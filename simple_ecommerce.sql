-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 24, 2026 at 11:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_email`, `payment_method`, `total_amount`, `order_status`, `created_at`) VALUES
(1, 43, 'Tanbir Alom', 'customer@example.com', 'bKash', 89.98, 'Rejected', '2026-05-23 21:38:40'),
(2, 45, 'Tanbir', 'customer@example.com', 'bKash', 29.97, 'Pending', '2026-05-24 09:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `stock`, `created_at`) VALUES
(1, 'Laptop', 'High-performance laptop for work and gaming', 899.99, 'images/laptop.jpg', 'Electronics', 10, '2026-05-14 20:16:44'),
(2, 'Smartphone', 'Latest model smartphone with great camera', 599.99, 'images/smartphone.jpg', 'Electronics', 15, '2026-05-14 20:16:44'),
(3, 'T-Shirt', 'Comfortable cotton t-shirt', 19.99, 'images/tshirt.jpg', 'Clothing', 50, '2026-05-14 20:16:44'),
(4, 'Jeans', 'Classic blue jeans', 49.99, 'images/jeans.jpg', 'Clothing', 30, '2026-05-14 20:16:44'),
(5, 'Coffee Mug', 'Ceramic coffee mug', 9.99, 'images/mug.jpg', 'Kitchen', 100, '2026-05-14 20:16:44'),
(6, 'Backpack', 'Durable travel backpack', 39.99, 'images/backpack.jpg', 'Accessories', 25, '2026-05-14 20:16:44'),
(7, 'Headphones', 'Wireless bluetooth headphones', 79.99, 'images/headphones.jpg', 'Electronics', 20, '2026-05-14 20:16:44'),
(8, 'Sneakers', 'Comfortable running sneakers', 89.99, 'images/sneakers.jpg', 'Footwear', 40, '2026-05-14 20:16:44'),
(12, 'Water bottle', 'Stainless steel water bottle', 9.99, 'images/waterbottle.jpg', 'Kitchen', 30, '2026-05-24 09:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `is_verified`, `verification_token`) VALUES
(7, 'Md Tarek', 'ta@gmail.com', '$2y$10$gkQnEVdE5MS/QiR20cz3V.fsVhwk1g5ydzTQ39mhXQNHcZye5YE0q', '2026-05-20 14:59:19', 0, NULL),
(14, 'Rejwan', 'rejwan@gmail.com', '$2y$10$3KOZ7y2A6fQXA49qluAWMu1jE5x.0ZjmkHI0urU58EZYCTmf5IxBO', '2026-05-20 15:17:28', 0, NULL),
(18, 'tarek', 'tarek', '$2y$10$x2nMUDza84by1V2ON4HsVuZDIyJ6oV1mINEWuENjMpGtU7ntDn69m', '2026-05-20 19:43:51', 0, NULL),
(35, 'Tarek', 'tarek13817@gmail.com', '$2y$10$/0gZLUp5ubhpxwRXqm0W1eHFRz6U.dkq.Ny93t4Qdcw45X92.wMFW', '2026-05-23 17:18:07', 1, NULL),
(37, 'Rejwan', 'larade693@gmail.com', '$2y$10$gLg/9AaVk5/EAXPmfg5yleaDba/HOSErZqfUl5fgzmlrb.VY9LGlm', '2026-05-23 17:22:40', 0, 'fa131ddd86db1e4145ce76eab4833e30'),
(45, 'Tanbir', 'ta992416@gmail.com', '$2y$10$1U9VzUqcZgH0CZ4jg2EtIeJJWSBXzU99q4ovjOScGntpRc6hEtsQi', '2026-05-24 09:05:40', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
