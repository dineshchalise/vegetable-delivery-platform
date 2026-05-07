# API Documentation

## Public Catalog

`GET /api/products?category=leafy-greens`

Returns published products, optionally filtered by category slug.

`GET /api/categories`

Returns active categories ordered by display order.

`GET /api/hubs`

Returns active pickup hubs.

## Checkout

`POST /api/orders`

```json
{
  "name": "Sita Sharma",
  "mobile": "9812345678",
  "address": "Koteshwor",
  "hub_id": 1,
  "items": [
    { "product_id": 1, "quantity": 2 }
  ]
}
```

Creates or updates the customer, creates the order and order items in a transaction, reduces stock, and logs an SMS.

## OTP Authentication

`POST /api/auth/send-otp`

```json
{ "mobile": "9812345678" }
```

`POST /api/auth/verify-otp`

```json
{ "mobile": "9812345678", "otp": "123456" }
```

Returns a Sanctum bearer token.

## Customer Authenticated

Use `Authorization: Bearer <token>`.

- `GET /api/auth/user`
- `POST /api/auth/logout`
- `GET /api/orders`
- `GET /api/orders/{id}`
- `GET /api/profile`
- `PUT /api/profile`

## Admin and Staff

Use a staff/admin Sanctum token.

- `GET /api/admin/dashboard/stats`
- `api/admin/products`
- `POST /api/admin/products/bulk-price`
- `POST /api/admin/products/bulk-publish`
- `api/admin/categories`
- `POST /api/admin/categories/reorder`
- `api/admin/hubs`
- `GET /api/admin/orders`
- `PATCH /api/admin/orders/{order}/status`
- `GET /api/admin/customers`
- `PATCH /api/admin/customers/{customer}/block`
