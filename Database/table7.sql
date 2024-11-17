/*
SQLyog Ultimate
MySQL - 10.4.27-MariaDB : Database - qlicksystems_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`qlicksystems_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `qlicksystems_db`;

/*Table structure for table `l2_vehicle_students` */

DROP TABLE IF EXISTS `l2_vehicle_students`;

CREATE TABLE `l2_vehicle_students` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `Added_by` int(11) NOT NULL,
  `Company_Type` int(11) DEFAULT NULL COMMENT 'from r_Gender',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `P_Buss_am` date DEFAULT NULL,
  `Off_Buss_am` date DEFAULT NULL,
  `P_Buss_pm` date DEFAULT NULL,
  `Off_Buss_pm` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `l2_vehicle_students` */

insert  into `l2_vehicle_students`(`Id`,`student_id`,`car_id`,`Added_by`,`Company_Type`,`TimeStamp`,`P_Buss_am`,`Off_Buss_am`,`P_Buss_pm`,`Off_Buss_pm`) values 
(1,6,1,3,NULL,'2023-02-28 11:54:48',NULL,NULL,NULL,NULL);

/*Table structure for table `r_attendance_rule` */

DROP TABLE IF EXISTS `r_attendance_rule`;

CREATE TABLE `r_attendance_rule` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Added_By` varchar(255) NOT NULL,
  `ruletype` int(11) NOT NULL DEFAULT 1 COMMENT '1-once,2-twice,3-three',
  `rule_a_in` time NOT NULL DEFAULT '00:00:00',
  `rule_a_out` time NOT NULL DEFAULT '00:00:00',
  `rule_b_in` time DEFAULT NULL,
  `rule_b_out` time DEFAULT NULL,
  `rule_c_in` time DEFAULT NULL,
  `rule_c_out` time DEFAULT NULL,
  `Created` date NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'Company_Department',
  `grace_period` time NOT NULL DEFAULT '00:00:00',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `r_attendance_rule` */

insert  into `r_attendance_rule`(`Id`,`Added_By`,`ruletype`,`rule_a_in`,`rule_a_out`,`rule_b_in`,`rule_b_out`,`rule_c_in`,`rule_c_out`,`Created`,`Action`,`grace_period`,`TimeStamp`) values 
(1,'1',1,'08:00:00','12:00:00','01:00:00','09:00:00',NULL,NULL,'2021-05-05','Company_Department','00:00:00','2021-05-05 14:20:21'),
(2,'3',2,'08:00:00','12:00:00','01:00:00','09:00:00',NULL,NULL,'2021-05-05','Company_Department','00:00:00','2021-05-05 14:30:10'),
(3,'1',1,'08:00:00','12:00:00','01:00:00','09:00:00',NULL,NULL,'2021-08-05','School','00:00:00','2021-08-05 16:18:18'),
(4,'4',1,'08:12:00','11:12:00','12:12:00','04:12:00','00:00:00','00:00:00','0000-00-00','School','00:00:00','2022-06-27 14:09:37'),
(5,'9',1,'08:00:00','11:00:00','12:00:00','04:00:00','00:00:00','00:00:00','0000-00-00','School','00:00:15','2022-11-08 08:57:41'),
(6,'3',1,'08:20:00','11:30:00','11:45:00','15:15:00','15:20:00','19:00:00','0000-00-00','School','00:00:15','2023-01-01 08:19:34');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
