// cart.js
let cart = [];

const cartCount = document.getElementById("cartCount");
const cartIcon = document.getElementById("cartIcon");

cartIcon.addEventListener("click", () => {
    const offcanvas = new bootstrap.Offcanvas(
        document.getElementById("cartOffcanvas"),
        {
            backdrop: false,
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
        row.className =
            "d-flex justify-content-between align-items-center mb-2";
        row.innerHTML = `
            <div>
                <strong>${item.name}</strong><br>
                <small>${item.qty} x Rp${item.price.toLocaleString(
            "id-ID"
        )}</small>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQty(${index}, -1)">-</button>
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQty(${index}, 1)">+</button>
                <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">&times;</button>
            </div>
        `;
        cartItems.appendChild(row);
    });

    cartTotal.textContent = "Rp" + total.toLocaleString("id-ID");
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

// Fungsi untuk mengirim data keranjang saat checkout
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

// Buat cartIcon selalu mengambang saat scroll
window.addEventListener("scroll", () => {
    const cartIcon = document.getElementById("cartIcon");
    if (!cartIcon) return;

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
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const form = document.getElementById("checkoutForm");
    const nama = form.nama.value;
    const meja = form.no_meja.value;

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
    });

    fetch("/order", {
        method: "POST",
        headers: {
            Accept: "application/json",
        },
        body: formData,
    })
        .then((res) => {
            if (!res.ok) {
                throw new Error("Gagal mengirim data.");
            }
            return res.json();
        })
        .then((response) => {
            if (response.snap_token) {
                snap.pay(response.snap_token, {
                    onSuccess: function (result) {
                        alert("Pembayaran berhasil!");
                        window.location.href = "/orders";
                    },
                    onPending: function (result) {
                        alert("Menunggu pembayaran.");
                        window.location.href = "/orders";
                    },
                    onError: function (result) {
                        alert("Terjadi kesalahan saat pembayaran.");
                    },
                    onClose: function () {
                        alert("Pembayaran dibatalkan.");
                    },
                });
            } else {
                alert("Gagal membuat pesanan. " + (response.message || ""));
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat memproses pesanan.");
        });
}
