-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table project_tools.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(45) NOT NULL,
  `role` varchar(45) NOT NULL,
  `created-at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.admin: 1 rows
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`, `email`, `role`, `created-at`) VALUES
	(1, 'nuralam', '698d51a19d8a121ce581499d7b701668', 'nuralam862@gmail.com', 'admin', '2018-11-23 16:22:12');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table project_tools.msgs
CREATE TABLE IF NOT EXISTS `msgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `read` tinyint(4) DEFAULT '0',
  `msg` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.msgs: ~3 rows (approximately)
/*!40000 ALTER TABLE `msgs` DISABLE KEYS */;
INSERT INTO `msgs` (`id`, `from`, `to`, `read`, `msg`, `created_at`) VALUES
	(1, '1', '1', 0, 'hey pops', '2018-11-26 14:11:04'),
	(2, '1', '2', 0, 'ya pups', '2018-11-26 14:11:20'),
	(3, '1', '2', 0, 'hey new msg', '2018-11-26 14:13:27');
/*!40000 ALTER TABLE `msgs` ENABLE KEYS */;

-- Dumping structure for table project_tools.projectpeoples
CREATE TABLE IF NOT EXISTS `projectpeoples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `project_id` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.projectpeoples: 0 rows
/*!40000 ALTER TABLE `projectpeoples` DISABLE KEYS */;
/*!40000 ALTER TABLE `projectpeoples` ENABLE KEYS */;

-- Dumping structure for table project_tools.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `projectName` varchar(100) NOT NULL,
  `projectDeadline` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customerName` varchar(45) NOT NULL,
  `customerPhone` varchar(45) NOT NULL,
  `customerEmail` varchar(45) NOT NULL,
  `projectDescription` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.projects: 2 rows
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `user_id`, `projectName`, `projectDeadline`, `customerName`, `customerPhone`, `customerEmail`, `projectDescription`, `created_at`) VALUES
	(1, 1, 'new project', '2018-11-08 00:00:00', 'nuralam', '01737867700', 'nuralam862@gmail.com', 'Conveniently visualize intermandated content through principle-centered ideas. Monotonectally implement extensive materials without emerging paradigms.', '2018-11-25 17:12:11'),
	(2, 222, 'project name', '2018-11-25 19:27:46', 'customer name', 'customer phone', 'customer email', 'project desc', '2018-11-25 19:27:46');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Dumping structure for table project_tools.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(255) NOT NULL,
  `taskName` varchar(45) NOT NULL,
  `requirement` tinytext NOT NULL,
  `progress` varchar(45) NOT NULL,
  `priority` varchar(45) NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.tasks: 0 rows
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Dumping structure for table project_tools.tasktopeople
CREATE TABLE IF NOT EXISTS `tasktopeople` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `task_id` int(255) NOT NULL,
  `project_id` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.tasktopeople: 0 rows
/*!40000 ALTER TABLE `tasktopeople` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasktopeople` ENABLE KEYS */;

-- Dumping structure for table project_tools.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `role` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table project_tools.users: 2 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
	(1, 'nuralam', 'nuralam862@gmail.com', '698d51a19d8a121ce581499d7b701668', 'project_manager', '2018-11-23 22:15:54'),
	(2, 'faysal', 'faysal862@gmail.com', '698d51a19d8a121ce581499d7b701668', 'employee', '2018-11-23 16:18:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
