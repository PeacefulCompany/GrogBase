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
-- Table structure for table `reviews_winery`
--

DROP TABLE IF EXISTS `reviews_winery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews_winery` (
  `winery_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `points` tinyint(3) unsigned NOT NULL,
  `review` text NOT NULL,
  PRIMARY KEY (`winery_id`,`user_id`),
  KEY `FK_wreview_user` (`user_id`),
  CONSTRAINT `FK_wreview_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_wreview_winery` FOREIGN KEY (`winery_id`) REFERENCES `wineries` (`winery_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_winery`
--

LOCK TABLES `reviews_winery` WRITE;
/*!40000 ALTER TABLE `reviews_winery` DISABLE KEYS */;
INSERT INTO `reviews_winery` VALUES (2,19,6,'I visited this winery with high expectations but was somewhat disappointed. The wines were average, lacking complexity and depth. The service was mediocre, and the tasting room felt crowded.'),(3,7,9,'This winery is truly exceptional. The ambiance is beautiful, and the staff is knowledgeable and friendly. The wines are exquisite, with a wide range of flavors to choose from. Highly recommended!'),(4,13,8,'I had a great experience visiting this winery. The tasting room was inviting, and the staff was helpful in guiding me through the wine selection. The wines were delicious, especially the red blends.'),(6,19,9,'This winery is truly exceptional. The ambiance is beautiful, and the staff is knowledgeable and friendly. The wines are exquisite, with a wide range of flavors to choose from. Highly recommended!'),(7,13,9,'I had an amazing time at this winery. The vineyards were stunning, and the wine tasting experience was top-notch. The wines were superb, particularly the Chardonnay and Pinot Noir.'),(7,16,7,'This winery has a nice atmosphere, and the wines are decent. The staff was friendly, although they seemed a bit overwhelmed during peak hours. Overall, a satisfactory experience.');
/*!40000 ALTER TABLE `reviews_winery` ENABLE KEYS */;
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
