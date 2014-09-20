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

-- Exportiere Struktur von Tabelle amvscore.amv
CREATE TABLE IF NOT EXISTS `amv` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contest_id` bigint(20) NOT NULL,
  `contest_amv_id` bigint(20) NOT NULL,
  `avg_rating` decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'average vote',
  `min_rating` decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'lowest vote',
  `max_rating` decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT 'highest vote',
  `sum_rating` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'sum of all votes to easier calculate the avg later',
  `votes` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `contest_id_contest_amv_id` (`contest_id`,`contest_amv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle amvscore.contest
CREATE TABLE IF NOT EXISTS `contest` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trigger` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_parsed_tweet_id` bigint(20) DEFAULT NULL,
  `parse_from` datetime DEFAULT NULL,
  `parse_to` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contest_last_parsed_tweet_id` (`last_parsed_tweet_id`),
  CONSTRAINT `fk_contest_last_parsed_tweet_id` FOREIGN KEY (`last_parsed_tweet_id`) REFERENCES `tweet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle amvscore.tweet
CREATE TABLE IF NOT EXISTS `tweet` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `text` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contest_id` bigint(20) NOT NULL,
  `amv_id` bigint(20) NOT NULL,
  `rating` tinyint(2) unsigned NOT NULL,
  `needs_validation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_tweet_amv_id` (`amv_id`),
  KEY `fk_tweet_contest_id` (`contest_id`),
  CONSTRAINT `fk_tweet_contest_id` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_tweet_user_id` FOREIGN KEY (`user_id`) REFERENCES `tweet_user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='crawled tweets';

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle amvscore.tweet_user
CREATE TABLE IF NOT EXISTS `tweet_user` (
  `id` bigint(20) NOT NULL,
  `screen_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Twitter Users';

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
