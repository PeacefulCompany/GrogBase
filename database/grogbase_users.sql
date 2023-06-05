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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('User','Critic','Manager','Admin') NOT NULL DEFAULT 'User',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UK_USER` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mason','Stuart','Jerry@Suspendisse.org','f3G#k7rMx&','User'),(2,'Rachel','Hester','Kenyon@sollicitudin.org','P@ssw0rd123!','Manager'),(3,'Caesar','Robinson','Katelyn@amet.net','QW8r#h%2T','Critic'),(4,'Portia','Melendez','Yolanda@rutrum.org','x9$z6&v5P@','User'),(5,'Ivan','Molina','Bruce@laoreet.org','7s@Df4gT','Manager'),(6,'Driscoll','Bradford','Illiana@tempus.net','b2@L!c8Hn','Critic'),(7,'Quentin','Guerra','Ross@consectetuer.net','R#p5*Yq9S!','User'),(8,'Blythe','Rutledge','Gavin@orci.gov','M8s@k4Zv7!','Manager'),(9,'Grace','Santos','Noel@sapien.com','#q7r2Gf4T','Critic'),(10,'Mark','Wade','Ryder@facilisis.gov','P!w5D@r9S','User'),(11,'Nash','Mcgowan','Bo@aliquet.edu','L$7v#d3Np','Manager'),(12,'Vielka','Spears','Abraham@vulputate.us','9c@B#j4Zm','Critic'),(13,'Evan','Stafford','Rae@faucibus.org','Xp9$z6*Y','User'),(14,'Lael','Hughes','Micah@ullamcorper.us','T4h@W3q2P','Manager'),(15,'Curran','Black','Hunter@vel.net','6N!j7Xm#','Critic'),(16,'Jemima','Conner','Tanisha@erat.org','3v@S#k9Bd','User'),(17,'Frances','Caldwell','Amelia@fames.gov','5m#J&d7Rz','Manager'),(18,'Sasha','Velasquez','Declan@ut.org','W!7y4Qb9K','Critic'),(19,'Len','Odonnell','Michael@pulvinar.gov','F6@q3z#Xv','User'),(20,'Hedwig','Soto','Hiram@montes.com','D!2s%P7rC','Manager');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
