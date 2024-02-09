-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2023 at 02:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `bid_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL,
  `proposal` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `files` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`bid_id`, `job_id`, `freelancer_id`, `bid_amount`, `proposal`, `created_at`, `status`, `files`) VALUES
(1, 2, 4, '104.00', 'asdas', '2023-11-20 06:48:53', 'pending', '655b63c5dbe171.05577429.pdf'),
(2, 3, 4, '0.03', 'asdasd', '2023-11-21 05:21:00', 'pending', '655ca0acd29f12.84269029.pdf'),
(3, 3, 4, '100.00', 'test', '2023-11-21 08:12:30', 'pending', '655cc8de40ddf1.85408745.pdf'),
(4, 1, 4, '1000.00', 'wala to', '2023-11-23 21:07:55', 'pending', '6560219bad38c1.24218903.pdf'),
(5, 4, 4, '19999.00', 'sdadfghqwfeqwg', '2023-11-23 21:08:53', 'pending', '656021d54adcc0.78212194.pdf'),
(6, 5, 4, '10000.00', 'asdasdasdasd', '2023-11-23 23:18:31', 'pending', '65604037cc5bf1.18628769.pdf'),
(7, 6, 4, '50000.00', 'sana ako nalang', '2023-11-24 06:24:40', 'pending', '6560a418e9d5e9.37211193.pdf'),
(8, 1, 4, '90000.00', 'test world', '2023-11-24 06:27:28', 'pending', '6560a4c020d8f2.81599157.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `user_id`, `company_name`, `website_url`, `industry`, `img`) VALUES
(1, 9, 'WebArt Zone', NULL, NULL, NULL),
(2, 10, 'ewqwe', 'gumana ka na please', 'miggy', '\\project-root\\images\\clientcats.jpg'),
(4, 11, '123234', NULL, NULL, NULL),
(5, 12, 'rgqwhjevbqw', NULL, NULL, NULL),
(7, 21, 'wads', 'asdasd', 'asdasd', '../project-root/images/omics.jpg'),
(9, 22, 'client2', 'client', 'client2', '../project-root/images/omics.jpg'),
(10, 24, 'jeff enterprise', 'jeffwebsite.com', 'manufacturing', '../project-root/images/profileScreenshot (42).png');

-- --------------------------------------------------------

--
-- Table structure for table `freelancers`
--

CREATE TABLE `freelancers` (
  `freelancer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `skills` varchar(255) NOT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `freelancers`
--

INSERT INTO `freelancers` (`freelancer_id`, `user_id`, `full_name`, `bio`, `skills`, `portfolio_url`, `img`) VALUES
(1, 3, 'raj', NULL, 'wala', NULL, NULL),
(2, 8, 'jhon', NULL, 'overthnk', NULL, NULL),
(3, 13, 'rarasrasesae', NULL, 'ewqeqwewqeqweqwe', NULL, NULL),
(4, 18, 'mico', 'rajesh', 'sana ako nalang', 'radas', '\\project-root\\images\\profilecats.jpg'),
(5, 19, 'rajesh', NULL, 'respall', NULL, '../project-root/imagesomics.jpg'),
(6, 23, 'pauline catarata', NULL, 'dasdghdjhasdgasjdgasdghjasdhjgasdhgasjhdashddhjasdashdh', NULL, '../project-root/images/profileAPPLICATION LETTER.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descriptions` text NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `status` enum('pending','active','completed','cancelled') NOT NULL DEFAULT 'pending',
  `files` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `client_id`, `title`, `descriptions`, `budget`, `status`, `files`, `created_at`) VALUES
