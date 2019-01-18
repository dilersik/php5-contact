/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : contactproject

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-07-22 11:04:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_area_un
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
-- Records of admin_area_un
-- ----------------------------
INSERT INTO `admin_area_un` VALUES ('1', '1', '1', '1');
INSERT INTO `admin_area_un` VALUES ('2', '1', '2', '1');

-- ----------------------------
-- Table structure for admin_areas
-- ----------------------------
DROP TABLE IF EXISTS `admin_areas`;
CREATE TABLE `admin_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_areas
-- ----------------------------
INSERT INTO `admin_areas` VALUES ('1', '1', 'Administrador');
INSERT INTO `admin_areas` VALUES ('2', '1', 'Gerenciar conteúdos');

-- ----------------------------
-- Table structure for admin_logins
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admins
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
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', '1', '2012-02-24 14:11:00', '2012-05-29 14:52:38', '1', null, '33cd946d0692762be5dc45035c3c278c', 'Diler', null, 'di_ler@hotmail.com', 'diler', '5c59d9f743936543194a1cc680b7829334532e5131df04bf59daa468388a4a2b0e24a7d858649e16bc51574271e41a83310873a4408fa2cc373fc1fed4047885', '');
INSERT INTO `admins` VALUES ('2', '1', '2017-07-22 11:00:51', null, '1', null, '1efc7e513e59ff4aba20bea78fdff8d2', 'TESTE', null, 'teste@teste.com', 'teste', '5c59d9f743936543194a1cc680b7829334532e5131df04bf59daa468388a4a2b0e24a7d858649e16bc51574271e41a83310873a4408fa2cc373fc1fed4047885', '::1');
SET FOREIGN_KEY_CHECKS=1;
