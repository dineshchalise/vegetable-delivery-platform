# Vegetable Delivery E-Commerce Platform

Laravel 11 + Livewire 3 source scaffold for a vegetable delivery platform with OTP login, guest checkout, hub pickup/delivery workflow, admin management, bulk price updates, SMS logging, and API endpoints.

## Stack

- Laravel 11, PHP 8.2+
- MySQL 8.0
- Laravel Sanctum
- Livewire 3, Alpine.js, Tailwind CSS
- Redis cache/queue recommended

## Local Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run dev
php artisan serve
php artisan queue:work
```

## Demo Credentials

- Admin: `admin@veg.test` / `password123`
- Staff: `staff@veg.test` / `password123`
- Customer OTP demo: use any 10 digit mobile. With `SMS_DRIVER=log`, OTPs are stored in `sms_logs`.

## API Summary

Public:

- `GET /api/products`
- `GET /api/categories`
- `GET /api/hubs`
- `POST /api/orders`
- `POST /api/auth/send-otp`
- `POST /api/auth/verify-otp`

Authenticated customer:

- `GET /api/auth/user`
- `POST /api/auth/logout`
- `GET /api/orders`
- `GET /api/orders/{order}`
- `GET /api/profile`
- `PUT /api/profile`

Admin/staff:

- `api/admin/products`, `api/admin/categories`, `api/admin/hubs`, `api/admin/orders`, `api/admin/customers`, `api/admin/dashboard/stats`

## Deployment Notes

Use Ubuntu 22.04/24.04, PHP 8.2 FPM, Nginx, MySQL 8.0, Redis, Supervisor queue worker, and a cron entry for `php artisan schedule:run` every minute. Configure SSL with LetEncrypt.
