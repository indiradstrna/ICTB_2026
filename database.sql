-- Database schema for ICTB Conference Registration
-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS ictb_db;
USE ictb_db;

-- Table structure for `participants`
CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `participant_type` enum('author','participant','exhibitor') NOT NULL DEFAULT 'participant',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `bukti_diri` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
