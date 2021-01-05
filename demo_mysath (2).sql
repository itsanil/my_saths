/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - demo_mysath
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`demo_mysath` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `demo_mysath`;

/*Table structure for table `campaign_categorys` */

DROP TABLE IF EXISTS `campaign_categorys`;

CREATE TABLE `campaign_categorys` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

/*Data for the table `campaign_categorys` */

insert  into `campaign_categorys`(`id`,`title`,`photo`,`status`,`created_at`,`updated_at`) values 
(1,'Animals','app/category/16095769771000.jpg','Active',NULL,'2021-01-02 08:42:57'),
(2,'Charity',NULL,'Active',NULL,NULL),
(3,'Dance',NULL,'Active',NULL,NULL),
(4,'Community',NULL,'Active',NULL,NULL),
(5,'Comics & Books',NULL,'Active',NULL,NULL),
(6,'Clubs & Organization',NULL,'Active',NULL,NULL),
(7,'Children',NULL,'Active',NULL,NULL),
(8,'Accidents & Disasters',NULL,'Active',NULL,NULL),
(9,'Adoption',NULL,'Active',NULL,NULL),
(10,'Art',NULL,'Active',NULL,NULL),
(11,'Business & Technology',NULL,'Active',NULL,NULL),
(12,'Buy & Home',NULL,'Active',NULL,NULL),
(13,'Emergencies',NULL,'Active',NULL,NULL),
(14,'Films & Short Films',NULL,'Active',NULL,NULL),
(15,'Food',NULL,'Active',NULL,NULL),
(16,'Music & Albums',NULL,'Active',NULL,NULL),
(17,'Old Age Homes',NULL,'Active',NULL,NULL),
(18,'Energy & Environments',NULL,'Active',NULL,NULL),
(19,'Travels & Trips',NULL,'Active',NULL,NULL),
(20,'Women Empowerment',NULL,'Active',NULL,NULL),
(21,'Military & Veterns',NULL,'Active',NULL,NULL),
(22,'Medical & Health',NULL,'Active',NULL,NULL),
(23,'Special Events',NULL,'Active',NULL,NULL),
(24,'Natural Disasters',NULL,'Active',NULL,NULL),
(25,'Education Purpose',NULL,'Active',NULL,NULL),
(26,'Entrepreneur',NULL,'Active',NULL,NULL),
(27,'Rural Development',NULL,'Active',NULL,NULL),
(28,'Real Estate',NULL,'Active',NULL,NULL),
(29,'Non Profit Organizations',NULL,'Active',NULL,NULL),
(30,'Repay a Loan',NULL,'Active',NULL,NULL),
(31,'Marriage Events',NULL,'Active',NULL,NULL),
(32,'Get Out Of debts',NULL,'Active',NULL,NULL),
(33,'Sports Events',NULL,'Active',NULL,NULL),
(34,'Develop a Software',NULL,'Active',NULL,NULL),
(35,'Others',NULL,'Active',NULL,NULL);

/*Table structure for table `campaign_comments` */

DROP TABLE IF EXISTS `campaign_comments`;

CREATE TABLE `campaign_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `campaign_comments` */

/*Table structure for table `campaign_perks` */

DROP TABLE IF EXISTS `campaign_perks`;

CREATE TABLE `campaign_perks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned DEFAULT NULL,
  `perk_type` int(11) NOT NULL,
  `perk_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perk_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_perks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimated_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perk_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_perks_campaign_id_index` (`campaign_id`),
  CONSTRAINT `campaign_perks_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `campaign_perks` */

insert  into `campaign_perks`(`id`,`campaign_id`,`perk_type`,`perk_title`,`perk_description`,`amount`,`max_perks`,`estimated_date`,`shipping_address`,`perk_photo`,`created_at`,`updated_at`) values 
(1,2,1,'demo perk','xyz','500','10','2021-01-05','{\"address\":\"India\",\"fees\":\"10\"}','app/perk/16098427301000.jpg','2021-01-05 10:14:45','2021-01-05 10:32:10');

/*Table structure for table `campaign_subscribers` */

DROP TABLE IF EXISTS `campaign_subscribers`;

CREATE TABLE `campaign_subscribers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `campaign_subscribers` */

/*Table structure for table `campaigns` */

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `recipient_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_recipient_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_recipient_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discription` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `campaigns` */

