-- MySQL dump 10.16  Distrib 10.1.31-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: book
-- ------------------------------------------------------
-- Server version	10.1.31-MariaDB

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
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `idbook` varchar(20) NOT NULL,
  `kat` varchar(250) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  PRIMARY KEY (`idbook`,`kat`),
  CONSTRAINT `idbook` FOREIGN KEY (`idbook`) REFERENCES `penjualan` (`idbook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES ('0-1LTfwEeq0C','Fiction'),('38ZQOiEpDvQC','Juvenile Fiction'),('3sSVzLsHIb8C','Uncategorized'),('4MwXAAAAYAAJ','Uncategorized'),('BQLwo39frsgC','Comics & Graphic Novels'),('CcFNCgAAQBAJ','Fiction / General'),('CcFNCgAAQBAJ','Juvenile Fiction / Humorous Stories'),('CcFNCgAAQBAJ','Juvenile Fiction / Love & Romance'),('dQZmAgAAQBAJ','Juvenile Fiction / Horror'),('dQZmAgAAQBAJ','Juvenile Fiction / Love & Romance'),('dURGDwAAQBAJ','Family & Relationships'),('FLL83L6lDfIC','Uncategorized'),('HgIVMqrVJd8C','Juvenile Fiction'),('hR84AQAAQBAJ','Juvenile Nonfiction / Performing Arts / Film'),('NAc8p9CXff4C','Uncategorized'),('nciBAAAAQBAJ','Juvenile Fiction'),('rHPbQ9R87MQC','Uncategorized'),('ssCuWsY3dskC','Juvenile Fiction'),('ssCuWsY3dskC','Juvenile Fiction / Action & Adventure / General'),('ssCuWsY3dskC','Juvenile Fiction / Comics & Graphic Novels / Superheroes'),('ssCuWsY3dskC','Juvenile Fiction / Media Tie-In'),('ssCuWsY3dskC','Juvenile Fiction / Readers / Beginner'),('tOD9AwAAQBAJ','Humorous stories'),('U1QQVig-DuIC','Family & Relationships'),('uC-uAgAAQBAJ','Juvenile Fiction'),('v19OswEACAAJ','Young Adult Fiction / Girls & Women'),('v19OswEACAAJ','Young Adult Fiction / Romance / Contemporary'),('v19OswEACAAJ','Young Adult Fiction / Social Themes / Dating & Sex'),('VfWI-JB8kjsC','Juvenile Fiction'),('xsIZEhS0DrIC','Juvenile Fiction'),('xsIZEhS0DrIC','Juvenile Fiction / Action & Adventure / General'),('xsIZEhS0DrIC','Juvenile Fiction / Fantasy & Magic'),('xsIZEhS0DrIC','Juvenile Fiction / Media Tie-In'),('xVBbEzRjBZoC','Children\'s stories'),('YLtIBAAAQBAJ','Juvenile Fiction / Love & Romance'),('z-VfDeuhq6kC','Young Adult Fiction / Media Tie-In'),('z-VfDeuhq6kC','Young Adult Fiction / Romance / Contemporary'),('z-VfDeuhq6kC','Young Adult Fiction / Social Themes / Dating & Sex'),('ZKk2Nuc20dQC','Presidents'),('_8haYvWoKfYC','Juvenile Fiction'),('_rn3DAEACAAJ','Juvenile Nonfiction'),('_XEVAAAAYAAJ','Uncategorized');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualan` (
  `idbook` varchar(20) NOT NULL,
  `harga` float DEFAULT NULL,
  `totalpenjualan` int(11) DEFAULT NULL,
  PRIMARY KEY (`idbook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan`
--

LOCK TABLES `penjualan` WRITE;
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
INSERT INTO `penjualan` VALUES ('0-1LTfwEeq0C',4041,0),('38ZQOiEpDvQC',75403,0),('3sSVzLsHIb8C',0,0),('4MwXAAAAYAAJ',0,0),('BQLwo39frsgC',0,0),('CcFNCgAAQBAJ',0,0),('dHKJAwAAQBAJ',43000,0),('dQZmAgAAQBAJ',50000,16),('dURGDwAAQBAJ',39000,0),('FLL83L6lDfIC',63479,0),('fwI0XAUZxjQC',0,0),('HgIVMqrVJd8C',0,0),('hIVxHQAACAAJ',0,0),('hR84AQAAQBAJ',0,0),('i44wDwAAQBAJ',75000,0),('JsxNtAEACAAJ',0,0),('NAc8p9CXff4C',0,0),('nciBAAAAQBAJ',8900,0),('qoUrAAAAIAAJ',0,0),('rHPbQ9R87MQC',0,0),('ryr9WXfrKIkC',0,0),('ssCuWsY3dskC',35000,0),('tOD9AwAAQBAJ',0,0),('U1QQVig-DuIC',0,0),('uC-uAgAAQBAJ',86335,0),('UuER-81srSEC',0,0),('v19OswEACAAJ',0,0),('VfWI-JB8kjsC',8900,0),('WsFWPwAACAAJ',0,0),('xsIZEhS0DrIC',8900,0),('xVBbEzRjBZoC',0,0),('YLtIBAAAQBAJ',78000,2),('z-VfDeuhq6kC',50000,0),('ZKk2Nuc20dQC',0,0),('_8haYvWoKfYC',8900,0),('_rn3DAEACAAJ',0,0),('_vy8Syc9g-gC',0,0),('_XEVAAAAYAAJ',0,0);
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-30 16:02:35
