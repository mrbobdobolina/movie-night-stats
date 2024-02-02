-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 02, 2024 at 02:09 AM
-- Server version: 10.3.27-MariaDB-0+deb10u1
-- PHP Version: 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `dice`
--

CREATE TABLE `dice` (
	                    `id` int(11) UNSIGNED NOT NULL,
	                    `datetime` datetime NOT NULL,
	                    `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
	                     `id` int(11) NOT NULL,
	                     `name` text CHARACTER SET utf8 NOT NULL,
	                     `image` text DEFAULT NULL,
	                     `tomatometer` int(11) DEFAULT NULL,
	                     `rt_audience` int(11) DEFAULT NULL,
	                     `imdb` int(11) DEFAULT NULL,
	                     `metacritic` int(11) DEFAULT NULL,
	                     `meta_userscore` int(11) DEFAULT NULL,
	                     `year` int(11) DEFAULT NULL,
	                     `type` text DEFAULT NULL,
	                     `runtime` int(11) DEFAULT NULL,
	                     `MPAA` text DEFAULT NULL,
	                     `first_instance` date DEFAULT NULL,
	                     `last_instance` date DEFAULT NULL,
	                     `imdb_id` text DEFAULT NULL,
	                     `poster_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
	                       `id` int(11) UNSIGNED NOT NULL,
	                       `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
	                       `value` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
	                        `id` int(11) UNSIGNED NOT NULL,
	                        `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
	                        `rgba` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spinners`
--

CREATE TABLE `spinners` (
	                        `id` int(11) UNSIGNED NOT NULL,
	                        `name` text DEFAULT NULL,
	                        `wedge_1` text DEFAULT NULL,
	                        `wedge_2` text DEFAULT NULL,
	                        `wedge_3` text DEFAULT NULL,
	                        `wedge_4` text DEFAULT NULL,
	                        `wedge_5` text DEFAULT NULL,
	                        `wedge_6` text DEFAULT NULL,
	                        `wedge_7` text DEFAULT NULL,
	                        `wedge_8` text DEFAULT NULL,
	                        `wedge_9` text DEFAULT NULL,
	                        `wedge_10` text DEFAULT NULL,
	                        `wedge_11` text DEFAULT NULL,
	                        `wedge_12` text DEFAULT NULL,
	                        `uses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `viewers`
--

CREATE TABLE `viewers` (
	                       `id` int(11) NOT NULL,
	                       `name` text NOT NULL,
	                       `color` varchar(6) DEFAULT NULL,
	                       `attendance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE `week` (
	                    `id` int(11) NOT NULL,
	                    `date` date NOT NULL,
	                    `wheel_1` int(11) NOT NULL,
	                    `wheel_2` int(11) NOT NULL,
	                    `wheel_3` int(11) NOT NULL,
	                    `wheel_4` int(11) NOT NULL,
	                    `wheel_5` int(11) NOT NULL,
	                    `wheel_6` int(11) NOT NULL,
	                    `wheel_7` int(11) NOT NULL,
	                    `wheel_8` int(11) NOT NULL,
	                    `wheel_9` int(11) NOT NULL,
	                    `wheel_10` int(11) NOT NULL,
	                    `wheel_11` int(11) NOT NULL,
	                    `wheel_12` int(11) NOT NULL,
	                    `moviegoer_1` int(11) NOT NULL,
	                    `moviegoer_2` int(11) NOT NULL,
	                    `moviegoer_3` int(11) NOT NULL,
	                    `moviegoer_4` int(11) NOT NULL,
	                    `moviegoer_5` int(11) NOT NULL,
	                    `moviegoer_6` int(11) NOT NULL,
	                    `moviegoer_7` int(11) NOT NULL,
	                    `moviegoer_8` int(11) NOT NULL,
	                    `moviegoer_9` int(11) NOT NULL,
	                    `moviegoer_10` int(11) NOT NULL,
	                    `moviegoer_11` int(11) NOT NULL,
	                    `moviegoer_12` int(11) NOT NULL,
	                    `spinner` int(11) NOT NULL,
	                    `winning_wedge` int(11) NOT NULL,
	                    `winning_moviegoer` int(11) NOT NULL,
	                    `winning_film` int(11) NOT NULL,
	                    `format` text NOT NULL,
	                    `error_spin` text DEFAULT NULL,
	                    `scribe` int(11) NOT NULL,
	                    `theme` text DEFAULT NULL,
	                    `attendees` text NOT NULL,
	                    `selection_method` text NOT NULL,
	                    `runtime` int(11) NOT NULL DEFAULT 0,
	                    `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dice`
--
ALTER TABLE `dice`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `films`
--
ALTER TABLE `films`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spinners`
--
ALTER TABLE `spinners`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewers`
--
ALTER TABLE `viewers`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week`
--
ALTER TABLE `week`
	ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dice`
--
ALTER TABLE `dice`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `spinners`
--
ALTER TABLE `spinners`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `viewers`
--
ALTER TABLE `viewers`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `week`
--
ALTER TABLE `week`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;
