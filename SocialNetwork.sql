-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 19 2018 г., 11:55
-- Версия сервера: 5.7.20
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `SocialNetwork`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `posted_at` datetime NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `comment`, `user_id`, `posted_at`, `post_id`) VALUES
(1, 'Comment test ', 8, '2018-11-16 16:14:47', 10),
(2, 'Comment test ', 8, '2018-11-16 16:15:00', 10),
(3, 'уще комменр', 8, '2018-11-16 16:17:47', 7),
(4, 'у', 8, '2018-11-16 16:19:17', 9),
(5, 'new', 8, '2018-11-16 16:27:01', 6),
(8, 'sss', 8, '2018-11-16 16:30:33', 9),
(9, 'some new comments', 8, '2018-11-16 16:33:25', 9),
(10, 'Some new comments', 8, '2018-11-16 16:33:50', 10),
(11, 'some new comments', 8, '2018-11-16 16:34:02', 1),
(12, 'a lot of many comments', 8, '2018-11-16 16:34:21', 8),
(13, 'some', 16, '2018-11-16 16:37:34', 24),
(14, 'some', 16, '2018-11-16 16:44:03', 28),
(15, '16.11', 16, '2018-11-16 16:52:45', 22),
(16, 'Hello Vika', 12, '2018-11-16 17:01:46', 12),
(17, '7', 8, '2018-11-16 17:13:27', 12),
(18, '7', 8, '2018-11-16 17:13:39', 12),
(19, 'some', 16, '2018-11-22 12:12:01', 9),
(20, 'some', 16, '2018-11-22 12:12:23', 26),
(21, 'any', 16, '2018-11-22 12:12:32', 26),
(22, 'some', 16, '2018-11-22 13:04:49', 25),
(23, 'some', 16, '2018-11-22 13:05:36', 24),
(24, 'hey', 8, '2018-11-27 12:19:22', 38),
(25, 'it\'s cool', 8, '2018-11-29 13:26:29', 72),
(26, 'by', 16, '2018-12-04 16:52:39', 37),
(27, 'hello, how are you\'had?', 16, '2018-12-04 16:54:22', 24),
(28, 'some comments', 16, '2018-12-11 13:45:17', 90);

-- --------------------------------------------------------

--
-- Структура таблицы `followers`
--

CREATE TABLE `followers` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `follower_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `follower_id`) VALUES
(16, 8, 10),
(17, 10, 8),
(21, 8, 12),
(22, 16, 8),
(23, 8, 16),
(24, 10, 12),
(25, 16, 12),
(26, 12, 8),
(27, 12, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `token`, `user_id`) VALUES
(37, '3821bf55b280cc0696f0cba1f4d08c58c202a4da', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `sender` int(11) UNSIGNED NOT NULL,
  `receiver` int(11) UNSIGNED NOT NULL,
  `watched` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `body`, `sender`, `receiver`, `watched`) VALUES
(1, 'hello, Kira! How are You?', 8, 10, 0),
(2, 'My name is Sergey', 8, 10, 0),
(3, 'alert(\'push)', 8, 10, 0),
(4, 'Hey Kira', 8, 10, 0),
(5, 'Hey kira', 8, 10, 0),
(6, 'Hey! how are you?', 8, 10, 0),
(11, 'new message', 8, 10, 0),
(12, '1', 8, 10, 0),
(13, 'Hello Sergey', 10, 10, 0),
(14, 'Hello Kira? my name is vasy', 12, 10, 1),
(15, 'Hello Vasy my name is Kira', 10, 12, 0),
(16, 'hi Sergey, how are You', 10, 10, 0),
(17, 'hi Sergey how are you&', 10, 8, 1),
(18, 'How are you Kira', 12, 10, 1),
(19, 'am fine? how are you?', 12, 12, 0),
(20, 'it\'s ok, how are you?', 10, 12, 0),
(21, 'am fine, let\'s go walk', 12, 10, 0),
(22, 'hello Vika, how are you?', 12, 16, 1),
(23, 'Vika, you\'re cool', 12, 16, 1),
(24, 'new message', 8, 10, 0),
(26, 'alert(\'hello\')', 8, 10, 0),
(27, 'hi handsome', 16, 10, 0),
(28, 'some', 8, 10, 0),
(29, 'new', 8, 10, 0),
(30, 'hi handsome', 16, 8, 0),
(31, 'serj', 10, 8, 0),
(32, 'hi vika', 8, 16, 0),
(33, 'kira', 8, 10, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` int(11) UNSIGNED NOT NULL,
  `receiver` int(10) UNSIGNED NOT NULL,
  `sender` int(11) UNSIGNED NOT NULL,
  `extra` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `receiver`, `sender`, `extra`) VALUES
