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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,NULL,'2022-01-08 09:07:27'),(2,NULL,'2022-01-08 09:07:31'),(3,NULL,'2022-01-08 09:26:22'),(4,NULL,'2022-01-08 09:28:04'),(5,NULL,'2022-01-08 10:11:07'),(6,NULL,'2022-01-08 10:11:08'),(7,NULL,'2022-01-08 10:11:14'),(8,1,'2022-01-08 12:44:13'),(9,NULL,'2022-01-08 10:35:56'),(10,NULL,'2022-01-08 10:40:13'),(11,NULL,'2022-01-08 10:41:11'),(12,NULL,'2022-01-08 10:41:32'),(13,NULL,'2022-01-08 10:42:24'),(14,NULL,'2022-01-08 10:51:42'),(15,NULL,'2022-01-08 10:54:41'),(16,NULL,'2022-01-08 10:56:52'),(17,NULL,'2022-01-08 11:00:24'),(18,NULL,'2022-01-08 11:00:28'),(19,NULL,'2022-01-08 11:01:17'),(20,NULL,'2022-01-08 11:01:41'),(21,NULL,'2022-01-08 11:01:57'),(22,NULL,'2022-01-08 11:02:03'),(23,NULL,'2022-01-08 11:02:25'),(24,NULL,'2022-01-08 11:03:36'),(25,NULL,'2022-01-08 11:04:06'),(26,NULL,'2022-01-08 11:04:16'),(27,NULL,'2022-01-08 11:04:19'),(28,NULL,'2022-01-08 11:04:38'),(29,NULL,'2022-01-08 11:04:45'),(30,NULL,'2022-01-08 11:05:03'),(31,NULL,'2022-01-08 11:05:13'),(32,NULL,'2022-01-08 11:05:44'),(33,NULL,'2022-01-08 11:06:00'),(34,NULL,'2022-01-08 11:06:36'),(35,NULL,'2022-01-08 11:06:59'),(36,NULL,'2022-01-08 11:07:11'),(37,NULL,'2022-01-08 11:07:13'),(38,NULL,'2022-01-08 11:07:40'),(39,NULL,'2022-01-08 11:07:47'),(40,NULL,'2022-01-08 11:07:54'),(41,NULL,'2022-01-08 11:08:08'),(42,NULL,'2022-01-08 11:08:23'),(43,NULL,'2022-01-08 11:08:31'),(44,NULL,'2022-01-08 11:08:52'),(45,NULL,'2022-01-08 11:08:59'),(46,NULL,'2022-01-08 11:09:05'),(47,NULL,'2022-01-08 11:09:15'),(48,NULL,'2022-01-08 11:09:18'),(49,NULL,'2022-01-08 11:09:34'),(50,NULL,'2022-01-08 11:09:51'),(51,NULL,'2022-01-08 11:09:56'),(52,NULL,'2022-01-08 11:10:40'),(53,NULL,'2022-01-08 11:10:46'),(54,NULL,'2022-01-08 11:11:05'),(55,NULL,'2022-01-08 11:11:28'),(56,NULL,'2022-01-08 11:11:39'),(57,NULL,'2022-01-08 11:11:43'),(58,NULL,'2022-01-08 11:11:52'),(59,NULL,'2022-01-08 11:26:21'),(60,NULL,'2022-01-08 11:26:30'),(61,NULL,'2022-01-08 11:26:46'),(62,NULL,'2022-01-08 12:06:24'),(63,NULL,'2022-01-08 12:08:20'),(64,NULL,'2022-01-08 12:08:21'),(65,NULL,'2022-01-08 12:08:23'),(66,NULL,'2022-01-08 12:09:56'),(67,NULL,'2022-01-08 12:19:29');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_item`
--

LOCK TABLES `cart_item` WRITE;
/*!40000 ALTER TABLE `cart_item` DISABLE KEYS */;
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
INSERT INTO `category` VALUES (1,'Lama','Lamy, známé též jako velbloudi Jižní Ameriky, jsou zvířata z čeledi velbloudovití, která se přizpůsobila těžkému životu v Andách. V posledních 40 letech se šíří do celého světa jako chovný dobytek či zvěř chovaná v zoologických zahradách. '),(2,'Příslušenství','Příslušenství k chovu lam.'),(3,'Krmivo','Krmivo pro lamy a podobná zvířata.');
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
INSERT INTO `category_dimension` VALUES (1,3),(1,4),(1,6),(3,6),(3,7),(3,8);
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
  PRIMARY KEY (`dimension_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dimension`
--

LOCK TABLES `dimension` WRITE;
/*!40000 ALTER TABLE `dimension` DISABLE KEYS */;
INSERT INTO `dimension` VALUES (3,'Šířka (m)',''),(4,'Výška (m)',''),(5,'Hloubka (m)',''),(6,'Hmotnost (kg)',''),(7,'Objem (L)','Objem v litrech.'),(8,'Roční období','Pro jaké roční období je krmivo vhodné.');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (1,'1641252485_2_tshirt-agyle.png',312331,553,510),(2,'1641252496_2_roadsign-top-samurai.png',341932,679,422),(3,'1641252571_2_pants-northern-forester.png',417669,541,738),(4,'1641253206_2_pants-outlaw.png',333977,449,705),(5,'1641253206_2_pants-steppe-camo.png',278900,383,703),(6,'1641253206_2_roadsign-top-dominator.png',286807,559,424),(7,'1641253235_2_pants-steppe-camo.png',278900,383,703),(8,'1641253235_2_roadsign-top-dominator.png',286807,559,424),(9,'1641253235_2_roadsign-top-last-viking.png',279585,552,443),(10,'1641253235_2_roadsign-top-nordic.png',349598,640,482),(11,'1641253235_2_roadsign-top-samurai.png',341932,679,422),(12,'1641253235_2_roadsign-top-snapturtle.png',370902,687,452),(13,'1641640801_3_kartac.jpeg',24458,500,500),(14,'1641640823_3_kartac.jpeg',24458,500,500),(15,'1641640876_3_kartac.jpeg',24458,500,500),(16,'1641640971_4_seno.jpeg',276918,1200,954),(17,'1641641154_5_seno2.jpeg',197520,1024,767);
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (22,'admin','Admin:Category','','allow'),(21,'admin','Admin:Dashboard','','allow'),(29,'admin','Admin:Dimension','','allow'),(30,'admin','Admin:Dimension','delete','allow'),(24,'admin','Admin:Product','','allow'),(36,'admin','Admin:Product','deletePhoto','allow'),(32,'admin','Admin:ProductDimension','','allow'),(33,'admin','Admin:ProductDimension','delete','allow'),(12,'admin','Category','','allow'),(31,'admin','Dimension','','allow'),(23,'admin','Product','','allow'),(35,'admin','Product','delete','allow'),(37,'admin','Product','deletePhoto','allow'),(34,'admin','ProductDimension','delete','allow'),(40,'authenticated','Front:Cart','','allow'),(4,'authenticated','Front:Error','','allow'),(5,'authenticated','Front:Error4xx','','allow'),(6,'authenticated','Front:Homepage','','allow'),(28,'authenticated','Front:Product','','allow'),(9,'authenticated','Front:User','login','allow'),(10,'authenticated','Front:User','logout','allow'),(27,'authenticated','Product','','allow'),(41,'guest','Front:Cart','','allow'),(1,'guest','Front:Error','','allow'),(2,'guest','Front:Error4xx','','allow'),(3,'guest','Front:Homepage','','allow'),(26,'guest','Front:Product','','allow'),(15,'guest','Front:User','facebookLogin','allow'),(13,'guest','Front:User','forgottenPassword','allow'),(7,'guest','Front:User','login','allow'),(8,'guest','Front:User','logout','allow'),(11,'guest','Front:User','register','allow'),(14,'guest','Front:User','renewPassword','allow'),(25,'guest','Product','','allow');
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
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `url` (`url`),
  KEY `available` (`available`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s nabízenými produkty';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Test','test','test',10.00,'jpg',1),(2,'Dobrá lama','dobra-lama','test',123.00,'jpeg',1),(3,'Kartáč','kartac','Každá milovaná lama musí mít kvalitní kartáč.',120.00,'',1),(4,'Seno 1200L','seno-1200l','Seno v množství 1200 L. Vhodné pro krmení v zimě.',500.00,'',1),(5,'Seno balík','seno-balik','Seno v klasickém kulatém balíku. Krmení pro Vaší lamu, zábava pro vás.',1000.00,'',1);
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
INSERT INTO `product_category` VALUES (2,1),(2,2),(2,3),(3,2),(4,3),(5,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_dimension`
--

