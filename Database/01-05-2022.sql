/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.17-MariaDB : Database - qlicksystems_db
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

/*Table structure for table `absence_records` */

DROP TABLE IF EXISTS `absence_records`;

CREATE TABLE `absence_records` (
  `Id` bigint(11) NOT NULL AUTO_INCREMENT,
  `usertype` varchar(50) DEFAULT NULL,
  `userid` bigint(11) DEFAULT NULL,
  `day` date DEFAULT NULL,
  `recorded_at` time DEFAULT NULL,
  `undone` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_areas` */

DROP TABLE IF EXISTS `air_areas`;

CREATE TABLE `air_areas` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NULL DEFAULT current_timestamp(),
  `source_id` int(11) NOT NULL COMMENT 'user id',
  `mac_adress` varchar(255) NOT NULL,
  `generation` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `Site_Id` varchar(11) NOT NULL COMMENT 'r_sites table',
  `Description` varchar(255) NOT NULL,
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_ids` */

DROP TABLE IF EXISTS `air_ids`;

CREATE TABLE `air_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_levels` */

DROP TABLE IF EXISTS `air_levels`;

CREATE TABLE `air_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Name_Item` varchar(255) DEFAULT NULL,
  `good_from` double NOT NULL,
  `good_to` double NOT NULL,
  `good_back_col` varchar(11) NOT NULL,
  `good_font_col` varchar(11) NOT NULL,
  `satisfactory_from` double NOT NULL,
  `satisfactory_to` double NOT NULL,
  `satisfactory_back_col` varchar(11) NOT NULL,
  `satisfactory_font_col` varchar(11) NOT NULL,
  `moderatelypolluted_from` double NOT NULL,
  `moderatelypolluted_to` double NOT NULL,
  `moderatelypolluted_back_col` varchar(11) NOT NULL,
  `moderatelypolluted_font_col` varchar(11) NOT NULL,
  `poor_from` double NOT NULL,
  `poor_to` double NOT NULL,
  `poor_back_col` varchar(11) NOT NULL,
  `poor_font_col` varchar(11) NOT NULL,
  `verypoor_from` double NOT NULL,
  `verypoor_to` double NOT NULL,
  `verypoor_back_col` varchar(11) NOT NULL,
  `verypoor_font_col` varchar(11) NOT NULL,
  `severe_from` double NOT NULL,
  `severe_to` double NOT NULL,
  `severe_back_col` varchar(11) NOT NULL,
  `severe_font_col` varchar(11) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `generation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_levels_alert` */

DROP TABLE IF EXISTS `air_levels_alert`;

CREATE TABLE `air_levels_alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `good_from` double NOT NULL,
  `good_to` double NOT NULL,
  `satisfactory_from` double NOT NULL,
  `satisfactory_to` double NOT NULL,
  `moderatelypolluted_from` double NOT NULL,
  `moderatelypolluted_to` double NOT NULL,
  `poor_from` double NOT NULL,
  `poor_to` double NOT NULL,
  `verypoor_from` double NOT NULL,
  `verypoor_to` double NOT NULL,
  `severe_from` double NOT NULL,
  `severe_to` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_result` */

DROP TABLE IF EXISTS `air_result`;

CREATE TABLE `air_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_id` int(11) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `device_id` int(11) DEFAULT 0,
  `co2_time` datetime DEFAULT NULL,
  `co2` double DEFAULT 0,
  `pm_time` datetime DEFAULT NULL,
  `pm` double NOT NULL DEFAULT 0,
  `pm1_time` datetime DEFAULT NULL,
  `pm1` double NOT NULL DEFAULT 0,
  `pm2_5_time` datetime DEFAULT NULL,
  `pm2_5` double NOT NULL DEFAULT 0,
  `pm10_time` datetime DEFAULT NULL,
  `pm10` double NOT NULL DEFAULT 0,
  `ch2o_time` datetime DEFAULT NULL,
  `ch2o` double NOT NULL DEFAULT 0,
  `voc_EtOH_time` datetime DEFAULT NULL,
  `voc_EtOH` double NOT NULL DEFAULT 0,
  `voc_Isobutylene_time` datetime DEFAULT NULL,
  `voc_Isobutylene` double DEFAULT 0,
  `Barometer_time` datetime DEFAULT NULL,
  `Barometer` double NOT NULL DEFAULT 0,
  `dewpoint_f_time` datetime DEFAULT NULL,
  `dewpoint_f` double NOT NULL DEFAULT 0,
  `dewpoint_c_time` datetime DEFAULT NULL,
  `dewpoint_c` double NOT NULL DEFAULT 0,
  `Temperature_c_time` datetime DEFAULT NULL,
  `Temperature_c` double NOT NULL DEFAULT 0,
  `Temperature_f_time` datetime DEFAULT NULL,
  `Temperature_f` double NOT NULL DEFAULT 0,
  `humidity_time` datetime DEFAULT NULL,
  `humidity` double NOT NULL DEFAULT 0,
  `aq_time` datetime DEFAULT NULL,
  `aq` double NOT NULL DEFAULT 0,
  `Pressure_time` datetime DEFAULT NULL,
  `Pressure` double NOT NULL DEFAULT 0,
  `pc0_3_time` datetime DEFAULT NULL,
  `pc0_3` double NOT NULL DEFAULT 0,
  `pc0_5_time` datetime DEFAULT NULL,
  `pc0_5` double NOT NULL DEFAULT 0,
  `pc1_time` datetime DEFAULT NULL,
  `pc1` double NOT NULL DEFAULT 0,
  `pc2_5_time` datetime DEFAULT NULL,
  `pc2_5` double NOT NULL DEFAULT 0,
  `pc5_time` datetime DEFAULT NULL,
  `pc5` double NOT NULL DEFAULT 0,
  `pc10_time` datetime DEFAULT NULL,
  `pc10` double NOT NULL DEFAULT 0,
  `Device_Mac` varchar(255) NOT NULL,
  `created` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_result_aqi` */

DROP TABLE IF EXISTS `air_result_aqi`;

CREATE TABLE `air_result_aqi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pm2_5` double NOT NULL DEFAULT 0,
  `carbon_dioxide` double NOT NULL DEFAULT 0,
  `Temperature` double NOT NULL DEFAULT 0,
  `humidity` double NOT NULL DEFAULT 0,
  `formaldehydea` double NOT NULL DEFAULT 0,
  `AQI` double NOT NULL DEFAULT 0,
  `Device_Mac` varchar(255) NOT NULL DEFAULT 'Device_Mac',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_result_daily` */

DROP TABLE IF EXISTS `air_result_daily`;

CREATE TABLE `air_result_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_id` int(11) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `device_id` int(11) DEFAULT 0,
  `co2_time` datetime DEFAULT NULL,
  `co2` double DEFAULT 0,
  `pm_time` datetime DEFAULT NULL,
  `pm` double NOT NULL DEFAULT 0,
  `pm1_time` datetime DEFAULT NULL,
  `pm1` double NOT NULL DEFAULT 0,
  `pm2_5_time` datetime DEFAULT NULL,
  `pm2_5` double NOT NULL DEFAULT 0,
  `pm10_time` datetime DEFAULT NULL,
  `pm10` double NOT NULL DEFAULT 0,
  `ch2o_time` datetime DEFAULT NULL,
  `ch2o` double NOT NULL DEFAULT 0,
  `voc_EtOH_time` datetime DEFAULT NULL,
  `voc_EtOH` double NOT NULL DEFAULT 0,
  `voc_Isobutylene_time` datetime DEFAULT NULL,
  `voc_Isobutylene` double DEFAULT 0,
  `Barometer` double DEFAULT 0,
  `Barometer_Time` time DEFAULT NULL,
  `Pressure_time` datetime DEFAULT NULL,
  `Pressure` double NOT NULL DEFAULT 0,
  `dewpoint_f_time` datetime DEFAULT NULL,
  `dewpoint_f` double NOT NULL DEFAULT 0,
  `dewpoint_c_time` datetime DEFAULT NULL,
  `dewpoint_c` double NOT NULL DEFAULT 0,
  `Temperature_c_time` datetime DEFAULT NULL,
  `Temperature_c` double NOT NULL DEFAULT 0,
  `Temperature_f_time` datetime DEFAULT NULL,
  `Temperature_f` double NOT NULL DEFAULT 0,
  `humidity_time` datetime DEFAULT NULL,
  `humidity` double NOT NULL DEFAULT 0,
  `aq_time` datetime DEFAULT NULL,
  `aq` double NOT NULL DEFAULT 0,
  `pc0_3_time` datetime DEFAULT NULL,
  `pc0_3` double NOT NULL DEFAULT 0,
  `pc0_5_time` datetime DEFAULT NULL,
  `pc0_5` double NOT NULL DEFAULT 0,
  `pc1_time` datetime DEFAULT NULL,
  `pc1` double NOT NULL DEFAULT 0,
  `pc2_5_time` datetime DEFAULT NULL,
  `pc2_5` double NOT NULL DEFAULT 0,
  `pc5_time` datetime DEFAULT NULL,
  `pc5` double NOT NULL DEFAULT 0,
  `pc10_time` datetime DEFAULT NULL,
  `pc10` double NOT NULL DEFAULT 0,
  `Device_Mac` varchar(255) NOT NULL,
  `created` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1132256 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_result_gateway` */

DROP TABLE IF EXISTS `air_result_gateway`;

CREATE TABLE `air_result_gateway` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_id` int(11) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `device_id` int(11) DEFAULT 0,
  `co2` double DEFAULT 0,
  `pm` double NOT NULL DEFAULT 0,
  `pm1` double NOT NULL DEFAULT 0,
  `pm2_5` double NOT NULL DEFAULT 0,
  `pm10` double NOT NULL DEFAULT 0,
  `ch2o` double NOT NULL DEFAULT 0,
  `voc_EtOH` double NOT NULL DEFAULT 0,
  `voc_Isobutylene` double DEFAULT 0,
  `Barometer` double NOT NULL DEFAULT 0,
  `dewpoint_f` double NOT NULL DEFAULT 0,
  `dewpoint_c` double NOT NULL DEFAULT 0,
  `Temperature_c` double NOT NULL DEFAULT 0,
  `Temperature_f` double NOT NULL DEFAULT 0,
  `humidity` double NOT NULL DEFAULT 0,
  `aq` double NOT NULL DEFAULT 0,
  `Pressure` double NOT NULL DEFAULT 0,
  `pc0_3` double NOT NULL DEFAULT 0,
  `pc0_5` double NOT NULL DEFAULT 0,
  `pc1` double NOT NULL DEFAULT 0,
  `pc2_5` double NOT NULL DEFAULT 0,
  `pc5` double NOT NULL DEFAULT 0,
  `pc10` double NOT NULL DEFAULT 0,
  `Device_Mac` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `time` time NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_result_month` */

DROP TABLE IF EXISTS `air_result_month`;

CREATE TABLE `air_result_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_id` int(11) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `device_id` int(11) DEFAULT 0,
  `co2` double DEFAULT 0,
  `pm` double NOT NULL DEFAULT 0,
  `pm1` double NOT NULL DEFAULT 0,
  `pm2_5` double NOT NULL DEFAULT 0,
  `pm10` double NOT NULL DEFAULT 0,
  `ch2o` double NOT NULL DEFAULT 0,
  `voc_EtOH` double NOT NULL DEFAULT 0,
  `voc_Isobutylene` double DEFAULT 0,
  `Barometer` double NOT NULL DEFAULT 0,
  `dewpoint_f` double NOT NULL DEFAULT 0,
  `dewpoint_c` double NOT NULL DEFAULT 0,
  `Temperature_c` double NOT NULL DEFAULT 0,
  `Temperature_f` double NOT NULL DEFAULT 0,
  `humidity` double NOT NULL DEFAULT 0,
  `aq` double NOT NULL DEFAULT 0,
  `Pressure` double NOT NULL DEFAULT 0,
  `pc0_3` double NOT NULL DEFAULT 0,
  `pc0_5` double NOT NULL DEFAULT 0,
  `pc1` double NOT NULL DEFAULT 0,
  `pc2_5` double NOT NULL DEFAULT 0,
  `pc5` double NOT NULL DEFAULT 0,
  `pc10` double NOT NULL DEFAULT 0,
  `Device_Mac` varchar(255) NOT NULL,
  `created` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1342 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `air_result_week` */

DROP TABLE IF EXISTS `air_result_week`;

CREATE TABLE `air_result_week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_id` int(11) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `device_id` int(11) DEFAULT 0,
  `co2` double DEFAULT 0,
  `pm` double NOT NULL DEFAULT 0,
  `pm1` double NOT NULL DEFAULT 0,
  `pm2_5` double NOT NULL DEFAULT 0,
  `pm10` double NOT NULL DEFAULT 0,
  `ch2o` double NOT NULL DEFAULT 0,
  `voc_EtOH` double NOT NULL DEFAULT 0,
  `voc_Isobutylene` double DEFAULT 0,
  `Barometer` double NOT NULL DEFAULT 0,
  `dewpoint_f` double NOT NULL DEFAULT 0,
  `dewpoint_c` double NOT NULL DEFAULT 0,
  `Temperature_c` double NOT NULL DEFAULT 0,
  `Temperature_f` double NOT NULL DEFAULT 0,
  `humidity` double NOT NULL DEFAULT 0,
  `aq` double NOT NULL DEFAULT 0,
  `Pressure` double NOT NULL DEFAULT 0,
  `pc0_3` double NOT NULL DEFAULT 0,
  `pc0_5` double NOT NULL DEFAULT 0,
  `pc1` double NOT NULL DEFAULT 0,
  `pc2_5` double NOT NULL DEFAULT 0,
  `pc5` double NOT NULL DEFAULT 0,
  `pc10` double NOT NULL DEFAULT 0,
  `Device_Mac` varchar(255) NOT NULL,
  `created` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `co_machine` */

DROP TABLE IF EXISTS `co_machine`;

CREATE TABLE `co_machine` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mac` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `Site` varchar(255) NOT NULL,
  `Added_By` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `generation` varchar(255) NOT NULL DEFAULT 'ViceDevice',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `education_profile` */

DROP TABLE IF EXISTS `education_profile`;

CREATE TABLE `education_profile` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `Classes` varchar(255) NOT NULL COMMENT 'upload by ";" ; the class = Id in v_school grades',
  `name_ar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `feedback` */

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `img_txt` text NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `feedback_desc` varchar(255) NOT NULL,
  `session_data` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `interface` */

DROP TABLE IF EXISTS `interface`;

CREATE TABLE `interface` (
  `Id` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l0_consultant_chat` */

DROP TABLE IF EXISTS `l0_consultant_chat`;

CREATE TABLE `l0_consultant_chat` (
  `Id` int(18) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NULL DEFAULT current_timestamp(),
  `about` int(18) NOT NULL COMMENT 'the report id here (l1_consultant_reports)',
  `sender_id` int(18) NOT NULL COMMENT 'sender id if its from consultant account it will be "0"',
  `receiver_id` int(18) NOT NULL COMMENT 'receiver id if its to consultant account it will be "0"',
  `sender_usertype` varchar(50) NOT NULL,
  `receiver_usertype` varchar(50) NOT NULL,
  `message_content` text NOT NULL,
  `read_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l0_global_settings` */

DROP TABLE IF EXISTS `l0_global_settings`;

CREATE TABLE `l0_global_settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `logo_url` varchar(255) NOT NULL COMMENT 'assets\\images\\settings\\logos/ { name }',
  `api_copy` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l0_organization` */

DROP TABLE IF EXISTS `l0_organization`;

CREATE TABLE `l0_organization` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `AR_Title` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Manager` varchar(255) NOT NULL,
  `Tel` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Logo` text NOT NULL,
  `CountryID` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `EN_Title` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `UI_lang` varchar(255) NOT NULL DEFAULT 'EN',
  `verify` int(11) NOT NULL DEFAULT 0,
  `Email` varchar(255) NOT NULL,
  `VX` int(11) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(255) DEFAULT '0',
  `Style_type_id` int(11) NOT NULL,
  `zone_time_h` int(11) NOT NULL DEFAULT 0,
  `zone_time_m` int(11) NOT NULL DEFAULT 0,
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l0_systemtwithtest` */

DROP TABLE IF EXISTS `l0_systemtwithtest`;

CREATE TABLE `l0_systemtwithtest` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `SystemId` int(11) NOT NULL,
  `TestId` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l0_tests` */

DROP TABLE IF EXISTS `l0_tests`;

CREATE TABLE `l0_tests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `TestName_AR` varchar(255) NOT NULL,
  `TestName_EN` varchar(255) NOT NULL,
  `TestCode` int(11) NOT NULL,
  `TestMin` varchar(255) NOT NULL,
  `TestMax` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `MaxUnit` varchar(255) NOT NULL,
  `MinUnit` varchar(255) NOT NULL,
  `Ch` int(11) NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_category_resources` */

DROP TABLE IF EXISTS `l1_category_resources`;

CREATE TABLE `l1_category_resources` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL COMMENT '= Id in sv_st_category',
  `AccountId` int(11) NOT NULL DEFAULT 0 COMMENT '= when the Consultant uploads the file by default 0',
  `AccountType` varchar(200) DEFAULT NULL COMMENT '= when the Consultant uploads the file by default null',
  `file_type` int(11) NOT NULL COMMENT 'when 1 = folder name = Category_resources , else = Reports_resources',
  `file_url` text NOT NULL COMMENT 'the url to find this file is : ./uploads/Reports_resources/+ $language +/+{ this name }',
  `file_language` varchar(50) NOT NULL,
  `file_name_en` varchar(255) NOT NULL DEFAULT 'No title' COMMENT 'the name will be show in the reports EN version',
  `file_name_ar` varchar(255) NOT NULL DEFAULT 'بدون عنوان' COMMENT 'the name will be show in the reports AR version',
  `is_this_the_thumblain` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `TimeStamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_co_department` */

DROP TABLE IF EXISTS `l1_co_department`;

CREATE TABLE `l1_co_department` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Dept_Name_AR` varchar(255) NOT NULL,
  `Dept_Name_EN` varchar(255) NOT NULL,
  `Manager_EN` varchar(255) NOT NULL,
  `Manager_AR` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Position` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Citys` int(11) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Logo` tinytext NOT NULL,
  `Type_Of_Dept` varchar(255) NOT NULL,
  `Dept_Type` varchar(255) NOT NULL,
  `Added_By` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `UI_lang` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `Father` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `generation` varchar(14) DEFAULT '0',
  `zone_time_h` int(11) NOT NULL DEFAULT 0,
  `zone_time_m` int(11) NOT NULL DEFAULT 0,
  `DepartmentId` varchar(50) NOT NULL,
  `Company_Type` int(11) DEFAULT 3,
  PRIMARY KEY (`Id`),
  KEY `disInab` (`status`),
  KEY `addby` (`Added_By`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_consultant_reports` */

DROP TABLE IF EXISTS `l1_consultant_reports`;

CREATE TABLE `l1_consultant_reports` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AccountId` int(11) NOT NULL,
  `AccountType` varchar(18) NOT NULL COMMENT 'S = school \r\nM = Ministry\r\nC = Company\r\nD = Department',
  `UploadedBy` int(11) NOT NULL,
  `Comments` varchar(200) NOT NULL DEFAULT 'No Comment',
  `FileName` varchar(200) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_consultants` */

DROP TABLE IF EXISTS `l1_consultants`;

CREATE TABLE `l1_consultants` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `loginkey` int(11) NOT NULL,
  `Added_By` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_consultants_children` */

DROP TABLE IF EXISTS `l1_consultants_children`;

CREATE TABLE `l1_consultants_children` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `consultant_id` int(11) NOT NULL COMMENT '= i in l1_consultants',
  `account_id` int(11) NOT NULL COMMENT '= id in l1_school or co departments',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_department` */

DROP TABLE IF EXISTS `l1_department`;

CREATE TABLE `l1_department` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Dept_Name_AR` varchar(255) NOT NULL,
  `Dept_Name_EN` varchar(255) NOT NULL,
  `Manager_EN` varchar(255) NOT NULL,
  `Manager_AR` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Citys` int(11) NOT NULL,
  `Country` int(11) NOT NULL,
  `Logo` text NOT NULL,
  `Type_Of_Dept` varchar(255) NOT NULL,
  `Added_By` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `UI_lang` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `generation` varchar(255) DEFAULT '0',
  `Company_Type` int(11) NOT NULL DEFAULT 6,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l1_school` */

DROP TABLE IF EXISTS `l1_school`;

CREATE TABLE `l1_school` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `School_Name_AR` varchar(255) NOT NULL,
  `School_Name_EN` varchar(255) NOT NULL,
  `Manager_EN` varchar(255) NOT NULL,
  `Manager_AR` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Citys` int(11) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Logo` text NOT NULL,
  `Type_Of_School` varchar(255) NOT NULL,
  `Added_By` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UI_lang` varchar(255) NOT NULL DEFAULT 'EN',
  `status` int(11) NOT NULL DEFAULT 1,
  `Adress_AR` varchar(255) NOT NULL,
  `Adress_EN` varchar(255) NOT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `Main_School` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(255) DEFAULT '0',
  `zone_time_h` int(11) NOT NULL DEFAULT 0,
  `zone_time_m` int(11) NOT NULL DEFAULT 0,
  `SchoolId` varchar(50) NOT NULL,
  `Company_Type` int(11) NOT NULL DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_attendance_result` */

DROP TABLE IF EXISTS `l2_attendance_result`;

CREATE TABLE `l2_attendance_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_first` double NOT NULL DEFAULT 0,
  `Result_last` double NOT NULL DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Type` varchar(255) NOT NULL,
  `Time_first` time NOT NULL DEFAULT '00:00:00',
  `Time_last` time NOT NULL DEFAULT '00:00:00',
  `Created` date NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device_first` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_last` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Date_out` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=624 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_avatars` */

DROP TABLE IF EXISTS `l2_avatars`;

CREATE TABLE `l2_avatars` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `For_User` int(11) NOT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `Type_Of_User` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `generation` varchar(14) NOT NULL DEFAULT 'NewDB',
  PRIMARY KEY (`Id`),
  KEY `foruser` (`For_User`)
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_batches` */

DROP TABLE IF EXISTS `l2_batches`;

CREATE TABLE `l2_batches` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Batch_Id` varchar(255) NOT NULL,
  `Device_Type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `For_Device` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Active, 1 = Not Active',
  `Created` datetime NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_attendance_result` */

DROP TABLE IF EXISTS `l2_co_attendance_result`;

CREATE TABLE `l2_co_attendance_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_first` double NOT NULL DEFAULT 0,
  `Result_last` double NOT NULL DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Type` varchar(255) NOT NULL,
  `Time_first` time NOT NULL DEFAULT '00:00:00',
  `Time_last` time NOT NULL DEFAULT '00:00:00',
  `Created` date NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device_first` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_last` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Date_out` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2135 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_avatars` */

DROP TABLE IF EXISTS `l2_co_avatars`;

CREATE TABLE `l2_co_avatars` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `For_User` int(11) NOT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `Type_Of_User` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `generation` varchar(14) NOT NULL DEFAULT 'NewDB',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_batches` */

DROP TABLE IF EXISTS `l2_co_batches`;

CREATE TABLE `l2_co_batches` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Batch_Id` varchar(255) NOT NULL,
  `Device_Type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `For_Device` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Active, 1 = Not Active',
  `Created` datetime NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_devices` */

DROP TABLE IF EXISTS `l2_co_devices`;

CREATE TABLE `l2_co_devices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `D_Id` varchar(255) NOT NULL,
  `Added_by` varchar(255) NOT NULL,
  `Comments` varchar(255) NOT NULL,
  `UserType` varchar(255) NOT NULL DEFAULT 'Company_Department',
  `Created` datetime NOT NULL,
  `Site` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `generation` varchar(14) DEFAULT 'VXDeviceBil21',
  `car_id` int(11) DEFAULT NULL,
  `Site_ar` varchar(255) DEFAULT NULL,
  `Description_ar` varchar(255) DEFAULT NULL,
  `device_type` int(11) DEFAULT NULL,
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_gateway_result` */

DROP TABLE IF EXISTS `l2_co_gateway_result`;

CREATE TABLE `l2_co_gateway_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL DEFAULT 0,
  `Blood_pressure_min` double DEFAULT 0,
  `Blood_pressure_max` double DEFAULT 0,
  `Glucose` double DEFAULT 0,
  `Blood_oxygen` double DEFAULT 0,
  `Heart_rate` double DEFAULT 0,
  `weight` double DEFAULT 0,
  `Steps` int(11) DEFAULT 0,
  `Calories` int(11) DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Pass_rec_id` int(11) DEFAULT NULL,
  `img_uri` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_history_result` */

DROP TABLE IF EXISTS `l2_co_history_result`;

CREATE TABLE `l2_co_history_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Result_out` double DEFAULT NULL,
  `Blood_pressure_max` double NOT NULL DEFAULT 0,
  `Blood_pressure_min` double NOT NULL DEFAULT 0,
  `Blood_oxygen` double NOT NULL DEFAULT 0,
  `Heart_rate` double NOT NULL DEFAULT 0,
  `weight` double NOT NULL DEFAULT 0,
  `Glucose` double NOT NULL DEFAULT 0,
  `Steps` int(11) DEFAULT 0,
  `Calores` int(11) DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Date_out` date DEFAULT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Time_out` time DEFAULT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_labtests` */

DROP TABLE IF EXISTS `l2_co_labtests`;

CREATE TABLE `l2_co_labtests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL COMMENT '1 = Positive +,0 = Nigative -',
  `Symptoms` varchar(255) NOT NULL,
  `Device` int(11) NOT NULL DEFAULT 0,
  `Device_Test` varchar(255) NOT NULL,
  `Device_Batch` varchar(255) NOT NULL,
  `Test_Description` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `generation` varchar(255) DEFAULT 'LabComBil21',
  `Report_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `createdDate` (`Created`)
) ENGINE=InnoDB AUTO_INCREMENT=1956 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_mac` */

DROP TABLE IF EXISTS `l2_co_mac`;

CREATE TABLE `l2_co_mac` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GTW_mac` varchar(255) DEFAULT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Watch_mac` varchar(255) NOT NULL,
  `Data` varchar(255) NOT NULL,
  `Created_time` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_machine` */

DROP TABLE IF EXISTS `l2_co_machine`;

CREATE TABLE `l2_co_machine` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `device_name` varchar(255) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `min_temp` double NOT NULL,
  `max_temp` double NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_monthly_result` */

DROP TABLE IF EXISTS `l2_co_monthly_result`;

CREATE TABLE `l2_co_monthly_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_Time` time DEFAULT '00:00:00',
  `Result` double NOT NULL,
  `Blood_pressure_Time` time DEFAULT '00:00:00',
  `Blood_pressure_max` double DEFAULT 0,
  `Blood_pressure_min` double NOT NULL DEFAULT 0,
  `Blood_oxygen_Time` time DEFAULT '00:00:00',
  `Blood_oxygen` double NOT NULL DEFAULT 0,
  `Heart_rate_Time` time DEFAULT '00:00:00',
  `Heart_rate` double NOT NULL DEFAULT 0,
  `weight_Time` time DEFAULT '00:00:00',
  `weight` double NOT NULL DEFAULT 0,
  `Glucose_Time` time DEFAULT '00:00:00',
  `Glucose` double DEFAULT 0,
  `Calores_Time` time DEFAULT '00:00:00',
  `calories` int(11) DEFAULT 0,
  `Steps_Time` time DEFAULT '00:00:00',
  `Steps` int(11) DEFAULT 0,
  `Symptoms_Time` time DEFAULT '00:00:00',
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `usertype` (`UserType`),
  KEY `userId` (`UserId`),
  KEY `created` (`Created`)
) ENGINE=InnoDB AUTO_INCREMENT=2276 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_patient` */

DROP TABLE IF EXISTS `l2_co_patient`;

CREATE TABLE `l2_co_patient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserType` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) CHARACTER SET utf8 NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) CHARACTER SET utf8 NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) CHARACTER SET utf8 NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(255) DEFAULT '0',
  `Action` varchar(100) DEFAULT 'work',
  `Prefix` varchar(255) DEFAULT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `Perm` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `see_refrigerator` int(11) NOT NULL DEFAULT 0 COMMENT '0 = no, yes = 1',
  `see_air_quality` int(11) NOT NULL DEFAULT 0 COMMENT '0 = no, yes = 1',
  `adding_method` varchar(200) NOT NULL DEFAULT 'page',
  `martial_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `addedBy` (`Added_By`)
) ENGINE=InnoDB AUTO_INCREMENT=734 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_result` */

