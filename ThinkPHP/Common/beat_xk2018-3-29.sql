/*
Navicat MySQL Data Transfer

Source Server         : pp
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : beat_xk

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-23 17:59:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `xk_admin`
-- ----------------------------
DROP TABLE IF EXISTS `xk_admin`;
CREATE TABLE `xk_admin` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(11) CHARACTER SET utf8 NOT NULL COMMENT '用户代码',
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户名称',
  `mobile` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `cp_id` int(20) NOT NULL DEFAULT '0' COMMENT '所属公司id',
  `is_qy` smallint(1) NOT NULL DEFAULT '1' COMMENT '是否启用 1是 0否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户(职业顾问)表';

-- ----------------------------
-- Records of xk_admin
-- ----------------------------
INSERT INTO `xk_admin` VALUES ('1', 'admin', '系统管理员', '13999999999', 'd23c305cd9b8fb70c47b0f9633d12d21', '0', '1');

-- ----------------------------
-- Table structure for `xk_applyqdhz`
-- ----------------------------
DROP TABLE IF EXISTS `xk_applyqdhz`;
CREATE TABLE `xk_applyqdhz` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `lxfs` varchar(50) NOT NULL,
  `company` varchar(30) NOT NULL,
  `prov` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `createdtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_applyqdhz
-- ----------------------------
INSERT INTO `xk_applyqdhz` VALUES ('1', 'uuu', 'uuu@111.com', 'uuu', '四川', '成都市', '1520396245');

-- ----------------------------
-- Table structure for `xk_applytest`
-- ----------------------------
DROP TABLE IF EXISTS `xk_applytest`;
CREATE TABLE `xk_applytest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `telphone` varchar(11) NOT NULL,
  `company` varchar(50) NOT NULL,
  `content` varchar(100) DEFAULT NULL,
  `createdtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_applytest
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_build`
-- ----------------------------
DROP TABLE IF EXISTS `xk_build`;
CREATE TABLE `xk_build` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '楼栋id',
  `pc_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '批次id',
  `proj_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目id',
  `buildname` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '楼栋名称',
  `buildcode` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '楼栋编号',
  `bldtype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '楼栋属性：0住宅、1车位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='楼栋表';

-- ----------------------------
-- Records of xk_build
-- ----------------------------
INSERT INTO `xk_build` VALUES ('1', '1', '1', 'LOFT', '0', '0');
INSERT INTO `xk_build` VALUES ('2', '1', '1', 'SOHO', '0', '0');
INSERT INTO `xk_build` VALUES ('3', '1', '1', '1栋', '1', '0');
INSERT INTO `xk_build` VALUES ('4', '2', '2', '104栋', '104', '0');
INSERT INTO `xk_build` VALUES ('14', '0', '2', '2栋', '2', '0');
INSERT INTO `xk_build` VALUES ('7', '0', '2', '3栋', '3', '0');
INSERT INTO `xk_build` VALUES ('8', '0', '2', '4栋', '4', '0');
INSERT INTO `xk_build` VALUES ('9', '0', '2', '5栋', '5', '0');
INSERT INTO `xk_build` VALUES ('13', '0', '2', '1栋', '1', '0');
INSERT INTO `xk_build` VALUES ('16', '4', '2', '6栋', '6', '0');
INSERT INTO `xk_build` VALUES ('17', '0', '3', '3号楼', '3', '0');
INSERT INTO `xk_build` VALUES ('18', '0', '3', '4号楼', '4', '0');
INSERT INTO `xk_build` VALUES ('19', '0', '2', '11栋', '11', '0');
INSERT INTO `xk_build` VALUES ('20', '0', '2', '33栋', '33', '0');

-- ----------------------------
-- Table structure for `xk_choose`
-- ----------------------------
DROP TABLE IF EXISTS `xk_choose`;
CREATE TABLE `xk_choose` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `batch_id` bigint(20) DEFAULT '0' COMMENT '批次号',
  `customer_name` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '客户名称',
  `customer_phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `cardno` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '身份证号码',
  `cyjno` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `row_number` int(11) DEFAULT '0' COMMENT '排号号码',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '诚意金金额',
  `area` decimal(10,2) DEFAULT '0.00' COMMENT '意向面积',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '意向金额',
  `house_type` varchar(25) CHARACTER SET utf8 DEFAULT '' COMMENT '意向户型',
  `floor` varchar(10) CHARACTER SET utf8 DEFAULT '' COMMENT '意向楼层',
  `room` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '意向房间',
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码',
  `remark` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-关闭',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  `ywy` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '置业顾问',
  `ywyphone` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '置业顾问电话',
  `start_time` int(11) DEFAULT '0' COMMENT '生效时间',
  `ys_time` int(5) DEFAULT NULL COMMENT '延迟时间:以分为单位',
  `like_p` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `like_c` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否签到：0否1是',
  `sign_time` int(11) DEFAULT '0',
  `is_admission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未入场，1入场',
  `admission_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='竞价选房';

-- ----------------------------
-- Records of xk_choose
-- ----------------------------
INSERT INTO `xk_choose` VALUES ('103', '2', '2', '薛先生', 'M!T6g338OWDfIgwhOMD*gLwODYO0O0O', 'N!T6E3w8MWzfAgzhMMT*kL5NTA3MDkwMzIy', '001', '0', '0.00', '0.00', '0.00', '', '', null, null, '', '1', '1515115689', '192.168.2.99', '置业顾问1', '18111111113', '0', '0', '54|56|48|56|56|48|50|56|55|56|49|', '50|50|51|48|57|48|55|48|53|57|57|49|51|48|51|48|49|53|', '1', '1521683026', '0', '1521770323');
INSERT INTO `xk_choose` VALUES ('104', '2', '2', '姜001', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', 'N!T6E3w8MWzfAgzhMMT*kL5NTA3MDkwMzIx', '002', '0', '0.00', '0.00', '0.00', '', '', null, null, '', '1', '1513388299', '127.0.0.1', '置业顾问1', '18111111111', '0', '0', '53|54|56|53|50|52|51|57|54|51|49|', '49|50|51|48|57|48|55|48|53|57|57|49|51|48|51|48|49|53|', '1', '1521698758', '0', '1517824226');
INSERT INTO `xk_choose` VALUES ('108', '2', '2', '姜先生', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', 'N!T6E3w8NWDfAgzhMMT*kL4MjEyMDQwMzFYOzUxMDMwMzE5OTUwNzA5MDMyMgO0O0OO0O0O', '003', '0', '8000.00', '0.00', '0.00', '', '', null, null, '', '1', '1515737749', '127.0.0.1', '置业顾问1', '13898989898', '0', '10', '50|51|54|57|50|50|51|56|53|56|49|', '50|50|51|48|57|48|55|48|53|57|57|49|51|48|51|48|49|53|59|88|49|51|48|52|48|50|49|50|56|57|49|51|48|52|48|49|53|', '1', '1521698765', '0', '1521770326');
INSERT INTO `xk_choose` VALUES ('110', '2', '2', '李四', 'M!T6I3z8NWDfUg2hNMz*gL5MDEO0O0O', 'M!z6E3w8NWTfAgxhMMT*kL5MzA4MDYwNzUx', '004', '0', '0.00', '0.00', '0.00', '', '', '', null, '', '1', '1516177219', '127.0.0.1', '', '', '0', '0', '49|48|57|56|55|54|53|52|51|50|49|', '49|53|55|48|54|48|56|48|51|57|57|49|49|48|53|48|49|51|', '1', '1521698760', '0', '0');
INSERT INTO `xk_choose` VALUES ('111', '2', '2', '王五', 'M!T6I3z8NWDfUg2hNMz*gL5MDIO0O0O', 'N!T6E3w8MWTfBgYhWMF*hLYWFhYWDAzMDIO0O0O', '005', '0', '0.00', '0.00', '0.00', '', '', '', null, '', '1', '1516177262', '127.0.0.1', '置业顾问1', '', '0', '0', '50|48|57|56|55|54|53|52|51|50|49|', '50|48|51|48|88|88|88|88|88|88|88|88|48|49|48|49|53|', '0', '0', '1', '1521516747');
INSERT INTO `xk_choose` VALUES ('115', '2', '2', '新城test1', 'M!T6I3z8NWDfUg2hNMz*gL5MDAO0O0O', 'M!T6I3z8NWDfUg2hMMT*kL4ODA4MDgO0O0O', '006', null, '0.00', '0.00', '0.00', '', '', null, null, '', '1', '1518334205', '192.168.2.103', '云销控', '18108255285', '0', '0', '48|48|57|56|55|54|53|52|51|50|49|', '56|48|56|48|56|56|57|49|54|53|52|51|50|49|', '1', '1521698771', '0', '0');
INSERT INTO `xk_choose` VALUES ('116', '2', '2', '新城test2', 'M!T6g348MWTfIgzhNMD*gL4ODIO0O0O', 'M!T6I3z8NWDfUg2hMMT*kL4ODA4MDg1NgO0O0OO0O0O', '010', null, '0.00', '0.00', '0.00', '', '', null, null, '', '1', '1518334205', '192.168.2.103', '云销控', '18108255285', '0', '0', '50|56|56|56|52|51|50|49|56|56|49|', '54|53|56|48|56|48|56|56|57|49|54|53|52|51|50|49|', '0', '0', '0', '0');
INSERT INTO `xk_choose` VALUES ('117', '2', '2', '薛85', 'M!T6g338OWDfIgwhOMD*gLwODgO0O0O', 'M!T6I3z8NWDfUg2hMMT*kL4ODA4MDg1Njc4', '007', '0', '0.00', '0.00', '0.00', '', '', '', null, '', '1', '1520406239', '192.168.2.103', '云销控', '18782088085', '0', '0', '56|56|48|56|56|48|50|56|55|56|49|', '56|55|54|53|56|48|56|48|56|56|57|49|54|53|52|51|50|49|', '0', '0', '0', '0');
INSERT INTO `xk_choose` VALUES ('118', '2', '2', '新城test3', 'M!T6M328OWTfMg0hMMj*UL4NjgO0O0O', 'M!T6I3z8NWDfUg2hMMT*kL4ODA4MDg5ODky', '008', null, '8.00', '0.00', '0.00', '', '', null, null, '', '1', '1520413709', '192.168.2.103', '云销控', '18108255285', '0', '0', '56|54|56|53|50|52|51|57|54|51|49|', '50|57|56|57|56|48|56|48|56|56|57|49|54|53|52|51|50|49|', '0', '0', '0', '0');
INSERT INTO `xk_choose` VALUES ('120', '2', '2', 'ggg', 'M!T6M328OWTfMg0hMMj*UL5OTkO0O0O', 'M!T6I3z8NWDfUg2hMMT*kL4ODA4MDg1NgO0O0OO0O0O', '009', '0', '1000.00', '0.00', '0.00', '', '', null, null, '', '1', '1520836144', '127.0.0.1', '', '', '0', '0', '57|57|57|53|50|52|51|57|54|51|49|', '54|53|56|48|56|48|56|56|57|49|54|53|52|51|50|49|', '1', '1521698790', '0', '0');

-- ----------------------------
-- Table structure for `xk_choose2user_log`
-- ----------------------------
DROP TABLE IF EXISTS `xk_choose2user_log`;
CREATE TABLE `xk_choose2user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `choose_id` int(11) NOT NULL COMMENT '客户id',
  `log_type` varchar(15) NOT NULL COMMENT '记录类型，签到，取消签到，入场，取消入场',
  `user_id` int(11) NOT NULL COMMENT '操作人',
  `log_time` int(11) NOT NULL COMMENT '操作时间',
  `log_ip` varchar(20) NOT NULL COMMENT '操作ip',
  `cst_name` varchar(20) NOT NULL COMMENT '签到人名字，或者入场人的名字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_choose2user_log
-- ----------------------------
INSERT INTO `xk_choose2user_log` VALUES ('1', '97', '签到', '1', '1516950162', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('2', '100', '签到', '1', '1516950514', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('13', '100', '取消签到', '1', '1516951253', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('14', '100', '签到', '1', '1516951256', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('15', '100', '取消签到', '1', '1516951257', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('16', '100', '签到', '1', '1516951259', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('17', '100', '取消签到', '1', '1516951261', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('18', '100', '签到', '1', '2147483647', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('19', '100', '取消签到', '1', '1516951336', '11111111111111111111', '');
INSERT INTO `xk_choose2user_log` VALUES ('20', '100', '签到', '1', '1516951957', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('21', '100', '取消签到', '1', '1516951959', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('22', '97', '入场', '1', '1516957826', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('23', '97', '取消入场', '1', '1516957911', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('24', '97', '入场', '1', '1517211319', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('25', '100', '签到', '1', '1517909557', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('26', '100', '取消签到', '1', '1517909562', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('27', '100', '签到', '1', '1517909774', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('28', '108', '签到', '1', '1517909786', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('29', '103', '签到', '1', '1517909855', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('30', '109', '签到', '1', '1517909891', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('31', '109', '取消签到', '1', '1517909931', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('32', '109', '签到', '1', '1517909942', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('33', '97', '取消签到', '1', '1517910082', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('34', '100', '取消签到', '1', '1517910084', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('35', '108', '取消签到', '1', '1517910085', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('36', '75', '签到', '1', '1517969525', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('37', '100', '签到', '1', '1517971638', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('38', '97', '签到', '1', '1517972095', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('39', '97', '取消入场', '1', '1517976470', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('40', '103', '入场', '1', '1517976559', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('41', '97', '入场', '1', '1517976599', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('42', '97', '取消入场', '1', '1517976612', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('43', '97', '入场', '1', '1517976728', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('44', '108', '签到', '1', '1518070434', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('45', '108', '取消签到', '1', '1518070439', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('46', '111', '签到', '1', '1518073401', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('47', '111', '签到', '1', '1518073402', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('48', '111', '取消签到', '1', '1518073407', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('49', '112', '签到', '1', '1518076630', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('50', '112', '取消签到', '1', '1518076632', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('51', '112', '签到', '1', '1518076670', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('52', '112', '取消签到', '1', '1518076673', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('53', '112', '签到', '1', '1518076765', '127.0.0.1', 'ggg');
INSERT INTO `xk_choose2user_log` VALUES ('54', '112', '取消签到', '1', '1518076844', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('55', '108', '签到', '1', '1518076857', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('56', '108', '取消签到', '1', '1518076881', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('57', '97', '取消签到', '1', '1518076883', '127.0.0.1', '是是是');
INSERT INTO `xk_choose2user_log` VALUES ('58', '112', '签到', '1', '1518076890', '127.0.0.1', 'ggg');
INSERT INTO `xk_choose2user_log` VALUES ('59', '112', '取消签到', '1', '1518076892', '127.0.0.1', 'ggg');
INSERT INTO `xk_choose2user_log` VALUES ('60', '108', '签到', '1', '1518080950', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('61', '108', '取消签到', '1', '1518081925', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('62', '108', '签到', '1', '1518082157', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('63', '108', '取消签到', '1', '1518082178', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('64', '108', '签到', '1', '1518082849', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('65', '110', '签到', '1', '1518082871', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('66', '110', '取消签到', '1', '1518082910', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('67', '110', '签到', '1', '1518082925', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('68', '110', '取消签到', '1', '1518082964', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('69', '108', '取消签到', '1', '1518082966', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('70', '108', '', '1', '1518083559', '127.0.0.1', '姜学伟');
INSERT INTO `xk_choose2user_log` VALUES ('71', '110', '', '1', '1518083559', '127.0.0.1', '姜学伟');
INSERT INTO `xk_choose2user_log` VALUES ('72', '108', '取消签到', '1', '1518083599', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('73', '110', '取消签到', '1', '1518083601', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('74', '108', '签到', '1', '1518083651', '127.0.0.1', '姜学伟');
INSERT INTO `xk_choose2user_log` VALUES ('75', '110', '签到', '1', '1518083651', '127.0.0.1', '姜学伟');
INSERT INTO `xk_choose2user_log` VALUES ('76', '108', '取消签到', '1', '1518139904', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('77', '110', '取消签到', '1', '1518139907', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('78', '108', '签到', '1', '1518139917', '127.0.0.1', '姜学伟');
INSERT INTO `xk_choose2user_log` VALUES ('79', '110', '签到', '1', '1518139917', '127.0.0.1', '姜学伟');
INSERT INTO `xk_choose2user_log` VALUES ('80', '110', '入场', '1', '1518140635', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('81', '110', '取消入场', '1', '1518141224', '127.0.0.1', '');
INSERT INTO `xk_choose2user_log` VALUES ('82', '110', '入场', '1', '1518141414', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('83', '110', '取消入场', '1', '1518141437', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('84', '97', '取消入场', '1', '1518141463', '127.0.0.1', '是是是');
INSERT INTO `xk_choose2user_log` VALUES ('85', '100', '入场', '1', '1518141488', '127.0.0.1', '姜姜姜');
INSERT INTO `xk_choose2user_log` VALUES ('86', '112', '入场', '1', '1518141492', '127.0.0.1', 'ggg');
INSERT INTO `xk_choose2user_log` VALUES ('87', '108', '入场', '1', '1518141507', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('88', '110', '入场', '1', '1518141510', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('89', '108', '取消入场', '1', '1518141894', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('90', '110', '取消入场', '1', '1518141897', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('91', '108', '入场', '1', '1518141915', '127.0.0.1', '姜学伟2');
INSERT INTO `xk_choose2user_log` VALUES ('92', '110', '入场', '1', '1518141915', '127.0.0.1', '姜学伟1');
INSERT INTO `xk_choose2user_log` VALUES ('93', '108', '取消入场', '1', '1518141984', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('94', '108', '入场', '1', '1518141993', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('95', '110', '取消入场', '1', '1518142040', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('96', '108', '签到', '1', '1518226311', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('97', '108', '取消签到', '1', '1518226320', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('98', '108', '签到', '1', '1518226337', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('99', '108', '入场', '1', '1520237335', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('100', '108', '取消入场', '1', '1520471329', '127.0.0.1', '好好');
INSERT INTO `xk_choose2user_log` VALUES ('101', '110', '签到', '1', '1520471590', '127.0.0.1', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('102', '115', '签到', '1', '1521514331', '192.168.2.104', '新城test1');
INSERT INTO `xk_choose2user_log` VALUES ('103', '103', '入场', '1', '1521516745', '192.168.2.104', '薛先生');
INSERT INTO `xk_choose2user_log` VALUES ('104', '111', '入场', '1', '1521516747', '192.168.2.104', '王五');
INSERT INTO `xk_choose2user_log` VALUES ('105', '108', '取消签到', '1', '1521540768', '127.0.0.1', '姜先生');
INSERT INTO `xk_choose2user_log` VALUES ('106', '103', '签到', '17', '1521683026', '127.0.0.1', '薛先生');
INSERT INTO `xk_choose2user_log` VALUES ('107', '115', '取消签到', '1', '1521698735', '192.168.2.88', '新城test1');
INSERT INTO `xk_choose2user_log` VALUES ('108', '110', '取消签到', '1', '1521698737', '192.168.2.88', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('109', '104', '取消签到', '1', '1521698738', '192.168.2.88', '姜001');
INSERT INTO `xk_choose2user_log` VALUES ('110', '104', '签到', '1', '1521698758', '192.168.2.88', '姜001');
INSERT INTO `xk_choose2user_log` VALUES ('111', '110', '签到', '1', '1521698760', '192.168.2.88', '李四');
INSERT INTO `xk_choose2user_log` VALUES ('112', '108', '签到', '1', '1521698765', '192.168.2.88', '姜先生');
INSERT INTO `xk_choose2user_log` VALUES ('113', '115', '签到', '1', '1521698771', '192.168.2.88', '新城test1');
INSERT INTO `xk_choose2user_log` VALUES ('114', '120', '签到', '1', '1521698790', '192.168.2.88', 'ggg');
INSERT INTO `xk_choose2user_log` VALUES ('115', '108', '入场', '1', '1521770243', '192.168.2.88', '姜先生');
INSERT INTO `xk_choose2user_log` VALUES ('116', '103', '取消入场', '1', '1521770323', '192.168.2.88', '薛先生');
INSERT INTO `xk_choose2user_log` VALUES ('117', '108', '取消入场', '1', '1521770326', '192.168.2.88', '姜先生');

-- ----------------------------
-- Table structure for `xk_choose_activity`
-- ----------------------------
DROP TABLE IF EXISTS `xk_choose_activity`;
CREATE TABLE `xk_choose_activity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '活动名称',
  `description` text COLLATE utf8_unicode_ci COMMENT '描述',
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `batch_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '批次号',
  `sort` int(11) DEFAULT '1' COMMENT '轮次',
  `person_count` int(11) NOT NULL DEFAULT '0' COMMENT '人数',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `long_time` int(10) DEFAULT '120' COMMENT '竞价时长(默认2分钟)(单位:秒)',
  `type` varchar(50) CHARACTER SET utf8 DEFAULT 'order' COMMENT '补位规则【单选】【随机rand，顺序order】',
  `remark` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-关闭',
  `add_user_id` bigint(20) DEFAULT '0' COMMENT '添加的用户',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='竞价选房活动';

-- ----------------------------
-- Records of xk_choose_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_choose_log`
-- ----------------------------
DROP TABLE IF EXISTS `xk_choose_log`;
CREATE TABLE `xk_choose_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `choose_id` bigint(20) NOT NULL,
  `activity_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当前出价',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '1-已经阅读',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-关闭',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  `is_pwcg` tinyint(1) DEFAULT '0' COMMENT '1-本轮排位成功',
  `pxh` smallint(10) DEFAULT '0' COMMENT '本轮竞拍入场序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户竞价选房记录';

-- ----------------------------
-- Records of xk_choose_log
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_choose_user`
-- ----------------------------
DROP TABLE IF EXISTS `xk_choose_user`;
CREATE TABLE `xk_choose_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `batch_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '批次号',
  `choose_id` bigint(20) NOT NULL DEFAULT '0',
  `customer_phone` char(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '客户手机号',
  `password` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '登录密码',
  `is_login` tinyint(1) DEFAULT '0' COMMENT '1-登录过',
  `login_time` int(10) DEFAULT '0' COMMENT '登录时间,判断是否为当天有用',
  `login_ip` varchar(15) CHARACTER SET utf8 DEFAULT '0.0.0.0' COMMENT '登录IP',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-关闭',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户密码登录相关';

-- ----------------------------
-- Records of xk_choose_user
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_company`
-- ----------------------------
DROP TABLE IF EXISTS `xk_company`;
CREATE TABLE `xk_company` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司id',
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `addres` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司地址',
  `mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司联系电话',
  `createdate` int(10) DEFAULT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='公司';

-- ----------------------------
-- Records of xk_company
-- ----------------------------
INSERT INTO `xk_company` VALUES ('1', '测试公司', '成都', null, null);
INSERT INTO `xk_company` VALUES ('2', '链商科技', '成都', null, null);

-- ----------------------------
-- Table structure for `xk_cst2rooms`
-- ----------------------------
DROP TABLE IF EXISTS `xk_cst2rooms`;
CREATE TABLE `xk_cst2rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cst_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `room_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '房间id',
  `sctime` int(10) DEFAULT NULL COMMENT '收藏时间',
  `proj_id` bigint(20) DEFAULT NULL,
  `px` int(11) DEFAULT NULL,
  `eventId` int(11) DEFAULT '0' COMMENT '微信认购活动id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='客户收藏房间对应表';

-- ----------------------------
-- Records of xk_cst2rooms
-- ----------------------------
INSERT INTO `xk_cst2rooms` VALUES ('4', '98', '1020', '1513563248', '1', '1', '1');
INSERT INTO `xk_cst2rooms` VALUES ('110', '104', '1275', '1518405195', '2', '1', '2');
INSERT INTO `xk_cst2rooms` VALUES ('129', '104', '1242', '1521518498', '2', '3', '2');
INSERT INTO `xk_cst2rooms` VALUES ('112', '103', '1226', '1520408078', '2', '2', '2');
INSERT INTO `xk_cst2rooms` VALUES ('113', '103', '1237', '1520408088', '2', '3', '2');
INSERT INTO `xk_cst2rooms` VALUES ('114', '103', '1242', '1520408329', '2', '4', '2');
INSERT INTO `xk_cst2rooms` VALUES ('115', '103', '1188', '1520408335', '2', '5', '2');
INSERT INTO `xk_cst2rooms` VALUES ('116', '103', '1167', '1520408341', '2', '6', '2');
INSERT INTO `xk_cst2rooms` VALUES ('117', '103', '1258', '1520408346', '2', '7', '2');
INSERT INTO `xk_cst2rooms` VALUES ('118', '103', '1264', '1520408352', '2', '8', '2');
INSERT INTO `xk_cst2rooms` VALUES ('119', '103', '1166', '1520408358', '2', '1', '2');
INSERT INTO `xk_cst2rooms` VALUES ('130', '104', '1236', '1521518504', '2', '4', '2');
INSERT INTO `xk_cst2rooms` VALUES ('128', '104', '1268', '1521518494', '2', '2', '2');
INSERT INTO `xk_cst2rooms` VALUES ('122', '108', '1268', '1521022886', '2', '1', '2');
INSERT INTO `xk_cst2rooms` VALUES ('123', '108', '1227', '1521022891', '2', '2', '2');
INSERT INTO `xk_cst2rooms` VALUES ('124', '6', '1275', '1518405195', '2', '1', '0');
INSERT INTO `xk_cst2rooms` VALUES ('125', '6', '1274', '1518405195', '2', '2', '0');
INSERT INTO `xk_cst2rooms` VALUES ('126', '6', '1273', '1518405195', '2', '1', '0');

-- ----------------------------
-- Table structure for `xk_customer`
-- ----------------------------
DROP TABLE IF EXISTS `xk_customer`;
CREATE TABLE `xk_customer` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '客户昵称',
  `mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机',
  `sex` tinyint(1) DEFAULT '1' COMMENT '1男，2女',
  `openid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires_in` int(12) DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '登录IP',
  `appid` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目微信APPID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='客户信息(购房者)表';

-- ----------------------------
-- Records of xk_customer
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_event_order_house`
-- ----------------------------
DROP TABLE IF EXISTS `xk_event_order_house`;
CREATE TABLE `xk_event_order_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL COMMENT '公司ID 外键 xk_copany id',
  `project_id` int(11) NOT NULL COMMENT '项目ID 外键 xk_project id',
  `batch_id` int(11) NOT NULL COMMENT '批次ID 外键 xk_kppc id',
  `name` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动名称',
  `desc` text COLLATE utf8_unicode_ci COMMENT '活动描述',
  `start_time` int(11) NOT NULL COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL COMMENT '活动结束时间',
  `states` tinyint(1) NOT NULL COMMENT '活动状态',
  `mark` text COLLATE utf8_unicode_ci COMMENT '标记',
  `visit_count` int(11) NOT NULL DEFAULT '0',
  `use_count` int(11) NOT NULL DEFAULT '0',
  `log_time` int(11) NOT NULL,
  `rdd_project_name` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'rdd 冗余\r\n            搜索项目名称',
  `maxcount` tinyint(2) DEFAULT '0' COMMENT '每人允许添加备选房间个数',
  `isysdl` tinyint(1) DEFAULT '0' COMMENT '是否开启延时登录功能；1是，0否',
  `loginimg` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机端微信开盘登录图片地址',
  `is_show_discount` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示优惠价格',
  `is_aqyz` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启安全验证',
  `is_short_message` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启手机短信验证登录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xk_event_order_house
-- ----------------------------
INSERT INTO `xk_event_order_house` VALUES ('1', '1', '1', '1', '测试', '1. 本次在线选房活动，为链商科技对外演示云销控系统的活动，非真实活动。\r\n 2. 本次开盘总共推售168套房源，活动开始后，所有客户同时进行在线选房，每个客户(手机号)只能成功选择一个房间。 \r\n 3. 选中房源后，请按照公司要求及时办理认筹手续，逾期未办理视为自动放弃，已收取的认筹金不予退还，且我司有权将此房屋另售他人，不再另行通知。\r\n4.【链商科技 项目部】拥有此活动最终解释权。', '1513551944', '1516284770', '1', '请于XX月XX日17:00前到【XX项目销售部】办理认购手续；逾期未办理视为自动放弃，已收取的认筹金不予退还，且我司有权将此房屋另售他人，不再另行通知！', '0', '0', '1515391586', null, '5', '0', '/Uploads/img/wxlogin/xmbg.jpg', '0', '0', '1');
INSERT INTO `xk_event_order_house` VALUES ('2', '2', '2', '2', '一批次微信开盘', '本次活动为&quot;云销控-微信开盘&quot;在线体验活动，非正式活动！！\r\n1 、您知悉并同意此次线上选房采取通过个人设备登陆“云景府”微信公众号线上选定房源的流程和操作方式进行，您在选房前已自行通过“云景府”微信公众号或向销售中心工作人员学习、了解并熟悉选定房源的流程和操作方式，并自行参加模拟选房测试过程。选房过程中，可能因为个人设备或网络故障等原因致使不能成功选房的，本公司不承担任何责任。 \r\n2 、您已知悉并同意此次在线选定的房号即视为您已选定的房源，应在选房当日17:00前携带认筹协议、诚意金收据、在线选房的房源确认短信、应付房款及产权名义人身份证原件到云景府销售中心签订《房屋定购合同》，且产权名义人必须是您本人或配偶、父母及子女。\r\n3 、您已知悉此次在线选房选定房源后，诚意金自动转为定金。若您未能在约定时间内签订 《房屋定购合同》等相关合同和协议，本公司有权单方面将选定房源另行出售，且您所付定金不予退还。 \r\n4 、您已知悉并同意前期本项目销售物料及宣传资料上载明的项目总平图、房屋栋号、房号等信息仅供参考，后期可能存在调整，项目总平图、房屋栋号、房号等信息均以选房当日“云景府”微信公众号公示的信息为准。\r\n6 、您确认使用 《云景府项目线上选房客户信息确认单 》 上的信息购买本项目房屋，该信息与后期签订的 《 商品房买卖合同 》 上载明的客户信息一致，并且与在线选房登录的客户信息一致。请仔细阅读，对其内容及事项无异议后方可开始网上选房。', '1521518352', '1521543600', '1', '你已认购成功，请于2018年XX月XX日12:30前至财务部办理认购手续，逾期来办理视为自动放弃，我司有权将此房屋另售他人。', '0', '0', '1521518364', null, '8', '0', '/Uploads/img/wxlogin/20180207/5a7a6a3f512a5.png', '0', '0', '0');
INSERT INTO `xk_event_order_house` VALUES ('4', '2', '2', '4', '二批次微信开盘测试1', '测试1', '1516868465', '1517041282', '0', '', '0', '0', '1520241566', null, '5', '1', '/Uploads/img/wxlogin/20180125/5a6993a981843.jpg', '0', '0', '1');
INSERT INTO `xk_event_order_house` VALUES ('5', '2', '2', '4', '自用测试', '鬼鬼鬼', '1520242545', '1522316150', '1', '', '0', '0', '1521517888', null, '5', '0', '/Uploads/img/wxlogin/20180305/5a9d0f8720bed.png', '0', '0', '1');

-- ----------------------------
-- Table structure for `xk_fun`
-- ----------------------------
DROP TABLE IF EXISTS `xk_fun`;
CREATE TABLE `xk_fun` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '模块名称',
  `parent_id` int(20) DEFAULT NULL COMMENT '父级id，自关联',
  `is_Enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1启用，0禁用',
  `px` tinyint(3) DEFAULT NULL COMMENT '排序',
  `url` varchar(100) DEFAULT NULL COMMENT '地址',
  `createdate` int(11) DEFAULT NULL COMMENT '创建日期，时间戳形式存储的时间，自动保存',
  `icon` varchar(35) DEFAULT NULL COMMENT '描述备注',
  `is_fun` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否功模块；1是  0否',
  `is_mobile` tinyint(1) DEFAULT '0' COMMENT '区分后台功能还是手机端功能；0后台， 1手机',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COMMENT='功能模块表-luolongf';

-- ----------------------------
-- Records of xk_fun
-- ----------------------------
INSERT INTO `xk_fun` VALUES ('1', '客户信息', '0', '1', '1', 'ChooseUser/index', null, 'icon-group', '1', '0');
INSERT INTO `xk_fun` VALUES ('2', '微信开盘', '0', '0', '4', null, null, 'icon-comments', '1', '0');
INSERT INTO `xk_fun` VALUES ('3', '入场选房', '0', '0', '5', null, null, ' icon-laptop', '1', '0');
INSERT INTO `xk_fun` VALUES ('4', '基础数据设置', '0', '0', '98', null, null, 'icon-cog', '1', '0');
INSERT INTO `xk_fun` VALUES ('5', '用户权限设置', '0', '0', '99', null, null, 'icon-cogs', '1', '0');
INSERT INTO `xk_fun` VALUES ('6', '选房摇号', '0', '0', '3', null, null, ' icon-exclamation-sign', '1', '0');
INSERT INTO `xk_fun` VALUES ('7', '客户签到', '0', '1', '2', 'CstSign/index', null, 'icon-check', '1', '0');
INSERT INTO `xk_fun` VALUES ('22', '微信认购记录', '2', '1', '3', 'WeixBuylog/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('23', '微信认购分析', '2', '1', '4', 'WeixBuyset/AnalyticalRoomHot', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('24', 'LED大屏显示', '2', '1', '2', 'WeixBuyled/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('25', '微信认购设置', '2', '1', '1', 'WeixBuyset/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('31', '快速选房', '3', '1', '2', 'SelectRoom/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('32', '交易管理', '0', '1', '6', 'Xsgllog/index', null, 'icon-edit', '1', '0');
INSERT INTO `xk_fun` VALUES ('33', 'LED显示', '3', '1', '4', 'Xsglled/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('34', '取消选房', '3', '1', '5', null, null, null, '0', '0');
INSERT INTO `xk_fun` VALUES ('35', '入场审核', '3', '1', '1', 'Admission/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('41', '房间管理', '4', '1', '1', 'Jcsjroom/room', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('42', '批次设置', '4', '1', '3', 'Jcsjpcset/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('43', '户型设置', '4', '1', '2', 'Hxset/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('44', '参数设置', '4', '1', '4', 'YwcsSet/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('45', '套打设置', '4', '1', '5', 'Printing/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('51', '用户资料设置', '5', '1', '1', 'Yhqxuser/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('52', '岗位用户管理', '5', '1', '2', 'Yhqxstation/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('53', '岗位数据权限', '5', '1', '3', 'Yhqxproj/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('54', '岗位功能权限', '5', '1', '4', 'Yhqxfun/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('61', '摇号准备', '6', '1', '1', 'YaoHset/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('62', '摇号结果', '6', '1', '3', 'YaoHresult/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('63', '摇号预设', '6', '1', '2', 'YaoHuser/index', null, null, '1', '0');
INSERT INTO `xk_fun` VALUES ('100', '手机端功能权限', '0', '0', '100', null, null, null, '0', '1');
INSERT INTO `xk_fun` VALUES ('101', '查看所有客户', '100', '1', '1', null, null, null, '0', '1');
INSERT INTO `xk_fun` VALUES ('102', '查看销售排名', '100', '1', '2', null, null, null, '0', '1');
INSERT INTO `xk_fun` VALUES ('104', '房间销控', '100', '1', '4', null, null, null, '0', '1');
INSERT INTO `xk_fun` VALUES ('105', '房间取消销控', '100', '1', '5', null, null, null, '0', '1');

-- ----------------------------
-- Table structure for `xk_fun_station`
-- ----------------------------
DROP TABLE IF EXISTS `xk_fun_station`;
CREATE TABLE `xk_fun_station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fun_id` int(11) NOT NULL COMMENT '模块id',
  `station_id` int(11) NOT NULL COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=417 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_fun_station
-- ----------------------------
INSERT INTO `xk_fun_station` VALUES ('412', '5', '5');
INSERT INTO `xk_fun_station` VALUES ('411', '45', '5');
INSERT INTO `xk_fun_station` VALUES ('410', '44', '5');
INSERT INTO `xk_fun_station` VALUES ('409', '42', '5');
INSERT INTO `xk_fun_station` VALUES ('258', '105', '4');
INSERT INTO `xk_fun_station` VALUES ('257', '104', '4');
INSERT INTO `xk_fun_station` VALUES ('256', '102', '4');
INSERT INTO `xk_fun_station` VALUES ('255', '101', '4');
INSERT INTO `xk_fun_station` VALUES ('254', '100', '4');
INSERT INTO `xk_fun_station` VALUES ('253', '54', '4');
INSERT INTO `xk_fun_station` VALUES ('252', '53', '4');
INSERT INTO `xk_fun_station` VALUES ('251', '52', '4');
INSERT INTO `xk_fun_station` VALUES ('250', '51', '4');
INSERT INTO `xk_fun_station` VALUES ('249', '5', '4');
INSERT INTO `xk_fun_station` VALUES ('248', '44', '4');
INSERT INTO `xk_fun_station` VALUES ('247', '42', '4');
INSERT INTO `xk_fun_station` VALUES ('246', '43', '4');
INSERT INTO `xk_fun_station` VALUES ('245', '41', '4');
INSERT INTO `xk_fun_station` VALUES ('244', '4', '4');
INSERT INTO `xk_fun_station` VALUES ('408', '43', '5');
INSERT INTO `xk_fun_station` VALUES ('407', '41', '5');
INSERT INTO `xk_fun_station` VALUES ('406', '4', '5');
INSERT INTO `xk_fun_station` VALUES ('405', '32', '5');
INSERT INTO `xk_fun_station` VALUES ('404', '33', '5');
INSERT INTO `xk_fun_station` VALUES ('403', '31', '5');
INSERT INTO `xk_fun_station` VALUES ('352', '101', '6');
INSERT INTO `xk_fun_station` VALUES ('351', '100', '6');
INSERT INTO `xk_fun_station` VALUES ('308', '104', '1');
INSERT INTO `xk_fun_station` VALUES ('307', '101', '1');
INSERT INTO `xk_fun_station` VALUES ('306', '100', '1');
INSERT INTO `xk_fun_station` VALUES ('243', '32', '4');
INSERT INTO `xk_fun_station` VALUES ('242', '34', '4');
INSERT INTO `xk_fun_station` VALUES ('241', '33', '4');
INSERT INTO `xk_fun_station` VALUES ('240', '31', '4');
INSERT INTO `xk_fun_station` VALUES ('263', '34', '2');
INSERT INTO `xk_fun_station` VALUES ('262', '33', '2');
INSERT INTO `xk_fun_station` VALUES ('261', '31', '2');
INSERT INTO `xk_fun_station` VALUES ('260', '35', '2');
INSERT INTO `xk_fun_station` VALUES ('259', '3', '2');
INSERT INTO `xk_fun_station` VALUES ('135', '100', '3');
INSERT INTO `xk_fun_station` VALUES ('402', '35', '5');
INSERT INTO `xk_fun_station` VALUES ('401', '3', '5');
INSERT INTO `xk_fun_station` VALUES ('400', '23', '5');
INSERT INTO `xk_fun_station` VALUES ('399', '22', '5');
INSERT INTO `xk_fun_station` VALUES ('398', '24', '5');
INSERT INTO `xk_fun_station` VALUES ('239', '35', '4');
INSERT INTO `xk_fun_station` VALUES ('238', '3', '4');
INSERT INTO `xk_fun_station` VALUES ('237', '23', '4');
INSERT INTO `xk_fun_station` VALUES ('236', '22', '4');
INSERT INTO `xk_fun_station` VALUES ('235', '24', '4');
INSERT INTO `xk_fun_station` VALUES ('234', '25', '4');
INSERT INTO `xk_fun_station` VALUES ('233', '2', '4');
INSERT INTO `xk_fun_station` VALUES ('232', '62', '4');
INSERT INTO `xk_fun_station` VALUES ('231', '61', '4');
INSERT INTO `xk_fun_station` VALUES ('230', '6', '4');
INSERT INTO `xk_fun_station` VALUES ('229', '7', '4');
INSERT INTO `xk_fun_station` VALUES ('228', '1', '4');
INSERT INTO `xk_fun_station` VALUES ('264', '100', '2');
INSERT INTO `xk_fun_station` VALUES ('265', '101', '2');
INSERT INTO `xk_fun_station` VALUES ('266', '102', '2');
INSERT INTO `xk_fun_station` VALUES ('267', '104', '2');
INSERT INTO `xk_fun_station` VALUES ('268', '105', '2');
INSERT INTO `xk_fun_station` VALUES ('305', '6', '1');
INSERT INTO `xk_fun_station` VALUES ('304', '1', '1');
INSERT INTO `xk_fun_station` VALUES ('350', '61', '6');
INSERT INTO `xk_fun_station` VALUES ('349', '6', '6');
INSERT INTO `xk_fun_station` VALUES ('348', '7', '6');
INSERT INTO `xk_fun_station` VALUES ('347', '1', '6');
INSERT INTO `xk_fun_station` VALUES ('353', '102', '6');
INSERT INTO `xk_fun_station` VALUES ('354', '104', '6');
INSERT INTO `xk_fun_station` VALUES ('355', '105', '6');
INSERT INTO `xk_fun_station` VALUES ('356', '1', '17');
INSERT INTO `xk_fun_station` VALUES ('357', '7', '17');
INSERT INTO `xk_fun_station` VALUES ('358', '6', '17');
INSERT INTO `xk_fun_station` VALUES ('359', '61', '17');
INSERT INTO `xk_fun_station` VALUES ('397', '25', '5');
INSERT INTO `xk_fun_station` VALUES ('396', '2', '5');
INSERT INTO `xk_fun_station` VALUES ('395', '62', '5');
INSERT INTO `xk_fun_station` VALUES ('394', '63', '5');
INSERT INTO `xk_fun_station` VALUES ('393', '61', '5');
INSERT INTO `xk_fun_station` VALUES ('392', '6', '5');
INSERT INTO `xk_fun_station` VALUES ('391', '7', '5');
INSERT INTO `xk_fun_station` VALUES ('390', '1', '5');
INSERT INTO `xk_fun_station` VALUES ('413', '51', '5');
INSERT INTO `xk_fun_station` VALUES ('414', '52', '5');
INSERT INTO `xk_fun_station` VALUES ('415', '53', '5');
INSERT INTO `xk_fun_station` VALUES ('416', '54', '5');

-- ----------------------------
-- Table structure for `xk_game`
-- ----------------------------
DROP TABLE IF EXISTS `xk_game`;
CREATE TABLE `xk_game` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '活动标题',
  `room_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '房间ID',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `next_start_time` int(10) DEFAULT '0',
  `end_time` int(10) DEFAULT '0' COMMENT '结束时间',
  `allow_num` int(11) DEFAULT '5' COMMENT '允许循环次数',
  `use_num` int(11) DEFAULT '0' COMMENT '已用次数',
  `time_length` int(5) DEFAULT '5' COMMENT '抢房时长。单位：秒',
  `content` text COLLATE utf8_unicode_ci COMMENT '优惠信息',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `create_user_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `is_open` tinyint(2) DEFAULT '1' COMMENT '1-开启',
  `is_end` tinyint(1) DEFAULT '0' COMMENT '1-结束',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xk_game
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_game_prize`
-- ----------------------------
DROP TABLE IF EXISTS `xk_game_prize`;
CREATE TABLE `xk_game_prize` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) DEFAULT NULL COMMENT '中奖游戏ID',
  `customer_id` bigint(20) DEFAULT NULL COMMENT '中奖人',
  `wx_openid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '中奖人微信ID',
  `room_id` bigint(20) DEFAULT NULL COMMENT '中奖房间ID',
  `time` int(10) DEFAULT NULL COMMENT '中奖时间',
  `create_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `is_buy` tinyint(2) DEFAULT '0' COMMENT '1-确认购买',
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '电话号码',
  `buy_time` int(10) DEFAULT '0' COMMENT '购买时间',
  `code` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '确认后识别码',
  `is_delete` tinyint(2) DEFAULT '0' COMMENT '1-删除，未中奖',
  `remark` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='游戏中奖';

-- ----------------------------
-- Records of xk_game_prize
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_game_statistics`
-- ----------------------------
DROP TABLE IF EXISTS `xk_game_statistics`;
CREATE TABLE `xk_game_statistics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) DEFAULT '0' COMMENT '中奖游戏ID',
  `customer_id` bigint(20) DEFAULT '0' COMMENT '中奖人',
  `create_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `click` bigint(20) DEFAULT '1' COMMENT '抢购点击次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='抢购统计';

-- ----------------------------
-- Records of xk_game_statistics
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_hxset`
-- ----------------------------
DROP TABLE IF EXISTS `xk_hxset`;
CREATE TABLE `xk_hxset` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(20) NOT NULL COMMENT '项目id',
  `batch_id` int(20) DEFAULT NULL COMMENT '批次id',
  `hx` varchar(10) NOT NULL COMMENT '户型',
  `hxmx` varchar(30) DEFAULT NULL,
  `area` decimal(6,2) DEFAULT NULL,
  `tnarea` decimal(6,2) DEFAULT NULL,
  `imgurl` varchar(200) DEFAULT NULL COMMENT '户型图地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_hxset
-- ----------------------------
INSERT INTO `xk_hxset` VALUES ('2', '2', '2', 'Q2', '五室两厅两卫', null, null, '/Uploads/img/hximg/20180320/5ab0a8d52d2f8.jpg');
INSERT INTO `xk_hxset` VALUES ('3', '2', '2', 'Q3', '四室两厅两卫', null, null, '/Uploads/img/hximg/20180202/5a7429dd731bf.jpg');
INSERT INTO `xk_hxset` VALUES ('4', '1', '1', 'A2', '4室2厅2卫', null, null, '/Uploads/img/hximg/20171218/5a3717aa42d59.jpg');
INSERT INTO `xk_hxset` VALUES ('6', '2', '2', 'A2', '3室1厅1卫', null, null, '/Uploads/img/hximg/20180202/5a7429d35dfcb.jpg');
INSERT INTO `xk_hxset` VALUES ('7', '2', '2', 'A1', '2室2厅1卫', null, null, '/Uploads/img/hximg/20180202/5a7429c0b7a67.jpg');

-- ----------------------------
-- Table structure for `xk_kppc`
-- ----------------------------
DROP TABLE IF EXISTS `xk_kppc`;
CREATE TABLE `xk_kppc` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '批次id',
  `proj_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目id',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `kptime` int(10) NOT NULL DEFAULT '0' COMMENT '开盘时间',
  `roomscount` int(11) NOT NULL DEFAULT '0' COMMENT '房间数量',
  `is_yx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否生效。0否，1是',
  `is_dq` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否当前批次 0否  1是',
  `ledurl` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'led页面地址',
  `cjcs` smallint(3) NOT NULL DEFAULT '1' COMMENT '每人允许抽奖次数',
  `cjzrs` smallint(5) NOT NULL DEFAULT '100' COMMENT '抽奖总人数',
  `xsms` tinyint(1) DEFAULT '0' COMMENT '显示模式；0普通表格、1平面图',
  `plan` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '平面图地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='开盘批次表';

-- ----------------------------
-- Records of xk_kppc
-- ----------------------------
INSERT INTO `xk_kppc` VALUES ('1', '1', '一期', '0', '0', '1', '1', null, '1', '100', '0', null);
INSERT INTO `xk_kppc` VALUES ('2', '2', '一批次', '0', '0', '1', '0', null, '1', '100', '0', '/Uploads/img/jcsjpcset/2018-02-10/1518244399.png');
INSERT INTO `xk_kppc` VALUES ('3', '3', '一批次', '-28800', '0', '1', '1', null, '1', '100', '0', '/Uploads/img/jcsjpcset/2018-01-26/1516932212.jpg');
INSERT INTO `xk_kppc` VALUES ('4', '2', '二批次', '-28800', '0', '1', '0', null, '1', '100', '0', '/Uploads/img/jcsjpcset/2017-12-21/1513827428.jpg');

-- ----------------------------
-- Table structure for `xk_order_house_order`
-- ----------------------------
DROP TABLE IF EXISTS `xk_order_house_order`;
CREATE TABLE `xk_order_house_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL COMMENT '活动ID 外键 xk_event_house',
  `event_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '冗余 活动名称\r\n    ',
  `company_id` int(11) NOT NULL COMMENT '公司ID 外键 xk_copany id',
  `project_id` int(11) NOT NULL COMMENT '项目ID 外键 xk_project id',
  `project_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目名称',
  `batch_id` int(11) NOT NULL COMMENT '批次ID 外键 xk_kppc id',
  `batch_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT '批次名称',
  `build_id` int(11) NOT NULL COMMENT '建筑ID 外键 xk_build id',
  `build_name` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT '栋名称',
  `unit_no` int(11) NOT NULL COMMENT '单元',
  `floor_no` int(11) NOT NULL COMMENT '楼层',
  `room_id` int(11) NOT NULL COMMENT '房间ID 外间 xk_room id',
  `room_no` int(11) NOT NULL COMMENT '门牌号',
  `room_room` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `belong_openid` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT '成功抢购者openid ',
  `belong_wechat_nickname` varchar(45) CHARACTER SET utf8 DEFAULT NULL COMMENT '成功抢购者真实姓名',
  `belong_real_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT '成功抢购者微信昵称',
  `belong_gender` tinyint(1) DEFAULT NULL COMMENT '成功抢购者性别',
  `belong_phone` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT '成功抢购者 手机号码',
  `belong_uid` int(11) DEFAULT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '预购码',
  `log_time` int(11) NOT NULL COMMENT '入库时间',
  `is_checked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审查过',
  `order_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '订单ID',
  `sms_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发送短信',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xk_order_house_order
-- ----------------------------
INSERT INTO `xk_order_house_order` VALUES ('1', '2', '一批次微信开盘', '2', '2', '云景府', '2', '一批次', '4', '104栋', '1', '30', '1251', '2', '3002', '', null, '薛01', null, '18782088086', '103', '0001', '1520407571', '0', '20180307021520417457', '0');
INSERT INTO `xk_order_house_order` VALUES ('2', '2', '一批次微信开盘', '2', '2', '云景府', '2', '一批次', '4', '104栋', '1', '28', '1236', '3', '2803', '', null, '新城test1', null, '12345678900', '115', '0002', '1520412203', '0', '20180307021520413978', '0');
INSERT INTO `xk_order_house_order` VALUES ('3', '2', '一批次微信开盘', '2', '2', '云景府', '2', '一批次', '4', '104栋', '1', '33', '1275', '4', '3304', '', null, '姜001', null, '13693425865', '104', '0003', '1520582193', '0', '20180309021520583320', '0');
INSERT INTO `xk_order_house_order` VALUES ('4', '2', '一批次微信开盘', '2', '2', '云景府', '2', '一批次', '4', '104栋', '1', '32', '1266', '1', '3201', '', null, '好好', null, '18583229632', '108', '0004', '1521022194', '0', '20180314021521026808', '0');

-- ----------------------------
-- Table structure for `xk_order_house_phone_login`
-- ----------------------------
DROP TABLE IF EXISTS `xk_order_house_phone_login`;
CREATE TABLE `xk_order_house_phone_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `logip` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logintime` int(11) DEFAULT NULL,
  `logouttime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=479 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of xk_order_house_phone_login
-- ----------------------------
INSERT INTO `xk_order_house_phone_login` VALUES ('427', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1520221560', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('428', '2', 'M!T6g338OWDfIgwhOMD*gLwODUO0O0O', '117', '192.168.2.102', '1520406273', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('429', '2', 'M!T6g338OWDfIgwhOMD*gLwODUO0O0O', '117', '192.168.2.102', '1520406677', '1520407512');
INSERT INTO `xk_order_house_phone_login` VALUES ('430', '2', 'M!T6g338OWDfIgwhOMD*gLwODYO0O0O', '103', '192.168.2.102', '1520407548', '1520407753');
INSERT INTO `xk_order_house_phone_login` VALUES ('431', '2', 'M!T6g338OWDfIgwhOMD*gLwODYO0O0O', '103', '192.168.2.102', '1520407758', '1520411931');
INSERT INTO `xk_order_house_phone_login` VALUES ('432', '2', 'M!T6I3z8NWDfUg2hNMz*gL5MDAO0O0O', '109', '192.168.2.102', '1520411947', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('433', '2', 'M!T6I3z8NWDfUg2hNMz*gL5MDAO0O0O', '109', '192.168.2.102', '1520411961', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('434', '2', 'M!T6g338OWDfIgwhOMD*gLwODYO0O0O', '103', '192.168.2.102', '1520412173', '1520412186');
INSERT INTO `xk_order_house_phone_login` VALUES ('435', '2', 'M!T6I3z8NWDfUg2hNMz*gL5MDAO0O0O', '115', '192.168.2.102', '1520412197', '1520412288');
INSERT INTO `xk_order_house_phone_login` VALUES ('436', '2', 'M!T6g338OWDfIgwhOMD*gLwODUO0O0O', '117', '192.168.2.102', '1520412301', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('437', '2', 'M!T6g338OWDfIgwhOMD*gLwODgO0O0O', '117', '192.168.2.102', '1520412496', '1520413999');
INSERT INTO `xk_order_house_phone_login` VALUES ('438', '2', 'M!T6g338OWDfIgwhOMD*gLwODYO0O0O', '103', '192.168.2.102', '1520414005', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('439', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1520582161', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('440', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1520902852', '1520904308');
INSERT INTO `xk_order_house_phone_login` VALUES ('441', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1520904313', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('442', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1520905184', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('443', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.105', '1521021365', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('444', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521021581', '1521022377');
INSERT INTO `xk_order_house_phone_login` VALUES ('445', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521021871', '1521021873');
INSERT INTO `xk_order_house_phone_login` VALUES ('446', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521022515', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('447', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521086959', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('448', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521093846', '1521093895');
INSERT INTO `xk_order_house_phone_login` VALUES ('449', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '192.168.2.108', '1521093907', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('450', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521094603', '1521094673');
INSERT INTO `xk_order_house_phone_login` VALUES ('451', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521094678', '1521094727');
INSERT INTO `xk_order_house_phone_login` VALUES ('452', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521094809', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('453', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521099466', '1521100864');
INSERT INTO `xk_order_house_phone_login` VALUES ('454', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521100869', '1521100979');
INSERT INTO `xk_order_house_phone_login` VALUES ('455', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521101102', '1521101111');
INSERT INTO `xk_order_house_phone_login` VALUES ('456', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521101120', '1521101197');
INSERT INTO `xk_order_house_phone_login` VALUES ('457', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521101202', '1521101227');
INSERT INTO `xk_order_house_phone_login` VALUES ('458', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521101464', '1521101505');
INSERT INTO `xk_order_house_phone_login` VALUES ('459', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521101512', '1521101545');
INSERT INTO `xk_order_house_phone_login` VALUES ('460', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521101550', '1521101735');
INSERT INTO `xk_order_house_phone_login` VALUES ('461', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521101746', '1521105551');
INSERT INTO `xk_order_house_phone_login` VALUES ('462', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521105907', '1521106613');
INSERT INTO `xk_order_house_phone_login` VALUES ('463', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521167758', '1521167804');
INSERT INTO `xk_order_house_phone_login` VALUES ('464', '2', 'M!T6g318OWDfMgyhMMj*kL2MzIO0O0O', '108', '127.0.0.1', '1521167809', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('465', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521428422', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('466', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521440710', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('467', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521514544', null);
INSERT INTO `xk_order_house_phone_login` VALUES ('468', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521516332', '1521516571');
INSERT INTO `xk_order_house_phone_login` VALUES ('469', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521516577', '1521516730');
INSERT INTO `xk_order_house_phone_login` VALUES ('470', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521516735', '1521517049');
INSERT INTO `xk_order_house_phone_login` VALUES ('471', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521517055', '1521517082');
INSERT INTO `xk_order_house_phone_login` VALUES ('472', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521517088', '1521517473');
INSERT INTO `xk_order_house_phone_login` VALUES ('473', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521517485', '1521517614');
INSERT INTO `xk_order_house_phone_login` VALUES ('474', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521517620', '1521517650');
INSERT INTO `xk_order_house_phone_login` VALUES ('475', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521517657', '1521518619');
INSERT INTO `xk_order_house_phone_login` VALUES ('476', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521518647', '1521518688');
INSERT INTO `xk_order_house_phone_login` VALUES ('477', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '127.0.0.1', '1521518699', '1521518706');
INSERT INTO `xk_order_house_phone_login` VALUES ('478', '2', 'M!T6M328OWTfMg0hMMj*UL4NjUO0O0O', '104', '192.168.2.88', '1521518739', null);

-- ----------------------------
-- Table structure for `xk_print`
-- ----------------------------
DROP TABLE IF EXISTS `xk_print`;
CREATE TABLE `xk_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_id` int(11) NOT NULL COMMENT '批次id',
  `proj_id` int(11) NOT NULL COMMENT '项目id',
  `name` varchar(50) NOT NULL COMMENT '中文别名',
  `html_url` varchar(50) NOT NULL COMMENT 'html路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_print
-- ----------------------------
INSERT INTO `xk_print` VALUES ('1', '2', '2', '一批次认购书模板', '1521529026-mb.html');

-- ----------------------------
-- Table structure for `xk_prizes`
-- ----------------------------
DROP TABLE IF EXISTS `xk_prizes`;
CREATE TABLE `xk_prizes` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` int(20) NOT NULL COMMENT '项目id',
  `pc_id` int(20) DEFAULT NULL COMMENT '批次id',
  `name` varchar(30) NOT NULL COMMENT '奖品名称',
  `rank` varchar(20) NOT NULL DEFAULT '' COMMENT '等级',
  `zgs` smallint(10) NOT NULL DEFAULT '0' COMMENT '总个数',
  `sygs` smallint(10) NOT NULL DEFAULT '0' COMMENT '剩余个数',
  `zjv` smallint(5) NOT NULL DEFAULT '0' COMMENT '中奖率 填写整数，单位以每千份中奖概率计算',
  `type` smallint(1) NOT NULL DEFAULT '0' COMMENT '类别  0普通 1特殊',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_prizes
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_project`
-- ----------------------------
DROP TABLE IF EXISTS `xk_project`;
CREATE TABLE `xk_project` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目id',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目名称',
  `cp_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '公司id',
  `address` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '项目地址',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用',
  `mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目联系电话',
  `projfzr` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目负责人',
  `createdate` int(10) DEFAULT NULL COMMENT '创建日期',
  `app_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目微信APPID',
  `app_secret` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目微信密钥',
  `wx_avatar` text CHARACTER SET utf8 COMMENT '公众号微信头像位置',
  `poster_path` text COLLATE utf8_unicode_ci COMMENT '海报位置',
  `mch_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '商户号',
  `wishing` text COLLATE utf8_unicode_ci COMMENT '红包祝福语',
  `act_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '活动名称',
  `api_password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '支付密钥',
  `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
  `public_key` text CHARACTER SET utf8 COMMENT '证书pem格式',
  `private_key` text CHARACTER SET utf8 COMMENT '证书密钥pem格式',
  `rootca` text CHARACTER SET utf8 COMMENT 'CA证书',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='项目';

-- ----------------------------
-- Records of xk_project
-- ----------------------------
INSERT INTO `xk_project` VALUES ('1', '测试项目', '1', '成都市', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `xk_project` VALUES ('2', '云景府', '2', '成都市', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `xk_project` VALUES ('3', 'XXXX', '2', '成都市', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `xk_projoptions`
-- ----------------------------
DROP TABLE IF EXISTS `xk_projoptions`;
CREATE TABLE `xk_projoptions` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` int(20) NOT NULL DEFAULT '0',
  `is_xsjg_user` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许用户查看价格 1是，0否',
  `is_qxxf_sh` tinyint(1) NOT NULL DEFAULT '0' COMMENT '取消选房是否需要审核 1是，0否',
  `is_xspm_led` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'led大屏是否显示排名 1是，0否',
  `is_xszt_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户端是否显示销售状态 0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_projoptions
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_pzcs`
-- ----------------------------
DROP TABLE IF EXISTS `xk_pzcs`;
CREATE TABLE `xk_pzcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(20) NOT NULL,
  `cs_type` varchar(10) NOT NULL DEFAULT 'radio' COMMENT 'radio、checkbox、text',
  `options` varchar(50) NOT NULL DEFAULT '是,1;否,0' COMMENT '选项',
  `group_id` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1' COMMENT '分组id; 0无，1电子开盘，2微信开盘',
  `yw_type` varchar(10) NOT NULL DEFAULT '批次' COMMENT '批次、项目、公司',
  `px` tinyint(1) DEFAULT '0' COMMENT '排序',
  `remark` varchar(70) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_pzcs
-- ----------------------------
INSERT INTO `xk_pzcs` VALUES ('1', '开盘类型', 'radio', '电子开盘,1;微信开盘,-1', '0', '批次', '0', '');
INSERT INTO `xk_pzcs` VALUES ('2', '自动签到', 'radio', '是,1;否,-1', '1', '批次', '1', '[控制刷身份证是否自动签到]');
INSERT INTO `xk_pzcs` VALUES ('4', '自动入场审核', 'radio', '是,1;否,-1', '1', '批次', '4', '[控制刷身份证是否自动入场]');
INSERT INTO `xk_pzcs` VALUES ('12', '选房资格强控', 'radio', '是,1;否,-1', '1', '批次', '5', '[控制快速选房时是否校验入场资格]');
INSERT INTO `xk_pzcs` VALUES ('7', '付款方式必填', 'radio', '是,1;否,-1', '1', '批次', '8', '[控制打印认购书或交易录入时,付款方式是否必填]');
INSERT INTO `xk_pzcs` VALUES ('6', '选房时录入付款方式', 'radio', '是,1;否,-1', '1', '批次', '7', '[控制快速选房时是否需要填写付款方式]');
INSERT INTO `xk_pzcs` VALUES ('9', '诚意金编号必填', 'radio', '是,1;否,-1', '1', '批次', '6', '[控制快速选房时,是否录入诚意金编号]');
INSERT INTO `xk_pzcs` VALUES ('10', '签到后摇号', 'radio', '是,1;否,-1', '1', '批次', '2', '[控制是否签到之后才能参与摇号]');
INSERT INTO `xk_pzcs` VALUES ('11', '入场模式', 'radio', '摇号,1;诚意排号,2;签到,3', '1', '批次', '3', '[控制以什么方式入场]');

-- ----------------------------
-- Table structure for `xk_pzcsvalue`
-- ----------------------------
DROP TABLE IF EXISTS `xk_pzcsvalue`;
CREATE TABLE `xk_pzcsvalue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pzcs_id` int(10) NOT NULL DEFAULT '0',
  `cs_value` varchar(40) NOT NULL DEFAULT '0',
  `company_id` int(10) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL,
  `batch_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=894 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_pzcsvalue
-- ----------------------------
INSERT INTO `xk_pzcsvalue` VALUES ('350', '5', '标准总价;优惠后总价;建筑面积', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('654', '5', '标准总价;优惠后总价;建筑面积', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('653', '6', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('652', '9', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('651', '7', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('650', '4', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('649', '11', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('648', '10', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('892', '7', '-1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('891', '6', '1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('890', '9', '1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('889', '12', '1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('888', '4', '1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('349', '6', '1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('348', '9', '1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('347', '7', '1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('346', '4', '1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('345', '3', '1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('344', '2', '1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('343', '1', '-1', null, '1', '1');
INSERT INTO `xk_pzcsvalue` VALUES ('645', '5', '标准总价;优惠后总价;建筑面积', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('644', '6', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('643', '9', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('642', '7', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('640', '11', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('639', '10', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('637', '1', '-1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('638', '2', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('647', '2', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('646', '1', '1', null, '3', '3');
INSERT INTO `xk_pzcsvalue` VALUES ('641', '4', '1', null, '2', '4');
INSERT INTO `xk_pzcsvalue` VALUES ('887', '11', '3', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('886', '10', '-1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('885', '2', '1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('884', '1', '1', null, '2', '2');
INSERT INTO `xk_pzcsvalue` VALUES ('893', '0', '', null, '2', '2');

-- ----------------------------
-- Table structure for `xk_reward_log`
-- ----------------------------
DROP TABLE IF EXISTS `xk_reward_log`;
CREATE TABLE `xk_reward_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `reward_customer_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '提供奖励的用户ID',
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `reward` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖励金额',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '1-已经加钱到总账户',
  `action` tinyint(1) DEFAULT '1' COMMENT '1-获得奖励，2-提取奖励',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-有效',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='奖励记录';

-- ----------------------------
-- Records of xk_reward_log
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_reward_money`
-- ----------------------------
DROP TABLE IF EXISTS `xk_reward_money`;
CREATE TABLE `xk_reward_money` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) DEFAULT '0' COMMENT '用户ID',
  `project_id` bigint(20) DEFAULT '0' COMMENT '项目ID',
  `wxopenid` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户OPENID',
  `reward` decimal(10,2) DEFAULT NULL COMMENT '用户奖励总额',
  `use_reward` decimal(10,2) DEFAULT '0.00' COMMENT '已经提取金额',
  `code` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '提取奖励随机码',
  `code_time` int(10) DEFAULT NULL COMMENT '生成验证码时间',
  `is_notice` tinyint(1) DEFAULT '0' COMMENT '1-已通知',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户奖励记录';

-- ----------------------------
-- Records of xk_reward_money
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_reward_option`
-- ----------------------------
DROP TABLE IF EXISTS `xk_reward_option`;
CREATE TABLE `xk_reward_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `one_reward` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '一级奖励',
  `two_reward` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '二级奖励',
  `three_reward` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '三级奖励',
  `lowest_cash` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最低提现金额',
  `end_time` int(10) DEFAULT '0' COMMENT '结束时间',
  `qrcode_time` varchar(2) COLLATE utf8_unicode_ci DEFAULT '7' COMMENT '二维码时间长度：天',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-禁用',
  `remark` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='奖励设置';

-- ----------------------------
-- Records of xk_reward_option
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_reward_users`
-- ----------------------------
DROP TABLE IF EXISTS `xk_reward_users`;
CREATE TABLE `xk_reward_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0' COMMENT '父用户ID',
  `customer_id` bigint(20) DEFAULT '0' COMMENT '用户ID',
  `project_id` bigint(20) DEFAULT '0' COMMENT '项目ID',
  `code` int(10) DEFAULT NULL COMMENT '分享随机码，用于分享确认。数字',
  `qrcode_path` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '二维码保存地址名称',
  `qrcode_last_time` int(10) DEFAULT '0' COMMENT '微信二维码最后更新时间',
  `qrcode_url` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '关注微信公众号二维码URL',
  `wxopenid` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户OPENID',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='奖励用户关系结构';

-- ----------------------------
-- Records of xk_reward_users
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_room`
-- ----------------------------
DROP TABLE IF EXISTS `xk_room`;
CREATE TABLE `xk_room` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '房间id',
  `bld_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '楼栋id',
  `pc_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '批次id',
  `proj_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目id',
  `cp_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '公司id',
  `unit` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '单元',
  `floor` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '楼层',
  `no` int(10) NOT NULL COMMENT '房间号',
  `room` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hx` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '建筑面积',
  `tnarea` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '套内面积',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '建筑单价',
  `tnprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '套内单价',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '标准总价',
  `is_xf` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否选房。0否，1是',
  `xftime` int(10) DEFAULT NULL COMMENT '选房时间',
  `cstid` int(20) DEFAULT '0' COMMENT '选房客户ID',
  `cstname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '客户名称',
  `is_qxxf` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有取消选房操作 0否 1是',
  `qxxftime` int(10) DEFAULT NULL COMMENT '取消选房时间',
  `xstype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0可销售/1不销售',
  `schedule_phone` bigint(11) DEFAULT NULL COMMENT '用户预购字段',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠后价格',
  `ycx_price` decimal(10,2) DEFAULT '0.00',
  `fq_price` decimal(10,2) DEFAULT '0.00',
  `gjj_price` decimal(10,2) DEFAULT '0.00',
  `aj_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `group_index` (`bld_id`,`proj_id`,`pc_id`,`cp_id`,`unit`) USING BTREE,
  KEY `index_cstid` (`cstid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1362 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='房间表';

-- ----------------------------
-- Records of xk_room
-- ----------------------------
INSERT INTO `xk_room` VALUES ('1', '1', '0', '1', '1', '1', '4', '1', '401', null, '62.05', '62.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('2', '1', '0', '1', '1', '1', '5', '1', '501', null, '62.05', '62.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('3', '1', '0', '1', '1', '1', '6', '1', '601', null, '62.05', '62.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('4', '1', '0', '1', '1', '1', '7', '1', '701', null, '62.05', '62.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('5', '1', '0', '1', '1', '1', '8', '1', '801', null, '62.05', '62.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('6', '1', '0', '1', '1', '1', '9', '1', '901', null, '62.05', '62.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('7', '1', '0', '1', '1', '1', '11', '1', '1101', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('8', '1', '0', '1', '1', '1', '12', '1', '1201', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('9', '1', '0', '1', '1', '1', '13', '1', '1301', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('10', '1', '0', '1', '1', '1', '14', '1', '1401', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('11', '1', '0', '1', '1', '1', '15', '1', '1501', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('12', '1', '0', '1', '1', '1', '16', '1', '1601', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('13', '1', '0', '1', '1', '1', '17', '1', '1701', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('14', '1', '0', '1', '1', '1', '18', '1', '1801', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('15', '1', '0', '1', '1', '1', '19', '1', '1901', null, '62.16', '62.16', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('16', '1', '0', '1', '1', '1', '21', '1', '2101', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('17', '1', '0', '1', '1', '1', '22', '1', '2201', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('18', '1', '0', '1', '1', '1', '23', '1', '2301', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('19', '1', '0', '1', '1', '1', '24', '1', '2401', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('20', '1', '0', '1', '1', '1', '25', '1', '2501', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('21', '1', '0', '1', '1', '1', '26', '1', '2601', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('22', '1', '0', '1', '1', '1', '27', '1', '2701', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('23', '1', '0', '1', '1', '1', '28', '1', '2801', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('24', '1', '0', '1', '1', '1', '29', '1', '2901', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1512886648', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('25', '1', '0', '1', '1', '1', '4', '2', '402', null, '62.18', '62.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('26', '1', '0', '1', '1', '1', '5', '2', '502', null, '62.18', '62.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('27', '1', '0', '1', '1', '1', '6', '2', '602', null, '62.18', '62.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('28', '1', '0', '1', '1', '1', '7', '2', '702', null, '62.18', '62.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('29', '1', '0', '1', '1', '1', '8', '2', '802', null, '62.18', '62.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('30', '1', '0', '1', '1', '1', '9', '2', '902', null, '62.18', '62.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('31', '1', '0', '1', '1', '1', '11', '2', '1102', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('32', '1', '0', '1', '1', '1', '12', '2', '1202', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('33', '1', '0', '1', '1', '1', '13', '2', '1302', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('34', '1', '0', '1', '1', '1', '14', '2', '1402', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('35', '1', '0', '1', '1', '1', '15', '2', '1502', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('36', '1', '0', '1', '1', '1', '16', '2', '1602', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('37', '1', '0', '1', '1', '1', '17', '2', '1702', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('38', '1', '0', '1', '1', '1', '18', '2', '1802', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('39', '1', '0', '1', '1', '1', '19', '2', '1902', null, '62.51', '62.51', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('40', '1', '0', '1', '1', '1', '21', '2', '2102', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('41', '1', '0', '1', '1', '1', '22', '2', '2202', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('42', '1', '0', '1', '1', '1', '23', '2', '2302', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('43', '1', '0', '1', '1', '1', '24', '2', '2402', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('44', '1', '0', '1', '1', '1', '25', '2', '2502', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('45', '1', '0', '1', '1', '1', '26', '2', '2602', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('46', '1', '0', '1', '1', '1', '27', '2', '2702', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('47', '1', '0', '1', '1', '1', '28', '2', '2802', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('48', '1', '0', '1', '1', '1', '29', '2', '2902', null, '62.81', '62.81', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('49', '1', '0', '1', '1', '1', '4', '3', '403', null, '62.20', '62.20', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('50', '1', '0', '1', '1', '1', '5', '3', '503', null, '62.20', '62.20', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('51', '1', '0', '1', '1', '1', '6', '3', '603', null, '62.20', '62.20', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('52', '1', '0', '1', '1', '1', '7', '3', '703', null, '62.20', '62.20', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('53', '1', '0', '1', '1', '1', '8', '3', '803', null, '62.20', '62.20', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('54', '1', '0', '1', '1', '1', '9', '3', '903', null, '62.20', '62.20', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('55', '1', '0', '1', '1', '1', '11', '3', '1103', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('56', '1', '0', '1', '1', '1', '12', '3', '1203', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('57', '1', '0', '1', '1', '1', '13', '3', '1303', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('58', '1', '0', '1', '1', '1', '14', '3', '1403', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('59', '1', '0', '1', '1', '1', '15', '3', '1503', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('60', '1', '0', '1', '1', '1', '16', '3', '1603', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('61', '1', '0', '1', '1', '1', '17', '3', '1703', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('62', '1', '0', '1', '1', '1', '18', '3', '1803', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('63', '1', '0', '1', '1', '1', '19', '3', '1903', null, '62.54', '62.54', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('64', '1', '0', '1', '1', '1', '21', '3', '2103', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('65', '1', '0', '1', '1', '1', '22', '3', '2203', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('66', '1', '0', '1', '1', '1', '23', '3', '2303', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('67', '1', '0', '1', '1', '1', '24', '3', '2403', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('68', '1', '0', '1', '1', '1', '25', '3', '2503', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('69', '1', '0', '1', '1', '1', '26', '3', '2603', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('70', '1', '0', '1', '1', '1', '27', '3', '2703', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('71', '1', '0', '1', '1', '1', '28', '3', '2803', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('72', '1', '0', '1', '1', '1', '29', '3', '2903', null, '62.82', '62.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('73', '1', '0', '1', '1', '1', '4', '4', '404', null, '60.96', '60.96', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('74', '1', '0', '1', '1', '1', '5', '4', '504', null, '60.96', '60.96', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('75', '1', '0', '1', '1', '1', '6', '4', '604', null, '60.96', '60.96', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('76', '1', '0', '1', '1', '1', '7', '4', '704', null, '60.96', '60.96', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('77', '1', '0', '1', '1', '1', '8', '4', '804', null, '60.96', '60.96', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('78', '1', '0', '1', '1', '1', '9', '4', '904', null, '60.96', '60.96', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('79', '1', '0', '1', '1', '1', '11', '4', '1104', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('80', '1', '0', '1', '1', '1', '12', '4', '1204', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('81', '1', '0', '1', '1', '1', '13', '4', '1304', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('82', '1', '0', '1', '1', '1', '14', '4', '1404', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('83', '1', '0', '1', '1', '1', '15', '4', '1504', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('84', '1', '0', '1', '1', '1', '16', '4', '1604', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('85', '1', '0', '1', '1', '1', '17', '4', '1704', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('86', '1', '0', '1', '1', '1', '18', '4', '1804', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('87', '1', '0', '1', '1', '1', '19', '4', '1904', null, '61.11', '61.11', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('88', '1', '0', '1', '1', '1', '21', '4', '2104', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('89', '1', '0', '1', '1', '1', '22', '4', '2204', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('90', '1', '0', '1', '1', '1', '23', '4', '2304', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('91', '1', '0', '1', '1', '1', '24', '4', '2404', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('92', '1', '0', '1', '1', '1', '25', '4', '2504', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('93', '1', '0', '1', '1', '1', '26', '4', '2604', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('94', '1', '0', '1', '1', '1', '27', '4', '2704', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('95', '1', '0', '1', '1', '1', '28', '4', '2804', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('96', '1', '0', '1', '1', '1', '29', '4', '2904', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('97', '1', '0', '1', '1', '1', '4', '5', '405', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('98', '1', '0', '1', '1', '1', '5', '5', '505', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('99', '1', '0', '1', '1', '1', '6', '5', '605', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('100', '1', '0', '1', '1', '1', '7', '5', '705', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('101', '1', '0', '1', '1', '1', '8', '5', '805', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('102', '1', '0', '1', '1', '1', '9', '5', '905', null, '61.18', '61.18', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('103', '1', '0', '1', '1', '1', '11', '5', '1105', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('104', '1', '0', '1', '1', '1', '12', '5', '1205', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('105', '1', '0', '1', '1', '1', '13', '5', '1305', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('106', '1', '0', '1', '1', '1', '14', '5', '1405', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('107', '1', '0', '1', '1', '1', '15', '5', '1505', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('108', '1', '0', '1', '1', '1', '16', '5', '1605', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('109', '1', '0', '1', '1', '1', '17', '5', '1705', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('110', '1', '0', '1', '1', '1', '18', '5', '1805', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('111', '1', '0', '1', '1', '1', '19', '5', '1905', null, '61.33', '61.33', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('112', '1', '0', '1', '1', '1', '21', '5', '2105', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('113', '1', '0', '1', '1', '1', '22', '5', '2205', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('114', '1', '0', '1', '1', '1', '23', '5', '2305', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1512886642', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('115', '1', '0', '1', '1', '1', '24', '5', '2405', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('116', '1', '0', '1', '1', '1', '25', '5', '2505', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('117', '1', '0', '1', '1', '1', '26', '5', '2605', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('118', '1', '0', '1', '1', '1', '27', '5', '2705', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('119', '1', '0', '1', '1', '1', '28', '5', '2805', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('120', '1', '0', '1', '1', '1', '29', '5', '2905', null, '61.39', '61.39', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('121', '1', '0', '1', '1', '1', '4', '6', '406', null, '61.26', '61.26', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('122', '1', '0', '1', '1', '1', '5', '6', '506', null, '61.26', '61.26', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('123', '1', '0', '1', '1', '1', '6', '6', '606', null, '61.26', '61.26', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('124', '1', '0', '1', '1', '1', '7', '6', '706', null, '61.26', '61.26', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('125', '1', '0', '1', '1', '1', '8', '6', '806', null, '61.26', '61.26', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('126', '1', '0', '1', '1', '1', '9', '6', '906', null, '61.26', '61.26', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('127', '1', '0', '1', '1', '1', '11', '6', '1106', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('128', '1', '0', '1', '1', '1', '12', '6', '1206', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('129', '1', '0', '1', '1', '1', '13', '6', '1306', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('130', '1', '0', '1', '1', '1', '14', '6', '1406', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('131', '1', '0', '1', '1', '1', '15', '6', '1506', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('132', '1', '0', '1', '1', '1', '16', '6', '1606', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('133', '1', '0', '1', '1', '1', '17', '6', '1706', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('134', '1', '0', '1', '1', '1', '18', '6', '1806', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('135', '1', '0', '1', '1', '1', '19', '6', '1906', null, '61.38', '61.38', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('136', '1', '0', '1', '1', '1', '21', '6', '2106', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('137', '1', '0', '1', '1', '1', '22', '6', '2206', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('138', '1', '0', '1', '1', '1', '23', '6', '2306', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1519542780', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('139', '1', '0', '1', '1', '1', '24', '6', '2406', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('140', '1', '0', '1', '1', '1', '25', '6', '2506', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('141', '1', '0', '1', '1', '1', '26', '6', '2606', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('142', '1', '0', '1', '1', '1', '27', '6', '2706', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('143', '1', '0', '1', '1', '1', '28', '6', '2806', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1512886645', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('144', '1', '0', '1', '1', '1', '29', '6', '2906', null, '61.44', '61.44', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('145', '1', '0', '1', '1', '1', '4', '7', '407', null, '61.61', '61.61', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('146', '1', '0', '1', '1', '1', '5', '7', '507', null, '61.61', '61.61', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('147', '1', '0', '1', '1', '1', '6', '7', '607', null, '61.61', '61.61', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('148', '1', '0', '1', '1', '1', '7', '7', '707', null, '61.61', '61.61', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('149', '1', '0', '1', '1', '1', '8', '7', '807', null, '61.61', '61.61', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('150', '1', '0', '1', '1', '1', '9', '7', '907', null, '61.61', '61.61', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('151', '1', '0', '1', '1', '1', '11', '7', '1107', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('152', '1', '0', '1', '1', '1', '12', '7', '1207', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('153', '1', '0', '1', '1', '1', '13', '7', '1307', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('154', '1', '0', '1', '1', '1', '14', '7', '1407', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('155', '1', '0', '1', '1', '1', '15', '7', '1507', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('156', '1', '0', '1', '1', '1', '16', '7', '1607', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('157', '1', '0', '1', '1', '1', '17', '7', '1707', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('158', '1', '0', '1', '1', '1', '18', '7', '1807', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('159', '1', '0', '1', '1', '1', '19', '7', '1907', null, '61.69', '61.69', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('160', '1', '0', '1', '1', '1', '21', '7', '2107', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('161', '1', '0', '1', '1', '1', '22', '7', '2207', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('162', '1', '0', '1', '1', '1', '23', '7', '2307', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('163', '1', '0', '1', '1', '1', '24', '7', '2407', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1512887092', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('164', '1', '0', '1', '1', '1', '25', '7', '2507', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('165', '1', '0', '1', '1', '1', '26', '7', '2607', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('166', '1', '0', '1', '1', '1', '27', '7', '2707', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('167', '1', '0', '1', '1', '1', '28', '7', '2807', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('168', '1', '0', '1', '1', '1', '29', '7', '2907', null, '61.76', '61.76', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('169', '1', '0', '1', '1', '1', '4', '8', '408', null, '63.52', '63.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('170', '1', '0', '1', '1', '1', '5', '8', '508', null, '63.52', '63.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('171', '1', '0', '1', '1', '1', '6', '8', '608', null, '63.52', '63.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('172', '1', '0', '1', '1', '1', '7', '8', '708', null, '63.52', '63.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('173', '1', '0', '1', '1', '1', '8', '8', '808', null, '63.52', '63.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('174', '1', '0', '1', '1', '1', '9', '8', '908', null, '63.52', '63.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('175', '1', '0', '1', '1', '1', '11', '8', '1108', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('176', '1', '0', '1', '1', '1', '12', '8', '1208', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('177', '1', '0', '1', '1', '1', '13', '8', '1308', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('178', '1', '0', '1', '1', '1', '14', '8', '1408', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('179', '1', '0', '1', '1', '1', '15', '8', '1508', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('180', '1', '0', '1', '1', '1', '16', '8', '1608', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('181', '1', '0', '1', '1', '1', '17', '8', '1708', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('182', '1', '0', '1', '1', '1', '18', '8', '1808', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('183', '1', '0', '1', '1', '1', '19', '8', '1908', null, '63.46', '63.46', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('184', '1', '0', '1', '1', '1', '21', '8', '2108', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('185', '1', '0', '1', '1', '1', '22', '8', '2208', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('186', '1', '0', '1', '1', '1', '23', '8', '2308', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('187', '1', '0', '1', '1', '1', '24', '8', '2408', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('188', '1', '0', '1', '1', '1', '25', '8', '2508', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('189', '1', '0', '1', '1', '1', '26', '8', '2608', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('190', '1', '0', '1', '1', '1', '27', '8', '2708', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('191', '1', '0', '1', '1', '1', '28', '8', '2808', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('192', '1', '0', '1', '1', '1', '29', '8', '2908', null, '63.53', '63.53', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('193', '1', '0', '1', '1', '1', '4', '9', '409', null, '42.40', '42.40', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('194', '1', '0', '1', '1', '1', '5', '9', '509', null, '42.40', '42.40', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('195', '1', '0', '1', '1', '1', '6', '9', '609', null, '42.40', '42.40', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('196', '1', '0', '1', '1', '1', '7', '9', '709', null, '42.40', '42.40', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('197', '1', '0', '1', '1', '1', '8', '9', '809', null, '42.40', '42.40', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('198', '1', '0', '1', '1', '1', '9', '9', '909', null, '42.40', '42.40', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('199', '1', '0', '1', '1', '1', '11', '9', '1109', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('200', '1', '0', '1', '1', '1', '12', '9', '1209', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('201', '1', '0', '1', '1', '1', '13', '9', '1309', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('202', '1', '0', '1', '1', '1', '14', '9', '1409', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('203', '1', '0', '1', '1', '1', '15', '9', '1509', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('204', '1', '0', '1', '1', '1', '16', '9', '1609', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('205', '1', '0', '1', '1', '1', '17', '9', '1709', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('206', '1', '0', '1', '1', '1', '18', '9', '1809', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('207', '1', '0', '1', '1', '1', '19', '9', '1909', null, '42.72', '42.72', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('208', '1', '0', '1', '1', '1', '21', '9', '2109', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('209', '1', '0', '1', '1', '1', '22', '9', '2209', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('210', '1', '0', '1', '1', '1', '23', '9', '2309', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1517383952', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('211', '1', '0', '1', '1', '1', '24', '9', '2409', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('212', '1', '0', '1', '1', '1', '25', '9', '2509', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('213', '1', '0', '1', '1', '1', '26', '9', '2609', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('214', '1', '0', '1', '1', '1', '27', '9', '2709', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('215', '1', '0', '1', '1', '1', '28', '9', '2809', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('216', '1', '0', '1', '1', '1', '29', '9', '2909', null, '42.99', '42.99', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('217', '1', '0', '1', '1', '1', '4', '10', '410', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('218', '1', '0', '1', '1', '1', '5', '10', '510', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('219', '1', '0', '1', '1', '1', '6', '10', '610', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('220', '1', '0', '1', '1', '1', '7', '10', '710', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('221', '1', '0', '1', '1', '1', '8', '10', '810', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('222', '1', '0', '1', '1', '1', '9', '10', '910', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('223', '1', '0', '1', '1', '1', '11', '10', '1110', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('224', '1', '0', '1', '1', '1', '12', '10', '1210', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('225', '1', '0', '1', '1', '1', '13', '10', '1310', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('226', '1', '0', '1', '1', '1', '14', '10', '1410', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('227', '1', '0', '1', '1', '1', '15', '10', '1510', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('228', '1', '0', '1', '1', '1', '16', '10', '1610', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('229', '1', '0', '1', '1', '1', '17', '10', '1710', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('230', '1', '0', '1', '1', '1', '18', '10', '1810', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('231', '1', '0', '1', '1', '1', '19', '10', '1910', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('232', '1', '0', '1', '1', '1', '21', '10', '2110', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('233', '1', '0', '1', '1', '1', '22', '10', '2210', null, '41.85', '41.85', '0.00', '0.00', '0.00', '1', '1517384032', '76', 'AAA3', '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('234', '1', '0', '1', '1', '1', '23', '10', '2310', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('235', '1', '0', '1', '1', '1', '24', '10', '2410', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('236', '1', '0', '1', '1', '1', '25', '10', '2510', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('237', '1', '0', '1', '1', '1', '26', '10', '2610', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('238', '1', '0', '1', '1', '1', '27', '10', '2710', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('239', '1', '0', '1', '1', '1', '28', '10', '2810', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('240', '1', '0', '1', '1', '1', '29', '10', '2910', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('241', '1', '0', '1', '1', '1', '4', '11', '411', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('242', '1', '0', '1', '1', '1', '5', '11', '511', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('243', '1', '0', '1', '1', '1', '6', '11', '611', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('244', '1', '0', '1', '1', '1', '7', '11', '711', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('245', '1', '0', '1', '1', '1', '8', '11', '811', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('246', '1', '0', '1', '1', '1', '9', '11', '911', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('247', '1', '0', '1', '1', '1', '11', '11', '1111', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('248', '1', '0', '1', '1', '1', '12', '11', '1211', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('249', '1', '0', '1', '1', '1', '13', '11', '1311', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('250', '1', '0', '1', '1', '1', '14', '11', '1411', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('251', '1', '0', '1', '1', '1', '15', '11', '1511', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('252', '1', '0', '1', '1', '1', '16', '11', '1611', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('253', '1', '0', '1', '1', '1', '17', '11', '1711', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('254', '1', '0', '1', '1', '1', '18', '11', '1811', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('255', '1', '0', '1', '1', '1', '19', '11', '1911', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('256', '1', '0', '1', '1', '1', '21', '11', '2111', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('257', '1', '0', '1', '1', '1', '22', '11', '2211', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1512886639', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('258', '1', '0', '1', '1', '1', '23', '11', '2311', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('259', '1', '0', '1', '1', '1', '24', '11', '2411', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('260', '1', '0', '1', '1', '1', '25', '11', '2511', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('261', '1', '0', '1', '1', '1', '26', '11', '2611', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('262', '1', '0', '1', '1', '1', '27', '11', '2711', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('263', '1', '0', '1', '1', '1', '28', '11', '2811', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('264', '1', '0', '1', '1', '1', '29', '11', '2911', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('265', '1', '0', '1', '1', '1', '4', '12', '412', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('266', '1', '0', '1', '1', '1', '5', '12', '512', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('267', '1', '0', '1', '1', '1', '6', '12', '612', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('268', '1', '0', '1', '1', '1', '7', '12', '712', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('269', '1', '0', '1', '1', '1', '8', '12', '812', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('270', '1', '0', '1', '1', '1', '9', '12', '912', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('271', '1', '0', '1', '1', '1', '11', '12', '1112', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('272', '1', '0', '1', '1', '1', '12', '12', '1212', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('273', '1', '0', '1', '1', '1', '13', '12', '1312', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('274', '1', '0', '1', '1', '1', '14', '12', '1412', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('275', '1', '0', '1', '1', '1', '15', '12', '1512', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('276', '1', '0', '1', '1', '1', '16', '12', '1612', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('277', '1', '0', '1', '1', '1', '17', '12', '1712', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('278', '1', '0', '1', '1', '1', '18', '12', '1812', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('279', '1', '0', '1', '1', '1', '19', '12', '1912', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('280', '1', '0', '1', '1', '1', '21', '12', '2112', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('281', '1', '0', '1', '1', '1', '22', '12', '2212', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('282', '1', '0', '1', '1', '1', '23', '12', '2312', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('283', '1', '0', '1', '1', '1', '24', '12', '2412', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('284', '1', '0', '1', '1', '1', '25', '12', '2512', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('285', '1', '0', '1', '1', '1', '26', '12', '2612', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('286', '1', '0', '1', '1', '1', '27', '12', '2712', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('287', '1', '0', '1', '1', '1', '28', '12', '2812', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('288', '1', '0', '1', '1', '1', '29', '12', '2912', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('289', '1', '0', '1', '1', '1', '4', '13', '413', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('290', '1', '0', '1', '1', '1', '5', '13', '513', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('291', '1', '0', '1', '1', '1', '6', '13', '613', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('292', '1', '0', '1', '1', '1', '7', '13', '713', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('293', '1', '0', '1', '1', '1', '8', '13', '813', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('294', '1', '0', '1', '1', '1', '9', '13', '913', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('295', '1', '0', '1', '1', '1', '11', '13', '1113', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('296', '1', '0', '1', '1', '1', '12', '13', '1213', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('297', '1', '0', '1', '1', '1', '13', '13', '1313', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('298', '1', '0', '1', '1', '1', '14', '13', '1413', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('299', '1', '0', '1', '1', '1', '15', '13', '1513', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('300', '1', '0', '1', '1', '1', '16', '13', '1613', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('301', '1', '0', '1', '1', '1', '17', '13', '1713', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('302', '1', '0', '1', '1', '1', '18', '13', '1813', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('303', '1', '0', '1', '1', '1', '19', '13', '1913', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('304', '1', '0', '1', '1', '1', '21', '13', '2113', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('305', '1', '0', '1', '1', '1', '22', '13', '2213', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('306', '1', '0', '1', '1', '1', '23', '13', '2313', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('307', '1', '0', '1', '1', '1', '24', '13', '2413', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('308', '1', '0', '1', '1', '1', '25', '13', '2513', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('309', '1', '0', '1', '1', '1', '26', '13', '2613', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('310', '1', '0', '1', '1', '1', '27', '13', '2713', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('311', '1', '0', '1', '1', '1', '28', '13', '2813', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('312', '1', '0', '1', '1', '1', '29', '13', '2913', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('313', '1', '0', '1', '1', '1', '4', '14', '414', null, '41.95', '41.95', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('314', '1', '0', '1', '1', '1', '5', '14', '514', null, '41.95', '41.95', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('315', '1', '0', '1', '1', '1', '6', '14', '614', null, '41.95', '41.95', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('316', '1', '0', '1', '1', '1', '7', '14', '714', null, '41.95', '41.95', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('317', '1', '0', '1', '1', '1', '8', '14', '814', null, '41.95', '41.95', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('318', '1', '0', '1', '1', '1', '9', '14', '914', null, '41.95', '41.95', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('319', '1', '0', '1', '1', '1', '11', '14', '1114', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('320', '1', '0', '1', '1', '1', '12', '14', '1214', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('321', '1', '0', '1', '1', '1', '13', '14', '1314', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('322', '1', '0', '1', '1', '1', '14', '14', '1414', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('323', '1', '0', '1', '1', '1', '15', '14', '1514', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('324', '1', '0', '1', '1', '1', '16', '14', '1614', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('325', '1', '0', '1', '1', '1', '17', '14', '1714', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('326', '1', '0', '1', '1', '1', '18', '14', '1814', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('327', '1', '0', '1', '1', '1', '19', '14', '1914', null, '41.90', '41.90', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('328', '1', '0', '1', '1', '1', '21', '14', '2114', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('329', '1', '0', '1', '1', '1', '22', '14', '2214', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('330', '1', '0', '1', '1', '1', '23', '14', '2314', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('331', '1', '0', '1', '1', '1', '24', '14', '2414', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('332', '1', '0', '1', '1', '1', '25', '14', '2514', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('333', '1', '0', '1', '1', '1', '26', '14', '2614', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('334', '1', '0', '1', '1', '1', '27', '14', '2714', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('335', '1', '0', '1', '1', '1', '28', '14', '2814', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('336', '1', '0', '1', '1', '1', '29', '14', '2914', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('337', '1', '0', '1', '1', '1', '4', '15', '415', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('338', '1', '0', '1', '1', '1', '5', '15', '515', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('339', '1', '0', '1', '1', '1', '6', '15', '615', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('340', '1', '0', '1', '1', '1', '7', '15', '715', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('341', '1', '0', '1', '1', '1', '8', '15', '815', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('342', '1', '0', '1', '1', '1', '9', '15', '915', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('343', '1', '0', '1', '1', '1', '11', '15', '1115', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('344', '1', '0', '1', '1', '1', '12', '15', '1215', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('345', '1', '0', '1', '1', '1', '13', '15', '1315', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('346', '1', '0', '1', '1', '1', '14', '15', '1415', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('347', '1', '0', '1', '1', '1', '15', '15', '1515', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('348', '1', '0', '1', '1', '1', '16', '15', '1615', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('349', '1', '0', '1', '1', '1', '17', '15', '1715', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('350', '1', '0', '1', '1', '1', '18', '15', '1815', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('351', '1', '0', '1', '1', '1', '19', '15', '1915', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('352', '1', '0', '1', '1', '1', '21', '15', '2115', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('353', '1', '0', '1', '1', '1', '22', '15', '2215', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('354', '1', '0', '1', '1', '1', '23', '15', '2315', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('355', '1', '0', '1', '1', '1', '24', '15', '2415', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('356', '1', '0', '1', '1', '1', '25', '15', '2515', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('357', '1', '0', '1', '1', '1', '26', '15', '2615', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('358', '1', '0', '1', '1', '1', '27', '15', '2715', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('359', '1', '0', '1', '1', '1', '28', '15', '2815', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('360', '1', '0', '1', '1', '1', '29', '15', '2915', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', '1519627916', '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('361', '1', '0', '1', '1', '1', '4', '16', '416', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('362', '1', '0', '1', '1', '1', '5', '16', '516', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('363', '1', '0', '1', '1', '1', '6', '16', '616', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('364', '1', '0', '1', '1', '1', '7', '16', '716', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('365', '1', '0', '1', '1', '1', '8', '16', '816', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('366', '1', '0', '1', '1', '1', '9', '16', '916', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('367', '1', '0', '1', '1', '1', '11', '16', '1116', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('368', '1', '0', '1', '1', '1', '12', '16', '1216', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('369', '1', '0', '1', '1', '1', '13', '16', '1316', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('370', '1', '0', '1', '1', '1', '14', '16', '1416', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('371', '1', '0', '1', '1', '1', '15', '16', '1516', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('372', '1', '0', '1', '1', '1', '16', '16', '1616', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('373', '1', '0', '1', '1', '1', '17', '16', '1716', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('374', '1', '0', '1', '1', '1', '18', '16', '1816', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('375', '1', '0', '1', '1', '1', '19', '16', '1916', null, '41.83', '41.83', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('376', '1', '0', '1', '1', '1', '21', '16', '2116', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('377', '1', '0', '1', '1', '1', '22', '16', '2216', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('378', '1', '0', '1', '1', '1', '23', '16', '2316', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('379', '1', '0', '1', '1', '1', '24', '16', '2416', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('380', '1', '0', '1', '1', '1', '25', '16', '2516', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('381', '1', '0', '1', '1', '1', '26', '16', '2616', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('382', '1', '0', '1', '1', '1', '27', '16', '2716', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('383', '1', '0', '1', '1', '1', '28', '16', '2816', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('384', '1', '0', '1', '1', '1', '29', '16', '2916', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('385', '1', '0', '1', '1', '1', '4', '17', '417', null, '42.01', '42.01', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('386', '1', '0', '1', '1', '1', '5', '17', '517', null, '42.01', '42.01', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('387', '1', '0', '1', '1', '1', '6', '17', '617', null, '42.01', '42.01', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('388', '1', '0', '1', '1', '1', '7', '17', '717', null, '42.01', '42.01', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('389', '1', '0', '1', '1', '1', '8', '17', '817', null, '42.01', '42.01', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('390', '1', '0', '1', '1', '1', '9', '17', '917', null, '42.01', '42.01', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('391', '1', '0', '1', '1', '1', '11', '17', '1117', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('392', '1', '0', '1', '1', '1', '12', '17', '1217', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('393', '1', '0', '1', '1', '1', '13', '17', '1317', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('394', '1', '0', '1', '1', '1', '14', '17', '1417', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('395', '1', '0', '1', '1', '1', '15', '17', '1517', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('396', '1', '0', '1', '1', '1', '16', '17', '1617', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('397', '1', '0', '1', '1', '1', '17', '17', '1717', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('398', '1', '0', '1', '1', '1', '18', '17', '1817', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('399', '1', '0', '1', '1', '1', '19', '17', '1917', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('400', '1', '0', '1', '1', '1', '21', '17', '2117', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('401', '1', '0', '1', '1', '1', '22', '17', '2217', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('402', '1', '0', '1', '1', '1', '23', '17', '2317', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('403', '1', '0', '1', '1', '1', '24', '17', '2417', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('404', '1', '0', '1', '1', '1', '25', '17', '2517', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('405', '1', '0', '1', '1', '1', '26', '17', '2617', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('406', '1', '0', '1', '1', '1', '27', '17', '2717', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('407', '1', '0', '1', '1', '1', '28', '17', '2817', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('408', '1', '0', '1', '1', '1', '29', '17', '2917', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('409', '1', '0', '1', '1', '1', '4', '18', '418', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('410', '1', '0', '1', '1', '1', '5', '18', '518', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('411', '1', '0', '1', '1', '1', '6', '18', '618', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('412', '1', '0', '1', '1', '1', '7', '18', '718', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('413', '1', '0', '1', '1', '1', '8', '18', '818', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('414', '1', '0', '1', '1', '1', '9', '18', '918', null, '41.97', '41.97', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('415', '1', '0', '1', '1', '1', '11', '18', '1118', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('416', '1', '0', '1', '1', '1', '12', '18', '1218', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('417', '1', '0', '1', '1', '1', '13', '18', '1318', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('418', '1', '0', '1', '1', '1', '14', '18', '1418', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('419', '1', '0', '1', '1', '1', '15', '18', '1518', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('420', '1', '0', '1', '1', '1', '16', '18', '1618', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('421', '1', '0', '1', '1', '1', '17', '18', '1718', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('422', '1', '0', '1', '1', '1', '18', '18', '1818', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('423', '1', '0', '1', '1', '1', '19', '18', '1918', null, '41.93', '41.93', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('424', '1', '0', '1', '1', '1', '21', '18', '2118', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('425', '1', '0', '1', '1', '1', '22', '18', '2218', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('426', '1', '0', '1', '1', '1', '23', '18', '2318', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('427', '1', '0', '1', '1', '1', '24', '18', '2418', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('428', '1', '0', '1', '1', '1', '25', '18', '2518', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('429', '1', '0', '1', '1', '1', '26', '18', '2618', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('430', '1', '0', '1', '1', '1', '27', '18', '2718', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('431', '1', '0', '1', '1', '1', '28', '18', '2818', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('432', '1', '0', '1', '1', '1', '29', '18', '2918', null, '41.88', '41.88', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('433', '1', '0', '1', '1', '1', '4', '19', '419', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('434', '1', '0', '1', '1', '1', '5', '19', '519', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('435', '1', '0', '1', '1', '1', '6', '19', '619', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('436', '1', '0', '1', '1', '1', '7', '19', '719', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('437', '1', '0', '1', '1', '1', '8', '19', '819', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('438', '1', '0', '1', '1', '1', '9', '19', '919', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('439', '1', '0', '1', '1', '1', '11', '19', '1119', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('440', '1', '0', '1', '1', '1', '12', '19', '1219', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('441', '1', '0', '1', '1', '1', '13', '19', '1319', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('442', '1', '0', '1', '1', '1', '14', '19', '1419', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('443', '1', '0', '1', '1', '1', '15', '19', '1519', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('444', '1', '0', '1', '1', '1', '16', '19', '1619', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('445', '1', '0', '1', '1', '1', '17', '19', '1719', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('446', '1', '0', '1', '1', '1', '18', '19', '1819', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('447', '1', '0', '1', '1', '1', '19', '19', '1919', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('448', '1', '0', '1', '1', '1', '21', '19', '2119', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('449', '1', '0', '1', '1', '1', '22', '19', '2219', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('450', '1', '0', '1', '1', '1', '23', '19', '2319', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('451', '1', '0', '1', '1', '1', '24', '19', '2419', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('452', '1', '0', '1', '1', '1', '25', '19', '2519', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('453', '1', '0', '1', '1', '1', '26', '19', '2619', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('454', '1', '0', '1', '1', '1', '27', '19', '2719', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('455', '1', '0', '1', '1', '1', '28', '19', '2819', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('456', '1', '0', '1', '1', '1', '29', '19', '2919', null, '41.82', '41.82', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('457', '1', '0', '1', '1', '1', '4', '20', '420', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('458', '1', '0', '1', '1', '1', '5', '20', '520', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('459', '1', '0', '1', '1', '1', '6', '20', '620', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('460', '1', '0', '1', '1', '1', '7', '20', '720', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('461', '1', '0', '1', '1', '1', '8', '20', '820', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('462', '1', '0', '1', '1', '1', '9', '20', '920', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('463', '1', '0', '1', '1', '1', '11', '20', '1120', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('464', '1', '0', '1', '1', '1', '12', '20', '1220', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('465', '1', '0', '1', '1', '1', '13', '20', '1320', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('466', '1', '0', '1', '1', '1', '14', '20', '1420', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('467', '1', '0', '1', '1', '1', '15', '20', '1520', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('468', '1', '0', '1', '1', '1', '16', '20', '1620', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('469', '1', '0', '1', '1', '1', '17', '20', '1720', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('470', '1', '0', '1', '1', '1', '18', '20', '1820', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('471', '1', '0', '1', '1', '1', '19', '20', '1920', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('472', '1', '0', '1', '1', '1', '21', '20', '2120', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('473', '1', '0', '1', '1', '1', '22', '20', '2220', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('474', '1', '0', '1', '1', '1', '23', '20', '2320', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('475', '1', '0', '1', '1', '1', '24', '20', '2420', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('476', '1', '0', '1', '1', '1', '25', '20', '2520', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('477', '1', '0', '1', '1', '1', '26', '20', '2620', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('478', '1', '0', '1', '1', '1', '27', '20', '2720', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('479', '1', '0', '1', '1', '1', '28', '20', '2820', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('480', '1', '0', '1', '1', '1', '29', '20', '2920', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('481', '1', '0', '1', '1', '1', '4', '21', '421', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('482', '1', '0', '1', '1', '1', '5', '21', '521', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('483', '1', '0', '1', '1', '1', '6', '21', '621', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('484', '1', '0', '1', '1', '1', '7', '21', '721', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('485', '1', '0', '1', '1', '1', '8', '21', '821', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('486', '1', '0', '1', '1', '1', '9', '21', '921', null, '41.91', '41.91', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('487', '1', '0', '1', '1', '1', '11', '21', '1121', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('488', '1', '0', '1', '1', '1', '12', '21', '1221', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('489', '1', '0', '1', '1', '1', '13', '21', '1321', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('490', '1', '0', '1', '1', '1', '14', '21', '1421', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('491', '1', '0', '1', '1', '1', '15', '21', '1521', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('492', '1', '0', '1', '1', '1', '16', '21', '1621', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('493', '1', '0', '1', '1', '1', '17', '21', '1721', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('494', '1', '0', '1', '1', '1', '18', '21', '1821', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('495', '1', '0', '1', '1', '1', '19', '21', '1921', null, '41.87', '41.87', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('496', '1', '0', '1', '1', '1', '21', '21', '2121', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('497', '1', '0', '1', '1', '1', '22', '21', '2221', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('498', '1', '0', '1', '1', '1', '23', '21', '2321', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('499', '1', '0', '1', '1', '1', '24', '21', '2421', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('500', '1', '0', '1', '1', '1', '25', '21', '2521', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('501', '1', '0', '1', '1', '1', '26', '21', '2621', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('502', '1', '0', '1', '1', '1', '27', '21', '2721', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('503', '1', '0', '1', '1', '1', '28', '21', '2821', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('504', '1', '0', '1', '1', '1', '29', '21', '2921', null, '41.85', '41.85', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('505', '1', '0', '1', '1', '1', '4', '22', '422', null, '42.66', '42.66', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('506', '1', '0', '1', '1', '1', '5', '22', '522', null, '42.66', '42.66', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('507', '1', '0', '1', '1', '1', '6', '22', '622', null, '42.66', '42.66', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('508', '1', '0', '1', '1', '1', '7', '22', '722', null, '42.66', '42.66', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('509', '1', '0', '1', '1', '1', '8', '22', '822', null, '42.66', '42.66', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('510', '1', '0', '1', '1', '1', '9', '22', '922', null, '42.66', '42.66', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('511', '1', '0', '1', '1', '1', '11', '22', '1122', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('512', '1', '0', '1', '1', '1', '12', '22', '1222', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('513', '1', '0', '1', '1', '1', '13', '22', '1322', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('514', '1', '0', '1', '1', '1', '14', '22', '1422', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('515', '1', '0', '1', '1', '1', '15', '22', '1522', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('516', '1', '0', '1', '1', '1', '16', '22', '1622', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('517', '1', '0', '1', '1', '1', '17', '22', '1722', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('518', '1', '0', '1', '1', '1', '18', '22', '1822', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('519', '1', '0', '1', '1', '1', '19', '22', '1922', null, '42.59', '42.59', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('520', '1', '0', '1', '1', '1', '21', '22', '2122', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('521', '1', '0', '1', '1', '1', '22', '22', '2222', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('522', '1', '0', '1', '1', '1', '23', '22', '2322', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('523', '1', '0', '1', '1', '1', '24', '22', '2422', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('524', '1', '0', '1', '1', '1', '25', '22', '2522', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('525', '1', '0', '1', '1', '1', '26', '22', '2622', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('526', '1', '0', '1', '1', '1', '27', '22', '2722', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('527', '1', '0', '1', '1', '1', '28', '22', '2822', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('528', '1', '0', '1', '1', '1', '29', '22', '2922', null, '42.78', '42.78', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('529', '2', '0', '1', '1', '1', '4', '1', '401', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('530', '2', '0', '1', '1', '1', '5', '1', '501', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('531', '2', '0', '1', '1', '1', '6', '1', '601', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('532', '2', '0', '1', '1', '1', '7', '1', '701', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('533', '2', '0', '1', '1', '1', '8', '1', '801', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('534', '2', '0', '1', '1', '1', '9', '1', '901', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('535', '2', '0', '1', '1', '1', '10', '1', '1001', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('536', '2', '0', '1', '1', '1', '11', '1', '1101', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('537', '2', '0', '1', '1', '1', '12', '1', '1201', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('538', '2', '0', '1', '1', '1', '13', '1', '1301', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('539', '2', '0', '1', '1', '1', '14', '1', '1401', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('540', '2', '0', '1', '1', '1', '15', '1', '1501', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('541', '2', '0', '1', '1', '1', '16', '1', '1601', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('542', '2', '0', '1', '1', '1', '17', '1', '1701', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('543', '2', '0', '1', '1', '1', '18', '1', '1801', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('544', '2', '0', '1', '1', '1', '19', '1', '1901', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('545', '2', '0', '1', '1', '1', '20', '1', '2001', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('546', '2', '0', '1', '1', '1', '21', '1', '2101', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('547', '2', '0', '1', '1', '1', '22', '1', '2201', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('548', '2', '0', '1', '1', '1', '23', '1', '2301', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('549', '2', '0', '1', '1', '1', '24', '1', '2401', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('550', '2', '0', '1', '1', '1', '25', '1', '2501', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('551', '2', '0', '1', '1', '1', '26', '1', '2601', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('552', '2', '0', '1', '1', '1', '27', '1', '2701', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('553', '2', '0', '1', '1', '1', '28', '1', '2801', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('554', '2', '0', '1', '1', '1', '29', '1', '2901', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('555', '2', '0', '1', '1', '1', '4', '2', '402', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('556', '2', '0', '1', '1', '1', '5', '2', '502', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('557', '2', '0', '1', '1', '1', '6', '2', '602', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('558', '2', '0', '1', '1', '1', '7', '2', '702', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('559', '2', '0', '1', '1', '1', '8', '2', '802', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('560', '2', '0', '1', '1', '1', '9', '2', '902', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('561', '2', '0', '1', '1', '1', '10', '2', '1002', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('562', '2', '0', '1', '1', '1', '11', '2', '1102', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('563', '2', '0', '1', '1', '1', '12', '2', '1202', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('564', '2', '0', '1', '1', '1', '13', '2', '1302', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('565', '2', '0', '1', '1', '1', '14', '2', '1402', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('566', '2', '0', '1', '1', '1', '15', '2', '1502', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('567', '2', '0', '1', '1', '1', '16', '2', '1602', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('568', '2', '0', '1', '1', '1', '17', '2', '1702', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('569', '2', '0', '1', '1', '1', '18', '2', '1802', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('570', '2', '0', '1', '1', '1', '19', '2', '1902', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('571', '2', '0', '1', '1', '1', '20', '2', '2002', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('572', '2', '0', '1', '1', '1', '21', '2', '2102', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('573', '2', '0', '1', '1', '1', '22', '2', '2202', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('574', '2', '0', '1', '1', '1', '23', '2', '2302', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('575', '2', '0', '1', '1', '1', '24', '2', '2402', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('576', '2', '0', '1', '1', '1', '25', '2', '2502', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('577', '2', '0', '1', '1', '1', '26', '2', '2602', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('578', '2', '0', '1', '1', '1', '27', '2', '2702', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('579', '2', '0', '1', '1', '1', '28', '2', '2802', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('580', '2', '0', '1', '1', '1', '29', '2', '2902', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('581', '2', '0', '1', '1', '1', '4', '3', '403', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('582', '2', '0', '1', '1', '1', '5', '3', '503', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('583', '2', '0', '1', '1', '1', '6', '3', '603', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('584', '2', '0', '1', '1', '1', '7', '3', '703', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('585', '2', '0', '1', '1', '1', '8', '3', '803', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('586', '2', '0', '1', '1', '1', '9', '3', '903', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('587', '2', '0', '1', '1', '1', '10', '3', '1003', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('588', '2', '0', '1', '1', '1', '11', '3', '1103', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('589', '2', '0', '1', '1', '1', '12', '3', '1203', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('590', '2', '0', '1', '1', '1', '13', '3', '1303', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('591', '2', '0', '1', '1', '1', '14', '3', '1403', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('592', '2', '0', '1', '1', '1', '15', '3', '1503', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('593', '2', '0', '1', '1', '1', '16', '3', '1603', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('594', '2', '0', '1', '1', '1', '17', '3', '1703', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('595', '2', '0', '1', '1', '1', '18', '3', '1803', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('596', '2', '0', '1', '1', '1', '19', '3', '1903', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('597', '2', '0', '1', '1', '1', '20', '3', '2003', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('598', '2', '0', '1', '1', '1', '21', '3', '2103', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('599', '2', '0', '1', '1', '1', '22', '3', '2203', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('600', '2', '0', '1', '1', '1', '23', '3', '2303', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('601', '2', '0', '1', '1', '1', '24', '3', '2403', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('602', '2', '0', '1', '1', '1', '25', '3', '2503', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('603', '2', '0', '1', '1', '1', '26', '3', '2603', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('604', '2', '0', '1', '1', '1', '27', '3', '2703', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('605', '2', '0', '1', '1', '1', '28', '3', '2803', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('606', '2', '0', '1', '1', '1', '29', '3', '2903', null, '62.73', '62.73', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('607', '2', '0', '1', '1', '1', '4', '4', '404', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('608', '2', '0', '1', '1', '1', '5', '4', '504', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('609', '2', '0', '1', '1', '1', '6', '4', '604', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('610', '2', '0', '1', '1', '1', '7', '4', '704', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('611', '2', '0', '1', '1', '1', '8', '4', '804', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('612', '2', '0', '1', '1', '1', '9', '4', '904', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('613', '2', '0', '1', '1', '1', '10', '4', '1004', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('614', '2', '0', '1', '1', '1', '11', '4', '1104', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('615', '2', '0', '1', '1', '1', '12', '4', '1204', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('616', '2', '0', '1', '1', '1', '13', '4', '1304', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('617', '2', '0', '1', '1', '1', '14', '4', '1404', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('618', '2', '0', '1', '1', '1', '15', '4', '1504', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('619', '2', '0', '1', '1', '1', '16', '4', '1604', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', '0', '0', '', '1', '1512886631', '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('620', '2', '0', '1', '1', '1', '17', '4', '1704', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('621', '2', '0', '1', '1', '1', '18', '4', '1804', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('622', '2', '0', '1', '1', '1', '19', '4', '1904', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('623', '2', '0', '1', '1', '1', '20', '4', '2004', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('624', '2', '0', '1', '1', '1', '21', '4', '2104', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('625', '2', '0', '1', '1', '1', '22', '4', '2204', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('626', '2', '0', '1', '1', '1', '23', '4', '2304', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('627', '2', '0', '1', '1', '1', '24', '4', '2404', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('628', '2', '0', '1', '1', '1', '25', '4', '2504', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('629', '2', '0', '1', '1', '1', '26', '4', '2604', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('630', '2', '0', '1', '1', '1', '27', '4', '2704', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('631', '2', '0', '1', '1', '1', '28', '4', '2804', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('632', '2', '0', '1', '1', '1', '29', '4', '2904', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('633', '2', '0', '1', '1', '1', '4', '5', '405', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('634', '2', '0', '1', '1', '1', '5', '5', '505', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('635', '2', '0', '1', '1', '1', '6', '5', '605', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('636', '2', '0', '1', '1', '1', '7', '5', '705', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('637', '2', '0', '1', '1', '1', '8', '5', '805', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('638', '2', '0', '1', '1', '1', '9', '5', '905', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('639', '2', '0', '1', '1', '1', '10', '5', '1005', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('640', '2', '0', '1', '1', '1', '11', '5', '1105', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('641', '2', '0', '1', '1', '1', '12', '5', '1205', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('642', '2', '0', '1', '1', '1', '13', '5', '1305', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('643', '2', '0', '1', '1', '1', '14', '5', '1405', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('644', '2', '0', '1', '1', '1', '15', '5', '1505', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('645', '2', '0', '1', '1', '1', '16', '5', '1605', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('646', '2', '0', '1', '1', '1', '17', '5', '1705', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('647', '2', '0', '1', '1', '1', '18', '5', '1805', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('648', '2', '0', '1', '1', '1', '19', '5', '1905', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('649', '2', '0', '1', '1', '1', '20', '5', '2005', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('650', '2', '0', '1', '1', '1', '21', '5', '2105', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('651', '2', '0', '1', '1', '1', '22', '5', '2205', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('652', '2', '0', '1', '1', '1', '23', '5', '2305', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('653', '2', '0', '1', '1', '1', '24', '5', '2405', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('654', '2', '0', '1', '1', '1', '25', '5', '2505', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('655', '2', '0', '1', '1', '1', '26', '5', '2605', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('656', '2', '0', '1', '1', '1', '27', '5', '2705', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('657', '2', '0', '1', '1', '1', '28', '5', '2805', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('658', '2', '0', '1', '1', '1', '29', '5', '2905', null, '62.74', '62.74', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('659', '2', '0', '1', '1', '1', '4', '6', '406', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('660', '2', '0', '1', '1', '1', '5', '6', '506', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('661', '2', '0', '1', '1', '1', '6', '6', '606', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('662', '2', '0', '1', '1', '1', '7', '6', '706', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('663', '2', '0', '1', '1', '1', '8', '6', '806', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('664', '2', '0', '1', '1', '1', '9', '6', '906', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('665', '2', '0', '1', '1', '1', '10', '6', '1006', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('666', '2', '0', '1', '1', '1', '11', '6', '1106', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('667', '2', '0', '1', '1', '1', '12', '6', '1206', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('668', '2', '0', '1', '1', '1', '13', '6', '1306', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('669', '2', '0', '1', '1', '1', '14', '6', '1406', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('670', '2', '0', '1', '1', '1', '15', '6', '1506', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('671', '2', '0', '1', '1', '1', '16', '6', '1606', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('672', '2', '0', '1', '1', '1', '17', '6', '1706', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('673', '2', '0', '1', '1', '1', '18', '6', '1806', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('674', '2', '0', '1', '1', '1', '19', '6', '1906', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('675', '2', '0', '1', '1', '1', '20', '6', '2006', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('676', '2', '0', '1', '1', '1', '21', '6', '2106', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('677', '2', '0', '1', '1', '1', '22', '6', '2206', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('678', '2', '0', '1', '1', '1', '23', '6', '2306', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('679', '2', '0', '1', '1', '1', '24', '6', '2406', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('680', '2', '0', '1', '1', '1', '25', '6', '2506', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('681', '2', '0', '1', '1', '1', '26', '6', '2606', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('682', '2', '0', '1', '1', '1', '27', '6', '2706', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('683', '2', '0', '1', '1', '1', '28', '6', '2806', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('684', '2', '0', '1', '1', '1', '29', '6', '2906', null, '62.70', '62.70', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('685', '2', '0', '1', '1', '1', '4', '7', '407', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('686', '2', '0', '1', '1', '1', '5', '7', '507', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('687', '2', '0', '1', '1', '1', '6', '7', '607', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('688', '2', '0', '1', '1', '1', '7', '7', '707', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('689', '2', '0', '1', '1', '1', '8', '7', '807', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('690', '2', '0', '1', '1', '1', '9', '7', '907', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('691', '2', '0', '1', '1', '1', '10', '7', '1007', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('692', '2', '0', '1', '1', '1', '11', '7', '1107', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('693', '2', '0', '1', '1', '1', '12', '7', '1207', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('694', '2', '0', '1', '1', '1', '13', '7', '1307', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('695', '2', '0', '1', '1', '1', '14', '7', '1407', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('696', '2', '0', '1', '1', '1', '15', '7', '1507', null, '42.13', '42.13', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('697', '2', '0', '1', '1', '1', '16', '7', '1607', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('698', '2', '0', '1', '1', '1', '17', '7', '1707', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('699', '2', '0', '1', '1', '1', '18', '7', '1807', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('700', '2', '0', '1', '1', '1', '19', '7', '1907', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('701', '2', '0', '1', '1', '1', '20', '7', '2007', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('702', '2', '0', '1', '1', '1', '21', '7', '2107', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('703', '2', '0', '1', '1', '1', '22', '7', '2207', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('704', '2', '0', '1', '1', '1', '23', '7', '2307', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('705', '2', '0', '1', '1', '1', '24', '7', '2407', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('706', '2', '0', '1', '1', '1', '25', '7', '2507', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('707', '2', '0', '1', '1', '1', '26', '7', '2607', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('708', '2', '0', '1', '1', '1', '27', '7', '2707', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('709', '2', '0', '1', '1', '1', '28', '7', '2807', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('710', '2', '0', '1', '1', '1', '29', '7', '2907', null, '42.10', '42.10', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('711', '2', '0', '1', '1', '1', '4', '8', '408', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('712', '2', '0', '1', '1', '1', '5', '8', '508', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('713', '2', '0', '1', '1', '1', '6', '8', '608', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('714', '2', '0', '1', '1', '1', '7', '8', '708', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('715', '2', '0', '1', '1', '1', '8', '8', '808', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('716', '2', '0', '1', '1', '1', '9', '8', '908', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('717', '2', '0', '1', '1', '1', '10', '8', '1008', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('718', '2', '0', '1', '1', '1', '11', '8', '1108', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('719', '2', '0', '1', '1', '1', '12', '8', '1208', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('720', '2', '0', '1', '1', '1', '13', '8', '1308', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('721', '2', '0', '1', '1', '1', '14', '8', '1408', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('722', '2', '0', '1', '1', '1', '15', '8', '1508', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('723', '2', '0', '1', '1', '1', '16', '8', '1608', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('724', '2', '0', '1', '1', '1', '17', '8', '1708', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('725', '2', '0', '1', '1', '1', '18', '8', '1808', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('726', '2', '0', '1', '1', '1', '19', '8', '1908', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('727', '2', '0', '1', '1', '1', '20', '8', '2008', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('728', '2', '0', '1', '1', '1', '21', '8', '2108', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('729', '2', '0', '1', '1', '1', '22', '8', '2208', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('730', '2', '0', '1', '1', '1', '23', '8', '2308', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('731', '2', '0', '1', '1', '1', '24', '8', '2408', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('732', '2', '0', '1', '1', '1', '25', '8', '2508', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('733', '2', '0', '1', '1', '1', '26', '8', '2608', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('734', '2', '0', '1', '1', '1', '27', '8', '2708', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('735', '2', '0', '1', '1', '1', '28', '8', '2808', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('736', '2', '0', '1', '1', '1', '29', '8', '2908', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('737', '2', '0', '1', '1', '1', '4', '9', '409', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('738', '2', '0', '1', '1', '1', '5', '9', '509', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('739', '2', '0', '1', '1', '1', '6', '9', '609', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('740', '2', '0', '1', '1', '1', '7', '9', '709', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('741', '2', '0', '1', '1', '1', '8', '9', '809', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('742', '2', '0', '1', '1', '1', '9', '9', '909', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('743', '2', '0', '1', '1', '1', '10', '9', '1009', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('744', '2', '0', '1', '1', '1', '11', '9', '1109', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('745', '2', '0', '1', '1', '1', '12', '9', '1209', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('746', '2', '0', '1', '1', '1', '13', '9', '1309', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('747', '2', '0', '1', '1', '1', '14', '9', '1409', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('748', '2', '0', '1', '1', '1', '15', '9', '1509', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('749', '2', '0', '1', '1', '1', '16', '9', '1609', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('750', '2', '0', '1', '1', '1', '17', '9', '1709', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('751', '2', '0', '1', '1', '1', '18', '9', '1809', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('752', '2', '0', '1', '1', '1', '19', '9', '1909', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('753', '2', '0', '1', '1', '1', '20', '9', '2009', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('754', '2', '0', '1', '1', '1', '21', '9', '2109', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('755', '2', '0', '1', '1', '1', '22', '9', '2209', null, '42.02', '42.02', '0.00', '0.00', '0.00', '1', '1513143136', '2', '天誉test2', '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('756', '2', '0', '1', '1', '1', '23', '9', '2309', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('757', '2', '0', '1', '1', '1', '24', '9', '2409', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('758', '2', '0', '1', '1', '1', '25', '9', '2509', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('759', '2', '0', '1', '1', '1', '26', '9', '2609', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('760', '2', '0', '1', '1', '1', '27', '9', '2709', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('761', '2', '0', '1', '1', '1', '28', '9', '2809', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('762', '2', '0', '1', '1', '1', '29', '9', '2909', null, '42.02', '42.02', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('763', '2', '0', '1', '1', '1', '4', '10', '410', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('764', '2', '0', '1', '1', '1', '5', '10', '510', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('765', '2', '0', '1', '1', '1', '6', '10', '610', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('766', '2', '0', '1', '1', '1', '7', '10', '710', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('767', '2', '0', '1', '1', '1', '8', '10', '810', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('768', '2', '0', '1', '1', '1', '9', '10', '910', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('769', '2', '0', '1', '1', '1', '10', '10', '1010', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('770', '2', '0', '1', '1', '1', '11', '10', '1110', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('771', '2', '0', '1', '1', '1', '12', '10', '1210', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('772', '2', '0', '1', '1', '1', '13', '10', '1310', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('773', '2', '0', '1', '1', '1', '14', '10', '1410', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('774', '2', '0', '1', '1', '1', '15', '10', '1510', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('775', '2', '0', '1', '1', '1', '16', '10', '1610', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('776', '2', '0', '1', '1', '1', '17', '10', '1710', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('777', '2', '0', '1', '1', '1', '18', '10', '1810', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('778', '2', '0', '1', '1', '1', '19', '10', '1910', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('779', '2', '0', '1', '1', '1', '20', '10', '2010', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('780', '2', '0', '1', '1', '1', '21', '10', '2110', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('781', '2', '0', '1', '1', '1', '22', '10', '2210', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('782', '2', '0', '1', '1', '1', '23', '10', '2310', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('783', '2', '0', '1', '1', '1', '24', '10', '2410', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('784', '2', '0', '1', '1', '1', '25', '10', '2510', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('785', '2', '0', '1', '1', '1', '26', '10', '2610', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('786', '2', '0', '1', '1', '1', '27', '10', '2710', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('787', '2', '0', '1', '1', '1', '28', '10', '2810', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('788', '2', '0', '1', '1', '1', '29', '10', '2910', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('789', '2', '0', '1', '1', '1', '5', '11', '511', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('790', '2', '0', '1', '1', '1', '6', '11', '611', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('791', '2', '0', '1', '1', '1', '7', '11', '711', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('792', '2', '0', '1', '1', '1', '8', '11', '811', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('793', '2', '0', '1', '1', '1', '9', '11', '911', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('794', '2', '0', '1', '1', '1', '10', '11', '1011', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('795', '2', '0', '1', '1', '1', '11', '11', '1111', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('796', '2', '0', '1', '1', '1', '12', '11', '1211', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('797', '2', '0', '1', '1', '1', '13', '11', '1311', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('798', '2', '0', '1', '1', '1', '14', '11', '1411', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('799', '2', '0', '1', '1', '1', '15', '11', '1511', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('800', '2', '0', '1', '1', '1', '16', '11', '1611', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('801', '2', '0', '1', '1', '1', '17', '11', '1711', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('802', '2', '0', '1', '1', '1', '18', '11', '1811', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('803', '2', '0', '1', '1', '1', '19', '11', '1911', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('804', '2', '0', '1', '1', '1', '20', '11', '2011', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('805', '2', '0', '1', '1', '1', '21', '11', '2111', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('806', '2', '0', '1', '1', '1', '22', '11', '2211', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('807', '2', '0', '1', '1', '1', '23', '11', '2311', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('808', '2', '0', '1', '1', '1', '24', '11', '2411', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('809', '2', '0', '1', '1', '1', '25', '11', '2511', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('810', '2', '0', '1', '1', '1', '26', '11', '2611', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('811', '2', '0', '1', '1', '1', '27', '11', '2711', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('812', '2', '0', '1', '1', '1', '28', '11', '2811', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('813', '2', '0', '1', '1', '1', '29', '11', '2911', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('814', '2', '0', '1', '1', '1', '5', '12', '512', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('815', '2', '0', '1', '1', '1', '6', '12', '612', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('816', '2', '0', '1', '1', '1', '7', '12', '712', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('817', '2', '0', '1', '1', '1', '8', '12', '812', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('818', '2', '0', '1', '1', '1', '9', '12', '912', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('819', '2', '0', '1', '1', '1', '10', '12', '1012', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('820', '2', '0', '1', '1', '1', '11', '12', '1112', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('821', '2', '0', '1', '1', '1', '12', '12', '1212', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('822', '2', '0', '1', '1', '1', '13', '12', '1312', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('823', '2', '0', '1', '1', '1', '14', '12', '1412', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('824', '2', '0', '1', '1', '1', '15', '12', '1512', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('825', '2', '0', '1', '1', '1', '16', '12', '1612', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('826', '2', '0', '1', '1', '1', '17', '12', '1712', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('827', '2', '0', '1', '1', '1', '18', '12', '1812', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('828', '2', '0', '1', '1', '1', '19', '12', '1912', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('829', '2', '0', '1', '1', '1', '20', '12', '2012', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('830', '2', '0', '1', '1', '1', '21', '12', '2112', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('831', '2', '0', '1', '1', '1', '22', '12', '2212', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('832', '2', '0', '1', '1', '1', '23', '12', '2312', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('833', '2', '0', '1', '1', '1', '24', '12', '2412', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('834', '2', '0', '1', '1', '1', '25', '12', '2512', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('835', '2', '0', '1', '1', '1', '26', '12', '2612', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('836', '2', '0', '1', '1', '1', '27', '12', '2712', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('837', '2', '0', '1', '1', '1', '28', '12', '2812', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('838', '2', '0', '1', '1', '1', '29', '12', '2912', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('839', '2', '0', '1', '1', '1', '5', '13', '513', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('840', '2', '0', '1', '1', '1', '6', '13', '613', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('841', '2', '0', '1', '1', '1', '7', '13', '713', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('842', '2', '0', '1', '1', '1', '8', '13', '813', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('843', '2', '0', '1', '1', '1', '9', '13', '913', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('844', '2', '0', '1', '1', '1', '10', '13', '1013', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('845', '2', '0', '1', '1', '1', '11', '13', '1113', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('846', '2', '0', '1', '1', '1', '12', '13', '1213', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('847', '2', '0', '1', '1', '1', '13', '13', '1313', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('848', '2', '0', '1', '1', '1', '14', '13', '1413', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('849', '2', '0', '1', '1', '1', '15', '13', '1513', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('850', '2', '0', '1', '1', '1', '16', '13', '1613', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('851', '2', '0', '1', '1', '1', '17', '13', '1713', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('852', '2', '0', '1', '1', '1', '18', '13', '1813', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('853', '2', '0', '1', '1', '1', '19', '13', '1913', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('854', '2', '0', '1', '1', '1', '20', '13', '2013', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('855', '2', '0', '1', '1', '1', '21', '13', '2113', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('856', '2', '0', '1', '1', '1', '22', '13', '2213', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('857', '2', '0', '1', '1', '1', '23', '13', '2313', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('858', '2', '0', '1', '1', '1', '24', '13', '2413', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('859', '2', '0', '1', '1', '1', '25', '13', '2513', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('860', '2', '0', '1', '1', '1', '26', '13', '2613', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('861', '2', '0', '1', '1', '1', '27', '13', '2713', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('862', '2', '0', '1', '1', '1', '28', '13', '2813', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('863', '2', '0', '1', '1', '1', '29', '13', '2913', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('864', '2', '0', '1', '1', '1', '5', '14', '514', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('865', '2', '0', '1', '1', '1', '6', '14', '614', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('866', '2', '0', '1', '1', '1', '7', '14', '714', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('867', '2', '0', '1', '1', '1', '8', '14', '814', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('868', '2', '0', '1', '1', '1', '9', '14', '914', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('869', '2', '0', '1', '1', '1', '10', '14', '1014', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('870', '2', '0', '1', '1', '1', '11', '14', '1114', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('871', '2', '0', '1', '1', '1', '12', '14', '1214', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('872', '2', '0', '1', '1', '1', '13', '14', '1314', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('873', '2', '0', '1', '1', '1', '14', '14', '1414', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('874', '2', '0', '1', '1', '1', '15', '14', '1514', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('875', '2', '0', '1', '1', '1', '16', '14', '1614', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('876', '2', '0', '1', '1', '1', '17', '14', '1714', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('877', '2', '0', '1', '1', '1', '18', '14', '1814', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('878', '2', '0', '1', '1', '1', '19', '14', '1914', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('879', '2', '0', '1', '1', '1', '20', '14', '2014', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('880', '2', '0', '1', '1', '1', '21', '14', '2114', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('881', '2', '0', '1', '1', '1', '22', '14', '2214', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('882', '2', '0', '1', '1', '1', '23', '14', '2314', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('883', '2', '0', '1', '1', '1', '24', '14', '2414', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('884', '2', '0', '1', '1', '1', '25', '14', '2514', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('885', '2', '0', '1', '1', '1', '26', '14', '2614', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('886', '2', '0', '1', '1', '1', '27', '14', '2714', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('887', '2', '0', '1', '1', '1', '28', '14', '2814', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('888', '2', '0', '1', '1', '1', '29', '14', '2914', null, '42.03', '42.03', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('889', '2', '0', '1', '1', '1', '5', '15', '515', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('890', '2', '0', '1', '1', '1', '6', '15', '615', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('891', '2', '0', '1', '1', '1', '7', '15', '715', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('892', '2', '0', '1', '1', '1', '8', '15', '815', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('893', '2', '0', '1', '1', '1', '9', '15', '915', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('894', '2', '0', '1', '1', '1', '10', '15', '1015', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('895', '2', '0', '1', '1', '1', '11', '15', '1115', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('896', '2', '0', '1', '1', '1', '12', '15', '1215', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('897', '2', '0', '1', '1', '1', '13', '15', '1315', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('898', '2', '0', '1', '1', '1', '14', '15', '1415', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('899', '2', '0', '1', '1', '1', '15', '15', '1515', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('900', '2', '0', '1', '1', '1', '16', '15', '1615', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('901', '2', '0', '1', '1', '1', '17', '15', '1715', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('902', '2', '0', '1', '1', '1', '18', '15', '1815', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('903', '2', '0', '1', '1', '1', '19', '15', '1915', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('904', '2', '0', '1', '1', '1', '20', '15', '2015', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('905', '2', '0', '1', '1', '1', '21', '15', '2115', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('906', '2', '0', '1', '1', '1', '22', '15', '2215', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('907', '2', '0', '1', '1', '1', '23', '15', '2315', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('908', '2', '0', '1', '1', '1', '24', '15', '2415', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('909', '2', '0', '1', '1', '1', '25', '15', '2515', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('910', '2', '0', '1', '1', '1', '26', '15', '2615', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('911', '2', '0', '1', '1', '1', '27', '15', '2715', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('912', '2', '0', '1', '1', '1', '28', '15', '2815', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('913', '2', '0', '1', '1', '1', '29', '15', '2915', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('914', '2', '0', '1', '1', '1', '5', '16', '516', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('915', '2', '0', '1', '1', '1', '6', '16', '616', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('916', '2', '0', '1', '1', '1', '7', '16', '716', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('917', '2', '0', '1', '1', '1', '8', '16', '816', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('918', '2', '0', '1', '1', '1', '9', '16', '916', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('919', '2', '0', '1', '1', '1', '10', '16', '1016', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('920', '2', '0', '1', '1', '1', '11', '16', '1116', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('921', '2', '0', '1', '1', '1', '12', '16', '1216', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('922', '2', '0', '1', '1', '1', '13', '16', '1316', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('923', '2', '0', '1', '1', '1', '14', '16', '1416', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('924', '2', '0', '1', '1', '1', '15', '16', '1516', null, '42.06', '42.06', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('925', '2', '0', '1', '1', '1', '16', '16', '1616', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('926', '2', '0', '1', '1', '1', '17', '16', '1716', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('927', '2', '0', '1', '1', '1', '18', '16', '1816', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('928', '2', '0', '1', '1', '1', '19', '16', '1916', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('929', '2', '0', '1', '1', '1', '20', '16', '2016', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('930', '2', '0', '1', '1', '1', '21', '16', '2116', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('931', '2', '0', '1', '1', '1', '22', '16', '2216', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('932', '2', '0', '1', '1', '1', '23', '16', '2316', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('933', '2', '0', '1', '1', '1', '24', '16', '2416', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('934', '2', '0', '1', '1', '1', '25', '16', '2516', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('935', '2', '0', '1', '1', '1', '26', '16', '2616', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('936', '2', '0', '1', '1', '1', '27', '16', '2716', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('937', '2', '0', '1', '1', '1', '28', '16', '2816', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('938', '2', '0', '1', '1', '1', '29', '16', '2916', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('939', '2', '0', '1', '1', '1', '5', '17', '517', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('940', '2', '0', '1', '1', '1', '6', '17', '617', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('941', '2', '0', '1', '1', '1', '7', '17', '717', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('942', '2', '0', '1', '1', '1', '8', '17', '817', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('943', '2', '0', '1', '1', '1', '9', '17', '917', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('944', '2', '0', '1', '1', '1', '10', '17', '1017', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('945', '2', '0', '1', '1', '1', '11', '17', '1117', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('946', '2', '0', '1', '1', '1', '12', '17', '1217', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('947', '2', '0', '1', '1', '1', '13', '17', '1317', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('948', '2', '0', '1', '1', '1', '14', '17', '1417', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('949', '2', '0', '1', '1', '1', '15', '17', '1517', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('950', '2', '0', '1', '1', '1', '16', '17', '1617', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('951', '2', '0', '1', '1', '1', '17', '17', '1717', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('952', '2', '0', '1', '1', '1', '18', '17', '1817', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('953', '2', '0', '1', '1', '1', '19', '17', '1917', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('954', '2', '0', '1', '1', '1', '20', '17', '2017', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('955', '2', '0', '1', '1', '1', '21', '17', '2117', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('956', '2', '0', '1', '1', '1', '22', '17', '2217', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('957', '2', '0', '1', '1', '1', '23', '17', '2317', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('958', '2', '0', '1', '1', '1', '24', '17', '2417', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('959', '2', '0', '1', '1', '1', '25', '17', '2517', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('960', '2', '0', '1', '1', '1', '26', '17', '2617', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('961', '2', '0', '1', '1', '1', '27', '17', '2717', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('962', '2', '0', '1', '1', '1', '28', '17', '2817', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('963', '2', '0', '1', '1', '1', '29', '17', '2917', null, '42.04', '42.04', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('964', '2', '0', '1', '1', '1', '5', '18', '518', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('965', '2', '0', '1', '1', '1', '6', '18', '618', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('966', '2', '0', '1', '1', '1', '7', '18', '718', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('967', '2', '0', '1', '1', '1', '8', '18', '818', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('968', '2', '0', '1', '1', '1', '9', '18', '918', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('969', '2', '0', '1', '1', '1', '10', '18', '1018', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('970', '2', '0', '1', '1', '1', '11', '18', '1118', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('971', '2', '0', '1', '1', '1', '12', '18', '1218', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('972', '2', '0', '1', '1', '1', '13', '18', '1318', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('973', '2', '0', '1', '1', '1', '14', '18', '1418', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('974', '2', '0', '1', '1', '1', '15', '18', '1518', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('975', '2', '0', '1', '1', '1', '16', '18', '1618', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('976', '2', '0', '1', '1', '1', '17', '18', '1718', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('977', '2', '0', '1', '1', '1', '18', '18', '1818', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('978', '2', '0', '1', '1', '1', '19', '18', '1918', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('979', '2', '0', '1', '1', '1', '20', '18', '2018', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('980', '2', '0', '1', '1', '1', '21', '18', '2118', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('981', '2', '0', '1', '1', '1', '22', '18', '2218', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('982', '2', '0', '1', '1', '1', '23', '18', '2318', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('983', '2', '0', '1', '1', '1', '24', '18', '2418', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('984', '2', '0', '1', '1', '1', '25', '18', '2518', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('985', '2', '0', '1', '1', '1', '26', '18', '2618', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('986', '2', '0', '1', '1', '1', '27', '18', '2718', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('987', '2', '0', '1', '1', '1', '28', '18', '2818', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('988', '2', '0', '1', '1', '1', '29', '18', '2918', null, '42.05', '42.05', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('989', '2', '0', '1', '1', '1', '5', '19', '519', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('990', '2', '0', '1', '1', '1', '6', '19', '619', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('991', '2', '0', '1', '1', '1', '7', '19', '719', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('992', '2', '0', '1', '1', '1', '8', '19', '819', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('993', '2', '0', '1', '1', '1', '9', '19', '919', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('994', '2', '0', '1', '1', '1', '10', '19', '1019', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('995', '2', '0', '1', '1', '1', '11', '19', '1119', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('996', '2', '0', '1', '1', '1', '12', '19', '1219', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('997', '2', '0', '1', '1', '1', '13', '19', '1319', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('998', '2', '0', '1', '1', '1', '14', '19', '1419', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('999', '2', '0', '1', '1', '1', '15', '19', '1519', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1000', '2', '0', '1', '1', '1', '16', '19', '1619', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1001', '2', '0', '1', '1', '1', '17', '19', '1719', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1002', '2', '0', '1', '1', '1', '18', '19', '1819', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1003', '2', '0', '1', '1', '1', '19', '19', '1919', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1004', '2', '0', '1', '1', '1', '20', '19', '2019', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1005', '2', '0', '1', '1', '1', '21', '19', '2119', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1006', '2', '0', '1', '1', '1', '22', '19', '2219', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1007', '2', '0', '1', '1', '1', '23', '19', '2319', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1008', '2', '0', '1', '1', '1', '24', '19', '2419', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1009', '2', '0', '1', '1', '1', '25', '19', '2519', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1010', '2', '0', '1', '1', '1', '26', '19', '2619', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1011', '2', '0', '1', '1', '1', '27', '19', '2719', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1012', '2', '0', '1', '1', '1', '28', '19', '2819', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1013', '2', '0', '1', '1', '1', '29', '19', '2919', null, '70.52', '70.52', '0.00', '0.00', '0.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1014', '3', '0', '1', '1', '1', '1', '1', '101 ', 'A2', '90.00', '80.00', '8000.00', '10500.00', '720000.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1015', '3', '0', '1', '1', '1', '1', '2', '102 ', 'A2', '91.00', '80.00', '8100.00', '11500.00', '737100.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1016', '3', '0', '1', '1', '1', '1', '3', '103', 'A1', '92.00', '80.00', '8100.00', '11500.00', '745200.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1017', '3', '0', '1', '1', '1', '1', '4', '104', 'A1', '93.00', '80.00', '8100.00', '11500.00', '753300.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1018', '3', '0', '1', '1', '1', '2', '1', '201', 'A1', '94.00', '80.00', '8100.00', '11500.00', '761400.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1019', '3', '0', '1', '1', '1', '2', '2', '202 ', 'A2', '95.00', '80.00', '8100.00', '11500.00', '769500.00', '0', null, '0', null, '0', null, '0', '18000000002', '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1020', '3', '0', '1', '1', '1', '2', '3', '203', 'A2', '96.00', '80.00', '8100.00', '11500.00', '777600.00', '0', null, '0', null, '0', null, '0', '18000000001', '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1311', '17', '0', '3', '2', '1', '1', '4', '104', 'C1', '117.42', '0.00', '6247.00', '0.00', '733523.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1022', '4', '0', '2', '2', '1', '1', '1', '101', 'Q3', '100.00', '90.00', '0.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '814821.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1023', '4', '0', '2', '2', '1', '1', '3', '103', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1024', '4', '0', '2', '2', '1', '1', '4', '104', 'Q2', '132.20', '107.70', '6900.00', '0.00', '912180.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902180.00', '907180.00', '911180.00', '910180.00');
INSERT INTO `xk_room` VALUES ('1025', '4', '0', '2', '2', '2', '1', '6', '106', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1026', '4', '0', '2', '2', '2', '1', '7', '107', 'Q2', '132.20', '107.70', '6900.00', '0.00', '912180.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902180.00', '907180.00', '911180.00', '910180.00');
INSERT INTO `xk_room` VALUES ('1027', '4', '0', '2', '2', '2', '1', '8', '108', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1028', '4', '0', '2', '2', '1', '2', '1', '201', 'Q3', '0.00', '0.00', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1029', '4', '0', '2', '2', '1', '2', '3', '203', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1030', '4', '0', '2', '2', '1', '2', '4', '204', 'Q2', '132.37', '107.84', '6900.00', '0.00', '913353.00', '0', '0', null, '', '0', null, '0', null, '0.00', '903353.00', '908353.00', '912353.00', '911353.00');
INSERT INTO `xk_room` VALUES ('1031', '4', '0', '2', '2', '2', '2', '6', '206', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1032', '4', '0', '2', '2', '2', '2', '7', '207', 'Q2', '132.37', '107.84', '6900.00', '0.00', '913353.00', '0', '0', null, '', '0', null, '0', null, '0.00', '903353.00', '908353.00', '912353.00', '911353.00');
INSERT INTO `xk_room` VALUES ('1033', '4', '0', '2', '2', '2', '2', '8', '208', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1034', '4', '0', '2', '2', '1', '3', '1', '301', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1035', '4', '0', '2', '2', '1', '3', '2', '302', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1036', '4', '0', '2', '2', '1', '3', '3', '303', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1037', '4', '0', '2', '2', '1', '3', '4', '304', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1038', '4', '0', '2', '2', '2', '3', '5', '305', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1039', '4', '0', '2', '2', '2', '3', '6', '306', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1040', '4', '0', '2', '2', '2', '3', '7', '307', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1041', '4', '0', '2', '2', '2', '3', '8', '308', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1042', '4', '0', '2', '2', '1', '4', '1', '401', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1043', '4', '0', '2', '2', '1', '4', '2', '402', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1044', '4', '0', '2', '2', '1', '4', '3', '403', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1045', '4', '0', '2', '2', '1', '4', '4', '404', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1046', '4', '0', '2', '2', '2', '4', '5', '405', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1047', '4', '0', '2', '2', '2', '4', '6', '406', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1048', '4', '0', '2', '2', '2', '4', '7', '407', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1049', '4', '0', '2', '2', '2', '4', '8', '408', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1050', '4', '0', '2', '2', '1', '5', '1', '501', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1051', '4', '0', '2', '2', '1', '5', '2', '502', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1052', '4', '0', '2', '2', '1', '5', '3', '503', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1053', '4', '0', '2', '2', '1', '5', '4', '504', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1054', '4', '0', '2', '2', '2', '5', '5', '505', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1055', '4', '0', '2', '2', '2', '5', '6', '506', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1056', '4', '0', '2', '2', '2', '5', '7', '507', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1057', '4', '0', '2', '2', '2', '5', '8', '508', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1058', '4', '0', '2', '2', '1', '6', '1', '601', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1059', '4', '0', '2', '2', '1', '6', '2', '602', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1060', '4', '0', '2', '2', '1', '6', '3', '603', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1061', '4', '0', '2', '2', '1', '6', '4', '604', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1062', '4', '0', '2', '2', '2', '6', '5', '605', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1063', '4', '0', '2', '2', '2', '6', '6', '606', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1064', '4', '0', '2', '2', '2', '6', '7', '607', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1065', '4', '0', '2', '2', '2', '6', '8', '608', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1066', '4', '0', '2', '2', '1', '7', '1', '701', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1067', '4', '0', '2', '2', '1', '7', '2', '702', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1068', '4', '0', '2', '2', '1', '7', '3', '703', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1069', '4', '0', '2', '2', '1', '7', '4', '704', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1070', '4', '0', '2', '2', '2', '7', '5', '705', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1071', '4', '0', '2', '2', '2', '7', '6', '706', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1072', '4', '0', '2', '2', '2', '7', '7', '707', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1073', '4', '0', '2', '2', '2', '7', '8', '708', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1074', '4', '0', '2', '2', '1', '8', '1', '801', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1075', '4', '0', '2', '2', '1', '8', '2', '802', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1076', '4', '0', '2', '2', '1', '8', '3', '803', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1077', '4', '0', '2', '2', '1', '8', '4', '804', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1078', '4', '0', '2', '2', '2', '8', '5', '805', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1079', '4', '0', '2', '2', '2', '8', '6', '806', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1080', '4', '0', '2', '2', '2', '8', '7', '807', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1081', '4', '0', '2', '2', '2', '8', '8', '808', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1082', '4', '0', '2', '2', '1', '9', '1', '901', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1083', '4', '0', '2', '2', '1', '9', '2', '902', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1084', '4', '0', '2', '2', '1', '9', '3', '903', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1085', '4', '0', '2', '2', '1', '9', '4', '904', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1086', '4', '0', '2', '2', '2', '9', '5', '905', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1087', '4', '0', '2', '2', '2', '9', '6', '906', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1088', '4', '0', '2', '2', '2', '9', '7', '907', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1089', '4', '0', '2', '2', '2', '9', '8', '908', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1090', '4', '0', '2', '2', '1', '10', '1', '1001', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1091', '4', '0', '2', '2', '1', '10', '2', '1002', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1092', '4', '0', '2', '2', '1', '10', '3', '1003', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1093', '4', '0', '2', '2', '1', '10', '4', '1004', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1094', '4', '0', '2', '2', '2', '10', '5', '1005', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1095', '4', '0', '2', '2', '2', '10', '6', '1006', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1096', '4', '0', '2', '2', '2', '10', '7', '1007', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1097', '4', '0', '2', '2', '2', '10', '8', '1008', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1098', '4', '0', '2', '2', '1', '11', '1', '1101', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1099', '4', '0', '2', '2', '1', '11', '2', '1102', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1100', '4', '0', '2', '2', '1', '11', '3', '1103', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1101', '4', '0', '2', '2', '1', '11', '4', '1104', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1102', '4', '0', '2', '2', '2', '11', '5', '1105', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1103', '4', '0', '2', '2', '2', '11', '6', '1106', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1104', '4', '0', '2', '2', '2', '11', '7', '1107', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1105', '4', '0', '2', '2', '2', '11', '8', '1108', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1106', '4', '0', '2', '2', '1', '12', '1', '1201', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1107', '4', '0', '2', '2', '1', '12', '2', '1202', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1108', '4', '0', '2', '2', '1', '12', '3', '1203', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1109', '4', '0', '2', '2', '1', '12', '4', '1204', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1110', '4', '0', '2', '2', '2', '12', '5', '1205', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1111', '4', '0', '2', '2', '2', '12', '6', '1206', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1112', '4', '0', '2', '2', '2', '12', '7', '1207', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1113', '4', '0', '2', '2', '2', '12', '8', '1208', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1114', '4', '0', '2', '2', '1', '13', '1', '1301', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1115', '4', '0', '2', '2', '1', '13', '2', '1302', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1116', '4', '0', '2', '2', '1', '13', '3', '1303', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1117', '4', '0', '2', '2', '1', '13', '4', '1304', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1118', '4', '0', '2', '2', '2', '13', '5', '1305', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1119', '4', '0', '2', '2', '2', '13', '6', '1306', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1120', '4', '0', '2', '2', '2', '13', '7', '1307', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1121', '4', '0', '2', '2', '2', '13', '8', '1308', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1122', '4', '0', '2', '2', '1', '14', '1', '1401', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1123', '4', '0', '2', '2', '1', '14', '2', '1402', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1124', '4', '0', '2', '2', '1', '14', '3', '1403', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1125', '4', '0', '2', '2', '1', '14', '4', '1404', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1126', '4', '0', '2', '2', '2', '14', '5', '1405', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1127', '4', '0', '2', '2', '2', '14', '6', '1406', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1128', '4', '0', '2', '2', '2', '14', '7', '1407', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1129', '4', '0', '2', '2', '2', '14', '8', '1408', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1130', '4', '0', '2', '2', '1', '15', '1', '1501', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1131', '4', '0', '2', '2', '1', '15', '2', '1502', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1132', '4', '0', '2', '2', '1', '15', '3', '1503', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1133', '4', '0', '2', '2', '1', '15', '4', '1504', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1134', '4', '0', '2', '2', '2', '15', '5', '1505', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1135', '4', '0', '2', '2', '2', '15', '6', '1506', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1136', '4', '0', '2', '2', '2', '15', '7', '1507', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1137', '4', '0', '2', '2', '2', '15', '8', '1508', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1138', '4', '0', '2', '2', '1', '16', '1', '1601', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1139', '4', '0', '2', '2', '1', '16', '2', '1602', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1140', '4', '0', '2', '2', '1', '16', '3', '1603', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1141', '4', '0', '2', '2', '1', '16', '4', '1604', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1142', '4', '0', '2', '2', '2', '16', '5', '1605', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1143', '4', '0', '2', '2', '2', '16', '6', '1606', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1144', '4', '0', '2', '2', '2', '16', '7', '1607', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1145', '4', '0', '2', '2', '2', '16', '8', '1608', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1146', '4', '0', '2', '2', '1', '17', '1', '1701', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1147', '4', '0', '2', '2', '1', '17', '2', '1702', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1148', '4', '0', '2', '2', '1', '17', '3', '1703', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1149', '4', '0', '2', '2', '1', '17', '4', '1704', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1150', '4', '0', '2', '2', '2', '17', '5', '1705', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1151', '4', '0', '2', '2', '2', '17', '6', '1706', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1152', '4', '0', '2', '2', '2', '17', '7', '1707', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1153', '4', '0', '2', '2', '2', '17', '8', '1708', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1154', '4', '0', '2', '2', '1', '18', '1', '1801', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1155', '4', '0', '2', '2', '1', '18', '2', '1802', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1156', '4', '0', '2', '2', '1', '18', '3', '1803', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1157', '4', '0', '2', '2', '1', '18', '4', '1804', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1158', '4', '0', '2', '2', '2', '18', '5', '1805', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1159', '4', '0', '2', '2', '2', '18', '6', '1806', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1160', '4', '0', '2', '2', '2', '18', '7', '1807', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1161', '4', '0', '2', '2', '2', '18', '8', '1808', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1162', '4', '0', '2', '2', '1', '19', '1', '1901', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1163', '4', '0', '2', '2', '1', '19', '2', '1902', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1164', '4', '0', '2', '2', '1', '19', '3', '1903', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1165', '4', '0', '2', '2', '1', '19', '4', '1904', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1166', '4', '0', '2', '2', '2', '19', '5', '1905', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1167', '4', '0', '2', '2', '2', '19', '6', '1906', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1168', '4', '0', '2', '2', '2', '19', '7', '1907', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1169', '4', '0', '2', '2', '2', '19', '8', '1908', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1170', '4', '0', '2', '2', '1', '20', '1', '2001', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1171', '4', '0', '2', '2', '1', '20', '2', '2002', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1172', '4', '0', '2', '2', '1', '20', '3', '2003', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1173', '4', '0', '2', '2', '1', '20', '4', '2004', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1174', '4', '0', '2', '2', '2', '20', '5', '2005', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1175', '4', '0', '2', '2', '2', '20', '6', '2006', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', '0', '', '1', '1521711132', '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1176', '4', '0', '2', '2', '2', '20', '7', '2007', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1177', '4', '0', '2', '2', '2', '20', '8', '2008', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1178', '4', '0', '2', '2', '1', '21', '1', '2101', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1179', '4', '0', '2', '2', '1', '21', '2', '2102', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1180', '4', '0', '2', '2', '1', '21', '3', '2103', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1181', '4', '0', '2', '2', '1', '21', '4', '2104', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1182', '4', '0', '2', '2', '2', '21', '5', '2105', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1183', '4', '0', '2', '2', '2', '21', '6', '2106', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1184', '4', '0', '2', '2', '2', '21', '7', '2107', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1185', '4', '0', '2', '2', '2', '21', '8', '2108', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1186', '4', '0', '2', '2', '1', '22', '1', '2201', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1187', '4', '0', '2', '2', '1', '22', '2', '2202', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1188', '4', '0', '2', '2', '1', '22', '3', '2203', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1189', '4', '0', '2', '2', '1', '22', '4', '2204', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1190', '4', '0', '2', '2', '2', '22', '5', '2205', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1191', '4', '0', '2', '2', '2', '22', '6', '2206', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1192', '4', '0', '2', '2', '2', '22', '7', '2207', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1193', '4', '0', '2', '2', '2', '22', '8', '2208', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1194', '4', '0', '2', '2', '1', '23', '1', '2301', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1195', '4', '0', '2', '2', '1', '23', '2', '2302', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1196', '4', '0', '2', '2', '1', '23', '3', '2303', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1197', '4', '0', '2', '2', '1', '23', '4', '2304', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1198', '4', '0', '2', '2', '2', '23', '5', '2305', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1199', '4', '0', '2', '2', '2', '23', '6', '2306', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1200', '4', '0', '2', '2', '2', '23', '7', '2307', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1201', '4', '0', '2', '2', '2', '23', '8', '2308', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1202', '4', '0', '2', '2', '1', '24', '1', '2401', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1203', '4', '0', '2', '2', '1', '24', '2', '2402', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1204', '4', '0', '2', '2', '1', '24', '3', '2403', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1205', '4', '0', '2', '2', '1', '24', '4', '2404', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1206', '4', '0', '2', '2', '2', '24', '5', '2405', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1207', '4', '0', '2', '2', '2', '24', '6', '2406', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1208', '4', '0', '2', '2', '2', '24', '7', '2407', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1209', '4', '0', '2', '2', '2', '24', '8', '2408', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1210', '4', '0', '2', '2', '1', '25', '1', '2501', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1211', '4', '0', '2', '2', '1', '25', '2', '2502', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1212', '4', '0', '2', '2', '1', '25', '3', '2503', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1213', '4', '0', '2', '2', '1', '25', '4', '2504', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1214', '4', '0', '2', '2', '2', '25', '5', '2505', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1215', '4', '0', '2', '2', '2', '25', '6', '2506', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1216', '4', '0', '2', '2', '2', '25', '7', '2507', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1217', '4', '0', '2', '2', '2', '25', '8', '2508', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1218', '4', '0', '2', '2', '1', '26', '1', '2601', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1219', '4', '0', '2', '2', '1', '26', '2', '2602', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1220', '4', '0', '2', '2', '1', '26', '3', '2603', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1221', '4', '0', '2', '2', '1', '26', '4', '2604', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1222', '4', '0', '2', '2', '2', '26', '5', '2605', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1223', '4', '0', '2', '2', '2', '26', '6', '2606', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1224', '4', '0', '2', '2', '2', '26', '7', '2607', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1225', '4', '0', '2', '2', '2', '26', '8', '2608', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1226', '4', '0', '2', '2', '1', '27', '1', '2701', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1227', '4', '0', '2', '2', '1', '27', '2', '2702', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1228', '4', '0', '2', '2', '1', '27', '3', '2703', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1229', '4', '0', '2', '2', '1', '27', '4', '2704', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1230', '4', '0', '2', '2', '2', '27', '5', '2705', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1231', '4', '0', '2', '2', '2', '27', '6', '2706', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1232', '4', '0', '2', '2', '2', '27', '7', '2707', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1233', '4', '0', '2', '2', '2', '27', '8', '2708', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1234', '4', '0', '2', '2', '1', '28', '1', '2801', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1235', '4', '0', '2', '2', '1', '28', '2', '2802', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1236', '4', '0', '2', '2', '1', '28', '3', '2803', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', '0', '', '1', '1521522128', '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1237', '4', '0', '2', '2', '1', '28', '4', '2804', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1238', '4', '0', '2', '2', '2', '28', '5', '2805', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1239', '4', '0', '2', '2', '2', '28', '6', '2806', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1240', '4', '0', '2', '2', '2', '28', '7', '2807', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1241', '4', '0', '2', '2', '2', '28', '8', '2808', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1242', '4', '0', '2', '2', '1', '29', '1', '2901', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1243', '4', '0', '2', '2', '1', '29', '2', '2902', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1244', '4', '0', '2', '2', '1', '29', '3', '2903', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1245', '4', '0', '2', '2', '1', '29', '4', '2904', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1246', '4', '0', '2', '2', '2', '29', '5', '2905', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1247', '4', '0', '2', '2', '2', '29', '6', '2906', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1248', '4', '0', '2', '2', '2', '29', '7', '2907', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', '0', '', '1', '1521522105', '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1249', '4', '0', '2', '2', '2', '29', '8', '2908', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1250', '4', '0', '2', '2', '1', '30', '1', '3001', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1251', '4', '0', '2', '2', '1', '30', '2', '3002', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', '0', '', '1', '1521522102', '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1252', '4', '0', '2', '2', '1', '30', '3', '3003', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '1', '1519873566', '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1253', '4', '0', '2', '2', '1', '30', '4', '3004', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1254', '4', '0', '2', '2', '2', '30', '5', '3005', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1255', '4', '0', '2', '2', '2', '30', '6', '3006', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1256', '4', '0', '2', '2', '2', '30', '7', '3007', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1257', '4', '0', '2', '2', '2', '30', '8', '3008', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1258', '4', '0', '2', '2', '1', '31', '1', '3101', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1259', '4', '0', '2', '2', '1', '31', '2', '3102', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1260', '4', '0', '2', '2', '1', '31', '3', '3103', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1261', '4', '0', '2', '2', '1', '31', '4', '3104', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1262', '4', '0', '2', '2', '2', '31', '5', '3105', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', '0', '', '1', '1521522077', '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1263', '4', '0', '2', '2', '2', '31', '6', '3106', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1264', '4', '0', '2', '2', '2', '31', '7', '3107', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1265', '4', '0', '2', '2', '2', '31', '8', '3108', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1266', '4', '0', '2', '2', '1', '32', '1', '3201', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', '0', '', '1', '1521522012', '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1267', '4', '0', '2', '2', '1', '32', '2', '3202', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1268', '4', '0', '2', '2', '1', '32', '3', '3203', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1269', '4', '0', '2', '2', '1', '32', '4', '3204', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '1520409968', '0', '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1270', '4', '0', '2', '2', '2', '32', '5', '3205', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1271', '4', '0', '2', '2', '2', '32', '6', '3206', 'Q3', '118.09', '96.20', '6900.00', '0.00', '814821.00', '0', '0', null, '', '0', null, '0', null, '0.00', '804821.00', '809821.00', '813821.00', '812821.00');
INSERT INTO `xk_room` VALUES ('1272', '4', '0', '2', '2', '2', '32', '7', '3207', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1273', '4', '0', '2', '2', '2', '32', '8', '3208', 'Q2', '132.29', '107.77', '6900.00', '0.00', '912801.00', '0', '0', null, '', '0', null, '0', null, '0.00', '902801.00', '907801.00', '911801.00', '910801.00');
INSERT INTO `xk_room` VALUES ('1274', '4', '0', '2', '2', '1', '33', '3', '3303', 'Q2', '132.37', '107.84', '6900.00', '0.00', '913353.00', '0', '0', '0', '', '1', '1521711162', '0', null, '0.00', '903353.00', '908353.00', '912353.00', '911353.00');
INSERT INTO `xk_room` VALUES ('1275', '4', '0', '2', '2', '1', '33', '4', '3304', 'Q2', '132.37', '107.84', '6900.00', '0.00', '913353.00', '1', '1521536586', '104', '姜001', '0', '1521536544', '0', null, '0.00', '903353.00', '908353.00', '912353.00', '911353.00');
INSERT INTO `xk_room` VALUES ('1276', '4', '0', '2', '2', '2', '33', '7', '3307', 'Q2', '132.37', '107.84', '6900.00', '0.00', '913353.00', '0', '0', null, '', '0', null, '0', null, '0.00', '903353.00', '908353.00', '912353.00', '911353.00');
INSERT INTO `xk_room` VALUES ('1277', '4', '0', '2', '2', '2', '33', '8', '3308', 'Q2', '132.37', '107.84', '6900.00', '0.00', '913353.00', '0', '0', null, '', '0', null, '0', null, '0.00', '903353.00', '908353.00', '912353.00', '911353.00');
INSERT INTO `xk_room` VALUES ('1309', '16', '0', '2', '2', '2', '1', '2', '102', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1299', '14', '0', '2', '2', '1', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1298', '14', '0', '2', '2', '1', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1282', '7', '0', '2', '2', '1', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1283', '7', '0', '2', '2', '1', '1', '2', '102 ', 'A2', '122.56', '102.58', '7800.00', '9319.24', '955968.00', '0', '0', null, '', '0', null, '0', null, '955968.00', '945968.00', '950968.00', '954968.00', '953968.00');
INSERT INTO `xk_room` VALUES ('1284', '8', '0', '2', '2', '1', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1285', '8', '0', '2', '2', '1', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1286', '8', '0', '2', '2', '2', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1287', '8', '0', '2', '2', '2', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1288', '9', '0', '2', '2', '1', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1289', '9', '0', '2', '2', '1', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1290', '9', '0', '2', '2', '1', '1', '3', '103', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1291', '9', '0', '2', '2', '1', '1', '1', '104', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1308', '16', '0', '2', '2', '2', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1296', '13', '0', '2', '2', '1', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '750000.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1297', '13', '0', '2', '2', '1', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1307', '16', '0', '2', '2', '1', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '1520415022', '0', '', '0', null, '0', null, '0.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1306', '16', '0', '2', '2', '1', '1', '1', '101', 'A2', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '1520415017', '0', '', '0', null, '0', null, '0.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1310', '17', '0', '3', '2', '1', '1', '1', '101', 'C1', '117.42', '0.00', '6200.00', '0.00', '728004.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1312', '17', '0', '3', '2', '1', '2', '1', '201', 'C1', '117.42', '0.00', '6220.00', '0.00', '730352.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1313', '17', '0', '3', '2', '1', '4', '1', '401', 'C1', '117.42', '0.00', '6293.00', '0.00', '738924.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1314', '17', '0', '3', '2', '1', '6', '4', '604', 'C1', '117.42', '0.00', '6292.00', '0.00', '738807.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1315', '17', '0', '3', '2', '1', '9', '2', '902', 'C2', '83.64', '0.00', '5919.00', '0.00', '495065.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1316', '17', '0', '3', '2', '1', '9', '3', '903', 'C2', '83.54', '0.00', '5918.00', '0.00', '494390.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1317', '17', '0', '3', '2', '1', '14', '1', '1401', 'C1', '117.42', '0.00', '6382.00', '0.00', '749374.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1318', '17', '0', '3', '2', '1', '20', '1', '2001', 'C1', '117.42', '0.00', '6436.00', '0.00', '755715.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1319', '17', '0', '3', '2', '1', '21', '3', '2103', 'C2', '83.54', '0.00', '6025.00', '0.00', '503329.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1320', '17', '0', '3', '2', '1', '24', '4', '2404', 'C1', '117.42', '0.00', '6400.00', '0.00', '751488.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1321', '17', '0', '3', '2', '1', '30', '4', '3004', 'C1', '117.42', '0.00', '6380.00', '0.00', '749140.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1322', '17', '0', '3', '2', '1', '31', '1', '3101', 'C1', '117.42', '0.00', '6400.00', '0.00', '751488.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1323', '17', '0', '3', '2', '1', '31', '2', '3102', 'C2', '83.64', '0.00', '6025.00', '0.00', '503931.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1324', '17', '0', '3', '2', '1', '31', '4', '3104', 'C1', '117.42', '0.00', '6360.00', '0.00', '746791.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1325', '18', '0', '3', '2', '1', '1', '2', '102', 'C1', '119.34', '0.00', '5800.00', '0.00', '692172.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1326', '18', '0', '3', '2', '1', '2', '1', '201', 'C2', '84.77', '0.00', '6245.00', '0.00', '529389.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1327', '18', '0', '3', '2', '1', '3', '4', '304', 'C1', '119.45', '0.00', '6300.00', '0.00', '752535.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1328', '18', '0', '3', '2', '1', '4', '1', '401', 'C1', '119.45', '0.00', '6300.00', '0.00', '752535.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1329', '18', '0', '3', '2', '1', '4', '4', '404', 'C1', '119.45', '0.00', '6320.00', '0.00', '754924.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1330', '18', '0', '3', '2', '1', '11', '4', '1104', 'C1', '119.45', '0.00', '6416.00', '0.00', '766391.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1331', '18', '0', '3', '2', '1', '14', '1', '1401', 'C1', '119.45', '0.00', '6380.00', '0.00', '762091.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1332', '18', '0', '3', '2', '1', '14', '4', '1404', 'C1', '119.45', '0.00', '6320.00', '0.00', '754924.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1333', '18', '0', '3', '2', '1', '18', '4', '1804', 'C1', '119.45', '0.00', '6420.00', '0.00', '766869.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1334', '18', '0', '3', '2', '1', '20', '3', '2003', 'C2', '84.96', '0.00', '6069.00', '0.00', '515622.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1335', '18', '0', '3', '2', '1', '24', '1', '2401', 'C1', '119.45', '0.00', '6500.00', '0.00', '776425.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1336', '18', '0', '3', '2', '1', '24', '3', '2403', 'C2', '84.96', '0.00', '6105.00', '0.00', '518681.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1337', '18', '0', '3', '2', '1', '27', '1', '2701', 'C1', '119.45', '0.00', '6520.00', '0.00', '778814.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1338', '18', '0', '3', '2', '1', '27', '4', '2704', 'C1', '119.45', '0.00', '6500.00', '0.00', '776425.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1339', '18', '0', '3', '2', '1', '28', '1', '2801', 'C1', '119.45', '0.00', '6552.00', '0.00', '782636.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1340', '18', '0', '3', '2', '1', '29', '1', '2901', 'C1', '119.45', '0.00', '6460.00', '0.00', '771647.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1341', '18', '0', '3', '2', '1', '29', '4', '2904', 'C1', '119.45', '0.00', '6500.00', '0.00', '776425.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1342', '18', '0', '3', '2', '1', '30', '1', '3001', 'C1', '119.45', '0.00', '6470.00', '0.00', '772842.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1343', '18', '0', '3', '2', '1', '30', '4', '3004', 'C1', '119.45', '0.00', '6488.00', '0.00', '774992.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1344', '18', '0', '3', '2', '1', '31', '1', '3101', 'C1', '119.45', '0.00', '6460.00', '0.00', '771647.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1345', '18', '0', '3', '2', '1', '31', '4', '3104', 'C1', '119.45', '0.00', '6470.00', '0.00', '772842.00', '0', null, '0', null, '0', null, '0', null, '0.00', null, null, null, null);
INSERT INTO `xk_room` VALUES ('1346', '19', '0', '2', '2', '1', '1', '1', '101 ', 'A1', '90.00', '80.00', '8000.00', '10500.00', '810000.00', '0', '0', null, '', '0', null, '0', null, '800000.00', '800000.00', '805000.00', '809000.00', '808000.00');
INSERT INTO `xk_room` VALUES ('1347', '19', '0', '2', '2', '1', '1', '2', '102 ', 'A1', '90.00', '80.00', '8100.00', '11500.00', '910000.00', '0', '0', null, '', '0', null, '0', null, '900000.00', '900000.00', '905000.00', '909000.00', '908000.00');
INSERT INTO `xk_room` VALUES ('1348', '19', '0', '2', '2', '1', '1', '3', '103', null, '90.00', '80.00', '8200.00', '12500.00', '1010000.00', '0', '0', null, '', '0', null, '0', null, '1000000.00', '1000000.00', '1005000.00', '1009000.00', '1008000.00');
INSERT INTO `xk_room` VALUES ('1349', '19', '0', '2', '2', '1', '1', '4', '104', null, '90.00', '80.00', '8300.00', '13500.00', '1110000.00', '0', '0', null, '', '0', null, '0', null, '1100000.00', '1100000.00', '1105000.00', '1109000.00', '1108000.00');
INSERT INTO `xk_room` VALUES ('1350', '19', '0', '2', '2', '1', '2', '1', '201 ', 'A1', '90.00', '80.00', '8400.00', '14500.00', '1210000.00', '0', '0', null, '', '0', null, '0', null, '1200000.00', '1200000.00', '1205000.00', '1209000.00', '1208000.00');
INSERT INTO `xk_room` VALUES ('1351', '19', '0', '2', '2', '1', '2', '2', '202 ', 'A1', '90.00', '80.00', '8500.00', '15500.00', '1310000.00', '0', '0', null, '', '0', null, '0', null, '1300000.00', '1300000.00', '1305000.00', '1309000.00', '1308000.00');
INSERT INTO `xk_room` VALUES ('1352', '19', '0', '2', '2', '1', '2', '3', '203', null, '90.00', '80.00', '8600.00', '16500.00', '1410000.00', '0', '0', null, '', '0', null, '0', null, '1400000.00', '1400000.00', '1405000.00', '1409000.00', '1408000.00');
INSERT INTO `xk_room` VALUES ('1353', '19', '0', '2', '2', '1', '2', '4', '204', null, '90.00', '80.00', '8700.00', '17500.00', '1510000.00', '0', '0', null, '', '0', null, '0', null, '1500000.00', '1500000.00', '1505000.00', '1509000.00', '1508000.00');
INSERT INTO `xk_room` VALUES ('1354', '19', '0', '2', '2', '1', '3', '1', '301 ', 'A1', '90.00', '80.00', '8800.00', '18500.00', '1610000.00', '0', '0', null, '', '0', null, '0', null, '1600000.00', '1600000.00', '1605000.00', '1609000.00', '1608000.00');
INSERT INTO `xk_room` VALUES ('1355', '19', '0', '2', '2', '1', '3', '2', '302 ', 'A1', '90.00', '80.00', '8900.00', '19500.00', '1710000.00', '0', '0', null, '', '0', null, '0', null, '1700000.00', '1700000.00', '1705000.00', '1709000.00', '1708000.00');
INSERT INTO `xk_room` VALUES ('1356', '19', '0', '2', '2', '1', '3', '3', '303', null, '90.00', '80.00', '9000.00', '20500.00', '1810000.00', '0', '0', null, '', '0', null, '0', null, '1800000.00', '1800000.00', '1805000.00', '1809000.00', '1808000.00');
INSERT INTO `xk_room` VALUES ('1357', '19', '0', '2', '2', '1', '3', '4', '304', null, '90.00', '80.00', '9100.00', '21500.00', '1910000.00', '0', '0', null, '', '0', null, '0', null, '1900000.00', '1900000.00', '1905000.00', '1909000.00', '1908000.00');
INSERT INTO `xk_room` VALUES ('1358', '19', '0', '2', '2', '1', '5', '1', '501 ', 'A1', '90.00', '80.00', '9200.00', '22500.00', '2010000.00', '0', '0', null, '', '0', null, '0', null, '2000000.00', '2000000.00', '2005000.00', '2009000.00', '2008000.00');
INSERT INTO `xk_room` VALUES ('1359', '19', '0', '2', '2', '1', '5', '2', '502 ', 'A1', '90.00', '80.00', '9300.00', '23500.00', '2110000.00', '0', '0', null, '', '0', null, '0', null, '2100000.00', '2100000.00', '2105000.00', '2109000.00', '2108000.00');
INSERT INTO `xk_room` VALUES ('1360', '19', '0', '2', '2', '1', '5', '3', '503', null, '90.00', '80.00', '9400.00', '24500.00', '2210000.00', '0', '0', null, '', '0', null, '0', null, '2200000.00', '2200000.00', '2205000.00', '2209000.00', '2208000.00');
INSERT INTO `xk_room` VALUES ('1361', '20', '0', '2', '2', '1', '1', '1', '101 ', 'A2', '100.00', '0.00', '10000.00', '0.00', '980000.00', '0', null, '0', null, '0', null, '0', null, '980000.00', '970000.00', '975000.00', '979000.00', '978000.00');

-- ----------------------------
-- Table structure for `xk_roomattribute`
-- ----------------------------
DROP TABLE IF EXISTS `xk_roomattribute`;
CREATE TABLE `xk_roomattribute` (
  `room_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '房间id',
  `djcount` bigint(20) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `sccount` bigint(20) NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `sscount` bigint(20) NOT NULL DEFAULT '0' COMMENT '试算次数',
  `mock_djcount` bigint(20) DEFAULT '0' COMMENT '点击次数 - 自定义数据',
  `mock_sccount` bigint(20) DEFAULT '0' COMMENT '收藏次数 - 自定义数据',
  `mock_sscount` bigint(20) DEFAULT '0' COMMENT '试算次数 - 自定义数据',
  PRIMARY KEY (`room_id`),
  KEY `djcount` (`djcount`) USING BTREE,
  KEY `sccount` (`sccount`) USING BTREE,
  KEY `sscount` (`sscount`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='房间属性表';

-- ----------------------------
-- Records of xk_roomattribute
-- ----------------------------
INSERT INTO `xk_roomattribute` VALUES ('1268', '26', '4', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1274', '49', '1', '9', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1269', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1252', '90', '1', '2', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1235', '18', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1228', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1226', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1227', '4', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1221', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1260', '51', '0', '4', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1259', '4', '1', '5', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1251', '2', '1', '2', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1236', '8', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1245', '0', '0', '2', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1242', '6', '2', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1275', '102', '5', '9', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1021', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1020', '0', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1258', '10', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1014', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1019', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1015', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('240', '4', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1067', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1099', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1261', '0', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1250', '1', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1267', '60', '0', '3', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1098', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1243', '9', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1234', '4', '3', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1253', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1244', '25', '1', '3', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1265', '0', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1266', '17', '1', '2', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1276', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1219', '18', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1212', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1296', '47', '3', '9', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1297', '91', '2', '9', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1277', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1247', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1284', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1282', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1288', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('167', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1255', '6', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1256', '6', '2', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1285', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1287', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1263', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1232', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1272', '6', '2', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1264', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1238', '0', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1231', '0', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1271', '1', '0', '2', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1248', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1239', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1224', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1220', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1230', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1299', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1273', '13', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1240', '6', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1031', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1176', '4', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1192', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1201', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1033', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('127', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1290', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1289', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1283', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1241', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1257', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1153', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1184', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1200', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1136', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1222', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1309', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1179', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1307', '10', '0', '20', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1291', '0', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1164', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1160', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1064', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1044', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1213', '4', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1270', '18', '0', '2', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1306', '34', '0', '20', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1107', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('24', '4', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1108', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1052', '1', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1047', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('360', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1168', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1144', '1', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1111', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1237', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1188', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1167', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1166', '2', '1', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1254', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1029', '2', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1028', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1211', '8', '0', '0', '0', '0', '0');
INSERT INTO `xk_roomattribute` VALUES ('1116', '2', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `xk_roomczlog`
-- ----------------------------
DROP TABLE IF EXISTS `xk_roomczlog`;
CREATE TABLE `xk_roomczlog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(20) NOT NULL DEFAULT '0' COMMENT '房间id',
  `cztype` varchar(20) NOT NULL DEFAULT '取消选房' COMMENT '操作类型',
  `cztime` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `czuser` int(20) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `czusername` varchar(20) DEFAULT NULL COMMENT '操作人名称',
  `cstid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_roomczlog
-- ----------------------------
INSERT INTO `xk_roomczlog` VALUES ('60', '1270', '选房', '1519874204', '1', '超级管理员', '108');
INSERT INTO `xk_roomczlog` VALUES ('61', '1168', '选房', '1519874247', '1', '超级管理员', '103');
INSERT INTO `xk_roomczlog` VALUES ('62', '1297', '销控', '1519958806', '8', '置业顾问1', '0');
INSERT INTO `xk_roomczlog` VALUES ('63', '1297', '取消销控', '1519958828', '8', '置业顾问1', '0');
INSERT INTO `xk_roomczlog` VALUES ('64', '1259', '销控', '1519959273', '8', '置业顾问1', '0');
INSERT INTO `xk_roomczlog` VALUES ('65', '1217', '选房', '1519976804', '1', '超级管理员', '109');
INSERT INTO `xk_roomczlog` VALUES ('66', '1262', '选房', '1520216910', '1', '超级管理员', '104');
INSERT INTO `xk_roomczlog` VALUES ('67', '1274', '销控', '1520217172', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('68', '1248', '选房', '1520243222', '1', '超级管理员', '103');
INSERT INTO `xk_roomczlog` VALUES ('69', '1269', '销控', '1520409968', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('70', '1269', '取消销控', '1520409971', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('71', '1306', '销控', '1520415017', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('72', '1307', '销控', '1520415022', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('73', '1306', '取消销控', '1520415084', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('74', '1307', '取消销控', '1520415090', '4', '云景府管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('75', '1266', '取消选房', '1521522012', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('76', '1262', '取消选房', '1521522077', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('77', '1275', '取消选房', '1521522088', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('78', '1251', '取消选房', '1521522102', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('79', '1248', '取消选房', '1521522105', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('80', '1274', '取消选房', '1521522125', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('81', '1236', '取消选房', '1521522128', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('82', '1274', '选房', '1521522189', '1', '超级管理员', '104');
INSERT INTO `xk_roomczlog` VALUES ('83', '1275', '选房', '1521525868', '1', '超级管理员', '108');
INSERT INTO `xk_roomczlog` VALUES ('84', '1275', '取消选房', '1521526118', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('85', '1274', '取消选房', '1521530951', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('86', '1274', '选房', '1521530971', '1', '超级管理员', '104');
INSERT INTO `xk_roomczlog` VALUES ('87', '1274', '取消选房', '1521531483', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('88', '1274', '选房', '1521531602', '1', '超级管理员', '104');
INSERT INTO `xk_roomczlog` VALUES ('89', '1274', '取消选房', '1521531654', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('90', '1274', '选房', '1521532510', '1', '超级管理员', '104');
INSERT INTO `xk_roomczlog` VALUES ('91', '1275', '选房', '1521533038', '1', '超级管理员', '103');
INSERT INTO `xk_roomczlog` VALUES ('92', '1275', '取消选房', '1521533044', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('93', '1275', '选房', '1521533049', '1', '超级管理员', '103');
INSERT INTO `xk_roomczlog` VALUES ('94', '1275', '取消选房', '1521536544', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('95', '1274', '取消选房', '1521536548', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('96', '1274', '选房', '1521536577', '1', '超级管理员', '103');
INSERT INTO `xk_roomczlog` VALUES ('97', '1275', '选房', '1521536586', '1', '超级管理员', '104');
INSERT INTO `xk_roomczlog` VALUES ('98', '1175', '选房', '1521705294', '1', '超级管理员', '108');
INSERT INTO `xk_roomczlog` VALUES ('99', '1175', '取消选房', '1521711132', '1', '超级管理员', '0');
INSERT INTO `xk_roomczlog` VALUES ('100', '1274', '取消选房', '1521711163', '1', '超级管理员', '0');

-- ----------------------------
-- Table structure for `xk_roomtemp`
-- ----------------------------
DROP TABLE IF EXISTS `xk_roomtemp`;
CREATE TABLE `xk_roomtemp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` int(10) DEFAULT NULL,
  `pc_id` int(10) DEFAULT NULL,
  `bld_id` int(10) DEFAULT NULL,
  `cp_id` int(10) DEFAULT NULL,
  `buildname` varchar(20) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `no` varchar(10) DEFAULT NULL,
  `room` varchar(10) DEFAULT NULL,
  `hx` varchar(20) DEFAULT NULL,
  `area` decimal(10,2) DEFAULT NULL,
  `tnarea` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tnprice` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `isadd` tinyint(1) NOT NULL DEFAULT '1',
  `room_id` int(20) DEFAULT '0',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠后价格',
  `ycx_price` decimal(10,2) DEFAULT '0.00',
  `fq_price` decimal(10,2) DEFAULT '0.00',
  `gjj_price` decimal(10,2) DEFAULT '0.00',
  `aj_price` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_roomtemp
-- ----------------------------
INSERT INTO `xk_roomtemp` VALUES ('1', '2', '2', '20', '2', '33栋', '1', '1', '1', '101 ', 'A2', '100.00', '0.00', '10000.00', '0.00', '980000.00', '0', '1361', '980000.00', '0.00', '0.00', '0.00', '0.00');

-- ----------------------------
-- Table structure for `xk_room_pmtzb`
-- ----------------------------
DROP TABLE IF EXISTS `xk_room_pmtzb`;
CREATE TABLE `xk_room_pmtzb` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(20) NOT NULL,
  `leftpx` int(5) DEFAULT NULL,
  `toppx` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_room_pmtzb
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_ssroom`
-- ----------------------------
DROP TABLE IF EXISTS `xk_ssroom`;
CREATE TABLE `xk_ssroom` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cst_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `room_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '房间id',
  `sstime` int(10) DEFAULT '0' COMMENT '试算时间',
  `gftotal` decimal(10,2) DEFAULT NULL COMMENT '购房总价',
  `payfrom` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '付款方式',
  `dktotal` decimal(10,2) DEFAULT NULL COMMENT '贷款金额',
  `fqs` int(11) DEFAULT NULL COMMENT '分期期数',
  `dklv` decimal(6,3) DEFAULT NULL COMMENT '贷款利率',
  `hkfs` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '还款方式',
  `myhkje` decimal(10,2) DEFAULT NULL COMMENT '每月还款金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='客户试算房间表';

-- ----------------------------
-- Records of xk_ssroom
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_station`
-- ----------------------------
DROP TABLE IF EXISTS `xk_station`;
CREATE TABLE `xk_station` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `cp_id` int(20) NOT NULL COMMENT '公司id',
  `proj_id` int(20) DEFAULT NULL COMMENT '项目id',
  `name` varchar(30) CHARACTER SET gb2312 NOT NULL COMMENT '岗位名称',
  `code` varchar(10) CHARACTER SET gb2312 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_station
-- ----------------------------
INSERT INTO `xk_station` VALUES ('1', '1', '0', '公司管理员', 'ty-gly');
INSERT INTO `xk_station` VALUES ('2', '1', '1', '销售管理', 'ty-skgl');
INSERT INTO `xk_station` VALUES ('3', '1', '1', '置业顾问', 'ty-xk');
INSERT INTO `xk_station` VALUES ('4', '2', '0', '公司管理员', 'hldc_gly');
INSERT INTO `xk_station` VALUES ('5', '2', '2', '销售管理', 'hldc_xsgl');
INSERT INTO `xk_station` VALUES ('6', '2', '2', '置业顾问', 'hldc_zygw');
INSERT INTO `xk_station` VALUES ('7', '2', '3', '销售管理1', '');
INSERT INTO `xk_station` VALUES ('8', '2', '3', '置业顾问1', '');
INSERT INTO `xk_station` VALUES ('14', '2', '4', '销售管理', null);
INSERT INTO `xk_station` VALUES ('15', '2', '4', '置业顾问', null);
INSERT INTO `xk_station` VALUES ('16', '2', '4', 'LED 展示', null);

-- ----------------------------
-- Table structure for `xk_station2pc`
-- ----------------------------
DROP TABLE IF EXISTS `xk_station2pc`;
CREATE TABLE `xk_station2pc` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(20) NOT NULL COMMENT '岗位id',
  `pc_id` int(20) NOT NULL COMMENT '批次id',
  `proj_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_station2pc
-- ----------------------------
INSERT INTO `xk_station2pc` VALUES ('2', '2', '1', '1');
INSERT INTO `xk_station2pc` VALUES ('10', '4', '2', '2');
INSERT INTO `xk_station2pc` VALUES ('27', '5', '2', '2');
INSERT INTO `xk_station2pc` VALUES ('6', '6', '2', '2');
INSERT INTO `xk_station2pc` VALUES ('19', '4', '4', '2');
INSERT INTO `xk_station2pc` VALUES ('20', '6', '4', '2');

-- ----------------------------
-- Table structure for `xk_station2proj`
-- ----------------------------
DROP TABLE IF EXISTS `xk_station2proj`;
CREATE TABLE `xk_station2proj` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` int(20) NOT NULL,
  `station_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_station2proj
-- ----------------------------
INSERT INTO `xk_station2proj` VALUES ('2', '1', '2');
INSERT INTO `xk_station2proj` VALUES ('10', '2', '4');
INSERT INTO `xk_station2proj` VALUES ('18', '2', '5');
INSERT INTO `xk_station2proj` VALUES ('6', '2', '6');

-- ----------------------------
-- Table structure for `xk_station2user`
-- ----------------------------
DROP TABLE IF EXISTS `xk_station2user`;
CREATE TABLE `xk_station2user` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(20) NOT NULL COMMENT '岗位id',
  `userid` int(20) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_station2user
-- ----------------------------
INSERT INTO `xk_station2user` VALUES ('10', '5', '17');
INSERT INTO `xk_station2user` VALUES ('2', '2', '2');
INSERT INTO `xk_station2user` VALUES ('3', '3', '3');
INSERT INTO `xk_station2user` VALUES ('4', '4', '4');
INSERT INTO `xk_station2user` VALUES ('5', '5', '5');
INSERT INTO `xk_station2user` VALUES ('6', '6', '6');
INSERT INTO `xk_station2user` VALUES ('15', '1', '2');
INSERT INTO `xk_station2user` VALUES ('16', '6', '8');
INSERT INTO `xk_station2user` VALUES ('17', '4', '18');
INSERT INTO `xk_station2user` VALUES ('18', '6', '19');

-- ----------------------------
-- Table structure for `xk_trade`
-- ----------------------------
DROP TABLE IF EXISTS `xk_trade`;
CREATE TABLE `xk_trade` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '业务id，微信认购、快速选房',
  `yw_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `cst_id` int(11) DEFAULT NULL COMMENT '客户id',
  `source` varchar(10) DEFAULT NULL COMMENT '来源:微信认购、快速选房',
  `status` varchar(10) DEFAULT NULL COMMENT '状态：选房、认购、签约',
  `isyx` tinyint(1) DEFAULT '1' COMMENT '1有效，0无效',
  `tradetime` int(11) DEFAULT NULL,
  `cjtotal` decimal(10,2) DEFAULT '0.00' COMMENT '交易金额',
  `code` varchar(20) DEFAULT NULL COMMENT '微信认购码',
  `ywy` varchar(10) DEFAULT NULL COMMENT '置业顾问',
  `createdbyid` int(11) DEFAULT NULL COMMENT '创建人id',
  `createdby` varchar(10) DEFAULT NULL COMMENT '创建人',
  `old_id` int(11) DEFAULT NULL,
  `pay` varchar(10) NOT NULL COMMENT '付款方式',
  `proportion` decimal(10,2) DEFAULT '0.00' COMMENT '比例',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_trade
-- ----------------------------
INSERT INTO `xk_trade` VALUES ('133', '1275', '1275', '104', '快速选房', '认购', '1', '1521536586', '911353.00', null, '', '1', '超级管理员', null, '按揭', '0.00', '0.00');

-- ----------------------------
-- Table structure for `xk_update_choose_log`
-- ----------------------------
DROP TABLE IF EXISTS `xk_update_choose_log`;
CREATE TABLE `xk_update_choose_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `choose_id` int(11) NOT NULL COMMENT '用户id',
  `choose_phone` varchar(50) NOT NULL,
  `choose_card` varchar(50) NOT NULL,
  `choose_cyjno` varchar(50) NOT NULL,
  `new_phone` varchar(50) NOT NULL,
  `new_card` varchar(50) NOT NULL,
  `new_cyjno` varchar(50) NOT NULL,
  `update_user` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `update_ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_update_choose_log
-- ----------------------------
INSERT INTO `xk_update_choose_log` VALUES ('49', '104', '13693425865', '510403198', '', '13693425865', '51040319821204031X', '1111', '1', '1518417717', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('48', '104', '13693425866', '510403198', '', '13693425865', '510403198', '1111', '1', '1518341328', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('47', '104', '13693425865', '510403198', '', '13693425866', '510403198', '1111', '1', '1518341184', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('46', '104', '13693425864', '510403198', '', '13693425865', '510403198', '1111', '1', '1518341149', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('45', '104', '13693425865', '510403198', '', '13693425864', '510403198', '1111', '1', '1518341082', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('50', '103', '18782088086', '511111111111111111', '', '18782088086', '511111111111111111', 'VIP01', '1', '1519612246', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('51', '103', '18782088086', '511111111111111111', '', '18782088086', '511111111111111111', 'VIP01', '1', '1520243272', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('52', '108', '13693425866', '51040319821204031X', '', '13693425866', '51040319821204031X', 'VIP004', '1', '1520409054', '192.168.2.103');
INSERT INTO `xk_update_choose_log` VALUES ('53', '104', '13693425865', '51040319821204031X', '', '13693425865', '', '1213', '1', '1520409192', '192.168.2.103');
INSERT INTO `xk_update_choose_log` VALUES ('54', '108', '13693425866', '51040319821204031X', '', '13693425866', '51040319821204031X', 'VIP004', '1', '1520410036', '192.168.2.103');
INSERT INTO `xk_update_choose_log` VALUES ('55', '108', '13693425866', '51040319821204031X', '', '13693425866', '51040319821204031X', 'VIP004', '1', '1520410050', '192.168.2.103');
INSERT INTO `xk_update_choose_log` VALUES ('56', '103', '18782088086', '511111111111111111', '', '18782088086', '511111111111111111', 'VIP01', '1', '1520411924', '192.168.2.103');
INSERT INTO `xk_update_choose_log` VALUES ('57', '117', '18782088085', '123456198808085678', '', '18782088088', '123456198808085678', 'VIP8085', '1', '1520412326', '192.168.2.103');
INSERT INTO `xk_update_choose_log` VALUES ('58', '104', '13693425865', '', '', '13693425865', '51040319821204031X', '1213', '1', '1520475134', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('59', '104', '13693425865', '51040319821204031X', '', '13693425865', '', '1213', '1', '1520475145', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('60', '108', '13693425866', '51040319821204031X', '', '13693425888', '51040319821204031X', '66004', '1', '1520835410', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('61', '108', '13693425888', '51040319821204031X', '', '18583229632', '51040319821204031X', '66004', '1', '1521021577', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('62', '103', '18782088086', '511111111111111111', '', '18782088086', '510403XXXXXXXX0701', 'VIP001', '1', '1521422438', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('63', '111', '12345678902', '18777777', '', '12345678902', '51010XXXXXXXX0302', 'VIP002', '1', '1521422469', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('64', '103', '18782088086', '510403XXXXXXXX0701', '', '18782088086', '510403XXXXXXXX0701', '001', '1', '1521453483', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('65', '104', '13693425865', '', '', '13693425865', '', '002', '1', '1521453496', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('66', '108', '18583229632', '51040319821204031X', '', '18583229632', '51040319821204031X', '003', '1', '1521453504', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('67', '110', '12345678901', '1999999', '', '12345678901', '1999999', '004', '1', '1521453510', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('68', '111', '12345678902', '51010XXXXXXXX0302', '', '12345678902', '51010XXXXXXXX0302', '005', '1', '1521453515', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('69', '117', '18782088088', '123456198808085678', '', '18782088088', '123456198808085678', '006', '1', '1521453522', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('70', '117', '18782088088', '123456198808085678', '', '18782088088', '123456198808085678', '007', '1', '1521453554', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('71', '115', '12345678900', '12345619880808', '', '12345678900', '12345619880808', '006', '1', '1521453561', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('72', '118', '13693425868', '123456198808089892', '', '13693425868', '123456198808089892', '008', '1', '1521453587', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('73', '120', '13693425999', '67676', '', '13693425999', '67676', '009', '1', '1521453598', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('74', '116', '18812348882', '1234561988080856', '', '18812348882', '1234561988080856', '010', '1', '1521453613', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('75', '104', '13693425865', '', '', '13693425865', '510303199507090321', '002', '1', '1521509770', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('76', '110', '12345678901', '1999999', '', '12345678901', '31050119308060751', '004', '1', '1521509818', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('77', '110', '12345678901', '31050119308060751', '', '12345678901', '310501199308060751', '004', '1', '1521509858', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('78', '120', '13693425999', '67676', '', '13693425999', '1234561988080856', '009', '1', '1521517983', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('79', '108', '18583229632', '51040319821204031X', '', '18583229632', '51040319821204031X;510303199507090321', '003', '1', '1521540502', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('80', '108', '18583229632', '51040319821204031X;510303199507090321', '', '18583229632', '51040319821204031X;510303199507090322', '003', '17', '1521625693', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('81', '103', '18782088086', '510403XXXXXXXX0701', '', '18782088086', '510303199507090321', '001', '17', '1521625911', '127.0.0.1');
INSERT INTO `xk_update_choose_log` VALUES ('82', '103', '18782088086', '510303199507090321', '', '18782088086', '510303199507090322', '001', '1', '1521688831', '192.168.2.88');

-- ----------------------------
-- Table structure for `xk_user`
-- ----------------------------
DROP TABLE IF EXISTS `xk_user`;
CREATE TABLE `xk_user` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(11) CHARACTER SET utf8 NOT NULL COMMENT '用户代码',
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户名称',
  `mobile` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `cp_id` int(20) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0置业顾问  1微信认购  2案场销控  3领导(可以查看报表)  4管理员   5超级管理员；后面的权限包含前面的权限',
  `status` tinyint(1) DEFAULT '0' COMMENT '0启用/1禁用',
  `is_wx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '微信认购权限',
  `is_all` tinyint(1) DEFAULT '0' COMMENT '1超级管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='用户(职业顾问)表';

-- ----------------------------
-- Records of xk_user
-- ----------------------------
INSERT INTO `xk_user` VALUES ('1', 'admin', '超级管理员', '999999999', '14e1b600b1fd579f47433b88e8d85291', '0', '5', '0', '0', '1');
INSERT INTO `xk_user` VALUES ('2', 'xsjl', '销售管理', '12111111111', '14e1b600b1fd579f47433b88e8d85291', '1', '0', '0', '0', '0');
INSERT INTO `xk_user` VALUES ('4', 'yjfgly', '云景府管理员', '18788887879', '14e1b600b1fd579f47433b88e8d85291', '2', '0', '0', '0', '0');
INSERT INTO `xk_user` VALUES ('6', 'yjfled', 'LED展示', '19999999999', 'fe3cfcddc51e5a488b41c56fbf57fd14', '2', '0', '0', '1', '0');
INSERT INTO `xk_user` VALUES ('8', 'yjfywy01', '置业顾问1', '18111111111', '14e1b600b1fd579f47433b88e8d85291', '2', '0', '0', '0', '0');
INSERT INTO `xk_user` VALUES ('17', 'yjfxsjl', '销售经理', '12345678901', '14e1b600b1fd579f47433b88e8d85291', '2', '0', '0', '0', '0');
INSERT INTO `xk_user` VALUES ('20', 'yyy', 'yyy', 'yyy', 'd9b1d7db4cd6e70935368a1efb10e377', '2', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `xk_user2prize`
-- ----------------------------
DROP TABLE IF EXISTS `xk_user2prize`;
CREATE TABLE `xk_user2prize` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(20) NOT NULL COMMENT '用户id',
  `prize_id` int(20) NOT NULL COMMENT '奖品id',
  `proj_id` int(20) NOT NULL COMMENT '项目id',
  `pc_id` int(20) DEFAULT '0' COMMENT '批次id',
  `zjtime` int(11) NOT NULL DEFAULT '0' COMMENT '中奖时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_user2prize
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_voucher`
-- ----------------------------
DROP TABLE IF EXISTS `xk_voucher`;
CREATE TABLE `xk_voucher` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '名称',
  `description` text COLLATE utf8_unicode_ci COMMENT '描述',
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `batch_id` bigint(20) DEFAULT '0' COMMENT '批次号',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类型（满减[gift]、通用[common]、定向[directional]）',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '总数量',
  `open_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '已启用总数量',
  `use_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '已使用数量',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `min_money` decimal(10,2) DEFAULT NULL COMMENT '满减条件(比如大于50万)-类型为满减时,可选择',
  `directional_type` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '定向类型（户型[house_type]、房间[room_id]）',
  `house_type` varchar(25) CHARACTER SET utf8 DEFAULT '' COMMENT '户型-类型为定向时',
  `room_id` bigint(20) DEFAULT NULL COMMENT '指定房间-类型为定向时',
  `remark` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-关闭',
  `add_user_id` bigint(20) DEFAULT '0' COMMENT '添加用户',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='代金券设置';

-- ----------------------------
-- Records of xk_voucher
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_voucher_activity`
-- ----------------------------
DROP TABLE IF EXISTS `xk_voucher_activity`;
CREATE TABLE `xk_voucher_activity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '活动名称',
  `description` text COLLATE utf8_unicode_ci COMMENT '描述',
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `batch_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '批次号',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `attr_count` int(11) DEFAULT '0' COMMENT '选用代金券个数',
  `remark` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-关闭',
  `add_user_id` bigint(20) DEFAULT '0' COMMENT '添加的用户',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  `cyfs` int(1) DEFAULT '0' COMMENT '参与方式：0抢，1领，2随机',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='代金券活动设置';

-- ----------------------------
-- Records of xk_voucher_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_voucher_activity_attr`
-- ----------------------------
DROP TABLE IF EXISTS `xk_voucher_activity_attr`;
CREATE TABLE `xk_voucher_activity_attr` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `voucher_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '代金券ID',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `use_quantity` int(10) DEFAULT '0' COMMENT '已用数量',
  `add_user_id` bigint(20) DEFAULT '0' COMMENT '添加的用户',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='代金券活动设置 - 代金券选择';

-- ----------------------------
-- Records of xk_voucher_activity_attr
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_voucher_log`
-- ----------------------------
DROP TABLE IF EXISTS `xk_voucher_log`;
CREATE TABLE `xk_voucher_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) DEFAULT '0' COMMENT '用户ID',
  `voucher_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '代金券ID',
  `activity_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `batch_id` bigint(20) DEFAULT '0' COMMENT '批次号',
  `is_use` tinyint(1) DEFAULT '0' COMMENT '1-使用',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-有效',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='代金券消费记录';

-- ----------------------------
-- Records of xk_voucher_log
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_voucher_tip`
-- ----------------------------
DROP TABLE IF EXISTS `xk_voucher_tip`;
CREATE TABLE `xk_voucher_tip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `batch_id` bigint(20) DEFAULT '0' COMMENT '批次号',
  `activity_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `customer_id` bigint(20) DEFAULT '0' COMMENT '用户ID',
  `is_tip` tinyint(1) DEFAULT '0' COMMENT '1-已经提示',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0.0.0.0' COMMENT '添加IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提醒表';

-- ----------------------------
-- Records of xk_voucher_tip
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_wxrglog`
-- ----------------------------
DROP TABLE IF EXISTS `xk_wxrglog`;
CREATE TABLE `xk_wxrglog` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `hd_id` int(20) DEFAULT NULL COMMENT '微信认购活动id',
  `room_id` int(20) NOT NULL,
  `cst_id` int(20) NOT NULL COMMENT '类型',
  `cst_name` varchar(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `cztime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态  1激活，0作废',
  `sjm` varchar(10) DEFAULT NULL COMMENT '随机码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of xk_wxrglog
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_xsledset`
-- ----------------------------
DROP TABLE IF EXISTS `xk_xsledset`;
CREATE TABLE `xk_xsledset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) NOT NULL DEFAULT '0',
  `batch_id` int(10) NOT NULL DEFAULT '0',
  `bldidlist` varchar(100) NOT NULL DEFAULT '0',
  `bldnamelist` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_xsledset
-- ----------------------------
INSERT INTO `xk_xsledset` VALUES ('15', '1', '1', '2', 'SOHO');
INSERT INTO `xk_xsledset` VALUES ('14', '1', '1', '1', 'LOFT');

-- ----------------------------
-- Table structure for `xk_yaohresult`
-- ----------------------------
DROP TABLE IF EXISTS `xk_yaohresult`;
CREATE TABLE `xk_yaohresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cstid` int(11) NOT NULL,
  `group` int(4) NOT NULL COMMENT '分组(批次)',
  `no` int(5) NOT NULL COMMENT '编号',
  `pxingroup` int(3) DEFAULT NULL COMMENT '组内排序号',
  `yaohset_id` int(11) NOT NULL COMMENT '摇号设置ID',
  `project_id` int(11) NOT NULL COMMENT '项目ID',
  `batch_id` int(11) NOT NULL COMMENT '项目批次ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0未入场、1已入场',
  `is_yx` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效；1正常 0作废',
  `createdtime` int(11) NOT NULL COMMENT '创建时间',
  `createdby` varchar(30) NOT NULL COMMENT '创建人',
  `createdbyid` int(11) NOT NULL COMMENT '创建人ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_yaohresult
-- ----------------------------

-- ----------------------------
-- Table structure for `xk_yaohset`
-- ----------------------------
DROP TABLE IF EXISTS `xk_yaohset`;
CREATE TABLE `xk_yaohset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `zgs` int(5) NOT NULL DEFAULT '1',
  `mzgs` int(4) NOT NULL DEFAULT '5' COMMENT '每组抽取个数',
  `groupgs` int(4) NOT NULL DEFAULT '1' COMMENT '组数',
  `showcontent` varchar(30) NOT NULL DEFAULT '姓名+手机号' COMMENT '显示内容：0姓名+VIP编号；1姓名+手机号；2姓名+身份证；3姓名+VIP编号+身份证',
  `ycqgs` int(5) NOT NULL DEFAULT '0' COMMENT '已抽取个数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0未开始；1进行中；-1已结束',
  `is_yx` tinyint(1) DEFAULT '1' COMMENT '是否有效: 0否，1是',
  `dqmaxgroup` int(4) NOT NULL DEFAULT '0' COMMENT '当前最大组',
  `dqmaxno` int(4) NOT NULL DEFAULT '0' COMMENT '当前最大序号',
  `fs` tinyint(1) DEFAULT '1' COMMENT '摇号方式：1随机；0顺序',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_yaohset
-- ----------------------------
INSERT INTO `xk_yaohset` VALUES ('15', '2', '2', '123', '1', '5', '0', '姓名+VIP编号+身份证', '0', '0', '1', '0', '0', '0', '123');

-- ----------------------------
-- Table structure for `xk_yaohuser`
-- ----------------------------
DROP TABLE IF EXISTS `xk_yaohuser`;
CREATE TABLE `xk_yaohuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proj_id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `cst_id` int(11) NOT NULL COMMENT '用户id',
  `yh_group` int(4) NOT NULL COMMENT '分组',
  `yh_group_px` int(4) NOT NULL COMMENT '分组排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xk_yaohuser
-- ----------------------------

-- ----------------------------
-- View structure for `xk_buildlist`
-- ----------------------------
DROP VIEW IF EXISTS `xk_buildlist`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `xk_buildlist` AS select `a`.`id` AS `id`,`a`.`pc_id` AS `pc_id`,`a`.`proj_id` AS `proj_id`,`a`.`buildname` AS `buildname`,`a`.`buildcode` AS `buildcode` from (`xk_build` `a` left join `xk_kppc` `b` on((`a`.`pc_id` = `b`.`id`))) where (`b`.`is_yx` = 1) ;

-- ----------------------------
-- View structure for `xk_cst2roomslist`
-- ----------------------------
DROP VIEW IF EXISTS `xk_cst2roomslist`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `xk_cst2roomslist` AS select `a`.`id` AS `id`,`a`.`cst_id` AS `cst_id`,`a`.`room_id` AS `room_id`,`a`.`sctime` AS `sctime`,`b`.`proj_id` AS `proj_id`,`b`.`pc_id` AS `pc_id`,`b`.`is_dq` AS `is_dq`,`b`.`is_xf` AS `is_xf` from (`xk_cst2rooms` `a` left join `xk_roomlist` `b` on((`a`.`room_id` = `b`.`id`))) ;

-- ----------------------------
-- View structure for `xk_roomlist`
-- ----------------------------
DROP VIEW IF EXISTS `xk_roomlist`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `xk_roomlist` AS select `a`.`id` AS `id`,`a`.`discount` AS `discount`,`a`.`bld_id` AS `bld_id`,`b`.`pc_id` AS `pc_id`,`a`.`ycx_price` AS `ycx_price`,`a`.`fq_price` AS `fq_price`,`a`.`aj_price` AS `aj_price`,`a`.`gjj_price` AS `gjj_price`,`a`.`proj_id` AS `proj_id`,`a`.`cp_id` AS `cp_id`,`a`.`unit` AS `unit`,`a`.`floor` AS `floor`,`a`.`no` AS `no`,`a`.`room` AS `room`,`a`.`hx` AS `hx`,`a`.`area` AS `area`,`a`.`tnarea` AS `tnarea`,`a`.`price` AS `price`,`a`.`tnprice` AS `tnprice`,`a`.`total` AS `total`,`a`.`is_xf` AS `is_xf`,`a`.`cstid` AS `cstid`,`a`.`xftime` AS `xftime`,`a`.`xstype` AS `xstype`,`f`.`customer_name` AS `cstname`,`f`.`customer_phone` AS `phone`,`f`.`cyjno` AS `cyjno`,`f`.`cardno` AS `cardno`,`a`.`is_qxxf` AS `is_qxxf`,`a`.`qxxftime` AS `qxxftime`,`b`.`buildname` AS `buildname`,`b`.`buildcode` AS `buildcode`,`c`.`name` AS `pcname`,`c`.`is_dq` AS `is_dq`,`d`.`name` AS `projname`,`e`.`name` AS `cpname` from (((((`xk_room` `a` left join `xk_build` `b` on((`a`.`bld_id` = `b`.`id`))) left join `xk_kppc` `c` on((`b`.`pc_id` = `c`.`id`))) left join `xk_project` `d` on((`a`.`proj_id` = `d`.`id`))) left join `xk_company` `e` on((`a`.`cp_id` = `e`.`id`))) left join `xk_choose` `f` on((`a`.`cstid` = `f`.`id`))) where (`d`.`status` = 1) ;

-- ----------------------------
-- View structure for `xk_station2sjqx`
-- ----------------------------
DROP VIEW IF EXISTS `xk_station2sjqx`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `xk_station2sjqx` AS select `a`.`id` AS `id`,`a`.`station_id` AS `station_id`,`a`.`pc_id` AS `pc_id`,`a`.`proj_id` AS `proj_id`,`d`.`cp_id` AS `cp_id`,`c`.`is_yx` AS `is_yx`,`c`.`is_dq` AS `is_dq`,`c`.`ledurl` AS `ledurl`,`c`.`name` AS `pcname`,`d`.`name` AS `projname` from ((`xk_station2pc` `a` left join `xk_kppc` `c` on((`a`.`pc_id` = `c`.`id`))) left join `xk_project` `d` on((`a`.`proj_id` = `d`.`id`))) ;
DROP TRIGGER IF EXISTS `conpany_insert`;
DELIMITER ;;
CREATE TRIGGER `conpany_insert` AFTER INSERT ON `xk_company` FOR EACH ROW BEGIN
     insert into xk_station(cp_id,name) values(new.id,'公司管理员');
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_atr`;
DELIMITER ;;
CREATE TRIGGER `insert_atr` AFTER INSERT ON `xk_order_house_order` FOR EACH ROW BEGIN
insert into xk_trade(yw_id,room_id,cst_id,source,status,isyx,tradetime,code,ywy)
values (new.id,new.room_id,new.belong_uid,'微信认购','选房',1,new.log_time,new.code,'');
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `delete_atr`;
DELIMITER ;;
CREATE TRIGGER `delete_atr` AFTER DELETE ON `xk_order_house_order` FOR EACH ROW BEGIN
delete from xk_trade where yw_id=old.id and source='微信认购'  and status='选房';
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `project_insert`;
DELIMITER ;;
CREATE TRIGGER `project_insert` AFTER INSERT ON `xk_project` FOR EACH ROW BEGIN
     insert into xk_station(cp_id,proj_id,name) values(new.cp_id,new.id,'销售管理');
     insert into xk_station(cp_id,proj_id,name) values(new.cp_id,new.id,'置业顾问');
     insert into xk_station(cp_id,proj_id,name) values(new.cp_id,new.id,'LED 展示');
END
;;
DELIMITER ;
