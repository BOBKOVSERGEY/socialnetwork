-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 27 2018 г., 16:41
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
(6, 'alert(\'hello\')', 8, '2018-11-16 16:27:38', 6),
(7, 'alert(\'hello\')', 8, '2018-11-16 16:27:54', 6),
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
(24, 'hey', 8, '2018-11-27 12:19:22', 38);

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
(14, '2936b14435cb8fc5819944ff04b8f4e06243a124', 12);

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
(23, 'Vika, you\'re cool', 12, 16, 1);

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
(10, 2, 16, 16, '');

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
(1, 'Hello world!', '2018-11-13 15:39:28', 12, 0, NULL, NULL),
(5, 'alert(\'hello)', '2018-11-13 15:49:45', 12, 0, NULL, NULL),
(6, '&lt;?php echo \'hello\';?&gt;\r\n&lt;script&gt;alert(\'hello)&lt;/script&gt;', '2018-11-13 15:51:19', 12, 0, NULL, NULL),
(7, 'alert(\'hello)', '2018-11-13 15:57:33', 12, 0, NULL, NULL),
(8, 'alert(\'hello)', '2018-11-13 15:59:21', 12, 0, NULL, NULL),
(9, 'alert(\'hello)', '2018-11-13 16:02:33', 12, 2, NULL, NULL),
(10, 'e', '2018-11-13 16:02:53', 12, 1, NULL, NULL),
(13, 'new', '2018-11-14 13:21:35', 16, 1, NULL, NULL),
(14, 'rrrrrrrrrrrrr', '2018-11-14 13:29:27', 16, 1, NULL, NULL),
(15, 'rrrrrrrrrrrrr', '2018-11-14 13:42:29', 16, 0, NULL, NULL),
(16, 'rrrrrrrrrrrrr', '2018-11-14 13:42:32', 16, 1, NULL, NULL),
(17, 'eeeeeeeeeeee', '2018-11-14 14:29:13', 16, 0, NULL, NULL),
(18, 'eeeeeeeeeeee', '2018-11-14 14:29:23', 16, 0, NULL, NULL),
(19, 'eeeeeeeeeee', '2018-11-14 14:30:28', 16, 0, NULL, NULL),
(20, 'd', '2018-11-14 14:30:35', 16, 1, NULL, NULL),
(21, 'some new', '2018-11-14 14:32:20', 8, 0, NULL, NULL),
(22, 'New post from Post.php', '2018-11-15 13:51:02', 8, 0, NULL, NULL),
(23, 'New post from Post.php', '2018-11-15 13:51:17', 8, 1, NULL, NULL),
(24, 'fffffffffffff', '2018-11-15 13:53:54', 8, 2, NULL, NULL),
(25, 'some', '2018-11-15 13:54:43', 8, 2, NULL, NULL),
(26, 'some yet', '2018-11-15 14:12:36', 8, 3, NULL, NULL),
(27, 'already', '2018-11-15 14:17:57', 8, 0, NULL, NULL),
(28, 'e', '2018-11-16 16:35:03', 8, 1, NULL, NULL),
(29, 'eeeeeeeeeee', '2018-11-16 16:57:57', 12, 0, NULL, NULL),
(30, 'Все привет', '2018-11-16 16:59:32', 12, 0, NULL, NULL),
(31, 'some', '2018-11-20 15:39:16', 8, 1, NULL, NULL),
(32, 'dddddddddddddddddddddd', '2018-11-20 15:59:06', 8, 1, NULL, NULL),
(33, '', '2018-11-20 15:59:14', 8, 1, NULL, NULL),
(34, 'some new', '2018-11-20 16:17:05', 8, 1, NULL, NULL),
(37, 'some', '2018-11-20 16:36:47', 8, 3, 'https://i.imgur.com/9EOBIaF.png', NULL),
(38, 'dddddddd', '2018-11-21 14:46:11', 16, 1, NULL, NULL),
(51, '@Vika kkkk', '2018-11-21 15:25:26', 16, 1, NULL, NULL),
(60, '@Sergey Developer', '2018-11-22 12:59:54', 16, 0, NULL, ''),
(61, '#PHP Developers', '2018-11-22 13:00:26', 16, 0, NULL, 'PHP,'),
(62, '@Sergey Hello', '2018-11-22 13:53:52', 16, 0, NULL, ''),
(63, '@Vasy  hello', '2018-11-22 13:58:59', 16, 0, NULL, ''),
(64, '@Vika some', '2018-11-22 14:00:08', 16, 0, NULL, ''),
(65, '@vika any', '2018-11-23 14:41:41', 16, 1, NULL, ''),
(67, '@vika Hello World', '2018-11-23 14:54:17', 16, 1, NULL, ''),
(69, '', '2018-11-23 14:57:18', 16, 1, 'https://i.imgur.com/b0Yeied.jpg', ''),
(70, '@vika json some', '2018-11-23 15:15:04', 16, 2, NULL, ''),
(71, '@Vika some new create notify Method \'\'\' some\'', '2018-11-23 15:32:25', 16, 2, NULL, ''),
(72, '@vika six', '2018-11-23 15:33:10', 16, 2, 'https://i.imgur.com/s2crzOv.jpg', '');

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
(116, 34, 16),
(117, 33, 16),
(118, 37, 16),
(119, 71, 16),
(120, 32, 16),
(121, 31, 16),
(122, 28, 16),
(123, 26, 16),
(124, 25, 16),
(125, 67, 16),
(126, 65, 16);

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
(12, 'Vasy', '$2y$10$jW.yZeVrrpuSMvF86jBViOJRr8HP097awdd4Easf2Rd6hKsR9R9zS', 'pochta@pktitan.ru', 0, NULL),
(13, 'Vasy1', '$2y$10$tuTAsY15oKrhzxpQkLci5ujXNnGXVTXse1ZxkspxXiOZ4g7pqjHO.', 'pochta1@pktitan.ru', 0, NULL),
(14, 'Verified', '$2y$10$ShpIEeTLaipYTA6N4uoXhupgmE.FZqeIXtjinZy6VzcgG4GBTBD6.', 'verified@gmail.com', 0, NULL),
(15, 'alert(\'hello)', '$2y$10$Z7bgQ5XEEup7wNh9T5LnJO5N.Rm9S4HYy/kqNBGX7CguZwPfL/Vke', 'vzlk@yandex.ru', 0, NULL),
(16, 'Vika', '$2y$10$fVKElmVNUMZsfiPobHr4UuUZYge5Jf.FPSm18C39bu.NzCvFxGslK', 'pktitanseo@yandex.ru', 0, NULL),
(17, 'SergeyBobkov', '$2y$10$ZpeBzRq3QGLs1xK4vpeYQOtW4mRxIaqXmcQ5j8PcH5QxZb4TJhxtm', 'bobkovsergeyarkadevich@gmail.com', 0, 'https://i.imgur.com/kcLu8VU.jpg');

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
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `password_tokens`
--
ALTER TABLE `password_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT для таблицы `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `password_tokens`
--
ALTER TABLE `password_tokens`
  ADD CONSTRAINT `password_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