DROP TABLE IF EXISTS `l2_co_result`;

CREATE TABLE `l2_co_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_Date` date DEFAULT NULL,
  `Result_Time` time DEFAULT '00:00:00',
  `Result` double NOT NULL COMMENT 'temperature',
  `Blood_pressure_Date` date DEFAULT NULL,
  `Blood_pressure_Time` time DEFAULT '00:00:00',
  `Blood_pressure_min` double NOT NULL DEFAULT 0 COMMENT 'systolic',
  `Blood_pressure_max` double DEFAULT 0 COMMENT 'diastolic',
  `Blood_oxygen_Date` date DEFAULT NULL,
  `Blood_oxygen_Time` time DEFAULT '00:00:00',
  `Blood_oxygen` double NOT NULL DEFAULT 0 COMMENT 'oxygen',
  `Heart_rate_Date` date DEFAULT NULL,
  `Heart_rate_Time` time DEFAULT '00:00:00',
  `Heart_rate` double NOT NULL DEFAULT 0 COMMENT 'heart beats',
  `weight_Date` date DEFAULT NULL,
  `weight_Time` time DEFAULT '00:00:00',
  `weight` double NOT NULL DEFAULT 0 COMMENT 'weight',
  `Glucose_Date` date DEFAULT NULL,
  `Glucose_Time` time DEFAULT '00:00:00',
  `Glucose` double DEFAULT 0 COMMENT 'glucose',
  `calories_Date` date DEFAULT NULL,
  `calories_Time` time DEFAULT '00:00:00',
  `calories` int(11) DEFAULT 0,
  `Steps_Date` date DEFAULT NULL,
  `Steps_Time` time DEFAULT '00:00:00',
  `Steps` int(11) DEFAULT 0,
  `Symptoms_Date` date DEFAULT NULL,
  `Symptoms_time` time DEFAULT '00:00:00',
  `Symptoms` varchar(255) NOT NULL DEFAULT '0',
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Pass_rec_id` int(11) DEFAULT NULL,
  `img_uri` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_result_machine` */

