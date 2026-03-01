// ===== TechDrop Main JavaScript =====
document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initMobileMenu();
    initAddToCart();
    initAnimations();
});

// Navbar scroll effect
function initNavbar() {
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    });
}

// Mobile menu toggle
function initMobileMenu() {
    const toggle = document.getElementById('mobileToggle');
    const menu = document.getElementById('mobileMenu');
    if (toggle && menu) {
        toggle.addEventListener('click', () => menu.classList.toggle('open'));
        document.addEventListener('click', (e) => {
            if (!menu.contains(e.target) && !toggle.contains(e.target)) menu.classList.remove('open');
        });
    }
}

// AJAX Add to Cart
function initAddToCart() {
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.dataset.productId;
            const qty = document.getElementById('qtyInput')?.value || 1;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

            try {
                const resp = await fetch('/dropship/public/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ product_id: productId, quantity: parseInt(qty) })
                });
                const data = await resp.json();
                if (data.success) {
                    showToast(data.message, 'success');
                    const badge = document.getElementById('cartBadge');
                    if (badge) badge.textContent = data.cart_count;
                }
            } catch (err) {
                showToast('Failed to add to cart', 'error');
            }

            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-shopping-bag"></i> Add to Cart';
        });
    });
}

// Quantity controls
function updateQty(action) {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value);
    if (action === 'increase' && val < 10) input.value = val + 1;
    if (action === 'decrease' && val > 1) input.value = val - 1;
}

// Cart quantity update
async function updateCartItem(id, quantity) {
    try {
        const resp = await fetch(`/dropship/public/cart/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ quantity })
        });
        const data = await resp.json();
        if (data.success) {
            document.getElementById(`item-total-${id}`).textContent = '₹' + data.item_total;
            document.getElementById('cart-subtotal').textContent = '₹' + data.subtotal;
            document.getElementById('cart-shipping').textContent = data.shipping == 0 ? 'FREE' : '₹' + data.shipping;
            document.getElementById('cart-total').textContent = '₹' + data.total;
            document.getElementById('cartBadge').textContent = data.cart_count;
        }
    } catch (err) { showToast('Update failed', 'error'); }
}

// Remove cart item
async function removeCartItem(id) {
    try {
        const resp = await fetch(`/dropship/public/cart/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });
        const data = await resp.json();
        if (data.success) {
            document.getElementById(`cart-item-${id}`).remove();
            document.getElementById('cartBadge').textContent = data.cart_count;
            showToast(data.message, 'success');
            if (data.cart_count == 0) location.reload();
        }
    } catch (err) { showToast('Remove failed', 'error'); }
}

// Toast notifications
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
}

// Intersection Observer animations
function initAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.product-card, .category-card, .feature-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.5s ease';
        observer.observe(el);
    });
}

// Payment option selection
document.addEventListener('click', (e) => {
    if (e.target.closest('.payment-option')) {
        document.querySelectorAll('.payment-option').forEach(p => p.classList.remove('selected'));
        e.target.closest('.payment-option').classList.add('selected');
    }
});
