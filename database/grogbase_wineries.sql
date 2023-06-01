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
-- Table structure for table `wineries`
--

DROP TABLE IF EXISTS `wineries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wineries` (
  `winery_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL DEFAULT '',
  `established` year(4) NOT NULL,
  `location` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `manager_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`winery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wineries`
--

LOCK TABLES `wineries` WRITE;
/*!40000 ALTER TABLE `wineries` DISABLE KEYS */;
INSERT INTO `wineries` VALUES (1,'J. Lohr','Located amidst rolling vineyards and breathtaking landscapes, our winery combines traditional craftsmanship with modern techniques. We take pride in producing exquisite wines that reflect the unique terroir of our region.',1950,'Paso Robles',' Central Coast',' US','www.J.Lohr.com',20),(2,'Antucura','Nestled in the heart of wine country, our family-owned winery is dedicated to creating wines that capture the essence of the land. With a meticulous approach to winemaking, we strive to deliver exceptional quality and a memorable experience for every wine lover.',1960,'Vista Flores',' Mendoza Province',' Argentina','www.Antucura.com',5),(3,'Quinta do Portal','Discover the artistry and passion behind our winery, where generations of winemakers have honed their skills. From vine to bottle, we carefully craft wines that showcase the rich flavors and distinct character of our vineyards.',1949,'Douro','',' Portugal','www.QuintadoPortal.com',17),(4,'Tenuta di Ghizzano','Journey to our boutique winery, hidden away in a picturesque valley. Experience the harmony of nature and winemaking as we produce small-batch wines that celebrate the harmony of fruit, oak, and time.',1956,'Toscana',' Tuscany',' Italy','www.TenutadiGhizzano.com',20),(5,'Tenuta San Francesco','At our modern winery, innovation meets tradition. Our winemakers are constantly pushing boundaries to create unique and captivating wines. Explore our portfolio and indulge in the artistry of our winemaking.',1957,'Campania',' Southern Italy',' Italy','www.TenutaSanFrancesco.com',11),(6,'Las Positas','Step into our historic winery, where time-honored traditions are preserved. With a legacy spanning decades, we continue to produce wines of exceptional quality and finesse, blending old-world techniques with a touch of modern elegance.',1961,'Livermore Valley',' Central Coast',' US','www.LasPositas.com',20),(7,'Krupp Brothers','Situated amidst lush vineyards, our sustainable winery is committed to environmental stewardship. From organic farming practices to eco-friendly production methods, we strive to create wines that are not only delicious but also respectful of the earth.',1957,'Napa Valley',' Napa',' US','www.KruppBrothers.com',17);
/*!40000 ALTER TABLE `wineries` ENABLE KEYS */;
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