insert  into `campaigns`(`id`,`recipient_type`,`added_by`,`recipient_first_name`,`recipient_last_name`,`recipient_business_name`,`legal_recipient_first_name`,`legal_recipient_last_name`,`project`,`category_id`,`title`,`discription`,`video_type`,`video_1`,`video_2`,`photo`,`add_photo`,`status`,`created_at`,`updated_at`) values 
(2,'me',1,NULL,NULL,NULL,NULL,NULL,'{\"currency\":\"2\",\"needed_amount\":\"60000\",\"website_url\":null,\"linkedin_url\":null,\"facebook_url\":null,\"twitter_url\":null}',29,'Animals','hbjhbj','0',NULL,NULL,'app/campaign/16097598301000.jpg','[\"app\\/campaign\\/16097598301000.jpg\",\"app\\/campaign\\/16097598301000.jpg\"]','Active','2021-01-04 07:35:41','2021-01-04 11:30:30');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2020_09_09_044548_create_home_products_table',1),
(2,'2020_09_17_090934_create_tags_table',2),
(3,'2020_09_22_101037_create_promotions_table',3),
(4,'2020_10_01_051922_create_wishlists_table',4),
(5,'2020_10_01_131244_create_vouchers_table',5),
(6,'2020_10_03_044833_create_customer_discounts_table',5),
(7,'2020_10_09_085830_create_manage_sgps_table',6),
(8,'2020_10_10_053645_create_product_combos_table',7),
(9,'2020_12_23_060758_create_return_stock_logs_table',8),
(10,'2014_10_12_000000_create_users_table',9),
(11,'2014_10_12_100000_create_password_resets_table',9),
(12,'2019_08_19_000000_create_failed_jobs_table',9),
(13,'2020_07_29_060554_laratrust_setup_tables',9),
(14,'2021_01_01_065708_create_campaigns_table',10),
(15,'2021_01_05_081330_create_campaign_subscribers_table',11),
(16,'2021_01_05_083721_create_campaign_comments_table',12),
(17,'2021_01_05_084125_create_campaign_perks_table',13);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`token`,`created_at`) values 
('achal@sanchitsolutions.net','$2y$10$0LHeLWtzPKPTpBvuPthcu.gWB6yhC2OBTekcgNK9gU9TmeSWLnW6y','2020-09-22 14:43:25');

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`permission_id`,`role_id`) values 
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1),
(9,1),
(10,1),
(11,3),
(12,3),
(13,3),
(14,3),
(9,4),
(10,4);

/*Table structure for table `permission_user` */

DROP TABLE IF EXISTS `permission_user`;

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_user` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values 
(1,'users-create','Create Users','Create Users','2020-07-29 06:21:37','2020-07-29 06:21:37'),
(2,'users-read','Read Users','Read Users','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(3,'users-update','Update Users','Update Users','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(4,'users-delete','Delete Users','Delete Users','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(5,'payments-create','Create Payments','Create Payments','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(6,'payments-read','Read Payments','Read Payments','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(7,'payments-update','Update Payments','Update Payments','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(8,'payments-delete','Delete Payments','Delete Payments','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(9,'profile-read','Read Profile','Read Profile','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(10,'profile-update','Update Profile','Update Profile','2020-07-29 06:21:38','2020-07-29 06:21:38'),
(11,'module_1_name-create','Create Module_1_name','Create Module_1_name','2020-07-29 06:21:39','2020-07-29 06:21:39'),
(12,'module_1_name-read','Read Module_1_name','Read Module_1_name','2020-07-29 06:21:39','2020-07-29 06:21:39'),
(13,'module_1_name-update','Update Module_1_name','Update Module_1_name','2020-07-29 06:21:39','2020-07-29 06:21:39'),
(14,'module_1_name-delete','Delete Module_1_name','Delete Module_1_name','2020-07-29 06:21:39','2020-07-29 06:21:39');

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `role_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_user` */

insert  into `role_user`(`role_id`,`user_id`,`user_type`) values 
(1,1,NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values 
(1,'admin','Admin','Admin','2020-07-29 06:21:37','2020-07-29 06:21:37'),
(2,'user','user','user',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usertype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` bigint(20) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pinno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `panno_aadharno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`firstname`,`lastname`,`username`,`usertype`,`dob`,`gender`,`phonecode`,`mobile`,`email`,`email_verified_at`,`password`,`security_pin`,`country`,`state`,`district`,`city`,`pinno`,`panno_aadharno`,`campaign`,`remember_token`,`created_at`,`updated_at`) values 
(1,'anil','LTD.','admin','NONNGO','2021-01-01','Male','+91',8652427021,'admin@gmail.com',NULL,'$2y$10$1C0wdlDsXwo.FJVMY4NQkOjLD6vCkvAHmmz1EgEmN.oSug1SgVJdG','1234','India','Andhra Pradesh','mumbai','Mumbai','400058','806260113622','ADOPTION','bp07B6WuapOQTDjXcpY6iqebQmHTxry1bkeuE4qxs2n64kQB0caymdHcQhJu','2021-01-01 06:07:21','2021-01-01 06:07:21');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
