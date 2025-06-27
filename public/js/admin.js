document.addEventListener('DOMContentLoaded', function() {
            const incomeElement = document.querySelector('.income-amount');
            if (incomeElement) {
                const finalValue = incomeElement.textContent;
                const numericValue = parseInt(finalValue.replace(/[^\d]/g, ''));
                
                if (numericValue > 0) {
                    let currentValue = 0;
                    const increment = numericValue / 50;
                    
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= numericValue) {
                            currentValue = numericValue;
                            clearInterval(timer);
                        }
                        
                        const formattedValue = 'Rp' + Math.floor(currentValue).toLocaleString('id-ID');
                        incomeElement.textContent = formattedValue;
                    }, 20);
                }
            }
        });

        document.querySelectorAll('.order-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });