-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: eshop
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB-0+deb11u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `street` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `country` varchar(256) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `FK_address_user` (`user_id`),
  CONSTRAINT `FK_address_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'Karel Douda','Nevím','Praha','19800','Čečenská Republika',1),(2,'Karel Douda','Nevím','Praha','19800','Čečenská Republika',1),(3,'Karel Douda','Nevím','Praha','19800','Čečenská Republika',1);
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=503 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (221,NULL,'2022-01-10 14:56:08'),(222,NULL,'2022-01-10 15:37:09'),(223,NULL,'2022-01-10 15:38:26'),(224,NULL,'2022-01-10 15:40:12'),(225,NULL,'2022-01-10 15:40:16'),(226,NULL,'2022-01-10 15:40:16'),(227,NULL,'2022-01-10 15:40:17'),(228,NULL,'2022-01-10 15:40:18'),(229,NULL,'2022-01-10 15:40:25'),(230,NULL,'2022-01-10 15:40:32'),(231,NULL,'2022-01-10 15:41:06'),(232,NULL,'2022-01-10 15:41:08'),(233,NULL,'2022-01-10 15:41:09'),(234,NULL,'2022-01-10 15:41:36'),(235,NULL,'2022-01-10 15:41:38'),(236,NULL,'2022-01-10 15:41:39'),(237,NULL,'2022-01-10 15:41:42'),(238,NULL,'2022-01-10 15:42:05'),(239,NULL,'2022-01-10 15:43:27'),(240,NULL,'2022-01-10 15:43:32'),(241,NULL,'2022-01-10 15:43:32'),(242,NULL,'2022-01-10 15:43:39'),(243,NULL,'2022-01-10 15:43:42'),(244,NULL,'2022-01-10 15:43:44'),(245,NULL,'2022-01-10 15:44:00'),(246,NULL,'2022-01-10 15:44:25'),(247,NULL,'2022-01-10 15:44:26'),(248,NULL,'2022-01-10 15:44:27'),(249,NULL,'2022-01-10 15:44:29'),(250,NULL,'2022-01-10 15:44:30'),(251,NULL,'2022-01-10 15:44:31'),(252,NULL,'2022-01-10 15:44:32'),(253,NULL,'2022-01-10 15:44:32'),(254,NULL,'2022-01-10 15:44:34'),(255,NULL,'2022-01-10 15:44:38'),(256,NULL,'2022-01-10 15:44:47'),(257,NULL,'2022-01-10 15:45:04'),(258,NULL,'2022-01-10 15:45:12'),(259,NULL,'2022-01-10 15:45:24'),(260,NULL,'2022-01-10 15:47:16'),(261,NULL,'2022-01-10 15:47:17'),(262,NULL,'2022-01-10 15:47:18'),(263,NULL,'2022-01-10 15:47:24'),(264,NULL,'2022-01-10 15:47:30'),(265,NULL,'2022-01-10 15:48:00'),(266,NULL,'2022-01-10 15:48:15'),(267,NULL,'2022-01-10 15:48:18'),(268,NULL,'2022-01-10 15:48:21'),(269,NULL,'2022-01-10 15:49:11'),(270,6,'2022-01-10 16:28:22'),(271,NULL,'2022-01-10 15:51:10'),(272,NULL,'2022-01-10 16:16:40'),(273,NULL,'2022-01-10 16:25:06'),(274,NULL,'2022-01-10 16:32:39'),(275,NULL,'2022-01-10 16:37:46'),(276,NULL,'2022-01-10 16:48:12'),(277,NULL,'2022-01-10 23:01:26'),(278,NULL,'2022-01-11 00:18:07'),(279,NULL,'2022-01-11 01:18:25'),(280,NULL,'2022-01-11 01:26:48'),(281,NULL,'2022-01-11 01:31:55'),(282,NULL,'2022-01-11 01:56:33'),(283,NULL,'2022-01-11 02:42:22'),(284,NULL,'2022-01-11 02:49:02'),(285,NULL,'2022-01-11 02:50:39'),(286,NULL,'2022-01-11 04:19:55'),(287,NULL,'2022-01-11 05:08:17'),(288,NULL,'2022-01-11 05:15:31'),(289,NULL,'2022-01-11 05:20:42'),(290,NULL,'2022-01-11 05:36:20'),(291,NULL,'2022-01-11 05:38:08'),(292,NULL,'2022-01-11 06:33:55'),(293,NULL,'2022-01-11 06:37:21'),(294,NULL,'2022-01-11 06:41:47'),(295,NULL,'2022-01-11 06:41:47'),(296,NULL,'2022-01-11 07:14:09'),(297,NULL,'2022-01-11 07:40:32'),(298,NULL,'2022-01-11 07:46:42'),(299,NULL,'2022-01-11 07:47:48'),(300,NULL,'2022-01-11 07:50:34'),(301,NULL,'2022-01-11 08:10:52'),(302,NULL,'2022-01-11 08:35:36'),(303,NULL,'2022-01-11 08:48:23'),(304,NULL,'2022-01-11 08:49:17'),(305,NULL,'2022-01-11 08:49:18'),(306,NULL,'2022-01-11 08:49:19'),(307,NULL,'2022-01-11 08:49:19'),(308,NULL,'2022-01-11 08:49:21'),(309,NULL,'2022-01-11 08:49:24'),(310,NULL,'2022-01-11 08:49:25'),(311,NULL,'2022-01-11 08:49:27'),(312,NULL,'2022-01-11 08:49:28'),(313,NULL,'2022-01-11 08:49:30'),(314,NULL,'2022-01-11 08:49:31'),(315,NULL,'2022-01-11 08:49:32'),(316,NULL,'2022-01-11 08:49:33'),(317,NULL,'2022-01-11 08:49:35'),(318,NULL,'2022-01-11 08:49:36'),(319,NULL,'2022-01-11 08:49:51'),(320,NULL,'2022-01-11 08:49:53'),(321,NULL,'2022-01-11 08:49:55'),(322,NULL,'2022-01-11 08:53:32'),(323,NULL,'2022-01-11 08:54:21'),(324,NULL,'2022-01-11 08:55:04'),(325,NULL,'2022-01-11 08:55:21'),(326,NULL,'2022-01-11 08:55:32'),(327,NULL,'2022-01-11 08:55:33'),(328,NULL,'2022-01-11 08:55:34'),(329,NULL,'2022-01-11 08:55:45'),(330,NULL,'2022-01-11 08:55:52'),(331,NULL,'2022-01-11 08:55:59'),(332,NULL,'2022-01-11 08:56:01'),(333,NULL,'2022-01-11 08:56:02'),(334,NULL,'2022-01-11 08:56:06'),(335,NULL,'2022-01-11 08:56:07'),(336,NULL,'2022-01-11 08:56:14'),(337,NULL,'2022-01-11 08:56:18'),(338,NULL,'2022-01-11 08:56:27'),(339,NULL,'2022-01-11 08:56:30'),(340,NULL,'2022-01-11 08:56:33'),(341,NULL,'2022-01-11 08:57:07'),(342,NULL,'2022-01-11 08:57:09'),(343,NULL,'2022-01-11 08:57:13'),(344,NULL,'2022-01-11 08:57:17'),(345,NULL,'2022-01-11 08:57:19'),(346,NULL,'2022-01-11 08:57:38'),(347,NULL,'2022-01-11 08:57:55'),(348,NULL,'2022-01-11 08:57:56'),(349,NULL,'2022-01-11 08:57:58'),(350,NULL,'2022-01-11 08:58:00'),(351,NULL,'2022-01-11 08:58:01'),(352,NULL,'2022-01-11 08:59:07'),(353,NULL,'2022-01-11 08:59:22'),(354,NULL,'2022-01-11 08:59:26'),(355,NULL,'2022-01-11 08:59:43'),(356,NULL,'2022-01-11 08:59:45'),(357,NULL,'2022-01-11 08:59:47'),(358,NULL,'2022-01-11 08:59:55'),(359,NULL,'2022-01-11 10:54:40'),(360,NULL,'2022-01-11 11:14:28'),(361,NULL,'2022-01-11 12:16:10'),(362,NULL,'2022-01-11 12:40:38'),(363,NULL,'2022-01-11 13:18:41'),(364,NULL,'2022-01-11 13:51:35'),(365,NULL,'2022-01-11 14:05:10'),(366,NULL,'2022-01-11 14:53:18'),(367,NULL,'2022-01-11 15:17:41'),(368,NULL,'2022-01-11 15:31:30'),(369,NULL,'2022-01-11 18:49:50'),(370,NULL,'2022-01-11 19:37:35'),(371,NULL,'2022-01-11 19:37:36'),(372,NULL,'2022-01-11 19:41:51'),(373,NULL,'2022-01-11 20:47:15'),(374,NULL,'2022-01-11 21:29:08'),(375,NULL,'2022-01-11 23:14:56'),(376,NULL,'2022-01-11 23:14:56'),(377,NULL,'2022-01-11 23:17:24'),(378,NULL,'2022-01-11 23:55:20'),(379,NULL,'2022-01-12 00:07:35'),(380,NULL,'2022-01-12 00:53:46'),(381,NULL,'2022-01-12 01:03:08'),(382,NULL,'2022-01-12 01:41:47'),(383,NULL,'2022-01-12 01:56:53'),(384,NULL,'2022-01-12 02:42:36'),(385,NULL,'2022-01-12 02:56:20'),(386,NULL,'2022-01-12 02:56:22'),(387,NULL,'2022-01-12 02:56:49'),(388,NULL,'2022-01-12 02:56:51'),(389,NULL,'2022-01-12 02:59:04'),(390,NULL,'2022-01-12 02:59:06'),(391,NULL,'2022-01-12 03:27:20'),(392,NULL,'2022-01-12 04:01:55'),(393,NULL,'2022-01-12 04:13:17'),(394,NULL,'2022-01-12 04:30:20'),(395,NULL,'2022-01-12 04:44:19'),(396,NULL,'2022-01-12 04:45:01'),(397,NULL,'2022-01-12 04:45:02'),(398,NULL,'2022-01-12 04:45:09'),(399,NULL,'2022-01-12 04:45:10'),(400,NULL,'2022-01-12 04:45:22'),(401,NULL,'2022-01-12 04:45:28'),(402,NULL,'2022-01-12 04:45:28'),(403,NULL,'2022-01-12 04:45:44'),(404,NULL,'2022-01-12 04:49:54'),(405,NULL,'2022-01-12 05:20:50'),(406,NULL,'2022-01-12 05:36:39'),(407,NULL,'2022-01-12 05:53:39'),(408,NULL,'2022-01-12 05:53:49'),(409,NULL,'2022-01-12 05:53:51'),(410,NULL,'2022-01-12 05:53:59'),(411,NULL,'2022-01-12 06:14:18'),(412,NULL,'2022-01-12 06:23:43'),(413,NULL,'2022-01-12 06:37:21'),(414,NULL,'2022-01-12 07:13:54'),(415,NULL,'2022-01-12 08:06:13'),(416,NULL,'2022-01-12 08:42:41'),(417,NULL,'2022-01-12 09:05:02'),(418,NULL,'2022-01-12 09:05:04'),(419,NULL,'2022-01-12 09:05:15'),(420,NULL,'2022-01-12 09:24:16'),(421,NULL,'2022-01-12 09:30:42'),(422,NULL,'2022-01-12 09:37:29'),(423,NULL,'2022-01-12 10:55:05'),(424,NULL,'2022-01-12 10:56:53'),(425,NULL,'2022-01-12 11:17:48'),(426,NULL,'2022-01-12 11:32:17'),(427,NULL,'2022-01-12 13:13:25'),(428,NULL,'2022-01-12 14:06:38'),(429,NULL,'2022-01-12 14:17:49'),(430,NULL,'2022-01-12 14:17:49'),(431,NULL,'2022-01-12 15:32:21'),(432,NULL,'2022-01-12 15:47:31'),(433,NULL,'2022-01-12 16:08:49'),(434,NULL,'2022-01-12 16:24:43'),(435,NULL,'2022-01-12 19:48:11'),(436,NULL,'2022-01-12 19:48:15'),(437,NULL,'2022-01-12 19:48:16'),(438,NULL,'2022-01-12 19:48:21'),(439,NULL,'2022-01-12 19:48:24'),(441,NULL,'2022-01-12 20:48:36'),(442,NULL,'2022-01-12 21:21:52'),(443,NULL,'2022-01-12 21:22:59'),(444,NULL,'2022-01-12 21:23:03'),(445,NULL,'2022-01-12 21:23:04'),(446,NULL,'2022-01-12 21:23:07'),(447,NULL,'2022-01-12 21:23:08'),(448,NULL,'2022-01-12 21:28:12'),(449,NULL,'2022-01-12 21:38:02'),(450,NULL,'2022-01-12 21:39:37'),(451,NULL,'2022-01-12 21:40:44'),(452,NULL,'2022-01-12 21:43:28'),(453,NULL,'2022-01-12 22:19:36'),(454,NULL,'2022-01-12 22:38:59'),(455,NULL,'2022-01-12 22:50:12'),(456,NULL,'2022-01-12 22:51:51'),(457,NULL,'2022-01-12 23:09:55'),(458,NULL,'2022-01-12 23:10:07'),(459,NULL,'2022-01-12 23:35:16'),(460,NULL,'2022-01-12 23:35:27'),(461,NULL,'2022-01-12 23:58:05'),(462,NULL,'2022-01-13 00:35:05'),(463,NULL,'2022-01-13 00:55:37'),(464,NULL,'2022-01-13 01:44:55'),(465,NULL,'2022-01-13 02:37:27'),(466,NULL,'2022-01-13 02:37:30'),(467,NULL,'2022-01-13 03:04:36'),(468,NULL,'2022-01-13 03:52:38'),(469,NULL,'2022-01-13 03:52:38'),(470,NULL,'2022-01-13 04:46:03'),(471,NULL,'2022-01-13 05:17:20'),(472,NULL,'2022-01-13 05:17:21'),(473,NULL,'2022-01-13 05:18:00'),(474,NULL,'2022-01-13 05:29:16'),(475,NULL,'2022-01-13 06:17:56'),(476,NULL,'2022-01-13 06:27:09'),(477,NULL,'2022-01-13 06:28:25'),(478,NULL,'2022-01-13 06:55:15'),(479,NULL,'2022-01-13 08:07:10'),(480,NULL,'2022-01-13 08:32:00'),(481,NULL,'2022-01-13 08:52:48'),(482,NULL,'2022-01-13 09:08:18'),(483,NULL,'2022-01-13 09:15:36'),(484,NULL,'2022-01-13 10:07:43'),(485,NULL,'2022-01-13 10:12:30'),(486,NULL,'2022-01-13 10:24:51'),(487,NULL,'2022-01-13 10:24:55'),(488,NULL,'2022-01-13 10:24:56'),(489,NULL,'2022-01-13 10:25:17'),(490,NULL,'2022-01-13 11:06:42'),(491,NULL,'2022-01-13 11:07:16'),(492,NULL,'2022-01-13 11:31:25'),(493,NULL,'2022-01-13 11:31:26'),(494,NULL,'2022-01-13 11:40:03'),(495,NULL,'2022-01-13 12:06:06'),(496,NULL,'2022-01-13 13:34:38'),(497,NULL,'2022-01-13 13:52:21'),(498,NULL,'2022-01-13 13:52:21'),(499,NULL,'2022-01-13 13:52:26'),(500,NULL,'2022-01-13 14:16:38'),(501,NULL,'2022-01-13 14:16:38'),(502,1,'2022-01-13 14:54:48');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_item`
--

