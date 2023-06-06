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
-- Table structure for table `wines`
--

DROP TABLE IF EXISTS `wines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wines` (
  `wine_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL DEFAULT '',
  `type` enum('Red','White','Rose','Orange','Sparkling','Fortified','Ice','Dessert','Other','Non-Alcoholic') NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `winery` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wine_id`),
  KEY `FK_winery` (`winery`),
  CONSTRAINT `FK_winery` FOREIGN KEY (`winery`) REFERENCES `wineries` (`winery_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wines`
--

LOCK TABLES `wines` WRITE;
/*!40000 ALTER TABLE `wines` DISABLE KEYS */;
INSERT INTO `wines` VALUES (1,'J. Lohr 2000 Hilltop Vineyard Cabernet Sauvignon (Paso Robles)','Held back nearly five years, this Cab still has some sturdy tannins, but I would drink it now because the fruit\'s in a precarious position. It\'s rich and tasty now in black currants and cherries, but too soft to age.','Red',2000,32,7),(2,'Antucura 2010 Pinot Noir (Vista Flores)','Rubbery, bold and earthy on the nose, then full and sticky in the mouth, with sweet black fruit flavors. Tastes more like a Bordeaux red wine than textbook Pinot Noir courtesy of heavy extraction, darkness and oak. Tastes good but could use a lesson in elegance and restraint.','Red',2010,17,4),(3,'J. Lohr 2000 Hilltop Vineyard Cabernet Sauvignon (Paso Robles)','Held back nearly five years, this Cab still has some sturdy tannins, but I would drink it now because the fruit\'s in a precarious position. It\'s rich and tasty now in black currants and cherries, but too soft to age.','Red',2000,32,4),(4,'Antucura 2010 Pinot Noir (Vista Flores)','Rubbery, bold and earthy on the nose, then full and sticky in the mouth, with sweet black fruit flavors. Tastes more like a Bordeaux red wine than textbook Pinot Noir courtesy of heavy extraction, darkness and oak. Tastes good but could use a lesson in elegance and restraint.','Red',2010,17,3),(5,'Quinta do Portal 1999 Quinta do Portal Reserva Red (Douro)','Smoky, meaty aromas lead into perfumed fruit flavors. The tannins are soft but dry; the fruit is very aromatic with a touch of violets and some rich, dark tannins underneath. The wine will age well—probably 5–10 years. —R.V.','Red',1999,21,7),(6,'Tenuta di Ghizzano 2006 Il Ghizzano Red (Toscana)','The nose is rather neutral save for distant aromas of cherry fruit, boysenberry and spice. However, the mouthfeel is more interesting thanks to the wine\'s chewy succulence and fresh, zesty close: An 80-20 blend of Sangiovese and Merlot.','Red',2006,18,6),(7,'Tenuta San Francesco 2007 Tramonti White (Campania)','This intriguing blend of Falanghina, Biancolella and Pepella (three relatively unknown indigenous grapes) has a candy- or soda-like quality that recalls butterscotch and caramel. However, those notes are balanced by an elegant mineral tone and the wine has good dimension on the close.','White',2007,21,5),(8,'Las Positas 2011 Estate Barbera (Livermore Valley)','This is a hefty Barbera, replete with dark, brooding layers of rich cinnamon and anise, especially aromatically, and a chewy texture. Structured, it\'s leathery yet juicy, touched by oak, with a suggestion of petrol on the finish. But with Nonna\'s lasagne? Great.','Red',2011,40,3),(9,'Krupp Brothers 2007 The Doctor Red (Napa Valley)','An ambitious blend of Merlot, Tempranillo, Malbec and Cabernet Sauvignon, grown mainly on Atlas Peak. It\'s bone dry and locked down in tannins and acidity, offering little relief, but there\'s a potent core of blackberries and black currants that yearns to bust through. Clearly well grown, it could be an ager, but predictions are risky.','Red',2007,60,5),(10,'J. Lohr 2000 Hilltop Vineyard Cabernet Sauvignon (Paso Robles)','Held back nearly five years, this Cab still has some sturdy tannins, but I would drink it now because the fruit\'s in a precarious position. It\'s rich and tasty now in black currants and cherries, but too soft to age.','Red',2000,32,4),(11,'Antucura 2010 Pinot Noir (Vista Flores)','Rubbery, bold and earthy on the nose, then full and sticky in the mouth, with sweet black fruit flavors. Tastes more like a Bordeaux red wine than textbook Pinot Noir courtesy of heavy extraction, darkness and oak. Tastes good but could use a lesson in elegance and restraint.','Red',2010,17,3),(12,'Quinta do Portal 1999 Quinta do Portal Reserva Red (Douro)','Smoky, meaty aromas lead into perfumed fruit flavors. The tannins are soft but dry; the fruit is very aromatic with a touch of violets and some rich, dark tannins underneath. The wine will age well—probably 5–10 years. —R.V.','Red',1999,21,7),(13,'Tenuta di Ghizzano 2006 Il Ghizzano Red (Toscana)','The nose is rather neutral save for distant aromas of cherry fruit, boysenberry and spice. However, the mouthfeel is more interesting thanks to the wine\'s chewy succulence and fresh, zesty close: An 80-20 blend of Sangiovese and Merlot.','Red',2006,18,6),(14,'Tenuta San Francesco 2007 Tramonti White (Campania)','This intriguing blend of Falanghina, Biancolella and Pepella (three relatively unknown indigenous grapes) has a candy- or soda-like quality that recalls butterscotch and caramel. However, those notes are balanced by an elegant mineral tone and the wine has good dimension on the close.','White',2007,21,5),(15,'Las Positas 2011 Estate Barbera (Livermore Valley)','This is a hefty Barbera, replete with dark, brooding layers of rich cinnamon and anise, especially aromatically, and a chewy texture. Structured, it\'s leathery yet juicy, touched by oak, with a suggestion of petrol on the finish. But with Nonna\'s lasagne? Great.','Red',2011,40,3),(16,'Krupp Brothers 2007 The Doctor Red (Napa Valley)','An ambitious blend of Merlot, Tempranillo, Malbec and Cabernet Sauvignon, grown mainly on Atlas Peak. It\'s bone dry and locked down in tannins and acidity, offering little relief, but there\'s a potent core of blackberries and black currants that yearns to bust through. Clearly well grown, it could be an ager, but predictions are risky.','Red',2007,60,5),(17,'J. Lohr 2000 Hilltop Vineyard Cabernet Sauvignon (Paso Robles)','Held back nearly five years, this Cab still has some sturdy tannins, but I would drink it now because the fruit\'s in a precarious position. It\'s rich and tasty now in black currants and cherries, but too soft to age.','Red',2000,32,2),(18,'Antucura 2010 Pinot Noir (Vista Flores)','Rubbery, bold and earthy on the nose, then full and sticky in the mouth, with sweet black fruit flavors. Tastes more like a Bordeaux red wine than textbook Pinot Noir courtesy of heavy extraction, darkness and oak. Tastes good but could use a lesson in elegance and restraint.','Red',2010,17,6),(19,'Quinta do Portal 1999 Quinta do Portal Reserva Red (Douro)','Smoky, meaty aromas lead into perfumed fruit flavors. The tannins are soft but dry; the fruit is very aromatic with a touch of violets and some rich, dark tannins underneath. The wine will age well—probably 5–10 years. —R.V.','Red',1999,21,5),(20,'Tenuta di Ghizzano 2006 Il Ghizzano Red (Toscana)','The nose is rather neutral save for distant aromas of cherry fruit, boysenberry and spice. However, the mouthfeel is more interesting thanks to the wine\'s chewy succulence and fresh, zesty close: An 80-20 blend of Sangiovese and Merlot.','Red',2006,18,1),(21,'Tenuta San Francesco 2007 Tramonti White (Campania)','This intriguing blend of Falanghina, Biancolella and Pepella (three relatively unknown indigenous grapes) has a candy- or soda-like quality that recalls butterscotch and caramel. However, those notes are balanced by an elegant mineral tone and the wine has good dimension on the close.','White',2007,21,5),(22,'Las Positas 2011 Estate Barbera (Livermore Valley)','This is a hefty Barbera, replete with dark, brooding layers of rich cinnamon and anise, especially aromatically, and a chewy texture. Structured, it\'s leathery yet juicy, touched by oak, with a suggestion of petrol on the finish. But with Nonna\'s lasagne? Great.','Red',2011,40,7),(23,'Krupp Brothers 2007 The Doctor Red (Napa Valley)','An ambitious blend of Merlot, Tempranillo, Malbec and Cabernet Sauvignon, grown mainly on Atlas Peak. It\'s bone dry and locked down in tannins and acidity, offering little relief, but there\'s a potent core of blackberries and black currants that yearns to bust through. Clearly well grown, it could be an ager, but predictions are risky.','Red',2007,60,6),(24,'Yvon Mau NV Premius Brut Rosé  (Crémant de Bordeaux)','Made in a traditional style, this is a fruity, crisp blend of Cabernet Franc and Merlot. With its freshness allied to the attractive strawberry flavors, the wine has both a ripe character and a buoyant mousse and aftertaste. Drink now.','Sparkling',2004,19,5),(25,'Gunter Triebaumer 2006 Blaufränkisch (Burgenland)','A big, ripe wine, full of berry fruits and rhubarb, edged with tannins, spice and red plum skins. It has a juicy, rich quality, enhanced by acidity, and rounded with vanilla. Keep for a year. Screwcap.','Red',2006,16,5),(26,'Ata Rangi 2016 Crimson Pinot Noir (Martinborough)','Founder Clive Paton is a keen conservationist, and proceeds from the sale of this wine go toward Project Crimson, which replants threatened red-flowering trees around New Zealand. The nose is a little reductive, requiring a few minutes to get going in the glass, but when it does, it\'s quite fragrant, with bright red berry fruit, potpourri, floral, pepper and sap characters. It\'s medium bodied, and the juicy, slippery fruit is tightly wound with sappy, earthy tannins and slightly bitter oak spice. Drink now–2024.','Red',2016,30,4);
/*!40000 ALTER TABLE `wines` ENABLE KEYS */;
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
