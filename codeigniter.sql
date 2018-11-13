/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100110
 Source Host           : localhost:3306
 Source Schema         : codeigniter

 Target Server Type    : MySQL
 Target Server Version : 100110
 File Encoding         : 65001

 Date: 13/11/2018 13:47:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime(0) NOT NULL,
  `modified` datetime(0) NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (3, 'omar', 'omar@pucv.cl', '4d186321c1a7f0f354b297e8914ab240', 'Male', '97725057', '2018-11-13 15:23:58', '2018-11-13 15:23:58', '1');
INSERT INTO `users` VALUES (4, 'felipe', 'felipe@piucv.cl', '4d186321c1a7f0f354b297e8914ab240', 'Male', '123546', '2018-11-13 15:36:38', '2018-11-13 15:36:38', '1');

SET FOREIGN_KEY_CHECKS = 1;
