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
CREATE DATABASE IF NOT EXISTS `amvscore` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `amvscore`;


-- Exportiere Struktur von Tabelle amvscore.amv
CREATE TABLE IF NOT EXISTS `amv` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contest_id` bigint(20) NOT NULL,
  `contest_amv_id` bigint(20) NOT NULL,
  `avg_rating` decimal(4,2) NOT NULL DEFAULT '0.00',
  `min_rating` decimal(4,2) NOT NULL DEFAULT '0.00',
  `max_rating` decimal(4,2) NOT NULL DEFAULT '0.00',
  `votes` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `contest_id_contest_amv_id` (`contest_id`,`contest_amv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportiere Daten aus Tabelle amvscore.amv: ~5 rows (ungefähr)
DELETE FROM `amv`;
/*!40000 ALTER TABLE `amv` DISABLE KEYS */;
INSERT INTO `amv` (`id`, `contest_id`, `contest_amv_id`, `avg_rating`, `min_rating`, `max_rating`, `votes`) VALUES
  (1, 1, 16, 7.00, 7.00, 7.00, 1),
  (2, 1, 24, 0.00, 0.00, 0.00, 0),
  (3, 1, 12, 0.00, 0.00, 0.00, 0),
  (4, 1, 47, 0.00, 0.00, 0.00, 0),
  (5, 1, 23, 0.00, 0.00, 0.00, 0);
/*!40000 ALTER TABLE `amv` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportiere Daten aus Tabelle amvscore.contest: ~1 rows (ungefähr)
DELETE FROM `contest`;
/*!40000 ALTER TABLE `contest` DISABLE KEYS */;
INSERT INTO `contest` (`id`, `name`, `trigger`, `year`, `active`, `last_parsed_tweet_id`, `parse_from`, `parse_to`) VALUES
  (1, 'Connichi AMV Contest', '@AMV_Contest', '2014', 1, NULL, '2014-09-12 00:00:00', '2014-09-13 00:00:00');
/*!40000 ALTER TABLE `contest` ENABLE KEYS */;


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

