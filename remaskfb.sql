-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 02 2020 г., 10:06
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dvrdmtr_remask`
--

-- --------------------------------------------------------

--
-- Структура таблицы `remaskfb`
--
-- Создание: Фев 12 2020 г., 16:51
-- Последнее обновление: Мар 02 2020 г., 06:02
--

DROP TABLE IF EXISTS `remaskfb`;
CREATE TABLE `remaskfb` (
  `id` mediumint(9) NOT NULL,
  `name` char(30) NOT NULL,
  `token` text,
  `action` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `remaskfb`
--

INSERT INTO `remaskfb` (`id`, `name`, `token`, `action`) VALUES
(49, '1-getsize-r.pat', 'EAABsbCS1iHgBADbR61arnm2ZBg4RVHlkiWZA9YI2ZCQznZBOQbZAa5kN6sp2lGs1hdIfErw7GlZBeDS3mrEQ9uAtYWf9AHQhE4UFaZCEZCLqbcTtvbW1A8Op5dQDYAd248x9RJY1oecJrahjKFYlvky5TvcgQwTtiuA30uHyAp7MtNqhCSsChgBf', 'DELETE'),
(50, '1-indigo-shopify-test', 'EAABsbCS1iHgBAIzd9YXZBJPFsNoQpDfrfEyvgT282OBrGo795BwTFcump1cgNKEqRSaZAw3ZBtMZAlq68aVCMC34jMOBcYFnRkSgvZBhZAmoxFcJmzacxiV1AmHENl1IOn6UqdjKYabKIOtbZC23R8z6RRoLzFZAZCcCqwSZCflxv8EgZDZD', 'DELETE');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `remaskfb`
--
ALTER TABLE `remaskfb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `remaskfb`
--
ALTER TABLE `remaskfb`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
