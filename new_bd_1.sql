-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Мар 04 2023 г., 11:28
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `new_bd_1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `shift_workers` varchar(255) NOT NULL,
  `create_at` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `id_shift` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `table_number`, `shift_workers`, `create_at`, `status`, `price`, `id_shift`) VALUES
(7, 1, 'Sheida', '04.03.2023 11:20:01', 'Принят', 0, 3),
(8, 4, 'Sheida', '04.03.2023 11:20:48', 'Принят', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'working',
  `group` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `token`, `status`, `group`) VALUES
(4, 'Love', 'Sheida', 'Love@gmail.com', 'Love321', ' ', 'working', 'официант'),
(5, 'Maksim', 'Petrov', 'Markus@root.com', 'Maks222', ' ', 'working', 'Waiter'),
(6, 'Michel', 'Sidorov', 'Markus@root.com', 'MITC555', ' ', 'working', 'Waiter'),
(7, 'Kirill', 'Komarov', 'Kir.Komarov@yandex.ru', 'SyPePASs123', ' ', 'working', 'Admin');

-- --------------------------------------------------------

--
-- Структура таблицы `work_shift`
--

CREATE TABLE `work_shift` (
  `id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'false',
  `id_user` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `work_shift`
--

INSERT INTO `work_shift` (`id`, `start`, `end`, `active`, `id_user`, `status`) VALUES
(3, '2023-03-02 13:00:00', '2023-03-02 18:00:00', 'true', '4', 'added'),
(6, '2023-03-05 13:00:00', '2023-03-05 18:00:00', 'false', '5', 'added'),
(7, '2023-03-05 13:00:00', '2023-03-05 18:00:00', 'false', '0', ''),
(10, '2023-03-20 08:00:00', '2023-03-20 16:00:00', 'false', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `work_shift`
--
ALTER TABLE `work_shift`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `work_shift`
--
ALTER TABLE `work_shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
