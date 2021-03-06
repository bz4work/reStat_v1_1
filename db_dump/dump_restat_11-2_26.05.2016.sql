-- --------------------------------------------------------
-- Сервер:                       localhost
-- Версія сервера:               5.7.11-log - MySQL Community Server (GPL)
-- ОС сервера:                   Win32
-- HeidiSQL Версія:              9.3.0.5062
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for restat_11-2
CREATE DATABASE IF NOT EXISTS `restat_11-2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `restat_11-2`;

-- Dumping structure for таблиця restat_11-2.group
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` char(255) NOT NULL DEFAULT '0',
  `access_level` int(11) NOT NULL,
  KEY `Індекс 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table restat_11-2.group: ~2 rows (приблизно)
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` (`id`, `group_name`, `access_level`) VALUES
	(1, 'admin', 0),
	(2, 'users', 0);
/*!40000 ALTER TABLE `group` ENABLE KEYS */;

-- Dumping structure for таблиця restat_11-2.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table restat_11-2.permissions: ~2 rows (приблизно)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id_user`, `id_group`) VALUES
	(1, 1),
	(1, 1);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for таблиця restat_11-2.refill
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='данные о заправках';

-- Dumping data for table restat_11-2.refill: ~4 rows (приблизно)
/*!40000 ALTER TABLE `refill` DISABLE KEYS */;
INSERT INTO `refill` (`id`, `id_user`, `date`, `time`, `odometr`, `total_sum`, `total_liters`, `price_gas`, `fuel_type`) VALUES
	(48, 2, '2016-05-25', '19:19:23', 1, 1, 1, 1, NULL),
	(49, 2, '2016-05-25', '19:20:20', 11, 111, 11, 111, NULL),
	(50, 2, '2016-05-25', '19:20:49', 1, 1, 1, 1, NULL),
	(51, 2, '2016-05-25', '21:19:38', 1, 1, 1, 1, NULL),
	(52, 2, '2016-05-25', '21:19:38', 7, 7, 7, 7, NULL);
/*!40000 ALTER TABLE `refill` ENABLE KEYS */;

-- Dumping structure for таблиця restat_11-2.total_km
CREATE TABLE IF NOT EXISTS `total_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_refill` int(11) DEFAULT NULL,
  `sumkm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Dumping data for table restat_11-2.total_km: ~27 rows (приблизно)
/*!40000 ALTER TABLE `total_km` DISABLE KEYS */;
INSERT INTO `total_km` (`id`, `id_refill`, `sumkm`) VALUES
	(1, NULL, 96),
	(2, NULL, 88),
	(3, NULL, 136),
	(4, NULL, 232),
	(5, NULL, 328),
	(6, NULL, 424),
	(7, NULL, 520),
	(8, NULL, 616),
	(9, NULL, 712),
	(10, NULL, 808),
	(11, NULL, 904),
	(12, NULL, 1000),
	(13, NULL, 1096),
	(14, NULL, 1192),
	(15, NULL, 1288),
	(16, NULL, 1384),
	(17, NULL, 1528),
	(18, NULL, 1636),
	(19, NULL, 1732),
	(20, NULL, 1828),
	(21, NULL, 1976),
	(22, NULL, 2076),
	(23, NULL, 2258),
	(24, NULL, 2569),
	(25, NULL, 96),
	(26, NULL, 271),
	(27, NULL, 190);
/*!40000 ALTER TABLE `total_km` ENABLE KEYS */;

-- Dumping structure for таблиця restat_11-2.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `activated` tinyint(3) unsigned DEFAULT '1' COMMENT 'активация акк. Если 1 - активирован, если 0 - нет',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table restat_11-2.users: ~2 rows (приблизно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `hash`, `activated`) VALUES
	(1, 'slava', 'test', 'adm@i.ua', NULL, 0),
	(2, 'test', 'aaa', 'aaa@a.ua', NULL, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
