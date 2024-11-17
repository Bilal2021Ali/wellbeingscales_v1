/*
SQLyog Ultimate
MySQL - 10.4.22-MariaDB : Database - qlicksystems_db
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

/*Table structure for table `v0_permissions` */

DROP TABLE IF EXISTS `v0_permissions`;

CREATE TABLE `v0_permissions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `dashboard` int(1) NOT NULL DEFAULT 0,
  `profile` int(1) NOT NULL DEFAULT 0,
  `addschool` int(1) NOT NULL DEFAULT 0,
  `schoollist` int(1) NOT NULL DEFAULT 0,
  `deptlist` int(1) NOT NULL DEFAULT 0,
  `categories` int(1) NOT NULL DEFAULT 0,
  `sitereports` int(1) NOT NULL DEFAULT 0,
  `aireports` int(1) NOT NULL DEFAULT 0,
  `labreports` int(1) NOT NULL DEFAULT 0,
  `wellbeing` int(1) NOT NULL DEFAULT 0,
  `Claimate` int(11) NOT NULL DEFAULT 0,
  `counselor` int(1) NOT NULL DEFAULT 0,
  `Air_quality` int(11) NOT NULL DEFAULT 0,
  `LoadFromCsv` int(11) NOT NULL DEFAULT 0,
  `TemperatureAndLab` int(11) DEFAULT 0,
  `cars` int(11) DEFAULT 0,
  `attendance` int(11) NOT NULL DEFAULT 0,
  `qmcommunity` int(1) NOT NULL DEFAULT 0,
  `courses` int(1) NOT NULL DEFAULT 0,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `visitors` int(11) DEFAULT 0,
  `surveys` int(1) NOT NULL DEFAULT 1,
  `Company_Type` int(11) DEFAULT NULL COMMENT 'from r_company_type',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `v0_permissions` */

insert  into `v0_permissions`(`Id`,`TimeStamp`,`user_id`,`user_type`,`dashboard`,`profile`,`addschool`,`schoollist`,`deptlist`,`categories`,`sitereports`,`aireports`,`labreports`,`wellbeing`,`Claimate`,`counselor`,`Air_quality`,`LoadFromCsv`,`TemperatureAndLab`,`cars`,`attendance`,`qmcommunity`,`courses`,`Created`,`Time`,`visitors`,`surveys`,`Company_Type`) values 
(1,'2022-02-27 11:36:21',1,'Ministry',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,'2023-02-19','02:20:09',1,0,NULL),
(2,'2022-02-27 11:36:21',2,'Company',0,0,0,0,0,0,0,0,0,1,1,0,0,1,1,0,0,1,1,'2022-02-27','09:36:21',0,0,NULL),
(3,'2022-02-28 11:13:47',5,'Ministry',0,0,0,0,0,0,0,0,0,1,1,0,1,1,1,1,0,1,1,'2022-02-28','12:13:50',1,0,NULL),
(4,'2022-02-28 16:10:56',6,'Ministry',0,0,0,0,0,0,0,0,0,1,1,0,1,1,1,1,0,1,1,'2022-02-28','05:11:00',1,0,NULL),
(5,'2022-03-14 09:26:23',10,'Ministry',0,0,0,0,0,0,0,0,0,1,0,0,1,1,1,0,0,1,1,'2022-03-14','10:26:25',0,0,1),
(6,'2023-02-19 15:47:41',7,'Ministry',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'2023-02-19','01:47:42',0,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
