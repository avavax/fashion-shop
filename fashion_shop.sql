-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 19 2020 г., 14:06
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fashion_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(256) NOT NULL,
  `slug` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `title`, `slug`) VALUES
(1, 'Женщины', 'women'),
(2, 'Мужчины', 'men'),
(3, 'Дети', 'children'),
(4, 'Аксессуары', 'accessories');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(256) NOT NULL,
  `delivery` varchar(16) NOT NULL,
  `pay` varchar(16) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `email` varchar(256) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `address` varchar(256) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `product` int(11) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `fullname`, `delivery`, `pay`, `status`, `email`, `phone`, `address`, `comment`, `product`, `date`) VALUES
(2, 'Петров Илья Петрович', 'dev-yes', 'cash', 1, 'email@emai.ru', '+799999999', 'Псков Ленина 1 1', 'Когда б вы знали из какого сора растут стихи не ведая стыда', 5, '2020-08-16 18:11:16'),
(4, 'Иван Иванов Иваныч', 'dev-no', 'cash', 0, 'email@mail.ru', '+7888888888888', NULL, NULL, 1, '2020-08-17 06:53:20'),
(5, 'Амалия Балабкина ', 'dev-yes', '0', 0, 'email@email.ru', '+788888888', 'г.Чебоксары ул.Ленина 12-13', 'О как любил я вас! И так любил, и этак...', 6, '2020-08-18 19:44:03'),
(9, 'Валленштейн Элеонора ', 'dev-no', 'card', 1, 'admin@mail.ru', '+788888888', NULL, NULL, 2, '2020-08-19 06:34:32');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(64) NOT NULL,
  `title` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `sale` tinyint(1) NOT NULL DEFAULT 0,
  `new` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `image`, `title`, `price`, `sale`, `new`) VALUES
(1, 'product-1.jpg', 'Белое платье со складками', 1800, 0, 1),
(2, 'product-2.jpg', 'Клетчатая рубашка', 2100, 1, 0),
(3, 'product-3.jpg', 'Красивые китайские часы', 4250, 0, 1),
(4, 'product-4.jpg', 'Разноцветные полосатые штаны с длинным названием в несколько строчек', 1200, 0, 0),
(5, 'product-5.jpg', 'Сумка женская коричневая', 830, 1, 0),
(6, 'product-6.jpg', 'Красное платье летнее', 3200, 1, 0),
(7, 'product-7.jpg', 'Кофта женская розовая', 1790, 1, 1),
(11, 'product-8.jpg', 'Джинсы синие укороченные', 2900, 0, 1),
(12, 'product-9.jpg', 'Ботинки коричневые женские', 900, 1, 1),
(13, 'product-10.jpg', 'Мужской костюм с отливом', 3700, 1, 0),
(45, 'child_siut.jpg', 'Детский костюм тройка', 3100, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(5, 1),
(5, 4),
(6, 1),
(7, 1),
(11, 1),
(12, 1),
(13, 2),
(45, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(128) NOT NULL,
  `dt_add` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`session_id`, `user_id`, `token`, `dt_add`) VALUES
(12, 1, '73ed95df7c18a8312d64452bd36403cc198ee93059e8fff9e0f671996891bf35af83e0c9da59eca97abfd3117859f090116d9d4ad78808c0321bc8aebe625d6b', '2020-08-19 11:05:19');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `status`) VALUES
(1, 'admin@mail.ru', '$2y$10$vOOIexk3kBLzdWmNuy3K8ueC8uIj3iB7t6DQ.00GS/IyQhVNBat.G', 'admin'),
(2, 'operator@mail.ru', '$2y$10$vOOIexk3kBLzdWmNuy3K8ueC8uIj3iB7t6DQ.00GS/IyQhVNBat.G', 'operator');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product` (`product`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`product_id`);

--
-- Ограничения внешнего ключа таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
