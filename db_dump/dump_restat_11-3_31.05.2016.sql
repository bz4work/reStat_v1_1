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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='данные о заправках';

-- Дамп данных таблицы restat_11-3.refill: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `refill` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.service_intervals: ~24 rows (приблизительно)
/*!40000 ALTER TABLE `service_intervals` DISABLE KEYS */;
INSERT INTO `service_intervals` (`id`, `id_user`, `date_add`, `time_add`, `name`, `start_odo`, `interval`, `finish_odo`, `start_date`, `interval_days`, `finish_date`, `comment`, `notify`) VALUES
	(47, 2, '2016-12-31', '23:22:00', '6', 10, 100, 0, NULL, NULL, NULL, '', 0),
	(50, 2, '0000-00-00', '00:00:00', '', 1111, 0, 0, NULL, NULL, NULL, '', 0),
	(51, 2, '0000-00-00', '00:00:00', '', 222, 0, 0, NULL, NULL, NULL, '', 0),
	(52, 2, '0000-00-00', '00:00:00', '', 111, 0, 0, NULL, NULL, NULL, '', 0),
	(53, 2, '0000-00-00', '00:00:00', '', 1, 0, 0, NULL, NULL, NULL, '', 0),
	(54, 2, '0000-00-00', '00:00:00', '', 555, 0, 0, NULL, NULL, NULL, '', 0),
	(55, 2, '0000-00-00', '00:00:00', '6', 12121, 12121, 12121, NULL, NULL, NULL, '12121', 0),
	(56, 2, '2016-05-31', '00:00:00', '', 999, 0, 0, NULL, NULL, NULL, '', 0),
	(57, 2, '2016-05-31', '18:12:00', '', 777, 0, 0, NULL, NULL, NULL, '', 0),
	(62, 2, '2016-05-31', '18:46:00', '7', NULL, NULL, NULL, '2016-12-31', 90, '2016-08-29', '', 0),
	(63, 2, '2016-05-31', '19:07:00', '7', NULL, NULL, NULL, '2016-12-20', 5, '0000-00-00', '', 0),
	(64, 2, '2016-05-31', '19:10:00', '7', NULL, NULL, NULL, '2016-12-20', 20, '0000-00-00', '', 0),
	(65, 2, '2016-05-31', '19:13:00', '7', NULL, NULL, NULL, '2000-01-20', 1, '0000-00-00', '', 0),
	(66, 2, '2016-05-31', '19:15:00', '6', NULL, NULL, NULL, '2000-01-20', 1, '2000-01-21', '', 0),
	(67, 2, '2016-05-31', '19:17:00', '6', NULL, NULL, NULL, '2000-01-20', 90, '2000-04-19', '', 0),
	(68, 2, '2016-05-31', '19:18:00', '7', 1500, 500, 0, NULL, NULL, NULL, '', 0),
	(69, 2, '2016-05-31', '19:20:00', '7', NULL, NULL, NULL, '2000-01-20', 5, '2000-01-25', '', 0),
	(70, 2, '2016-05-31', '19:20:00', '7', NULL, NULL, NULL, '2000-01-20', 365, '2001-01-19', '', 0),
	(71, 2, '2016-05-31', '19:28:00', '7', 1500, 10000, 11500, NULL, NULL, NULL, '', 0),
	(72, 2, '2016-05-31', '19:29:00', '7', 734000, 90000, 824000, NULL, NULL, NULL, '', 0),
	(73, 2, '2016-05-31', '19:30:00', '7', 980000, 25000, 1005000, NULL, NULL, NULL, '', 0),
	(74, 2, '2016-05-31', '19:38:00', 'error', NULL, NULL, NULL, '0000-00-00', 0, '1970-01-01', '', 0),
	(75, 2, '2016-05-31', '19:39:00', 'error', 15151, 10, 15161, NULL, NULL, NULL, '', 0),
	(76, 2, '2016-05-31', '19:42:00', '7', 1, 1, 2, NULL, NULL, NULL, '', 0);
/*!40000 ALTER TABLE `service_intervals` ENABLE KEYS */;


-- Дамп структуры для таблица restat_11-3.total_km
CREATE TABLE IF NOT EXISTS `total_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_refill` int(11) DEFAULT NULL,
  `sumkm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.total_km: ~27 rows (приблизительно)
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
	(27, 2, NULL, 190);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы restat_11-3.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `hash`, `activated`) VALUES
	(1, 'slava', 'test', 'adm@i.ua', NULL, 0),
	(2, 'test', 'aaa', 'aaa@a.ua', NULL, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
