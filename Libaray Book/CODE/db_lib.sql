-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 03:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `publish_year` year(4) NOT NULL,
  `language` varchar(50) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `copies` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `publish_year`, `language`, `category_id`, `created_at`, `updated_at`, `description`, `category_name`, `copies`) VALUES
(1, 'في قلبي أنثى عربية', 'خولة حمدي', 'دار كيان', '2012', 'العربية', 1, '2025-01-15 21:26:20', '2025-02-01 14:50:52', 'رواية أدبية', 'روايات', 6),
(2, 'نظرية الفوضى', 'إدوارد لورنز', 'دار العلوم', '1987', 'العربية', 2, '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتاب علمي يشرح تأثيرات الفوضى في الأنظمة الديناميكية', 'علوم', 3),
(3, 'البداية والنهاية', 'ابن كثير', 'دار المعرفة', '1939', 'العربية', 3, '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتاب تاريخي يتناول بداية الخلق ونهاية العالم', 'تاريخ', 2),
(4, 'قوة الآن', 'إيكهارت تول', 'دار التنوير', '1997', 'العربية', 4, '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتاب يساعدك على العيش في اللحظة الحالية', 'تنمية ذاتية', 7);

-- --------------------------------------------------------

--
-- Table structure for table `borrowedbooks`
--

CREATE TABLE `borrowedbooks` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrowed_id` int(11) NOT NULL,
  `by_employee` int(11) NOT NULL,
  `borrowed_date` date NOT NULL,
  `due_date` date NOT NULL,
  `returned_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowedbooks`
--

INSERT INTO `borrowedbooks` (`id`, `book_id`, `borrowed_id`, `by_employee`, `borrowed_date`, `due_date`, `returned_date`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, '2024-12-01', '2024-12-15', '2024-12-15', '2025-01-15 21:26:20', '2025-01-15 21:26:20'),
(2, 3, 3, 4, '2024-12-10', '2024-12-25', NULL, '2025-01-15 21:26:20', '2025-01-15 21:26:20'),
(3, 2, 5, 2, '2024-12-05', '2024-12-12', '2024-12-12', '2025-01-15 21:26:20', '2025-01-15 21:26:20'),
(4, 4, 5, 2, '2024-12-20', '2025-01-05', NULL, '2025-01-15 21:26:20', '2025-01-15 21:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `description`) VALUES
(1, 'روايات', '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتب أدبية تحتوي على قصص خيالية أو واقعية'),
(2, 'علوم', '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتب علمية تغطي موضوعات مختلفة'),
(3, 'تاريخ', '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتب تتناول موضوعات تاريخية'),
(4, 'تنمية ذاتية', '2025-01-15 21:26:20', '2025-01-15 21:26:20', 'كتب مخصصة لتحسين الذات وتطوير المهارات');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Members','Employee','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `HireDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `phone`, `address`, `password`, `role`, `created_at`, `updated_at`, `HireDate`) VALUES
(1, 'Admin', 'admin', '0910001212', 'شارع التحرير', 'admin', 'admin', '2025-01-15 21:26:20', '2025-01-15 22:16:54', '2023-01-01'),
(2, 'أحمد حسن', 'ahmed@example.com', '0910001212', 'شارع النصر', 'password1', 'Employee', '2025-01-15 21:26:20', '2025-01-15 21:26:20', '2024-02-01'),
(3, 'سارة محمود', 'sarah@example.com', '0910001212', 'شارع الوحدة', 'password2', 'Members', '2025-01-15 21:26:20', '2025-01-15 21:26:20', '2022-05-15'),
(4, 'ليلى إبراهيم', 'laila@example.com', '0910001212', 'شارع السلام', 'password3', 'Employee', '2025-01-15 21:26:20', '2025-01-15 21:26:20', '2023-07-10'),
(5, 'عمر يوسف', 'omar@example.com', '0910001212', 'شارع الجمهورية', 'password4', 'Members', '2025-01-15 21:26:20', '2025-01-15 21:26:20', '2023-11-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_category` (`category_id`);

--
-- Indexes for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_borrowedbooks_book` (`book_id`),
  ADD KEY `fk_borrowedbooks_borrower` (`borrowed_id`),
  ADD KEY `fk_borrowedbooks_employee` (`by_employee`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD CONSTRAINT `fk_borrowedbooks_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_borrowedbooks_borrower` FOREIGN KEY (`borrowed_id`) REFERENCES `users` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_borrowedbooks_employee` FOREIGN KEY (`by_employee`) REFERENCES `users` (`userid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
