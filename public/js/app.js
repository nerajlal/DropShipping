// ===== TechDrop Premium JavaScript =====
document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initMobileMenu();
    initAddToCart();
    initScrollReveal();
});

// Navbar scroll effect
function initNavbar() {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const st = window.scrollY;
        if (st > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        lastScroll = st;
    }, { passive: true });
}

// Mobile menu
function initMobileMenu() {
    const toggle = document.getElementById('mobileToggle');
    const menu = document.getElementById('mobileMenu');
    if (!toggle || !menu) return;
    toggle.addEventListener('click', () => {
        menu.classList.toggle('open');
        toggle.classList.toggle('active');
    });
}

// AJAX Add to Cart
function initAddToCart() {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.add-to-cart-btn');
        if (!btn) return;
        e.preventDefault();
        const productId = btn.dataset.productId;
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!token) { window.location.href = '/dropship/public/login'; return; }

        btn.disabled = true;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch('/dropship/public/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Added to cart!', 'success');
                const badge = document.getElementById('cartBadge');
                if (badge && data.cart_count !== undefined) badge.textContent = data.cart_count;
                // Button success animation
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.style.background = '#059669';
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 1200);
            } else {
                showToast(data.message || 'Error adding to cart', 'error');
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        })
        .catch(() => {
            showToast('Error adding to cart', 'error');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        });
    });
}

// Scroll Reveal Animations
function initScrollReveal() {
    const elements = document.querySelectorAll('[data-animate]');
    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    elements.forEach(el => observer.observe(el));
}

// Toast notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Quantity selector
document.addEventListener('click', (e) => {
    if (e.target.closest('.qty-btn')) {
        const btn = e.target.closest('.qty-btn');
        const input = btn.parentElement.querySelector('.qty-input');
        if (!input) return;
        const action = btn.dataset.action;
        let val = parseInt(input.value) || 1;
        if (action === 'increase') val++;
        else if (action === 'decrease' && val > 1) val--;
        input.value = val;
    }
});