-- Exportiere Daten aus Tabelle amvscore.tweet: ~50 rows (ungefähr)
DELETE FROM `tweet`;
/*!40000 ALTER TABLE `tweet` DISABLE KEYS */;
INSERT INTO `tweet` (`id`, `created_at`, `text`, `user_id`, `contest_id`, `amv_id`, `rating`, `needs_validation`) VALUES
  (510898711845949440, '2014-09-13 21:11:59', '@AMV_Contest ID16 Wertung: 8', 77182301, 1, 1, 8, 0),
  (510898715872464896, '2014-09-13 21:12:00', '@AMV_Contest ID16 Wertung: 3', 53934147, 1, 1, 3, 0),
  (510898720444256256, '2014-09-13 21:12:01', '@AMV_Contest ID16 Wertung:10', 115368505, 1, 1, 10, 0),
  (510898722872766464, '2014-09-13 21:12:02', '@amv_contest ID16 Wertung: 9', 63717144, 1, 1, 9, 0),
  (510898723887779840, '2014-09-13 21:12:02', '@AMV_Contest ID16 Wertung 9', 1370174803, 1, 1, 9, 0),
  (510898727478099968, '2014-09-13 21:12:03', '@AMV_Contest id16 8', 110096050, 1, 1, 8, 0),
  (510898730971967488, '2014-09-13 21:12:04', '@AMV_Contest ID16 Wertung: 4', 573523395, 1, 1, 4, 0),
  (510898732058288128, '2014-09-13 21:12:04', '@AMV_Contest ID16 Wertung: 6', 26605965, 1, 1, 6, 0),
  (510898733119471616, '2014-09-13 21:12:04', '@AMV_Contest ID16 Wertung: 7', 60506384, 1, 1, 7, 0),
  (510898735644430336, '2014-09-13 21:12:05', '@AMV_Contest id16 8', 580284221, 1, 1, 8, 0),
  (510898738035195904, '2014-09-13 21:12:05', '@AMV_Contest ID16 Wertung: 3', 1661232073, 1, 1, 3, 0),
  (510898738181971970, '2014-09-13 21:12:05', '@AMV_Contest id16 7', 2521008823, 1, 1, 7, 0),
  (510898738328788992, '2014-09-13 21:12:05', '@AMV_Contest ID16 Wertung 7', 66149822, 1, 1, 7, 0),
  (510898738693685248, '2014-09-13 21:12:06', '@amv_contest ID16 Wertung: 5', 79536341, 1, 1, 5, 0),
  (510898740048441344, '2014-09-13 21:12:06', '@AMV_Contest ID16 Wertung: 7', 510118037, 1, 1, 7, 0),
  (510898740937637888, '2014-09-13 21:12:06', '@AMV_Contest ID16 Wertung: 8', 234514815, 1, 1, 8, 0),
  (510898742841843712, '2014-09-13 21:12:06', '@amv_contest id 16 wertung  6', 2363844951, 1, 1, 0, 1),
  (510898743433265153, '2014-09-13 21:12:07', '@AMV_Contest ID16 Wertung: 7', 2442723785, 1, 1, 7, 0),
  (510898743554883584, '2014-09-13 21:12:07', '@AMV_Contest ID16 Wertung: 7', 2387381378, 1, 1, 7, 0),
  (510898746180530178, '2014-09-13 21:12:07', '@AMV_Contest ID16  Wertung 9', 2267344427, 1, 1, 9, 0),
  (510898746390245376, '2014-09-13 21:12:07', '@AMV_Contest ID16 Wertung:7,5', 2729307158, 1, 1, 7, 0),
  (510898747153612800, '2014-09-13 21:12:08', '@AMV_Contest ID16   Wertung: 7', 1252431793, 1, 1, 7, 0),
  (510898747564630016, '2014-09-13 21:12:08', '@AMV_Contest ID16 Wertung: 7', 2453282316, 1, 1, 7, 0),
  (510898749397553152, '2014-09-13 21:12:08', '@AMV_Contest ID16 Wertung: 9', 21028139, 1, 1, 9, 0),
  (510898752786534400, '2014-09-13 21:12:09', '@AMV_Contest ID16 Wertung: 9', 49673310, 1, 1, 9, 0),
  (510898752803323904, '2014-09-13 21:12:09', '@AMV_Contest id16 wertung: 7', 395388426, 1, 1, 7, 0),
  (510898753696706561, '2014-09-13 21:12:09', '@AMV_Contest ID16 Wertung: 7', 771240836, 1, 1, 7, 0),
  (510898754388779008, '2014-09-13 21:12:09', '@AMV_Contest ID16 Wertung: 9', 1595565451, 1, 1, 9, 0),
  (510898757479964672, '2014-09-13 21:12:10', '@AMV_Contest ID 16 Wertung 6', 58177321, 1, 1, 6, 0),
  (510898759044444160, '2014-09-13 21:12:10', '@AMV_Contest ID16 Wertung: 9', 189438384, 1, 1, 9, 0),
  (510898763578478593, '2014-09-13 21:12:11', '@AMV_Contest ID16 Wertung: 7', 1864898851, 1, 1, 7, 0),
  (510898775192522752, '2014-09-13 21:12:14', '@AMV_Contest ID 24 Wertung 10', 58177321, 1, 2, 10, 0),
  (510898775691644928, '2014-09-13 21:12:14', '@AMV_Contest ID16 Wertung: 7', 2232087216, 1, 1, 7, 0),
  (510898778296307712, '2014-09-13 21:12:15', '@amv_contest id16 wertung: 10', 188767493, 1, 1, 10, 0),
  (510898780389269504, '2014-09-13 21:12:15', '@AMV_Contest ID16 Wertung: 6', 1648299554, 1, 1, 6, 0),
  (510898788089987072, '2014-09-13 21:12:17', '@AMV_Contest ID16 Wertung: 7', 366036263, 1, 1, 7, 0),
  (510898788404584448, '2014-09-13 21:12:17', '@AMV_Contest ID16 Wertung: 5', 315185586, 1, 1, 5, 0),
  (510898789029543936, '2014-09-13 21:12:18', '@AMV_Contest ID16 Wertung: 8', 574983095, 1, 1, 8, 0),
  (510898790535278592, '2014-09-13 21:12:18', '@AMV_Contest ID16 Wertung: 7', 51533087, 1, 1, 7, 0),
  (510898792175267840, '2014-09-13 21:12:18', '@AMV_Contest ID16 Wertung 8', 2695339118, 1, 1, 8, 0),
  (510898797711736832, '2014-09-13 21:12:20', '@AMV_Contest ID16 Wertung:7', 326812772, 1, 1, 7, 0),
  (510898804229697536, '2014-09-13 21:12:21', '@AMV_Contest ID16 Wertung:10', 87536985, 1, 1, 10, 0),
  (510898814136643584, '2014-09-13 21:12:23', '@AMV_Contest ID16 Wertung:7', 18331512, 1, 1, 7, 0),
  (510898832885157888, '2014-09-13 21:12:28', '@AMV_Contest ID16 Wertung:7', 746438233, 1, 1, 7, 0),
  (510898835523395584, '2014-09-13 21:12:29', '@AMV_Contest ID16 Wertung: 7', 2421091274, 1, 1, 7, 0),
  (510898867941158912, '2014-09-13 21:12:36', '@AMV_Contest ID23\nWertung:7', 253734966, 1, 5, 7, 0),
  (510898983490027522, '2014-09-13 21:13:04', '@AMV_Contest ID47  Wertung:7', 90016702, 1, 4, 7, 0),
  (510899128092884992, '2014-09-13 21:13:38', '@AMV_Contest ID16 Wertung: 8', 37931088, 1, 1, 8, 0),
  (510899199173738497, '2014-09-13 21:13:55', '@AMV_Contest ID12  Wertung:10', 90016702, 1, 3, 10, 0),
  (510900930192351232, '2014-09-13 21:20:48', '@AMV_Contest ID&lt;Platz 5: Kategorie "Kranker Scheiß"&gt; Wertung: 10!!!', 771240836, 1, -1, 10, 1);