DROP TABLE IF EXISTS `l2_co_result_machine`;

CREATE TABLE `l2_co_result_machine` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_result_machine_gateway` */

DROP TABLE IF EXISTS `l2_co_result_machine_gateway`;

CREATE TABLE `l2_co_result_machine_gateway` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_shift_attendance_result` */

DROP TABLE IF EXISTS `l2_co_shift_attendance_result`;

CREATE TABLE `l2_co_shift_attendance_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_A_In` double NOT NULL DEFAULT 0,
  `Time_A_In` time NOT NULL DEFAULT '00:00:00',
  `Result_A_Out` double NOT NULL DEFAULT 0,
  `Time_A_Out` time NOT NULL DEFAULT '00:00:00',
  `Result_B_In` double NOT NULL DEFAULT 0,
  `Time_B_In` time NOT NULL DEFAULT '00:00:00',
  `Result_B_Out` double NOT NULL DEFAULT 0,
  `Time_B_Out` time NOT NULL DEFAULT '00:00:00',
  `Result_C_In` double NOT NULL DEFAULT 0,
  `Time_C_In` time NOT NULL DEFAULT '00:00:00',
  `Result_C_Out` double NOT NULL DEFAULT 0,
  `Time_C_Out` time NOT NULL DEFAULT '00:00:00',
  `Created` date NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device_A_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_A_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_B_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_B_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_C_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_C_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_shift_attendance_seq_result` */

DROP TABLE IF EXISTS `l2_co_shift_attendance_seq_result`;

CREATE TABLE `l2_co_shift_attendance_seq_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_A_In` double NOT NULL DEFAULT 0,
  `Time_A_In` time DEFAULT NULL,
  `Result_A_Out` double NOT NULL DEFAULT 0,
  `Time_A_Out` time DEFAULT NULL,
  `Result_B_In` double NOT NULL DEFAULT 0,
  `Time_B_In` time DEFAULT NULL,
  `Result_B_Out` double NOT NULL DEFAULT 0,
  `Time_B_Out` time DEFAULT NULL,
  `Result_C_In` double NOT NULL DEFAULT 0,
  `Time_C_In` time DEFAULT NULL,
  `Result_C_Out` double NOT NULL DEFAULT 0,
  `Time_C_Out` time DEFAULT NULL,
  `Result_D_In` double NOT NULL DEFAULT 0,
  `Time_D_In` time DEFAULT NULL,
  `Result_D_Out` double NOT NULL DEFAULT 0,
  `Time_D_Out` time DEFAULT NULL,
  `Result_E_In` double NOT NULL DEFAULT 0,
  `Time_E_In` time DEFAULT NULL,
  `Result_E_Out` double NOT NULL DEFAULT 0,
  `Time_E_Out` time DEFAULT NULL,
  `Result_F_In` double NOT NULL DEFAULT 0,
  `Time_F_In` time DEFAULT NULL,
  `Result_F_Out` double NOT NULL DEFAULT 0,
  `Time_F_Out` time DEFAULT NULL,
  `Result_G_In` double NOT NULL DEFAULT 0,
  `Time_G_In` time DEFAULT NULL,
  `Result_G_Out` double NOT NULL DEFAULT 0,
  `Time_G_Out` time DEFAULT NULL,
  `Result_H_In` double NOT NULL DEFAULT 0,
  `Time_H_In` time DEFAULT NULL,
  `Result_H_Out` double NOT NULL DEFAULT 0,
  `Time_H_Out` time DEFAULT NULL,
  `Result_I_In` double NOT NULL DEFAULT 0,
  `Time_I_In` time DEFAULT NULL,
  `Result_I_Out` double NOT NULL DEFAULT 0,
  `Time_I_Out` time DEFAULT NULL,
  `Result_J_In` double NOT NULL DEFAULT 0,
  `Time_J_In` time DEFAULT NULL,
  `Result_J_Out` double NOT NULL DEFAULT 0,
  `Time_J_Out` time DEFAULT NULL,
  `Created` date NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device_A_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_A_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_B_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_B_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_C_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_C_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_D_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_D_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_E_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_E_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_F_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_F_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_G_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_G_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_H_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_H_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_I_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_I_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_J_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_J_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1058 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_site` */

DROP TABLE IF EXISTS `l2_co_site`;

CREATE TABLE `l2_co_site` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Site_Code` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Add_Me` varchar(255) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `generation` varchar(14) DEFAULT '0',
  `Site_For` int(11) DEFAULT NULL,
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_staff` */

DROP TABLE IF EXISTS `l2_co_staff`;

CREATE TABLE `l2_co_staff` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `PermSchool` int(11) NOT NULL DEFAULT 0,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_temp_patient` */

DROP TABLE IF EXISTS `l2_co_temp_patient`;

CREATE TABLE `l2_co_temp_patient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserType` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Action` varchar(100) NOT NULL DEFAULT 'work',
  `Prefix` varchar(255) DEFAULT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `Perm` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `see_refrigerator` int(11) NOT NULL DEFAULT 0 COMMENT '0 = no, yes = 1',
  `see_air_quality` int(11) NOT NULL DEFAULT 0 COMMENT '0 = no, yes = 1',
  `otp` int(11) NOT NULL,
  `generation` varchar(255) DEFAULT '0',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `adding_method` varchar(255) NOT NULL DEFAULT 'page',
  PRIMARY KEY (`Id`),
  KEY `addedBy` (`Added_By`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_co_visitors` */

DROP TABLE IF EXISTS `l2_co_visitors`;

CREATE TABLE `l2_co_visitors` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) DEFAULT NULL,
  `F_name_AR` varchar(255) DEFAULT NULL,
  `M_name_EN` varchar(255) DEFAULT NULL,
  `M_name_AR` varchar(255) DEFAULT NULL,
  `L_name_EN` varchar(255) DEFAULT NULL,
  `L_name_AR` varchar(255) DEFAULT NULL,
  `DOP` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Created` datetime DEFAULT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) DEFAULT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_dept_site` */

DROP TABLE IF EXISTS `l2_dept_site`;

CREATE TABLE `l2_dept_site` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Site_Code` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Add_Me` varchar(255) NOT NULL,
  `User_type` varchar(255) NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_devices` */

DROP TABLE IF EXISTS `l2_devices`;

CREATE TABLE `l2_devices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT NULL,
  `Added_by` varchar(255) NOT NULL,
  `device_type` int(11) DEFAULT NULL,
  `UserType` varchar(255) NOT NULL,
  `D_Id` varchar(255) NOT NULL,
  `Site` varchar(255) NOT NULL,
  `Site_ar` varchar(255) DEFAULT NULL,
  `Description` varchar(255) NOT NULL,
  `Description_ar` varchar(255) DEFAULT NULL,
  `Comments` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_gateway_result` */

DROP TABLE IF EXISTS `l2_gateway_result`;

CREATE TABLE `l2_gateway_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL DEFAULT 1,
  `Blood_pressure_min` double DEFAULT 0,
  `Blood_pressure_max` double DEFAULT 0,
  `Glucose` double DEFAULT 0,
  `Blood_oxygen` double DEFAULT 0,
  `Heart_rate` double DEFAULT 0,
  `weight` double DEFAULT 0,
  `Steps` int(11) DEFAULT 0,
  `Calories` int(11) DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL DEFAULT '0',
  `Device_Test` varchar(255) NOT NULL DEFAULT 'No',
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Pass_rec_id` int(11) DEFAULT 0,
  `img_uri` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_grades` */

DROP TABLE IF EXISTS `l2_grades`;

CREATE TABLE `l2_grades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `0` int(11) NOT NULL DEFAULT 0,
  `1` int(11) NOT NULL DEFAULT 0,
  `2` int(11) NOT NULL DEFAULT 0,
  `3` int(11) NOT NULL DEFAULT 0,
  `4` int(11) NOT NULL DEFAULT 0,
  `5` int(11) NOT NULL DEFAULT 0,
  `6` int(11) NOT NULL DEFAULT 0,
  `7` int(11) NOT NULL DEFAULT 0,
  `8` int(11) NOT NULL DEFAULT 0,
  `9` int(11) NOT NULL DEFAULT 0,
  `10` int(11) NOT NULL DEFAULT 0,
  `11` int(11) NOT NULL DEFAULT 0,
  `12` int(11) NOT NULL DEFAULT 0,
  `13` int(11) NOT NULL DEFAULT 0,
  `14` int(11) NOT NULL DEFAULT 0,
  `generation` varchar(14) DEFAULT '0',
  KEY `Id` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_history_result` */

DROP TABLE IF EXISTS `l2_history_result`;

CREATE TABLE `l2_history_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Result_out` double DEFAULT NULL,
  `Blood_pressure_max` double(22,0) DEFAULT 0,
  `Blood_pressure_min` double(22,0) DEFAULT 0,
  `Blood_oxygen` double(22,0) DEFAULT 0,
  `Heart_rate` double(22,0) DEFAULT 0,
  `weight` double(22,0) DEFAULT 0,
  `Glucose` double(22,0) DEFAULT 0,
  `Steps` int(11) DEFAULT 0,
  `Calores` int(11) DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Date_out` date DEFAULT NULL,
  `Time` time NOT NULL,
  `Time_out` time DEFAULT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9927 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_labtests` */

DROP TABLE IF EXISTS `l2_labtests`;

CREATE TABLE `l2_labtests` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL COMMENT '1 = Positive +,0 = Nigative -',
  `Symptoms` varchar(255) NOT NULL,
  `Device` int(11) NOT NULL DEFAULT 0,
  `Device_Test` varchar(255) NOT NULL,
  `Device_Batch` varchar(255) NOT NULL,
  `Test_Description` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `generation` varchar(14) DEFAULT '0',
  `Report_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_mac` */

