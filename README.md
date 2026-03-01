# TechDrop - Premium Tech Gadgets Dropshipping Store

A fully automated tech gadgets dropshipping store built with **Laravel 12** and **MySQL**, featuring a premium light-themed storefront and Shopify-style admin panel.

## Features

### Customer Storefront
- Premium light theme with vibrant gradient hero
- Product catalog with category filtering, sorting, and pagination
- Product detail pages with specs and related products
- AJAX shopping cart (no page reloads)
- Checkout with COD, UPI, and Card payment options
- User accounts with order tracking
- Guest cart that merges on login

### Admin Panel (Shopify-Style)
- Dashboard with revenue, orders, and product stats
- Full product CRUD with search and filtering
- Order management with status updates and tracking
- Clean, light-themed UI matching Shopify's Polaris design

### Supplier Integration
- CJ Dropshipping ready (supplier SKU, URL, price tracking)
- Automated shipping time tracking per product

## Tech Stack
- **Backend:** Laravel 12, PHP 8.3
- **Database:** MySQL
- **Frontend:** Blade Templates, Vanilla CSS, JavaScript
- **Fonts:** Inter, Space Grotesk (Google Fonts)
- **Icons:** Font Awesome 6.5

## Setup

```bash
# Clone the repo
git clone https://github.com/nerajlal/DropShipping.git
cd DropShipping

# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database (update .env with your DB credentials)
php artisan migrate --seed

# Run the server
php artisan serve
```

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@techdrop.com | password |
| Customer | john@example.com | password |

## License
MIT
