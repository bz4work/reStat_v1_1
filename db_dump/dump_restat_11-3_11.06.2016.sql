-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.10-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win64
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных restat_11-3
CREATE DATABASE IF NOT EXISTS `restat_11-3` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `restat_11-3`;


-- Дамп структуры для таблица restat_11-3.group
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` char(255) NOT NULL DEFAULT '0',
  `access_level` int(11) NOT NULL,
  KEY `Індекс 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.group: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` (`id`, `group_name`, `access_level`) VALUES
	(1, 'admin', 0),
	(2, 'users', 0);
/*!40000 ALTER TABLE `group` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.name_intervals
CREATE TABLE IF NOT EXISTS `name_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `status` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.name_intervals: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `name_intervals` DISABLE KEYS */;
INSERT INTO `name_intervals` (`id`, `id_user`, `name`, `status`) VALUES
	(6, 2, 'Замена дворников', 1),
	(7, 2, 'Замена масла КПП', 1);
/*!40000 ALTER TABLE `name_intervals` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.permissions: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id_user`, `id_group`) VALUES
	(1, 1),
	(1, 1);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.refill
CREATE TABLE IF NOT EXISTS `refill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `odometr` int(11) DEFAULT NULL,
  `total_sum` float DEFAULT NULL,
  `total_liters` float DEFAULT NULL,
  `price_gas` float DEFAULT NULL,
  `fuel_type` char(50) DEFAULT NULL,
  `id_zapravki` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='данные о заправках';

-- Дамп данных таблицы restat_11-3.refill: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `refill` DISABLE KEYS */;
INSERT INTO `refill` (`id`, `id_user`, `date`, `time`, `odometr`, `total_sum`, `total_liters`, `price_gas`, `fuel_type`, `id_zapravki`) VALUES
	(6, 2, '2016-01-01', '23:11:00', 100000, 100, 13, 7.69, 'test', 'test'),
	(25, 2, '2016-06-06', '13:32:00', 159789, 100, 13, 7.69, 'test2', 'test2'),
	(31, 2, '2016-06-09', '14:47:00', 333, 3, 3, 3, 'gas', ''),
	(32, 2, '2016-06-09', '14:53:00', 4, 4, 4, 4, 'gas', ''),
	(33, 2, '2016-06-09', '14:55:00', 5, 5, 5, 5, 'gas', ''),
	(34, 2, '2016-06-09', '14:56:00', 6, 6, 6, 6, 'gas', ''),
	(35, 2, '2016-06-09', '15:00:00', 99, 9, 9, 9, 'gas', ''),
	(43, 2, '2016-06-09', '16:02:00', 333, 200, 26.01, 7.69, 'gas', ''),
	(44, 2, '2016-06-09', '16:12:00', 444, 200, 26.01, 7.69, 'gas', ''),
	(45, 2, '2016-06-09', '16:35:00', 777, 100, 13, 7.69, 'gas', ''),
	(47, 1, '2016-06-09', '17:24:00', 159159, 200, 26.01, 7.69, 'gas', ''),
	(48, 1, '2016-06-09', '17:26:00', 1555, 200, 26.01, 7.69, 'gas', '');
/*!40000 ALTER TABLE `refill` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.service_intervals
CREATE TABLE IF NOT EXISTS `service_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `date_add` date DEFAULT NULL,
  `time_add` time DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `start_odo` int(10) unsigned DEFAULT NULL,
  `interval` int(10) unsigned DEFAULT NULL,
  `finish_odo` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `interval_days` int(10) unsigned DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `notify` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.service_intervals: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `service_intervals` DISABLE KEYS */;
INSERT INTO `service_intervals` (`id`, `id_user`, `date_add`, `time_add`, `name`, `start_odo`, `interval`, `finish_odo`, `start_date`, `interval_days`, `finish_date`, `comment`, `notify`) VALUES
	(47, 2, '2016-12-31', '23:22:00', '6', 10, 100, 0, NULL, NULL, NULL, '', 0);
/*!40000 ALTER TABLE `service_intervals` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.settings_name
CREATE TABLE IF NOT EXISTS `settings_name` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.settings_name: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `settings_name` DISABLE KEYS */;
INSERT INTO `settings_name` (`id`, `name`) VALUES
	(1, 'fuel_economy'),
	(2, 'main_fuel_type'),
	(3, 'stack_fuel_type');
/*!40000 ALTER TABLE `settings_name` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.total_km
CREATE TABLE IF NOT EXISTS `total_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_refill` int(11) DEFAULT NULL,
  `sumkm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.total_km: ~30 rows (приблизительно)
/*!40000 ALTER TABLE `total_km` DISABLE KEYS */;
INSERT INTO `total_km` (`id`, `id_user`, `id_refill`, `sumkm`) VALUES
	(1, 0, NULL, 96),
	(2, 0, NULL, 88),
	(3, 0, NULL, 136),
	(4, 0, NULL, 232),
	(5, 0, NULL, 328),
	(6, 0, NULL, 424),
	(7, 0, NULL, 520),
	(8, 0, NULL, 616),
	(9, 0, NULL, 712),
	(10, 0, NULL, 808),
	(11, 0, NULL, 904),
	(12, 0, NULL, 1000),
	(13, 0, NULL, 1096),
	(14, 0, NULL, 1192),
	(15, 0, NULL, 1288),
	(16, 0, NULL, 1384),
	(17, 0, NULL, 1528),
	(18, 0, NULL, 1636),
	(19, 0, NULL, 1732),
	(20, 0, NULL, 1828),
	(21, 0, NULL, 1976),
	(22, 0, NULL, 2076),
	(23, 0, NULL, 2258),
	(24, 0, NULL, 2569),
	(25, 0, NULL, 96),
	(26, 0, NULL, 271),
	(27, 2, NULL, 190),
	(30, 1, NULL, 0),
	(31, 1, NULL, 260),
	(32, 1, NULL, 520);
/*!40000 ALTER TABLE `total_km` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `activated` tinyint(3) unsigned DEFAULT '1' COMMENT 'активация акк. Если 1 - активирован, если 0 - нет',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.users: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `hash`, `activated`) VALUES
	(1, 'slava', '$2umG6Dyp7oSc', 'adm@i.ua', NULL, 1),
	(2, 'test', '$2LG2ab3mUN7Y', 'aaa@a.ua', NULL, 1),
	(58, 'qwerty', '$27EjMsMs.bxk', 'slava@topcar.ua', NULL, 1),
	(60, 'test1', '$24gPKpWgK/AY', 'test2@i.ua1', NULL, 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.user_settings
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `id_setting` int(11) unsigned NOT NULL,
  `value` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.user_settings: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;
INSERT INTO `user_settings` (`id`, `id_user`, `id_setting`, `value`) VALUES
	(1, 2, 1, '13'),
	(2, 2, 2, 'gas'),
	(3, 1, 2, 'gas'),
	(4, 1, 1, '10');
/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
