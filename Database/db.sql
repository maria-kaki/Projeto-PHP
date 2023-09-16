-- Create Schema
CREATE DATABASE paymentsystem;
USE paymentsystem;

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Be sure to securely store passwords using cryptographic hashes
    email VARCHAR(100) UNIQUE NOT NULL,
    balance DECIMAL(10, 2) DEFAULT 0.00  -- User's wallet balance
);

-- Transactions Table
CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description VARCHAR(255),  -- Transaction description
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Payment Records Table
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    payment_status ENUM('Pending Payment', 'Paid', 'Payment Failed') NOT NULL,
    paypal_payment_id VARCHAR(100) UNIQUE NOT NULL,  -- PayPal payment ID
    paypal_token VARCHAR(100) NOT NULL,  -- PayPal payment token
    paypal_payer_id VARCHAR(100) NOT NULL,  -- PayPal payer ID
    payment_date TIMESTAMP,  -- Payment date/time
    FOREIGN KEY (transaction_id) REFERENCES transactions(transaction_id)
);

CREATE TABLE verification(
    verificationid INT AUTO_INCREMENT PRIMARY KEY,
    verificationcode INT NOT NULL,
)