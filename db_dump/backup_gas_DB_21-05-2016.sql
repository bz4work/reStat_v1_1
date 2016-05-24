-- --------------------------------------------------------
-- Сервер:                       192.168.1.11
-- Версія сервера:               5.5.49-0ubuntu0.12.04.1 - (Ubuntu)
-- ОС сервера:                   debian-linux-gnu
-- HeidiSQL Версія:              9.3.0.5062
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for gas
CREATE DATABASE IF NOT EXISTS `gas` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gas`;

-- Dumping structure for таблиця gas.group
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` char(255) NOT NULL DEFAULT '0',
  `access_level` int(11) NOT NULL,
  KEY `Індекс 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table gas.group: ~2 rows (приблизно)
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` (`id`, `group_name`, `access_level`) VALUES
	(1, 'admin', 0),
	(2, 'users', 0);
/*!40000 ALTER TABLE `group` ENABLE KEYS */;

-- Dumping structure for таблиця gas.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id_user` int(11) NOT NULL,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table gas.permissions: ~1 rows (приблизно)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id_user`, `group`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for таблиця gas.refill
CREATE TABLE IF NOT EXISTS `refill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `odometr` int(11) DEFAULT NULL,
  `total_sum` float DEFAULT NULL,
  `total_liters` float DEFAULT NULL,
  `price_gas` float DEFAULT NULL,
  `fuel_type` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='данные о заправках';

-- Dumping data for table gas.refill: ~26 rows (приблизно)
/*!40000 ALTER TABLE `refill` DISABLE KEYS */;
INSERT INTO `refill` (`id`, `id_user`, `date`, `time`, `odometr`, `total_sum`, `total_liters`, `price_gas`, `fuel_type`) VALUES
	(2, 1, 1459890000, 943958075, 156537, 100, 11.93, 8.38, NULL),
	(3, 1, 1459976400, 943958205, 156616, 50, 6.5, 7.69, NULL),
	(4, 1, 1460062800, 943958263, 156676, 100, 13, 7.69, NULL),
	(5, 1, 1460235600, 943958429, 156763, 100, 13, 7.69, NULL),
	(6, 1, 1460408400, 943958463, 156867, 100, 13, 7.69, NULL),
	(7, 1, 1460494800, 943958486, 156950, 100, 13, 7.69, NULL),
	(8, 2, 1460581200, 943958513, 157051, 100, 13, 7.69, NULL),
	(9, NULL, 1460667600, 943958644, 157140, 100, 13, 7.69, NULL),
	(10, NULL, 1460754000, 943958689, 157250, 100, 13, 7.69, NULL),
	(11, NULL, 1460926800, 943958714, 157352, 100, 13, 7.69, NULL),
	(12, NULL, 1461099600, 943958741, 157448, 100, 13, 7.69, NULL),
	(13, NULL, 1461272400, 943958768, 157538, 100, 13, 7.69, NULL),
	(14, NULL, 1461531600, 943958796, 157640, 100, 13, 7.69, NULL),
	(15, NULL, 1461704400, 943958826, 157755, 100, 13, 7.69, NULL),
	(16, NULL, 1461790800, 943958849, 157844, 100, 13, 7.69, NULL),
	(17, NULL, 1461963600, 943970494, 157957, 149, 19.38, 7.69, NULL),
	(18, NULL, 1462136400, 943983387, 158062, 112, 14.56, 7.69, NULL),
	(19, NULL, 1462222800, 943975354, 158181, 100, 13, 7.69, NULL),
	(20, NULL, 1462395600, 943977039, 158292, 100, 13, 7.69, NULL),
	(21, NULL, 1462654800, 943956299, 158437, 154, 20.03, 7.69, NULL),
	(22, NULL, 1462654800, 943968396, 158677, 100, 13.51, 7.4, NULL),
	(23, NULL, 1462741200, 943956503, 158828, 178, 24.55, 7.25, NULL),
	(24, NULL, 1462741200, 943975255, 159012, 100, 13, 7.69, NULL),
	(25, NULL, 1463000400, 943968623, 159163, 100, 13, 7.69, NULL),
	(26, NULL, 1463173200, 943961453, 159253, 182, 23.67, 7.69, NULL),
	(27, NULL, 1463605200, 943973733, 159424, 197, 25.62, 7.69, NULL);
/*!40000 ALTER TABLE `refill` ENABLE KEYS */;

-- Dumping structure for таблиця gas.total_km
CREATE TABLE IF NOT EXISTS `total_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_refill` int(11) DEFAULT NULL,
  `sumkm` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Dumping data for table gas.total_km: ~27 rows (приблизно)
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

-- Dumping structure for таблиця gas.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table gas.users: ~2 rows (приблизно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `hash`) VALUES
	(1, 'slava', 'test', 'adm@i.ua', NULL),
	(2, 'test', 'aaa', 'aaa@a.ua', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