(1, 1, 'Web Development', 'Build a responsive website for our business.', '5000.00', 'pending', NULL, '2023-11-11 08:53:14'),
(2, 1, 'Graphic Design', 'Design a new logo for our company.', '1000.00', 'pending', NULL, '2023-11-11 08:53:14'),
(3, 1, 'Digital Marketing', 'Create and manage online marketing campaigns.', '3000.00', 'pending', NULL, '2023-11-11 08:53:14'),
(4, 2, 'Mobile App Development1', 'Develop a mobile app for iOS and Android.', '8000.00', 'completed', NULL, '2023-11-11 08:53:14'),
(5, 2, 'Content Writing', 'Write engaging content for our blog.', '500.00', 'completed', NULL, '2023-11-11 08:53:14'),
(6, 2, 'SEO Optimization', 'Optimize our website for search engines.', '1500.00', 'completed', NULL, '2023-11-11 08:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descriptions` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `delivery_time` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `files` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `freelancer_id`, `title`, `descriptions`, `price`, `delivery_time`, `created_at`, `files`) VALUES
(1, 1, 'Web Development', 'Expert in building modern and responsive websites.', '500.00', 14, '2023-11-11 08:55:28', NULL),
(2, 1, 'WordPress Development', 'Customize and develop WordPress websites.', '400.00', 10, '2023-11-11 08:55:28', NULL),
(3, 1, 'Jaz Website', 'jezz', '5000.00', 1, '2023-11-11 08:55:28', NULL),
(4, 2, 'Mobile App Development', 'Specialized in developing mobile applications for various platforms.', '700.00', 28, '2023-11-11 08:55:28', NULL),
(5, 2, 'UI/UX Design', 'Design intuitive and user-friendly interfaces.', '450.00', 14, '2023-11-11 08:55:28', NULL),
(6, 2, 'Social Media Marketing', 'Promote businesses on social media platforms.', '300.00', 21, '2023-11-11 08:55:28', NULL),
(19, 4, 'jadasd', 'asdasd', '300.00', 4, '2023-11-25 04:41:01', NULL),
(20, 4, 'josh', 'lovejane', '300.00', 4, '2023-11-25 05:02:42', NULL),
(21, 4, 'josh', 'lovejane', '300.00', 4, '2023-11-25 05:03:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `bid_id`, `amount`, `transaction_date`) VALUES
(1, 5, '400042.00', '2023-11-23 23:44:51'),
(2, 6, '10100.00', '2023-11-23 23:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('client','freelancer','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `pass`, `email`, `user_type`) VALUES
(1, 'test1', 'test', 'test@gmail.com', 'freelancer'),
(2, 'lester', 'lester', 'lester@gmail.com', 'freelancer'),
(3, 'rajesh', '123', 'ewan ko', 'freelancer'),
(4, 'rajesh', 'lw6LYYhqj5Ox*09TVQRGb(CM', 'ewan ko', 'client'),
(5, 'rajesh', 'lw6LYYhqj5Ox*09TVQRGb(CM', 'ewan ko', 'freelancer'),
(6, 'rajesh', 'lw6LYYhqj5Ox*09TVQRGb(CM', 'asdasd', 'freelancer'),
(7, 'rajesh', 'lw6LYYhqj5Ox*09TVQRGb(CM', 'asdasd', 'client'),
(8, 'jhonludwig', 'gayaps123', 'jhonludwig@gmail.com', 'freelancer'),
(9, 'Jazlyn', 'Ybonne123', 'jaz@tup.edu.ph', 'client'),
(10, 'tester', '123', 'raj@tup.gmail.com', 'client'),
(11, 'trejihrw', 'weqwewqe', 'raj@tup.emailll.com', 'client'),
(12, 'eyqwueg', 'wqeqwe12', 'rarjasdgashg@tup', 'client'),
(13, 'jgherwqe', 'sadhasjdhas', 'rajeshehs@tup', 'freelancer'),
(14, 'MICO', 'admin', 'micoadmin@gmail.com', 'admin'),
(15, 'RAJESH', 'admin', 'rajeshadmin@gmail.com', 'admin'),
(16, 'LESTER', 'admin', 'lesteradmin@gmail.com', 'admin'),
(18, 'freelancer1', 'freelancer1', 'freelancer1', 'freelancer'),
(19, 'freelancer2', 'freelancer2', 'freelancer2', 'freelancer'),
(20, 'freelancer3', 'freelancer1', 'freelancer3@gmail.com', 'freelancer'),
(21, 'client1', 'client1', 'client1@gmail.com', 'client'),
(22, 'client2', 'clients2', 'client2@gmail.com', 'client'),
(23, 'pauline', '123', 'pauline@gmail.com', 'freelancer'),
(24, 'jepoy', '123', 'jepoy@gmail.com', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`bid_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `freelancers`
--
ALTER TABLE `freelancers`
  ADD PRIMARY KEY (`freelancer_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `bid_id` (`bid_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `freelancers`
--
ALTER TABLE `freelancers`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`),
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`freelancer_id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `freelancers`
--
ALTER TABLE `freelancers`
  ADD CONSTRAINT `freelancers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`freelancer_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`bid_id`) REFERENCES `bids` (`bid_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