(1, 1, 8, 16, NULL),
(2, 1, 12, 16, NULL),
(3, 1, 16, 16, NULL),
(4, 1, 16, 16, NULL),
(7, 1, 16, 16, '{ \"postbody\" : \"@vika json some\" }'),
(8, 1, 16, 16, '{ \"postbody\" : \"@Vika some new create notify Method \'\'\' some\'\" }'),
(9, 1, 16, 16, '{ \"postbody\" : \"@vika six\" }'),
(10, 2, 16, 16, ''),
(11, 2, 12, 12, ''),
(12, 2, 12, 12, ''),
(13, 2, 8, 16, ''),
(14, 1, 8, 16, '{ \"postbody\" : \"@Sergey Hello\" }'),
(15, 1, 16, 16, '{ \"postbody\" : \"@vika some\" }'),
(16, 1, 8, 8, '{ \"postbody\" : \"@sergey hello world\" }');

-- --------------------------------------------------------

--
-- Структура таблицы `password_tokens`
--

CREATE TABLE `password_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `body` varchar(160) NOT NULL,
  `posted_at` datetime NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `likes` int(11) UNSIGNED NOT NULL,
  `postimg` varchar(255) DEFAULT NULL,
  `topics` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `body`, `posted_at`, `user_id`, `likes`, `postimg`, `topics`) VALUES
(13, 'new', '2018-11-14 13:21:35', 16, 2, NULL, NULL),
(14, 'rrrrrrrrrrrrr', '2018-11-14 13:29:27', 16, 1, NULL, NULL),
(15, 'rrrrrrrrrrrrr', '2018-11-14 13:42:29', 16, 1, NULL, NULL),
(16, 'rrrrrrrrrrrrr', '2018-11-14 13:42:32', 16, 2, NULL, NULL),
(17, 'eeeeeeeeeeee', '2018-11-14 14:29:13', 16, 1, NULL, NULL),
(18, 'eeeeeeeeeeee', '2018-11-14 14:29:23', 16, 1, NULL, NULL),
(19, 'eeeeeeeeeee', '2018-11-14 14:30:28', 16, 2, NULL, NULL),
(20, 'd', '2018-11-14 14:30:35', 16, 1, NULL, NULL),
(21, 'some new', '2018-11-14 14:32:20', 8, 1, NULL, NULL),
(22, 'New post from Post.php', '2018-11-15 13:51:02', 8, 2, NULL, NULL),
(23, 'New post from Post.php', '2018-11-15 13:51:17', 8, 1, NULL, NULL),
(24, 'fffffffffffff', '2018-11-15 13:53:54', 8, 3, NULL, NULL),
(25, 'some', '2018-11-15 13:54:43', 8, 3, NULL, NULL),
(26, 'some yet', '2018-11-15 14:12:36', 8, 3, NULL, NULL),
(27, 'already', '2018-11-15 14:17:57', 8, 1, NULL, NULL),
(28, 'e', '2018-11-16 16:35:03', 8, 2, NULL, NULL),
(31, 'some', '2018-11-20 15:39:16', 8, 1, NULL, NULL),
(32, 'dddddddddddddddddddddd', '2018-11-20 15:59:06', 8, 1, NULL, NULL),
(33, '', '2018-11-20 15:59:14', 8, 2, NULL, NULL),
(34, 'some new', '2018-11-20 16:17:05', 8, 1, NULL, NULL),
(37, 'some', '2018-11-20 16:36:47', 8, 4, 'https://i.imgur.com/9EOBIaF.png', NULL),
(38, 'dddddddd', '2018-11-21 14:46:11', 16, 2, NULL, NULL),
(69, '', '2018-11-23 14:57:18', 16, 1, 'https://i.imgur.com/b0Yeied.jpg', ''),
(79, 'new some', '2018-12-05 14:31:57', 16, 1, NULL, ''),
(80, 'Hey guy', '2018-12-05 15:06:01', 16, 1, NULL, ''),
(82, '@Sergey Hello', '2018-12-05 15:09:38', 16, 1, NULL, ''),
(85, 'Hey guy', '2018-12-05 15:15:05', 16, 1, NULL, ''),
(86, '#PHP', '2018-12-05 15:15:52', 16, 2, NULL, 'PHP,'),
(87, '#PHP', '2018-12-05 15:18:03', 16, 1, NULL, 'PHP,'),
(88, '123456New posts', '2018-12-11 13:18:54', 16, 1, NULL, ''),
(89, '', '2018-12-11 13:20:02', 16, 2, 'https://i.imgur.com/wjw1LT5.jpg', ''),
(90, '', '2018-12-11 13:20:23', 16, 1, 'https://i.imgur.com/Qh32soY.jpg', ''),
(91, 'today 1212', '2018-12-12 10:35:19', 16, 1, NULL, ''),
(92, 'aua', '2018-12-12 16:32:10', 8, 1, NULL, ''),
(93, 'aua', '2018-12-12 16:32:29', 8, 2, 'https://i.imgur.com/c33TYs6.jpg', ''),
(94, 'some', '2018-12-17 15:48:50', 8, 1, 'https://i.imgur.com/KY4L5yv.jpg', ''),
(95, 'some', '2018-12-17 15:49:02', 8, 1, 'https://i.imgur.com/mehk3XI.jpg', ''),
(96, '', '2018-12-17 15:51:18', 8, 1, 'https://i.imgur.com/4S9gCya.jpg', ''),
(97, '', '2018-12-17 15:51:42', 8, 1, 'https://i.imgur.com/vHQklOV.jpg', ''),
(98, '@vika some', '2018-12-18 13:54:42', 16, 0, NULL, ''),
(99, '@sergey hello world', '2018-12-19 11:49:59', 8, 0, NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`) VALUES
(113, 72, 16),
(114, 70, 16),
(115, 38, 16),
(117, 33, 16),
(119, 71, 16),
(121, 31, 16),
(125, 67, 16),
(126, 65, 16),
(145, 25, 16),
(148, 86, 16),
(150, 87, 16),
(152, 21, 16),
(153, 22, 16),
(154, 32, 16),
(158, 15, 16),
(160, 17, 16),
(164, 10, 16),
(168, 91, 16),
(169, 19, 16),
(170, 29, 16),
(171, 74, 16),
(172, 79, 16),
(173, 82, 16),
(174, 85, 16),
(175, 88, 16),
(176, 18, 16),
(177, 28, 16),
(178, 34, 16),
(179, 73, 16),
(180, 37, 16),
(181, 37, 8),
(183, 93, 8),
(184, 90, 8),
(185, 13, 8),
(186, 16, 8),
(187, 19, 8),
(188, 22, 8),
(189, 28, 8),
(190, 33, 8),
(191, 38, 8),
(192, 86, 8),
(193, 89, 8),
(194, 26, 8),
(195, 25, 8),
(196, 24, 8),
(197, 92, 8),
(198, 80, 8),
(199, 27, 8),
(200, 96, 8),
(201, 95, 8),
(202, 94, 8),
(203, 93, 16),
(204, 89, 16),
(205, 97, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `email` text NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT '0',
  `profileimg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`, `profileimg`) VALUES
