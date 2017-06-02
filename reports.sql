-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 02 2017 г., 09:29
-- Версия сервера: 5.5.50-0+deb8u1-log
-- Версия PHP: 5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `reports`
--

-- --------------------------------------------------------

--
-- Структура таблицы `etth`
--

CREATE TABLE IF NOT EXISTS `etth` (
`id` int(11) NOT NULL,
  `street` text COLLATE utf8_unicode_ci NOT NULL,
  `home` text COLLATE utf8_unicode_ci NOT NULL,
  `abon` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` text COLLATE utf8_unicode_ci NOT NULL,
  `model` text COLLATE utf8_unicode_ci NOT NULL,
  `port` int(2) NOT NULL,
  `count_down` int(6) NOT NULL,
  `date` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=159055 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `jpon`
--

CREATE TABLE IF NOT EXISTS `jpon` (
`id` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `hostname` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mac`
--

CREATE TABLE IF NOT EXISTS `mac` (
`id` int(10) NOT NULL,
  `ontSerial` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7054 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ont`
--

CREATE TABLE IF NOT EXISTS `ont` (
`id` int(11) NOT NULL,
  `id_device` int(11) NOT NULL,
  `ontSlot` int(2) NOT NULL,
  `ontSerial` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `ontChannel` int(2) NOT NULL,
  `ontId` int(3) NOT NULL,
  `ontState` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ontRssi` float NOT NULL,
  `ontRxPower` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `ontDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3926 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `etth`
--
ALTER TABLE `etth`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `jpon`
--
ALTER TABLE `jpon`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Индексы таблицы `mac`
--
ALTER TABLE `mac`
 ADD PRIMARY KEY (`id`), ADD KEY `ontSerial` (`ontSerial`), ADD KEY `mac` (`mac`);

--
-- Индексы таблицы `ont`
--
ALTER TABLE `ont`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `etth`
--
ALTER TABLE `etth`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=159055;
--
-- AUTO_INCREMENT для таблицы `jpon`
--
ALTER TABLE `jpon`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT для таблицы `mac`
--
ALTER TABLE `mac`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7054;
--
-- AUTO_INCREMENT для таблицы `ont`
--
ALTER TABLE `ont`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3926;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
