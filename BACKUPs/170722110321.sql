/*
MySQL Backup
Source Server Version: 5.7.14
Source Database: contactproject
Date: 22/07/2017 11:03:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `date_post` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `post_admin_id` int(10) unsigned NOT NULL,
  `update_admin_id` int(10) unsigned DEFAULT NULL,
  `token` varchar(32) CHARACTER SET latin1 NOT NULL,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `username` varchar(20) CHARACTER SET latin1 NOT NULL,
  `pwd` varchar(128) CHARACTER SET latin1 NOT NULL,
  `ip` varchar(15) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`token`) USING BTREE,
  KEY `admin_id` (`post_admin_id`),
  KEY `update_admin_id` (`update_admin_id`),
  CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`post_admin_id`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `admins_ibfk_2` FOREIGN KEY (`update_admin_id`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `admin_areas`
-- ----------------------------
DROP TABLE IF EXISTS `admin_areas`;
CREATE TABLE `admin_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `admin_area_un`
-- ----------------------------
DROP TABLE IF EXISTS `admin_area_un`;
CREATE TABLE `admin_area_un` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `admin_id` int(10) unsigned NOT NULL,
  `admin_area_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `admin_area_id` (`admin_area_id`),
  CONSTRAINT `admin_area_un_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_area_un_ibfk_2` FOREIGN KEY (`admin_area_id`) REFERENCES `admin_areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `admin_logins`
-- ----------------------------
DROP TABLE IF EXISTS `admin_logins`;
CREATE TABLE `admin_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `date_post` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `token` varchar(32) CHARACTER SET latin1 NOT NULL,
  `ip` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admin_logins_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `contacts`
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `date_post` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `post_admin_id` int(10) unsigned DEFAULT NULL,
  `update_admin_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(70) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `ddd_tel` varchar(2) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `msg` mediumtext,
  `filename` varchar(255) DEFAULT NULL,
  `seen` tinyint(3) unsigned DEFAULT NULL,
  `responded` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`post_admin_id`),
  KEY `update_admin_id` (`update_admin_id`),
  CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`post_admin_id`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `contacts_ibfk_2` FOREIGN KEY (`update_admin_id`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `defines`
-- ----------------------------
DROP TABLE IF EXISTS `defines`;
CREATE TABLE `defines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `date_post` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `post_admin_id` int(10) unsigned NOT NULL,
  `update_admin_id` int(10) unsigned DEFAULT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_meta_keywords` varchar(255) NOT NULL,
  `page_meta_description` varchar(255) NOT NULL,
  `page_nice_url` varchar(50) DEFAULT NULL,
  `page_analytics_code` varchar(50) DEFAULT NULL,
  `company_cnpj` varchar(14) DEFAULT NULL,
  `company_state_registration` varchar(20) DEFAULT NULL,
  `company_corporate_name` varchar(60) DEFAULT NULL,
  `company_fancy_name` varchar(60) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_tel` varchar(25) DEFAULT NULL,
  `company_tel2` varchar(25) DEFAULT NULL,
  `company_cel` varchar(25) DEFAULT NULL,
  `company_cel2` varchar(25) DEFAULT NULL,
  `company_whatsapp` varchar(25) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_address2` varchar(255) DEFAULT NULL,
  `company_cep_origem` varchar(8) NOT NULL,
  `company_facebook` varchar(200) DEFAULT NULL,
  `company_instagram` varchar(200) DEFAULT NULL,
  `company_linkedin` varchar(200) DEFAULT NULL,
  `company_twitter` varchar(200) DEFAULT NULL,
  `company_youtube` varchar(200) DEFAULT NULL,
  `correio_empresa` varchar(20) DEFAULT NULL,
  `correio_senha` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`post_admin_id`),
  KEY `update_admin_id` (`update_admin_id`),
  CONSTRAINT `defines_ibfk_1` FOREIGN KEY (`post_admin_id`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `defines_ibfk_2` FOREIGN KEY (`update_admin_id`) REFERENCES `admins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `admins` VALUES ('1','1','2012-02-24 14:11:00','2012-05-29 14:52:38','1',NULL,'33cd946d0692762be5dc45035c3c278c','Diler',NULL,'di_ler@hotmail.com','diler','5c59d9f743936543194a1cc680b7829334532e5131df04bf59daa468388a4a2b0e24a7d858649e16bc51574271e41a83310873a4408fa2cc373fc1fed4047885',''), ('4','1','2017-07-22 11:00:51',NULL,'1',NULL,'1efc7e513e59ff4aba20bea78fdff8d2','TESTE',NULL,'teste@teste.com','teste','5c59d9f743936543194a1cc680b7829334532e5131df04bf59daa468388a4a2b0e24a7d858649e16bc51574271e41a83310873a4408fa2cc373fc1fed4047885','::1');
INSERT INTO `admin_areas` VALUES ('1','1','Administrador'), ('2','1','Gerenciar conteúdos');
INSERT INTO `admin_area_un` VALUES ('1','1','1','1'), ('4','1','4','1');
INSERT INTO `admin_logins` VALUES ('1','1','2017-06-05 16:57:28','2017-06-05 17:41:12','33cd946d0692762be5dc45035c3c278c','::1'), ('2','1','2017-06-06 11:27:51','2017-06-06 11:59:36','33cd946d0692762be5dc45035c3c278c','::1'), ('3','1','2017-06-06 13:47:54','2017-06-06 13:56:10','33cd946d0692762be5dc45035c3c278c','::1'), ('4','1','2017-06-07 11:29:48','2017-06-07 11:33:10','33cd946d0692762be5dc45035c3c278c','::1'), ('5','1','2017-07-21 19:23:49','2017-07-21 19:24:05','33cd946d0692762be5dc45035c3c278c','::1'), ('6','1','2017-07-21 19:55:54','2017-07-21 22:19:46','33cd946d0692762be5dc45035c3c278c','::1'), ('7','1','2017-07-22 08:49:20','2017-07-22 08:49:20','33cd946d0692762be5dc45035c3c278c','::1'), ('8','1','2017-07-22 08:49:22','2017-07-22 11:00:51','33cd946d0692762be5dc45035c3c278c','::1');
INSERT INTO `contacts` VALUES ('1','1','2017-07-21 21:43:03',NULL,NULL,NULL,'NIKE','nike@email.com','41','30304040',NULL,'',NULL,NULL,NULL), ('2','1','2017-07-22 09:06:57','2017-07-22 10:55:30',NULL,'1','MANO ALTERA','mano@email.com','','',NULL,'',NULL,'1',NULL);
