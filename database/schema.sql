CREATE DATABASE IF NOT EXISTS mini_bookstore_lab05
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE mini_bookstore_lab05;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_email (email),
    INDEX idx_users_status_created_at (status, created_at)
);

CREATE TABLE IF NOT EXISTS bookstore_prospects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    interested_genre VARCHAR(80) NOT NULL DEFAULT 'General',
    status ENUM('new', 'contacted', 'qualified', 'lost') NOT NULL DEFAULT 'new',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    UNIQUE KEY unique_prospect_email (email),
    INDEX idx_prospects_created_at (created_at),
    INDEX idx_prospects_status_created_at (status, created_at),
    INDEX idx_prospects_phone (phone),
    INDEX idx_prospects_genre (interested_genre)
);

CREATE TABLE IF NOT EXISTS book_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL,
    customer_name VARCHAR(120) NOT NULL,
    customer_email VARCHAR(150),
    book_title VARCHAR(180) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('pending', 'confirmed', 'packed', 'shipped', 'cancelled') NOT NULL DEFAULT 'pending',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    UNIQUE KEY unique_book_order_code (order_code),
    INDEX idx_orders_created_at (created_at),
    INDEX idx_orders_status_created_at (status, created_at),
    INDEX idx_orders_customer_email (customer_email),
    INDEX idx_orders_book_title (book_title)
);
