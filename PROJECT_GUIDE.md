# 👗 FashionFlair - Modern E-Commerce Fashion Store

A modern, beautiful, and fully-functional e-commerce platform for selling fashion items, built with **Laravel 13**, **Tailwind CSS**, **Alpine.js**, and **Vite**.

## 🎨 Design Features

### Color Scheme (Perfect for Fashion)
- **Primary Rose**: `#d946a6` - Main brand color
- **Secondary Purple**: `#8b5cf6` - Accent color
- **Pink**: `#ec4899` - Highlights & CTAs
- **Dark**: `#1a1a2e` - Text & backgrounds
- **Light**: `#f9f5ff` - Subtle backgrounds

### Smooth Animations
- **Fade In animations** on page load
- **Hover effects** on products and buttons
- **Scale animations** for interactive elements
- **Smooth transitions** throughout the app
- **Minimal loading** with optimized images

## 🚀 Quick Start

### Prerequisites
- PHP 8.3+
- Composer
- Node.js 18+
- MySQL/SQLite

### Installation

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env
DB_DATABASE=fashion_flair
DB_USERNAME=root
DB_PASSWORD=

# 4. Run migrations
php artisan migrate:fresh

# 5. Start development server
npm run dev
php artisan serve
```

Visit `http://localhost:8000`

## 📁 Project Structure

### Frontend Routes
- `/` - Homepage with hero, featured products
- `/products` - Product listing with filters
- `/products/{slug}` - Product detail page
- `/cart` - Shopping cart
- `/checkout` - Checkout flow (auth required)
- `/dashboard` - User orders (auth required)

### Admin Routes (requires admin role)
- `/admin` - Admin dashboard
- `/admin/products` - Product management
- `/admin/categories` - Category management
- `/admin/orders` - Order management
- `/admin/users` - User management

## 🎯 Features Implemented

### ✅ Frontend
- [x] Modern, responsive homepage with hero section
- [x] Product listing with advanced filters:
  - Filter by category
  - Filter by gender (Women, Men, Kids)
  - Filter by price range
  - Search products
  - Sort by price, name, latest
- [x] Product detail page with:
  - Image gallery (main + thumbnails)
  - Product variants (size, color)
  - Discount display
  - Stock status
  - Related products
  - Add to cart with quantity selector
- [x] Shopping cart system:
  - Session-based cart
  - Update quantities
  - Remove items
  - Order summary
  - Cart count badge in navbar
- [x] Checkout flow:
  - Address selection/entry
  - Payment method selection
  - Order summary
  - Tax calculation

### ✅ Admin Panel
- [x] Dashboard with statistics:
  - Total sales
  - Total orders
  - Total products
  - Total users
  - Low stock alerts
  - Recent orders
- [x] Product management:
  - Create products with image upload
  - Edit product details
  - Delete products
  - Mark as featured/active
  - Add variants (sizes, colors)
  - Stock management
- [x] Category management
- [x] Order viewing & management
- [x] User management

### ✅ UI/UX
- [x] Beautiful gradient backgrounds (Rose → Purple)
- [x] Smooth fade-in animations on scroll
- [x] Hover effects on all interactive elements
- [x] Responsive design (mobile, tablet, desktop)
- [x] Loading states
- [x] Flash messages (success/error)
- [x] Badges for discounts, stock status

## 🎨 CSS Classes Reference

### Layout
```css
.container          /* Max width container */
.section            /* Vertical padding */
.section-title      /* Styled section heading */
.divider            /* Horizontal separator */
```

### Products
```css
.products-grid      /* Responsive product grid */
.product-card       /* Individual product card */
.product-image      /* Product image container */
.product-badge      /* Discount/Featured badge */
.product-info       /* Product details section */
.product-name       /* Product title */
.product-price      /* Price display */
.add-to-cart-btn    /* CTA button */
```

### Buttons
```css
.btn-primary        /* Main CTA button (Rose → Purple gradient) */
.btn-secondary      /* Secondary button (border style) */
.action-btn         /* Small action button */
.btn-edit           /* Edit button */
.btn-delete         /* Delete button */
```

### Forms
```css
.form-group         /* Form field wrapper */
.form-label         /* Form label */
.form-error         /* Error message */
.image-upload-area  /* Drag & drop image upload */
```

### Admin
```css
.admin-sidebar      /* Admin navigation sidebar */
.admin-content      /* Main admin content area */
.admin-table        /* Data table styling */
.admin-header       /* Admin page header */
```

### Animations
```css
.animate-fadeInUp       /* Fade in from bottom */
.animate-fadeInLeft     /* Fade in from left */
.animate-fadeInRight    /* Fade in from right */
.animate-scaleIn        /* Scale animation */
.gradient-text          /* Rose to Purple gradient text */
```

