/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : seara

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-05-10 11:22:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `company_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_fantasy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_cnpj` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_complement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_district` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_addr_cep` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_brand_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `companies_company_cnpj_unique` (`company_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES ('7', 'FRANCISCO ANTONIO FEITOSA DE OLIVEIRA 96439670344', 'EXCELLENCE SOFT', '22.002.899/0001-14', 'R CAMPO MAIOR', '168 ', '', 'DENDE', 'FORTALEZA', 'CE', '60.714-730', '(85)3493-6894', '', '', '2017-04-07 21:39:01', '2017-04-07 21:39:01');
INSERT INTO `companies` VALUES ('8', 'Alguma coisa', '', '', '', '', '', '', '', '', '', '', '', '', null, null);
