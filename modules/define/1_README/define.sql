/*
Navicat MySQL Data Transfer

Source Server         : 1- LOCALHOST
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : contactproject

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2017-04-27 14:24:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for defines
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
