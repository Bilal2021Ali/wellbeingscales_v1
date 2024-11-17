/*
SQLyog Ultimate
MySQL - 5.7.40-log : Database - qlicksystems_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`qlicksystems_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `qlicksystems_db`;

/*Table structure for table `l2_family` */

DROP TABLE IF EXISTS `l2_family`;

CREATE TABLE `l2_family` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prefix` varchar(255) NOT NULL DEFAULT 'Mr',
  `F_name_EN` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL COMMENT 'from r_Gender',
  `Relation_Id` int(11) NOT NULL COMMENT 'from r_relation',
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `watch_mac` varchar(128) NOT NULL DEFAULT 'Bind Watch',
  `ring_mac` varchar(128) DEFAULT 'Ring_mac',
  `adding_method` varchar(200) DEFAULT 'page',
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `language` varchar(11) NOT NULL DEFAULT 'en' COMMENT 'Arabic =ar ,English =en',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `l2_family` */

/*Table structure for table `l2_student_document` */

DROP TABLE IF EXISTS `l2_student_document`;

CREATE TABLE `l2_student_document` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` int(11) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Document_Id` int(11) NOT NULL COMMENT 'from r_document',
  `Report_link` varchar(255) DEFAULT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `l2_student_document` */

/*Table structure for table `l2_temp_family` */

DROP TABLE IF EXISTS `l2_temp_family`;

CREATE TABLE `l2_temp_family` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prefix` varchar(255) NOT NULL DEFAULT 'Mr',
  `F_name_EN` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL COMMENT 'from r_Gender',
  `Relation_Id` int(11) NOT NULL COMMENT 'from r_relation',
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `watch_mac` varchar(128) NOT NULL DEFAULT 'Bind Watch',
  `ring_mac` varchar(128) DEFAULT 'Ring_mac',
  `adding_method` varchar(200) DEFAULT 'page',
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `language` varchar(11) NOT NULL DEFAULT 'en' COMMENT 'Arabic =ar ,English =en',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `l2_temp_family` */

/*Table structure for table `r_document` */

DROP TABLE IF EXISTS `r_document`;

CREATE TABLE `r_document` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Document` varchar(150) DEFAULT NULL,
  `Comments` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `r_document` */

insert  into `r_document`(`Id`,`TimeStamp`,`Document`,`Comments`) values 
(1,'2023-03-14 13:41:11','QID',NULL),
(2,'2023-03-14 13:41:21','Health Card',NULL);

/*Table structure for table `r_relation` */

DROP TABLE IF EXISTS `r_relation`;

CREATE TABLE `r_relation` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `relation_ar` varchar(150) DEFAULT NULL,
  `relation_en` varchar(150) DEFAULT NULL,
  `Comments` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `r_relation` */

insert  into `r_relation`(`Id`,`TimeStamp`,`relation_ar`,`relation_en`,`Comments`) values 
(1,'2023-03-14 13:32:34','أب','Father',NULL),
(2,'2023-03-14 12:32:45','الأم','Mother',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
