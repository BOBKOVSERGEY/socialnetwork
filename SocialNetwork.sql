-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 05 2018 г., 21:04
-- Версия сервера: 5.7.16
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(1, 'ba42c643a0333c66502bd93e1b919cba03ebc57f', 8),
(2, 'a4c79db1a7f806c1aaf3a10d7bd86a447fbf309c', 8),
(3, 'd9605d812b6368c8cbcd6bbf9126e972c6741a69', 8),
(4, 'ea7eeafce284e31a7381da46e42b1ed529a104f6', 8),
(5, 'd2de8773c472a34912c2cd0a5881577851131d54', 8),
(6, 'eec650aa19d842898cabf6d91d7b3c1310e3b30b', 8),
(7, '91ed4fad9a5790be0c312f3adb21288c1d7f51e4', 8),
(8, '2d92067a148d6466140205a7bd95c7966376e11e', 8),
(9, 'd75beaf7fc7be2c4e656cdca5808faaecb980194', 8),
(10, 'd29bf1b29c5427fbb721abb6167e1eb7057154b1', 8),
(11, 'a156691aa76b4740a861bcf23a37ab7b9f4c18f0', 8),
(12, 'cc786ec631f235cc15e674c3766db6de4880b10b', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'advocat', '1234', 'sergey_bobkov@inbox.ru'),
(2, 'Sergeykira', '123456', 'pochta@pktitan.ru'),
(3, 'admin_advokat', '123456', 'taran.kira@rambler.ru'),
(4, 'advocat', '1234', 'pochta@pktitan.ru'),
(5, 'admin_advokat', '123', 'taran.kira@rambler.ru'),
(6, 'name', '1234', 'name@name.ru'),
(7, 'username1', '$2y$10$qaK7aP.tp66ASemSfDp0HeQkohA4j2F/0QxXZYWBYzA76UvOHmdZ6', 'sergey_bobkov@inbox.ru'),
(8, 'Sergey', '$2y$10$htQWSmEeyI/qDvTjbfgI2OmHUP8XbDxVEdR1iv7bePbDl1JWWuCJa', 'sergey_bobkov@inbox.ru'),
(9, 'Sergey1', '$2y$10$CCi4Md.RCxVqxtMK.41Jmeb8dX4daYDvkl3feDdTdk/5ugmHXattO', 'sergey_bobkov1@inbox.ru');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
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
-- AUTO_INCREMENT для таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
