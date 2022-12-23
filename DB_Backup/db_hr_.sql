/*
SQLyog Community v13.1.8 (64 bit)
MySQL - 10.1.38-MariaDB : Database - db_hr
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_iidfc` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_iidfc`;

/*Table structure for table `calendar` */

DROP TABLE IF EXISTS `calendar`;

CREATE TABLE `calendar` (
  `date` date NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `calendar` */

/*Table structure for table `car_cost` */

DROP TABLE IF EXISTS `car_cost`;

CREATE TABLE `car_cost` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `car_id` varchar(100) NOT NULL,
  `Cost_Type` varchar(100) DEFAULT NULL,
  `Cost_Amount` varchar(200) DEFAULT NULL,
  `Cost_Date` varchar(200) DEFAULT NULL,
  `buyer` varchar(200) DEFAULT NULL,
  `Remarks` text,
  `created_by` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `reserved1` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `car_cost` */

/*Table structure for table `car_documents` */

DROP TABLE IF EXISTS `car_documents`;

CREATE TABLE `car_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` varchar(200) DEFAULT NULL,
  `field_repeat` int(32) NOT NULL DEFAULT '0',
  `field_name` varchar(100) DEFAULT NULL,
  `field_value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `car_documents` */

/*Table structure for table `car_emp_info` */

DROP TABLE IF EXISTS `car_emp_info`;

CREATE TABLE `car_emp_info` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` varchar(100) NOT NULL,
  `emp_office_phone` varchar(200) DEFAULT NULL,
  `emp_phone` varchar(200) DEFAULT NULL,
  `emp_emergency_contact` varchar(200) DEFAULT NULL,
  `emp_driving_license` varchar(200) DEFAULT NULL,
  `License_Expires_Date` varchar(200) DEFAULT NULL,
  `notes` text,
  `driver_status` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `reserved` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `car_emp_info` */

/*Table structure for table `car_info` */

DROP TABLE IF EXISTS `car_info`;

CREATE TABLE `car_info` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `Car_Code` varchar(200) DEFAULT NULL,
  `Vehicle_Name` varchar(300) DEFAULT NULL,
  `Vehicle_Owner` varchar(300) DEFAULT NULL,
  `Vehicle_Model` varchar(300) DEFAULT NULL,
  `Model_Year` varchar(300) DEFAULT NULL,
  `Purchase_Date` varchar(300) DEFAULT NULL,
  `Plate` varchar(300) DEFAULT NULL,
  `Total_Seats` varchar(300) DEFAULT NULL,
  `Make` varchar(300) DEFAULT NULL,
  `Chassis_number` varchar(300) DEFAULT NULL,
  `Engine` varchar(300) DEFAULT NULL,
  `Transmission` varchar(300) DEFAULT NULL,
  `Tire_Size` varchar(300) DEFAULT NULL,
  `Color` varchar(300) DEFAULT NULL,
  `Notes` text,
  `Insurance_Company` varchar(300) DEFAULT NULL,
  `Insurance_Account` varchar(300) DEFAULT NULL,
  `Insurance_Premium` varchar(300) DEFAULT NULL,
  `Insurance_Date` varchar(200) DEFAULT NULL,
  `Insurance_Due` varchar(300) DEFAULT NULL,
  `Route_Permit_Date` varchar(300) DEFAULT NULL,
  `Route_Permit_Cost` varchar(300) DEFAULT NULL,
  `Tax_Token_Date` varchar(300) DEFAULT NULL,
  `Tax_Renewal_Date` varchar(300) DEFAULT NULL,
  `Tax_Cost` varchar(300) DEFAULT NULL,
  `Fitness_Exp` varchar(300) DEFAULT NULL,
  `Fitness_Cost` varchar(300) DEFAULT NULL,
  `Plate_Renewal_Date` varchar(300) DEFAULT NULL,
  `Car_Status` varchar(300) DEFAULT NULL,
  `Car_Status_Date` varchar(200) DEFAULT NULL,
  `default_driver_emp_id` varchar(200) DEFAULT NULL,
  `default_driver_phone` varchar(200) DEFAULT NULL,
  `Created_By` varchar(300) DEFAULT NULL,
  `Created_Time` varchar(200) DEFAULT NULL,
  `Updated_By` varchar(200) DEFAULT NULL,
  `Updated_Time` varchar(200) DEFAULT NULL,
  `Reserved1` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `car_info` */

/*Table structure for table `car_requisition` */

DROP TABLE IF EXISTS `car_requisition`;

CREATE TABLE `car_requisition` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `requester_content_id` varchar(100) NOT NULL,
  `Requisition_Date` varchar(200) DEFAULT NULL,
  `Requisition_Time` varchar(200) DEFAULT NULL,
  `purpose` varchar(200) DEFAULT NULL,
  `Requisition_Location` varchar(200) DEFAULT NULL,
  `Location_Distance` varchar(200) DEFAULT NULL,
  `Car_Code` varchar(200) DEFAULT NULL,
  `driver_content_id` varchar(200) DEFAULT NULL,
  `notes` text,
  `status` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `reserved` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `car_requisition` */

/*Table structure for table `company_info` */

DROP TABLE IF EXISTS `company_info`;

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(40) DEFAULT NULL,
  `comp_addresss` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(40) DEFAULT NULL,
  `email_address` varchar(40) DEFAULT NULL,
  `created` varchar(40) DEFAULT NULL,
  `updated` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `company_info` */

insert  into `company_info`(`id`,`company_name`,`comp_addresss`,`mobile_no`,`email_address`,`created`,`updated`) values 
(1,'IIDFC','','','','2021-12-24','');

/*Table structure for table `emp_attendance` */

DROP TABLE IF EXISTS `emp_attendance`;

CREATE TABLE `emp_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` varchar(100) DEFAULT NULL,
  `login_time` varchar(100) DEFAULT NULL,
  `logout_time` varchar(100) DEFAULT NULL,
  `attendance_date` varchar(100) DEFAULT NULL,
  `total_hours_perday` varchar(100) DEFAULT NULL,
  `entry_type` varchar(100) DEFAULT NULL,
  `presence_status` varchar(200) DEFAULT NULL,
  `remarks` text,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `entry_date` varchar(200) DEFAULT NULL,
  `entry_user` varchar(100) DEFAULT NULL,
  `reserved1` varchar(200) DEFAULT NULL,
  `reserved2` varchar(200) DEFAULT NULL,
  `reserved3` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_content_id` (`content_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_attendance` */

/*Table structure for table `emp_attendance_archive` */

DROP TABLE IF EXISTS `emp_attendance_archive`;

CREATE TABLE `emp_attendance_archive` (
  `id` int(11) DEFAULT NULL,
  `content_id` varchar(300) DEFAULT NULL,
  `login_time` varchar(300) DEFAULT NULL,
  `logout_time` varchar(300) DEFAULT NULL,
  `attendance_date` varchar(300) DEFAULT NULL,
  `total_hours_perday` varchar(300) DEFAULT NULL,
  `entry_type` varchar(300) DEFAULT NULL,
  `presence_status` varchar(600) DEFAULT NULL,
  `remarks` text,
  `updated_time` varchar(600) DEFAULT NULL,
  `updated_by` varchar(600) DEFAULT NULL,
  `entry_date` varchar(600) DEFAULT NULL,
  `entry_user` varchar(300) DEFAULT NULL,
  `reserved1` varchar(600) DEFAULT NULL,
  `reserved2` varchar(600) DEFAULT NULL,
  `reserved3` varchar(600) DEFAULT NULL,
  KEY `content_id` (`content_id`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_attendance_archive` */

/*Table structure for table `emp_details` */

DROP TABLE IF EXISTS `emp_details`;

CREATE TABLE `emp_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` varchar(40) DEFAULT NULL,
  `emp_id` varchar(40) DEFAULT NULL,
  `field_repeat` int(32) NOT NULL DEFAULT '0',
  `field_name` varchar(100) DEFAULT NULL,
  `field_value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=459 DEFAULT CHARSET=utf8;

/*Data for the table `emp_details` */

insert  into `emp_details`(`id`,`content_id`,`emp_id`,`field_repeat`,`field_name`,`field_value`) values 
(1,'1','000000085',0,'emp_company','11'),
(2,'1','000000085',0,'emp_nationality','BD'),
(3,'1','000000085',0,'emp_fathername','Late Advocate Motiur Rahman'),
(4,'1','000000085',0,'emp_mothername','Mrs Rahima Rahman'),
(5,'1','000000085',0,'emp_tin','031734801591'),
(6,'1','000000085',0,'emp_parmanent_address','House No-09,Road No-1,Block -B,Section - 6,Mirpur,Dhaka.'),
(7,'1','000000085',0,'emp_parmanent_city','7'),
(8,'1','000000085',0,'emp_parmanent_distict','235'),
(9,'1','000000085',0,'emp_present_address','3/502 Eastern Peach,30 Shantinagar,Dhaka-1217'),
(10,'1','000000085',0,'emp_present_city','209'),
(11,'1','000000085',0,'emp_qualification','170'),
(12,'1','000000085',0,'resources/uploads','1644316542_Madam_Picture.jpg'),
(13,'1','000000085',0,'emp_blood_group','192'),
(14,'2','000000219',0,'resources/uploads','1644489705_Picture_of_maruf-2021.JPG'),
(15,'2','000000219',0,'emp_company','11'),
(16,'2','000000219',0,'emp_nationality','BD'),
(17,'2','000000219',0,'emp_fathername','Late Md. Golam Mostofa Khan'),
(18,'2','000000219',0,'emp_mothername','Momotaj Begum'),
(19,'2','000000219',0,'husband_wife_name','MRS. FARHANA HOQUE'),
(20,'2','000000219',0,'emp_blood_group','188'),
(21,'2','000000219',0,'emp_tin','868725536102'),
(22,'2','000000219',0,'emp_parmanent_address','Vill+Post: Shahapur, Thana-Dumuria, Dist-Khulna'),
(23,'2','000000219',0,'emp_parmanent_city','211'),
(24,'2','000000219',0,'emp_parmanent_distict','256'),
(25,'2','000000219',0,'emp_present_address','R#06, H#20, Nobouday Housing,Mohammadpur,Dhaka-1207'),
(26,'2','000000219',0,'emp_present_city','7'),
(27,'2','000000219',0,'emp_emergency_contact','01717583393'),
(28,'2','000000219',0,'emp_email','maruf@iidfcsecurities.com'),
(29,'2','000000219',0,'emp_qualification','164'),
(30,'3','0000000309',0,'resources/uploads','1644492101_309.jpg'),
(31,'3','000000309',0,'emp_company','11'),
(32,'3','000000309',0,'emp_nationality','BD'),
(33,'3','000000309',0,'emp_fathername','Md. Mokbul Hossain'),
(34,'3','000000309',0,'emp_mothername','Mrs. Jamila Khathun'),
(35,'3','000000309',0,'emp_blood_group','190'),
(36,'3','000000309',0,'emp_tin','113379904636'),
(37,'3','000000309',0,'emp_parmanent_address','R#7, H#8, F#301, PC Housing Society, Mohammadpur'),
(38,'3','000000309',0,'emp_parmanent_city','7'),
(39,'3','000000309',0,'emp_parmanent_distict','235'),
(40,'3','000000309',0,'emp_present_address','Md. Mokbul Hossain , Agnibina Sarak, Jhenidah,'),
(41,'3','000000309',0,'emp_present_city','209'),
(42,'3','000000309',0,'emp_email','mamun@iidfcsecurities.com'),
(43,'3','000000309',0,'emp_qualification','856'),
(44,'4','000000309',0,'resources/uploads','1644737439_223.jpg'),
(45,'4','000000223',0,'emp_company','11'),
(46,'4','000000223',0,'emp_nationality','BD'),
(47,'4','000000223',0,'emp_fathername','Nur Mohammed Mollah'),
(48,'4','000000223',0,'emp_mothername','Rehana Akhter'),
(49,'4','000000223',0,'husband_wife_name','MRS. HOSSNA ARA'),
(50,'4','000000223',0,'emp_blood_group','192'),
(51,'4','000000223',0,'emp_tin','269928436331'),
(52,'4','000000223',0,'emp_parmanent_address','473 South Goran, Dhaka-1219'),
(53,'4','000000223',0,'emp_parmanent_city','209'),
(54,'4','000000223',0,'emp_parmanent_distict','235'),
(55,'4','000000223',0,'emp_present_address','473 South Goran, Dhaka-1219'),
(56,'4','000000223',0,'emp_present_city','209'),
(57,'4','000000223',0,'emp_emergency_contact','01917652670'),
(58,'4','000000223',0,'emp_email','rakibul@iidfcsecurities.com'),
(59,'4','000000223',0,'emp_qualification','164'),
(60,'5','000000523',0,'resources/uploads','1644750575_Omar_faruq.jpg'),
(61,'5','000000523',0,'emp_company','11'),
(62,'5','000000523',0,'emp_nationality','BD'),
(63,'5','000000523',0,'emp_fathername','Late Abdul Mazid Khan'),
(64,'5','000000523',0,'emp_mothername','Syeda Asma Khan'),
(65,'5','000000523',0,'husband_wife_name','Jamila'),
(66,'5','000000523',0,'emp_blood_group','192'),
(67,'5','000000523',0,'emp_tin','146686433386'),
(68,'5','000000523',0,'emp_parmanent_address','31/1Jha (4th floor), khilgaon punorbashon area, Dhaka-1219'),
(69,'5','000000523',0,'emp_parmanent_city','209'),
(70,'5','000000523',0,'emp_parmanent_distict','235'),
(71,'5','000000523',0,'emp_present_address','Vill+Post+Police station: Enayetpur, District: Sirajginj, Bangladesh'),
(72,'5','000000523',0,'emp_present_city','209'),
(73,'5','000000523',0,'emp_email','faruque@iidfcsecurities.com'),
(74,'5','000000523',0,'emp_qualification','164'),
(75,'6','000000154',0,'resources/uploads','1644817689_093.JPG'),
(76,'6','000000093',0,'emp_company','11'),
(77,'6','000000093',0,'emp_nationality','BD'),
(78,'6','000000093',0,'emp_fathername','Late Syed Murad Ali'),
(79,'6','000000093',0,'emp_mothername','Hamida Begum'),
(80,'6','000000093',0,'husband_wife_name','MRS. AYSHA MUNA'),
(81,'6','000000093',0,'emp_blood_group','188'),
(82,'6','000000093',0,'emp_tin','897829305198'),
(83,'6','000000093',0,'emp_parmanent_address','C.O Md. Alomgir Mia, Vill-Karticpur, PO Kusum Hati, P.S Dohar, Dist- Dhaka'),
(84,'6','000000093',0,'emp_parmanent_city','7'),
(85,'6','000000093',0,'emp_parmanent_distict','235'),
(86,'6','000000093',0,'emp_present_address','24/1 Tejkuni Para, Dhaka-1215'),
(87,'6','000000093',0,'emp_present_city','209'),
(88,'6','000000093',0,'emp_email','haider@iidfcsecurities.com'),
(89,'6','000000093',0,'emp_qualification','181'),
(90,'7','000000154',0,'resources/uploads','1644905820_154.jpg'),
(91,'7','000000154',0,'emp_company','11'),
(92,'7','000000154',0,'emp_nationality','BD'),
(93,'7','000000154',0,'emp_fathername','Mohammad Muslim Uddin'),
(94,'7','000000154',0,'emp_mothername','Delwara Begum'),
(95,'7','000000154',0,'husband_wife_name','MRS. FARHANA AKTER'),
(96,'7','000000154',0,'emp_tin','353674604011'),
(97,'7','000000154',0,'emp_parmanent_address','CS Plot No – 952, East Badda,Post Office Road, Badda'),
(98,'7','000000154',0,'emp_parmanent_city','7'),
(99,'7','000000154',0,'emp_parmanent_distict','235'),
(100,'7','000000154',0,'emp_present_address','CS Plot No – 952, East Badda,Post Office Road, Badda'),
(101,'7','000000154',0,'emp_present_city','209'),
(102,'7','000000154',0,'emp_email','sikder@iidfcsecurities.com'),
(103,'7','000000154',0,'emp_qualification','181'),
(104,'8','000000117',0,'resources/uploads','1644909195_117.jpg'),
(105,'8','000000117',0,'emp_company','11'),
(106,'8','000000117',0,'emp_nationality','BD'),
(107,'8','000000117',0,'emp_fathername','Late Sirajul Islam Khan'),
(108,'8','000000117',0,'emp_mothername','Sajada Begum'),
(109,'8','000000117',0,'husband_wife_name','MS. TASLIMA AKTER'),
(110,'8','000000117',0,'emp_blood_group','192'),
(111,'8','000000117',0,'emp_parmanent_address','63/1, Block-A,Bank Colony,Saver, Dhaka'),
(112,'8','000000117',0,'emp_parmanent_city','7'),
(113,'8','000000117',0,'emp_parmanent_distict','235'),
(114,'8','000000117',0,'emp_present_address','63/1, Block-A,Bank Colony,Saver, Dhaka'),
(115,'8','000000117',0,'emp_present_city','7'),
(116,'8','000000117',0,'emp_email','didarul@iidfcsecurities.com'),
(117,'8','000000117',0,'emp_qualification','184'),
(118,'9','000000149',0,'emp_company','11'),
(119,'9','000000149',0,'emp_nationality','BD'),
(120,'9','000000149',0,'emp_fathername','SK. Nazibul Islam'),
(121,'9','000000149',0,'emp_mothername','Hosne-Ara Begum'),
(122,'9','000000149',0,'husband_wife_name','MRS. FAHMIN SAMRINA'),
(123,'9','000000149',0,'emp_present_city','209'),
(124,'9','000000149',0,'resources/uploads','1644916470_149.jpg'),
(125,'9','000000149',0,'emp_blood_group','6'),
(126,'9','000000149',0,'emp_tin','753378548332'),
(127,'9','000000149',0,'emp_parmanent_address','H#726/14, R#10, Baitul Aman Housing Society, Adabor, Mohammadpur, Dhaka.-1207'),
(128,'9','000000149',0,'emp_parmanent_city','209'),
(129,'9','000000149',0,'emp_parmanent_distict','235'),
(130,'9','000000149',0,'emp_present_address','House # 154, (New # 423), Road # 4,Mohammadi Housing Society,Mohannadpur, Dhaka-1207'),
(131,'9','000000149',0,'emp_email','sabbir@iidfcsecurities.com'),
(132,'9','000000149',0,'emp_qualification','164'),
(133,'10','000000151',0,'resources/uploads','1645008366_151.JPG'),
(134,'10','000000151',0,'emp_company','11'),
(135,'10','000000151',0,'emp_nationality','BD'),
(136,'10','000000151',0,'emp_fathername','Fazlul Kader'),
(137,'10','000000151',0,'emp_mothername','Rasheda Begum'),
(138,'10','000000151',0,'husband_wife_name','Mos.Nasrin Nahar Ronu'),
(139,'10','000000151',0,'emp_blood_group','188'),
(140,'10','000000151',0,'emp_tin','\'454841149773'),
(141,'10','000000151',0,'emp_parmanent_address','H# 16, R#1/2, P# Cadet College, Thana# Sadar Rangpur-5400'),
(142,'10','000000151',0,'emp_parmanent_city','209'),
(143,'10','000000151',0,'emp_parmanent_distict','235'),
(144,'10','000000151',0,'emp_present_address','142/J(3rd floor), South komlapur,Dhaka-1000'),
(145,'10','000000151',0,'emp_present_city','209'),
(146,'10','000000151',0,'emp_email','bashar@iidfcsecurities.com'),
(147,'10','000000151',0,'emp_qualification','163'),
(148,'11','000000161',0,'resources/uploads','1645009699_161.jpg'),
(149,'11','000000161',0,'emp_company','11'),
(150,'11','000000161',0,'emp_nationality','BD'),
(151,'11','000000161',0,'emp_fathername','Md. Mozaharul Islam'),
(152,'11','000000161',0,'emp_mothername','Mst. Johura Begum'),
(153,'11','000000161',0,'husband_wife_name','MRS. JANNATUL FERDOWS'),
(154,'11','000000161',0,'emp_blood_group','6'),
(155,'11','000000161',0,'emp_tin','\'159649577063'),
(156,'11','000000161',0,'emp_parmanent_address','Fullbari Dhakhin Para, Bogura -5800'),
(157,'11','000000161',0,'emp_present_address','House 322,Flat D3,R# Gawair Maddrasa Road,Dhakkinkhan, Dhaka-1230'),
(158,'11','000000161',0,'emp_present_city','209'),
(159,'11','000000161',0,'emp_email','jafor@iidfcsecurities.com'),
(160,'11','000000161',0,'emp_qualification','164'),
(161,'12','000000173',0,'resources/uploads','1645077893_173.JPG'),
(162,'12','000000173',0,'emp_company','11'),
(163,'12','000000173',0,'emp_nationality','BD'),
(164,'12','000000173',0,'emp_fathername','Khabir Uddin Ahmed'),
(165,'12','000000173',0,'emp_mothername','Selima Khanam'),
(166,'12','000000173',0,'husband_wife_name','Md. Saiful Alam'),
(167,'12','000000173',0,'emp_blood_group','188'),
(168,'12','000000173',0,'emp_tin','888256866465'),
(169,'12','000000173',0,'emp_parmanent_address','141 Sadar Road, Natun Bazar, Patuakhhli'),
(170,'12','000000173',0,'emp_parmanent_city','211'),
(171,'12','000000173',0,'emp_parmanent_distict','256'),
(172,'12','000000173',0,'emp_present_address','House No-11-G, Rahman Topical Tower, 51/1,52/5 Purana Paltan line, Dhaka'),
(173,'12','000000173',0,'emp_present_city','209'),
(174,'12','000000173',0,'emp_email','syeda@iidfcsecurities.com'),
(175,'12','000000173',0,'emp_qualification','164'),
(176,'13','000000227',0,'resources/uploads','1645085556_227.jpg'),
(177,'13','000000227',0,'emp_company','11'),
(178,'13','000000227',0,'emp_nationality','BD'),
(179,'13','000000227',0,'emp_fathername','Md. Nazmul Chowdhury'),
(180,'13','000000227',0,'emp_mothername','Shireen Chowdhury'),
(181,'13','000000227',0,'husband_wife_name','Md.Fayzul Haque Miah'),
(182,'13','000000227',0,'emp_blood_group','192'),
(183,'13','000000227',0,'emp_tin','617048630672'),
(184,'13','000000227',0,'emp_parmanent_address','Vill+Post=Monohorkhadi, Thana+ Dist= Chandpur'),
(185,'13','000000227',0,'emp_present_address','30, Shantinagar, Eastern Pace, B-04, F-403, Dhaka'),
(186,'13','000000227',0,'emp_present_city','209'),
(187,'13','000000227',0,'emp_email','lora@iidfcsecurities.com'),
(188,'13','000000227',0,'emp_qualification','3'),
(189,'14','000000225',0,'resources/uploads','1645086461_225.jpg'),
(190,'14','000000225',0,'emp_company','11'),
(191,'14','000000225',0,'emp_nationality','BD'),
(192,'14','000000225',0,'emp_fathername','Md. Abu Taha'),
(193,'14','000000225',0,'emp_mothername','Mrs. Sajeda Begum'),
(194,'14','000000225',0,'husband_wife_name','SUMA AKTER BITHI'),
(195,'14','000000225',0,'emp_tin','123057884917'),
(196,'14','000000225',0,'emp_parmanent_address','Vill- Baridi, PO- Kaya, PS- Kurar Khali, Dist- Kustia'),
(197,'14','000000225',0,'emp_parmanent_city','211'),
(198,'14','000000225',0,'emp_parmanent_distict','256'),
(199,'14','000000225',0,'emp_present_address','C/O Md. Tafael Hossain,House# 17(1st Floor),Sha Mokdum Avenue,Uttara-14,Dhaka-1230'),
(200,'14','000000225',0,'emp_present_city','209'),
(201,'14','000000225',0,'emp_email','torequl@iidfcsecurities.com'),
(202,'14','000000225',0,'emp_qualification','184'),
(203,'15','000005009',0,'resources/uploads','1647241020_muna.jpeg'),
(204,'15','000005009',0,'emp_company','11'),
(205,'15','000005009',0,'emp_nationality','BD'),
(206,'15','000005009',0,'emp_fathername','Md.Abul Hossain'),
(207,'15','000005009',0,'emp_mothername','Mrs Monohara Hossain'),
(208,'15','000005009',0,'emp_tin','146686433386'),
(209,'15','000005009',0,'emp_parmanent_address','House No=383,Road No = 3.Sonadanga R/A Khulna.'),
(210,'15','000005009',0,'emp_parmanent_city','211'),
(211,'15','000005009',0,'emp_present_address','Road-10,House = 173,Baridhara DOHS,Khulna.'),
(212,'15','000005009',0,'emp_present_city','209'),
(213,'15','000005009',0,'emp_qualification','177'),
(214,'16','000000103',0,'resources/uploads','1646044418_Nusrat.jpg'),
(215,'16','000000103',0,'emp_company','11'),
(216,'16','000000103',0,'emp_nationality','BD'),
(217,'16','000000103',0,'emp_fathername','M A Rahim Chowdhury'),
(218,'16','000000103',0,'emp_mothername','Delangig Begum'),
(219,'16','000000103',0,'emp_blood_group','192'),
(220,'16','000000103',0,'emp_tin','635991429639'),
(221,'16','000000103',0,'emp_parmanent_address','283, Elephant Road (1st Floor),Dhaka-1205'),
(222,'16','000000103',0,'emp_present_address','283, Elephant Road (1st Floor),Dhaka-1205'),
(223,'16','000000103',0,'emp_present_city','209'),
(224,'16','000000103',0,'emp_email','nusrat@iidfcsecurities.com'),
(225,'16','000000103',0,'emp_qualification','164'),
(226,'17','000005005',0,'emp_company','11'),
(227,'17','000005005',0,'emp_nationality','BD'),
(228,'17','000005005',0,'emp_fathername','Md.Wahiduzzaman'),
(229,'17','000005005',0,'emp_mothername','Rahima Wahid'),
(230,'17','000005005',0,'emp_blood_group','192'),
(231,'17','000005005',0,'emp_present_city','209'),
(232,'17','000005005',0,'emp_qualification','164'),
(233,'18','000005008',0,'emp_company','11'),
(234,'18','000005008',0,'emp_nationality','BD'),
(235,'18','000005008',0,'emp_fathername','Md.Halim Mostab'),
(236,'18','000005008',0,'emp_mothername','Rousonara Begum'),
(237,'18','000005008',0,'emp_blood_group','188'),
(238,'18','000005008',0,'emp_tin','333767238953'),
(239,'18','000005008',0,'emp_parmanent_address','Village : Borai,Post Office : Bodorganj Bazar,Police Station: Jhenaidah Sader,Jhenaidah'),
(240,'18','000005008',0,'emp_parmanent_city','211'),
(241,'18','000005008',0,'emp_parmanent_distict','255'),
(242,'18','000005008',0,'emp_present_address','Road # 01,House # 04,Floor 5th,Kaderabadh Housing Mahammadpur.'),
(243,'18','000005008',0,'emp_present_city','209'),
(244,'18','000005008',0,'emp_email','roshid@iidfcsecurities.com'),
(245,'18','000005008',0,'emp_qualification','169'),
(246,'18','000005008',0,'resources/uploads','1646637153_Mamun_PP.JPG'),
(247,'19','000000105',0,'resources/uploads','1646642106_105.jpg'),
(248,'19','000000105',0,'emp_company','11'),
(249,'19','000000105',0,'emp_nationality','BD'),
(250,'19','000000105',0,'emp_fathername','Md. Amzad Hosen'),
(251,'19','000000105',0,'emp_mothername','Dil Afroza Begum'),
(252,'19','000000105',0,'husband_wife_name','MD. BELAYET HOSSAIN'),
(253,'19','000000105',0,'emp_blood_group','192'),
(254,'19','000000105',0,'emp_parmanent_address','H#319, Lane-05,Word-05,Dcag-541, Faidabad,D.Khan,Uttara-1230'),
(255,'19','000000105',0,'emp_present_address','H#319, Lane-05,Word-05,Dcag-541, Faidabad,D.Khan,Uttara-1230'),
(256,'19','000000105',0,'emp_present_city','209'),
(257,'19','000000105',0,'emp_emergency_contact','rubina@iidfcsecurities.com'),
(258,'19','000000105',0,'emp_email','rubina@iidfcsecurities.com'),
(259,'19','000000105',0,'emp_qualification','167'),
(260,'20','000000104',0,'resources/uploads','1646643124_104.JPG'),
(261,'20','000000104',0,'emp_company','11'),
(262,'20','000000104',0,'emp_nationality','BD'),
(263,'20','000000104',0,'emp_fathername','Md. Shohrab Mollah'),
(264,'20','000000104',0,'emp_mothername','Fulmala Begum'),
(265,'20','000000104',0,'husband_wife_name','MRS. KHADIZA BEGUM'),
(266,'20','000000104',0,'emp_blood_group','192'),
(267,'20','000000104',0,'emp_parmanent_address','Vill- Moradpur, Post-Omberpur, PS- Chandina, Dist- Comilla'),
(268,'20','000000104',0,'emp_present_address','Al-madina Tower, Apt no-2/A, House-12, Road-14, Block-B, Mirpur-10, Dhaka-1216'),
(269,'20','000000104',0,'emp_present_city','209'),
(270,'20','000000104',0,'emp_email','korban@iidfcsecurities.com'),
(271,'21','000005007',0,'resources/uploads','1646649883_986_Mitun-+_(2).jpg'),
(272,'21','000005007',0,'emp_company','11'),
(273,'21','000005007',0,'emp_nationality','BD'),
(274,'21','000005007',0,'emp_fathername','Asit Chandra Sikder'),
(275,'21','000005007',0,'emp_mothername','Eti Rani Sikder'),
(276,'21','000005007',0,'husband_wife_name','Bithi Mondal'),
(277,'21','000005007',0,'emp_tin','452494625756'),
(278,'21','000005007',0,'emp_parmanent_address','Village : Baminikathi,P.O-Kamarkhali,P,S-Bakergonj,District : Barisal'),
(279,'21','000005007',0,'emp_parmanent_city','214'),
(280,'21','000005007',0,'emp_present_address','C/O: Asit Chandra Sikder,11,Madhan Saha Lane(8th floor,Flat 8A)Sutrapur,Dhaka.'),
(281,'21','000005007',0,'emp_present_city','209'),
(282,'21','000005007',0,'emp_qualification',''),
(283,'22','000000137',0,'resources/uploads','1646651217_137.jpg'),
(284,'22','000000137',0,'emp_company','11'),
(285,'22','000000137',0,'emp_nationality','BD'),
(286,'22','000000137',0,'emp_fathername','Vart Chandra Das'),
(287,'22','000000137',0,'emp_mothername','Anita Das'),
(288,'22','000000137',0,'husband_wife_name','MRS. TUMPA DAS'),
(289,'22','000000137',0,'emp_blood_group','192'),
(290,'22','000000137',0,'emp_parmanent_address','Ruhul Amin’s Buildings, 2nd Floor,115, Sadarghat Road,Chittagong'),
(291,'22','000000137',0,'emp_parmanent_city','210'),
(292,'22','000000137',0,'emp_present_address','Vill- Dharmapur, Daskin Para, PS- Satkania, Dist- Chittagong'),
(293,'22','000000137',0,'emp_present_city','209'),
(294,'22','000000137',0,'emp_email','suman@iidfcsecurities.com'),
(295,'22','000000137',0,'emp_qualification','164'),
(296,'23','000000189',0,'resources/uploads','1646652248_189.jpg'),
(297,'23','000000189',0,'emp_company','11'),
(298,'23','000000189',0,'emp_nationality','BD'),
(299,'23','000000189',0,'emp_fathername','Md. Golam Kibria'),
(300,'23','000000189',0,'emp_mothername','Mrs. Kulsuma Akhter'),
(301,'23','000000189',0,'emp_blood_group','6'),
(302,'23','000000189',0,'emp_tin','\'168347863451'),
(303,'23','000000189',0,'emp_parmanent_address','Sultan Hajir Building, House No:935, North Muhuripara,Agrabad, Chittagong'),
(304,'23','000000189',0,'emp_parmanent_city','210'),
(305,'23','000000189',0,'emp_present_address','Vill- Fathapur, PO-Babubpur, PS- Sonagazi, Dist- Feni'),
(306,'23','000000189',0,'emp_present_city','209'),
(307,'23','000000189',0,'emp_qualification','164'),
(308,'24','000000228',0,'resources/uploads','1646715168_228.jpg'),
(309,'24','000000228',0,'emp_company','11'),
(310,'24','000000228',0,'emp_nationality','BD'),
(311,'24','000000228',0,'emp_fathername','Shum Uddin'),
(312,'24','000000228',0,'emp_mothername','Shirin Akhter'),
(313,'24','000000228',0,'husband_wife_name','Lubyna Tahiat'),
(314,'24','000000228',0,'emp_parmanent_address','Eid-gha Bow Bazar Amtol, Holding -1127,Chittagong'),
(315,'24','000000228',0,'emp_present_address','Eid-gha Bow Bazar Amtol, Holding -1127,Chittagong'),
(316,'24','000000228',0,'emp_present_city','209'),
(317,'24','000000228',0,'emp_email','nizam@iidfcsecurities.com'),
(318,'24','000000228',0,'emp_qualification','165'),
(319,'25','00005014',0,'emp_company','11'),
(320,'25','00005014',0,'emp_nationality','BD'),
(321,'25','00005014',0,'emp_fathername','Mr.Subash Chandra Das'),
(322,'25','00005014',0,'emp_parmanent_address','Mr. Satya Priya Barua (Satyajit)	\r\n8/B Colony, 12- Hemsen Lane, \r\nJamal Khan, \r\nChittagong'),
(323,'25','00005014',0,'emp_present_address','Mr. Satya Priya Barua (Satyajit)	\r\n8/B Colony, 12- Hemsen Lane, \r\nJamal Khan, \r\nChittagong'),
(324,'25','00005014',0,'emp_present_city','209'),
(325,'25','00005014',0,'emp_qualification','184'),
(326,'25','00005014',0,'resources/uploads','1646725509_Satyajit_PP.JPG'),
(327,'25','00005014',0,'emp_tin','830781575576'),
(328,'26','000000171',0,'emp_company','11'),
(329,'26','000000171',0,'emp_nationality','BD'),
(330,'26','000000171',0,'emp_fathername','Late Md. Akbar Ali'),
(331,'26','000000171',0,'emp_mothername','Late Most. Bulbuli Begum'),
(332,'26','000000171',0,'husband_wife_name','Arzina Begum'),
(333,'26','000000171',0,'emp_blood_group','192'),
(334,'26','000000171',0,'emp_parmanent_address','Vill- Hazradanga Post- Sundardhahi, PS- Debigong, Dist- Panchagarh'),
(335,'26','000000171',0,'emp_present_address','House# 56,Road#06,DIT Project,Badda Dhaka-1212'),
(336,'26','000000171',0,'emp_present_city','209'),
(337,'26','000000171',0,'emp_email','joynal@iidfcsecurities.com'),
(338,'26','000000171',0,'emp_qualification','170'),
(339,'26','000000171',0,'resources/uploads','1646736864_Abedin_(2).jpg'),
(340,'27','000000158',0,'resources/uploads','1647151156_asma_Nazim.JPG'),
(341,'27','000000158',0,'emp_company','11'),
(342,'27','000000158',0,'emp_nationality','BD'),
(343,'27','000000158',0,'emp_fathername','Late Salemuddin'),
(344,'27','000000158',0,'emp_mothername','Mrs. Ashrafun Nessa'),
(345,'27','000000158',0,'husband_wife_name','MR. MD. KHALILUR RAHMAN'),
(346,'27','000000158',0,'emp_blood_group','192'),
(347,'27','000000158',0,'emp_parmanent_address','Sopnil,4thFloor,House#06,Road#09,Lane#3,Block#A,Section-11,Mirpur, Dhaka'),
(348,'27','000000158',0,'emp_parmanent_city','209'),
(349,'27','000000158',0,'emp_present_address','Vill- Dogar Bari, PO- Tirnaihat, PS -Tetulia, Dsit- Panchagarg'),
(350,'27','000000158',0,'emp_present_city','209'),
(351,'27','000000158',0,'emp_email','masma@iidfcsecurities.com'),
(352,'27','000000158',0,'emp_qualification','177'),
(353,'28','000000540',0,'emp_company','11'),
(354,'28','000000540',0,'emp_nationality','BD'),
(355,'28','000000540',0,'emp_fathername','Md.Siddiqur Rahman'),
(356,'28','000000540',0,'emp_mothername','Mrs.Latufia Begum'),
(357,'28','000000540',0,'emp_blood_group','192'),
(358,'28','000000540',0,'emp_tin','\'375223290316'),
(359,'28','000000540',0,'emp_parmanent_address','Village : Koundopur,P.O:Aliara Bazer,P.S : Kachua,District : Chandpur.'),
(360,'28','000000540',0,'emp_present_address','195,SenparaPorbota(Ground Floor)Mirpur-10 Dhaka.'),
(361,'28','000000540',0,'emp_present_city','209'),
(362,'28','000000540',0,'emp_qualification','164'),
(363,'29','000005012',0,'resources/uploads','1647150902_img301.pdf'),
(364,'29','000005012',0,'emp_company','11'),
(365,'29','000005012',0,'emp_nationality','BD'),
(366,'29','000005012',0,'emp_fathername','Mohammed Ishaque'),
(367,'29','000005012',0,'emp_mothername','Nasima Akter'),
(368,'29','000005012',0,'emp_parmanent_address','Village : South Shaldhar,P,O : Shaldhar bazar,P.S ; Parashuram,District: Feni.'),
(369,'29','000005012',0,'emp_parmanent_city','7'),
(370,'29','000005012',0,'emp_present_address','House : 17, Oasis,(B-7),Sabdhar Hossain Sharak priyanka Runway city,Bawnia Road,Turag(Uttara),Dhaka-1230.'),
(371,'29','000005012',0,'emp_present_city','209'),
(372,'29','000005012',0,'emp_qualification','164'),
(373,'30','00005015',0,'resources/uploads','1647152906_Gorub_Barua.jpg'),
(374,'30','00005015',0,'emp_company','11'),
(375,'30','00005015',0,'emp_nationality','BD'),
(376,'30','00005015',0,'emp_fathername','Amit Bijoy Barua'),
(377,'30','00005015',0,'emp_mothername','Joyanti Barua'),
(378,'30','00005015',0,'emp_blood_group','188'),
(379,'30','00005015',0,'emp_parmanent_address','Lumbini (3rd Floor)\r\n72, S.S Khaled Road\r\nDampara, Kotowali -400\r\nChittagong'),
(380,'30','00005015',0,'emp_parmanent_city','210'),
(381,'30','00005015',0,'emp_present_address','Lumbini (3rd Floor)\r\n72, S.S Khaled Road\r\nDampara, Kotowali -400\r\nChittagong'),
(382,'30','00005015',0,'emp_present_city','209'),
(383,'30','00005015',0,'emp_qualification','163'),
(384,'31','000005010',0,'resources/uploads','1647164406_Farjana_Hossain_Chowdhury.jpeg'),
(385,'31','000005010',0,'emp_company','11'),
(386,'31','000005010',0,'emp_nationality','BD'),
(387,'31','000005010',0,'emp_fathername','Al-Hajj  Manwar hossain Chowdhury'),
(388,'31','000005010',0,'emp_mothername','Nazme Ara Setara'),
(389,'31','000005010',0,'emp_blood_group','6'),
(390,'31','000005010',0,'emp_parmanent_address','94/4, Wasa road, East basaboo, \r\nbasabo TSO Sabujbag\r\nDhaka-1214'),
(391,'31','000005010',0,'emp_parmanent_city','209'),
(392,'31','000005010',0,'emp_present_address','94/4, Wasa road, East basaboo, \r\nbasabo TSO Sabujbag\r\nDhaka-12140'),
(393,'31','000005010',0,'emp_present_city','209'),
(394,'31','000005010',0,'emp_email','farjanana.h.chowdhury@gmail.com'),
(395,'31','000005010',0,'emp_qualification','165'),
(396,'32','000000384',0,'resources/uploads','1647167474_317.JPG'),
(397,'32','000000384',0,'emp_company','11'),
(398,'32','000000384',0,'emp_nationality','BD'),
(399,'32','000000384',0,'emp_fathername','Late S.M. Hasanul Banna'),
(400,'32','000000384',0,'emp_mothername','Rokeya'),
(401,'32','000000384',0,'husband_wife_name','Abdul Malak'),
(402,'32','000000384',0,'emp_blood_group','6'),
(403,'32','000000384',0,'emp_parmanent_address','Vill:Horora, PO: Ochintapur, PS; Sailkupa, Dist: Jhenidha'),
(404,'32','000000384',0,'emp_parmanent_distict','255'),
(405,'32','000000384',0,'emp_present_address','1/1/3 (3rd Floor) Tolar Bag Mirpur 1, Dhaka-1210'),
(406,'32','000000384',0,'emp_present_city','209'),
(407,'32','000000384',0,'emp_email','ayesha@iidfcsecurities.com'),
(408,'32','000000384',0,'emp_qualification','164'),
(409,'33','EMP000005011',0,'resources/uploads','1647170534_MD_Selim_Mia.jpg'),
(410,'33','EMP000005011',0,'emp_company','11'),
(411,'33','EMP000005011',0,'emp_nationality','BD'),
(412,'33','EMP000005011',0,'emp_fathername','Md.Alauddin'),
(413,'33','EMP000005011',0,'emp_mothername','Afia Khatun'),
(414,'33','EMP000005011',0,'emp_blood_group','188'),
(415,'33','EMP000005011',0,'emp_tin','226376847109'),
(416,'33','EMP000005011',0,'emp_parmanent_address','Village : Madhabdi,P.O-Madhabdi,P.S-Madhabdi,District : Narsingdi.'),
(417,'33','EMP000005011',0,'emp_parmanent_city','209'),
(418,'33','EMP000005011',0,'emp_present_address','Village : Madhabdi,P.O-Madhabdi,P.S-Madhabdi,District : Narsingdi.'),
(419,'33','EMP000005011',0,'emp_present_city','209'),
(420,'33','EMP000005011',0,'emp_email','selim@iidfcsecurities.com'),
(421,'33','EMP000005011',0,'emp_qualification','164'),
(422,'30','00005015',0,'emp_tin','861396917027'),
(423,'34','000005023',0,'emp_company','11'),
(424,'34','000005023',0,'emp_nationality','BD'),
(425,'34','000005023',0,'emp_fathername','Md.Abdul Quyum'),
(426,'34','000005023',0,'emp_mothername','Nasima Akter'),
(427,'34','000005023',0,'emp_parmanent_address','Address: 104 Dewan Manjil\r\nPilkhana,North Masdair\r\nNarayangonj Sadar\r\nNarayangonj.'),
(428,'34','000005023',0,'emp_parmanent_city','217'),
(429,'34','000005023',0,'emp_present_address','Address: 104 Dewan Manjil\r\nPilkhana,North Masdair\r\nNarayangonj Sadar\r\nNarayangonj.'),
(430,'34','000005023',0,'emp_present_city','209'),
(431,'34','000005023',0,'emp_email','rasheduzzaman@iidfcsecurities.com'),
(432,'34','000005023',0,'emp_qualification','860'),
(433,'15','000005009',0,'emp_email','muna@iidfcsecurities.com'),
(434,'28','000000540',0,'resources/uploads','1647244268_MD_Abul_Kalam_Azad.jpg'),
(435,'22','000000137',0,'emp_tin',''),
(436,'35','000005016',0,'resources/uploads','1647251105_57007.jpg'),
(437,'35','000005016',0,'emp_company','11'),
(438,'35','000005016',0,'emp_nationality','BD'),
(439,'35','000005016',0,'emp_fathername','Mohammerd Nurul Absar'),
(440,'35','000005016',0,'emp_mothername','Hasina Akter'),
(441,'35','000005016',0,'emp_parmanent_address','C/O – Md. Nurul Absar, House # 196\r\nBlock – C, Bishawbank Clone\r\nP.O – Firoj Shah,P.S –Akbarshah\r\nColonel Hat,Chittgong,Sabdhar Hossain Sharak\r\nPriyanka Runway City\r\nBawnia Road, Turag (Uttara), Dhaka'),
(442,'35','000005016',0,'emp_parmanent_city','210'),
(443,'35','000005016',0,'emp_present_address','C/O – Md. Nurul Absar, House # 196\r\nBlock – C, Bishawbank Clone\r\nP.O – Firoj Shah,P.S –Akbarshah\r\nColonel Hat,Chittgong,Sabdhar Hossain Sharak\r\nPriyanka Runway City\r\nBawnia Road, Turag (Uttara), Dhaka'),
(444,'35','000005016',0,'emp_present_city','209'),
(445,'35','000005016',0,'emp_email','shakil@iidfcsecurities.com'),
(446,'35','000005016',0,'emp_qualification','164'),
(447,'35','000005016',0,'emp_blood_group','193'),
(448,'36','000005013',0,'emp_company','11'),
(449,'36','000005013',0,'emp_nationality','BD'),
(450,'36','000005013',0,'emp_fathername','Md.Nuruzzaman Khan'),
(451,'36','000005013',0,'emp_mothername','Zahura Begum'),
(452,'36','000005013',0,'emp_tin','317900242364'),
(453,'36','000005013',0,'emp_parmanent_address','Block - D, Road - 1/B, Lane - 6/7\r\nHouse No - 02, Sector: 12\r\nPallabi, Dhaka – 1216'),
(454,'36','000005013',0,'emp_parmanent_distict','235'),
(455,'36','000005013',0,'emp_present_address','Block - D, Road - 1/B, Lane - 6/7\r\nHouse No - 02, Sector: 12\r\nPallabi, Dhaka – 1216'),
(456,'36','000005013',0,'emp_present_city','209'),
(457,'36','000005013',0,'emp_email','zahiru@iidfcsecurities.com'),
(458,'36','000005013',0,'emp_qualification','171');

/*Table structure for table `emp_informed` */

DROP TABLE IF EXISTS `emp_informed`;

CREATE TABLE `emp_informed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `attendance_date` varchar(200) DEFAULT NULL,
  `movement_date` date DEFAULT NULL COMMENT 'For filter Query, Add this field',
  `presence_status` varchar(200) DEFAULT NULL,
  `logout_status` varchar(20) NOT NULL,
  `reason` varchar(30) NOT NULL,
  `remarks` text,
  `work_location` varchar(200) DEFAULT NULL,
  `contact_number` varchar(100) DEFAULT NULL,
  `informed_earlier` varchar(10) DEFAULT NULL,
  `type_of_movement` varchar(100) DEFAULT NULL,
  `out_time` varchar(10) DEFAULT NULL,
  `expected_in_time` varchar(10) DEFAULT NULL,
  `location_from` varchar(50) DEFAULT NULL,
  `location_to` varchar(50) DEFAULT NULL,
  `possibility_of_return` varchar(10) DEFAULT NULL,
  `first_approval` tinyint(2) DEFAULT '0' COMMENT '0=pending,1=approved,-1=not approved',
  `hr_approval` tinyint(2) DEFAULT '0' COMMENT '0=pending,1=approved,-1=not approved',
  `second_approval` tinyint(2) DEFAULT '0',
  `status_comments` varchar(200) DEFAULT NULL,
  `entry_date` varchar(200) DEFAULT NULL,
  `entry_user` varchar(100) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(200) DEFAULT NULL,
  `reserved2` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_informed` */

/*Table structure for table `emp_informed_cpy_b4_movement_date` */

DROP TABLE IF EXISTS `emp_informed_cpy_b4_movement_date`;

CREATE TABLE `emp_informed_cpy_b4_movement_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `attendance_date` varchar(200) DEFAULT NULL,
  `presence_status` varchar(200) DEFAULT NULL,
  `logout_status` varchar(20) NOT NULL,
  `reason` varchar(30) NOT NULL,
  `remarks` text,
  `work_location` varchar(200) DEFAULT NULL,
  `contact_number` varchar(100) DEFAULT NULL,
  `informed_earlier` varchar(10) DEFAULT NULL,
  `type_of_movement` varchar(100) DEFAULT NULL,
  `out_time` varchar(10) DEFAULT NULL,
  `expected_in_time` varchar(10) DEFAULT NULL,
  `location_from` varchar(50) DEFAULT NULL,
  `location_to` varchar(50) DEFAULT NULL,
  `possibility_of_return` varchar(10) DEFAULT NULL,
  `first_approval` tinyint(2) DEFAULT '0' COMMENT '0=pending,1=approved,-1=not approved',
  `hr_approval` tinyint(2) DEFAULT '0' COMMENT '0=pending,1=approved,-1=not approved',
  `second_approval` tinyint(2) DEFAULT '0',
  `status_comments` varchar(200) DEFAULT NULL,
  `entry_date` varchar(200) DEFAULT NULL,
  `entry_user` varchar(100) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(200) DEFAULT NULL,
  `reserved2` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_informed_cpy_b4_movement_date` */

/*Table structure for table `emp_job_history` */

DROP TABLE IF EXISTS `emp_job_history`;

CREATE TABLE `emp_job_history` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `start_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL,
  `division_tid` varchar(200) DEFAULT NULL COMMENT 'emp company id',
  `department_tid` varchar(200) DEFAULT NULL COMMENT 'emp division id',
  `department_id` int(5) DEFAULT NULL COMMENT 'emp department id',
  `post_tid` varchar(200) DEFAULT NULL COMMENT 'emp designation id',
  `grade_tid` varchar(200) DEFAULT NULL COMMENT 'emp grade id',
  `emp_type_tid` varchar(200) DEFAULT NULL COMMENT '1=Permanent,153=Left,154=on vacation,155=Provisional Period,473=Terminated',
  `created_time` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(20) DEFAULT NULL,
  `reserved2` varchar(20) DEFAULT NULL,
  `end_type_id` int(20) DEFAULT NULL,
  `reason` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

/*Data for the table `emp_job_history` */

insert  into `emp_job_history`(`id`,`content_id`,`start_date`,`end_date`,`division_tid`,`department_tid`,`department_id`,`post_tid`,`grade_tid`,`emp_type_tid`,`created_time`,`created_by`,`updated_time`,`updated_by`,`reserved1`,`reserved2`,`end_type_id`,`reason`) values 
(1,1,'17-12-2008','31-01-2022','11','823',827,'94','305','1','01-01-2022 14:39:56','1','28-02-2022 11:18:15','1','','',NULL,NULL),
(2,2,'27-09-2010','01-02-2022','11','823',848,'98','305','1','10-02-2022 16:41:45','1','28-02-2022 15:12:32','1','','',NULL,NULL),
(3,3,'02-07-2014','31-01-2022','11','823',664,'78','305','1','10-02-2022 17:21:41','1','28-02-2022 15:48:36','1','','',NULL,NULL),
(4,4,'06-10-2010','01-02-2022','11','823',853,'36','305','1','13-02-2022 13:30:40','1','28-02-2022 15:40:11','1','','',NULL,NULL),
(5,5,'11-07-2009','13-03-2022','11','823',847,'78','305','1','13-02-2022 17:09:35','1','14-03-2022 13:59:49','1','','',NULL,NULL),
(6,6,'01-03-2009','13-03-2022','11','823',847,'98','305','1','14-02-2022 11:48:10','1','14-03-2022 13:09:39','1','','',NULL,NULL),
(7,7,'29-04-2010','31-01-2022','11','823',847,'835','305','1','15-02-2022 12:17:01','1','28-02-2022 11:26:01','1','','',NULL,NULL),
(8,8,'02-06-2010','31-01-2022','11','823',847,'856','306','1','15-02-2022 13:13:15','1','28-02-2022 11:21:14','1','','',NULL,NULL),
(9,9,'09-02-2019','31-01-2022','11','823',852,'36','305','1','15-02-2022 14:51:42','1','28-02-2022 11:22:17','1','','',NULL,NULL),
(10,10,'01-03-2010','31-08-2021','11','823',851,'835','305','1','16-02-2022 16:46:06','1','14-03-2022 13:02:30','1','','',NULL,NULL),
(11,11,'13-05-2010','31-03-2021','11','823',847,'835','305','1','16-02-2022 17:08:19','1','14-03-2022 13:05:39','1','','',NULL,NULL),
(12,12,'25-05-2010','31-01-2022','11','823',849,'836','305','1','17-02-2022 12:04:53','1','28-02-2022 15:03:20','1','','',NULL,NULL),
(13,13,'24-08-2010','31-01-2022','11','823',848,'839','306','1','17-02-2022 14:12:36','1','28-02-2022 15:38:11','1','','',NULL,NULL),
(14,14,'13-10-2010','31-01-2022','11','823',847,'836','305','1','17-02-2022 14:27:42','1','28-02-2022 15:13:31','1','','',NULL,NULL),
(15,1,'01-02-2022','13-03-2022','11','823',845,'830','305','1','28-02-2022 11:18:15','1','14-03-2022 13:08:15','1','','',NULL,NULL),
(16,8,'01-02-2022','13-03-2022','11','823',847,'98','306','1','28-02-2022 11:21:14','1','14-03-2022 13:13:41','1','','',NULL,NULL),
(17,9,'01-02-2022','13-03-2022','11','823',852,'98','305','1','28-02-2022 11:22:17','1','14-03-2022 13:14:59','1','','',NULL,NULL),
(18,7,'01-02-2022','13-03-2022','11','823',847,'98','305','1','28-02-2022 11:26:01','1','14-03-2022 13:15:44','1','','',NULL,NULL),
(19,12,'01-02-2022','13-03-2022','11','823',849,'835','305','1','28-02-2022 15:03:20','1','14-03-2022 13:17:00','1','','',NULL,NULL),
(20,2,'02-02-2022','13-03-2022','11','823',848,'858','305','1','28-02-2022 15:12:32','1','14-03-2022 13:17:56','1','','',NULL,NULL),
(21,14,'01-02-2022','13-03-2022','11','823',847,'835','305','1','28-02-2022 15:13:31','1','14-03-2022 13:20:19','1','','',NULL,NULL),
(22,13,'01-02-2022','13-03-2022','11','823',848,'835','306','1','28-02-2022 15:38:11','1','14-03-2022 13:32:27','1','','',NULL,NULL),
(23,4,'02-02-2022','13-03-2022','11','823',853,'78','305','1','28-02-2022 15:40:11','1','14-03-2022 13:19:09','1','','',NULL,NULL),
(24,3,'01-02-2022','13-03-2022','11','823',664,'858','305','1','28-02-2022 15:48:36','1','14-03-2022 13:36:27','1','','',NULL,NULL),
(25,15,'07-11-2021','07-05-2022','11','823',853,'835','305','1','28-02-2022 16:20:14','1','14-03-2022 12:57:00','1','','',NULL,NULL),
(26,16,'03-05-2009','13-03-2022','11','823',849,'857','305','1','28-02-2022 16:33:38','1','14-03-2022 13:11:37','1','','',NULL,NULL),
(27,17,'16-09-2020','13-03-2022','11','823',847,'839','309','1','28-02-2022 16:57:18','1','14-03-2022 14:06:01','1','','',NULL,NULL),
(28,18,'02-11-2021','13-03-2022','11','823',851,'857','306','1','07-03-2022 13:10:57','1','14-03-2022 14:10:56','1','','',NULL,NULL),
(29,19,'14-05-2009','13-03-2022','11','825',668,'55','307','1','07-03-2022 14:35:06','1','14-03-2022 14:32:02','1','','',NULL,NULL),
(30,20,'03-05-2009','13-03-2022','11','823',853,'557','309','1','07-03-2022 14:52:04','1','14-03-2022 13:12:51','1','','',NULL,NULL),
(31,21,'18-07-2021','13-03-2022','11','823',848,'857','305','1','07-03-2022 16:44:43','1','14-03-2022 14:08:30','1','','',NULL,NULL),
(32,22,'01-12-2009','13-03-2022','11','824',847,'98','305','1','07-03-2022 17:06:57','1','14-03-2022 14:42:52','1','','',NULL,NULL),
(33,23,'30-06-2010','13-03-2022','11','824',847,'98','305','1','07-03-2022 17:24:08','1','14-03-2022 15:13:31','1','','',NULL,NULL),
(34,24,'30-06-2010','13-03-2022','11','824',847,'835','305','1','08-03-2022 10:52:48','1','14-03-2022 13:34:04','1','','',NULL,NULL),
(35,25,'26-12-2021','13-03-2022','11','824',847,'861','307','1','08-03-2022 11:17:55','1','14-03-2022 14:11:47','1','','',NULL,NULL),
(36,26,'26-09-2010','13-03-2022','11','825',847,'98','305','1','08-03-2022 15:09:40','1','14-03-2022 14:37:41','1','','',NULL,NULL),
(37,27,'18-05-2010','28-02-2021','11','825',847,'835','305','1','10-03-2022 10:41:21','1','14-03-2022 12:47:57','1','','',NULL,NULL),
(38,28,'07-11-2019','13-03-2022','11','826',847,'835','305','1','13-03-2022 11:06:10','1','14-03-2022 13:40:35','1','','',NULL,NULL),
(39,29,'15-12-2021','15-06-2022','11','826',847,'860','306','1','13-03-2022 11:55:02','1','14-03-2022 13:00:12','1','','',NULL,NULL),
(40,30,'01-03-2022','02-03-2022','11','824',847,'861','306','155','13-03-2022 12:28:26','1','14-03-2022 15:18:10','1','','',NULL,NULL),
(41,31,'21-09-2022','','11','824',854,'857','306','863','13-03-2022 15:40:06','1','13-03-2022 15:40:06','1','','',NULL,NULL),
(42,32,'01-02-2015','14-03-2022','11','826',849,'858','306','1','13-03-2022 16:31:14','1','14-03-2022 14:41:19','1','','',NULL,NULL),
(43,33,'19-12-2021','21-06-2022','11','826',848,'862','306','1','13-03-2022 17:22:14','1','14-03-2022 14:30:47','1','','',NULL,NULL),
(44,34,'08-03-2022','09-09-2022','11','826',848,'857','307','863','14-03-2022 12:44:05','1','14-03-2022 15:19:04','1','','',NULL,NULL),
(45,27,'01-03-2021','15-03-2022','11','826',847,'835','305','1','14-03-2022 12:47:57','1','14-03-2022 14:27:15','1','','',NULL,NULL),
(46,15,'08-05-2022','','11','824',854,'836','305','1','14-03-2022 12:57:00','1','14-03-2022 12:57:00','1','','',NULL,NULL),
(47,29,'16-06-2022','19-06-2022','11','826',847,'840','306','1','14-03-2022 13:00:12','1','14-03-2022 15:16:05','1','','',NULL,NULL),
(48,10,'01-09-2021','13-03-2022','11','826',851,'836','305','1','14-03-2022 13:02:30','1','14-03-2022 14:33:47','1','','',NULL,NULL),
(49,11,'01-04-2021','13-03-2022','11','826',680,'836','305','1','14-03-2022 13:05:39','1','14-03-2022 14:34:53','1','','',NULL,NULL),
(50,1,'14-03-2022','','11','824',846,'831','305','1','14-03-2022 13:08:15','1','14-03-2022 13:08:15','1','','',NULL,NULL),
(51,6,'14-03-2022','','11','824',848,'98','305','1','14-03-2022 13:09:39','1','14-03-2022 13:09:39','1','','',NULL,NULL),
(52,16,'14-03-2022','','11','824',850,'857','305','1','14-03-2022 13:11:37','1','14-03-2022 13:11:37','1','','',NULL,NULL),
(53,20,'14-03-2022','','11','824',854,'557','309','1','14-03-2022 13:12:51','1','14-03-2022 13:12:51','1','','',NULL,NULL),
(54,8,'14-03-2022','14-03-2022','11','826',848,'98','306','1','14-03-2022 13:13:41','1','14-03-2022 14:32:55','1','','',NULL,NULL),
(55,9,'14-03-2022','','11','824',671,'98','305','1','14-03-2022 13:14:59','1','14-03-2022 13:14:59','1','','',NULL,NULL),
(56,7,'14-03-2022','','11','824',848,'98','305','1','14-03-2022 13:15:44','1','14-03-2022 13:15:44','1','','',NULL,NULL),
(57,12,'14-03-2022','14-03-2022','11','824',850,'835','305','1','14-03-2022 13:17:00','1','14-03-2022 13:38:09','1','','',NULL,NULL),
(58,2,'14-03-2022','','11','824',849,'858','305','1','14-03-2022 13:17:56','1','14-03-2022 13:17:56','1','','',NULL,NULL),
(59,4,'14-03-2022','','11','824',854,'78','305','1','14-03-2022 13:19:09','1','14-03-2022 13:19:09','1','','',NULL,NULL),
(60,14,'14-03-2022','16-03-2022','11','826',848,'835','305','1','14-03-2022 13:20:19','1','14-03-2022 13:29:32','1','','',NULL,NULL),
(61,14,'17-03-2022','17-03-2022','11','826',848,'836','305','1','14-03-2022 13:29:32','1','14-03-2022 15:07:59','1','','',NULL,NULL),
(62,13,'14-03-2022','','11','824',849,'836','306','1','14-03-2022 13:32:27','1','14-03-2022 13:32:27','1','','',NULL,NULL),
(63,24,'14-03-2022','','11','825',848,'836','305','1','14-03-2022 13:34:04','1','14-03-2022 13:34:04','1','','',NULL,NULL),
(64,3,'14-03-2022','','11','824',851,'858','305','1','14-03-2022 13:36:27','1','14-03-2022 13:36:27','1','','',NULL,NULL),
(65,12,'15-03-2022','','11','824',850,'836','305','1','14-03-2022 13:38:09','1','14-03-2022 13:38:09','1','','',NULL,NULL),
(66,28,'14-03-2022','17-03-2022','11','826',848,'836','305','1','14-03-2022 13:40:35','1','14-03-2022 15:14:36','1','','',NULL,NULL),
(67,5,'14-03-2022','','11','824',848,'78','305','1','14-03-2022 13:59:49','1','14-03-2022 13:59:49','1','','',NULL,NULL),
(68,17,'14-03-2022','','11','824',848,'840','309','1','14-03-2022 14:06:01','1','14-03-2022 14:06:01','1','','',NULL,NULL),
(69,21,'14-03-2022','','11','824',849,'858','305','1','14-03-2022 14:08:30','1','14-03-2022 14:08:30','1','','',NULL,NULL),
(70,18,'14-03-2022','','11','824',852,'858','306','1','14-03-2022 14:10:56','1','14-03-2022 14:10:56','1','','',NULL,NULL),
(71,25,'14-03-2022','','11','825',847,'861','307','1','14-03-2022 14:11:47','1','14-03-2022 14:11:47','1','','',NULL,NULL),
(72,27,'16-03-2022','','11','826',847,'836','305','1','14-03-2022 14:27:15','1','14-03-2022 14:27:15','1','','',NULL,NULL),
(73,33,'22-06-2022','22-06-2022','11','826',848,'862','306','155','14-03-2022 14:30:47','1','14-03-2022 14:31:17','1','','',NULL,NULL),
(74,33,'23-06-2022','','11','824',848,'862','306','155','14-03-2022 14:31:17','1','14-03-2022 14:31:17','1','','',NULL,NULL),
(75,19,'14-03-2022','','11','824',668,'55','307','1','14-03-2022 14:32:02','1','14-03-2022 14:32:02','1','','',NULL,NULL),
(76,8,'15-03-2022','','11','824',848,'98','306','1','14-03-2022 14:32:55','1','14-03-2022 14:32:55','1','','',NULL,NULL),
(77,10,'14-03-2022','','11','824',851,'836','305','1','14-03-2022 14:33:47','1','14-03-2022 14:33:47','1','','',NULL,NULL),
(78,11,'14-03-2022','','11','824',680,'836','305','1','14-03-2022 14:34:53','1','14-03-2022 14:34:53','1','','',NULL,NULL),
(79,26,'14-03-2022','17-03-2022','11','824',848,'98','305','1','14-03-2022 14:37:41','1','14-03-2022 15:11:22','1','','',NULL,NULL),
(80,32,'15-03-2022','','11','824',849,'858','306','1','14-03-2022 14:41:19','1','14-03-2022 14:41:19','1','','',NULL,NULL),
(81,22,'14-03-2022','','11','825',847,'98','305','1','14-03-2022 14:42:52','1','14-03-2022 14:42:52','1','','',NULL,NULL),
(82,14,'18-03-2022','','11','824',848,'836','305','1','14-03-2022 15:07:59','1','14-03-2022 15:07:59','1','','',NULL,NULL),
(83,26,'18-03-2022','','11','826',848,'98','305','1','14-03-2022 15:11:22','1','14-03-2022 15:11:22','1','','',NULL,NULL),
(84,23,'14-03-2022','','11','824',848,'98','305','1','14-03-2022 15:13:31','1','14-03-2022 15:13:31','1','','',NULL,NULL),
(85,28,'18-03-2022','','11','827',848,'836','305','1','14-03-2022 15:14:36','1','14-03-2022 15:14:36','1','','',NULL,NULL),
(86,29,'20-06-2022','','11','827',848,'840','306','1','14-03-2022 15:16:05','1','14-03-2022 15:16:05','1','','',NULL,NULL),
(87,30,'03-03-2022','','11','825',848,'861','306','155','14-03-2022 15:18:10','1','14-03-2022 15:18:10','1','','',NULL,NULL),
(88,34,'10-09-2022','','11','824',848,'857','307','863','14-03-2022 15:19:04','1','14-03-2022 15:19:04','1','','',NULL,NULL),
(89,35,'01-03-2022','','11','825',848,'840','307','1','14-03-2022 15:45:05','1','14-03-2022 15:45:05','1','','',NULL,NULL),
(90,36,'02-07-2022','','11','826',848,'862','307','155','14-03-2022 16:31:41','1','14-03-2022 16:31:41','1','','',NULL,NULL);

/*Table structure for table `emp_leave` */

DROP TABLE IF EXISTS `emp_leave`;

CREATE TABLE `emp_leave` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `leave_year` varchar(100) DEFAULT NULL,
  `leave_start_date` varchar(100) DEFAULT NULL,
  `leave_end_date` varchar(100) DEFAULT NULL,
  `leave_total_day` varchar(100) DEFAULT NULL,
  `length_of_services` varchar(100) DEFAULT NULL,
  `leave_availed` int(2) DEFAULT '0',
  `total_leave_availed` int(4) DEFAULT '0',
  `total_annual_leave_spent` int(4) DEFAULT '0',
  `leave_remaining` int(4) DEFAULT NULL,
  `leave_type` varchar(100) DEFAULT NULL,
  `pay_status` varchar(100) DEFAULT NULL,
  `justification` text,
  `leave_address` text,
  `contact_number` varchar(50) DEFAULT NULL,
  `department_approval` tinyint(2) DEFAULT NULL COMMENT '0=pending,1=approved, -1=not approved',
  `hr_approval` tinyint(2) DEFAULT '0' COMMENT '0=pending,1=approved, -1=not approved',
  `approve_status` varchar(100) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `created_time` varchar(100) DEFAULT NULL,
  `updated_time` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `responsibilities` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

/*Data for the table `emp_leave` */

insert  into `emp_leave`(`id`,`content_id`,`leave_year`,`leave_start_date`,`leave_end_date`,`leave_total_day`,`length_of_services`,`leave_availed`,`total_leave_availed`,`total_annual_leave_spent`,`leave_remaining`,`leave_type`,`pay_status`,`justification`,`leave_address`,`contact_number`,`department_approval`,`hr_approval`,`approve_status`,`remarks`,`application_date`,`created_time`,`updated_time`,`created_by`,`updated_by`,`responsibilities`) values 
(2,18,'2022','09-01-2022','09-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:04:46','13-03-2022 13:04:46','1','1',NULL),
(3,6,'2022','24-01-2022','24-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:11:31','13-03-2022 13:11:31','1','1',NULL),
(4,7,'2022','13-01-2022','13-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:12:28','13-03-2022 13:12:28','1','1',NULL),
(5,12,'2022','06-01-2022','06-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:13:22','13-03-2022 13:13:22','1','1',NULL),
(6,12,'2022','03-02-2022','03-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(7,12,'2022','04-02-2022','04-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(8,12,'2022','05-02-2022','05-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(9,12,'2022','06-02-2022','06-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(10,12,'2022','07-02-2022','07-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(11,12,'2022','08-02-2022','08-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(12,12,'2022','09-02-2022','09-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(13,12,'2022','10-02-2022','10-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(14,12,'2022','11-02-2022','11-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(15,12,'2022','12-02-2022','12-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(16,12,'2022','13-02-2022','13-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(17,12,'2022','14-02-2022','14-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(18,12,'2022','15-02-2022','15-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(19,12,'2022','16-02-2022','16-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(20,12,'2022','17-02-2022','17-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:14:12','13-03-2022 13:14:12','1','1',NULL),
(25,17,'2022','05-01-2022','05-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 13:18:35','13-03-2022 13:18:35','1','1',NULL),
(26,4,'2022','06-01-2022','06-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 14:54:21','13-03-2022 14:54:21','1','1',NULL),
(27,12,'2022','24-01-2022','24-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 14:57:32','13-03-2022 14:57:32','1','1',NULL),
(28,12,'2022','25-01-2022','25-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 14:57:32','13-03-2022 14:57:32','1','1',NULL),
(29,12,'2022','26-01-2022','26-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 14:57:32','13-03-2022 14:57:32','1','1',NULL),
(30,12,'2022','27-01-2022','27-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 14:57:32','13-03-2022 14:57:32','1','1',NULL),
(31,12,'2022','24-02-2022','24-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:01:54','13-03-2022 15:01:54','1','1',NULL),
(32,12,'2022','25-02-2022','25-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:01:54','13-03-2022 15:01:54','1','1',NULL),
(33,12,'2022','26-02-2022','26-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:01:54','13-03-2022 15:01:54','1','1',NULL),
(34,12,'2022','27-02-2022','27-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:01:54','13-03-2022 15:01:54','1','1',NULL),
(35,17,'2022','01-03-2022','01-03-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:16:44','13-03-2022 15:16:44','1','1',NULL),
(36,13,'2021','27-12-2021','27-12-2021','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:20:35','13-03-2022 15:20:35','1','1',NULL),
(37,13,'2022','24-02-2022','24-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:21:42','13-03-2022 15:21:42','1','1',NULL),
(38,13,'2022','06-02-2022','06-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(39,13,'2022','07-02-2022','07-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(40,13,'2022','08-02-2022','08-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(41,13,'2022','09-02-2022','09-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(42,13,'2022','10-02-2022','10-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(43,13,'2022','11-02-2022','11-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(44,13,'2022','12-02-2022','12-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(45,13,'2022','13-02-2022','13-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(46,13,'2022','14-02-2022','14-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(47,13,'2022','15-02-2022','15-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(48,13,'2022','16-02-2022','16-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(49,13,'2022','17-02-2022','17-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:22:30','13-03-2022 15:22:30','1','1',NULL),
(50,13,'2022','06-03-2022','06-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:23:10','13-03-2022 15:23:10','1','1',NULL),
(51,31,'2022','06-01-2022','06-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:41:13','13-03-2022 15:41:13','1','1',NULL),
(52,3,'2022','02-01-2022','02-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:47:46','13-03-2022 15:47:46','1','1',NULL),
(54,3,'2022','27-02-2022','27-02-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:53:08','13-03-2022 15:53:08','1','1',NULL),
(55,3,'2022','08-03-2022','08-03-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:53:50','13-03-2022 15:53:50','1','1',NULL),
(56,20,'2022','23-01-2022','23-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:55:15','13-03-2022 15:55:44','1','1',NULL),
(57,20,'2022','24-01-2022','24-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:55:15','13-03-2022 15:55:44','1','1',NULL),
(58,20,'2022','25-01-2022','25-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:55:15','13-03-2022 15:55:44','1','1',NULL),
(59,20,'2022','26-01-2022','26-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:55:15','13-03-2022 15:55:44','1','1',NULL),
(60,20,'2022','27-01-2022','27-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 15:55:15','13-03-2022 15:55:44','1','1',NULL),
(61,9,'2022','25-01-2022','25-01-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:07:03','13-03-2022 16:07:03','1','1',NULL),
(62,32,'2022','23-01-2022','23-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(63,32,'2022','24-01-2022','24-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(64,32,'2022','25-01-2022','25-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(65,32,'2022','26-01-2022','26-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(66,32,'2022','27-01-2022','27-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(67,32,'2022','28-01-2022','28-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(68,32,'2022','29-01-2022','29-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(69,32,'2022','30-01-2022','30-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(70,32,'2022','31-01-2022','31-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(71,32,'2022','01-02-2022','01-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(72,32,'2022','02-02-2022','02-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(73,32,'2022','03-02-2022','03-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:32:57','13-03-2022 16:32:57','1','1',NULL),
(78,27,'2022','17-01-2022','17-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:43:58','13-03-2022 16:43:58','1','1',NULL),
(79,27,'2022','18-01-2022','18-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:43:58','13-03-2022 16:43:58','1','1',NULL),
(80,27,'2022','19-01-2022','19-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:43:58','13-03-2022 16:43:58','1','1',NULL),
(81,27,'2022','20-01-2022','20-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:43:58','13-03-2022 16:43:58','1','1',NULL),
(82,1,'2022','20-01-2022','20-01-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:02','13-03-2022 16:45:02','1','1',NULL),
(83,1,'2022','23-01-2022','23-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(84,1,'2022','24-01-2022','24-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(85,1,'2022','25-01-2022','25-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(86,1,'2022','26-01-2022','26-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(87,1,'2022','27-01-2022','27-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(88,1,'2022','28-01-2022','28-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(89,1,'2022','29-01-2022','29-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(90,1,'2022','30-01-2022','30-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(91,1,'2022','31-01-2022','31-01-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(92,1,'2022','01-02-2022','01-02-2022','1',NULL,0,0,0,NULL,'332','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:45:44','13-03-2022 16:45:44','1','1',NULL),
(93,10,'2022','20-02-2022','20-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:48:08','13-03-2022 16:48:08','1','1',NULL),
(94,19,'2022','22-02-2022','22-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:49:40','13-03-2022 16:49:40','1','1',NULL),
(95,19,'2022','23-02-2022','23-02-2022','1',NULL,0,0,0,NULL,'864','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:49:40','13-03-2022 16:49:40','1','1',NULL),
(96,15,'2022','06-03-2022','06-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:50:22','13-03-2022 16:50:22','1','1',NULL),
(97,2,'2022','17-02-2022','17-02-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:50:57','13-03-2022 16:50:57','1','1',NULL),
(98,29,'2022','07-03-2022','07-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 16:51:50','13-03-2022 16:51:50','1','1',NULL),
(99,33,'2022','09-03-2022','09-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 17:23:00','13-03-2022 17:23:00','1','1',NULL),
(100,33,'2022','10-03-2022','10-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'13-03-2022 17:23:00','13-03-2022 17:23:00','1','1',NULL),
(101,13,'2022','13-03-2022','13-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'14-03-2022 17:10:21','14-03-2022 17:10:21','1','1',NULL),
(102,18,'2022','20-03-2022','20-03-2022','1',NULL,0,0,0,NULL,'330','payable','','',NULL,NULL,0,'approved',NULL,NULL,'15-03-2022 10:58:58','15-03-2022 10:58:58','1','1',NULL);

/*Table structure for table `emp_leave_total_system` */

DROP TABLE IF EXISTS `emp_leave_total_system`;

CREATE TABLE `emp_leave_total_system` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(100) NOT NULL,
  `leave_type` varchar(100) DEFAULT NULL,
  `total_days` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `emp_leave_total_system` */

insert  into `emp_leave_total_system`(`id`,`content_id`,`leave_type`,`total_days`) values 
(1,1,'annual_leave_total','56'),
(2,2,'annual_leave_total','56'),
(3,3,'annual_leave_total','56'),
(4,4,'annual_leave_total','56'),
(5,5,'annual_leave_total','56'),
(6,6,'annual_leave_total','56'),
(7,7,'annual_leave_total','56'),
(8,8,'annual_leave_total','56'),
(9,9,'annual_leave_total','56'),
(10,10,'annual_leave_total','56'),
(11,11,'annual_leave_total','56'),
(12,12,'annual_leave_total','56'),
(13,13,'annual_leave_total','56'),
(14,14,'annual_leave_total','56'),
(15,15,'annual_leave_total','56'),
(16,16,'annual_leave_total','56'),
(17,17,'annual_leave_total','56'),
(18,18,'annual_leave_total','56'),
(19,19,'annual_leave_total','56'),
(20,20,'annual_leave_total','56'),
(21,21,'annual_leave_total','56'),
(22,22,'annual_leave_total','56'),
(23,23,'annual_leave_total','56'),
(24,24,'annual_leave_total','56'),
(25,25,'annual_leave_total','56'),
(26,26,'annual_leave_total','56'),
(27,27,'annual_leave_total','56'),
(28,28,'annual_leave_total','56'),
(29,29,'annual_leave_total','56'),
(30,30,'annual_leave_total','56'),
(31,31,'annual_leave_total','56'),
(32,32,'annual_leave_total','56'),
(33,33,'annual_leave_total','56'),
(34,34,'annual_leave_total','56'),
(35,35,'annual_leave_total','56'),
(36,36,'annual_leave_total','56');

/*Table structure for table `emp_leave_total_system_history` */

DROP TABLE IF EXISTS `emp_leave_total_system_history`;

CREATE TABLE `emp_leave_total_system_history` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `start_year` varchar(100) DEFAULT NULL,
  `end_year` varchar(100) DEFAULT NULL,
  `leave_type` varchar(200) DEFAULT NULL,
  `total_days` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(255) DEFAULT NULL,
  `reserved2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `emp_leave_total_system_history` */

insert  into `emp_leave_total_system_history`(`id`,`content_id`,`start_year`,`end_year`,`leave_type`,`total_days`,`created_time`,`created_by`,`updated_time`,`updated_by`,`reserved1`,`reserved2`) values 
(1,1,'01-01-2008','','annual_leave_total','56','01-01-2022 14:39:56','1','01-01-2022 14:39:56','1','',''),
(2,2,'01-01-2022','','annual_leave_total','56','10-02-2022 16:41:45','1','10-02-2022 16:41:45','1','',''),
(3,3,'01-01-2022','','annual_leave_total','56','10-02-2022 17:21:41','1','10-02-2022 17:21:41','1','',''),
(4,4,'01-01-2022','','annual_leave_total','56','13-02-2022 13:30:40','1','13-02-2022 13:30:40','1','',''),
(5,5,'01-01-2010','','annual_leave_total','56','13-02-2022 17:09:35','1','13-02-2022 17:09:35','1','',''),
(6,6,'01-01-2009','','annual_leave_total','56','14-02-2022 11:48:10','1','14-02-2022 11:48:10','1','',''),
(7,7,'01-01-2010','','annual_leave_total','56','15-02-2022 12:17:01','1','15-02-2022 12:17:01','1','',''),
(8,8,'01-01-2011','','annual_leave_total','56','15-02-2022 13:13:15','1','15-02-2022 13:13:15','1','',''),
(9,9,'01-01-2020','','annual_leave_total','56','15-02-2022 14:51:42','1','15-02-2022 14:51:42','1','',''),
(10,10,'01-01-2010','','annual_leave_total','56','16-02-2022 16:46:06','1','16-02-2022 16:46:06','1','',''),
(11,11,'01-01-2010','','annual_leave_total','56','16-02-2022 17:08:19','1','16-02-2022 17:08:19','1','',''),
(12,12,'01-01-2010','','annual_leave_total','56','17-02-2022 12:04:53','1','17-02-2022 12:04:53','1','',''),
(13,13,'01-01-2011','','annual_leave_total','56','17-02-2022 14:12:36','1','17-02-2022 14:12:36','1','',''),
(14,14,'01-01-2011','','annual_leave_total','56','17-02-2022 14:27:42','1','17-02-2022 14:27:42','1','',''),
(15,15,'01-01-2022','','annual_leave_total','56','28-02-2022 16:20:14','1','28-02-2022 16:20:14','1','',''),
(16,16,'01-01-2009','','annual_leave_total','56','28-02-2022 16:33:38','1','28-02-2022 16:33:38','1','',''),
(17,17,'01-01-2021','','annual_leave_total','56','28-02-2022 16:57:18','1','28-02-2022 16:57:18','1','',''),
(18,18,'01-01-2022','','annual_leave_total','56','07-03-2022 13:10:57','1','07-03-2022 13:10:57','1','',''),
(19,19,'01-01-2009','','annual_leave_total','56','07-03-2022 14:35:06','1','07-03-2022 14:35:06','1','',''),
(20,20,'01-01-2009','','annual_leave_total','56','07-03-2022 14:52:04','1','07-03-2022 14:52:04','1','',''),
(21,21,'01-01-2022','','annual_leave_total','56','07-03-2022 16:44:43','1','07-03-2022 16:44:43','1','',''),
(22,22,'01-01-2010','','annual_leave_total','56','07-03-2022 17:06:57','1','07-03-2022 17:06:57','1','',''),
(23,23,'01-01-2010','','annual_leave_total','56','07-03-2022 17:24:08','1','07-03-2022 17:24:08','1','',''),
(24,24,'01-01-2010','','annual_leave_total','56','08-03-2022 10:52:48','1','08-03-2022 10:52:48','1','',''),
(25,25,'01-01-2022','','annual_leave_total','56','08-03-2022 11:17:55','1','08-03-2022 11:17:55','1','',''),
(26,26,'01-01-2010','','annual_leave_total','56','08-03-2022 15:09:40','1','08-03-2022 15:09:40','1','',''),
(27,27,'01-01-2010','','annual_leave_total','56','10-03-2022 10:41:21','1','10-03-2022 10:41:21','1','',''),
(28,28,'01-01-2020','','annual_leave_total','56','13-03-2022 11:06:10','1','13-03-2022 11:06:10','1','',''),
(29,29,'01-01-2022','','annual_leave_total','56','13-03-2022 11:55:02','1','13-03-2022 11:55:02','1','',''),
(30,30,'01-01-2022','','annual_leave_total','56','13-03-2022 12:28:26','1','13-03-2022 12:28:26','1','',''),
(31,31,'01-01-2022','','annual_leave_total','56','13-03-2022 15:40:06','1','13-03-2022 15:40:06','1','',''),
(32,32,'01-01-2016','','annual_leave_total','56','13-03-2022 16:31:14','1','13-03-2022 16:31:14','1','',''),
(33,33,'01-01-2022','','annual_leave_total','56','13-03-2022 17:22:14','1','13-03-2022 17:22:14','1','',''),
(34,34,'01-01-2022','','annual_leave_total','56','14-03-2022 12:44:05','1','14-03-2022 12:44:05','1','',''),
(35,35,'01-01-2022','','annual_leave_total','56','14-03-2022 15:45:05','1','14-03-2022 15:45:05','1','',''),
(36,36,'01-01-2022','','annual_leave_total','56','14-03-2022 16:31:41','1','14-03-2022 16:31:41','1','','');

/*Table structure for table `emp_payment_method` */

DROP TABLE IF EXISTS `emp_payment_method`;

CREATE TABLE `emp_payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(40) NOT NULL,
  `bank_name` varchar(40) DEFAULT NULL,
  `emp_bank_branch` varchar(40) DEFAULT NULL,
  `emp_bank_account` varchar(40) DEFAULT NULL,
  `emp_pay_type` varchar(40) DEFAULT NULL,
  `created` varchar(40) DEFAULT NULL,
  `updated` varchar(40) DEFAULT NULL,
  `created_by` varchar(40) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `emp_payment_method` */

insert  into `emp_payment_method`(`id`,`content_id`,`bank_name`,`emp_bank_branch`,`emp_bank_account`,`emp_pay_type`,`created`,`updated`,`created_by`,`updated_by`,`comments`) values 
(1,1,'','','','207','01-01-2022 14:39:56','01-01-2022 14:39:56','1','1','');

/*Table structure for table `emp_per_submit_id` */

DROP TABLE IF EXISTS `emp_per_submit_id`;

CREATE TABLE `emp_per_submit_id` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `per_main_id` varchar(100) DEFAULT NULL,
  `appraisor_usr_id` varchar(200) DEFAULT NULL,
  `to_emp_id` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_per_submit_id` */

/*Table structure for table `emp_performance_id` */

DROP TABLE IF EXISTS `emp_performance_id`;

CREATE TABLE `emp_performance_id` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `Performance_Title` text,
  `appraisal_period_from` varchar(200) DEFAULT NULL,
  `appraisal_period_to` varchar(200) DEFAULT NULL,
  `Last_Date_Submission` varchar(200) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `Remarks` text,
  `created_time` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `emp_performance_id` */

insert  into `emp_performance_id`(`id`,`Performance_Title`,`appraisal_period_from`,`appraisal_period_to`,`Last_Date_Submission`,`Status`,`Remarks`,`created_time`,`updated_time`,`created_by`,`updated_by`) values 
(3,'Performance Appraisal - 2016','01-10-2015','31-12-2015','23-01-2016','1','','21-01-2016 11:44:14','','1','');

/*Table structure for table `emp_performance_value` */

DROP TABLE IF EXISTS `emp_performance_value`;

CREATE TABLE `emp_performance_value` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `performance_id` int(200) NOT NULL,
  `field_name` text,
  `field_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_performance_value` */

/*Table structure for table `emp_provision` */

DROP TABLE IF EXISTS `emp_provision`;

CREATE TABLE `emp_provision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(20) NOT NULL,
  `provision_date_from` varchar(40) DEFAULT NULL,
  `provision_date_to` varchar(40) DEFAULT NULL,
  `insertflag` int(11) NOT NULL DEFAULT '0',
  `created` varchar(40) DEFAULT NULL,
  `updated` varchar(40) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `emp_provision` */

insert  into `emp_provision`(`id`,`content_id`,`provision_date_from`,`provision_date_to`,`insertflag`,`created`,`updated`,`updated_by`) values 
(1,30,'01-03-2022','01-09-2022',0,'13-03-2022 12:28:26','14-03-2022 15:18:09','1'),
(2,33,'19-12-2021','22-06-2022',0,'14-03-2022 14:30:47','14-03-2022 14:31:17','1'),
(3,36,'02-01-2022','02-07-2022',0,'14-03-2022 16:31:41','14-03-2022 16:31:41','1');

/*Table structure for table `emp_salary` */

DROP TABLE IF EXISTS `emp_salary`;

CREATE TABLE `emp_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(5) NOT NULL,
  `basic_salary` varchar(40) DEFAULT '0',
  `house_rent` varchar(40) DEFAULT '0',
  `medical_allow` varchar(40) DEFAULT '0',
  `conveyance_allow` varchar(40) DEFAULT '0',
  `telephone_allow` varchar(40) DEFAULT '0',
  `special_allowa` varchar(40) DEFAULT '0',
  `provident_allow` varchar(40) DEFAULT '0',
  `transport_allow` varchar(40) DEFAULT '0',
  `other_allow` varchar(40) DEFAULT '0',
  `performance_bonus` varchar(40) DEFAULT '0',
  `festival_bonus` varchar(40) DEFAULT '0',
  `total_benifit` varchar(40) DEFAULT '0',
  `increment_amount` varchar(40) DEFAULT '0',
  `increment_percentage` varchar(40) DEFAULT NULL,
  `increment_date` varchar(40) DEFAULT NULL,
  `gross_salary` varchar(40) DEFAULT '0',
  `yearly_paid` varchar(40) DEFAULT '0',
  `created` varchar(40) DEFAULT NULL,
  `updated` varchar(40) DEFAULT NULL,
  `created_by` varchar(40) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_salary` */

/*Table structure for table `emp_salary_deduction` */

DROP TABLE IF EXISTS `emp_salary_deduction`;

CREATE TABLE `emp_salary_deduction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(5) NOT NULL,
  `provident_fund_deduction` varchar(40) DEFAULT '0',
  `tax_deduction` varchar(10) DEFAULT '0',
  `other_deduction` varchar(40) DEFAULT '0',
  `total_deduction` varchar(40) DEFAULT '0',
  `created` varchar(40) DEFAULT NULL,
  `updated` varchar(40) DEFAULT NULL,
  `created_by` varchar(40) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_salary_deduction` */

/*Table structure for table `emp_shift_history` */

DROP TABLE IF EXISTS `emp_shift_history`;

CREATE TABLE `emp_shift_history` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `start_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL,
  `work_starting_time` varchar(200) DEFAULT NULL,
  `work_ending_time` varchar(200) DEFAULT NULL,
  `attendance_required` varchar(200) DEFAULT NULL,
  `logout_required` varchar(200) DEFAULT NULL,
  `emp_latecount_time` varchar(200) DEFAULT NULL,
  `emp_earlycount_time` varchar(200) DEFAULT NULL,
  `half_day_absent` varchar(200) DEFAULT NULL,
  `absent_count_time` varchar(200) DEFAULT NULL,
  `overtime_count` varchar(200) DEFAULT NULL,
  `overtime_hourly_rate` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(255) DEFAULT NULL,
  `reserved2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `emp_shift_history` */

insert  into `emp_shift_history`(`id`,`content_id`,`start_date`,`end_date`,`work_starting_time`,`work_ending_time`,`attendance_required`,`logout_required`,`emp_latecount_time`,`emp_earlycount_time`,`half_day_absent`,`absent_count_time`,`overtime_count`,`overtime_hourly_rate`,`created_time`,`created_by`,`updated_time`,`updated_by`,`reserved1`,`reserved2`) values 
(1,1,'17-12-2008','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','01-01-2022 14:39:56','1','01-01-2022 14:39:56','1','',''),
(2,2,'01-02-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','10-02-2022 16:41:45','1','28-02-2022 15:12:00','1','',''),
(3,3,'01-02-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','10-02-2022 17:21:41','1','10-02-2022 17:21:41','1','',''),
(4,4,'01-12-2012','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-02-2022 13:30:40','1','13-03-2022 12:42:09','1','',''),
(5,5,'01-02-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-02-2022 17:09:35','1','13-02-2022 17:09:35','1','',''),
(6,6,'01-07-2009','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-02-2022 11:48:09','1','14-02-2022 15:10:13','1','',''),
(7,7,'29-04-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','15-02-2022 12:17:01','1','15-02-2022 12:17:01','1','',''),
(8,8,'01-01-2011','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','15-02-2022 13:13:15','1','15-02-2022 13:13:15','1','',''),
(9,9,'09-08-2011','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','15-02-2022 14:51:42','1','15-02-2022 15:14:30','1','',''),
(10,10,'01-09-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','16-02-2022 16:46:06','1','16-02-2022 16:46:06','1','',''),
(11,11,'13-08-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','16-02-2022 17:08:19','1','16-02-2022 17:08:19','1','',''),
(12,12,'05-08-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','17-02-2022 12:04:53','1','17-02-2022 12:04:53','1','',''),
(13,13,'25-02-2011','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','17-02-2022 14:12:36','1','17-02-2022 14:12:36','1','',''),
(14,14,'14-01-2011','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','17-02-2022 14:27:41','1','17-02-2022 14:27:41','1','',''),
(15,15,'07-05-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','28-02-2022 16:20:14','1','28-02-2022 16:20:14','1','',''),
(16,16,'03-11-2009','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','28-02-2022 16:33:38','1','28-02-2022 16:33:38','1','',''),
(17,17,'16-03-2021','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','28-02-2022 16:57:18','1','28-02-2022 16:57:18','1','',''),
(18,18,'01-01-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 13:10:56','1','07-03-2022 13:12:33','1','',''),
(19,19,'14-11-2009','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 14:35:06','1','07-03-2022 14:35:06','1','',''),
(20,20,'03-11-2009','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 14:52:04','1','07-03-2022 14:52:04','1','',''),
(21,21,'18-01-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 16:44:43','1','07-03-2022 16:44:43','1','',''),
(22,22,'07-03-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 17:06:57','1','07-03-2022 17:06:57','1','',''),
(23,23,'30-10-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 17:24:08','1','07-03-2022 17:24:08','1','',''),
(24,24,'30-09-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','08-03-2022 10:52:48','1','08-03-2022 10:52:48','1','',''),
(25,25,'01-03-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','08-03-2022 11:17:55','1','08-03-2022 11:17:55','1','',''),
(26,26,'07-12-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','08-03-2022 15:09:40','1','08-03-2022 15:09:40','1','',''),
(27,27,'18-08-2010','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','10-03-2022 10:41:21','1','10-03-2022 10:41:21','1','',''),
(28,28,'07-05-2020','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 11:06:10','1','13-03-2022 11:06:10','1','',''),
(29,29,'14-03-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 11:55:02','1','14-03-2022 15:09:03','1','',''),
(30,30,'03-03-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 12:28:26','1','14-03-2022 15:18:09','1','',''),
(31,31,'21-09-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 15:40:06','1','13-03-2022 15:40:06','1','',''),
(32,32,'15-06-2016','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 16:31:14','1','13-03-2022 16:31:14','1','',''),
(33,33,'19-06-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 17:22:14','1','13-03-2022 17:22:14','1','',''),
(34,34,'15-03-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-03-2022 12:44:05','1','14-03-2022 14:38:36','1','',''),
(35,35,'06-03-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-03-2022 15:45:05','1','14-03-2022 15:46:28','1','',''),
(36,36,'02-07-2022','','09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-03-2022 16:31:41','1','14-03-2022 16:31:41','1','','');

/*Table structure for table `emp_weeklyholiday` */

DROP TABLE IF EXISTS `emp_weeklyholiday`;

CREATE TABLE `emp_weeklyholiday` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(100) NOT NULL,
  `sat_off` varchar(40) NOT NULL,
  `sun_off` varchar(40) NOT NULL,
  `mon_off` varchar(40) NOT NULL,
  `tue_off` varchar(40) NOT NULL,
  `wed_off` varchar(40) NOT NULL,
  `thus_off` varchar(40) NOT NULL,
  `fri_off` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `emp_weeklyholiday` */

insert  into `emp_weeklyholiday`(`id`,`content_id`,`sat_off`,`sun_off`,`mon_off`,`tue_off`,`wed_off`,`thus_off`,`fri_off`) values 
(1,1,'off','on','on','on','on','on','off'),
(2,2,'off','on','on','on','on','on','off'),
(3,3,'off','on','on','on','on','on','off'),
(4,4,'off','on','on','on','on','on','off'),
(5,5,'off','on','on','on','on','on','off'),
(6,6,'off','on','on','on','on','on','off'),
(7,7,'off','on','on','on','on','on','off'),
(8,8,'off','on','on','on','on','on','off'),
(9,9,'off','on','on','on','on','on','off'),
(10,10,'off','on','on','on','on','on','off'),
(11,11,'off','on','on','on','on','on','off'),
(12,12,'off','on','on','on','on','on','off'),
(13,13,'off','on','on','on','on','on','off'),
(14,14,'off','on','on','on','on','on','off'),
(15,15,'off','on','on','on','on','on','off'),
(16,16,'off','on','on','on','on','on','off'),
(17,17,'off','on','on','on','on','on','off'),
(18,18,'on','on','off','on','on','on','on'),
(19,19,'off','on','on','on','on','on','off'),
(20,20,'off','on','on','on','on','on','off'),
(21,21,'off','on','on','on','on','on','off'),
(22,22,'off','on','on','on','on','on','off'),
(23,23,'off','on','on','on','on','on','off'),
(24,24,'off','on','on','on','on','on','off'),
(25,25,'off','on','on','on','on','on','off'),
(26,26,'off','on','on','on','on','on','off'),
(27,27,'on','off','on','on','on','on','on'),
(28,28,'off','on','on','on','on','on','off'),
(29,29,'off','on','on','on','on','on','off'),
(30,30,'off','on','on','on','on','on','off'),
(31,31,'off','on','on','on','on','on','off'),
(32,32,'off','on','on','on','on','on','off'),
(33,33,'off','on','on','on','on','on','off'),
(34,34,'off','on','on','on','on','on','off'),
(35,35,'off','on','on','on','on','on','off'),
(36,36,'off','on','on','on','on','on','off');

/*Table structure for table `emp_weeklyholiday_history` */

DROP TABLE IF EXISTS `emp_weeklyholiday_history`;

CREATE TABLE `emp_weeklyholiday_history` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `start_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL,
  `sat_off` varchar(200) DEFAULT NULL,
  `sun_off` varchar(200) DEFAULT NULL,
  `mon_off` varchar(200) DEFAULT NULL,
  `tue_off` varchar(200) DEFAULT NULL,
  `wed_off` varchar(200) DEFAULT NULL,
  `thus_off` varchar(200) DEFAULT NULL,
  `fri_off` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(255) DEFAULT NULL,
  `reserved2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `emp_weeklyholiday_history` */

insert  into `emp_weeklyholiday_history`(`id`,`content_id`,`start_date`,`end_date`,`sat_off`,`sun_off`,`mon_off`,`tue_off`,`wed_off`,`thus_off`,`fri_off`,`created_time`,`created_by`,`updated_time`,`updated_by`,`reserved1`,`reserved2`) values 
(1,1,'17-12-2008','','off','on','on','on','on','on','off','01-01-2022 14:39:56','1','01-01-2022 14:39:56','1','',''),
(2,2,'10-02-2022','','off','on','on','on','on','on','off','10-02-2022 16:41:45','1','28-02-2022 15:12:32','1','',''),
(3,3,'01-02-2022','','off','on','on','on','on','on','off','10-02-2022 17:21:41','1','10-02-2022 17:21:41','1','',''),
(4,4,'13-02-2022','','off','on','on','on','on','on','off','13-02-2022 13:30:40','1','13-03-2022 12:42:26','1','',''),
(5,5,'01-02-2010','','off','on','on','on','on','on','off','13-02-2022 17:09:35','1','13-02-2022 17:09:35','1','',''),
(6,6,'01-09-2009','','off','on','on','on','on','on','off','14-02-2022 11:48:10','1','14-02-2022 15:10:13','1','',''),
(7,7,'29-04-2010','','off','on','on','on','on','on','off','15-02-2022 12:17:01','1','15-02-2022 12:17:01','1','',''),
(8,8,'01-01-2011','','off','on','on','on','on','on','off','15-02-2022 13:13:15','1','15-02-2022 13:13:15','1','',''),
(9,9,'09-09-2020','','off','on','on','on','on','on','off','15-02-2022 14:51:42','1','15-02-2022 15:14:30','1','',''),
(10,10,'01-09-2010','','off','on','on','on','on','on','off','16-02-2022 16:46:06','1','16-02-2022 16:46:06','1','',''),
(11,11,'13-08-2010','','off','on','on','on','on','on','off','16-02-2022 17:08:19','1','16-02-2022 17:08:19','1','',''),
(12,12,'05-08-2010','','off','on','on','on','on','on','off','17-02-2022 12:04:53','1','17-02-2022 12:04:53','1','',''),
(13,13,'25-02-2011','','off','on','on','on','on','on','off','17-02-2022 14:12:36','1','17-02-2022 14:12:36','1','',''),
(14,14,'14-01-2011','','off','on','on','on','on','on','off','17-02-2022 14:27:42','1','17-02-2022 14:27:42','1','',''),
(15,15,'07-05-2022','','off','on','on','on','on','on','off','28-02-2022 16:20:14','1','28-02-2022 16:20:14','1','',''),
(16,16,'03-11-2009','','off','on','on','on','on','on','off','28-02-2022 16:33:38','1','28-02-2022 16:33:38','1','',''),
(17,17,'16-03-2021','','off','on','on','on','on','on','off','28-02-2022 16:57:18','1','28-02-2022 16:57:18','1','',''),
(18,18,'02-05-2022','','on','on','off','on','on','on','on','07-03-2022 13:10:57','1','14-03-2022 14:10:55','1','',''),
(19,19,'14-11-2009','','off','on','on','on','on','on','off','07-03-2022 14:35:06','1','07-03-2022 14:35:06','1','',''),
(20,20,'03-11-2009','','off','on','on','on','on','on','off','07-03-2022 14:52:04','1','07-03-2022 14:52:04','1','',''),
(21,21,'18-01-2022','','off','on','on','on','on','on','off','07-03-2022 16:44:43','1','07-03-2022 16:44:43','1','',''),
(22,22,'07-03-2010','','off','on','on','on','on','on','off','07-03-2022 17:06:57','1','07-03-2022 17:06:57','1','',''),
(23,23,'30-10-2010','','off','on','on','on','on','on','off','07-03-2022 17:24:08','1','07-03-2022 17:24:08','1','',''),
(24,24,'30-09-2010','','off','on','on','on','on','on','off','08-03-2022 10:52:48','1','08-03-2022 10:52:48','1','',''),
(25,25,'01-03-2022','','off','on','on','on','on','on','off','08-03-2022 11:17:55','1','08-03-2022 11:17:55','1','',''),
(26,26,'07-12-2010','','off','on','on','on','on','on','off','08-03-2022 15:09:40','1','08-03-2022 15:09:40','1','',''),
(27,27,'18-08-2010','17-03-2011','off','on','on','on','on','on','off','10-03-2022 10:41:21','1','13-03-2022 11:59:16','1','',''),
(28,28,'07-05-2020','','off','on','on','on','on','on','off','13-03-2022 11:06:10','1','13-03-2022 11:06:10','1','',''),
(29,29,'15-06-2022','','off','on','on','on','on','on','off','13-03-2022 11:55:02','1','14-03-2022 15:09:39','1','',''),
(30,27,'18-03-2011','','on','off','on','on','on','on','on','13-03-2022 11:59:16','1','13-03-2022 11:59:16','1','',''),
(31,30,'01-09-2022','','off','on','on','on','on','on','off','13-03-2022 12:28:26','1','14-03-2022 15:18:09','1','',''),
(32,31,'21-09-2022','','off','on','on','on','on','on','off','13-03-2022 15:40:06','1','13-03-2022 15:40:06','1','',''),
(33,32,'15-06-2016','','off','on','on','on','on','on','off','13-03-2022 16:31:14','1','13-03-2022 16:31:14','1','',''),
(34,33,'19-06-2022','','off','on','on','on','on','on','off','13-03-2022 17:22:14','1','13-03-2022 17:22:14','1','',''),
(35,34,'08-09-2022','','off','on','on','on','on','on','off','14-03-2022 12:44:05','1','14-03-2022 14:38:36','1','',''),
(36,35,'01-09-2022','','off','on','on','on','on','on','off','14-03-2022 15:45:05','1','14-03-2022 15:46:28','1','',''),
(37,36,'02-07-2022','','off','on','on','on','on','on','off','14-03-2022 16:31:41','1','14-03-2022 16:31:41','1','','');

/*Table structure for table `emp_working_time` */

DROP TABLE IF EXISTS `emp_working_time`;

CREATE TABLE `emp_working_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(40) NOT NULL,
  `work_starting_time` varchar(40) DEFAULT NULL,
  `work_ending_time` varchar(40) DEFAULT NULL,
  `attendance_required` varchar(100) DEFAULT NULL,
  `logout_required` varchar(100) DEFAULT NULL,
  `emp_latecount_time` varchar(100) DEFAULT NULL,
  `emp_earlycount_time` varchar(200) DEFAULT NULL,
  `half_day_absent` varchar(200) DEFAULT NULL,
  `absent_count_time` varchar(200) DEFAULT NULL,
  `overtime_count` varchar(200) DEFAULT NULL,
  `overtime_hourly_rate` varchar(200) DEFAULT NULL,
  `created` varchar(40) DEFAULT NULL,
  `updated` varchar(40) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `emp_working_time` */

insert  into `emp_working_time`(`id`,`content_id`,`work_starting_time`,`work_ending_time`,`attendance_required`,`logout_required`,`emp_latecount_time`,`emp_earlycount_time`,`half_day_absent`,`absent_count_time`,`overtime_count`,`overtime_hourly_rate`,`created`,`updated`,`updated_by`) values 
(1,1,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','01-01-2022 14:39:56','14-03-2022 13:08:15','1'),
(2,2,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','10-02-2022 16:41:45','14-03-2022 13:17:56','1'),
(3,3,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','10-02-2022 17:21:41','14-03-2022 13:36:27','1'),
(4,4,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-02-2022 13:30:40','14-03-2022 13:19:09','1'),
(5,5,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-02-2022 17:09:35','14-03-2022 13:59:48','1'),
(6,6,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-02-2022 11:48:09','14-03-2022 13:09:39','1'),
(7,7,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','15-02-2022 12:17:01','14-03-2022 13:15:44','1'),
(8,8,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','15-02-2022 13:13:15','14-03-2022 14:32:55','1'),
(9,9,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','15-02-2022 14:51:42','14-03-2022 13:14:59','1'),
(10,10,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','16-02-2022 16:46:06','14-03-2022 14:33:46','1'),
(11,11,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','16-02-2022 17:08:19','14-03-2022 14:34:53','1'),
(12,12,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','17-02-2022 12:04:53','14-03-2022 13:38:09','1'),
(13,13,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','17-02-2022 14:12:36','14-03-2022 13:32:27','1'),
(14,14,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','17-02-2022 14:27:41','14-03-2022 15:07:59','1'),
(15,15,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','28-02-2022 16:20:14','14-03-2022 12:57:00','1'),
(16,16,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','28-02-2022 16:33:38','14-03-2022 13:11:36','1'),
(17,17,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','28-02-2022 16:57:18','14-03-2022 14:06:00','1'),
(18,18,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 13:10:56','14-03-2022 14:10:55','1'),
(19,19,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 14:35:06','14-03-2022 14:32:01','1'),
(20,20,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 14:52:04','14-03-2022 13:12:51','1'),
(21,21,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 16:44:43','14-03-2022 14:08:29','1'),
(22,22,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 17:06:57','14-03-2022 15:48:57','1'),
(23,23,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','07-03-2022 17:24:08','14-03-2022 15:13:31','1'),
(24,24,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','08-03-2022 10:52:48','14-03-2022 13:34:04','1'),
(25,25,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','08-03-2022 11:17:55','14-03-2022 14:11:47','1'),
(26,26,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','08-03-2022 15:09:40','14-03-2022 15:11:22','1'),
(27,27,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','10-03-2022 10:41:21','14-03-2022 14:27:15','1'),
(28,28,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 11:06:10','14-03-2022 15:14:35','1'),
(29,29,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 11:55:02','14-03-2022 15:16:05','1'),
(30,30,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 12:28:26','14-03-2022 15:18:09','1'),
(31,31,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 15:40:06','13-03-2022 15:40:06','1'),
(32,32,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 16:31:14','14-03-2022 14:41:19','1'),
(33,33,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','13-03-2022 17:22:14','14-03-2022 14:31:17','1'),
(34,34,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-03-2022 12:44:05','14-03-2022 15:19:03','1'),
(35,35,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-03-2022 15:45:05','14-03-2022 15:47:07','1'),
(36,36,'09:30:00','17:30:00','Required','Required','09:46:00','17:20:00','Not_Eligible','','Not_Eligible','','14-03-2022 16:31:41','14-03-2022 16:31:41','1');

/*Table structure for table `emp_yearly_leave` */

DROP TABLE IF EXISTS `emp_yearly_leave`;

CREATE TABLE `emp_yearly_leave` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(100) NOT NULL,
  `leave_type` varchar(100) DEFAULT NULL,
  `total_days` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_yearly_leave` */

/*Table structure for table `emp_yearly_leave_cat_history` */

DROP TABLE IF EXISTS `emp_yearly_leave_cat_history`;

CREATE TABLE `emp_yearly_leave_cat_history` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `content_id` int(200) NOT NULL,
  `start_year` varchar(100) DEFAULT NULL,
  `end_year` varchar(100) DEFAULT NULL,
  `leave_type` varchar(200) DEFAULT NULL,
  `total_days` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `reserved1` varchar(255) DEFAULT NULL,
  `reserved2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_yearly_leave_cat_history` */

/*Table structure for table `emp_yearlyholiday` */

DROP TABLE IF EXISTS `emp_yearlyholiday`;

CREATE TABLE `emp_yearlyholiday` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `holiday_for_division` varchar(100) DEFAULT NULL COMMENT 'company id',
  `holiday_for_department` varchar(50) DEFAULT NULL,
  `holiday_year` varchar(100) DEFAULT NULL,
  `holiday_start_date` varchar(100) DEFAULT NULL,
  `holiday_end_date` varchar(100) DEFAULT NULL,
  `holiday_total_day` varchar(100) DEFAULT NULL,
  `holiday_type` varchar(100) DEFAULT NULL,
  `comments` text,
  `created_time` varchar(100) DEFAULT NULL,
  `updated_time` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `emp_yearlyholiday` */

/*Table structure for table `employee_id` */

DROP TABLE IF EXISTS `employee_id`;

CREATE TABLE `employee_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(32) NOT NULL DEFAULT '0',
  `author` int(32) NOT NULL DEFAULT '1',
  `created` varchar(50) DEFAULT NULL,
  `updated` varchar(50) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `password` varchar(100) DEFAULT NULL,
  `logged_status` int(2) DEFAULT NULL,
  `last_accessed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `employee_id` */

insert  into `employee_id`(`id`,`emp_id`,`author`,`created`,`updated`,`status`,`password`,`logged_status`,`last_accessed`) values 
(1,'000000085',1,'01-01-2022 14:39:56','14-03-2022 13:08:14',1,NULL,NULL,NULL),
(2,'000000219',1,'10-02-2022 16:41:45','14-03-2022 13:17:56',1,NULL,NULL,NULL),
(3,'000000309',1,'10-02-2022 17:21:41','14-03-2022 13:36:26',1,NULL,NULL,NULL),
(4,'000000223',1,'13-02-2022 13:30:39','14-03-2022 13:19:09',1,NULL,NULL,NULL),
(5,'000000523',1,'13-02-2022 17:09:35','14-03-2022 13:59:48',1,NULL,NULL,NULL),
(6,'000000093',1,'14-02-2022 11:48:09','14-03-2022 13:09:39',1,NULL,NULL,NULL),
(7,'000000154',1,'15-02-2022 12:17:00','14-03-2022 13:15:44',1,NULL,NULL,NULL),
(8,'000000117',1,'15-02-2022 13:13:15','14-03-2022 14:32:55',1,NULL,NULL,NULL),
(9,'000000149',1,'15-02-2022 14:51:42','14-03-2022 13:14:59',1,NULL,NULL,NULL),
(10,'000000151',1,'16-02-2022 16:46:06','14-03-2022 14:33:46',1,NULL,NULL,NULL),
(11,'000000161',1,'16-02-2022 17:08:19','14-03-2022 14:34:53',1,NULL,NULL,NULL),
(12,'000000173',1,'17-02-2022 12:04:53','14-03-2022 13:38:08',1,NULL,NULL,NULL),
(13,'000000227',1,'17-02-2022 14:12:36','14-03-2022 13:32:26',1,NULL,NULL,NULL),
(14,'000000225',1,'17-02-2022 14:27:41','14-03-2022 15:07:59',1,NULL,NULL,NULL),
(15,'000005009',1,'28-02-2022 16:20:14','14-03-2022 12:57:00',1,NULL,NULL,NULL),
(16,'000000103',1,'28-02-2022 16:33:38','14-03-2022 13:11:36',1,NULL,NULL,NULL),
(17,'000005005',1,'28-02-2022 16:57:18','14-03-2022 14:06:00',1,NULL,NULL,NULL),
(18,'000005008',1,'07-03-2022 13:10:56','14-03-2022 14:10:55',1,NULL,NULL,NULL),
(19,'000000105',1,'07-03-2022 14:35:06','14-03-2022 14:32:01',1,NULL,NULL,NULL),
(20,'000000104',1,'07-03-2022 14:52:04','14-03-2022 13:12:51',1,NULL,NULL,NULL),
(21,'000005007',1,'07-03-2022 16:44:43','14-03-2022 14:08:29',1,NULL,NULL,NULL),
(22,'000000137',1,'07-03-2022 17:06:57','14-03-2022 15:48:57',1,NULL,NULL,NULL),
(23,'000000189',1,'07-03-2022 17:24:08','14-03-2022 15:13:31',1,NULL,NULL,NULL),
(24,'000000228',1,'08-03-2022 10:52:48','14-03-2022 13:34:04',1,NULL,NULL,NULL),
(25,'00005014',1,'08-03-2022 11:17:55','14-03-2022 14:11:47',1,NULL,NULL,NULL),
(26,'000000171',1,'08-03-2022 15:09:40','14-03-2022 15:11:22',1,NULL,NULL,NULL),
(27,'000000158',1,'10-03-2022 10:41:21','14-03-2022 14:27:15',1,NULL,NULL,NULL),
(28,'000000540',1,'13-03-2022 11:06:10','14-03-2022 15:14:35',1,NULL,NULL,NULL),
(29,'000005012',1,'13-03-2022 11:55:02','14-03-2022 15:16:05',1,NULL,NULL,NULL),
(30,'00005015',1,'13-03-2022 12:28:26','14-03-2022 15:18:09',1,NULL,NULL,NULL),
(31,'000005010',1,'13-03-2022 15:40:06','13-03-2022 15:40:06',1,NULL,NULL,NULL),
(32,'000000384',1,'13-03-2022 16:31:14','14-03-2022 14:41:19',1,NULL,NULL,NULL),
(33,'EMP000005011',1,'13-03-2022 17:22:14','14-03-2022 14:31:17',1,NULL,NULL,NULL),
(34,'000005023',1,'14-03-2022 12:44:04','14-03-2022 15:19:03',1,NULL,NULL,NULL),
(35,'000005016',1,'14-03-2022 15:45:05','14-03-2022 15:47:07',1,NULL,NULL,NULL),
(36,'000005013',1,'14-03-2022 16:31:41','14-03-2022 16:31:41',1,NULL,NULL,NULL);

/*Table structure for table `globalsettings` */

DROP TABLE IF EXISTS `globalsettings`;

CREATE TABLE `globalsettings` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `action` text,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `globalsettings` */

/*Table structure for table `hs_hr_country` */

DROP TABLE IF EXISTS `hs_hr_country`;

CREATE TABLE `hs_hr_country` (
  `cou_code` char(2) NOT NULL DEFAULT '',
  `name` varchar(80) NOT NULL DEFAULT '',
  `cou_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hs_hr_country` */

insert  into `hs_hr_country`(`cou_code`,`name`,`cou_name`,`iso3`,`numcode`) values 
('AD','ANDORRA','Andorra','AND',20),
('AE','UNITED ARAB EMIRATES','United Arab Emirates','ARE',784),
('AF','AFGHANISTAN','Afghanistan','AFG',4),
('AI','ANGUILLA','Anguilla','AIA',660),
('AL','ALBANIA','Albania','ALB',8),
('AM','ARMENIA','Armenia','ARM',51),
('AO','ANGOLA','Angola','AGO',24),
('AQ','ANTARCTICA','Antarctica',NULL,NULL),
('AR','ARGENTINA','Argentina','ARG',32),
('AS','AMERICAN SAMOA','American Samoa','ASM',16),
('AT','AUSTRIA','Austria','AUT',40),
('AU','AUSTRALIA','Australia','AUS',36),
('AW','ARUBA','Aruba','ABW',533),
('AZ','AZERBAIJAN','Azerbaijan','AZE',31),
('BB','BARBADOS','Barbados','BRB',52),
('BD','BANGLADESH','Bangladesh','BGD',50),
('BE','BELGIUM','Belgium','BEL',56),
('BF','BURKINA FASO','Burkina Faso','BFA',854),
('BG','BULGARIA','Bulgaria','BGR',100),
('BH','BAHRAIN','Bahrain','BHR',48),
('BI','BURUNDI','Burundi','BDI',108),
('BJ','BENIN','Benin','BEN',204),
('BM','BERMUDA','Bermuda','BMU',60),
('BN','BRUNEI DARUSSALAM','Brunei Darussalam','BRN',96),
('BO','BOLIVIA','Bolivia','BOL',68),
('BR','BRAZIL','Brazil','BRA',76),
('BS','BAHAMAS','Bahamas','BHS',44),
('BT','BHUTAN','Bhutan','BTN',64),
('BV','BOUVET ISLAND','Bouvet Island',NULL,NULL),
('BW','BOTSWANA','Botswana','BWA',72),
('BY','BELARUS','Belarus','BLR',112),
('BZ','BELIZE','Belize','BLZ',84),
('CA','CANADA','Canada','CAN',124),
('CG','CONGO','Congo','COG',178),
('CH','SWITZERLAND','Switzerland','CHE',756),
('CI','COTE D\'IVOIRE','Cote D\'Ivoire','CIV',384),
('CK','COOK ISLANDS','Cook Islands','COK',184),
('CL','CHILE','Chile','CHL',152),
('CM','CAMEROON','Cameroon','CMR',120),
('CN','CHINA','China','CHN',156),
('CO','COLOMBIA','Colombia','COL',170),
('CR','COSTA RICA','Costa Rica','CRI',188),
('CU','CUBA','Cuba','CUB',192),
('CV','CAPE VERDE','Cape Verde','CPV',132),
('CX','CHRISTMAS ISLAND','Christmas Island',NULL,NULL),
('CY','CYPRUS','Cyprus','CYP',196),
('CZ','CZECH REPUBLIC','Czech Republic','CZE',203),
('DE','GERMANY','Germany','DEU',276),
('DJ','DJIBOUTI','Djibouti','DJI',262),
('DK','DENMARK','Denmark','DNK',208),
('DM','DOMINICA','Dominica','DMA',212),
('DO','DOMINICAN REPUBLIC','Dominican Republic','DOM',214),
('DZ','ALGERIA','Algeria','DZA',12),
('EC','ECUADOR','Ecuador','ECU',218),
('EE','ESTONIA','Estonia','EST',233),
('EG','EGYPT','Egypt','EGY',818),
('EH','WESTERN SAHARA','Western Sahara','ESH',732),
('ER','ERITREA','Eritrea','ERI',232),
('ES','SPAIN','Spain','ESP',724),
('ET','ETHIOPIA','Ethiopia','ETH',231),
('FI','FINLAND','Finland','FIN',246),
('FJ','FIJI','Fiji','FJI',242),
('FO','FAROE ISLANDS','Faroe Islands','FRO',234),
('FR','FRANCE','France','FRA',250),
('GA','GABON','Gabon','GAB',266),
('GB','UNITED KINGDOM','United Kingdom','GBR',826),
('GD','GRENADA','Grenada','GRD',308),
('GE','GEORGIA','Georgia','GEO',268),
('GF','FRENCH GUIANA','French Guiana','GUF',254),
('GH','GHANA','Ghana','GHA',288),
('GI','GIBRALTAR','Gibraltar','GIB',292),
('GL','GREENLAND','Greenland','GRL',304),
('GM','GAMBIA','Gambia','GMB',270),
('GN','GUINEA','Guinea','GIN',324),
('GP','GUADELOUPE','Guadeloupe','GLP',312),
('GQ','EQUATORIAL GUINEA','Equatorial Guinea','GNQ',226),
('GR','GREECE','Greece','GRC',300),
('GT','GUATEMALA','Guatemala','GTM',320),
('GU','GUAM','Guam','GUM',316),
('GW','GUINEA-BISSAU','Guinea-Bissau','GNB',624),
('GY','GUYANA','Guyana','GUY',328),
('HK','HONG KONG','Hong Kong','HKG',344),
('HN','HONDURAS','Honduras','HND',340),
('HR','CROATIA','Croatia','HRV',191),
('HT','HAITI','Haiti','HTI',332),
('HU','HUNGARY','Hungary','HUN',348),
('ID','INDONESIA','Indonesia','IDN',360),
('IE','IRELAND','Ireland','IRL',372),
('IL','ISRAEL','Israel','ISR',376),
('IN','INDIA','India','IND',356),
('IQ','IRAQ','Iraq','IRQ',368),
('IR','IRAN, ISLAMIC REPUBLIC OF','Iran, Islamic Republic of','IRN',364),
('IS','ICELAND','Iceland','ISL',352),
('IT','ITALY','Italy','ITA',380),
('JM','JAMAICA','Jamaica','JAM',388),
('JO','JORDAN','Jordan','JOR',400),
('JP','JAPAN','Japan','JPN',392),
('KE','KENYA','Kenya','KEN',404),
('KG','KYRGYZSTAN','Kyrgyzstan','KGZ',417),
('KH','CAMBODIA','Cambodia','KHM',116),
('KI','KIRIBATI','Kiribati','KIR',296),
('KM','COMOROS','Comoros','COM',174),
('KN','SAINT KITTS AND NEVIS','Saint Kitts and Nevis','KNA',659),
('KR','KOREA, REPUBLIC OF','Korea, Republic of','KOR',410),
('KW','KUWAIT','Kuwait','KWT',414),
('KY','CAYMAN ISLANDS','Cayman Islands','CYM',136),
('KZ','KAZAKHSTAN','Kazakhstan','KAZ',398),
('LB','LEBANON','Lebanon','LBN',422),
('LC','SAINT LUCIA','Saint Lucia','LCA',662),
('LI','LIECHTENSTEIN','Liechtenstein','LIE',438),
('LK','SRI LANKA','Sri Lanka','LKA',144),
('LR','LIBERIA','Liberia','LBR',430),
('LS','LESOTHO','Lesotho','LSO',426),
('LT','LITHUANIA','Lithuania','LTU',440),
('LU','LUXEMBOURG','Luxembourg','LUX',442),
('LV','LATVIA','Latvia','LVA',428),
('LY','LIBYAN ARAB JAMAHIRIYA','Libyan Arab Jamahiriya','LBY',434),
('MA','MOROCCO','Morocco','MAR',504),
('MC','MONACO','Monaco','MCO',492),
('MD','MOLDOVA, REPUBLIC OF','Moldova, Republic of','MDA',498),
('MG','MADAGASCAR','Madagascar','MDG',450),
('MH','MARSHALL ISLANDS','Marshall Islands','MHL',584),
('ML','MALI','Mali','MLI',466),
('MM','MYANMAR','Myanmar','MMR',104),
('MN','MONGOLIA','Mongolia','MNG',496),
('MO','MACAO','Macao','MAC',446),
('MQ','MARTINIQUE','Martinique','MTQ',474),
('MR','MAURITANIA','Mauritania','MRT',478),
('MS','MONTSERRAT','Montserrat','MSR',500),
('MT','MALTA','Malta','MLT',470),
('MU','MAURITIUS','Mauritius','MUS',480),
('MV','MALDIVES','Maldives','MDV',462),
('MW','MALAWI','Malawi','MWI',454),
('MX','MEXICO','Mexico','MEX',484),
('MY','MALAYSIA','Malaysia','MYS',458),
('MZ','MOZAMBIQUE','Mozambique','MOZ',508),
('NA','NAMIBIA','Namibia','NAM',516),
('NC','NEW CALEDONIA','New Caledonia','NCL',540),
('NE','NIGER','Niger','NER',562),
('NF','NORFOLK ISLAND','Norfolk Island','NFK',574),
('NG','NIGERIA','Nigeria','NGA',566),
('NI','NICARAGUA','Nicaragua','NIC',558),
('NL','NETHERLANDS','Netherlands','NLD',528),
('NO','NORWAY','Norway','NOR',578),
('NP','NEPAL','Nepal','NPL',524),
('NR','NAURU','Nauru','NRU',520),
('NU','NIUE','Niue','NIU',570),
('NZ','NEW ZEALAND','New Zealand','NZL',554),
('OM','OMAN','Oman','OMN',512),
('PA','PANAMA','Panama','PAN',591),
('PE','PERU','Peru','PER',604),
('PF','FRENCH POLYNESIA','French Polynesia','PYF',258),
('PG','PAPUA NEW GUINEA','Papua New Guinea','PNG',598),
('PH','PHILIPPINES','Philippines','PHL',608),
('PK','PAKISTAN','Pakistan','PAK',586),
('PL','POLAND','Poland','POL',616),
('PN','PITCAIRN','Pitcairn','PCN',612),
('PR','PUERTO RICO','Puerto Rico','PRI',630),
('PT','PORTUGAL','Portugal','PRT',620),
('PW','PALAU','Palau','PLW',585),
('PY','PARAGUAY','Paraguay','PRY',600),
('QA','QATAR','Qatar','QAT',634),
('RE','REUNION','Reunion','REU',638),
('RO','ROMANIA','Romania','ROM',642),
('RU','RUSSIAN FEDERATION','Russian Federation','RUS',643),
('RW','RWANDA','Rwanda','RWA',646),
('SA','SAUDI ARABIA','Saudi Arabia','SAU',682),
('SB','SOLOMON ISLANDS','Solomon Islands','SLB',90),
('SC','SEYCHELLES','Seychelles','SYC',690),
('SD','SUDAN','Sudan','SDN',736),
('SE','SWEDEN','Sweden','SWE',752),
('SG','SINGAPORE','Singapore','SGP',702),
('SH','SAINT HELENA','Saint Helena','SHN',654),
('SI','SLOVENIA','Slovenia','SVN',705),
('SJ','SVALBARD AND JAN MAYEN','Svalbard and Jan Mayen','SJM',744),
('SK','SLOVAKIA','Slovakia','SVK',703),
('SL','SIERRA LEONE','Sierra Leone','SLE',694),
('SM','SAN MARINO','San Marino','SMR',674),
('SN','SENEGAL','Senegal','SEN',686),
('SO','SOMALIA','Somalia','SOM',706),
('SR','SURINAME','Suriname','SUR',740),
('SV','EL SALVADOR','El Salvador','SLV',222),
('SZ','SWAZILAND','Swaziland','SWZ',748),
('TD','CHAD','Chad','TCD',148),
('TG','TOGO','Togo','TGO',768),
('TH','THAILAND','Thailand','THA',764),
('TJ','TAJIKISTAN','Tajikistan','TJK',762),
('TK','TOKELAU','Tokelau','TKL',772),
('TL','TIMOR-LESTE','Timor-Leste',NULL,NULL),
('TM','TURKMENISTAN','Turkmenistan','TKM',795),
('TN','TUNISIA','Tunisia','TUN',788),
('TO','TONGA','Tonga','TON',776),
('TR','TURKEY','Turkey','TUR',792),
('TT','TRINIDAD AND TOBAGO','Trinidad and Tobago','TTO',780),
('TV','TUVALU','Tuvalu','TUV',798),
('TW','TAIWAN, PROVINCE OF CHINA','Taiwan','TWN',158),
('UA','UKRAINE','Ukraine','UKR',804),
('UG','UGANDA','Uganda','UGA',800),
('US','UNITED STATES','United States','USA',840),
('UY','URUGUAY','Uruguay','URY',858),
('UZ','UZBEKISTAN','Uzbekistan','UZB',860),
('VE','VENEZUELA','Venezuela','VEN',862),
('VG','VIRGIN ISLANDS, BRITISH','Virgin Islands, British','VGB',92),
('VI','VIRGIN ISLANDS, U.S.','Virgin Islands, U.s.','VIR',850),
('VN','VIET NAM','Viet Nam','VNM',704),
('VU','VANUATU','Vanuatu','VUT',548),
('WF','WALLIS AND FUTUNA','Wallis and Futuna','WLF',876),
('WS','SAMOA','Samoa','WSM',882),
('YE','YEMEN','Yemen','YEM',887),
('YT','MAYOTTE','Mayotte',NULL,NULL),
('ZA','SOUTH AFRICA','South Africa','ZAF',710),
('ZM','ZAMBIA','Zambia','ZMB',894),
('ZW','ZIMBABWE','Zimbabwe','ZWE',716);

/*Table structure for table `log_maintenence` */

DROP TABLE IF EXISTS `log_maintenence`;

CREATE TABLE `log_maintenence` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `division_id` varchar(100) DEFAULT NULL COMMENT 'company id',
  `department_id` int(7) DEFAULT NULL,
  `content_id` varchar(200) DEFAULT NULL,
  `start_date` varchar(200) DEFAULT NULL,
  `end_date` varchar(200) DEFAULT NULL,
  `weekly_holiday` varchar(12) DEFAULT NULL,
  `late_status` varchar(200) DEFAULT NULL,
  `late_count_time` varchar(200) DEFAULT NULL,
  `half_day_absent_status` varchar(200) DEFAULT NULL,
  `half_day_absent_count_time` varchar(200) DEFAULT NULL,
  `early_status` varchar(200) DEFAULT NULL,
  `early_count_time` varchar(200) DEFAULT NULL,
  `present_status` varchar(200) DEFAULT NULL,
  `reason` text,
  `created_time` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_time` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `reserve1` text,
  `reserve2` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `log_maintenence` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `action` varchar(400) DEFAULT NULL,
  `user_type` varchar(400) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`action`,`user_type`,`status`) values 
(73,'add_daily_attendance','2',0),
(74,'add_edit_profile','2',0),
(75,'add_employee_performance','2',0),
(76,'add_holiday','2',0),
(77,'add_informed','2',0),
(78,'add_leave','2',0),
(79,'add_log_maintenence','2',0),
(80,'view_employee_list','2',0),
(81,'view_monthly_attendance','2',0),
(82,'add_daily_attendance','3',0),
(83,'add_edit_profile','3',0),
(84,'add_employee_performance','3',0),
(85,'add_holiday','3',0),
(86,'add_informed','3',0),
(87,'add_leave','3',0),
(88,'add_log_maintenence','3',0),
(89,'view_employee_list','3',0),
(90,'view_monthly_attendance','3',0),
(91,'add_daily_attendance','4',0),
(92,'add_edit_profile','4',0),
(93,'add_employee_performance','4',0),
(94,'add_holiday','4',0),
(95,'add_informed','4',0),
(96,'add_leave','4',0),
(97,'add_log_maintenence','4',0),
(98,'view_employee_list','4',0),
(99,'view_monthly_attendance','4',0),
(100,'add_daily_attendance','5',0),
(101,'add_edit_profile','5',0),
(102,'add_employee_performance','5',0),
(103,'add_holiday','5',0),
(104,'add_informed','5',0),
(105,'add_leave','5',0),
(106,'add_log_maintenence','5',0),
(107,'view_employee_list','5',0),
(108,'view_monthly_attendance','5',0),
(109,'add_daily_attendance','6',0),
(110,'add_edit_profile','6',0),
(111,'add_employee_performance','6',0),
(112,'add_holiday','6',0),
(113,'add_informed','6',0),
(114,'add_leave','6',0),
(115,'add_log_maintenence','6',0),
(116,'view_employee_list','6',0),
(117,'view_monthly_attendance','6',0),
(118,'add_daily_attendance','7',0),
(119,'add_edit_profile','7',0),
(120,'add_employee_performance','7',0),
(121,'add_holiday','7',0),
(122,'add_informed','7',0),
(123,'add_leave','7',0),
(124,'add_log_maintenence','7',0),
(125,'view_employee_list','7',1),
(126,'view_monthly_attendance','7',1);

/*Table structure for table `permitted_emp` */

DROP TABLE IF EXISTS `permitted_emp`;

CREATE TABLE `permitted_emp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) DEFAULT NULL,
  `emp_content_ids` text,
  `created` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `permitted_emp` */

/*Table structure for table `re_circular` */

DROP TABLE IF EXISTS `re_circular`;

CREATE TABLE `re_circular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` varchar(200) DEFAULT NULL,
  `Start_Date` varchar(200) DEFAULT NULL,
  `Last_Date` varchar(200) DEFAULT NULL,
  `short_description` text,
  `description` text,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `created_time` varchar(200) DEFAULT NULL,
  `reserved1` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `re_circular` */

/*Table structure for table `re_emp_details` */

DROP TABLE IF EXISTS `re_emp_details`;

CREATE TABLE `re_emp_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` varchar(40) DEFAULT NULL,
  `field_repeat` int(32) NOT NULL DEFAULT '0',
  `field_name` varchar(100) DEFAULT NULL,
  `field_value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `re_emp_details` */

/*Table structure for table `re_employee_id` */

DROP TABLE IF EXISTS `re_employee_id`;

CREATE TABLE `re_employee_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(32) NOT NULL DEFAULT '1',
  `created` varchar(50) DEFAULT NULL,
  `updated` varchar(50) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `re_employee_id` */

/*Table structure for table `re_search_field_emp` */

DROP TABLE IF EXISTS `re_search_field_emp`;

CREATE TABLE `re_search_field_emp` (
  `id` int(11) NOT NULL,
  `content_id` varchar(40) DEFAULT NULL,
  `emp_name` varchar(100) DEFAULT NULL,
  `emp_post_id` int(31) DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `dob` varchar(31) DEFAULT NULL,
  `marital_status` varchar(40) DEFAULT NULL,
  `religion` varchar(40) DEFAULT NULL,
  `age` int(31) DEFAULT NULL,
  `distict` varchar(40) DEFAULT NULL,
  `mobile_no` varchar(31) DEFAULT NULL,
  `national_id` varchar(40) DEFAULT NULL,
  `qualification` varchar(300) DEFAULT NULL,
  `total_exp` varchar(200) DEFAULT NULL,
  `apply_date` varchar(200) DEFAULT NULL,
  `interview_date` varchar(200) DEFAULT NULL,
  `interview_time` varchar(200) DEFAULT NULL,
  `circular_id` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `re_search_field_emp` */

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(40) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `role` */

insert  into `role`(`id`,`user_type`,`description`) values 
(1,'Super Admin','This role For Company Owner'),
(2,'Admin','This role for hr section'),
(3,'Department Head','This role for Department head'),
(4,'Employee','This role for individual employee'),
(5,'Account Section','This role for Account Section for payroll'),
(6,'Car Admin','This is Car Manager Role'),
(7,'Division Head',''),
(8,'Store',''),
(9,'Accounts Admin','This role is use for Head of Accounts.'),
(10,'Administrator','This role is use for group Administrator');

/*Table structure for table `search_field_emp` */

DROP TABLE IF EXISTS `search_field_emp`;

CREATE TABLE `search_field_emp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` varchar(40) DEFAULT NULL,
  `type_of_employee` varchar(40) DEFAULT NULL COMMENT '1=Permanent,153=Left,154=on vacation,155=Provisional Period,473=Terminated',
  `emp_id` varchar(40) DEFAULT NULL,
  `emp_name` varchar(100) DEFAULT NULL,
  `emp_division` varchar(10) DEFAULT NULL COMMENT 'emp company id',
  `emp_department` varchar(10) DEFAULT NULL COMMENT 'emp company division id',
  `department_id` int(5) DEFAULT NULL COMMENT 'emp departnment id',
  `emp_post_id` int(31) DEFAULT NULL COMMENT 'emp designation id',
  `grade` varchar(40) DEFAULT NULL COMMENT 'emp grade id',
  `gender` varchar(30) DEFAULT NULL,
  `dob` varchar(31) DEFAULT NULL,
  `marital_status` varchar(40) DEFAULT NULL,
  `religion` varchar(40) DEFAULT NULL,
  `age` int(31) DEFAULT NULL,
  `joining_date` varchar(40) DEFAULT NULL,
  `visa_selling` varchar(40) DEFAULT NULL,
  `pay_type` varchar(40) DEFAULT NULL,
  `distict` varchar(40) DEFAULT NULL,
  `mobile_no` varchar(31) DEFAULT NULL,
  `national_id` varchar(40) DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=unlock;0=locked',
  `deletion_status` tinyint(4) NOT NULL DEFAULT '0',
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_by` int(3) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `search_field_emp` */

insert  into `search_field_emp`(`id`,`content_id`,`type_of_employee`,`emp_id`,`emp_name`,`emp_division`,`emp_department`,`department_id`,`emp_post_id`,`grade`,`gender`,`dob`,`marital_status`,`religion`,`age`,`joining_date`,`visa_selling`,`pay_type`,`distict`,`mobile_no`,`national_id`,`tin`,`status`,`deletion_status`,`updated_at`,`updated_by`,`balance`) values 
(1,'1','1','000000085','Ashrafun Nessa','11','824',846,831,'305','Female','31-12-1972','156','4',49,'17-12-2008',NULL,'207','235','0197238566','2696536939594','031734801591',1,0,'14-03-2022 13:08:15',1,0.00),
(2,'2','1','000000219','Md. Maruf Hossain Khan','11','824',849,858,'305','Male','10-10-1979','156','4',42,'27-09-2010',NULL,NULL,'235','01730031980','2690243833530','868725536102',1,0,'14-03-2022 13:17:56',1,0.00),
(3,'3','1','000000309','Md. Mamunur Rashid','11','824',851,858,'305','Male','02-02-1982','156','4',40,'02-07-2014',NULL,NULL,'235','01711174423','19822694810995915','113379904636',1,0,'14-03-2022 13:36:27',1,0.00),
(4,'4','1','000000223','A.B.M Rakibul Hassan','11','824',854,78,'305','Male','01-10-1976','156','4',45,'06-10-2010',NULL,NULL,'235','01977778030','7300579260','269928436331',1,0,'14-03-2022 13:19:09',1,0.00),
(5,'5','1','000000523','Md. Omar Faruqeu Khan','11','824',848,78,'305','Male','09-07-1971','156','4',50,'11-07-2009',NULL,NULL,'235','01675021902','2814612202','146686433386',1,0,'14-03-2022 13:59:49',1,0.00),
(6,'6','1','000000093','Syed Haider Ali','11','824',848,98,'305','Male','07-06-1977','156','4',44,'01-03-2009',NULL,NULL,'235','01918865008','2699039523385','897829305198',1,0,'14-03-2022 13:09:39',1,0.00),
(7,'7','1','000000154','Md. Mohsin Sikder','11','824',848,98,'305','Male','06-06-1981','156','4',40,'29-04-2010',NULL,NULL,'235','01712097461','3287441277','353674604011',1,0,'14-03-2022 13:15:44',1,0.00),
(8,'8','1','000000117','Mohammad Didarul Haydar Khan','11','824',848,98,'306','Male','12-11-1978','156','4',43,'02-06-2010',NULL,NULL,'235','01714542316','','',1,0,'14-03-2022 14:32:55',1,0.00),
(9,'9','1','000000149','Sabbir Hassanul Islam','11','824',671,98,'305','Male','07-06-1983','156','4',38,'09-02-2019',NULL,NULL,'235','01676265466','2833217876','753378548332',1,0,'14-03-2022 13:14:59',1,0.00),
(10,'10','1','000000151','Md. Rashedul Bashar','11','824',851,836,'305','Male','08-02-1980','156','4',42,'01-03-2010',NULL,NULL,'235','01711073840','7327805417','\'454841149773',1,0,'14-03-2022 14:33:47',1,0.00),
(11,'11','1','000000161','Md. Abu Jafor','11','824',680,836,'305','Male','11-09-1984','156','4',37,'13-05-2010',NULL,NULL,'235','01753966844','','\'159649577063',1,0,'14-03-2022 14:34:53',1,0.00),
(12,'12','1','000000173','Syeda Yasmin','11','824',850,836,'305','Female','31-12-1987','156','4',34,'25-05-2010',NULL,NULL,'235','01727700667','','888256866465',1,0,'14-03-2022 13:38:09',1,0.00),
(13,'13','1','000000227','Reffet Nasreen Lora','11','824',849,836,'306','Female','18-11-1986','156','4',35,'24-08-2010',NULL,NULL,'235','01932341789','5995094322','617048630672',1,0,'14-03-2022 13:32:27',1,0.00),
(14,'14','1','000000225','Md.Torequl Islam','11','824',848,836,'305','Male','11-08-1977','156','4',44,'13-10-2010',NULL,NULL,'235','01710814109','5017151500865','123057884917',1,0,'14-03-2022 15:07:59',1,0.00),
(15,'15','1','000005009','Sabina Yesmin','11','824',854,836,'305','Female','02-05-1977','5','4',44,'07-11-2021',NULL,NULL,'235','01760747587','6408467915','146686433386',1,0,'14-03-2022 12:57:00',1,0.00),
(16,'16','1','000000103','Nusrat Jahan','11','824',850,857,'305','Female','20-03-1982','157','4',39,'03-05-2009',NULL,NULL,'235','01952372664','2639014955016','635991429639',1,0,'14-03-2022 13:11:37',1,0.00),
(17,'17','1','000005005','Mohammad Sharifuzzaman','11','824',848,840,'309','Male','01-01-1982','156','4',40,'16-09-2020',NULL,NULL,'235','01715434168','5912473072501','',1,0,'14-03-2022 14:06:01',1,0.00),
(18,'18','1','000005008','Md. Mamun Or Roshid','11','824',852,858,'306','Male','27-08-1993','156','4',28,'02-11-2021',NULL,NULL,'235','01919050121','19934411989000013','333767238953',1,0,'14-03-2022 14:10:56',1,0.00),
(19,'19','1','000000105','Rubina Yeasmin','11','824',668,55,'307','Female','05-09-1971','156','4',50,'14-05-2009',NULL,NULL,'235','01840187755','2611038835091','',1,0,'14-03-2022 14:32:02',1,0.00),
(20,'20','1','000000104','Korban Ali','11','824',854,557,'309','Male','10-10-1980','156','4',41,'03-05-2009',NULL,NULL,'235','0192107200','','',1,0,'14-03-2022 13:12:51',1,0.00),
(21,'21','1','000005007','Mithun Kumar Sikder ','11','824',849,858,'305','Male','05-10-1987','156','159',34,'18-07-2021',NULL,NULL,'235','01923849732','198726988739318753','452494625756',1,0,'14-03-2022 14:08:30',1,0.00),
(22,'22','1','000000137','Suman Das','11','825',847,98,'305','Male','21-05-1981','156','159',40,'01-12-2009',NULL,NULL,'227','01819330648','1592830126948','',1,0,'14-03-2022 15:48:57',1,0.00),
(23,'23','1','000000189','Md. Shakawat Kibria','11','824',848,98,'305','Male','01-01-1986','156','4',36,'30-06-2010',NULL,NULL,'227','01610401515','1593524219283','\'168347863451',1,0,'14-03-2022 15:13:31',1,0.00),
(24,'24','1','000000228','Nizam Uddin','11','825',848,836,'305','Male','13-03-1987','156','4',34,'30-06-2010',NULL,NULL,'235','01911127020','2692619471082','',1,0,'14-03-2022 13:34:04',1,0.00),
(25,'25','1','00005014','Mr. Satya Priya Barua (Satyajit)	','11','825',847,861,'307','Male','30-01-1974','156','159',48,'26-12-2021',NULL,NULL,'235','01813683979','1592828597786','830781575576',1,0,'14-03-2022 14:11:47',1,0.00),
(26,'26','1','000000171','Md. Joynal Abedin','11','826',848,98,'305','Male','14-12-1976','156','4',45,'26-09-2010',NULL,NULL,'235','01911751950','2695045905491','',1,0,'14-03-2022 15:11:22',1,0.00),
(27,'27','1','000000158','Asma Akter','11','826',847,836,'305','Female','03-08-1981','156','4',40,'18-05-2010',NULL,NULL,'262','01193093584','','',1,0,'14-03-2022 14:27:15',1,0.00),
(28,'28','1','000000540','Mohammad Abul Kalam Azad','11','827',848,836,'305','Male','28-05-1984','156','4',37,'07-11-2019',NULL,NULL,'235','01670617162','1315815551944','\'375223290316',1,0,'14-03-2022 15:14:36',1,0.00),
(29,'29','1','000005012','Mohammed Humayun Kabir','11','827',848,840,'306','Male','21-11-1979','156','4',42,'15-12-2021',NULL,NULL,'235','01819913854','3015123760010','',1,0,'14-03-2022 15:16:05',1,0.00),
(30,'30','155','00005015','Gourab Barau','11','825',848,861,'306','Male','12-01-1985','156','159',37,'01-03-2022',NULL,NULL,'227','01817207490','1594115236869','861396917027',1,0,'14-03-2022 15:18:10',1,0.00),
(31,'31','863','000005010','Farjana Hossain Chowdhury','11','824',854,857,'306','Male','01-01-1996','156','4',26,'21-03-2022',NULL,NULL,'235','01857775682','6902613071','',1,0,NULL,NULL,0.00),
(32,'32','1','000000384','Ayesha Akhter Hira','11','824',849,858,'306','Female','01-01-1986','156','4',36,'01-02-2015',NULL,NULL,'235','01553431189','4418025041219','',1,0,'14-03-2022 14:41:19',1,0.00),
(33,'33','155','EMP000005011','Selim Mia','11','824',848,862,'306','Male','10-11-1990','156','4',31,'19-12-2021',NULL,NULL,'235','01671767341','9125492638','226376847109',1,0,'14-03-2022 14:31:17',1,0.00),
(34,'34','863','000005023','Md. Rasheduzzaman','11','824',848,857,'307','Male','24-06-1990','156','4',31,'08-03-2022',NULL,NULL,'245','01670769007','2359878499','',1,0,'14-03-2022 15:19:04',1,0.00),
(35,'35','1','000005016','Mohammed Shahnewaz Shakil','11','825',848,840,'307','Male','31-12-1984','156','4',37,'01-03-2022',NULL,NULL,'235','01554555485','1594309458759','',1,0,'14-03-2022 15:47:08',1,0.00),
(36,'36','155','000005013','Md. Zahirul Islam Khan ','11','826',848,862,'307','Male','03-11-1990','156','4',31,'02-01-2022',NULL,NULL,'235','01847407533','4165461478','317900242364',1,0,NULL,NULL,0.00);

/*Table structure for table `search_query` */

DROP TABLE IF EXISTS `search_query`;

CREATE TABLE `search_query` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_query` text,
  `user_id` int(11) NOT NULL,
  `table_view` text,
  `per_page` text,
  `search_page` text,
  `search_date` text,
  `month` varchar(20) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Data for the table `search_query` */

insert  into `search_query`(`id`,`search_query`,`user_id`,`table_view`,`per_page`,`search_page`,`search_date`,`month`,`year`) values 
(4,' sfe.content_id !=\'0\'  AND sfe.type_of_employee !=\'153\' AND sfe.type_of_employee !=\'473\'',1,'emp_id','1000','contentwithpagination','08-02-2022',NULL,NULL),
(38,'18',1,'0','24','single_leave','15-03-2022',NULL,NULL);

/*Table structure for table `str_brands` */

DROP TABLE IF EXISTS `str_brands`;

CREATE TABLE `str_brands` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(100) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_brands` */

/*Table structure for table `str_categories` */

DROP TABLE IF EXISTS `str_categories`;

CREATE TABLE `str_categories` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` tinyint(3) DEFAULT NULL,
  `created_by` datetime DEFAULT NULL,
  `updated_at` tinyint(3) DEFAULT NULL,
  `updated_by` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_categories` */

/*Table structure for table `str_items` */

DROP TABLE IF EXISTS `str_items`;

CREATE TABLE `str_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(50) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `category_id` int(7) NOT NULL,
  `brand_id` int(7) DEFAULT NULL,
  `initial_qty` int(5) DEFAULT NULL,
  `initial_price` int(7) DEFAULT NULL,
  `current_qty` int(7) DEFAULT NULL,
  `current_price` int(7) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `min_stock_amt` int(5) DEFAULT NULL,
  `measurement_id` int(7) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_items` */

/*Table structure for table `str_measurements` */

DROP TABLE IF EXISTS `str_measurements`;

CREATE TABLE `str_measurements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(20) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`short_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `str_measurements` */

insert  into `str_measurements`(`id`,`short_name`,`full_name`,`description`,`status`,`created_at`,`created_by`,`updated_at`,`updated_by`) values 
(2,'Pcs','Pices','',1,'2019-07-29 10:57:47',35,'2019-07-29 09:58:27',35),
(3,'Kg','Kilogram','',1,'2019-07-29 10:58:44',35,NULL,NULL),
(4,'Liter','Liter','',1,'2019-07-29 10:59:15',35,NULL,NULL),
(5,'gm','Gram','',1,'2019-10-15 16:10:42',35,'2019-10-15 15:29:52',35);

/*Table structure for table `str_purchase_details` */

DROP TABLE IF EXISTS `str_purchase_details`;

CREATE TABLE `str_purchase_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `item_id` int(7) DEFAULT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `mfg_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `number_of_pack` int(7) DEFAULT NULL,
  `qty_per_pack` int(7) DEFAULT NULL,
  `free_qty` int(7) DEFAULT NULL,
  `total_qty` int(7) DEFAULT NULL,
  `received_qty` int(11) DEFAULT '0',
  `returned_qty` int(11) DEFAULT '0',
  `rate` int(7) DEFAULT NULL,
  `sales_rate` int(7) DEFAULT NULL,
  `discount` int(7) DEFAULT NULL,
  `amount` int(7) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(3) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_purchase_details` */

/*Table structure for table `str_purchase_payment` */

DROP TABLE IF EXISTS `str_purchase_payment`;

CREATE TABLE `str_purchase_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `account_id` int(7) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_purchase_payment` */

/*Table structure for table `str_purchase_receive` */

DROP TABLE IF EXISTS `str_purchase_receive`;

CREATE TABLE `str_purchase_receive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_date` date DEFAULT NULL,
  `purchase_detail_id` int(7) DEFAULT NULL,
  `item_id` int(7) DEFAULT NULL,
  `received_qty` int(7) DEFAULT NULL,
  `received_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_purchase_receive` */

/*Table structure for table `str_purchase_return` */

DROP TABLE IF EXISTS `str_purchase_return`;

CREATE TABLE `str_purchase_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_date` date DEFAULT NULL,
  `purchase_detail_id` int(7) DEFAULT NULL,
  `item_id` int(7) DEFAULT NULL,
  `returned_qty` int(7) DEFAULT NULL,
  `returned_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_purchase_return` */

/*Table structure for table `str_purchases` */

DROP TABLE IF EXISTS `str_purchases`;

CREATE TABLE `str_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_date` date DEFAULT NULL,
  `supplier_id` int(7) DEFAULT NULL,
  `delevired_by` varchar(50) DEFAULT NULL,
  `sub_total` float(10,2) DEFAULT NULL,
  `vat` int(5) DEFAULT NULL,
  `grand_total` float(10,2) DEFAULT NULL,
  `paid_amount` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_purchases` */

/*Table structure for table `str_sales` */

DROP TABLE IF EXISTS `str_sales`;

CREATE TABLE `str_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_date` date NOT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  `amount` double DEFAULT '0',
  `discount_percentage` double DEFAULT '0',
  `discount_amount` double DEFAULT '0',
  `tax_percentage` double DEFAULT '0',
  `tax_amount` double DEFAULT '0',
  `tax_description` varchar(100) DEFAULT NULL,
  `final_amount` double DEFAULT '0',
  `payment` double DEFAULT '0',
  `balance` double DEFAULT '0',
  `status` tinyint(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` tinyint(3) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` tinyint(3) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_sales` */

/*Table structure for table `str_sales_delivered` */

DROP TABLE IF EXISTS `str_sales_delivered`;

CREATE TABLE `str_sales_delivered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  `sales_id` int(9) DEFAULT NULL,
  `sales_detail_id` int(11) DEFAULT NULL,
  `item_id` int(5) DEFAULT NULL,
  `delivered_qty` int(5) DEFAULT '0',
  `delivered_by` int(3) DEFAULT NULL,
  `received_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `str_sales_delivered` */

/*Table structure for table `str_sales_details` */

DROP TABLE IF EXISTS `str_sales_details`;

CREATE TABLE `str_sales_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) NOT NULL,
  `item_id` int(7) NOT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `order_qty` int(5) NOT NULL DEFAULT '0',
  `delivered_qty` int(5) DEFAULT '0',
  `returned_qty` int(5) DEFAULT '0',
  `purchasing_price` double DEFAULT '0',
  `sales_price` double DEFAULT '0',
  `amount` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_sales_details` */

/*Table structure for table `str_sales_return` */

DROP TABLE IF EXISTS `str_sales_return`;

CREATE TABLE `str_sales_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_id` int(10) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `sales_id` int(9) DEFAULT NULL,
  `sales_detail_id` int(11) DEFAULT NULL,
  `item_id` int(5) DEFAULT NULL,
  `returned_qty` int(5) DEFAULT '0',
  `returned_by` varchar(20) DEFAULT NULL,
  `received_by` int(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `str_sales_return` */

/*Table structure for table `str_suppliers` */

DROP TABLE IF EXISTS `str_suppliers`;

CREATE TABLE `str_suppliers` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `image` varchar(500) DEFAULT NULL,
  `supplier_name` varchar(200) NOT NULL,
  `contact_person` varchar(20) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `national_id` varchar(100) DEFAULT NULL,
  `initial_balance` float(10,2) DEFAULT '0.00',
  `balance` float(10,2) DEFAULT '0.00',
  `note` varchar(100) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` tinyint(3) DEFAULT NULL,
  `created_by` datetime DEFAULT NULL,
  `updated_at` tinyint(3) DEFAULT NULL,
  `updated_by` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `str_suppliers` */

/*Table structure for table `taxonomy` */

DROP TABLE IF EXISTS `taxonomy`;

CREATE TABLE `taxonomy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vid` int(11) NOT NULL DEFAULT '0',
  `tid` int(50) NOT NULL DEFAULT '0',
  `name` text,
  `description` text,
  `parents_term` text,
  `weight` text,
  `url_path` text,
  `page_title` text,
  `page_description` text,
  `keywords` text,
  `status` tinyint(3) DEFAULT '1',
  `reserved1` text,
  `reserved2` text,
  `reserved3` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=utf8;

/*Data for the table `taxonomy` */

insert  into `taxonomy`(`id`,`vid`,`tid`,`name`,`description`,`parents_term`,`weight`,`url_path`,`page_title`,`page_description`,`keywords`,`status`,`reserved1`,`reserved2`,`reserved3`) values 
(1,4,1,'Permanent','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(3,5,3,'MSc','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(4,6,4,'Islam','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(5,7,5,'Single','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(6,8,6,'A+','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(7,11,7,'Dhaka North','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(8,12,8,'Barguna','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(9,10,9,'State bank of India','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(10,9,10,'Bank','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(11,1,11,'IIDFC Securities Limited','Tst','','100','','982338','','IIDFC',1,NULL,NULL,NULL),
(13,13,13,'Add Edit Profile','add_edit_profile','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(30,3,30,'CORP. FINANCE MANAGER','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(31,3,31,'MANAGER (CASH)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(32,3,32,'TECHNICAL MANAGER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(33,3,33,'MANAGER ESTATE','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(34,3,34,'EXECUTIVE SECRETERY','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(35,3,35,'GENERAL MANAGER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(36,3,36,'Asst. Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(37,3,37,'Ministry Co-ordinator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(38,3,38,'EMBASSY COORDINATOR','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(39,3,39,'Medical Officer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(40,3,40,'PROTOCOL OFFICER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(41,3,41,'OFFICE EXECUTIVE','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(42,3,42,'TRANSPORT OFFICER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(43,3,43,'Medical Co-ordinator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(44,3,44,'EXECUTIVE (HR)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(45,3,45,'Accounts Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(46,3,46,'Executive (Accounts)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(47,3,47,'VISA COORDINATOR','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(48,3,48,'CONTRACT CO -ORDINATOR','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(49,3,49,'Sr. Executive  (Manpower)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(50,3,50,'FLIGHT COORDINATOR','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(51,3,51,'Head Of Development','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(52,3,52,'EXECUTIVE','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(53,3,53,'FRONT DESK EXECUTIVE','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(54,3,54,'FRONT DESK EXECUTIVE & PRO','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(55,3,55,'FRONT DESK OFFICER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(56,3,56,'DRIVER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(57,3,57,'SECURITY GUARD OFFICE','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(58,3,58,'SECURITY GUARD GAZIPUR','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(59,3,59,'SECURITY GUARD KUAKATA','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(60,3,60,'SECURITY GUARD ASHULIA','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(61,3,61,'GARDENER','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(62,3,62,'GARDENER NORSHINGDI','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(63,3,63,'Caretaker Norshingdi','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(64,3,64,'Carpenter','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(65,3,65,'Cleaner','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(66,3,66,'OFFICE BOY','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(67,3,67,'Group Vice President','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(68,3,68,'Division Head','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(70,3,70,'Sr. Accounts Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(71,3,71,'Deport In Charge','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(72,3,72,'Territory Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(73,3,73,'Asst. Territory Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(74,3,74,'Marketing Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(75,3,75,'Pick-up Asst','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(76,3,76,'Depot.Asst','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(77,3,77,'Office Peon','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(78,3,78,'Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(79,3,79,'Sr. Sales Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(80,3,80,'Accountant','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(81,3,81,'Sales Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(82,3,82,'Factory Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(83,3,83,'Executive (Accounts & Vat)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(84,3,84,'Chemist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(85,3,85,'Machine In - Charge','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(86,3,86,'Sr. Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(87,3,87,'Print Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(88,3,88,'Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(89,3,89,'Office Assiatant','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(90,3,90,'Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(91,3,91,'Asst. Printing Operation','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(92,3,92,'Packer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(93,3,93,'Packing','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(94,3,94,'Vice President','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(95,3,95,'Director (Oil &Gas)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(96,3,96,'Director Operation','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(97,3,97,'Executive (Sales & Marketing)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(98,3,98,'Deputy Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(99,3,99,'Sr. Asst. Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(100,3,100,'Quality Control Engineer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(101,3,101,'Junior Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(102,3,102,'Executive (Procurement)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(103,3,103,'Consultant','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(104,3,104,'Asst.Factory Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(105,3,105,'Junior Executive (Accounts)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(106,3,106,'Store In-charge','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(107,3,107,'Technician Supervisor','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(108,3,108,'Block Plant Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(109,3,109,'Plant Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(110,3,110,'Lab Technician','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(111,3,111,'Machanics','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(112,3,112,'Pay Loader Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(113,3,113,'Fork Lift Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(114,3,114,'Mix Truck Driver','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(115,3,115,'Batching Plant Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(116,3,116,'Pump Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(117,3,117,'SECURITY GUARD','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(118,3,118,'Cook','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(119,3,119,'Peon','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(120,3,120,'Electrician','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(121,3,121,'Plant Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(122,3,122,'Lab Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(123,3,123,'General Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(124,3,124,'Pick-up Driver','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(125,3,125,'Block Plant Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(126,3,126,'Batching Plant Helper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(127,3,127,'Pathologist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(129,3,129,'Medical Technologist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(130,3,130,'Dark room Technologist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(131,3,131,'Blood Collector','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(132,3,132,'Sweepers','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(133,3,133,'Biochemist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(134,3,134,'Head Of Implementation','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(135,3,135,'Senior Programmer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(136,3,136,'Junior Programmer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(137,3,137,'Trainee Programmer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(138,3,138,'Maintenance','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(139,3,139,'Data Entry Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(140,3,140,'Programmer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(141,3,141,'Project Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(142,3,142,'Asst Accountant','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(143,3,143,'Procurement Executive','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(144,3,144,'Computer Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(145,3,145,'Deputy Chief Accountant','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(146,3,146,'Assistant Manager (Sales & Marketing)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(147,3,147,'Quantity & Quality Surveyor','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(148,3,148,'Supervisor of HR','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(149,10,149,'Dutch Bangla Bank Ltd','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(150,10,150,'Trust Bank','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(151,10,151,'South East Bank','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(152,10,152,'Islami bank bd','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(153,4,153,'Left','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(154,4,154,'On Vacation','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(155,4,155,'Provisional Period','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(156,7,156,'Married','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(157,7,157,'Divorced','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(158,7,158,'Widow','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(159,6,159,'Hindu','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(160,6,160,'Buddhist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(161,6,161,'Christian','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(162,6,162,'Unknown','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(163,5,163,'BSc','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(164,5,164,'MBA','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(165,5,165,'BBA','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(166,5,166,'BA','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(167,5,167,'HSc','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(168,5,168,'SSc','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(169,5,169,'Diploma in Engineering','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(170,5,170,'MSS','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(171,5,171,'BSS','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(172,5,172,'Class Ten','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(173,5,173,'Class Eight','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(174,5,174,'Class Five','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(175,5,175,'Class Three','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(176,5,176,'B.Sc Engineering, BUET','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(177,5,177,'Post Graduation','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(178,5,178,'Graduation','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(179,5,179,'CA','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(180,5,180,'Diploma','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(181,5,181,'M.A','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(182,5,182,'Honors','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(183,5,183,'Class Six','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(184,5,184,'B.Com','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(185,5,185,'BA (PASS)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(186,5,186,'BBS(Hons)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(187,8,187,'A−','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(188,8,188,'B+','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(189,8,189,'B−','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(190,8,190,'AB+','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(191,8,191,'AB−','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(192,8,192,'O+','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(193,8,193,'O−','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(194,10,194,'Al-Arafah Islami Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(195,10,195,'Shahjalal islami Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(196,10,196,'ICB Islamic Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(197,10,197,'Sonali Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(198,10,198,'Janata Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(199,10,199,'Agrani Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(200,10,200,'Rupali Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(201,10,201,'BRAC Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(202,10,202,'IFIC Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(203,10,203,'Pubali Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(204,10,204,'Southeast Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(205,10,205,'Standard Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(206,10,206,'The City Bank Limited','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(207,9,207,'Cash','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(208,9,208,'Cheque','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(209,11,209,'Dhaka South','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(210,11,210,'Chittagong','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(211,11,211,'Khulna','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(212,11,212,'Rajshahi','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(213,11,213,'Sylhet','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(214,11,214,'Barisal','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(215,11,215,'Rangpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(216,11,216,'Gazipur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(217,11,217,'Narayanganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(218,11,218,'Comilla','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(219,12,219,'Barisal','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(220,12,220,'Bhola','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(221,12,221,'Jhalokati','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(222,12,222,'Patuakhali','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(223,12,223,'Pirojpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(224,12,224,'Bandarban','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(225,12,225,'Brahmanbaria','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(226,12,226,'Chandpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(227,12,227,'Chittagong','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(228,12,228,'Comilla','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(229,12,229,'Cox&#39;s Bazar','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(230,12,230,'Feni','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(231,12,231,'Khagrachhari','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(232,12,232,'Lakshmipur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(233,12,233,'Noakhali','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(234,12,234,'Rangamati','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(235,12,235,'Dhaka','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(236,12,236,'Faridpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(237,12,237,'Gazipur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(238,12,238,'Gopalganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(239,12,239,'Jamalpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(240,12,240,'Kishoreganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(241,12,241,'Madaripur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(242,12,242,'Manikganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(243,12,243,'Munshiganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(244,12,244,'Mymensingh','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(245,12,245,'Narayanganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(246,12,246,'Narsingdi','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(247,12,247,'Netrakona','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(248,12,248,'Rajbari','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(249,12,249,'Shariatpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(250,12,250,'Sherpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(251,12,251,'Tangail','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(252,12,252,'Bagerhat','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(253,12,253,'Chuadanga','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(254,12,254,'Jessore','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(255,12,255,'Jhenaidah','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(256,12,256,'Khulna','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(257,12,257,'Kushtia','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(258,12,258,'Magura','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(259,12,259,'Meherpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(260,12,260,'Narail','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(261,12,261,'Satkhira','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(262,12,262,'Bogra','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(263,12,263,'Joypurhat','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(264,12,264,'Naogaon','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(265,12,265,'Natore','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(266,12,266,'Chapainawabganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(267,12,267,'Pabna','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(268,12,268,'Rajshahi','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(269,12,269,'Sirajganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(270,12,270,'Dinajpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(271,12,271,'Gaibandha','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(272,12,272,'Kurigram','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(273,12,273,'Lalmonirhat','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(274,12,274,'Nilphamari','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(275,12,275,'Panchagarh','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(276,12,276,'Rangpur','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(277,12,277,'Thakurgaon','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(278,12,278,'Habiganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(279,12,279,'Moulvibazar','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(280,12,280,'Sunamganj','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(281,12,281,'Sylhet','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(282,9,282,'Not Payable','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(283,14,283,'Father','Test','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(284,14,284,'Mother','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(285,14,285,'Son','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(286,14,286,'Daughter','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(287,14,287,'Husband','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(288,14,288,'Brother','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(289,14,289,'Sister','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(290,14,290,'Wife','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(291,14,291,'Others','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(293,2,293,'Accounts','','17','','','','','BCPL',0,NULL,NULL,NULL),
(295,2,295,'Sales & Marketing','','15','','','','','BL',0,NULL,NULL,NULL),
(296,3,296,'Assistant Protocol Officer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(300,2,300,'Lube','','15','0','','','',NULL,0,NULL,NULL,NULL),
(302,2,302,'Front Desk','','16','','','','','BEL',0,NULL,NULL,NULL),
(303,2,303,'Admin','','17','','','','','BCPL',0,NULL,NULL,NULL),
(305,15,305,'Grade 1','This is highest level of employee ','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(306,15,306,'Grade 2','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(307,15,307,'Grade 3','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(308,15,308,'Grade 4','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(309,15,309,'Grade 5','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(310,15,310,'Grade 6','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(311,15,311,'Grade 7','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(312,15,312,'Grade 8','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(313,15,313,'Grade 9','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(314,15,314,'Grade 10','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(315,15,315,'Grade 11','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(316,15,316,'Grade 12','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(317,15,317,'Grade 13','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(318,15,318,'Grade 14','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(319,15,319,'Grade 15','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(320,15,320,'Grade 16','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(321,15,321,'Grade 17','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(322,15,322,'Grade 18','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(323,15,323,'Grade 19','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(324,15,324,'Grade 20','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(325,3,325,'Coordination & Marketing Officer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(326,3,326,'Sales Engineer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(327,3,327,'Sales Executive cum Quality Controller','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(328,3,328,'Executive Accountant','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(329,3,329,'Project Engineer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(330,16,330,'Casual Leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(331,16,331,'Annual Leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(332,16,332,'Medical/Sick Leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(333,16,333,'Maternity Leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(334,16,334,'Paternity Leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(335,16,335,'Compassionate Leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(336,16,336,'Leave without pay','leave_without_pay','0','0',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),
(337,3,337,'Quality Assurance Officer','BCPL Quality Controller','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(338,2,338,'Lab','','17','0','','','','BCPL',0,NULL,NULL,NULL),
(339,17,339,'International Mother Language Day','The holiday is always celebrated on 21 February. Known as Language Movement Day, Martyrs\' Day and \'Shôhid Dibôs\' in Bengali, this holiday commemorates the struggle for the Bengali language in 1952','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(340,17,340,'Sheikh Mujibur Rahmans birthday','This national holiday in Bangladesh is observed on 17 March each year.\n\nThis holiday may also be known as \'Father of the Nation\'s birth anniversary\' and it commemorates the birthday of Sheikh Mujibur Rahman who is regarded as the father of the nation of Bangladesh.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(341,17,341,'Independence Day','This public holiday in Bangladesh is always celebrated on 26 March.\n\nThe holiday celebrates the declaration of the Independence of Bangladesh in 1971. It is the National Holiday of Bangladesh.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(342,17,342,'Bengali New Year','Bengali New Year, also known as \'Pohela Boishakh\' is the first day in the Bengali calendar.\n\nPoila means ‘first’ and Boishakh is first month of the Bengali calendar.\n\nAs Bengali New Year is based on a solar calendar it occurs on 14 April in the Gregorian calendar each year. It is an optional public holiday in Bangladesh and in India in 2018, it a public holiday in Tripura, West Bengal and may be celebrated by Bengali communities elsewhere in India.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(343,17,343,'May Day','May Day is now most commonly associated as a commemoration of the achievements of the labour movement. The holiday may also be known as Labour Day or International Worker\'s Day and is marked with a public holiday in over 80 countries.\n\nThe 1 May date is used because in 1884 the American Federation of Organized Trades and Labor Unions demanded an eight-hour workday, to come in effect as of 1 May 1886. This resulted in the general strike and the Haymarket Riot of 1886, but eventually also in the official sanction of the eight-hour workday. ','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(344,17,344,'Buddha Purnima','Buddha Purnima is the most sacred day in the Buddhist calendar. It is the most important festival of the Buddhists, and is celebrated with great enthusiasm. Although Buddhists regard every full moon as sacred, the moon of the month of Vaisakh has special significance because on this day the Buddha was born, attained enlightenment (nirvana), and attained parinirvana (nirvana-after-death of the body) when he died.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(345,17,345,'Shab e-Barat','Also known as Bara\'at Night, the The Night of Records, Shab e-Barat is a holiday observed on the 14th night of Sha\'aban, the eighth month in the Islamic calendar.\n\nShab e-Barat takes place on the full moon and the date of the public holiday in Bangladesh is dependent on the sighting of the new moon signifying the start of the month of Sha\'aban.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(346,17,346,'Jumatul Bidah','Jumatul Bidah is celebrated on the last Friday in the Islamic month* of Ramadan. It is a public holiday in Bangladesh and a regional holiday in the Indian states of Jammu and Kashmir and Uttarakhand, where it is known as \'Jumat-ul-Wida\'.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(347,17,347,'Night of Destiny','Laylat Al Qadr, also known as \'Shab-e-Qadr\', the \'Night of Destiny\' or the \'Night of Power\' is a public holiday in several countries, observed on the 27th Day of Ramadan, the ninth month in the Islamic calendar.\n\nThis day is considered as the holiest night of the year for Muslims and marks the night that the first verses of the Qur\'an were revealed to the Prophet Mohammed.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(348,17,348,'Eid ul-Fitr','The festival of Eid al-Fitr, the Festival of Fast breaking, marks the end of Ramadan.\n\nRamadan is one of the five pillars of the Islamic faith and is sacred to Muslims as it was during this month that the Qur\'an was revealed to the Prophet Muhammad.\n\nAs the date of Eid depends on the sighting of the moon, there may be variations in the exact date that is celebrated around the world. The announcement of the exact dates of Eid Al-Fitr may not happen until close to the start of Ramadan. ','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(349,17,349,'Eid ul-Fitr Holiday','\'Sawm\', which is fasting during the holy month of Ramadan is one of the five pillars of Islam. Muslims believe that it was during the month of Ramadan that the text of the Qur\'an was revealed to the Prophet Muhammad.\n\nMuslims celebrate Eid by saying prayers, giving money to the poor, sending Eid greetings and feasting with their families.\n\nThe phrase commonly used by Muslims as a greeting on this day is “Eid Mubarak”, which is Arabic for \'blessed festival\'.\n\nThe first Eid al-Fitr was celebrated in 624 CE by the Prophet Muhammad and his companions after their victory in the battle of Jang-e-Badar, a turning point in Muhammad\'s struggle with his opponents among the Quraish in Mecca during in the early days of Islam.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(350,17,350,'National Mourning Day','National Mourning Day is a public holiday in Bangladesh on 15th August.\n\nIt commemorates the murder of Bangabandhu Sheikh Mujibur Rahman, known as the \'Father of the Nation\' on 15 August 1975. ','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(351,17,351,'Janmashtami','Janmashtami is a Hindu festival and a Gazetted holiday in many regions of India.\n\nIt may be known as Sreekrishna Jayanthi in some regions.  ​According to the Hindu calendar, Janmashtami is celebrated on the Ashtami (eighth day) of Krishna Paksha (dark fortnight) in the month of Shravana or Bhadra (in the Hindu calendar, there is a leap month once every three years).\n\nJanmashtami is also a public holiday in Bangladesh.\nOne of the most important Hindu festivals, Janmashtami (Krishna Jayanti) is the birthday of Lord Krishna, the eighth re-incarnation of Lord Vishnu who gave the vital message of the Bhagwat Gita - the guiding principles for every Hindu.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(352,17,352,'Eid ul-Adha','Date varies on Lunar cycle.Known as Eid al-Adha, Eid ul Adha, Id-ul-Azha, Id-ul-Zuha, Hari Raya Haji, Greater Eid or Bakr-id; the \'Feast of Sacrifice\' is the most important feast of the Muslim calendar.\n\nEid al-Adha falls on the 10th day of Dhu al-Hijjah, the twelfth and final month in the Islamic calendar.\n\nAs the exact day is based on lunar sightings, the date may vary between countries.\n\nThe date shown on this page for Eid al-Adha is based on the expected date of Eid al-Adha in Saudi Arabia.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(353,17,353,'Eid ul-Adha Day 2','Eid al-Adha concludes the Pilgrimage to Mecca. Eid al-Adha lasts for three days and commemorates Ibrahim\'s (Abraham) willingness to obey God by sacrificing his son.\n\nThe same story appears in the Bible and is familiar to Jews and Christians. One key difference is that Muslims believe the son was Ishmael rather than Isaac as told in the Old Testament.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(354,17,354,'Eid ul-Adha Day 3','According to the Quran, Ibrahim was about to sacrifice his son when a voice from heaven stopped him and allowed him to make something else as a \'great sacrifice\'. In the Old Testament, it is a ram that is sacrificed instead of the son.\n\nIn Islam, Ishmael is regarded as a prophet and an ancestor of Muhammad.\n\nDuring the feast of Eid Al Adha, Muslims re-enact Ibrahim\'s obedience by sacrificing a cow or ram. The family will eat about a third of the meal a third goes to friends and relatives, and the remaining third is donated to the poor and needy.\n\nThe giving of charity in the form of money, food or clothes to the homeless or poor is another key tradition of Eid al Adha. ','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(355,17,355,'Ashura','The Day of Ashura is the 10th day of Muharram in the Islamic calendar. It marks the \'Remembrance of Muharram\' but not the Islamic month.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(356,17,356,'Eid e-Milad-un Nabi','Birthday of Prophet Muhammad.\nAlso known to Muslims in Malaysia as Maulud Nabi. This is purely a religious festival and is marked as a public holiday.\n\nProphet Muhammad (PBUH) was born on 12 Rabiulawal in 570 AD.\n\nHis birthday is celebrated with religious lectures and recitals of verses from the Koran.\n\nThe basic earliest accounts for the observance of Mawlid can be found in 8th century Mecca, when the house in which Prophet Muhammad (PBUH) was born was transformed into a place of prayer.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(357,17,357,'Victory Day','The holiday is always celebrated on 16 December. Known as \'Bijôy Dibôs\' in Bengali, this holiday commemorates the victory of the Allied forces High Command over the Pakistani forces in the Bangladesh Liberation War in 1971.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(358,17,358,'Christmas Day','Christmas Day celebrates the Nativity of Jesus, the date of which according to tradition took place on 25th December 1 BC.\n\n25 December will be a public holiday in most countries around the world. If 25 December falls on a weekend, then a nearby week day may be taken as a holiday in lieu. For a list of countries who have holidays over the Christmas period, check our 2018 Christmas dates list. ','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(359,18,359,'Quality of Work','','0','1','30%','quality_of_work',NULL,NULL,1,NULL,NULL,NULL),
(360,18,360,'Attendance and Punctuality','','0','2','10%','attendance_and_punctuality',NULL,NULL,1,NULL,NULL,NULL),
(361,18,361,'Job Knowledge and skills','','0','3','10%','job_knowledge_and_skills',NULL,NULL,1,NULL,NULL,NULL),
(362,18,362,'Cooperation','','0','4','5%','cooperation',NULL,NULL,1,NULL,NULL,NULL),
(363,18,363,'Initiative','','0','5','5%','initiative',NULL,NULL,1,NULL,NULL,NULL),
(364,18,364,'Dependability','','0','6','10%','dependability',NULL,NULL,1,NULL,NULL,NULL),
(365,18,365,'Attitude','','0','7','5%','attitude',NULL,NULL,1,NULL,NULL,NULL),
(366,18,366,'Communications (Written and Oral)','','0','8','5%','communications',NULL,NULL,1,NULL,NULL,NULL),
(367,18,367,'Productivity','','0','9','10%','productivity',NULL,NULL,1,NULL,NULL,NULL),
(368,18,368,'Interpersonal Relationships','','0','10','5%','interpersonal_relationships',NULL,NULL,1,NULL,NULL,NULL),
(369,18,369,'Safety','','0','11','5%','safety',NULL,NULL,1,NULL,NULL,NULL),
(370,19,370,'Completes high quality work according to specification with dedication','','359','1','quality_of_work_1438251282_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(371,19,371,'Thoroughly follows standards and procedures','','359','2','quality_of_work_1438251298_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(372,19,372,'Keeps complete record','','359','3','quality_of_work_1438251311_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(373,19,373,'Strong sense of duty and committed to achieve it','','359','4','quality_of_work_1438251324_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(374,19,374,'Promptness at the start of the work day','','360','1','attendance_and_punctuality_1438251351_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(375,19,375,'Attendance record','','360','2','attendance_and_punctuality_1438251373_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(376,19,376,'Stays as late as necessary to complete assignment','','360','3','attendance_and_punctuality_1438251395_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(377,19,377,'Has appropriate knowledge to specific job function','','361','1','job_knowledge_and_skills_1438251431_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(378,19,378,'Has appropriate skills in operating company equipment','','361','2','job_knowledge_and_skills_1438251451_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(379,19,379,'Has appropriate skills and knowledge in working with relevant area','','361','3','job_knowledge_and_skills_1438251475_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(380,19,380,'When new ideas or technologies are introduces, able to learn and use them appropriately','','361','4','job_knowledge_and_skills_1438251529_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(381,19,381,'Willingness to assist colleagues','','362','1','cooperation_1438251568_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(382,19,382,'Attitudes when work needs to be repeated','','362','2','cooperation_1438251588_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(383,19,383,'Adaptability when schedule must be changed','','362','3','cooperation_1438251620_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(384,19,384,'Willingness to work extra hours','','362','4','cooperation_1438251682_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(385,19,385,'Sees when something needs to be done and does it','','363','1','initiative_1438251783_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(386,19,386,'Demonstrates a “self-starter” attitude','','363','2','initiative_1438251798_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(387,19,387,'Seek help when needed','','363','3','initiative_1438251817_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(388,19,388,'Helps out to achieve the overall goals of the company','','363','4','initiative_1438251831_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(389,19,389,'Can be counted on to carry out assignments with careful follow-through and follow-up','','364','1','dependability_1438252047_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(390,19,390,'Meets predetermined targets','','364','2','dependability_1438252320_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(391,19,391,'Can be counted on to overcome obstacles to meet goals','','364','3','dependability_1438252344_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(392,19,392,'Can be counted on to adapt to changes as necessary','','364','4','dependability_1438252363_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(393,19,393,'Can be counted on for consistent performance','','364','5','dependability_1438252404_5',NULL,NULL,NULL,1,NULL,NULL,NULL),
(394,19,394,'Personally accountable for his/her actions','','364','6','dependability_1438252424_6',NULL,NULL,NULL,1,NULL,NULL,NULL),
(395,19,395,'Offers assistance willingly whenever needed','','365','1','attitude_1438252449_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(396,19,396,'Makes a positive contribution to morale','','365','2','attitude_1438252529_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(397,19,397,'Shows sensitivity to and consideration for others’ feelings','','365','3','attitude_1438252551_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(398,19,398,'Accepts constructive criticism positively','','365','4','attitude_1438252565_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(399,19,399,'Keeps company manager informed of work','','366','1','communications_1438252693_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(400,19,400,'Reports necessary information','','366','2','communications_1438252711_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(401,19,401,'Keeps and maintains all necessary written information that might e required by a specific assignment','','366','3','communications_1438252727_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(402,19,402,'Completion of work in his given duties effectively','','367','1','productivity_1438252749_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(403,19,403,'Can be counted on for extra efforts as needed to meet the company’s goals, ability to work under pressure','','367','2','productivity_1438252766_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(404,19,404,'Maintains a positive relationship with the management','','368','1','interpersonal_relationships_1438252817_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(405,19,405,'Maintains a positive relationship with other colleagues','','368','2','interpersonal_relationships_1438252833_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(406,19,406,'Listens effectively','','368','3','interpersonal_relationships_1438252856_3',NULL,NULL,NULL,1,NULL,NULL,NULL),
(407,19,407,'Participates with others to accomplish the task at hand','','368','4','interpersonal_relationships_1438252899_4',NULL,NULL,NULL,1,NULL,NULL,NULL),
(408,19,408,'Follow safety rules','','369','1','safety_1438252917_1',NULL,NULL,NULL,1,NULL,NULL,NULL),
(409,19,409,'Encourages safety of others on a regular basis, recognizes unsafe working conditions; suggests new safety standards as appropriate','','369','2','safety_1438252937_2',NULL,NULL,NULL,1,NULL,NULL,NULL),
(410,3,410,'Director','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(411,3,411,'Advisor','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(412,2,412,'IT','','18','0','','','','BDCL',0,NULL,NULL,NULL),
(413,2,413,'Business Development','','18','0','','','','BDCL',0,NULL,NULL,NULL),
(414,2,414,'HR','','18','0','','','','BDCL',0,NULL,NULL,NULL),
(415,2,415,'Solar','','304','0','','','',NULL,0,NULL,NULL,NULL),
(416,3,416,'Supervisor (General Service)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(417,3,417,'Assistant Supervisor (General Service)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(418,3,418,'Assistant Project Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(419,3,419,'Site Engineer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(420,3,420,'Site Supervisor','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(421,3,421,'Junior Site Engineer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(422,3,422,'Mixer Machine Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(423,3,423,'Store Keeper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(424,2,424,'Depot.','','15','0','','','',NULL,0,NULL,NULL,NULL),
(426,3,426,'Assistant Manager (Commercial)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(427,3,427,'Assistant Territory Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(428,3,428,'Chief Operating Officer (COO)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(429,3,429,'Senior Officer (Recruitment)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(432,3,432,'Project Coordinator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(434,3,434,'Motor Pool Coordinator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(435,3,435,'Assistant Technician','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(436,2,436,'Development','','20','0','','','','Med',0,NULL,NULL,NULL),
(437,3,437,'Nurse','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(438,3,438,'Assistant Programmer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(439,3,439,'Asst. Programmer (.Net)','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(440,3,440,'Net Programmer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(441,3,441,'Implement Manager','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(442,3,442,'System Administrator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(443,3,443,'Pharmacist','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(444,2,444,'Accounts','','16','','','','','BEL',0,NULL,NULL,NULL),
(445,16,445,'Adjust late with leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(446,16,446,'1/2 day leave','Deduct from total leave.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(448,2,448,'Accounts','','20','0','','','','COC',0,NULL,NULL,NULL),
(450,3,450,'Financial Cost Analyst','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(451,2,451,'Accounts','','21','66','','','','BPL',0,NULL,NULL,NULL),
(452,2,452,'Sales & Marketing','','14','0','','','','CTI',0,NULL,NULL,NULL),
(453,2,453,'Accounts','','14','0','','','','CTI',0,NULL,NULL,NULL),
(454,2,454,'Admin','','14','0','','','','CTI',0,NULL,NULL,NULL),
(455,2,455,'Admin','','18','0','','','','BDCL',0,NULL,NULL,NULL),
(456,2,456,'Transport','','18','0','','','','BDCL',0,NULL,NULL,NULL),
(457,2,457,'Admin','','16','','','','','BEL',0,NULL,NULL,NULL),
(458,2,458,'Production','','17','0','','','','BCPL',0,NULL,NULL,NULL),
(459,2,459,'Construction','','21','0','','','','BPL',0,NULL,NULL,NULL),
(460,2,460,'Admin','','21','0','','','','BPL',0,NULL,NULL,NULL),
(461,2,461,'Front Desk','','21','0','','','','BPL',0,NULL,NULL,NULL),
(463,2,463,'Admin','','304','0','','','','BREL',0,NULL,NULL,NULL),
(464,2,464,'Admin','','20','0','','','','Med',0,NULL,NULL,NULL),
(465,2,465,'Sales & Marketing','','16','','','','','BEL',0,NULL,NULL,NULL),
(466,2,466,'Store','','16','','','','','BEL',0,NULL,NULL,NULL),
(467,3,467,'Asst. Store Keeper','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(469,3,469,'Asst. Plant Operator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(470,2,470,'Transport','','16','','','','','BEL',0,NULL,NULL,NULL),
(471,3,471,'Welder','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(472,3,472,'Labour','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(473,4,473,'Terminated','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(474,2,474,'Front Desk','','14','233','','','','CTI',0,NULL,NULL,NULL),
(475,2,475,'Transport','','14','233','','','','CTI',0,NULL,NULL,NULL),
(476,2,476,'Admin','','23','0','Ashulia, Uttara, Dhaka','','','MTI',0,NULL,NULL,NULL),
(477,2,477,'Accounts','','23','0','','','','MTI',0,NULL,NULL,NULL),
(478,2,478,'Training & Development','','23','0','','','','MTI',0,NULL,NULL,NULL),
(479,20,479,'Fuel','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(480,20,480,'Insurance Cost','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(481,20,481,'Tax Cost','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(482,20,482,'Maintenance and Repair ','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(483,17,483,'Durga Puja','Durga Puja, also known as Durgotsava or Mahashtami, is a Hindu festival in South Asia that celebrates the worship of the goddess Durga.\n\nDurga Puja celebrates the ten-armed mother goddess, and her victory over the evil buffalo demon Mahishasura.','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(484,3,484,'Instructor','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(485,3,485,'Demonstrator','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(486,2,486,'Accounts','','15','44','','','','Lube',0,NULL,NULL,NULL),
(487,2,487,'Admin','','15','44','','','','Lube',0,NULL,NULL,NULL),
(488,13,488,'View Employee List','view_employee_list','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(489,13,489,'Add Employee Performance','add_employee_performance','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(490,13,490,'Add Daily Attendance','add_daily_attendance','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(491,13,491,'Add Informed','add_informed','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(492,13,492,'Add Log Maintenence','add_log_maintenence','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(493,13,493,'Add Leave','add_leave','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(494,13,494,'Add Holiday','add_holiday','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(495,13,495,'View Monthly Attendance','view_monthly_attendance','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(496,13,496,'View Salary In Emp List','view_salary_in_emp_list','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(497,2,497,'Accounts','','301','0','','','','NMS',0,NULL,NULL,NULL),
(498,2,498,'Admin','','301','0','','','','NMS',0,NULL,NULL,NULL),
(499,2,499,'Front Desk','','301','0','','','','NMS',0,NULL,NULL,NULL),
(500,2,500,'Medical','','301','0','','','','NMS',0,NULL,NULL,NULL),
(501,2,501,'Data Entry ','','301','0','','','','NMS',0,NULL,NULL,NULL),
(502,3,502,'Chief Medical Officer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(503,3,503,'Asst. Lab Technician','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(504,3,504,'X-Ray Technician','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(505,3,505,'Document Officer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(506,3,506,'Radiographer','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(507,5,507,'MBBS','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(508,2,508,'Transport','','15','0','','','','Auto',0,NULL,NULL,NULL),
(509,3,509,'Senior Technician','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(510,2,510,'Store','','23','0','','','','MTI',0,NULL,NULL,NULL),
(511,3,511,'Payloader Driver','','0','0',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(512,2,512,'IT','','301','258','','','','NMS',0,NULL,NULL,NULL),
(513,2,513,'Lab','','301','258','','','','NMS',0,NULL,NULL,NULL),
(515,3,515,'Liverman','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(516,3,516,'Loskor','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(517,3,517,'Asst. Driver','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(520,3,520,'Supervisor','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(521,3,521,'Sr. Technician','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(523,2,523,'Procurement','','21','','','','','BPL',0,NULL,NULL,NULL),
(524,3,524,'Reservation & Ticketing Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(525,2,525,'Reservation & Ticketing','','14','','','','','CTI',0,NULL,NULL,NULL),
(526,3,526,'Lab Technologist','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(527,13,527,'Edit View Login Profile','edit_view_login_profile',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(528,13,528,'View Attendance Reports Multiple','view_attendance_reports_multiple',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(529,13,529,'View Attendance Summery Reports','view_attendance_summery_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(530,13,530,'View Daily Attendance Reports','view_daily_attendance_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(531,13,531,'View Daily Late Reports','view_daily_late_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(532,13,532,'View Daily Early Reports','view_daily_early_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(533,13,533,'View Daily Absent Reports','view_daily_absent_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(534,13,534,'View Absent Reports Single','view_absent_reports_single',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(535,13,535,'View Daily Leave Reports','view_daily_leave_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(536,13,536,'View Single Leave Reports','view_single_leave_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(537,13,537,'View Leave Summery Reports','view_leave_summery_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(538,13,538,'View Attendance Informed Reports','view_attendance_informed_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(539,13,539,'View Attendance Log Reports','view_attendance_log_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(540,13,540,'VIew Salary History','view_salary_history',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(541,13,541,'View Salary History Multiple','view_salary_history_multiple',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(542,13,542,'View Job History','view_job_history',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(543,13,543,'View Resume','view_resume',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(544,13,544,'View Holiday Reports','view_holiday_reports',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(545,3,545,'IT Executive','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(546,17,546,'Annual Picnic','Annual Picnic holiday',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(547,3,547,'Sr. Executive (MIS)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(548,3,548,'Manpower Coordinator','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(549,3,549,'Plumber','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(550,3,550,'Mechanical Engineer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(552,2,552,'Front Desk','','551','','','','','Cut',0,NULL,NULL,NULL),
(553,2,553,'Admin','','551','','','','','Cut',0,NULL,NULL,NULL),
(554,2,554,'Accounts ','','551','','','','','Cut',0,NULL,NULL,NULL),
(555,2,555,'Massage ','','551','','','','','Cut',0,NULL,NULL,NULL),
(556,2,556,'Cutting','','551','','','','','Cut',0,NULL,NULL,NULL),
(557,3,557,'Massage Man ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(558,3,558,'Cutter','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(562,13,562,'View Attendance Wise Employee','view_attendance_wise_employee',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(563,13,563,'Import Attendance','import_attendance',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(564,3,564,'Pipe fitter','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(565,3,565,'Greaser','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(566,3,566,'Dredger Master','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(567,3,567,'Assistant Liverman','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(568,3,568,'Labour Sarder','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(569,3,569,'Master To WorkBoat','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(570,3,570,'Assistant Sales Executive','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(571,3,571,'Inkjet Printer Helper','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(572,3,572,'Interpreter','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(573,3,573,'Administrative Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(574,3,574,'Public Relation  Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(575,3,575,'Trainee','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(576,3,576,'Factory Accountant','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(577,3,577,'Imam (Factory Masque)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(578,3,578,'Director (Oil & Gas)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(579,3,579,'Manager (Planning)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(580,3,580,'Manager (Construction)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(581,3,581,'Assistant Manager Accounts (Tax & Vat)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(582,3,582,'Training Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(583,3,583,'Assistant Co-Ordinator','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(584,2,584,'Admin','','24','','','','','AAG',0,NULL,NULL,NULL),
(585,3,585,' Business Development & Operation','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(586,3,586,'Assistant General Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(587,16,587,'Leave with pay','leave_with_pay',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),
(588,3,588,'Assistant DGM','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(589,3,589,'Coordination Office','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(590,3,590,'Coordination Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(591,3,591,'GM (Marketing Block)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(592,3,592,'DGM Finance','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(593,3,593,'Logistic Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(594,16,594,'Special Leave','This leave is used for special causes with pay from management approval. Don\'t deduct from total leave.',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(595,3,595,'Advocate','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(596,3,596,'Chief Financial Office (CFO)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(597,3,597,'Financial analyst','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(598,3,598,'Internal Auditor','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(599,3,599,'Computer Executive','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(601,3,601,'Construction Project Manager ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(602,16,602,'Holiday Leave','Deduct from total leave.',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(603,17,603,'Official Holiday','It\'s defendant on official decision. ',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(605,3,605,'Planning Engineer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(606,3,606,'Site Engineer (Civil)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(607,3,607,'Manager Vat & Tax','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(608,3,608,'Representative','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(609,3,609,'Manager Tax & Vat','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(610,3,610,'Asst Project Manager (Security)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(611,3,611,'Site Engineer (Mechanical)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(612,2,612,'Land Project','','16','','','','','BEL',0,NULL,NULL,NULL),
(613,3,613,'Deputy Manager (Finance & Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(614,2,614,'Maritime University Project','','16','','','','','BEL',0,NULL,NULL,NULL),
(615,3,615,'GM (Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(616,16,616,'Election Leave','Deduct from total leave.',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(617,17,617,'Election Holiday','This holiday apply for local/ National election.',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(618,3,618,'Tecnecial Consaltant ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(619,3,619,'Technical consultant','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(621,3,621,'Lab In- Charge','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(622,3,622,'Manager(Finance & Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(623,3,623,'Ware House In-Charge','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(624,16,624,'Adjust with leave','It\'s adjust with future annual leave or provision period or others ',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(625,3,625,'Deputy Chief Engineer ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(626,3,626,'Quality Control Manager (QCM) ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(627,3,627,'Executive-(Finance & Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(628,13,628,'Edit Payroll','edit_payroll',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(629,13,629,'View payroll','view_payroll',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(630,13,630,'View Statement','view_statement',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(631,3,631,'Interpreter/ Translator (Arabic, English & Bengali)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(633,3,633,'Manager,Civil Construction','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(634,3,634,'Electrical Site Engineer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(635,3,635,'HSE Engineer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(636,3,636,'Project Assistant/Document Control Executive','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(637,3,637,'Executive Director','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(638,13,638,'View employee profile','view_employee_profile',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(639,13,639,'Genarate Pay Slip','genarate_pay_slip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(640,13,640,'Confirm Pay Slip','confirm_pay_slip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(641,13,641,'Payment Pay Slip','payment_pay_slip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(642,13,642,'Edit Pay Slip','edit_pay_slip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(643,13,643,'Add Loan Given','add_loan_given',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(644,13,644,'Add Loan Repayment','add_loan_repayment',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(645,13,645,'View Pay Slip','view_pay_slip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(646,13,646,'View Salary Statement','view_salary_statement',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(648,2,648,'Admin','','647','','','','','Admin',0,NULL,NULL,NULL),
(649,3,649,'Counter Executive','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(651,3,651,'Assistant Co - Ordinator','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(652,3,652,'Document Specialist','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(653,3,653,'Manager (E & I Construction)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(654,3,654,'Manager Procurement','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(655,3,655,'Deputy Construction Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(656,3,656,'Document Control','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(657,3,657,'QA/QC Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(658,3,658,'Assistant Site Engineer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(659,3,659,'Manager (Planning & Operation)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(660,22,660,'Accounts','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(661,22,661,'Accounts(Cash)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(662,22,662,'Admin','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(663,22,663,'HR','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(664,22,664,'IT','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(665,22,665,'Store','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(666,22,666,'Transport','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(667,22,667,'Data Entry','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(668,22,668,'Front Desk','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(669,22,669,'Sales & Marketing','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(670,22,670,'Development','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(671,22,671,'Business Development','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(672,22,672,'Lab','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(673,22,673,'Production','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(674,22,674,'Protocol','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(675,22,675,'Procurement','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(676,22,676,'Man Power','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(677,22,677,'Visa','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(678,22,678,'Medical','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(679,22,679,'Constuction','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(680,22,680,'Training & Development','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(681,22,681,'Reservation & Ticketing','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(682,22,682,'Massage','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(683,22,683,'Cutting','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(684,22,684,'Solar','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(699,3,699,'Director (Operation & Planning)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(700,3,700,'Director  (Planning & Operation)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(701,13,701,'View employee mobile number','view_employee_mobile_number',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(702,13,702,'view employee email address','view_employee_email_address',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(703,13,703,'view employee date of birth','view_employee_date_of_birth',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(704,13,704,'view employee age','view_employee_age',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(705,3,705,'Technical Advisor (Oil & Gas)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(706,22,706,'LPG','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(707,3,707,'Deputy General Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(708,3,708,'Security guard (Mongla LPG Project)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(709,3,709,'Manager Admin','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(712,3,712,'Fitter Man','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(713,3,713,'Sukani','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(715,3,715,'Navigational Expert','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(716,3,716,'Deputy General Manager (DGM)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(717,3,717,'Assistant Manager (Finance & Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(718,3,718,'Assistant Manager (Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(719,3,719,'Assistant Manager (MIS)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(720,13,720,'Print Attendance','print_attendance',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(721,3,721,'Assistant Manager (Airport Operation)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(722,3,722,'Office Assistant','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(723,3,723,'Security Guard Land Project Saver','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(724,3,724,'Security Guard (Land Project Saver)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(725,13,725,'Check Payslip','check_payslip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(726,13,726,'Approve Payslip','approve_payslip',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(727,13,727,'Add Loan Type','add_loan_type',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(728,13,728,'Approve Loan Application','approve_loan_application',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(729,13,729,'Manage Loan','manage_loan',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(730,13,730,'Manage Loan Type','manage_loan_type',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(731,13,731,'Submit Loan Application','submit_loan_application',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(732,3,732,'Security guard(Kuakata)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(733,3,733,'Security guard(Norshingdi)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(734,3,734,'Security Guard (Banani)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(735,3,735,'Local Person','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(736,13,736,'Create Requisition','create_requisition',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(737,3,737,'Security Guard Banani','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(738,3,738,'LIAISON OFFICER','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(739,3,739,'LIAISON OFFICER (Iraq Project)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(740,3,740,'Director Projects','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(741,3,741,'Technical Adviser','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(742,3,742,'Technical Advisor','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(743,3,743,'Manager(Maintenance)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(747,3,747,'Assistant HR','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(748,3,748,'Business Deployment Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(749,22,749,'Savar Housing Project','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(751,13,751,'view challan','view_challan',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(752,3,752,'Assistant Technical Consultant','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(753,3,753,'Technical Consultant (OIL & GAS)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(754,3,754,'CFB Packer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(755,10,755,'Modhumoti Bank Ltd.','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(756,3,756,'Office Boy (Accounts)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(757,3,757,'Manager (Business Development)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(758,3,758,'Assistant Manager (Logistic & Support Services)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(760,3,760,'Operation Manager (Technical)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(761,3,761,'Assistant Embassy Coordinator','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(763,3,763,'Deputy Manager (Planning)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(767,3,766,'Cyber Security Consultant','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(768,3,767,'Architect','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(770,3,769,'Imam (Head Office)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(771,3,770,'Sr. Executive (Purchase & Procurement).','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(772,13,771,'Admin Leave Application','admin_leave_application',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(773,13,772,'Admin Daily Movement','admin_daily_movement',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(774,13,773,'View Leave Application','view_leave_application',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(775,13,774,'View Daily Movement','view_daily_movement',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(776,3,775,'Engine Fitter/Driver','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(777,3,776,'Asst Driver','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(778,3,777,'Senior Greaser','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(781,13,780,'Delete Job History','delete_job_history',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(783,16,782,'Compensated Leave','It\'s adjust with holiday duties. Don\'t deduct from total leave.',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(784,22,783,'Maritime University project','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(785,3,784,'Machine Helper','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(786,3,785,'Printer Helper','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(788,22,787,'General','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(789,22,788,'Operation','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(791,3,790,'Senior Operation Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(792,3,791,'Security Guard (Noonertek Project)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(793,4,792,'Hold','His/Her salary will be hold',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(795,3,794,'Driver (Boro sir)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(796,3,795,'Driver (Choto sir)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(797,3,796,'Driver (Mejho sir)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(798,3,797,'Driver (AU Ahmed)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(799,3,798,'Driver (Azim bhai)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(800,3,799,'Driver (Boro Madam)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(802,3,801,'Security Guard (MTI)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(804,22,803,'Front Desk Executive cum Computer Operator','',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),
(805,3,804,'Front Desk Executive cum Computer Operator','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(806,3,805,'Big Truck Driver','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(807,3,806,'Asst. Machanic','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(808,3,807,'Senior Visa Executive','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(810,3,809,'Block and Batching Plant In-charge','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(811,3,810,'Supervisor (Technical)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(812,3,811,'Maintenance In Charge','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(813,4,812,'Temporary','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(814,3,813,'Machine Operator','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(815,3,814,'Executive- Public Relationship','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(816,3,815,'Receptionist cum Office Assistant','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(817,3,816,'Boatman','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(818,3,817,'Site Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(819,3,819,'Corporate Manager ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(820,3,820,'Receptionist','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(821,3,821,'HSE Supervisor','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(822,3,822,'Sr. General Manager- Technical','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(823,3,823,'General Manager-Operation','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(824,2,824,'Head Office','','11','','Matijheel','','','HO',1,NULL,NULL,NULL),
(825,2,825,'Chittagong','','11','','Chittagong','','','Chittagong',1,NULL,NULL,NULL),
(826,2,826,'Gukshan','','11','','Gukshan','','','Gukshan',1,NULL,NULL,NULL),
(827,2,827,'Nikunjo','','11','','Nikunjo','','','Nikunjo',1,NULL,NULL,NULL),
(828,22,828,'Chief Executive Officer (CEO)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(830,3,830,'Chief Technical Officer (CTO)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(831,3,831,'Chief Excecutive Officer (CEO)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(832,21,832,'Regular','','Required','09:00:00','17:00:00','09:15:00','17:00:00','Required',1,'Not_Eligible','',NULL),
(833,3,833,'Chief Executive Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(834,3,834,'Deputy Chief Executive Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(835,3,835,'Chief Business Officer (CBO)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(836,3,836,'Assistant Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(837,3,837,'Senior Officer (CTBL)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(838,22,838,'Monitoring & Complaince','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(839,3,839,'Senior Vice President','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(840,3,840,'Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(841,2,841,'Chittagong','','11','','','','','CTG',0,NULL,NULL,NULL),
(842,2,842,'Head Office','','11','','PFI Tower, 3rd Floor,56-57 Dilkusha C/A','','','HO',0,NULL,NULL,NULL),
(843,2,843,'Gulshan Branch','','11','','Progess Tower,(4th Floor),House -1,plot-46,Road-23,Gulshan-1.Dhaka-1212','','','GB',0,NULL,NULL,NULL),
(844,2,844,'Nikunja Branch','','11','','DSE Tower,Level-9,Room No-154,plot-46,Road-21,Nikunja-2,Dhaka-1229','','','NB',0,NULL,NULL,NULL),
(845,2,845,'Chittagong Branch','','11','','C& F(4th Floor)1712 Sk Mujib Road, Agrabad C/A,Chittagong-4100','','','CTG',0,NULL,NULL,NULL),
(846,22,846,'All Department','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(847,22,847,'Customer Service','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(848,22,848,'Marketing & Trading','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(849,22,849,'Finance & Accounts','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(850,22,850,'Central Depository Bangladesh Ltd(CDBL)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(851,22,851,'Business Monitoring & Compliance','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(852,22,852,'Information Technology (IT)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(853,22,853,'Research & Business Development','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(854,22,854,'HR and Admin','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(855,22,855,'Secretariat Affairs','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(856,5,856,'MBA,B.Sc. Engineering ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(857,3,857,'Junior Officer','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(858,3,858,'Senior Officer ','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(859,3,859,'Senior Manager','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(860,5,860,'MBS','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(861,3,861,'Junior Officer (Regular)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(862,3,862,'Officer (Regular)','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(863,4,863,'contractual','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(864,16,864,'Earned Leave','',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL);

/*Table structure for table `taxonomy_type` */

DROP TABLE IF EXISTS `taxonomy_type`;

CREATE TABLE `taxonomy_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_3` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `taxonomy_type` */

insert  into `taxonomy_type`(`id`,`name`,`description`) values 
(1,'Company','This is company '),
(2,'Company Division','This is company division'),
(3,'Job Title','This is job title'),
(4,'Type of Employee','This is employee category'),
(5,'Qualification','This is qualification'),
(6,'Religion','This is religion'),
(7,'Marital status','This is marital_status'),
(8,'Blood Group','This is blood_group'),
(9,'Pay Type','this is pay type'),
(10,'Bank Name','This is Bank Name'),
(11,'City Name','This is City name'),
(12,'Distict Name','This is Distict Name'),
(13,'Task Name','This is task type name or task name'),
(14,'Relative','This is relative'),
(15,'Job Grade',''),
(16,'Leave Type','This is employee leave type'),
(17,'Yearly Holiday Type','This is Yearly holiday'),
(18,'Performance Criteria Category','Performance Criteria Category'),
(19,'Performance Criteria','Performance Criteria Lebel'),
(20,'Car Cost Type','Car Cost Type'),
(21,'Working Shift','Working Shift'),
(22,'Department','This is Employee department');

/*Table structure for table `tbl_account_group` */

DROP TABLE IF EXISTS `tbl_account_group`;

CREATE TABLE `tbl_account_group` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountGroupName` varchar(50) NOT NULL,
  `Des` text NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedBy` int(3) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '1',
  `DeletionStatus` tinyint(4) NOT NULL DEFAULT '0',
  `SerialOrder` int(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_account_group` */

/*Table structure for table `tbl_accounts` */

DROP TABLE IF EXISTS `tbl_accounts`;

CREATE TABLE `tbl_accounts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountName` varchar(150) DEFAULT NULL,
  `AccountType` tinyint(2) DEFAULT NULL COMMENT '1=cash,2=bank,3=others',
  `AccountNumber` varchar(200) DEFAULT NULL,
  `Des` varchar(500) DEFAULT NULL COMMENT 'Description',
  `StartingBalance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `Balance` decimal(18,2) DEFAULT '0.00',
  `BankName` varchar(200) DEFAULT NULL,
  `Branch` varchar(200) DEFAULT NULL,
  `Address` varchar(250) DEFAULT NULL,
  `AccountHolder` varchar(150) DEFAULT NULL,
  `HolderImage` text,
  `HolderPhone` varchar(200) DEFAULT NULL,
  `Website` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Currency` varchar(20) DEFAULT NULL,
  `Notes` text,
  `SerialOrder` int(5) DEFAULT '0',
  `Token` varchar(200) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `CreatedBy` int(5) DEFAULT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` int(5) DEFAULT NULL,
  `Status` tinyint(2) DEFAULT '1',
  `DeletionStatus` tinyint(2) DEFAULT '0',
  `AccountGroupID` int(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_accounts` */

/*Table structure for table `tbl_applicant` */

DROP TABLE IF EXISTS `tbl_applicant`;

CREATE TABLE `tbl_applicant` (
  `ApplicantID` int(11) NOT NULL AUTO_INCREMENT,
  `CircularID` int(11) NOT NULL,
  `ApplicantName` varchar(150) NOT NULL,
  `ApplicantEmail` varchar(100) NOT NULL,
  `ApplicantPhone` varchar(50) NOT NULL,
  `ApplicantImage` text NOT NULL,
  `ApplicantCV` text NOT NULL,
  `AdditionalInformation` text NOT NULL,
  `AppliedTime` datetime NOT NULL,
  `Age` float(10,2) DEFAULT NULL,
  `LastInstitute` varchar(200) DEFAULT NULL,
  `ExpSalary` int(8) DEFAULT NULL,
  `TotalExp` int(5) DEFAULT NULL,
  `ExpDetail` text,
  `UpdatedBy` int(3) NOT NULL,
  `UpdatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0=applied,1=shortlisted,2=written,3=interview,4=selected,5=appointed,6=joined',
  `DeletionStatus` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ApplicantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_applicant` */

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) DEFAULT NULL,
  `CategoryTypeID` int(5) DEFAULT NULL COMMENT '1=income,2=expense,3=transfer,4=assets',
  `AccountID` int(7) DEFAULT NULL,
  `Des` varchar(500) DEFAULT NULL,
  `Budget` decimal(18,2) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `CreatedBy` int(3) DEFAULT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` int(3) DEFAULT NULL,
  `SerialOrder` int(11) DEFAULT '0',
  `Status` tinyint(3) DEFAULT '1',
  `DeletionStatus` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_category` */

/*Table structure for table `tbl_category_type` */

DROP TABLE IF EXISTS `tbl_category_type`;

CREATE TABLE `tbl_category_type` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CTName` varchar(100) DEFAULT NULL,
  `Des` text,
  `CreatedAt` datetime DEFAULT NULL,
  `CreatedBy` int(5) DEFAULT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` int(5) DEFAULT NULL,
  `Status` tinyint(3) DEFAULT '1',
  `DeletionStatus` tinyint(3) DEFAULT '0',
  `SerialOrder` int(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_category_type` */

/*Table structure for table `tbl_challan` */

DROP TABLE IF EXISTS `tbl_challan`;

CREATE TABLE `tbl_challan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challan_no` varchar(100) DEFAULT NULL,
  `challan_date` date DEFAULT NULL,
  `dipositor` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(3) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_challan` */

/*Table structure for table `tbl_challan_detail` */

DROP TABLE IF EXISTS `tbl_challan_detail`;

CREATE TABLE `tbl_challan_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challan_id` int(11) DEFAULT NULL,
  `tin` varchar(150) DEFAULT NULL,
  `content_id` varchar(20) DEFAULT NULL,
  `emp_id` varchar(20) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_challan_detail` */

/*Table structure for table `tbl_circular` */

DROP TABLE IF EXISTS `tbl_circular`;

CREATE TABLE `tbl_circular` (
  `CircularID` int(11) NOT NULL AUTO_INCREMENT,
  `PostID` int(5) NOT NULL,
  `DepartmentID` int(5) NOT NULL COMMENT 'department id',
  `DivisionID` int(5) NOT NULL COMMENT 'Company id',
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `JobType` varchar(20) CHARACTER SET utf8 DEFAULT 'Full-time',
  `JobLocation` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `JobExperience` text CHARACTER SET utf8,
  `Education` text CHARACTER SET utf8,
  `JobRequirments` text CHARACTER SET utf8,
  `ShortDescription` text CHARACTER SET utf8,
  `LongDescription` text CHARACTER SET utf8,
  `Salary` varchar(50) CHARACTER SET utf8 DEFAULT 'Negotiable',
  `OtherBenifits` text CHARACTER SET utf8 NOT NULL,
  `Vacancy` varchar(20) NOT NULL DEFAULT 'na',
  `BannerImage` varchar(250) DEFAULT 'resources/images/circularBanner/default_banner_image.jpg',
  `CreatedBy` int(3) NOT NULL,
  `CreaedTime` datetime NOT NULL,
  `UpdatedBy` int(3) NOT NULL,
  `UpdatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PublicationStatus` tinyint(4) NOT NULL DEFAULT '0',
  `DeletionStatus` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CircularID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_circular` */

/*Table structure for table `tbl_loan_advance` */

DROP TABLE IF EXISTS `tbl_loan_advance`;

CREATE TABLE `tbl_loan_advance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `content_id` int(5) DEFAULT NULL,
  `emp_id` int(8) DEFAULT NULL,
  `company_id` int(7) DEFAULT NULL,
  `division_id` int(7) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `loan_type_id` int(3) DEFAULT NULL,
  `given_method` int(3) DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `given_by` int(3) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `installment` int(3) DEFAULT NULL,
  `interest` float(10,2) DEFAULT NULL,
  `penalty` float(10,2) DEFAULT NULL,
  `total_payment` float(10,2) DEFAULT NULL,
  `installment_amount` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `repayment_type` varchar(50) DEFAULT NULL,
  `disbursement-date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(3) DEFAULT NULL,
  `paid_installment` int(5) DEFAULT '0',
  `repayment_from` int(11) DEFAULT '0' COMMENT 'if repay from salary value=1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_loan_advance` */

/*Table structure for table `tbl_loan_disbursement` */

DROP TABLE IF EXISTS `tbl_loan_disbursement`;

CREATE TABLE `tbl_loan_disbursement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(8) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `principal_amount` float(10,2) DEFAULT NULL,
  `interest_amount` float(10,2) DEFAULT NULL,
  `penalty_amount` float(10,2) DEFAULT NULL,
  `total_payment` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(3) DEFAULT NULL,
  `repayment_from` int(11) DEFAULT '0' COMMENT 'if repay from salary value=1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_loan_disbursement` */

/*Table structure for table `tbl_loan_repayment` */

DROP TABLE IF EXISTS `tbl_loan_repayment`;

CREATE TABLE `tbl_loan_repayment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(7) DEFAULT NULL,
  `loan_disbursement_id` int(9) DEFAULT NULL,
  `account_id` int(5) DEFAULT NULL,
  `content_id` int(7) DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `payment_date_was` date DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `payment_method` int(3) DEFAULT NULL COMMENT 'cash=1,cheque=2,salary=3',
  `principal_amount` int(11) DEFAULT NULL,
  `interest_amount` int(11) DEFAULT NULL,
  `penalty_amount` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_loan_repayment` */

/*Table structure for table `tbl_loan_type` */

DROP TABLE IF EXISTS `tbl_loan_type`;

CREATE TABLE `tbl_loan_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `loan_type_name` varchar(30) NOT NULL,
  `max_loan_amount` int(10) DEFAULT NULL,
  `interest_percentage` int(5) DEFAULT '0',
  `description` text,
  `status` tinyint(2) DEFAULT '1',
  `deletion_status` tinyint(2) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_loan_type` */

insert  into `tbl_loan_type`(`id`,`loan_type_name`,`max_loan_amount`,`interest_percentage`,`description`,`status`,`deletion_status`,`created_at`,`created_by`,`updated_at`,`updated_by`) values 
(11,'Home Loan',500000,15,'rr',0,0,'2019-03-16 17:00:12',16,'2019-03-30 23:22:07',16),
(22,'Personal Loan',555,0,'',1,0,'2019-03-16 20:07:39',16,'2019-03-30 22:31:32',NULL);

/*Table structure for table `tbl_month` */

DROP TABLE IF EXISTS `tbl_month`;

CREATE TABLE `tbl_month` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `month_id` int(3) DEFAULT NULL,
  `month_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_month` */

insert  into `tbl_month`(`id`,`month_id`,`month_name`) values 
(1,1,'January'),
(2,2,'February'),
(3,3,'March'),
(4,4,'April'),
(5,5,'May'),
(6,6,'June'),
(7,7,'July'),
(8,8,'August'),
(9,9,'September'),
(10,10,'October'),
(11,11,'November'),
(12,12,'December');

/*Table structure for table `tbl_notice` */

DROP TABLE IF EXISTS `tbl_notice`;

CREATE TABLE `tbl_notice` (
  `NoticeID` int(11) NOT NULL AUTO_INCREMENT,
  `NoticeName` varchar(250) NOT NULL,
  `ShortDescription` varchar(250) NOT NULL,
  `LongDescription` text NOT NULL,
  `NoticeFile` text NOT NULL,
  `PublishedOn` date NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `UpdatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedBy` int(3) NOT NULL,
  `PublicationStatus` tinyint(2) NOT NULL DEFAULT '1',
  `DeletionStatus` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`NoticeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_notice` */

/*Table structure for table `tbl_payroll` */

DROP TABLE IF EXISTS `tbl_payroll`;

CREATE TABLE `tbl_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_type_id` int(5) DEFAULT '1',
  `account_id` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `month_id` int(2) DEFAULT NULL,
  `pay_from` date DEFAULT NULL,
  `pay_to` date DEFAULT NULL,
  `content_id` int(7) DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  `division_id` int(5) DEFAULT NULL,
  `department_id` int(5) DEFAULT NULL,
  `grade_id` int(5) DEFAULT NULL,
  `emp_post_id` int(5) DEFAULT NULL,
  `emp_type_id` int(7) DEFAULT NULL,
  `reimbursment_date` date DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `basic` int(7) DEFAULT '0' COMMENT 'basic salary',
  `hra` int(7) DEFAULT '0' COMMENT 'house rent allowance',
  `ma` int(7) DEFAULT '0' COMMENT 'medical allowance',
  `ta` int(7) DEFAULT '0' COMMENT 'transport allowance',
  `pfa` int(7) DEFAULT '0' COMMENT 'Provident Fund Allowance',
  `ca` int(7) DEFAULT '0' COMMENT 'Coveyance Allowance',
  `pb` int(7) DEFAULT '0' COMMENT 'Performance bonus',
  `telephone_allow` int(5) DEFAULT '0',
  `bonus` int(5) DEFAULT '0' COMMENT 'Special Bonus',
  `festival_bonus` int(9) DEFAULT '0',
  `gratuity` int(7) DEFAULT '0',
  `oa` int(7) DEFAULT '0' COMMENT 'others allowance',
  `ot_hour` varchar(10) DEFAULT NULL,
  `ot_taka` int(7) DEFAULT '0' COMMENT 'Overtime taka',
  `arear` int(7) DEFAULT '0' COMMENT 'Arear',
  `present_salary` int(11) DEFAULT NULL,
  `gross_salary` int(11) DEFAULT '0',
  `total` int(11) DEFAULT '0',
  `loan` float(10,2) DEFAULT '0.00' COMMENT 'amount',
  `loan_disbursement_id` int(7) DEFAULT NULL COMMENT 'id',
  `late_early_day` int(7) DEFAULT NULL,
  `late_early_taka` int(7) DEFAULT '0',
  `present_day` int(7) DEFAULT NULL,
  `late_day` int(3) DEFAULT '0',
  `late_deduct` int(7) DEFAULT '0',
  `early_day` int(3) DEFAULT '0',
  `early_deduct` int(7) DEFAULT '0',
  `absent_day` int(7) DEFAULT '0',
  `absent_day_taka` int(7) DEFAULT '0',
  `pf` int(7) DEFAULT '0',
  `tax` int(7) DEFAULT '0',
  `other_deduct` int(7) DEFAULT '0',
  `other_deduction_note` varchar(500) DEFAULT NULL,
  `total_deduction` float(10,2) DEFAULT '0.00',
  `net_salary` int(11) DEFAULT '0' COMMENT 'after deduction',
  `payment_method_id` int(5) DEFAULT NULL,
  `total_paid` int(10) DEFAULT '0',
  `remarks` varchar(100) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0=pending,1=confirm,2=partly paid,3=Paid',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(3) DEFAULT NULL,
  `checked` tinyint(2) DEFAULT '0' COMMENT '0=pending; 1=checked',
  `checked_date` date DEFAULT NULL,
  `approved` tinyint(2) DEFAULT '0' COMMENT '0=pending; 1=approved',
  `approved_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_payroll` */

/*Table structure for table `tbl_payroll_payment` */

DROP TABLE IF EXISTS `tbl_payroll_payment`;

CREATE TABLE `tbl_payroll_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) DEFAULT NULL,
  `account_id` int(7) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_payroll_payment` */

/*Table structure for table `tbl_ramadan_time_schedule` */

DROP TABLE IF EXISTS `tbl_ramadan_time_schedule`;

CREATE TABLE `tbl_ramadan_time_schedule` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `year` year(4) DEFAULT NULL,
  `start_date` varchar(20) DEFAULT NULL,
  `end_date` varchar(20) DEFAULT NULL,
  `late_count_time` time DEFAULT NULL,
  `early_count_time` time DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_by` int(3) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_by` int(3) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_ramadan_time_schedule` */

/*Table structure for table `tbl_transactions` */

DROP TABLE IF EXISTS `tbl_transactions`;

CREATE TABLE `tbl_transactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TransDate` date DEFAULT NULL,
  `TransferID` int(11) DEFAULT NULL,
  `AccountID` int(7) DEFAULT NULL,
  `TTypeID` tinyint(3) DEFAULT NULL COMMENT '1=receipt,2=payment,3=transfer',
  `InOutACID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Des` varchar(500) DEFAULT NULL,
  `Amount` decimal(18,2) DEFAULT '0.00',
  `Dr` decimal(18,2) DEFAULT '0.00',
  `Cr` decimal(18,2) DEFAULT '0.00',
  `ContactPerson` varchar(100) DEFAULT NULL,
  `PaymentMethod` varchar(100) DEFAULT NULL,
  `Ref` varchar(200) DEFAULT NULL,
  `Status` tinyint(3) DEFAULT '1' COMMENT '1=cleared,2=pending,3=void',
  `Tax` decimal(18,2) DEFAULT '0.00',
  `Attachments` text,
  `CreatedAt` datetime DEFAULT NULL,
  `CreatedBy` int(5) DEFAULT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` int(5) DEFAULT NULL,
  `Archived` tinyint(1) DEFAULT '0',
  `Trash` tinyint(1) DEFAULT '0',
  `Flag` tinyint(1) DEFAULT '0',
  `BF` decimal(18,2) DEFAULT NULL,
  `Balance` decimal(18,2) DEFAULT '0.00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_transactions` */

/*Table structure for table `tbl_visitors` */

DROP TABLE IF EXISTS `tbl_visitors`;

CREATE TABLE `tbl_visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) DEFAULT NULL,
  `domain` varchar(150) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `serverDate` varchar(10) DEFAULT NULL,
  `serverTime` varchar(10) DEFAULT NULL,
  `timeZone` varchar(100) DEFAULT NULL,
  `userOS` varchar(100) DEFAULT NULL,
  `userBrowser` varchar(100) DEFAULT NULL,
  `userAgent` varchar(300) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `countryCode` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `lat` varchar(40) DEFAULT NULL,
  `lon` varchar(40) DEFAULT NULL,
  `isp` varchar(200) DEFAULT NULL,
  `org` varchar(200) DEFAULT NULL,
  `asp` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbl_visitors` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(40) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `user_status` int(2) DEFAULT '0',
  `phone` varchar(40) DEFAULT NULL,
  `user_role` varchar(20) DEFAULT NULL,
  `user_company` varchar(100) DEFAULT NULL,
  `user_division` varchar(100) DEFAULT NULL,
  `user_department` varchar(100) DEFAULT NULL,
  `user_permitted_account_group` int(7) DEFAULT NULL,
  `created` varchar(40) DEFAULT NULL,
  `user_logged_status` tinyint(1) DEFAULT '0',
  `user_last_accessed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`employee_id`,`name`,`username`,`email`,`password`,`user_status`,`phone`,`user_role`,`user_company`,`user_division`,`user_department`,`user_permitted_account_group`,`created`,`user_logged_status`,`user_last_accessed`) values 
(1,'99925','Administration','adminhr','misaag@ahmedamin.com','admin#hr;',1,'+88 02 8812395','1',NULL,'24',NULL,NULL,'21-04-2019 10:16:33',1,'2022-03-15 10:52:07');

/*Table structure for table `userwiseaccess` */

DROP TABLE IF EXISTS `userwiseaccess`;

CREATE TABLE `userwiseaccess` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `action` varchar(400) DEFAULT NULL,
  `user_id` varchar(400) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `userwiseaccess` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
