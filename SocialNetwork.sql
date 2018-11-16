-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 16 2018 г., 17:12
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
(16, 'Hello Vika', 12, '2018-11-16 17:01:46', 12);

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
(26, 12, 8);

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
(29, 'f1bc97cdb665de609914a20d83180029ed5e76f3', 8);

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
  `likes` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `body`, `posted_at`, `user_id`, `likes`) VALUES
(1, 'Hello world!', '2018-11-13 15:39:28', 12, 0),
(5, 'alert(\'hello)', '2018-11-13 15:49:45', 12, 0),
(6, '&lt;?php echo \'hello\';?&gt;\r\n&lt;script&gt;alert(\'hello)&lt;/script&gt;', '2018-11-13 15:51:19', 12, 0),
(7, 'alert(\'hello)', '2018-11-13 15:57:33', 12, 0),
(8, 'alert(\'hello)', '2018-11-13 15:59:21', 12, 0),
(9, 'alert(\'hello)', '2018-11-13 16:02:33', 12, 2),
(10, 'e', '2018-11-13 16:02:53', 12, 1),
(11, 'hello', '2018-11-14 12:41:53', 16, 1),
(12, 'some', '2018-11-14 12:43:22', 16, 6),
(13, 'new', '2018-11-14 13:21:35', 16, 1),
(14, 'rrrrrrrrrrrrr', '2018-11-14 13:29:27', 16, 1),
(15, 'rrrrrrrrrrrrr', '2018-11-14 13:42:29', 16, 0),
(16, 'rrrrrrrrrrrrr', '2018-11-14 13:42:32', 16, 1),
(17, 'eeeeeeeeeeee', '2018-11-14 14:29:13', 16, 0),
(18, 'eeeeeeeeeeee', '2018-11-14 14:29:23', 16, 0),
(19, 'eeeeeeeeeee', '2018-11-14 14:30:28', 16, 0),
(20, 'd', '2018-11-14 14:30:35', 16, 1),
(21, 'some new', '2018-11-14 14:32:20', 8, 0),
(22, 'New post from Post.php', '2018-11-15 13:51:02', 8, 0),
(23, 'New post from Post.php', '2018-11-15 13:51:17', 8, 1),
(24, 'fffffffffffff', '2018-11-15 13:53:54', 8, 1),
(25, 'some', '2018-11-15 13:54:43', 8, 1),
(26, 'some yet', '2018-11-15 14:12:36', 8, 2),
(27, 'already', '2018-11-15 14:17:57', 8, 0),
(28, 'e', '2018-11-16 16:35:03', 8, 0),
(29, 'eeeeeeeeeee', '2018-11-16 16:57:57', 12, 0),
(30, 'Все привет', '2018-11-16 16:59:32', 12, 0);

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
(8, 13, 16),
(9, 10, 12),
(10, 9, 12),
(15, 11, 16),
(32, 16, 16),
(34, 14, 16),
(37, 9, 16),
(38, 20, 16),
(48, 23, 8),
(52, 26, 8),
(53, 25, 8),
(54, 24, 8),
(68, 26, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `email` text NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `verified`) VALUES
(8, 'Sergey', '$2y$10$Sb7DtRyvi5YDTlD.zOWJUOPsP81Oa.4xzcT31mjNB0odisPeteROK', 'sergey_bobkov@inbox.ru', 1),
(10, 'Kira', '$2y$10$bgA2eRCAWdZlYAoSmEuYPOiOEOTclzeMXgzv7DwYoMg3reVZT0tO2', 'taran.kira@rambler.ru', 1),
(12, 'Vasy', '$2y$10$jW.yZeVrrpuSMvF86jBViOJRr8HP097awdd4Easf2Rd6hKsR9R9zS', 'pochta@pktitan.ru', 0),
(13, 'Vasy1', '$2y$10$tuTAsY15oKrhzxpQkLci5ujXNnGXVTXse1ZxkspxXiOZ4g7pqjHO.', 'pochta1@pktitan.ru', 0),
(14, 'Verified', '$2y$10$ShpIEeTLaipYTA6N4uoXhupgmE.FZqeIXtjinZy6VzcgG4GBTBD6.', 'verified@gmail.com', 0),
(15, 'alert(\'hello)', '$2y$10$Z7bgQ5XEEup7wNh9T5LnJO5N.Rm9S4HYy/kqNBGX7CguZwPfL/Vke', 'vzlk@yandex.ru', 0),
(16, 'Vika', '$2y$10$fVKElmVNUMZsfiPobHr4UuUZYge5Jf.FPSm18C39bu.NzCvFxGslK', 'pktitanseo@yandex.ru', 0);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `password_tokens`
--
ALTER TABLE `password_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

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
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
