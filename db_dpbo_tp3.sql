-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 02:11 PM
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
-- Database: `db_dpbo_tp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE `director` (
  `id_director` int(11) NOT NULL,
  `director_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `director`
--

INSERT INTO `director` (`id_director`, `director_name`) VALUES
(1, 'Bong Joon-ho'),
(2, 'Angga Dwimas Sasongko'),
(3, 'Christopher Nolan'),
(4, 'Bang Woo-ri'),
(5, 'Makoto Shinki'),
(6, 'Anthony Russo');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id_genre`, `genre_name`) VALUES
(1, 'Thriller'),
(3, 'Mystery'),
(4, 'Horror'),
(5, 'Action'),
(8, 'Romance'),
(9, 'Science-Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id_movie` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_year` varchar(255) NOT NULL,
  `movie_poster` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `director_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id_movie`, `title`, `release_year`, `movie_poster`, `country`, `director_id`, `genre_id`) VALUES
(1, 'Parasite', '2019', 'parasite.jpg', 'South Korea', 1, 1),
(2, 'Inception', '2010', 'inception.jpg', 'United States', 3, 5),
(6, 'Mencuri Raden Saleh', '2022', 'mencuri_raden_saleh.jpg', 'Indonesia', 2, 5),
(7, '20th Century Girl', '2022', '20thcenturygirl.jpg', 'South Korea', 4, 8),
(8, 'Interstellar', '2014', 'interstellar.jpg', 'United States', 3, 5),
(9, 'Ant-Man and the Wasp: Quantumania', '2023', 'quantumania.jpg', 'United States', 3, 5),
(10, 'Avatar: The Way of Water', '2022', 'avatar.jpg', 'United States', 3, 5),
(12, 'Suzume', '2022', 'suzume.jpg', 'Japan', 5, 8),
(13, 'Avengers: Endgame', '2019', 'endgame.jpg', 'United States', 6, 5),
(17, 'Your Name', '2016', 'yourname.jpg', 'Japan', 5, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`id_director`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id_movie`),
  ADD KEY `director_id` (`director_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `director`
--
ALTER TABLE `director`
  MODIFY `id_director` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id_movie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`director_id`) REFERENCES `director` (`id_director`),
  ADD CONSTRAINT `movie_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id_genre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
