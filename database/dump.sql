/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`KantorMaks` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `KantorMaks`;

/*
CREATE TABLE `ExchangeRate` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `TypeId` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `Flag` varchar(255) DEFAULT NULL,
  `Position` tinyint(3) unsigned DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Currency` varchar(10) DEFAULT NULL,
  `OldPurchase` float unsigned DEFAULT NULL,
  `Purchase` float unsigned DEFAULT NULL,
  `OldSale` float unsigned DEFAULT NULL,
  `Sale` float unsigned DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*Data for the table `ExchangeRate` */

INSERT  INTO `ExchangeRate`(`Id`,`TypeId`,`Flag`,`Position`,`Country`,`Currency`,`OldPurchase`,`Purchase`,`OldSale`,`Sale`,`Timestamp`) values (1,1,'',1,'Stany Zjednoczone','USD',66666,555,66666,555,'2012-03-22 20:24:53'),(2,1,'http://www.gant.com.pl/images/flagi/EUR.png',2,'Unia Europejska','EUR',777777,777777,777777,777777,'2012-03-22 20:24:53'),(3,1,'',3,'Wielka Brytania','GBP',4.47,4.47,4.68,4.68,'2012-03-20 23:25:45'),(4,1,'',4,'Szwajcaria','CHF',3.49,3.49,3.56,3.56,'2012-03-20 23:25:45'),(5,1,'',5,'Australia','AUD',3.01,3.01,3.07,3.07,'2012-03-20 23:25:45'),(6,1,'',6,'Kanada','CAD',2.85,2.85,2.94,2.94,'2012-03-20 23:25:45'),(7,1,'',7,'Szwecja','SEK',0.435,0.435,0.45,0.45,'2012-03-20 23:25:45'),(8,1,'',8,'Węgry','HUF',0.014,0.014,0.016,0.016,'2012-03-20 23:25:45'),(9,1,'',9,'Dania','DKK',0.528,0.528,0.543,0.543,'2012-03-20 23:25:45'),(10,1,'',10,'Norwegia','NOK',0.508,0.508,0.523,0.523,'2012-03-20 23:25:45'),(11,1,'',11,'Czechy','CZK',0.162,0.162,0.168,0.168,'2012-03-20 23:25:45'),(12,1,'',12,'Słowacja','SKK',0,0,0,0,'2012-03-20 23:25:45'),(13,1,'',13,'UE bilon','EURb',3.3,3.3,3.8,3.8,'2012-03-20 23:25:46'),(14,2,'',1,'Stany Zjednoczone','USD',66666,66666,66666,66666,'2012-03-22 20:23:16'),(15,2,'',2,'Unia Europejska','EUR',3,3,4,4,'2012-03-20 23:25:46'),(16,2,'',3,'Wielka Brytania','GBP',4,4,4,4,'2012-03-20 23:25:46'),(17,2,'',4,'Szwajcaria','CHF',3,3,3,3,'2012-03-20 23:25:46'),(18,2,'',5,'Australia','AUD',3,3,3,3,'2012-03-20 23:25:46'),(19,2,'',6,'Kanada','CAD',2,2,2,2,'2012-03-20 23:25:46'),(20,2,'',7,'Szwecja','SEK',0,0,0,0,'2012-03-20 23:25:46'),(21,2,'',8,'Węgry','HUF',0,0,0,0,'2012-03-20 23:25:46'),(22,2,'',9,'Dania','DKK',0,0,0,0,'2012-03-20 23:25:46'),(23,2,'',10,'Norwegia','NOK',0,0,0,0,'2012-03-20 23:25:46'),(24,2,'',11,'Czechy','CZK',0,0,0,0,'2012-03-20 23:25:46'),(25,2,'',12,'Słowacja','SKK',0,0,0,0,'2012-03-20 23:25:46'),(26,2,'',13,'UE bilon','EURb',3.555,3.555,3,3,'2012-03-20 23:25:46');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;