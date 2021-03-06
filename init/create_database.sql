# ************************************************************
# Sequel Ace SQL dump
# Version 20021
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 192.254.231.77 (MySQL 5.6.41-84.1)
# Database: movie_night_stats
# Generation Time: 2022-01-09 03:57:23 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table dice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dice`;

CREATE TABLE `dice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


# Dump of table films
# ------------------------------------------------------------

DROP TABLE IF EXISTS `films`;

CREATE TABLE `films` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `image` text,
  `tomatometer` int(11) DEFAULT NULL,
  `rt_audience` int(11) DEFAULT NULL,
  `imdb` int(11) DEFAULT NULL,
  `metacritic` int(11) DEFAULT NULL,
  `meta_userscore` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `type` text,
  `runtime` int(11) DEFAULT NULL,
  `MPAA` text,
  `first_instance` date DEFAULT NULL,
  `last_instance` date DEFAULT NULL,
  `imdb_id` text,
  `poster_url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Dump of table options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;

INSERT INTO `options` (`id`, `name`, `value`)
VALUES
	(1,'db_version','3.2');

/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table services
# ------------------------------------------------------------

DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci,
  `rgba` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;

INSERT INTO `services` (`id`, `name`, `rgba`)
VALUES
	(1,'Disney+','rgba(44,43,191,1)'),
	(2,'Netflix','rgba(229,9,20,1)'),
	(3,'Hulu','rgba(28,231,131,1)'),
	(4,'Digital File','rgba(237,182,23,1)'),
	(5,'DVD','rgba(166,170,155,1)'),
	(6,'Prime','rgba(0,168,255,1)'),
	(7,'HBO Max','rgba(91,28,230,1)'),
	(8,'iTunes Rental','rgba(136,136,136,1)'),
	(9,'Starz','rgba(0,0,0,1)'),
	(10,'HBO Now','rgba(0,0,0,1)'),
	(11,'Redbox','rgba(227,32,69,1)'),
	(12,'YouTube Movies','rgba(255,0,0,1)'),
	(13,'Bluray','rgba(0,144,206,1)'),
	(14,'Streaming','rgba(99,44,140,1)'),
	(15,'Steam','rgba(27,40,56,1)'),
	(16,'Apple TV+','rgba(11,11,12,1)'),
	(17,'Comedy Central','rgba(253,198,0,1)'),
	(18,'Showtime','rgba(177,0,0,1)'),
	(19,'Tubi','rgb(255,80,26,1)'),
  (20,'Dropout','rgb(254, 234, 59)');

/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table spinners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spinners`;

CREATE TABLE `spinners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `wedge_1` text,
  `wedge_2` text,
  `wedge_3` text,
  `wedge_4` text,
  `wedge_5` text,
  `wedge_6` text,
  `wedge_7` text,
  `wedge_8` text,
  `wedge_9` text,
  `wedge_10` text,
  `wedge_11` text,
  `wedge_12` text,
  `uses` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `spinners` WRITE;
/*!40000 ALTER TABLE `spinners` DISABLE KEYS */;

INSERT INTO `spinners` (`id`, `name`, `wedge_1`, `wedge_2`, `wedge_3`, `wedge_4`, `wedge_5`, `wedge_6`, `wedge_7`, `wedge_8`, `wedge_9`, `wedge_10`, `wedge_11`, `wedge_12`, `uses`)
VALUES
	(1,'wheel v1','#2b3fd5','#fff200','#ff0000','#297f53','#2b3fd5','#fff200','#ff0000','#297f53','#2b3fd5','#fff200','#ff0000','#297f53',4),
	(2,'wheel v2','#297f53','#ff0000','#fff200','#2b3fd5','#2b3fd5','#297f53','#ff0000','#fff200','#fff200','#2b3fd5','#297f53','#ff0000',17),
	(3,'wheel v3','#297f53','#ff0000','#fff200','#2b3fd5','#2b3fd5','#297f53','#ff0000','#fff200','#fff200','#2b3fd5','#297f53','#ff0000',29),
	(4,'die','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5','#2b3fd5',25),
	(5,'bobbot','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878','#3cb878',3),
	(7,'viewer choice','#222222','#222222','#222222','#222222','#222222','#222222','#222222','#222222','#222222','#222222','#222222','#222222',15),
	(8,'wheelofsus','#222222','#eaead7','#ff0000','#fff200','#ff6a0e','#71491e','#3cb878','#297f53','#3bbaff','#2b3fd5','#ab79db','#f6999e',9),
	(9,'random.org','#333333','#333333','#333333','#333333','#333333','#333333','#333333','#333333','#333333','#333333','#333333','#333333',1),
	(10,'Digital d12','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7','#336eb7',0);

/*!40000 ALTER TABLE `spinners` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table viewers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `viewers`;

CREATE TABLE `viewers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `color` varchar(6) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Dump of table week
# ------------------------------------------------------------

DROP TABLE IF EXISTS `week`;

CREATE TABLE `week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `wheel_1` int(11) NOT NULL,
  `wheel_2` int(11) NOT NULL,
  `wheel_3` int(11) NOT NULL,
  `wheel_4` int(11) NOT NULL,
  `wheel_5` int(11) NOT NULL,
  `wheel_6` int(11) NOT NULL,
  `wheel_7` int(11) NOT NULL,
  `wheel_8` int(11) NOT NULL,
  `wheel_9` int(11) NOT NULL,
  `wheel_10` int(11) NOT NULL,
  `wheel_11` int(11) NOT NULL,
  `wheel_12` int(11) NOT NULL,
  `moviegoer_1` int(11) NOT NULL,
  `moviegoer_2` int(11) NOT NULL,
  `moviegoer_3` int(11) NOT NULL,
  `moviegoer_4` int(11) NOT NULL,
  `moviegoer_5` int(11) NOT NULL,
  `moviegoer_6` int(11) NOT NULL,
  `moviegoer_7` int(11) NOT NULL,
  `moviegoer_8` int(11) NOT NULL,
  `moviegoer_9` int(11) NOT NULL,
  `moviegoer_10` int(11) NOT NULL,
  `moviegoer_11` int(11) NOT NULL,
  `moviegoer_12` int(11) NOT NULL,
  `spinner` int(11) NOT NULL,
  `winning_wedge` int(11) NOT NULL,
  `winning_moviegoer` int(11) NOT NULL,
  `winning_film` int(11) NOT NULL,
  `format` text NOT NULL,
  `error_spin` text,
  `scribe` int(11) NOT NULL,
  `theme` text,
  `attendees` text NOT NULL,
  `selection_method` text NOT NULL,
  `runtime` int(11) NOT NULL DEFAULT '0',
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
