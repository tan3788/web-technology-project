-- Simple E-commerce Database Schema
CREATE DATABASE IF NOT EXISTS simple_ecommerce;
USE simple_ecommerce;

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(100),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample products
INSERT INTO products (name, description, price, image, category, stock) VALUES
('Laptop', 'High-performance laptop for work and gaming', 899.99, 'images/laptop.jpg', 'Electronics', 10),
('Smartphone', 'Latest model smartphone with great camera', 599.99, 'images/smartphone.jpg', 'Electronics', 15),
('T-Shirt', 'Comfortable cotton t-shirt', 19.99, 'images/tshirt.jpg', 'Clothing', 50),
('Jeans', 'Classic blue jeans', 49.99, 'images/jeans.jpg', 'Clothing', 30),
('Coffee Mug', 'Ceramic coffee mug', 9.99, 'images/mug.jpg', 'Home', 100),
('Backpack', 'Durable travel backpack', 39.99, 'images/backpack.jpg', 'Accessories', 25),
('Headphones', 'Wireless bluetooth headphones', 79.99, 'images/headphones.jpg', 'Electronics', 20),
('Sneakers', 'Comfortable running sneakers', 89.99, 'images/sneakers.jpg', 'Footwear', 40);