/*!40000 ALTER TABLE `tweet` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle amvscore.tweet_user
CREATE TABLE IF NOT EXISTS `tweet_user` (
  `id` bigint(20) NOT NULL,
  `screen_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Twitter Users';

-- Exportiere Daten aus Tabelle amvscore.tweet_user: ~47 rows (ungefähr)
DELETE FROM `tweet_user`;
/*!40000 ALTER TABLE `tweet_user` DISABLE KEYS */;
INSERT INTO `tweet_user` (`id`, `screen_name`, `created_at`) VALUES
  (18331512, 'Tak0r', '2008-12-23 11:36:10'),
  (21028139, 'leading0', '2009-02-16 21:08:51'),
  (26605965, 'BrauseBrocken', '2009-03-25 22:08:50'),
  (37931088, 'vm10000', '2009-05-05 14:13:27'),
  (49673310, 'n_doroid', '2009-06-22 16:07:58'),
  (51533087, 'Alanceil', '2009-06-27 19:36:17'),
  (53934147, 'sehrunkreativ', '2009-07-05 15:41:37'),
  (58177321, '_Tenni_', '2009-07-19 11:21:40'),
  (60506384, 'anime_news', '2009-07-27 06:02:14'),
  (63717144, 'ZayolaAng', '2009-08-07 13:19:33'),
  (66149822, 'Wolfapo', '2009-08-16 17:12:32'),
  (77182301, 'Schattenbinder', '2009-09-25 10:20:42'),
  (79536341, 'DrevenSeal', '2009-10-03 18:43:16'),
  (87536985, 'Mondlied', '2009-11-04 21:26:03'),
  (90016702, 'Eeenton', '2009-11-14 20:42:09'),
  (110096050, 'Striker1988', '2010-01-31 09:34:38'),
  (115368505, 'MiaSkyLou', '2010-02-18 12:46:22'),
  (188767493, 'JimmPantsu', '2010-09-09 15:04:10'),
  (189438384, 'KemmlerFly', '2010-09-11 07:28:57'),
  (234514815, 'Shi_chan86', '2011-01-05 21:11:19'),
  (253734966, 'syjana', '2011-02-17 21:27:21'),
  (315185586, 'Thorus_144', '2011-06-11 12:59:28'),
  (326812772, 'ktrask23', '2011-06-30 14:45:56'),
  (366036263, 'jedicorran', '2011-09-01 13:19:57'),
  (395388426, '_Kente', '2011-10-21 15:50:19'),
  (510118037, 'kl0kkw0rk', '2012-03-01 11:51:11'),
  (573523395, 'aoiSamidare', '2012-05-07 08:48:25'),
  (574983095, 'SimonBrutus', '2012-05-09 02:38:51'),
  (580284221, 'BenediktHeidric', '2012-05-14 22:11:23'),
  (746438233, 'abyssinier', '2012-08-09 03:12:19'),
  (771240836, 'afh24', '2012-08-21 10:18:33'),
  (1252431793, 'katzenfan666', '2013-03-08 18:26:56'),
  (1370174803, 'Hanna_der_Wal', '2013-04-21 17:50:39'),
  (1595565451, 'Mikophilie', '2013-07-15 10:36:15'),
  (1648299554, 'NachigoOnTour', '2013-08-05 17:36:58'),
  (1661232073, 'SpiresAwake', '2013-08-10 23:52:56'),
  (1864898851, 'waka4200', '2013-09-14 20:21:21'),
  (2232087216, 'piv0t_', '2013-12-05 22:15:55'),
  (2267344427, 'AyaSan666', '2014-01-07 18:11:02'),
  (2363844951, 'edo_niichan', '2014-02-24 23:01:27'),
  (2387381378, 'aViiophobia', '2014-03-13 16:27:35'),
  (2421091274, 'reinibo', '2014-03-31 21:32:19'),
  (2442723785, 'vioplu', '2014-03-28 19:30:53'),
  (2453282316, 'Murkelchen11', '2014-04-19 14:55:15'),
  (2521008823, 'TeffenS', '2014-05-24 17:49:04'),
  (2695339118, 'o0thyella0o', '2014-07-31 10:07:03'),
  (2729307158, 'Shuuyachi', '2014-08-13 12:17:00');
/*!40000 ALTER TABLE `tweet_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
