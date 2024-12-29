-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: dec. 30, 2024 la 12:22 AM
-- Versiune server: 10.4.32-MariaDB
-- Versiune PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `web_test`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(1, 52, 11, 2),
(2, 52, 3, 1),
(3, 52, 6, 1),
(4, 52, 7, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`) VALUES
(1, 'Austria', '+43'),
(2, 'Belgium', '+32'),
(3, 'Bulgaria', '+359'),
(4, 'Cyprus', '+357'),
(5, 'Croatia', '+385'),
(6, 'Czech Republic', '+420'),
(7, 'Denmark', '+45'),
(8, 'Estonia', '+372'),
(9, 'Finland', '+358'),
(10, 'France', '+33'),
(11, 'Germany', '+49'),
(12, 'Greece', '+30'),
(13, 'Hungary', '+36'),
(14, 'Ireland', '+353'),
(15, 'Italy', '+39'),
(16, 'Latvia', '+371'),
(17, 'Lithuania', '+370'),
(18, 'Luxembourg', '+352'),
(19, 'Malta', '+356'),
(20, 'Netherlands', '+31'),
(21, 'Poland', '+48'),
(22, 'Portugal', '+351'),
(23, 'Romania', '+40'),
(24, 'Slovenia', '+386'),
(25, 'Slovakia', '+421'),
(26, 'Spain', '+34'),
(27, 'Sweden', '+46');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Pop'),
(2, 'R&amp;B'),
(3, 'Rap'),
(4, 'Rock'),
(5, 'Trap');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `number` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `payment_method` varchar(10) NOT NULL,
  `products_list` varchar(500) NOT NULL,
  `total_price` float NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `orders`
--

INSERT INTO `orders` (`id`, `number`, `user_id`, `first_name`, `last_name`, `email`, `address`, `country_name`, `phone_number`, `payment_method`, `products_list`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, '0000000001', 52, 'Nora', 'Wagner', 'user52@a.b', 'Simling 96, 8 OG, 0757, Berndorf bei Salzburg, Wien', 'Austria', '+43336002985', 'card', 'BADLANDS x 1', 10, '2024-12-19 22:00:00', 'completed');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `artist` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `genre_list` varchar(50) NOT NULL,
  `tracklist` varchar(500) NOT NULL,
  `release_date` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `cover` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `products`
--

INSERT INTO `products` (`id`, `title`, `artist`, `category`, `genre_list`, `tracklist`, `release_date`, `price`, `stock`, `cover`) VALUES
(1, 'Narrated For You', 'Alec Benjamin', 'Mixtape', 'Rock, Pop', '1.     If We Have Each Other\r\n2.	Water Fountain\r\n3.	Annabelle&#039;s Homework\r\n4.	Let Me Down Slowly\r\n5.	Swim\r\n6.	Boy in the Bubble\r\n7.	Steve\r\n8.	Gotta Be a Reason\r\n9.	Outrunning Karma\r\n10.	If I Killed Someone for You\r\n11.	Death of a Hero\r\n12.	1994', '2018-11-16', 23, 5, '676a87d3c2a11_alec-benjamin-narrated-for-you-cover.png'),
(2, 'TOO YOUNG TO BE SAD', 'Tate McRae', 'EP', 'Rock, Pop', '1.	bad ones\r\n2.	rubberband\r\n3.	slower\r\n4.	r u ok\r\n5.	you broke me first\r\n6.	wish i loved you in the 90s', '2021-03-26', 16, 2, '676b21dc50901_tate-mcrae-too-young-to-be-sad-cover.png'),
(3, 'Expectations', 'Bebe Rexha', 'Studio Album', 'Pop', '1. Ferrari\r\n2. I&#039;m a Mess\r\n3. 2 Souls on Fire (Ft. Quavo)\r\n4. Shining Star\r\n5. Knees\r\n6. I Got You\r\n7. Self Control\r\n8. Sad\r\n9. Mine\r\n10. Steady (Ft. Tory Lanez)\r\n11. Don&#039;t Get Any Closer\r\n12. Grace\r\n13. Pillow\r\n14. Meant to Be (Ft. Florida Georgia Line)', '2018-06-22', 14, 3, '676a88d4bd1d7_bebe-rexha-expectations-cover.png'),
(4, 'BADLANDS', 'Halsey', 'Studio Album', 'Pop', '1. Castle\r\n2. Hold Me Down\r\n3. New Americana\r\n4. Drive\r\n5. Roman Holiday\r\n6. Colors\r\n7. Coming Down\r\n8. Haunting\r\n9. Control\r\n10. Young God\r\n11. Ghost', '2015-08-28', 10, 2, '676a8aa627e97_halsey-badlands-cover.png'),
(5, 'Dream Awake', 'Black Atlass', 'Studio Album', 'R&amp;B', '1. Never Enough\r\n2. Do For Love\r\n3. Night After Night\r\n4. Sin City\r\n5. Lie To Me\r\n6. By My Side by Black Atlass &amp; SONIA\r\n7. Show Me\r\n8. On Your Mind\r\n9. Weak\r\n10. Drip\r\n11. Lavender\r\n12. Close Your Eyes', '2020-04-03', 17, 7, '676d926668dca_black-atlass-dream-awake-cover.png'),
(6, 'FREE 6LACK', '6LACK', 'Studio Album', 'R&amp;B', '1. Never Know\r\n2. Rules\r\n3. PRBLMS\r\n4. Free\r\n5. Learn Ya\r\n6. MTFU\r\n7. Luving U\r\n8. Gettin&#039; Old\r\n9. Worst Luck\r\n10. Ex Calling\r\n11. Alone / EA6\r\n12. Glock Six\r\n13. In Between (Ft. BANKS)\r\n14. One Way (Ft. T-Pain)', '2018-11-18', 20, 2, '676d9d0b5c411_6lack-free-6lack-cover.png'),
(7, 'My Favourite Clothes', 'RINI', 'Single', 'R&amp;B', '1. My Favourite Clothes', '2018-01-06', 10, 5, '676e85f2372f8_rini-my-favorite-clothes-cover.png'),
(8, 'The Off-Season', 'J. Cole', 'Studio Album', 'Rap', '1. 9 5 . s o u t h\r\n2. ​a m a r i\r\n3. ​m y . l i f e by J. Cole, 21 Savage &amp; Morray\r\n4. ​a p p l y i n g . p r e s s u r e\r\n5. ​p u n c h i n ’ . t h e . c l o c k\r\n6. 1 0 0 . m i l ’ by J. Cole &amp; Bas\r\n7. ​p r i d e . i s . t h e . d e v i l by J. Cole &amp; Lil Baby\r\n8. l e t . g o . m y . h a n d by J. Cole, Bas &amp; 6LACK\r\n9. i n t e r l u d e\r\n10. t h e . c l i m b . b a c k\r\n11. ​c l o s e\r\n12. h u n g e r . o n . h i l l s i d e by J. Cole &amp; Bas', '2021-05-14', 14, 3, '676e882a2c6b4_jcole-the-off-season-cover.png'),
(9, 'If Not Now, When?', 'Russ', 'EP', 'Rap', '1. Star\r\n2. Waves\r\n3. Back From London Freestyle\r\n4. Never Again', '2022-04-26', 11, 6, '676e8a166b383_russ-if-not-now-when-cover.png'),
(10, 'TESTING', 'A$AP Rocky', 'Studio Album', 'Rap', '1. Distorted Records\r\n2. A$AP Forever REMIX (Ft. Kid Cudi, Moby &amp; T.I.)\r\n3. Tony Tone\r\n4. Fukk Sleep (Ft. FKA twigs)\r\n5. Praise the Lord (Da Shine) (Ft. Skepta)\r\n6. CALLDROPS (Ft. Kodak Black)\r\n7. Buck Shots\r\n8. Gunz N Butter (Ft. Juicy J)\r\n9. Brotha Man (Ft. French Montana)\r\n10. OG Beeper\r\n11. Kids Turned Out Fine\r\n12. Hun43rd (Ft. Devonté Hynes)\r\n13. Changes\r\n14. Black Tux, White Collar\r\n15. Purity (Ft. Frank Ocean)', '2018-05-25', 20, 3, '676e8dd4dcbea_asap-rocky-testing-cover.png'),
(11, 'i am &gt; i was', '21 Savage', 'Studio Album', 'Rap, Trap', '1. a lot (Ft. J. Cole)\r\n2. break da law\r\n3. a&amp;t (Ft. Yung Miami)\r\n4. out for the night\r\n5. gun smoke\r\n6. 1.5 (Ft. Offset)\r\n7. all my friends (Ft. Post Malone)\r\n8. can’t leave without it (Ft. Gunna &amp; Lil Baby)\r\n9. asmr\r\n10. ball w/o you\r\n11. good day (Ft. Project Pat &amp; ScHoolboy Q)\r\n12. pad lock\r\n13. monster (Ft. Childish Gambino)\r\n14. letter 2 my momma\r\n15. 4L (Ft. Young Nudy)', '2019-12-21', 18, 4, '676e8d5eb2be2_21-savage-i-am-i-was-cover.png'),
(12, 'CrasH Talk', 'ScHoolboy Q', 'Studio Album', 'Rap', '1. Gang Gang\r\n2. Tales\r\n3. CHopstix by ScHoolboy Q &amp; Travis Scott\r\n4. Numb Numb Juice\r\n5. Drunk (Ft. 6LACK)\r\n6. Lies (Ft. Ty Dolla $ign &amp; YG)\r\n7. 5200\r\n8. Black Folk\r\n9. Floating (Ft. 21 Savage)\r\n10. Dangerous (Ft. Kid Cudi)\r\n11. Die Wit Em\r\n12. CrasH\r\n13. Water (Ft. Lil Baby)\r\n14. Attention', '2019-04-26', 15, 5, '676e8f0591b85_schoolboy-q-crash-talk-cover.png');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `profile_picture` varchar(300) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`, `user_type`) VALUES
(1, 'user1', 'user1@a.b', '$2y$10$1xsQu4wkbldMOlYmazfRe.URuseM7QIH2rZn84MsM8ubzxnO1o4Ru', 'default-profile-pic.png', 'user'),
(2, 'user02', 'user02@a.b', '$2y$10$S/xsgGH.PVsJXy3ZOOS7Vecma2uDqQZfcCCRXiTxWTmG0gfuVoTge', '67682f118c18c_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'admin'),
(3, 'user3', 'user3@a.b', '$2y$10$zLjjRRB6WfG726BppdRo0un/v1800rG/nerwJkjtfm7.blCQ5mOcG', 'default-profile-pic.png', 'admin'),
(4, 'user4', 'user4@a.b', '$2y$10$KNh0yHUxobxPb5A6.EGIguONwKFISuiiBU54rGAoGqljBaZIHQO.e', 'default-profile-pic.png', 'user'),
(5, 'user5', 'user5@a.b', '$2y$10$C0cHtSZgzZ6ob/nX4RpY0ecWax.YKqfpf4kPoueB8CBSSiX6Tlgvu', 'default-profile-pic.png', 'user'),
(6, 'user6', 'user6@a.b', '$2y$10$lkvSMgVgCHNQZ.VqpBZ..e5yZK5uANX28JvjswxetidgROUNMDT2e', 'default-profile-pic.png', 'user'),
(7, 'user7', 'user7@a.b', '$2y$10$rJqNfFPdqVP3aFOulsTcnO2SbQ.dYK7uGXXtyqZ/L7A4KiasSPJAu', 'default-profile-pic.png', 'admin'),
(8, 'user8', 'user8@a.b', '$2y$10$U/ZM0.CQv8ARNE2tgh2P1uHxLhF7OfoV8KtE6Ntc4w./mRUGKtBPG', 'default-profile-pic.png', 'user'),
(9, 'user9', 'user9@a.b', '$2y$10$zPORqYnRQP2wnRpUQn/S7.cQ4iiALYFmj6ihpIBTJN5YxF.eSuw96', 'default-profile-pic.png', 'user'),
(10, 'user10', 'user10@a.b', '$2y$10$9kJpK7S0BxJZqBFfsjuLl.YSHY2XUCG5AC4pyOKEDJgXd8oH8Zrcu', 'default-profile-pic.png', 'user'),
(11, 'user11', 'user11@a.b', '$2y$10$dOst7YDeqhXJN36EYbxLJ.eycYY/WvaeDkRcE/FgYmMEEEMiY84Eu', 'default-profile-pic.png', 'user'),
(12, 'user12', 'user12@a.b', '$2y$10$mYDv4bnpyYyoBEQ2tLnGpO7r4qCToQvtxla/Z7RICWq/3jxyxGVF6', 'default-profile-pic.png', 'user'),
(13, 'user13', 'user13@a.b', '$2y$10$xJ9BhLKcP2WZGwsGnoHOmeG1X2bYbiy3Fv4ngv8skyNk.SiXiH.jC', '4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(14, 'user14', 'user14@a.b', '$2y$10$Q4yCaum9YpwNiGYfGsC3ruOWRsXPrerTpCIY8O3g8UwCE0DjelHZq', 'default-profile-pic.png', 'user'),
(15, 'user15', 'user15@a.b', '$2y$10$zNIghJ3kLLNBewDneSW6qOaFeYre.4kKVZrgTiywNyMi9S.raNFx2', 'pexels-bertellifotografia-3792581.jpg', 'user'),
(16, 'user16', 'user16@a.b', '$2y$10$pq2nTUm5j3cKukA2aL2l6eyhHepNfMBdU9.4VNVT8t4QZr3fM7Gwe', 'pexels-bertellifotografia-3792581.jpg', 'user'),
(17, 'user17', 'user17@a.b', '$2y$10$yYNPafFnTach.tGrHol.T.RpIhu2vZkhbqRnv2nXOwpYp9s/WQmye', '4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(18, 'user18', 'user18@a.b', '$2y$10$.9IWoatX7w72EHtudHJ/9uCh1MOQt4H4lCRpTd5bIzuOwM7M7lSW2', '4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(19, 'user19', 'user19@a.b', '$2y$10$lH0dHlWmYcfJPJGydYffUOhi58JqEAJAoiEQUQ3smAqJIsDgSp2r2', 'n-avem', 'user'),
(20, 'user20', 'user20@a.b', '$2y$10$FzSVfRwMP50MUsBB07gpYezjcavCQVdhTC9JomflwgbK5KIaT5Pk.', 'n-avem', 'user'),
(21, 'user21', 'user21@a.b', '$2y$10$u/MofPg4t/11vYNDpWix/uRTYyEsjLddLgZhV1uqQhkddUCOXqXbC', 'n-avem', 'user'),
(22, 'user22', 'user22@a.b', '$2y$10$vTfd0H4nPsiywdexKDrqsONiH16EMikwBKeB9VJqLvCkeh6Z6uAOO', 'n-avem', 'user'),
(23, 'user23', 'user23@a.b', '$2y$10$f7X5B1YFt6Wlxxb6BhrZGe6XvmnV0YGPy3eezqqeiZJ4s9IwOX0o6', 'n-avem', 'user'),
(24, 'user24', 'user24@a.b', '$2y$10$eT/XK7DVTepDyWcc5/AdRu75y.VJb8Yg5cQbI4.QS4r45A6DqG0Jm', '67653b76327a8_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(25, 'user25', 'user25@a.b', '$2y$10$A8NX/bTGYzqL6avLNhTCjO/2kAwA.xRugp/7qCdgM2aMlPsTFPY82', '67653c603dd2a_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(26, 'user26', 'user26@a.b', '$2y$10$/DVE5KkrG3KnLVq0BVCAAuI7yCHniMFVFlArWA8VqHHr37xUmGR7i', '67653d164c87a_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(27, 'user27', 'user27@a.b', '$2y$10$szFnJbFGgNhyzyPEmqkkXe2zmKjz6MUra1rCazfWTBmSDSwNvs/Di', 'Array', 'user'),
(28, '[object Object]', '[object Object]', '$2y$10$ZNJEWC1xrJqpTiOXxzsdn.C13mjPztZtXbnZdshnbNt/whuU7Jh6i', '676541467ff9a_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(29, 'user29', 'user29@a.b', '$2y$10$0mGOXFkzM8WJMzzOp.19E.De796OpNpVRJml0Fg8kObyGzwVNjMR2', '676541981d2d4_pexels-bertellifotografia-3792581.jpg', 'user'),
(30, 'user30', 'user30@a.b', '$2y$10$ocm8qAYet.yXyKcJ7HTtr.Yc4M6HUTytMRl9mjW4A7UR/4LDfNZhe', 'default-profile-pic.png', 'user'),
(31, 'user31', 'user31@a.b', '$2y$10$oKDgMzwV.U3YKLgls./D6uA0McMDyH8suBRP6UDXJo2ZpeITxuNW6', '67657e917cb0f_profilepic.png', 'user'),
(32, 'user32', 'user32@a.b', '$2y$10$mi5xh9j9AyhmtSclSWWKEONFtOAi4L76yfVwTC8gYvJF2AyVJWzmu', '67657ee6bb0b5_profilepic.png', 'user'),
(33, 'user33', 'user33@a.b', '$2y$10$PEVuMZmjxedcO2uoKl8bseNTG3L3cWCKYSvX.XhaZsBecqSzzWzYq', 'default-profile-pic.png', 'user'),
(34, 'user34', 'user34@a.b', '$2y$10$ZCbmwU5BJmJD0WzyDuEdN.wn.fotG/.kMBdJv50Q2mZKtKFPvTrwm', 'default-profile-pic.png', 'user'),
(35, 'user35', 'user35@a.b', '$2y$10$XSmKBTY1S2RJg4YAVJB5PuZe7b8vAZpTPJlBKeC4gHW4vNCcRdvVC', '67657fcf3b9a2_concentratie_procentuala_calcul.jpeg', 'user'),
(36, 'user36', 'user36@a.b', '$2y$10$o0/JnNi8PpNK45EIRZWptuxqd6eK9.jyRgNXqQi6lyLGVeJN6j9lq', 'default-profile-pic.png', 'user'),
(37, 'user37', 'user37@a.b', '$2y$10$aveZQp9eGtEeAvhUsuvlA.W2.x0E4qNMt5GtGq3o2XXIR/JIQCxTO', 'default-profile-pic.png', 'user'),
(38, 'user38', 'user38@a.b', '$2y$10$IvdUpeUmx5iMWPJzWL/m3e.T9avZ4spoPk6FG17s5k2dqh3ra6JY6', 'default-profile-pic.png', 'user'),
(39, 'user39', 'user39@a.b', '$2y$10$dteYYQx21sXw9UWMYDLTwO8INcVuqrb1V7lHOwismwavRM8kPBV52', 'default-profile-pic.png', 'user'),
(40, 'user40', 'user40@a.b', '$2y$10$qGMvb1oKv3eyGjiu48l5zevDdAHUI49.sbd6RSznq3ljVb1goRUFy', 'default-profile-pic.png', 'user'),
(41, 'user41', 'user41@a.b', '$2y$10$TYPFMo5h4mtTLMAMoMf/SujmD0niXc8YSSR8YcjRZ/.9Gl5lQjnWq', 'default-profile-pic.png', 'user'),
(42, 'user42', 'user42@a.b', '$2y$10$qo1g8Z7WlVxGD5rzc.SPgufX2089V7AW00SRWZvjYJIJskISRrh.q', '6765b2da8ed3f_pexels-bertellifotografia-3792581.jpg', 'admin'),
(43, 'user43', 'user43@a.b', '$2y$10$efNDcUFP6DrJ7VH888yPyereyszREUvF9g9AOTQ7idVuajUPMN7E.', '67685728ad0be_pexels-bertellifotografia-3792581.jpg', 'admin'),
(44, 'user44', 'user44@a.b', '$2y$10$EO3P2z4kcL6MmoC6fmkcb.CnP4b5miYIZLbqDiLU4IvEMhYBB.pxe', '6769265da803c_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(45, 'user45', 'user45@a.b', '$2y$10$r3vx58N1PCLg1.BewaPINeX4S9eaAq4ceaDcSmlE5A8TriB2d/yYS', 'default-profile-pic.png', 'user'),
(46, 'user46', 'user46@a.b', '$2y$10$EXlnAEcw3JYjN1zWU54WFuy6.UvJwRZx0qDfFd/2lu3fGdueUwUBm', '67692f7969e1e_pexels-bertellifotografia-3792581.jpg', 'user'),
(47, 'user47', 'user47@a.b', '$2y$10$85jjAEPP7SzogeY7qXdiuO7YjfZJY.3iWT5TU1WaprftB2aPn2zmC', 'default-profile-pic.png', 'user'),
(48, 'user48', 'user48@a.b', '$2y$10$Ol88bHMfqXCNy21PQKbqgOp5FdBHrygLgedKxrUOoRsiEdx4tS3ty', 'default-profile-pic.png', 'user'),
(49, 'user49', 'user49@a.b', '$2y$10$zt8SrbZX1cLdwLRrvVUCbuwe.oLc/Y/.vaXjJEXpeCkfBKlW.WRKa', 'default-profile-pic.png', 'user'),
(50, 'user50', 'user50@a.b', '$2y$10$PO.8fuooZ2CTWqIKmDnhFOKLQebWKTdUFRjdVypY.K4FoKt0B3h.u', 'default-profile-pic.png', 'user'),
(51, 'user51', 'user51@a.b', '$2y$10$pcT2PQ3eCl/L.Lyw9P9OXe6pOuzA7FruPMCHj1Yw.An.ab30w.yHW', '676d1ffde0c14_pexels-bertellifotografia-3792581.jpg', 'admin'),
(52, 'user52', 'user52@a.b', '$2y$10$OCpDh3T.z3./L3FWjErfPe62VY0w/Z5wappNwQpSMZqNsTFpA91Ou', '6769828f102a3_4k-beautiful-colorful-abstract-wallpaper-photo.jpg', 'user'),
(53, 'NULL', 'NULL', 'NULL', 'NULL', 'user');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Eliminarea datelor din tabel `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`) VALUES
(1, 52, 3),
(2, 52, 5),
(3, 52, 11);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cartTable_idUser_fk` (`user_id`),
  ADD KEY `cartTable_idProduct_fk` (`product_id`);

--
-- Indexuri pentru tabele `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexuri pentru tabele `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexuri pentru tabele `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordersTable_userId_fk` (`user_id`);

--
-- Indexuri pentru tabele `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexuri pentru tabele `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlistTable_idUser_fk` (`user_id`),
  ADD KEY `wishlistTable_productId_fk` (`product_id`);

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cartTable_idProduct_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `cartTable_idUser_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constrângeri pentru tabele `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ordersTable_userId_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constrângeri pentru tabele `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlistTable_idUser_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlistTable_productId_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
