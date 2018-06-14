/*
* SQL for all the initial setup
 */

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


-- Create database for the webpage
CREATE DATABASE IF NOT EXISTS website CHARACTER SET utf8 COLLATE utf8_general_ci;


-- Create the user for the website and grant permissions
GRANT USAGE ON *.* TO 'website_connect'@'%' IDENTIFIED BY PASSWORD '*F0F191CDC10A5A68C9621C3BB75CE8528E58703C';
GRANT SELECT, INSERT, UPDATE, DELETE ON `website`.* TO 'website_connect'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER ON `world\_opg`.* TO 'website_connect'@'%';


-- --------------------------------------------------------

USE website;

--
-- Struktur-dump for tabellen `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(30) DEFAULT NULL,
  `pw_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);


--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


--
-- Struktur-dump for tabellen `login_attempts`
--
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indeks for tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


--
-- Tilføj AUTO_INCREMENT i tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Begrænsninger for tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


-- --------------------------------------------------------


-- Fill website.users with default test data (password is 'datait2018!')
INSERT INTO `users` (`id`, `username`, `email`, `full_name`, `short_name`, `pw_hash`) VALUES
(1, 'dbr', 'dbr@example.com', 'Navn Navensen', 'Navn', '$2y$10$ii.j3xliJAtHwzN0x0j4OeH3BjBrV4xyDfJMN8u1qr9uU7G61WEwO');
COMMIT;