/*
Navicat MySQL Data Transfer

Source Server         : 1- LOCALHOST
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : contactproject

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2017-04-27 14:23:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for contacts
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
