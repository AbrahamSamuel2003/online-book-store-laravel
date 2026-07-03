# Online Book Store

A Laravel-based Online Book Store application where customers can browse books, search books, add multiple books to a cart, place an order, and where an admin can manage books and customer orders.

## Features

### Customer Features

- View featured books on the home page
- Search books by title or author
- View book details
- Add books to cart with quantity
- Update or remove cart items
- Enter customer details during checkout
- Review order before placing it
- Place one order containing multiple books
- View order success confirmation
- Google Books API recommendations with Load More functionality

### Admin Features

- Admin login
- Dashboard with:
  - Total books
  - Available books
  - Out-of-stock books
  - Total orders
  - Recent customer orders
- Add new books
- Edit book details, price, and stock
- Delete books
- View all customer orders
- View customer information and ordered books
- Update order status:
  - Pending
  - Confirmed
  - Delivered

## Technologies Used

- Laravel 12
- PHP 8.2
- MySQL
- Laravel Blade Templates
- Bootstrap 5
- Google Books REST API
- JavaScript Fetch API
- Git and GitHub

## Database Tables

- users
- categories
- books
- orders
- order_items

## Database Relationships

- One Category has many Books
- One Order has many Order Items
- One Book has many Order Items
- Each Order Item belongs to one Book

## Installation Steps

### 1. Clone the repository

```bash
git clone https://github.com/AbrahamSamuel2003/online-book-store-laravel.git
```

### 2. Move into the project folder

```bash
cd online-book-store-laravel
```

### 3. Install dependencies

```bash
composer install
```

### 4. Create environment file

```bash
copy .env.example .env
```

### 5. Configure database

Create a MySQL database named:

```text
online_book_store
```

Update the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_book_store
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Add Google Books API key

Add this in `.env`:

```env
GOOGLE_BOOKS_API_KEY=your_google_books_api_key
```

### 7. Generate application key

```bash
php artisan key:generate
```

### 8. Run migrations and seed sample data

```bash
php artisan migrate
php artisan db:seed --class=BookStoreSeeder
```

### 9. Create admin user

```bash
php artisan tinker
```

Then run:

```php
App\Models\User::create([
    'name' => 'Sample Admin',
    'email' => 'sample@gmail.com',
    'password' => bcrypt('sample123456'),
]);
```

Exit Tinker:

```bash
exit
```

### 10. Start the application

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Admin Login

```text
Email: sample@gmail.com
Password: sample123456
```

## Main Pages

```text
/                     Home page
/books                Public book listing page
/cart                 Customer cart
/admin/login          Admin login page
/admin/dashboard      Admin dashboard
/admin/books          Manage books
/admin/orders         Customer orders
```

## Google Books API Integration

The project integrates the Google Books REST API using Laravel HTTP Client.

It fetches book recommendations based on a search query and displays them on the home page. The Load More button fetches additional recommendations without reloading the page.

## Order Flow

Customer selects books
-> Adds books to cart
-> Enters customer details
-> Proceeds to checkout
-> Confirms order
-> Order saved in database
-> Stock reduces automatically
-> Admin can view the order in the Orders page

## Important Environment Note

`.env.example` includes this placeholder:

```env
GOOGLE_BOOKS_API_KEY=
```

Do not paste your real API key in `.env.example`.

Your real key should stay only inside:

```text
.env
```

The `.env` file should not be pushed to GitHub.