## 📊 Database Models

### Product
- `id`, `name`, `slug`, `description`
- `price`, `offer_percent` (for discounts)
- `category_id`, `brand`, `material`
- `gender` (women, men, kids, unisex)
- `image` (main product image)
- `gallery` (JSON array of additional images)
- `stock_qty`, `is_featured`, `is_active`

### Category
- `id`, `name`, `slug`
- `description`
- `is_active`

### ProductVariant
- `id`, `product_id`
- `name`, `size`, `color`
- `sku`, `stock_qty`

### Order
- `id`, `user_id`
- `total`, `status`
- `payment_method`, `shipping_address`

### User
- Standard auth fields
- `role` (user, admin)
- `phone`

## 🔐 Authentication & Authorization

### User Roles
- **user**: Regular customer (can browse, buy, view orders)
- **admin**: Full access to admin panel

### Middleware
- `auth`: User must be logged in
- `admin`: User must have admin role
- `guest`: User must NOT be logged in

## 🎬 How to Populate Data

### Option 1: Manual Entry
1. Go to `/admin` (login as admin first)
2. Click "Add New Product"
3. Fill in details and upload image
4. Add variants (sizes/colors)
5. Save

### Option 2: Seeding (Create Database Seeder)
```php
// database/seeders/ProductSeeder.php
public function run()
{
    Category::create(['name' => 'Dresses', 'slug' => 'dresses']);
    // ... create categories
    
    Product::create([
        'name' => 'Summer Dress',
        'slug' => 'summer-dress-xyz',
        'price' => 79.99,
        'category_id' => 1,
        'gender' => 'women',
        'stock_qty' => 50,
    ]);
}
```

Run: `php artisan db:seed --class=ProductSeeder`

## 📁 File Structure Key Files

```
fashion-flair/
├── app/
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── User.php
│   │   └── ...
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ShopController.php
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   └── Admin/
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│
├── resources/
│   ├── css/
│   │   └── app.css (✨ All styling & animations)
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php (main layout)
│       │   └── admin.blade.php (admin layout)
│       ├── components/
│       │   ├── navbar.blade.php
│       │   └── footer.blade.php
│       ├── home.blade.php (homepage)
│       ├── shop/
│       │   ├── index.blade.php (products list)
│       │   └── show.blade.php (product detail)
│       ├── cart/
│       │   └── index.blade.php
│       ├── checkout/
│       │   └── index.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── products/
│           └── categories/
│
├── routes/
│   └── web.php (public & admin routes)
│
├── tailwind.config.js
├── vite.config.js
└── composer.json
```

## 🎯 Customization

### Change Colors
Edit `resources/css/app.css` color variables:
```css
:root {
    --primary: #d946a6;      /* Change to your color */
    --secondary: #8b5cf6;    /* Change to your color */
    /* ... */
}
```

### Change Animations
Modify animation classes in `app.css` or add custom ones:
```css
@keyframes customAnimation {
    /* Your animation */
}
```

### Add New Products Page
1. Create view in `resources/views/shop/page.blade.php`
2. Add route in `routes/web.php`
3. Create controller method if needed

## 🚀 Performance Tips

### Images
- Use WebP format for faster loading
- Lazy load product images
- Optimize image size before upload
- Use `<img loading="lazy">` in views

### Caching
```php
// Cache products for 1 hour
$products = Cache::remember('products.featured', 3600, function () {
    return Product::where('is_featured', true)->get();
});
```

### Database
- Index frequently queried columns
- Use eager loading (with()) to prevent N+1 queries
- Paginate large result sets

## 🐛 Troubleshooting

### Products not showing
- Check if `is_active` is true
- Verify category exists
- Check image path in storage

### Admin page gives 403 error
- Verify user has `role = 'admin'`
- Check AdminMiddleware in `app/Http/Middleware/`

### Images not uploading
- Check `storage/app/public` folder exists
- Run: `php artisan storage:link`
- Verify permissions are 755

### Cart not working
- Ensure sessions are configured in `.env`
- Check `SESSION_DRIVER=file`
- Clear sessions: `php artisan cache:clear`

## 📱 Responsive Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

All layouts are fully responsive!

## 🎓 Learning Resources

- [Laravel 13 Docs](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [Blade Templates](https://laravel.com/docs/blade)

## 📞 Support

Need help? Check:
1. Browser console for JavaScript errors
2. Laravel logs: `storage/logs/laravel.log`
3. Database connection in `.env`
4. File permissions in `storage/` folder

## 📄 License

This project is open source and available under the MIT license.

---

**Ready to launch your fashion store?** 🚀
Start by logging in as admin and adding some fabulous products! ✨
