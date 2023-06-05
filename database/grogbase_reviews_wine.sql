-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: wheatley.cs.up.ac.za    Database: u22563777_grogbase
-- ------------------------------------------------------
-- Server version	10.3.31-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `reviews_wine`
--

DROP TABLE IF EXISTS `reviews_wine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews_wine` (
  `user_id` int(10) unsigned NOT NULL,
  `wine_id` int(10) unsigned NOT NULL,
  `points` tinyint(3) unsigned NOT NULL,
  `review` text NOT NULL,
  `drunk` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`,`wine_id`),
  KEY `FK_review_wine` (`wine_id`),
  CONSTRAINT `FK_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_review_wine` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`wine_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_wine`
--

LOCK TABLES `reviews_wine` WRITE;
/*!40000 ALTER TABLE `reviews_wine` DISABLE KEYS */;
INSERT INTO `reviews_wine` VALUES (7,2,6,'I had mixed feelings about this wine. It had a light and fruity flavor, but it lacked depth and complexity. Not my favorite.',0),(7,13,7,'I enjoyed a glass of this wine with dinner. It had a smooth finish and a medium body. Not too strong, but definitely enjoyable.',0),(13,14,8,'I had a great time with friends, sipping on this wine. It had a balanced taste with a touch of sweetness. Perfect for a relaxed evening!',1),(16,6,9,'I got a bit tipsy after a couple of glasses of this wine. It has a bold and robust taste with intense aromas of black cherry and chocolate. Loved it!',1),(16,16,8,'This wine got me pleasantly drunk. It has a rich and complex flavor profile with notes of dark berries and a hint of oak. I would highly recommend it!',1);
/*!40000 ALTER TABLE `reviews_wine` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-31 10:48:02
