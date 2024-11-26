-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 11:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `followed_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 1),
(4, 5, 1),
(5, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

CREATE TABLE `hashtags` (
  `hashtag_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hashtags`
--

INSERT INTO `hashtags` (`hashtag_id`, `tag`) VALUES
(1, '#jou'),
(2, '#ahmud');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `liked_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `liked_user`) VALUES
(4, 3, 1),
(3, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `mentions`
--

CREATE TABLE `mentions` (
  `mention_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `mentioned_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentions`
--

INSERT INTO `mentions` (`mention_id`, `post_id`, `mentioned_user`) VALUES
(2, 1, 2),
(1, 13, 5),
(3, 14, 1),
(4, 15, 2),
(5, 16, 1),
(6, 16, 2),
(8, 18, 1),
(12, 22, 1),
(13, 22, 2),
(14, 22, 3),
(15, 22, 5),
(26, 24, 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `sender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `content`, `sender`) VALUES
(1, 'moikku @Lauri', 1),
(2, 'väsy', 2),
(12, 'Hei', 2),
(13, 'dfdufutf @Amanta uyf', 7),
(14, 'moi @Vil', 1),
(15, 'moi Lauri dsa', 1),
(16, 'moi @Vili ja @Lauri ', 1),
(18, 'Mitäs mies @Vili ', 2),
(22, 'Ukkelin morjes @Vili @Lauri @Juhani @Amanta ', 7),
(24, 'Morjes moro @Amanta', 3);

-- --------------------------------------------------------

--
-- Table structure for table `post_hashtags`
--

CREATE TABLE `post_hashtags` (
  `post_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_hashtags`
--

INSERT INTO `post_hashtags` (`post_id`, `hashtag_id`) VALUES
(2, 1),
(13, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `description`, `creation_date`) VALUES
(1, 'Vili', '$2y$10$Y7rkIYTAL1UR9ohF10JLhOlhbGQH71iNYR47fdBp9UFLxyUhPV262', 'v@v.com', 'Olen Viliilililili vilber', '2024-11-06'),
(2, 'Lauri', '$2y$10$Fl1bHSpC9Y39TdAN4ot01ebmrVFbLJbgAkzyjj4EcIKyz8mNBro0i', 'lauri@laurimail.com', '', '2024-11-22'),
(3, 'Juhani', '$2y$10$f/yGswHTIHvd1zuYGRbcF.QHCWlXiQoFTa0WyR2EpmE2pDUX2E6ra', 'juhani@juhanimail.com', '', NULL),
(5, 'Amanta', '$2y$10$Q4/E2a6GxyYirWqcoE2qs.3duFrNMwLatfPrsT7TtX17VuQVMXvLu', 'amanta@amantamail.com', '', NULL),
(7, 'aivan', '$2y$10$.SZlVjaJNPfCbv07SFskSeRq94sNL6g4G5sj9W.JOw0Tq13lF1.2K', 'a@a.a', '', NULL),
(8, 'Pertti', '$2y$10$5kXYh0G95OPDT5kP4pMKOeDshY/LeV6MWftKIL8ND7zAl3Rt4muwC', 'pertti@saunamail.com', 'Muistan vielä sen kesän -68... sauna, makkara ja sisu. Ei tule niitä aikoja takaisin.', '2024-11-06'),
(9, 'Aino', '$2y$10$8sfHD1SdjflKa0Po9wWCrWVRbR2yV0PiMtNiTL0JjYH4m.8U/F7N.', 'aino@postikone.fi', 'Kuka muistaa, kun kahvi maksoi markan? Minä ainakin! Nyt kaikki on euroja ja bittejä. Höh.', NULL),
(10, 'Reijo', '$2y$10$9BXoe6eHVJiwMqN.XQLL5OVzfrqHZT9/yUSobmwhMg94HpEbEeQpW', 'reijo@viskikirja.fi', 'Vieläkin muistan, kun kalaa sai verkoilla eikä marketista! Ei ollut silloin mitään ulkomaalaista tonnikalaa.', NULL),
(11, 'Helmi', '$2y$10$wLYDJjPPFbPH.PoJax1EuO/3VJnJZ9UnnZyoIEaF6BaEizEOhZWjy', 'helmi@kukkaniitty.fi', 'Ennen tanssilavoilla soi oikeat orkesterit. Ei ollut mitään koneääniä, vain haitari ja rummut.', NULL),
(12, 'Veikko', '$2y$10$2Dp/djxHYf2J8ZYzjKrvHuC3/XbrUI/AcJH6TkHMs7O6l7rRRLqJW', 'veikko@hikisauna.fi', 'Tervahöyryllä mentiin vielä minun lapsuudessa. Nyt kaikki on muovia ja sähköä. Mihin tämä maailma menee.', NULL),
(13, 'Maija', '$2y$10$45EZrOp.nMqr1lZWFS.J5O29cK2yBZNaTpPrShxwo8NTl9gu/nHb6', 'maija@lapinkulta.fi', 'Kukapa ei muistaisi vanhan kirkonkylän tansseja. Siellä minä kohtasin Eeron... tai ehkä se oli Olavi.', NULL),
(14, 'Eero', '$2y$10$dsH6JIOJYPukMF34sNfTGOlpix4/fEGHzawQlZUkBPXXPKTzWRdCG', 'eero@karhuolut.fi', 'Muistatko sinä sen pirtukanisterin, joka hukkui järveen? Se oli Eeron juhannus vuonna -72.', NULL),
(15, 'Riitta', '$2y$10$Xxo7A9vLXx/JQmO0tsrxUOvRrE0ZT6pLT46we/fB8FSYY75E0qPLy', 'riitta@kesakukka.fi', 'Minä tanssin aina ensimmäisen valssin. Aina. Ja viimeisenkin, jos oikein muisti pelaa.', NULL),
(16, 'Kalevi', '$2y$10$ukRyShKHkYvISU.JuMRLQeApZ2Wt/VIybz42aZ38XPc8AH87.2iLa', 'kalevi@koskenkorva.fi', 'Kuka muistaa, kun sauna lämpeni puilla eikä millään sähkövempaimilla? Silloin löylyt tuntuivat oikeilta.', NULL),
(17, 'Sirkka', '$2y$10$FlaTyLpZzwTZ6DjjTg2ONOWRSQ1gyldqsH2INmbISyHefgn2/xjt6', 'sirkka@vanhatavarat.fi', 'Vanha piironki tuolla nurkassa? Se on 50 vuotta vanha, niin kuin minäkin melkein. Ei niitä enää saa mistään.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_hashtags`
--

CREATE TABLE `user_hashtags` (
  `user_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`followed_id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indexes for table `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`hashtag_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `user_id` (`user_id`,`liked_user`),
  ADD KEY `liked_user` (`liked_user`);

--
-- Indexes for table `mentions`
--
ALTER TABLE `mentions`
  ADD PRIMARY KEY (`mention_id`),
  ADD KEY `post_id` (`post_id`,`mentioned_user`),
  ADD KEY `mentioned_user` (`mentioned_user`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `post_hashtags`
--
ALTER TABLE `post_hashtags`
  ADD KEY `post_id` (`post_id`,`hashtag_id`),
  ADD KEY `hashtag_id` (`hashtag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_hashtags`
--
ALTER TABLE `user_hashtags`
  ADD KEY `user_id` (`user_id`,`hashtag_id`),
  ADD KEY `hashtag_id` (`hashtag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `hashtag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mentions`
--
ALTER TABLE `mentions`
  MODIFY `mention_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`liked_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `mentions`
--
ALTER TABLE `mentions`
  ADD CONSTRAINT `mentions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `mentions_ibfk_2` FOREIGN KEY (`mentioned_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_hashtags`
--
ALTER TABLE `post_hashtags`
  ADD CONSTRAINT `post_hashtags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `post_hashtags_ibfk_2` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtags` (`hashtag_id`);

--
-- Constraints for table `user_hashtags`
--
ALTER TABLE `user_hashtags`
  ADD CONSTRAINT `user_hashtags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_hashtags_ibfk_2` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtags` (`hashtag_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
