/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : shoppingcart

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-04-09 11:10:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('7', null, null, null, null, '2016-04-09 06:07:33');
INSERT INTO `customers` VALUES ('8', null, null, null, null, '2016-04-09 06:08:09');
INSERT INTO `customers` VALUES ('9', 'doanh', 'doanhvt92@gmail.com', '0982425083', 'ha noi', '2016-04-09 06:08:37');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customerid` (`customerid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('2', '8', '2016-04-09 06:08:09');
INSERT INTO `orders` VALUES ('3', '9', '2016-04-09 06:08:37');

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`),
  KEY `productid` (`productid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_detail
-- ----------------------------
INSERT INTO `order_detail` VALUES ('1', '2', '14', '1', '17490000');
INSERT INTO `order_detail` VALUES ('2', '3', '14', '1', '17490000');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `name_url` varchar(250) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `contents` varchar(500) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `time_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('9', 'Điện thoại Microsoft Lumia 640 XL', null, 'gl5.jpg', 'Microsoft Lumia 640 XL', 'Điện thoại Microsoft Lumia 640 XL', '4590000', '2016-04-08 10:44:26');
INSERT INTO `products` VALUES ('10', 'Samsung Galaxy Grand Prime G530', null, 'gl5.jpg', 'Samsung Galaxy Grand Prime G530', 'Samsung Galaxy Grand Prime G530', '4190000', '2016-04-08 10:45:28');
INSERT INTO `products` VALUES ('11', 'Điện thoại iPhone 4S 8GB', null, 'gl5.jpg', 'Điện thoại iPhone 4S 8GB', 'Điện thoại iPhone 4S 8GB', '4990000', '2016-04-08 10:46:15');
INSERT INTO `products` VALUES ('12', 'Điện thoại Microsoft Lumia 430', null, 'gl5.jpg', 'Điện thoại Microsoft Lumia 430', 'Điện thoại Microsoft Lumia 430', '1990000', '2016-04-08 10:46:59');
INSERT INTO `products` VALUES ('13', 'Điện thoại Sony Xperia M4 Aqua Dual', null, 'gl5.jpg', 'Điện thoại Sony Xperia M4 Aqua Dual', 'Điện thoại Sony Xperia M4 Aqua Dual', '10500000', '2016-04-08 10:47:52');
INSERT INTO `products` VALUES ('14', 'Điện thoại Samsung Galaxy Note 4', null, 'gl5.jpg', 'Điện thoại Samsung Galaxy Note 4', 'Điện thoại Samsung Galaxy Note 4', '17490000', '2016-04-08 10:48:26');