LOCK TABLES `product_dimension` WRITE;
/*!40000 ALTER TABLE `product_dimension` DISABLE KEYS */;
INSERT INTO `product_dimension` VALUES (4,2,4,'1','123'),(10,2,6,'40',''),(12,4,6,'15',NULL),(13,4,7,'1200',NULL),(14,4,8,'zima',NULL),(15,5,6,'50',NULL),(16,5,7,'2000',NULL),(17,5,8,'zima',NULL);
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
INSERT INTO `product_images` VALUES (6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(15,3),(16,4),(17,5);
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
INSERT INTO `resource` VALUES ('Admin:Category'),('Admin:Dashboard'),('Admin:Dimension'),('Admin:Error4xx'),('Admin:Product'),('Admin:ProductDimension'),('Category'),('Dimension'),('Front:Cart'),('Front:Error'),('Front:Error4xx'),('Front:Homepage'),('Front:Product'),('Front:User'),('Product'),('ProductDimension');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s daty uživatelů';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Karel Douda','kareldouda1@gmail.com',NULL,'admin','$2y$10$JYRM4WKd/UCEUvjoSIWyGu3qSBCMb.v0k0tBIZajlX2Ce/2GncR.q'),(2,'user','user@user.user',NULL,'admin','$2y$10$8Q8f8ODAbsEkunrWAfOjeu.BMnq6k5Fz5gJbIt2vxLy2m70NDjxxS'),(3,'Tes Test','test@test.com',NULL,'admin','$2y$10$71/BeHdXdlf49gbFhXygQeDUmrtvkrFtinPnh2fTSIXwgV.JyMrfO');
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

-- Dump completed on 2022-01-08 12:46:19

ALTER TABLE product ADD featured TINYINT(1) DEFAULT 0;