DROP TABLE IF EXISTS `l2_mac`;

CREATE TABLE `l2_mac` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GTW_mac` varchar(255) DEFAULT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Watch_mac` varchar(255) NOT NULL,
  `Data` varchar(255) NOT NULL,
  `Created_time` datetime NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_machine` */

DROP TABLE IF EXISTS `l2_machine`;

CREATE TABLE `l2_machine` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `device_name` varchar(255) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `min_temp` varchar(8) NOT NULL,
  `max_temp` varchar(8) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_martial_status` */

DROP TABLE IF EXISTS `l2_martial_status`;

CREATE TABLE `l2_martial_status` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_monthly_result` */

DROP TABLE IF EXISTS `l2_monthly_result`;

CREATE TABLE `l2_monthly_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_Time` time DEFAULT '00:00:00',
  `Result` double NOT NULL,
  `Blood_pressure_Time` time DEFAULT '00:00:00',
  `Blood_pressure_max` double(22,0) DEFAULT 0,
  `Blood_pressure_min` double(22,0) DEFAULT 0,
  `Blood_oxygen_Time` time DEFAULT '00:00:00',
  `Blood_oxygen` double NOT NULL DEFAULT 0,
  `Heart_rate_Time` time DEFAULT '00:00:00',
  `Heart_rate` double NOT NULL DEFAULT 0,
  `weight_Time` time DEFAULT '00:00:00',
  `weight` double(22,0) DEFAULT 0,
  `Glucose_Time` time DEFAULT '00:00:00',
  `Glucose` double NOT NULL DEFAULT 0,
  `Calores_Time` time DEFAULT '00:00:00',
  `calories` int(11) DEFAULT 0,
  `Steps_Time` time DEFAULT '00:00:00',
  `Steps` int(11) DEFAULT 0,
  `Symptoms_Time` time DEFAULT '00:00:00',
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(14) DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5632 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_parents` */

DROP TABLE IF EXISTS `l2_parents`;

CREATE TABLE `l2_parents` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `login_key` int(11) NOT NULL COMMENT '= id in v_login table',
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `DOP` date NOT NULL,
  `gender` int(11) NOT NULL DEFAULT 1 COMMENT '1 =male ,\r\n2 = female',
  `martial_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_patient` */

DROP TABLE IF EXISTS `l2_patient`;

CREATE TABLE `l2_patient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserType` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) CHARACTER SET utf8 NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) CHARACTER SET utf8 NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) CHARACTER SET utf8 NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Perm` int(11) NOT NULL DEFAULT 0,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_result` */

DROP TABLE IF EXISTS `l2_result`;

CREATE TABLE `l2_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_Date` date DEFAULT NULL,
  `Result_Time` time DEFAULT '00:00:00',
  `Result` double NOT NULL,
  `Blood_pressure_Date` date DEFAULT NULL,
  `Blood_pressure_Time` time DEFAULT '00:00:00',
  `Blood_pressure_min` double NOT NULL DEFAULT 0,
  `Blood_pressure_max` double NOT NULL DEFAULT 0,
  `Blood_oxygen_Date` date DEFAULT NULL,
  `Blood_oxygen_Time` time DEFAULT '00:00:00',
  `Blood_oxygen` double NOT NULL DEFAULT 0,
  `Heart_rate_Date` date DEFAULT NULL,
  `Heart_rate_Time` time DEFAULT '00:00:00',
  `Heart_rate` double NOT NULL DEFAULT 0,
  `weight_Date` date DEFAULT NULL,
  `weight_Time` time DEFAULT '00:00:00',
  `weight` double NOT NULL DEFAULT 0,
  `Glucose_Date` date DEFAULT NULL,
  `Glucose_Time` time DEFAULT '00:00:00',
  `Glucose` double DEFAULT 0 COMMENT 'glucose',
  `calories_Date` date DEFAULT NULL,
  `calories_Time` time DEFAULT '00:00:00',
  `calories` int(11) DEFAULT 0,
  `Steps_Date` date DEFAULT NULL,
  `Steps_Time` time DEFAULT '00:00:00',
  `Steps` int(11) DEFAULT 0,
  `Symptoms_Date` date DEFAULT NULL,
  `Symptoms_time` time DEFAULT '00:00:00',
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Pass_rec_id` int(11) DEFAULT NULL,
  `img_uri` varchar(255) DEFAULT NULL,
  `Blood_pressure` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_result_machine` */

DROP TABLE IF EXISTS `l2_result_machine`;

CREATE TABLE `l2_result_machine` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_result_machine_gateway` */

DROP TABLE IF EXISTS `l2_result_machine_gateway`;

CREATE TABLE `l2_result_machine_gateway` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `battery_life` double DEFAULT 0,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_school_classes` */

DROP TABLE IF EXISTS `l2_school_classes`;

CREATE TABLE `l2_school_classes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `school_id` int(11) NOT NULL COMMENT '= Id in l2_schools',
  `class_key` int(11) NOT NULL COMMENT '= Id r_levels',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_shift_attendance_seq_result` */

DROP TABLE IF EXISTS `l2_shift_attendance_seq_result`;