DROP TABLE IF EXISTS `cart_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`cart_item_id`),
  UNIQUE KEY `product_id` (`product_id`,`cart_id`),
  KEY `cart_id` (`cart_id`),
  CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_item`
--

LOCK TABLES `cart_item` WRITE;
/*!40000 ALTER TABLE `cart_item` DISABLE KEYS */;
INSERT INTO `cart_item` VALUES (2,2,358,5);
/*!40000 ALTER TABLE `cart_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Kategorie poznámek';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Lama','Lamy, známé též jako velbloudi Jižní Ameriky, jsou zvířata z čeledi velbloudovití, která se přizpůsobila těžkému životu v Andách. V posledních 40 letech se šíří do celého světa jako chovný dobytek či zvěř chovaná v zoologických zahradách. '),(2,'Příslušenství','Příslušenství k chovu lam, to nejlepší pro vašeho chlupatého čtyřnohého mazlíčka, který určitě není pes.'),(3,'Krmivo','Krmivo pro lamy a podobná zvířata.');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_dimension`
--

DROP TABLE IF EXISTS `category_dimension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_dimension` (
  `category_id` smallint(5) unsigned NOT NULL,
  `dimension_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`dimension_id`),
  KEY `FK_category_dimension_dimension` (`dimension_id`),
  CONSTRAINT `FK_category_dimension_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  CONSTRAINT `FK_category_dimension_dimension` FOREIGN KEY (`dimension_id`) REFERENCES `dimension` (`dimension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_dimension`
--

LOCK TABLES `category_dimension` WRITE;
/*!40000 ALTER TABLE `category_dimension` DISABLE KEYS */;
INSERT INTO `category_dimension` VALUES (1,3),(1,4),(1,6),(1,9),(3,6),(3,7),(3,8);
/*!40000 ALTER TABLE `category_dimension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dimension`
--

DROP TABLE IF EXISTS `dimension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dimension` (
  `dimension_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `schema_property` varchar(256) NOT NULL,
  PRIMARY KEY (`dimension_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dimension`
--

LOCK TABLES `dimension` WRITE;
/*!40000 ALTER TABLE `dimension` DISABLE KEYS */;
INSERT INTO `dimension` VALUES (3,'Šířka (m)','',''),(4,'Výška (m)','',''),(5,'Hloubka (m)','',''),(6,'Hmotnost (kg)','',''),(7,'Objem (L)','Objem v litrech.',''),(8,'Roční období','Pro jaké roční období je krmivo vhodné.',''),(9,'Barva','Barva lamy.','color');
/*!40000 ALTER TABLE `dimension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(256) NOT NULL,
  `file_size` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (1,'1641252485_2_tshirt-agyle.png',312331,553,510),(2,'1641252496_2_roadsign-top-samurai.png',341932,679,422),(3,'1641252571_2_pants-northern-forester.png',417669,541,738),(4,'1641253206_2_pants-outlaw.png',333977,449,705),(5,'1641253206_2_pants-steppe-camo.png',278900,383,703),(6,'1641253206_2_roadsign-top-dominator.png',286807,559,424),(7,'1641253235_2_pants-steppe-camo.png',278900,383,703),(8,'1641253235_2_roadsign-top-dominator.png',286807,559,424),(9,'1641253235_2_roadsign-top-last-viking.png',279585,552,443),(10,'1641253235_2_roadsign-top-nordic.png',349598,640,482),(11,'1641253235_2_roadsign-top-samurai.png',341932,679,422),(12,'1641253235_2_roadsign-top-snapturtle.png',370902,687,452),(13,'1641640801_3_kartac.jpeg',24458,500,500),(14,'1641640823_3_kartac.jpeg',24458,500,500),(15,'1641640876_3_kartac.jpeg',24458,500,500),(16,'1641640971_4_seno.jpeg',276918,1200,954),(17,'1641641154_5_seno2.jpeg',197520,1024,767),(18,'1641651469_6_143374.jpeg',39806,354,500),(19,'1641651538_7_lama1.jpeg',123054,999,562);
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forgotten_password`
--

DROP TABLE IF EXISTS `forgotten_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forgotten_password` (
  `forgotten_password_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`forgotten_password_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `forgotten_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forgotten_password`
--

LOCK TABLES `forgotten_password` WRITE;
/*!40000 ALTER TABLE `forgotten_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `forgotten_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `state` varchar(32) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delivery_address_id` int(11) NOT NULL,
  `billing_address_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `FK_cart_order_user` (`user_id`),
  KEY `FK_cart_order_address_delivery` (`delivery_address_id`),
  KEY `FK_cart_order_address_billing` (`billing_address_id`),
  CONSTRAINT `FK_cart_order_address_billing` FOREIGN KEY (`billing_address_id`) REFERENCES `address` (`address_id`),
  CONSTRAINT `FK_cart_order_address_delivery` FOREIGN KEY (`delivery_address_id`) REFERENCES `address` (`address_id`),
  CONSTRAINT `FK_cart_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,1,'new','2022-01-13 15:33:17','2022-01-13 15:33:17',2,2),(2,1,'new','2022-01-13 15:33:32','2022-01-13 15:33:32',3,3),(3,1,'new','2022-01-13 15:38:41','2022-01-13 15:38:41',1,2);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `cart_order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cart_order_item_id`),
  UNIQUE KEY `order_id` (`order_id`,`product_id`),
  KEY `FK_cart_order_items_product` (`product_id`),
  CONSTRAINT `FK_cart_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  CONSTRAINT `FK_cart_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` VALUES (1,2,2,9,123.00),(2,3,2,9,123.00);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `resource_id` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `type` set('allow','deny') COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'allow',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `role_id` (`role_id`,`resource_id`,`action`,`type`),
  KEY `permission_ibfk_1` (`resource_id`),
  CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (22,'admin','Admin:Category','','allow'),(21,'admin','Admin:Dashboard','','allow'),(29,'admin','Admin:Dimension','','allow'),(30,'admin','Admin:Dimension','delete','allow'),(24,'admin','Admin:Product','','allow'),(36,'admin','Admin:Product','deletePhoto','allow'),(32,'admin','Admin:ProductDimension','','allow'),(33,'admin','Admin:ProductDimension','delete','allow'),(43,'admin','Admin:User','','allow'),(12,'admin','Category','','allow'),(31,'admin','Dimension','','allow'),(23,'admin','Product','','allow'),(35,'admin','Product','delete','allow'),(37,'admin','Product','deletePhoto','allow'),(34,'admin','ProductDimension','delete','allow'),(42,'admin','User','','allow'),(40,'authenticated','Front:Cart','','allow'),(4,'authenticated','Front:Error','','allow'),(5,'authenticated','Front:Error4xx','','allow'),(6,'authenticated','Front:Homepage','','allow'),(45,'authenticated','Front:Order','','allow'),(28,'authenticated','Front:Product','','allow'),(9,'authenticated','Front:User','login','allow'),(10,'authenticated','Front:User','logout','allow'),(27,'authenticated','Product','','allow'),(41,'guest','Front:Cart','','allow'),(1,'guest','Front:Error','','allow'),(2,'guest','Front:Error4xx','','allow'),(3,'guest','Front:Homepage','','allow'),(44,'guest','Front:Order','','allow'),(26,'guest','Front:Product','','allow'),(15,'guest','Front:User','facebookLogin','allow'),(13,'guest','Front:User','forgottenPassword','allow'),(7,'guest','Front:User','login','allow'),(8,'guest','Front:User','logout','allow'),(11,'guest','Front:User','register','allow'),(14,'guest','Front:User','renewPassword','allow'),(25,'guest','Product','','allow');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `description` text COLLATE utf8mb4_czech_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photo_extension` varchar(10) COLLATE utf8mb4_czech_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `url` (`url`),
  KEY `available` (`available`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s nabízenými produkty';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Test','test','test',10.00,'jpg',1,0),(2,'Dobrá lama','dobra-lama','test',123.00,'jpeg',1,1),(3,'Kartáč','kartac','Každá milovaná lama musí mít kvalitní kartáč.',120.00,'',1,0),(4,'Seno 1200L','seno-1200l','Seno v množství 1200 L. Vhodné pro krmení v zimě.',500.00,'',1,0),(5,'Seno balík','seno-balik','Seno v klasickém kulatém balíku. Krmení pro Vaší lamu, zábava pro vás.',1000.00,'',1,0),(6,'Plyšová lama','plysova-lama','Lama by neměla nikdy být sama. Pokud je ale další lama nad Vaše finanční možnosti, tak vám doporučujeme lamu plyšovou.',200.00,'',1,1),(7,'Další lama','dalsi-lama','Další lama.',10000.00,'',1,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (2,1),(2,2),(2,3),(3,2),(4,3),(5,3),(6,2),(7,1);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_dimension`
--

DROP TABLE IF EXISTS `product_dimension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_dimension` (
  `product_dimension_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `dimension_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`product_dimension_id`),
  UNIQUE KEY `product_id` (`product_id`,`dimension_id`),
  KEY `FK_product_dimension_dimension` (`dimension_id`),
  CONSTRAINT `FK_product_dimension_dimension` FOREIGN KEY (`dimension_id`) REFERENCES `dimension` (`dimension_id`),
  CONSTRAINT `FK_product_dimension_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_dimension`
--

LOCK TABLES `product_dimension` WRITE;
/*!40000 ALTER TABLE `product_dimension` DISABLE KEYS */;
INSERT INTO `product_dimension` VALUES (4,2,4,'1','123'),(10,2,6,'40',''),(12,4,6,'15',NULL),(13,4,7,'1200',NULL),(14,4,8,'zima',NULL),(15,5,6,'50',NULL),(16,5,7,'2000',NULL),(17,5,8,'zima',NULL),(18,2,9,'bílá',NULL);
/*!40000 ALTER TABLE `product_dimension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `file_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`file_id`,`product_id`),
  KEY `FK_product_images_product` (`product_id`),
  CONSTRAINT `FK_product_images_image` FOREIGN KEY (`file_id`) REFERENCES `file` (`file_id`),
  CONSTRAINT `FK_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(15,3),(16,4),(17,5),(18,6),(19,7);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource` (
  `resource_id` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka obsahující seznam zdrojů';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource`
--

LOCK TABLES `resource` WRITE;
/*!40000 ALTER TABLE `resource` DISABLE KEYS */;
INSERT INTO `resource` VALUES ('Admin:Category'),('Admin:Dashboard'),('Admin:Dimension'),('Admin:Error4xx'),('Admin:Product'),('Admin:ProductDimension'),('Admin:User'),('Category'),('Dimension'),('Front:Cart'),('Front:Error'),('Front:Error4xx'),('Front:Homepage'),('Front:Order'),('Front:Product'),('Front:User'),('Product'),('ProductDimension'),('User');
/*!40000 ALTER TABLE `resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES ('admin'),('authenticated'),('guest');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `facebook_id` varchar(100) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `role_id` varchar(50) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `facebook_id` (`facebook_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s daty uživatelů';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Karel Douda','kareldouda1@gmail.com',NULL,'admin','$2y$10$JYRM4WKd/UCEUvjoSIWyGu3qSBCMb.v0k0tBIZajlX2Ce/2GncR.q'),(6,'Lamo Lamovič','lama@lama.lama',NULL,NULL,'$2y$10$Nn3RioSA3FmoqiUcAWUjZ.nDE4D8dcvHsOyQdH1wO0yCbLgYW2UZm');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-13 14:58:11
