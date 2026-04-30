# 🛒 Laravel 11 E-Commerce System

A modern **E-Commerce Web Application** built with Laravel 11.
This project provides a complete online shopping experience including product management, cart system, authentication, and admin controls.

---

## 📌 Overview

This application simulates a real-world e-commerce platform where users can browse products, add items to cart, and place orders, while admins can manage products and system data.

---

## 🚀 Features

### 👤 User Side

* User Registration & Login
* Browse Products
* Add to Cart
* Checkout System
* Order Placement

### 🧑‍💼 Admin Panel

* Product Management (CRUD)
* Category Management
* Order Management
* User Management

### ⚙️ Core Functionalities

* Authentication & Authorization
* Shopping Cart System
* Database Integration
* Responsive UI (if implemented)

---

## 🛠️ Tech Stack

* **Framework:** Laravel 11 (PHP)
* **Frontend:** Blade / HTML / CSS / JavaScript
* **Styling:** Tailwind CSS (based on config files)
* **Database:** MySQL
* **Build Tool:** Vite

---

## 📂 Project Structure

app/ → Business logic
routes/ → Web routes
resources/ → Views (Blade templates)
database/ → Migrations & SQL dump
public/ → Assets
storage/ → Logs & cache

---

## ⚙️ Installation Guide

### 1. Clone Repository

git clone https://github.com/omaisjaveed/laravel11-ecommerce.git
cd laravel11-ecommerce

---

### 2. Install Dependencies

composer install
npm install

---

### 3. Setup Environment

cp .env.example .env

Update `.env` file:

* DB_DATABASE
* DB_USERNAME
* DB_PASSWORD

---

### 4. Generate App Key

php artisan key:generate

---

### 5. Setup Database

Option 1: Run migrations
php artisan migrate

Option 2: Import SQL file
Import `male_fashion.sql` into your database

---

### 6. Run Project

php artisan serve

Open:
http://127.0.0.1:8000

---

## 🔐 Default Login (if available)

Check file:
`login_details.txt`

---

## 📸 Screenshots (Add here)

* Home Page
* Product Page
* Cart Page
* Admin Dashboard

---

## 📌 Future Improvements

* Online Payment Integration (Stripe / PayPal)
* Product Reviews & Ratings
* Wishlist Feature
* Order Tracking System
* REST API for mobile apps

---

## 🤝 Contributing

Contributions are welcome!
Fork the repository and submit a pull request.

---

## 📜 License

This project is open-source under the MIT License.

---

## 👨‍💻 Author

Developed by **Omais Javeed**
