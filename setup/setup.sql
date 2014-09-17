-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.6.16 - MySQL Community Server (GPL)
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             8.3.0.4748
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Datenbank Struktur für amvscore
DROP DATABASE IF EXISTS `amvscore`;
CREATE DATABASE IF NOT EXISTS `amvscore` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `amvscore`;


-- Exportiere Struktur von Tabelle amvscore.amv
CREATE TABLE IF NOT EXISTS `amv` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contest_id` bigint(20) NOT NULL,
  `contest_amv_id` bigint(20) NOT NULL,
  `avg_rating` decimal(2,2) NOT NULL DEFAULT '0.00',
  `min_rating` decimal(2,2) NOT NULL DEFAULT '0.00',
  `max_rating` decimal(2,2) NOT NULL DEFAULT '0.00',
  `votes` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportiere Daten aus Tabelle amvscore.amv: ~0 rows (ungefähr)
DELETE FROM `amv`;
/*!40000 ALTER TABLE `amv` DISABLE KEYS */;
/*!40000 ALTER TABLE `amv` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle amvscore.contest
CREATE TABLE IF NOT EXISTS `contest` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_parsed_tweet_id` bigint(20) DEFAULT NULL,
  `parse_from` datetime DEFAULT NULL,
  `parse_to` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contest_last_parsed_tweet_id` (`last_parsed_tweet_id`),
  CONSTRAINT `fk_contest_last_parsed_tweet_id` FOREIGN KEY (`last_parsed_tweet_id`) REFERENCES `tweet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportiere Daten aus Tabelle amvscore.contest: ~0 rows (ungefähr)
DELETE FROM `contest`;
/*!40000 ALTER TABLE `contest` DISABLE KEYS */;
/*!40000 ALTER TABLE `contest` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle amvscore.tweet
CREATE TABLE IF NOT EXISTS `tweet` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `text` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contest_id` bigint(20) NOT NULL,
  `amv_id` bigint(20) NOT NULL,
  `rating` decimal(2,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_contest_id_amv_id` (`user_id`,`contest_id`,`amv_id`),
  KEY `user_id` (`user_id`),
  KEY `fk_tweet_amv_id` (`amv_id`),
  KEY `fk_tweet_contest_id` (`contest_id`),
  CONSTRAINT `fk_tweet_amv_id` FOREIGN KEY (`amv_id`) REFERENCES `amv` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_tweet_contest_id` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_tweet_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='crawled tweets';

-- Exportiere Daten aus Tabelle amvscore.tweet: ~0 rows (ungefähr)
DELETE FROM `tweet`;
/*!40000 ALTER TABLE `tweet` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle amvscore.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL,
  `screen_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Twitter Users';

-- Exportiere Daten aus Tabelle amvscore.user: ~0 rows (ungefähr)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
