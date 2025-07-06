// cart.js
let cart = [];

const cartCount = document.getElementById("cartCount");
const cartIcon = document.getElementById("cartIcon");

cartIcon.addEventListener("click", () => {
    const offcanvas = new bootstrap.Offcanvas(
        document.getElementById("cartOffcanvas"),
        {
            backdrop: false,
            scroll: true, // Izinkan scroll
        }
    );
    updateCartDisplay();
    offcanvas.show();
});

document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", () => {
        const id = button.getAttribute("data-id");
        const name = button.getAttribute("data-name");
        const price = parseFloat(button.getAttribute("data-price"));
        const image = button.getAttribute("data-image");

        const existing = cart.find((item) => item.name === name);
        if (existing) {
            existing.qty++;
        } else {
            cart.push({ name, price, qty: 1, image });
        }
        updateCartDisplay();
    });
});

function updateCartDisplay() {
    cartCount.textContent = cart.reduce((sum, item) => sum + item.qty, 0);
    const cartItems = document.getElementById("cartItems");
    const cartTotal = document.getElementById("cartTotal");

    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-muted">Keranjang kosong</p>';
        cartTotal.textContent = "Rp0";
        return;
    }

    cartItems.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        const subtotal = item.qty * item.price;
        total += subtotal;

        const row = document.createElement("div");
        row.className = "cart-item d-flex justify-content-between align-items-center mb-2";
        row.innerHTML = `
            <div class="flex-grow-1">
                <strong>${item.name}</strong><br>
                <small class="text-muted">${item.qty} x Rp${item.price.toLocaleString("id-ID")}</small>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQty(${index}, -1)">-</button>
                <span class="mx-2">${item.qty}</span>
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQty(${index}, 1)">+</button>
                <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeItem(${index})">&times;</button>
            </div>
        `;
        cartItems.appendChild(row);
    });

    cartTotal.textContent = "Rp" + total.toLocaleString("id-ID");
    
    // Pastikan scroll position di reset jika perlu
    cartItems.scrollTop = 0;
}

function changeQty(index, delta) {
    cart[index].qty += delta;
    if (cart[index].qty <= 0) {
        cart.splice(index, 1);
    }
    updateCartDisplay();
}

function removeItem(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function submitCart(formId) {
    const form = document.getElementById(formId);
    const container = document.getElementById("cartHiddenInputs");
    container.innerHTML = "";

    cart.forEach((item) => {
        container.innerHTML += `
            <input type="hidden" name="menu_names[]" value="${item.name}">
            <input type="hidden" name="quantities[]" value="${item.qty}">
            <input type="hidden" name="prices[]" value="${item.price}">
        `;
    });

    form.submit();
}

// Perbaiki scroll handling
window.addEventListener("scroll", () => {
    const cartIcon = document.getElementById("cartIcon");
    if (!cartIcon) return;

    // Jangan interfere dengan scroll jika offcanvas terbuka
    const offcanvasElement = document.getElementById("cartOffcanvas");
    if (offcanvasElement && offcanvasElement.classList.contains("show")) {
        return;
    }

    if (window.scrollY > 100) {
        cartIcon.classList.add("fixed-cart");
    } else {
        cartIcon.classList.remove("fixed-cart");
    }
});

window.addEventListener("DOMContentLoaded", () => {
    const cartIcon = document.getElementById("cartIcon");
    if (cartIcon) {
        cartIcon.classList.add("fixed-cart");
    }
});

function processPayment() {
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) {
        alert("CSRF token tidak ditemukan. Silakan refresh halaman.");
        return;
    }

    const csrfToken = csrfMeta.getAttribute("content");
    const form = document.getElementById("checkoutForm");
    const nama = form.nama.value.trim();
    const meja = form.no_meja.value.trim();

    if (!nama || !meja || cart.length === 0) {
        alert("Isi semua data dan pastikan keranjang tidak kosong.");
        return;
    }

    const formData = new FormData();
    formData.append("nama", nama);
    formData.append("no_meja", meja);
    formData.append("_token", csrfToken);

    cart.forEach((item) => {
        formData.append("menu_names[]", item.name);
        formData.append("quantities[]", item.qty);
        formData.append("prices[]", item.price);
    });

    const payButton = document.querySelector(
        'button[onclick="processPayment()"]'
    );
    const originalText = payButton.innerHTML;
    payButton.disabled = true;
    payButton.innerHTML =
        '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';

    fetch("/order", {
        method: "POST",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
    })
        .then((res) => {
            console.log("Response status:", res.status);
            console.log("Response headers:", res.headers);

            if (!res.ok) {
                return res.text().then((text) => {
                    console.error("Error response:", text);
                    throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                });
            }
            return res.json();
        })
        .then((response) => {
            console.log("Success response:", response);

            if (response.snap_token) {
                if (typeof snap === "undefined") {
                    throw new Error(
                        "Midtrans Snap tidak tersedia. Periksa konfigurasi Midtrans."
                    );
                }

                snap.pay(response.snap_token, {
                    onSuccess: function (result) {
                        console.log("Payment success:", result);
                        alert("Pembayaran berhasil!");
                        cart = [];
                        updateCartDisplay();
                        window.location.href = "/orders";
                    },
                    onPending: function (result) {
                        console.log("Payment pending:", result);
                        alert("Menunggu pembayaran.");
                        window.location.href = "/orders";
                    },
                    onError: function (result) {
                        console.error("Payment error:", result);
                        alert(
                            "Terjadi kesalahan saat pembayaran: " +
                                (result.status_message || "Unknown error")
                        );
                    },
                    onClose: function () {
                        console.log("Payment closed");
                        alert("Pembayaran dibatalkan.");
                    },
                });
            } else {
                throw new Error(
                    "Gagal membuat pesanan: " +
                        (response.message || "Tidak ada snap_token")
                );
            }
        })
        .catch((error) => {
            console.error("Detailed error:", error);
            console.error("Error type:", error.constructor.name);
            console.error("Error message:", error.message);

            let errorMessage = "Terjadi kesalahan saat memproses pesanan.";
            if (error.message.includes("HTTP 422")) {
                errorMessage =
                    "Data yang dikirim tidak valid. Periksa kembali form Anda.";
            } else if (error.message.includes("HTTP 500")) {
                errorMessage =
                    "Terjadi kesalahan server. Silakan coba lagi nanti.";
            } else if (
                error.message.includes("NetworkError") ||
                error.message.includes("Failed to fetch")
            ) {
                errorMessage =
                    "Tidak dapat terhubung ke server. Periksa koneksi internet Anda.";
            }

            alert(errorMessage);
        })
        .finally(() => {
            payButton.disabled = false;
            payButton.innerHTML = originalText;
        });
}