CREATE TABLE `l2_shift_attendance_seq_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_A_In` double NOT NULL DEFAULT 0,
  `Time_A_In` time DEFAULT NULL,
  `Result_A_Out` double NOT NULL DEFAULT 0,
  `Time_A_Out` time DEFAULT NULL,
  `Result_B_In` double NOT NULL DEFAULT 0,
  `Time_B_In` time DEFAULT NULL,
  `Result_B_Out` double NOT NULL DEFAULT 0,
  `Time_B_Out` time DEFAULT NULL,
  `Result_C_In` double NOT NULL DEFAULT 0,
  `Time_C_In` time DEFAULT NULL,
  `Result_C_Out` double NOT NULL DEFAULT 0,
  `Time_C_Out` time DEFAULT NULL,
  `Result_D_In` double NOT NULL DEFAULT 0,
  `Time_D_In` time DEFAULT NULL,
  `Result_D_Out` double NOT NULL DEFAULT 0,
  `Time_D_Out` time DEFAULT NULL,
  `Result_E_In` double NOT NULL DEFAULT 0,
  `Time_E_In` time DEFAULT NULL,
  `Result_E_Out` double NOT NULL DEFAULT 0,
  `Time_E_Out` time DEFAULT NULL,
  `Result_F_In` double NOT NULL DEFAULT 0,
  `Time_F_In` time DEFAULT NULL,
  `Result_F_Out` double NOT NULL DEFAULT 0,
  `Time_F_Out` time DEFAULT NULL,
  `Result_G_In` double NOT NULL DEFAULT 0,
  `Time_G_In` time DEFAULT NULL,
  `Result_G_Out` double NOT NULL DEFAULT 0,
  `Time_G_Out` time DEFAULT NULL,
  `Result_H_In` double NOT NULL DEFAULT 0,
  `Time_H_In` time DEFAULT NULL,
  `Result_H_Out` double NOT NULL DEFAULT 0,
  `Time_H_Out` time DEFAULT NULL,
  `Result_I_In` double NOT NULL DEFAULT 0,
  `Time_I_In` time DEFAULT NULL,
  `Result_I_Out` double NOT NULL DEFAULT 0,
  `Time_I_Out` time DEFAULT NULL,
  `Result_J_In` double NOT NULL DEFAULT 0,
  `Time_J_In` time DEFAULT NULL,
  `Result_J_Out` double NOT NULL DEFAULT 0,
  `Time_J_Out` time DEFAULT NULL,
  `Created` date NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device_A_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_A_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_B_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_B_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_C_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_C_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_D_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_D_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_E_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_E_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_F_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_F_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_G_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_G_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_H_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_H_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_I_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_I_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_J_IN` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `Device_J_Out` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` double(3,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_site` */

DROP TABLE IF EXISTS `l2_site`;

CREATE TABLE `l2_site` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_type` varchar(255) NOT NULL,
  `Site_For` varchar(200) NOT NULL,
  `Site_Code` varchar(255) NOT NULL,
  `Site_Code_ar` varchar(200) DEFAULT NULL,
  `Description` varchar(255) NOT NULL,
  `Description_ar` varchar(200) DEFAULT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Add_Me` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_staff` */

DROP TABLE IF EXISTS `l2_staff`;

CREATE TABLE `l2_staff` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `PermSchool` int(11) NOT NULL DEFAULT 0,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(255) NOT NULL,
  `martial_status` int(11) DEFAULT NULL,
  `last_change_status_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `adding_method` varchar(255) NOT NULL DEFAULT 'page',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_student` */

DROP TABLE IF EXISTS `l2_student`;

CREATE TABLE `l2_student` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL DEFAULT 'Student',
  `F_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL DEFAULT 'Student',
  `Email` varchar(255) NOT NULL,
  `Parent_NID` varchar(255) NOT NULL,
  `Class` varchar(255) NOT NULL,
  `Grades` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(255) NOT NULL,
  `Parent_NID_2` varchar(255) DEFAULT NULL,
  `martial_status` int(11) DEFAULT NULL,
  `last_change_status_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `adding_method` varchar(255) NOT NULL DEFAULT 'page',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_teacher` */

DROP TABLE IF EXISTS `l2_teacher`;

CREATE TABLE `l2_teacher` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Pic` text NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Classes` varchar(255) NOT NULL,
  `Grades` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `PermSchool` int(11) NOT NULL DEFAULT 0,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(255) NOT NULL,
  `car_id` int(11) NOT NULL DEFAULT 0,
  `martial_status` int(11) DEFAULT NULL,
  `last_change_status_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `AR_Position` varchar(255) NOT NULL,
  `adding_method` varchar(255) NOT NULL DEFAULT 'page',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_teachers_classes` */

DROP TABLE IF EXISTS `l2_teachers_classes`;

CREATE TABLE `l2_teachers_classes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `class_id` int(11) NOT NULL COMMENT '= Id in r_levels',
  `teacher_id` int(11) NOT NULL COMMENT '= Id in                             $id = $this->db->get(''l2_teacher'')->result_array()[0];\r\n',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_temp_staff` */

DROP TABLE IF EXISTS `l2_temp_staff`;

CREATE TABLE `l2_temp_staff` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prefix` varchar(200) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` timestamp NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `martial_status` int(11) NOT NULL DEFAULT 1,
  `Added_By` varchar(255) NOT NULL,
  `generation` varchar(200) NOT NULL,
  `adding_method` varchar(200) NOT NULL,
  `watch_mac` varchar(200) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_temp_student` */

DROP TABLE IF EXISTS `l2_temp_student`;

CREATE TABLE `l2_temp_student` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prefix` varchar(200) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` timestamp NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `martial_status` int(11) NOT NULL DEFAULT 1,
  `Parent_NID` varchar(255) NOT NULL,
  `Parent_NID_2` varchar(255) DEFAULT NULL,
  `Class` varchar(255) NOT NULL,
  `Grades` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `generation` varchar(200) NOT NULL,
  `adding_method` varchar(200) NOT NULL,
  `watch_mac` varchar(200) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=517 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_temp_teacher` */

DROP TABLE IF EXISTS `l2_temp_teacher`;

CREATE TABLE `l2_temp_teacher` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Prefix` varchar(200) NOT NULL,
  `F_name_EN` varchar(255) NOT NULL,
  `M_name_EN` varchar(255) NOT NULL,
  `L_name_EN` varchar(255) NOT NULL,
  `F_name_AR` varchar(255) NOT NULL,
  `M_name_AR` varchar(255) NOT NULL,
  `L_name_AR` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` timestamp NULL DEFAULT current_timestamp(),
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `martial_status` int(11) NOT NULL DEFAULT 1,
  `Classes` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `generation` varchar(200) NOT NULL,
  `adding_method` varchar(200) NOT NULL,
  `watch_mac` varchar(200) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Position` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_users_v0` */

DROP TABLE IF EXISTS `l2_users_v0`;

CREATE TABLE `l2_users_v0` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `User_type` varchar(255) NOT NULL,
  `F_name` varchar(255) NOT NULL,
  `M_name` varchar(255) NOT NULL,
  `L_name` varchar(255) NOT NULL,
  `DOP` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `PermSchool` int(11) NOT NULL,
  `Add_Me` varchar(255) NOT NULL,
  `Latitude` decimal(10,0) NOT NULL,
  `Longitude` decimal(10,0) NOT NULL,
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(255) NOT NULL,
  `generation` varchar(255) NOT NULL,
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicle` */

DROP TABLE IF EXISTS `l2_vehicle`;

CREATE TABLE `l2_vehicle` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `No_vehicle` int(11) NOT NULL,
  `type_vehicle` varchar(255) NOT NULL,
  `Company_vehicle` varchar(255) NOT NULL,
  `Country_vehicle` varchar(255) NOT NULL,
  `Model_vehicle` varchar(255) NOT NULL,
  `Year_vehicle` int(11) NOT NULL,
  `Color_vehicle` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `otp` int(11) NOT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(255) NOT NULL,
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicle_drivers` */

DROP TABLE IF EXISTS `l2_vehicle_drivers`;

CREATE TABLE `l2_vehicle_drivers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `car_id` int(11) NOT NULL COMMENT '= Id in l2_vehicle',
  `teacher_id` int(11) NOT NULL COMMENT '= id in l2_teacher',
  `Added_by` int(11) NOT NULL,
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicle_helpers` */

DROP TABLE IF EXISTS `l2_vehicle_helpers`;

CREATE TABLE `l2_vehicle_helpers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `car_id` int(11) NOT NULL COMMENT '= Id in l2_vehicle',
  `staff_id` int(11) NOT NULL COMMENT '= id in l2_staff',
  `Added_by` int(11) NOT NULL,
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicle_students` */

DROP TABLE IF EXISTS `l2_vehicle_students`;

CREATE TABLE `l2_vehicle_students` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `Added_by` int(11) NOT NULL,
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicle_type` */

DROP TABLE IF EXISTS `l2_vehicle_type`;

CREATE TABLE `l2_vehicle_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_type` varchar(100) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_ar` varchar(255) NOT NULL,
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicles_attendance_result` */

DROP TABLE IF EXISTS `l2_vehicles_attendance_result`;

CREATE TABLE `l2_vehicles_attendance_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `vehicle_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `Time_first` time NOT NULL DEFAULT '00:00:00',
  `Result_first` double DEFAULT NULL,
  `humidity_first` double DEFAULT NULL,
  `Time_last` time NOT NULL DEFAULT '00:00:00',
  `Result_last` double DEFAULT NULL,
  `humidity_last` double DEFAULT NULL,
  `Device_first` varchar(200) DEFAULT NULL,
  `Device_last` varchar(200) DEFAULT NULL,
  `Created` date NOT NULL,
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicles_gateway_result` */

DROP TABLE IF EXISTS `l2_vehicles_gateway_result`;

CREATE TABLE `l2_vehicles_gateway_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `VehicleId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double DEFAULT 0,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_vehicles_log_result` */

DROP TABLE IF EXISTS `l2_vehicles_log_result`;

CREATE TABLE `l2_vehicles_log_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double DEFAULT 0,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_visitors` */

DROP TABLE IF EXISTS `l2_visitors`;

CREATE TABLE `l2_visitors` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL DEFAULT 'Mr',
  `F_name_EN` varchar(255) DEFAULT NULL,
  `F_name_AR` varchar(255) DEFAULT NULL,
  `M_name_EN` varchar(255) DEFAULT NULL,
  `M_name_AR` varchar(255) DEFAULT NULL,
  `L_name_EN` varchar(255) DEFAULT NULL,
  `L_name_AR` varchar(255) DEFAULT NULL,
  `DOP` date DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Created` datetime DEFAULT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) DEFAULT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Added_By` varchar(255) DEFAULT NULL,
  `machine_mac` varchar(128) DEFAULT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` varchar(255) DEFAULT NULL,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `generation` varchar(255) NOT NULL DEFAULT 'Visitor',
  `Parent_NID` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  KEY `Id` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=427 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_visitors_gateway_result` */

DROP TABLE IF EXISTS `l2_visitors_gateway_result`;

CREATE TABLE `l2_visitors_gateway_result` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Symptoms` varchar(255) DEFAULT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) DEFAULT NULL,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `Pass_rec_id` int(11) NOT NULL,
  `img_uri` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l2_visitors_result` */

DROP TABLE IF EXISTS `l2_visitors_result`;

CREATE TABLE `l2_visitors_result` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL DEFAULT 'Visitor',
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Symptoms` varchar(255) DEFAULT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) DEFAULT NULL,
  `Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `Pass_rec_id` int(11) NOT NULL,
  `img_uri` varchar(255) NOT NULL,
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=397525 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_about_us` */

DROP TABLE IF EXISTS `l3_about_us`;

CREATE TABLE `l3_about_us` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `En_title` varchar(255) NOT NULL,
  `Ar_title` varchar(255) NOT NULL,
  `En_article` text NOT NULL,
  `Ar_article` text NOT NULL,
  `targeted_users` varchar(200) NOT NULL COMMENT '= usertype (staff , student , teacher)',
  `school_id` int(11) NOT NULL,
  `en_image` text NOT NULL,
  `ar_image` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_articles` */

DROP TABLE IF EXISTS `l3_articles`;

CREATE TABLE `l3_articles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `En_title` varchar(255) NOT NULL,
  `Ar_title` varchar(255) NOT NULL,
  `En_article` text NOT NULL,
  `Ar_article` text NOT NULL,
  `targeted_users` varchar(200) NOT NULL COMMENT '= usertype (staff , student , teacher)',
  `school_id` int(11) NOT NULL,
  `en_image` text NOT NULL,
  `ar_image` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_mylifereports` */

DROP TABLE IF EXISTS `l3_mylifereports`;

CREATE TABLE `l3_mylifereports` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT 'sv_set_template_lifereports.id',
  `type_id` int(11) NOT NULL COMMENT 'sv_set_template_lifereports_choices.id',
  `user_id` int(11) NOT NULL,
  `description_en` text NOT NULL,
  `description_ar` text NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 0,
  `closed` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_mylifereports_actions` */

DROP TABLE IF EXISTS `l3_mylifereports_actions`;

CREATE TABLE `l3_mylifereports_actions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL,
  `userid` varchar(250) NOT NULL,
  `usertype` varchar(200) NOT NULL,
  `text_en` text NOT NULL,
  `text_ar` text NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_mylifereportsmedia` */

DROP TABLE IF EXISTS `l3_mylifereportsmedia`;

CREATE TABLE `l3_mylifereportsmedia` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL COMMENT './uploads/Mylifereportsmedia/',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_student_dashboard` */

DROP TABLE IF EXISTS `l3_student_dashboard`;

CREATE TABLE `l3_student_dashboard` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `value_type` int(11) NOT NULL COMMENT '= Id in l3_student_dashboard_standards',
  `value` varchar(200) NOT NULL,
  `last_update` datetime NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_student_dashboard_standards` */

DROP TABLE IF EXISTS `l3_student_dashboard_standards`;

CREATE TABLE `l3_student_dashboard_standards` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `icon` text NOT NULL COMMENT 'uploads\\Dashboard_icons/{icon name}',
  `goal` varchar(200) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `l3_videos` */

DROP TABLE IF EXISTS `l3_videos`;

CREATE TABLE `l3_videos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `by_school` int(11) NOT NULL COMMENT 'school id',
  `title` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `langauge` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `password_reset_tbl` */

DROP TABLE IF EXISTS `password_reset_tbl`;

CREATE TABLE `password_reset_tbl` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `login_id` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `typeofUser` varchar(255) NOT NULL,
  `expDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_28_conners_12_17` */

DROP TABLE IF EXISTS `r_28_conners_12_17`;

CREATE TABLE `r_28_conners_12_17` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_28_conners_3_5` */

DROP TABLE IF EXISTS `r_28_conners_3_5`;

CREATE TABLE `r_28_conners_3_5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_28_conners_6_11` */

DROP TABLE IF EXISTS `r_28_conners_6_11`;

CREATE TABLE `r_28_conners_6_11` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1111118 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_39_conners_12_17` */

DROP TABLE IF EXISTS `r_39_conners_12_17`;

CREATE TABLE `r_39_conners_12_17` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_ME` int(11) DEFAULT NULL,
  `grade_MF` int(11) DEFAULT NULL,
  `grade_MI` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  `grade_FE` int(11) DEFAULT NULL,
  `grade_FF` int(11) DEFAULT NULL,
  `grade_FI` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_39_conners_3_5` */

DROP TABLE IF EXISTS `r_39_conners_3_5`;

CREATE TABLE `r_39_conners_3_5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_ME` int(11) DEFAULT NULL,
  `grade_MF` int(11) DEFAULT NULL,
  `grade_MI` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  `grade_FE` int(11) DEFAULT NULL,
  `grade_FF` int(11) DEFAULT NULL,
  `grade_FI` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_39_conners_6_11` */

DROP TABLE IF EXISTS `r_39_conners_6_11`;

CREATE TABLE `r_39_conners_6_11` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_ME` int(11) DEFAULT NULL,
  `grade_MF` int(11) DEFAULT NULL,
  `grade_MI` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  `grade_FE` int(11) DEFAULT NULL,
  `grade_FF` int(11) DEFAULT NULL,
  `grade_FI` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_48_conners_12_17` */

DROP TABLE IF EXISTS `r_48_conners_12_17`;

CREATE TABLE `r_48_conners_12_17` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_ME` int(11) DEFAULT NULL,
  `grade_MF` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  `grade_FE` int(11) DEFAULT NULL,
  `grade_FF` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_48_conners_3_5` */

DROP TABLE IF EXISTS `r_48_conners_3_5`;

CREATE TABLE `r_48_conners_3_5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_ME` int(11) DEFAULT NULL,
  `grade_MF` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  `grade_FE` int(11) DEFAULT NULL,
  `grade_FF` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_48_conners_6_11` */

DROP TABLE IF EXISTS `r_48_conners_6_11`;

CREATE TABLE `r_48_conners_6_11` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `grade_MA` int(11) DEFAULT NULL,
  `grade_MB` int(11) DEFAULT NULL,
  `grade_MC` int(11) DEFAULT NULL,
  `grade_MD` int(11) DEFAULT NULL,
  `grade_ME` int(11) DEFAULT NULL,
  `grade_MF` int(11) DEFAULT NULL,
  `grade_FA` int(11) DEFAULT NULL,
  `grade_FB` int(11) DEFAULT NULL,
  `grade_FC` int(11) DEFAULT NULL,
  `grade_FD` int(11) DEFAULT NULL,
  `grade_FE` int(11) DEFAULT NULL,
  `grade_FF` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_93_conners_3_17` */

DROP TABLE IF EXISTS `r_93_conners_3_17`;

CREATE TABLE `r_93_conners_3_17` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_grade` int(11) DEFAULT NULL,
  `A` int(11) DEFAULT NULL,
  `B` int(11) DEFAULT NULL,
  `C` int(11) DEFAULT NULL,
  `D` int(11) DEFAULT NULL,
  `E` int(11) DEFAULT NULL,
  `F` int(11) DEFAULT NULL,
  `G` int(11) DEFAULT NULL,
  `H` int(11) DEFAULT NULL,
  `I` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_attendance_bace` */

DROP TABLE IF EXISTS `r_attendance_bace`;

CREATE TABLE `r_attendance_bace` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `rule_name` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_attendance_rule` */

DROP TABLE IF EXISTS `r_attendance_rule`;

CREATE TABLE `r_attendance_rule` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
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
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_cars_levels` */

DROP TABLE IF EXISTS `r_cars_levels`;

CREATE TABLE `r_cars_levels` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Class` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_cities` */

DROP TABLE IF EXISTS `r_cities`;

CREATE TABLE `r_cities` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Name_EN` varchar(255) NOT NULL,
  `Country_Id` int(11) NOT NULL,
  `code` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3889 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_company_type` */

DROP TABLE IF EXISTS `r_company_type`;

CREATE TABLE `r_company_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Company_Type` varchar(150) DEFAULT NULL COMMENT 'from r_company_type',
  `comments` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_countries` */

DROP TABLE IF EXISTS `r_countries`;

CREATE TABLE `r_countries` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `countey_code_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_dental_conditions` */

DROP TABLE IF EXISTS `r_dental_conditions`;

CREATE TABLE `r_dental_conditions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Dental_Conditions_AR` varchar(255) NOT NULL,
  `Dental_Conditions_EN` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_device_type` */

DROP TABLE IF EXISTS `r_device_type`;

CREATE TABLE `r_device_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(255) DEFAULT NULL,
  `device_type_en` varchar(255) NOT NULL,
  `device_type_ar` varchar(255) NOT NULL,
  `message_code_in` int(11) NOT NULL,
  `message_code_out` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_dialosticbp` */

DROP TABLE IF EXISTS `r_dialosticbp`;

CREATE TABLE `r_dialosticbp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `low_from` double NOT NULL,
  `from_to` double NOT NULL,
  `low_back_col` varchar(11) NOT NULL,
  `low_font_col` varchar(11) NOT NULL,
  `normal_from` double NOT NULL,
  `normal_to` double NOT NULL,
  `normal_back_col` varchar(11) NOT NULL,
  `normal_font_col` varchar(11) NOT NULL,
  `pre_from` double NOT NULL,
  `pre_to` double NOT NULL,
  `pre_back_col` varchar(11) NOT NULL,
  `pre_font_col` varchar(11) NOT NULL,
  `high_from` double NOT NULL,
  `hight_to` double NOT NULL,
  `hight_back_col` varchar(11) NOT NULL,
  `hight_font_col` varchar(11) NOT NULL,
  `high2_from` double NOT NULL,
  `high2_to` double NOT NULL,
  `high2_back_col` varchar(11) NOT NULL,
  `high2_font_col` varchar(11) NOT NULL,
  `Name_Item` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_examination_code` */

DROP TABLE IF EXISTS `r_examination_code`;

CREATE TABLE `r_examination_code` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Code` varchar(10) DEFAULT NULL,
  `Description_AR` varchar(255) NOT NULL,
  `Description_EN` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_levels` */

DROP TABLE IF EXISTS `r_levels`;

CREATE TABLE `r_levels` (
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Class` varchar(255) NOT NULL,
  `Class_ar` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_lookup` */

DROP TABLE IF EXISTS `r_lookup`;

CREATE TABLE `r_lookup` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Lookup_Name` varchar(255) NOT NULL,
  `Description_AR` varchar(255) NOT NULL,
  `Description_EN` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_messages` */

DROP TABLE IF EXISTS `r_messages`;

CREATE TABLE `r_messages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `message_en` text NOT NULL,
  `message_ar` text NOT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1: Superadmin 2: Company 3: Ministry 4: Department 5: School',
  `typeID` int(6) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0: Private 1: Public',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_positions` */

DROP TABLE IF EXISTS `r_positions`;

CREATE TABLE `r_positions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Position` varchar(255) NOT NULL,
  `AR_Position` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_positions_gm` */

DROP TABLE IF EXISTS `r_positions_gm`;

CREATE TABLE `r_positions_gm` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Position` varchar(255) NOT NULL,
  `AR_Position` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_positions_sch` */

DROP TABLE IF EXISTS `r_positions_sch`;

CREATE TABLE `r_positions_sch` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Position` varchar(255) NOT NULL,
  `AR_Position` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_positions_tech` */

DROP TABLE IF EXISTS `r_positions_tech`;

CREATE TABLE `r_positions_tech` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Position` varchar(255) NOT NULL,
  `AR_Position` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_prefix` */

DROP TABLE IF EXISTS `r_prefix`;

CREATE TABLE `r_prefix` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL,
  `Prefix_ar` varchar(20) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_sites` */

DROP TABLE IF EXISTS `r_sites`;

CREATE TABLE `r_sites` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Site_Name` varchar(255) NOT NULL,
  `Site_Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Site_Name_ar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_standards` */

DROP TABLE IF EXISTS `r_standards`;

CREATE TABLE `r_standards` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NULL DEFAULT current_timestamp(),
  `Name_en` varchar(200) NOT NULL,
  `Name_ar` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_style` */

DROP TABLE IF EXISTS `r_style`;

CREATE TABLE `r_style` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ar_co_type` varchar(255) NOT NULL,
  `en_co_type` varchar(255) NOT NULL,
  `ar_co_type_sub` varchar(255) NOT NULL,
  `en_co_type_sub` varchar(255) NOT NULL,
  `style_name` varchar(255) NOT NULL,
  `type` varchar(1) DEFAULT NULL COMMENT 'M = ministry ; c = Company',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_symptoms` */

DROP TABLE IF EXISTS `r_symptoms`;

CREATE TABLE `r_symptoms` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `symptoms_EN` varchar(255) NOT NULL,
  `symptoms_AR` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_temp_levels` */

DROP TABLE IF EXISTS `r_temp_levels`;

CREATE TABLE `r_temp_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(150) NOT NULL,
  `from` double NOT NULL,
  `to` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_testcode` */

DROP TABLE IF EXISTS `r_testcode`;

CREATE TABLE `r_testcode` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `CPT_Code` varchar(255) NOT NULL,
  `Test_Desc` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_usertype` */

DROP TABLE IF EXISTS `r_usertype`;

CREATE TABLE `r_usertype` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserType` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `AR_UserType` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_usertype_school` */

DROP TABLE IF EXISTS `r_usertype_school`;

CREATE TABLE `r_usertype_school` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserType` varchar(255) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `AR_UserType` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_vaccines` */

DROP TABLE IF EXISTS `r_vaccines`;

CREATE TABLE `r_vaccines` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Vaccines_AR` varchar(255) NOT NULL,
  `Vaccines_EN` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `r_z_scores` */

DROP TABLE IF EXISTS `r_z_scores`;

CREATE TABLE `r_z_scores` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `accept_from` float NOT NULL,
  `accept_to` float NOT NULL,
  `color` varchar(200) NOT NULL,
  `font_color` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_area` */

DROP TABLE IF EXISTS `refrigerator_area`;

CREATE TABLE `refrigerator_area` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `source_id` int(11) NOT NULL,
  `mac_adress` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `Site_Id` varchar(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `generation` varchar(255) NOT NULL,
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `sourseId` (`source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_levels` */

DROP TABLE IF EXISTS `refrigerator_levels`;

CREATE TABLE `refrigerator_levels` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `device_name` varchar(255) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `min_temp` double NOT NULL,
  `max_temp` double NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  `device_name_ar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_result_daily` */

DROP TABLE IF EXISTS `refrigerator_result_daily`;

CREATE TABLE `refrigerator_result_daily` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_result_gateway` */

DROP TABLE IF EXISTS `refrigerator_result_gateway`;

CREATE TABLE `refrigerator_result_gateway` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_result_log_daily` */

DROP TABLE IF EXISTS `refrigerator_result_log_daily`;

CREATE TABLE `refrigerator_result_log_daily` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `Added_By` varchar(255) NOT NULL,
  `trip_name` datetime DEFAULT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `mUtcTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_result_monthly` */

DROP TABLE IF EXISTS `refrigerator_result_monthly`;

CREATE TABLE `refrigerator_result_monthly` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result_min_Time` time NOT NULL DEFAULT '00:00:00',
  `Result_min` double NOT NULL DEFAULT 0,
  `Result_max_Time` time NOT NULL DEFAULT '00:00:00',
  `Result_max` double NOT NULL DEFAULT 0,
  `Humidity_min_Time` time NOT NULL DEFAULT '00:00:00',
  `Humidity_min` double NOT NULL DEFAULT 0,
  `Humidity_max_Time` time NOT NULL DEFAULT '00:00:00',
  `Humidity_max` double NOT NULL DEFAULT 0,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `generation` varchar(255) DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=694 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `refrigerator_visitor` */

DROP TABLE IF EXISTS `refrigerator_visitor`;

CREATE TABLE `refrigerator_visitor` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `source_id` int(11) DEFAULT NULL,
  `mac_adress` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `Added_By_NID` varchar(255) NOT NULL,
  `Site_Id` varchar(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `sourseId` (`source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `region` */

DROP TABLE IF EXISTS `region`;

CREATE TABLE `region` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `region` varchar(255) NOT NULL,
  `generation` varchar(255) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_climate_answers` */

DROP TABLE IF EXISTS `scl_climate_answers`;

CREATE TABLE `scl_climate_answers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1 = staff , \r\n2 = student ,\r\n3 = teacher ,\r\n4 = parent',
  `climate_id` int(11) NOT NULL,
  `questionnaire` int(11) NOT NULL DEFAULT 0 COMMENT 'about all the questionnaire ',
  `questions` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding Questions\r\n',
  `options` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding The Options\r\n',
  `interaction` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Interaction With The Questionnaire\r\n',
  `review` text NOT NULL,
  `accepted_review` int(11) NOT NULL DEFAULT 0 COMMENT 'when 1 thats mean we can use it in report and when its 0 we not',
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `Added_by` varchar(255) NOT NULL DEFAULT 'Web',
  PRIMARY KEY (`Id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_co_climate_answers` */

DROP TABLE IF EXISTS `scl_co_climate_answers`;

CREATE TABLE `scl_co_climate_answers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `climate_id` int(11) NOT NULL,
  `questionnaire` int(11) NOT NULL DEFAULT 0 COMMENT 'about all the questionnaire ',
  `questions` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding Questions\r\n',
  `options` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding The Options\r\n',
  `interaction` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Interaction With The Questionnaire\r\n',
  `review` text NOT NULL,
  `accepted_review` int(11) NOT NULL DEFAULT 0 COMMENT 'when 1 thats mean we can use it in report and when its 0 we not',
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `Added_by` varchar(255) NOT NULL DEFAULT 'Web',
  PRIMARY KEY (`Id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_claimate` */

DROP TABLE IF EXISTS `scl_published_claimate`;

CREATE TABLE `scl_published_claimate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `By_school` int(11) NOT NULL,
  `climate_id` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_claimate_genders` */

DROP TABLE IF EXISTS `scl_published_claimate_genders`;

CREATE TABLE `scl_published_claimate_genders` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Climate_id` int(11) NOT NULL,
  `Gender_code` varchar(250) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_claimate_levels` */

DROP TABLE IF EXISTS `scl_published_claimate_levels`;

CREATE TABLE `scl_published_claimate_levels` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Claimate_id` int(11) NOT NULL,
  `Level_code` int(11) NOT NULL,
  `Created` int(11) NOT NULL,
  `Time` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_claimate_types` */

DROP TABLE IF EXISTS `scl_published_claimate_types`;

CREATE TABLE `scl_published_claimate_types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Climate_id` int(11) NOT NULL,
  `Type_code` int(11) NOT NULL COMMENT '1 = staff ,\r\n2 = students ,\r\n3 = Teachers ,\r\n4 = Parents',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_co_claimate` */

DROP TABLE IF EXISTS `scl_published_co_claimate`;

CREATE TABLE `scl_published_co_claimate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `By_department` int(11) NOT NULL,
  `climate_id` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_co_claimate_genders` */

DROP TABLE IF EXISTS `scl_published_co_claimate_genders`;

CREATE TABLE `scl_published_co_claimate_genders` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Climate_id` int(11) NOT NULL,
  `Gender_code` varchar(250) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_published_co_claimate_types` */

DROP TABLE IF EXISTS `scl_published_co_claimate_types`;

CREATE TABLE `scl_published_co_claimate_types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Climate_id` int(11) NOT NULL,
  `Type_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_st0_climate` */

DROP TABLE IF EXISTS `scl_st0_climate`;

CREATE TABLE `scl_st0_climate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `set_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `answer_group` int(11) unsigned zerofill NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `question_id` int(11) NOT NULL,
  `Created` date NOT NULL,
  `targeted_type` varchar(10) NOT NULL DEFAULT 'M',
  `style` int(11) NOT NULL COMMENT '= id in scl_st0_climate_styles',
  `Published_to` int(11) NOT NULL DEFAULT 0,
  `Time` time NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_st0_climate_styles` */

DROP TABLE IF EXISTS `scl_st0_climate_styles`;

CREATE TABLE `scl_st0_climate_styles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_st0_climate_targeted_accounts` */

DROP TABLE IF EXISTS `scl_st0_climate_targeted_accounts`;

CREATE TABLE `scl_st0_climate_targeted_accounts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL COMMENT '= id in scl_st0_climate',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` int(11) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_st_choices` */

DROP TABLE IF EXISTS `scl_st_choices`;

CREATE TABLE `scl_st_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servey_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL COMMENT '= id in sv_set_template_answers_choices',
  `icon_en` text DEFAULT NULL,
  `icon_ar` text DEFAULT NULL,
  `position` int(11) NOT NULL,
  `mark` int(11) NOT NULL DEFAULT 0,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_st_climate` */

DROP TABLE IF EXISTS `scl_st_climate`;

CREATE TABLE `scl_st_climate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Title_en` varchar(255) NOT NULL,
  `Title_ar` varchar(255) NOT NULL,
  `Startting_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Avalaible_to` int(11) NOT NULL COMMENT '1 = both ,\r\n2 = Government ,\r\n3 = Private',
  `Status` int(11) NOT NULL DEFAULT 0,
  `Climate_id` int(11) NOT NULL COMMENT ' = id in sv_st_surveys table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Published_by` int(11) DEFAULT NULL COMMENT '= Id in l0_organization',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `scl_st_co_climate` */

DROP TABLE IF EXISTS `scl_st_co_climate`;

CREATE TABLE `scl_st_co_climate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Title_en` varchar(255) NOT NULL,
  `Title_ar` varchar(255) NOT NULL,
  `Startting_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Avalaible_to` int(11) NOT NULL COMMENT '1 = both ,\r\n2 = Government ,\r\n3 = Private',
  `Status` int(11) NOT NULL DEFAULT 0,
  `Climate_id` int(11) NOT NULL COMMENT ' = id in sv_st_surveys table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Published_by` int(11) DEFAULT NULL COMMENT '= Id in l0_organization',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `st_sv_categorys_articles` */

DROP TABLE IF EXISTS `st_sv_categorys_articles`;

CREATE TABLE `st_sv_categorys_articles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Article` text NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL DEFAULT 0,
  `AccountType` int(200) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `st_sv_categorys_resources` */

DROP TABLE IF EXISTS `st_sv_categorys_resources`;

CREATE TABLE `st_sv_categorys_resources` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cat_id` int(11) DEFAULT NULL COMMENT '= Id in sv_st_category',
  `AccountId` int(11) NOT NULL DEFAULT 0,
  `AccountType` varchar(200) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL COMMENT 'uploads\\Category_resources/{this name}',
  `language_resource` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `student_dental_examination` */

DROP TABLE IF EXISTS `student_dental_examination`;

CREATE TABLE `student_dental_examination` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `DentalId` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `student_health_history_comments` */

DROP TABLE IF EXISTS `student_health_history_comments`;

CREATE TABLE `student_health_history_comments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Date` date DEFAULT NULL,
  `Note` varchar(255) NOT NULL,
  `Signature` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `student_health_record` */

DROP TABLE IF EXISTS `student_health_record`;

CREATE TABLE `student_health_record` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Preschool` date DEFAULT NULL,
  `Elementary` date DEFAULT NULL,
  `Intermediate` date DEFAULT NULL,
  `High` date DEFAULT NULL,
  `Parent_Name_Mother` varchar(255) NOT NULL,
  `Parent_Name_Father` varchar(255) NOT NULL,
  `Allergies` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Seniorhighschool` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `student_medical_status` */

DROP TABLE IF EXISTS `student_medical_status`;

CREATE TABLE `student_medical_status` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Allergy` int(11) DEFAULT NULL,
  `Asthma` int(11) DEFAULT NULL,
  `Behavioral_Problems` int(11) DEFAULT NULL,
  `Cancer_Leukemia` int(11) DEFAULT NULL,
  `Chronic_Cough_Wheezing` int(11) DEFAULT NULL,
  `Diabetes` int(11) DEFAULT NULL,
  `Hearing_Problems` int(11) DEFAULT NULL,
  `Heart_Disease` int(11) DEFAULT NULL,
  `Hemophilia` int(11) DEFAULT NULL,
  `Hypertension` int(11) DEFAULT NULL,
  `JRA_Arthritis` int(11) DEFAULT NULL,
  `Rheumatic_Heart` int(11) DEFAULT NULL,
  `Seizures` int(11) DEFAULT NULL,
  `Sickle_Cell_Anemia` int(11) DEFAULT NULL,
  `Skin_Problems` int(11) DEFAULT NULL,
  `Vision_Problem` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `student_physicians_examination_code` */

DROP TABLE IF EXISTS `student_physicians_examination_code`;

CREATE TABLE `student_physicians_examination_code` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Grade` int(11) DEFAULT NULL,
  `Height` int(11) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `BMI` varchar(5) DEFAULT NULL,
  `Blood_Pressure` varchar(5) DEFAULT NULL,
  `R_Vision` varchar(5) DEFAULT NULL,
  `L_Vision` varchar(5) DEFAULT NULL,
  `R_Hearing` varchar(5) DEFAULT NULL,
  `L_Hearing` varchar(5) DEFAULT NULL,
  `Eyes` varchar(5) DEFAULT NULL,
  `Ears` varchar(5) DEFAULT NULL,
  `Nose` varchar(5) DEFAULT NULL,
  `Throat` varchar(5) DEFAULT NULL,
  `Teeth` varchar(5) DEFAULT NULL,
  `Heart` varchar(5) DEFAULT NULL,
  `Lungs` varchar(5) DEFAULT NULL,
  `Abdomen` varchar(5) DEFAULT NULL,
  `Nervous_System` varchar(5) DEFAULT NULL,
  `Skin` varchar(5) DEFAULT NULL,
  `Scoliosis` varchar(5) DEFAULT NULL,
  `Extremities` varchar(5) DEFAULT NULL,
  `Nutrition` varchar(5) DEFAULT NULL,
  `varicella_Immunity_Secondary_to_Disease` date DEFAULT NULL,
  `Reviewed_Immunization_Record` varchar(10) DEFAULT NULL,
  `Completed_PPD_Screening` varchar(10) DEFAULT NULL,
  `Providers_Signature` varchar(255) NOT NULL,
  `Printed_Name` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `student_vaccines` */

DROP TABLE IF EXISTS `student_vaccines`;

CREATE TABLE `student_vaccines` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `VaccinesId` int(11) NOT NULL,
  `Date01` date DEFAULT NULL,
  `Date02` date DEFAULT NULL,
  `Date03` date DEFAULT NULL,
  `Date04` date DEFAULT NULL,
  `Date05` date DEFAULT NULL,
  `Date06` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `superadmin` */

DROP TABLE IF EXISTS `superadmin`;

CREATE TABLE `superadmin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `generation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_choices` */

DROP TABLE IF EXISTS `sv_choices`;

CREATE TABLE `sv_choices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `question_id` int(11) NOT NULL,
  `choice_title` int(11) NOT NULL,
  `choice_desc` int(11) NOT NULL,
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_choices_libaray` */

DROP TABLE IF EXISTS `sv_choices_libaray`;

CREATE TABLE `sv_choices_libaray` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `generation` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_co_published_surveys` */

DROP TABLE IF EXISTS `sv_co_published_surveys`;

CREATE TABLE `sv_co_published_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Created_By` int(11) NOT NULL,
  `Serv_id` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `theme_link` int(11) NOT NULL COMMENT '= id in sv_st_themes table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `survey_type` varchar(255) NOT NULL DEFAULT 'notfillable',
  PRIMARY KEY (`Id`),
  KEY `theme_link` (`theme_link`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_co_published_surveys_genders` */

DROP TABLE IF EXISTS `sv_co_published_surveys_genders`;

CREATE TABLE `sv_co_published_surveys_genders` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Gender_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_co_published_surveys_types` */

DROP TABLE IF EXISTS `sv_co_published_surveys_types`;

CREATE TABLE `sv_co_published_surveys_types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Type_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_dedicated_surveys` */

DROP TABLE IF EXISTS `sv_dedicated_surveys`;

CREATE TABLE `sv_dedicated_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `completed` int(11) NOT NULL DEFAULT 0,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `usertype` varchar(200) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_dedicated_surveys_answers` */

DROP TABLE IF EXISTS `sv_dedicated_surveys_answers`;

CREATE TABLE `sv_dedicated_surveys_answers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Survey_id` int(11) NOT NULL COMMENT '= Id in sv_dedicated_surveys',
  `User_id` int(11) NOT NULL,
  `Student_id` int(11) NOT NULL,
  `User_type` varchar(200) NOT NULL,
  `finishing_time` varchar(200) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_dedicated_surveys_answers_values` */

DROP TABLE IF EXISTS `sv_dedicated_surveys_answers_values`;

CREATE TABLE `sv_dedicated_surveys_answers_values` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `answers_data_id` int(11) NOT NULL,
  `answer_value` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_dedicated_surveys_students` */

DROP TABLE IF EXISTS `sv_dedicated_surveys_students`;

CREATE TABLE `sv_dedicated_surveys_students` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `survey_request` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_department_published_surveys` */

DROP TABLE IF EXISTS `sv_department_published_surveys`;

CREATE TABLE `sv_department_published_surveys` (
  `Id` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `By_dept` int(11) NOT NULL,
  `Serv_id` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `theme_link` int(11) NOT NULL COMMENT '= id in sv_st_themes table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `survey_type` varchar(255) NOT NULL DEFAULT 'notfillable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_department_published_surveys_genders` */

DROP TABLE IF EXISTS `sv_department_published_surveys_genders`;

CREATE TABLE `sv_department_published_surveys_genders` (
  `Id` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Gender_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_department_published_surveys_types` */

DROP TABLE IF EXISTS `sv_department_published_surveys_types`;

CREATE TABLE `sv_department_published_surveys_types` (
  `Id` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Type_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_permission` */

DROP TABLE IF EXISTS `sv_permission`;

CREATE TABLE `sv_permission` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `is_passed` int(11) NOT NULL DEFAULT 0,
  `created` date NOT NULL,
  `time` time NOT NULL,
  `survey_id` int(11) NOT NULL,
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_questions_library` */

DROP TABLE IF EXISTS `sv_questions_library`;

CREATE TABLE `sv_questions_library` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `serv_id` int(11) NOT NULL,
  `ar_title` text NOT NULL,
  `en_title` text NOT NULL,
  `ar_desc` text NOT NULL,
  `en_desc` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `generation` varchar(50) NOT NULL,
  `created` date NOT NULL,
  `time` time NOT NULL,
  `counter_charts_en` text DEFAULT NULL,
  `counter_charts_ar` text DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=767 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_school_published_fillable_surveys_targetedusers` */

DROP TABLE IF EXISTS `sv_school_published_fillable_surveys_targetedusers`;

CREATE TABLE `sv_school_published_fillable_surveys_targetedusers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Survey_id` int(11) NOT NULL COMMENT '= Id in ',
  `user_Type` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Company_Type` int(11) DEFAULT 5,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_school_published_surveys` */

DROP TABLE IF EXISTS `sv_school_published_surveys`;

CREATE TABLE `sv_school_published_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `By_school` int(11) NOT NULL,
  `Serv_id` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `theme_link` int(11) NOT NULL COMMENT '= id in sv_st_themes table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `survey_type` varchar(255) NOT NULL DEFAULT 'notfillable',
  PRIMARY KEY (`Id`),
  KEY `theme_link` (`theme_link`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_school_published_surveys_genders` */

DROP TABLE IF EXISTS `sv_school_published_surveys_genders`;

CREATE TABLE `sv_school_published_surveys_genders` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Gender_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_school_published_surveys_levels` */

DROP TABLE IF EXISTS `sv_school_published_surveys_levels`;

CREATE TABLE `sv_school_published_surveys_levels` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Level_code` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_school_published_surveys_types` */

DROP TABLE IF EXISTS `sv_school_published_surveys_types`;

CREATE TABLE `sv_school_published_surveys_types` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Survey_id` int(11) NOT NULL,
  `Type_code` int(11) NOT NULL COMMENT '1 = staff ,\r\n2 = students ,\r\n3 = Teachers ,\r\n4 = Parents',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_set_questions` */

DROP TABLE IF EXISTS `sv_set_questions`;

CREATE TABLE `sv_set_questions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `set_id` int(11) NOT NULL,
  `title_en` text NOT NULL,
  `title_ar` text NOT NULL,
  `place` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `generation` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_set_template_answers` */

DROP TABLE IF EXISTS `sv_set_template_answers`;

CREATE TABLE `sv_set_template_answers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `generation` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_set_template_answers_choices` */

DROP TABLE IF EXISTS `sv_set_template_answers_choices`;

CREATE TABLE `sv_set_template_answers_choices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `title_en` text NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_set_template_lifereports` */

DROP TABLE IF EXISTS `sv_set_template_lifereports`;

CREATE TABLE `sv_set_template_lifereports` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `generation` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_set_template_lifereports_choices` */

DROP TABLE IF EXISTS `sv_set_template_lifereports_choices`;

CREATE TABLE `sv_set_template_lifereports_choices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `title_en` text NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_sets` */

DROP TABLE IF EXISTS `sv_sets`;

CREATE TABLE `sv_sets` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title_en` text NOT NULL,
  `title_ar` text NOT NULL,
  `status` int(11) NOT NULL,
  `created` date NOT NULL,
  `time` time NOT NULL,
  `code` varchar(50) NOT NULL DEFAULT '',
  `generation` varchar(14) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_answers` */

DROP TABLE IF EXISTS `sv_st1_answers`;

CREATE TABLE `sv_st1_answers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1 = staff , \r\n2 = student ,\r\n3 = teacher ,\r\n4 = parent',
  `survey_type` varchar(200) NOT NULL DEFAULT 'notfillable',
  `show_user_name` int(11) NOT NULL DEFAULT 1,
  `finishing_time` time NOT NULL,
  `serv_id` int(11) NOT NULL,
  `questionnaire` int(11) NOT NULL DEFAULT 0 COMMENT 'about all the questionnaire ',
  `questions` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding Questions\r\n',
  `options` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding The Options\r\n',
  `interaction` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Interaction With The Questionnaire\r\n',
  `review` text NOT NULL DEFAULT 'no review found here' COMMENT 'Review -> text (Optiona)',
  `accepted_review` int(11) NOT NULL DEFAULT 0 COMMENT 'when 1 thats mean we can use it in report and when its 0 we not',
  PRIMARY KEY (`Id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_answers_values` */

DROP TABLE IF EXISTS `sv_st1_answers_values`;

CREATE TABLE `sv_st1_answers_values` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  `answers_data_id` int(11) NOT NULL COMMENT '= id in sv_st1_answers table',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_co_answers` */

DROP TABLE IF EXISTS `sv_st1_co_answers`;

CREATE TABLE `sv_st1_co_answers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `survey_type` varchar(200) NOT NULL DEFAULT 'notfillable',
  `show_user_name` int(11) NOT NULL DEFAULT 1,
  `finishing_time` time NOT NULL,
  `serv_id` int(11) NOT NULL,
  `questionnaire` int(11) NOT NULL DEFAULT 0 COMMENT 'about all the questionnaire ',
  `questions` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding Questions\r\n',
  `options` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Understanding The Options\r\n',
  `interaction` int(11) NOT NULL DEFAULT 0 COMMENT 'Ease Of Interaction With The Questionnaire\r\n',
  `review` text NOT NULL DEFAULT 'no review found here' COMMENT 'Review -> text (Optiona)',
  `accepted_review` int(11) NOT NULL DEFAULT 0 COMMENT 'when 1 thats mean we can use it in report and when its 0 we not',
  PRIMARY KEY (`Id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_co_answers_values` */

DROP TABLE IF EXISTS `sv_st1_co_answers_values`;

CREATE TABLE `sv_st1_co_answers_values` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  `answers_data_id` int(11) NOT NULL COMMENT '= id in sv_st1_answers table',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_co_surveys` */

DROP TABLE IF EXISTS `sv_st1_co_surveys`;

CREATE TABLE `sv_st1_co_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Title_en` varchar(255) NOT NULL,
  `Title_ar` varchar(255) NOT NULL,
  `Startting_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Avalaible_to` int(11) NOT NULL COMMENT '1 = both ,\r\n2 = Government ,\r\n3 = Private',
  `Status` int(11) NOT NULL DEFAULT 0,
  `Survey_id` int(11) NOT NULL COMMENT ' = id in sv_st_surveys table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Published_by` int(11) DEFAULT NULL COMMENT '= Id in l0_organization',
  `survey_type` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_fillable_answers_values` */

DROP TABLE IF EXISTS `sv_st1_fillable_answers_values`;

CREATE TABLE `sv_st1_fillable_answers_values` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `QuestionId` int(11) NOT NULL,
  `answer_Value` text NOT NULL,
  `answer_data_id` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st1_surveys` */

DROP TABLE IF EXISTS `sv_st1_surveys`;

CREATE TABLE `sv_st1_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Title_en` varchar(255) NOT NULL,
  `Title_ar` varchar(255) NOT NULL,
  `Startting_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Avalaible_to` int(11) NOT NULL COMMENT '1 = both ,\r\n2 = Government ,\r\n3 = Private',
  `Status` int(11) NOT NULL DEFAULT 0,
  `Survey_id` int(11) NOT NULL COMMENT ' = id in sv_st_surveys table',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Published_by` int(11) DEFAULT NULL COMMENT '= Id in l0_organization',
  `survey_type` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_answers_mark` */

DROP TABLE IF EXISTS `sv_st_answers_mark`;

CREATE TABLE `sv_st_answers_mark` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=625 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_categories_reports_files` */

DROP TABLE IF EXISTS `sv_st_categories_reports_files`;

CREATE TABLE `sv_st_categories_reports_files` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` datetime NOT NULL DEFAULT current_timestamp(),
  `Category_id` int(11) NOT NULL,
  `Staff_file_en` varchar(250) DEFAULT NULL,
  `Teacher_file_en` varchar(250) DEFAULT NULL,
  `Student_file_en` varchar(250) DEFAULT NULL,
  `Parent_file_en` varchar(250) DEFAULT NULL,
  `Staff_file_ar` varchar(250) NOT NULL,
  `Teacher_file_ar` varchar(250) NOT NULL,
  `Student_file_ar` varchar(250) NOT NULL,
  `Parent_file_ar` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_category` */

DROP TABLE IF EXISTS `sv_st_category`;

CREATE TABLE `sv_st_category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Cat_en` varchar(255) NOT NULL,
  `Cat_ar` varchar(255) NOT NULL,
  `Code` varchar(100) NOT NULL,
  `action_name_en` varchar(200) NOT NULL COMMENT 'upload by superadmin',
  `action_name_ar` varchar(200) NOT NULL COMMENT 'upload by superadmin',
  `action_en_url` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `action_ar_url` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `report_name_en` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `report_name_ar` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `report_en_url` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `report_ar_url` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `media_name_en` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `media_name_ar` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `media_en_url` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `media_ar_url` varchar(200) DEFAULT NULL COMMENT 'upload by superadmin',
  `icon_en` text DEFAULT NULL,
  `icon_ar` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_category_media_links` */

DROP TABLE IF EXISTS `sv_st_category_media_links`;

CREATE TABLE `sv_st_category_media_links` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `langauge` varchar(50) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `AccountId` int(11) NOT NULL DEFAULT 0,
  `AccountType` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_fillable_groups` */

DROP TABLE IF EXISTS `sv_st_fillable_groups`;

CREATE TABLE `sv_st_fillable_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `serv_id` int(11) NOT NULL COMMENT '= Id in sv_st_surveys table',
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_fillable_questions` */

DROP TABLE IF EXISTS `sv_st_fillable_questions`;

CREATE TABLE `sv_st_fillable_questions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Group_id` int(11) DEFAULT 0 COMMENT 'Id in sv_st_groups',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=420 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_fillable_surveys` */

DROP TABLE IF EXISTS `sv_st_fillable_surveys`;

CREATE TABLE `sv_st_fillable_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `set_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `code` varchar(50) NOT NULL,
  `generation` varchar(50) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `reference_en` text DEFAULT NULL,
  `reference_ar` text DEFAULT NULL,
  `disclaimer_en` text DEFAULT NULL,
  `disclaimer_ar` text DEFAULT NULL,
  `Message_en` text NOT NULL,
  `Message_ar` text NOT NULL,
  `targeted_type` varchar(10) NOT NULL DEFAULT 'M' COMMENT 'M  = ministry , C = Company',
  `style` int(11) DEFAULT NULL COMMENT '= id in scl_st0_climate_styles',
  `Company_Type` int(11) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_groups` */

DROP TABLE IF EXISTS `sv_st_groups`;

CREATE TABLE `sv_st_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `serv_id` int(11) NOT NULL COMMENT '= Id in sv_st_surveys table',
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_questions` */

DROP TABLE IF EXISTS `sv_st_questions`;

CREATE TABLE `sv_st_questions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Group_id` int(11) DEFAULT 0 COMMENT 'Id in sv_st_groups',
  `results_standard_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_standars_groups` */

DROP TABLE IF EXISTS `sv_st_standars_groups`;

CREATE TABLE `sv_st_standars_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `serv_id` int(11) NOT NULL COMMENT '= Id in sv_st_surveys table	',
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `Standard_Id` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_surveys` */

DROP TABLE IF EXISTS `sv_st_surveys`;

CREATE TABLE `sv_st_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `set_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `answer_group_en` int(11) NOT NULL COMMENT '= id in sv_set_template_answers',
  `answer_group_ar` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `code` varchar(50) NOT NULL,
  `generation` varchar(50) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `reference_en` text DEFAULT NULL,
  `reference_ar` text DEFAULT NULL,
  `disclaimer_en` text DEFAULT NULL,
  `disclaimer_ar` text DEFAULT NULL,
  `Message_en` text DEFAULT NULL,
  `Message_ar` text DEFAULT NULL,
  `targeted_type` varchar(10) NOT NULL DEFAULT 'M' COMMENT 'M = ministry , C = Company',
  `style` int(11) DEFAULT NULL COMMENT '= id in scl_st0_climate_styles',
  `Company_Type` int(11) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_targeted_accounts` */

DROP TABLE IF EXISTS `sv_st_targeted_accounts`;

CREATE TABLE `sv_st_targeted_accounts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `survey_id` int(11) NOT NULL COMMENT '= id in sv_st_fillable_surveys or sv_st_surveys',
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` int(11) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_st_themes` */

DROP TABLE IF EXISTS `sv_st_themes`;

CREATE TABLE `sv_st_themes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title_an` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL COMMENT 'assets/sv_themes/css',
  `image_name` varchar(255) NOT NULL COMMENT 'assets/sv_themes/img',
  `preview_color` varchar(255) NOT NULL COMMENT 'as hex color to show',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_standard_questions_groups` */

DROP TABLE IF EXISTS `sv_standard_questions_groups`;

CREATE TABLE `sv_standard_questions_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Question_id` int(11) NOT NULL COMMENT '= Id in sv_st_questions',
  `results_standard_group` int(11) NOT NULL COMMENT '= Id in sv_st_standars_groups',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sv_surveys` */

DROP TABLE IF EXISTS `sv_surveys`;

CREATE TABLE `sv_surveys` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `to_user` int(11) NOT NULL,
  `questions_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` date NOT NULL,
  `time` time NOT NULL,
  `expired_date` date NOT NULL,
  `notifications` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v0_area_depts_devices_permissions` */

DROP TABLE IF EXISTS `v0_area_depts_devices_permissions`;

CREATE TABLE `v0_area_depts_devices_permissions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `by_dept` int(11) NOT NULL,
  `to_dept` int(11) NOT NULL,
  `seen` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v0_area_device_permission` */

DROP TABLE IF EXISTS `v0_area_device_permission`;

CREATE TABLE `v0_area_device_permission` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `system_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `relation_type` int(11) NOT NULL COMMENT '0 = for company_dep\r\n1 = for other dept',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v0_companys_results_permissions` */

DROP TABLE IF EXISTS `v0_companys_results_permissions`;

CREATE TABLE `v0_companys_results_permissions` (
  `Id` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `by_company` int(11) NOT NULL,
  `to_company` int(11) NOT NULL,
  `seen` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v0_departments_results_permissions` */

DROP TABLE IF EXISTS `v0_departments_results_permissions`;

CREATE TABLE `v0_departments_results_permissions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `by_dept` int(11) NOT NULL,
  `to_dept` int(11) NOT NULL,
  `list` int(11) NOT NULL DEFAULT 1,
  `adding` int(11) NOT NULL DEFAULT 0,
  `seen` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v0_permissions` */

DROP TABLE IF EXISTS `v0_permissions`;

CREATE TABLE `v0_permissions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `Air_quality` varchar(255) NOT NULL DEFAULT '0',
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `surveys` varchar(255) NOT NULL DEFAULT '0',
  `visitors` int(11) NOT NULL DEFAULT 0,
  `cars` int(11) NOT NULL DEFAULT 0,
  `LoadFromCsv` int(11) NOT NULL DEFAULT 0,
  `TemperatureAndLab` int(11) DEFAULT 0,
  `Claimate` int(11) NOT NULL DEFAULT 0,
  `Company_Type` int(11) DEFAULT NULL,
  `attendance` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v0_schools_results_permissions` */

DROP TABLE IF EXISTS `v0_schools_results_permissions`;

CREATE TABLE `v0_schools_results_permissions` (
  `Id` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `by_school` int(11) NOT NULL,
  `to_school` int(11) NOT NULL,
  `list` int(11) NOT NULL DEFAULT 1,
  `adding` int(11) NOT NULL DEFAULT 0,
  `seen` int(11) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v1_permissions` */

DROP TABLE IF EXISTS `v1_permissions`;

CREATE TABLE `v1_permissions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `Air_quality` varchar(255) NOT NULL DEFAULT '0',
  `surveys` varchar(255) NOT NULL DEFAULT '0',
  `visitors` int(11) NOT NULL DEFAULT 0,
  `cars` int(11) NOT NULL DEFAULT 0,
  `LoadFromCsv` int(11) NOT NULL DEFAULT 0,
  `Created` date NOT NULL,
  `Time` time NOT NULL,
  `Company_Type` int(11) DEFAULT 1,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_login` */

DROP TABLE IF EXISTS `v_login`;

CREATE TABLE `v_login` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Company_Type` int(11) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `otp` int(11) NOT NULL,
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `city` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `Token` varchar(255) NOT NULL,
  `User_id` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1043 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_nationalids` */

DROP TABLE IF EXISTS `v_nationalids`;

CREATE TABLE `v_nationalids` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `National_Id` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `Geted_From` varchar(255) NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=955 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_notification` */

DROP TABLE IF EXISTS `v_notification`;

CREATE TABLE `v_notification` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `For_User` int(11) NOT NULL,
  `User_Type` varchar(255) NOT NULL,
  `User_Entred` varchar(255) NOT NULL,
  `Is_read` int(11) NOT NULL DEFAULT 0,
  `Created` datetime NOT NULL,
  `generation` varchar(14) DEFAULT '0',
  `Company_Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_notification_alert_companies` */

DROP TABLE IF EXISTS `v_notification_alert_companies`;

CREATE TABLE `v_notification_alert_companies` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Blood_pressure_min` double NOT NULL DEFAULT 0,
  `Blood_pressure_max` double NOT NULL DEFAULT 0,
  `Blood_oxygen` double NOT NULL DEFAULT 0,
  `Heart_rate` double NOT NULL DEFAULT 0,
  `weight` double NOT NULL DEFAULT 0,
  `Glucose` double NOT NULL DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'work',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Message_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_notification_alert_schools` */

DROP TABLE IF EXISTS `v_notification_alert_schools`;

CREATE TABLE `v_notification_alert_schools` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Blood_pressure_min` double NOT NULL DEFAULT 0,
  `Blood_pressure_max` double NOT NULL DEFAULT 0,
  `Blood_oxygen` double NOT NULL DEFAULT 0,
  `Heart_rate` double NOT NULL DEFAULT 0,
  `weight` double NOT NULL DEFAULT 0,
  `Glucose` double NOT NULL DEFAULT 0,
  `Symptoms` varchar(255) NOT NULL,
  `Device_Test` varchar(255) NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Device` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `generation` varchar(14) NOT NULL DEFAULT '0',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Message_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_notification_alert_visitors` */

DROP TABLE IF EXISTS `v_notification_alert_visitors`;

CREATE TABLE `v_notification_alert_visitors` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Symptoms` varchar(255) DEFAULT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL DEFAULT 'Visitor',
  `Device` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Message_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_notification_for_mobile_app` */

DROP TABLE IF EXISTS `v_notification_for_mobile_app`;

CREATE TABLE `v_notification_for_mobile_app` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserId` int(11) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `DeviceType` varchar(255) NOT NULL,
  `Added_By` varchar(255) NOT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Parent_NID_1` varchar(255) DEFAULT NULL,
  `Parent_NID_2` varchar(255) DEFAULT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Late_code` int(11) DEFAULT 0,
  `Action` varchar(255) NOT NULL DEFAULT 'School',
  `Device` varchar(255) NOT NULL DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `Message_AR` varchar(255) NOT NULL,
  `Message_EN` varchar(255) NOT NULL,
  `Message_code` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_notification_refrigerator` */

DROP TABLE IF EXISTS `v_notification_refrigerator`;

CREATE TABLE `v_notification_refrigerator` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Machine_Id` int(11) NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `Added_By` varchar(255) NOT NULL,
  `Result` double NOT NULL,
  `Humidity` double NOT NULL,
  `Created` date NOT NULL,
  `Time` time NOT NULL DEFAULT '00:00:00',
  `Action` varchar(255) NOT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `MAC_Device` varchar(255) DEFAULT 'MAC ADDRESS',
  `battery_life` int(11) NOT NULL DEFAULT 0,
  `generation` varchar(255) DEFAULT '0',
  `Message_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `v_schoolgrades` */

DROP TABLE IF EXISTS `v_schoolgrades`;

CREATE TABLE `v_schoolgrades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `S_id` int(11) NOT NULL,
  `Levels` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `generation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `visitors` */

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Prefix` varchar(255) NOT NULL,
  `Full_name_EN` varchar(255) DEFAULT NULL,
  `Full_name_AR` varchar(255) DEFAULT NULL,
  `F_name_EN` varchar(255) DEFAULT NULL,
  `F_name_AR` varchar(255) DEFAULT NULL,
  `M_name_EN` varchar(255) DEFAULT NULL,
  `M_name_AR` varchar(255) DEFAULT NULL,
  `L_name_EN` varchar(255) DEFAULT NULL,
  `L_name_AR` varchar(255) DEFAULT NULL,
  `DOP` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `National_Id` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Added_By` varchar(255) DEFAULT NULL,
  `Latitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `Longitude` decimal(12,8) NOT NULL DEFAULT 0.00000000,
  `watch_mac` varchar(128) DEFAULT 'Bind Watch',
  `Parent_NID` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `smart_mac` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