(8, 'Sergey', '$2y$10$Sb7DtRyvi5YDTlD.zOWJUOPsP81Oa.4xzcT31mjNB0odisPeteROK', 'sergey_bobkov@inbox.ru', 1, 'https://i.imgur.com/QWotl5x.jpg'),
(10, 'Kira', '$2y$10$bgA2eRCAWdZlYAoSmEuYPOiOEOTclzeMXgzv7DwYoMg3reVZT0tO2', 'taran.kira@rambler.ru', 1, NULL),
(13, 'Vasy1', '$2y$10$tuTAsY15oKrhzxpQkLci5ujXNnGXVTXse1ZxkspxXiOZ4g7pqjHO.', 'pochta1@pktitan.ru', 0, NULL),
(14, 'Verified', '$2y$10$ShpIEeTLaipYTA6N4uoXhupgmE.FZqeIXtjinZy6VzcgG4GBTBD6.', 'verified@gmail.com', 0, NULL),
(15, 'alert(\'hello)', '$2y$10$Z7bgQ5XEEup7wNh9T5LnJO5N.Rm9S4HYy/kqNBGX7CguZwPfL/Vke', 'vzlk@yandex.ru', 1, NULL),
(16, 'Vika', '$2y$10$fVKElmVNUMZsfiPobHr4UuUZYge5Jf.FPSm18C39bu.NzCvFxGslK', 'pktitanseo@yandex.ru', 1, NULL),
(17, 'SergeyBobkov', '$2y$10$ZpeBzRq3QGLs1xK4vpeYQOtW4mRxIaqXmcQ5j8PcH5QxZb4TJhxtm', 'bobkovsergeyarkadevich@gmail.com', 0, 'https://i.imgur.com/kcLu8VU.jpg'),
(25, 'Orally123456', '$2y$10$Nsvp031UAvVAs8fLCB46yOkcAHeGWrKbnk0DDfe5ksj.73gSJMEaK', 'info@sitesdevelopment.ru', 0, NULL),
(26, 'Sergey1', '$2y$10$3IpMre.tWx34aWfh9pABjex9B9f/XuaMvOTN6rqs/MvROWXOV/pW.', 'sergey1_bobkov@inbox.ru', 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comments_ibfk_1` (`post_id`);

--
-- Индексы таблицы `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_tokens`
--
ALTER TABLE `password_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_ibfk_1` (`user_id`);

--
-- Индексы таблицы `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `post_likes_ibfk_2` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `password_tokens`
--
ALTER TABLE `password_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT для таблицы `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
