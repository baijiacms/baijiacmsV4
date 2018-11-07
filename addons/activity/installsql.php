<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家威信 <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
defined('LOCK_TO_ADDONS_INSTALL') or exit('Access Denied');
$sql = "
CREATE TABLE IF NOT EXISTS `baijiacms_activity` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(10) NOT NULL COMMENT '公众号ID',
  `title` varchar(255) NOT NULL COMMENT '活动标题',
  `sharetitle` varchar(200) DEFAULT NULL COMMENT '分享标题',
  `followurl` varchar(200) DEFAULT NULL COMMENT '关注地址',
  `sharepic` varchar(255) DEFAULT NULL COMMENT '分享图片',
  `sharedesc` varchar(255) DEFAULT NULL COMMENT '分享描述',
  `unit` varchar(255) NOT NULL COMMENT '主办单位名称',
  `tel` varchar(11) NOT NULL COMMENT '联系电话',
  `detail` text COMMENT '详细内容',
  `starttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '开始时间',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `joinstime` timestamp NULL DEFAULT NULL COMMENT '报名开始时间',
  `joinetime` timestamp NULL DEFAULT NULL COMMENT '报名结束时间',
    `followicon` varchar(255) NOT NULL COMMENT '关注图标',
  `atlas` text NOT NULL COMMENT '图集',
  `personnum` int(11) DEFAULT NULL COMMENT '活动人数',
  `virtualrec` int(11) DEFAULT NULL COMMENT '活动人数',
  `lng` varchar(255) DEFAULT NULL COMMENT '经度',
  `lat` varchar(255) DEFAULT NULL COMMENT '纬度',
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `prize` text COMMENT '奖励设置',
    `entery_title` varchar(100) NOT NULL DEFAULT '',
  `entery_description` varchar(255) NOT NULL DEFAULT '',
  `entery_thumb` varchar(200) NOT NULL DEFAULT '',
  `entery_keyword` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of baijiacms_activity
-- ----------------------------

-- ----------------------------
-- Table structure for baijiacms_activity_records
-- ----------------------------
CREATE TABLE IF NOT EXISTS `baijiacms_activity_records` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `activityid` int(11) DEFAULT NULL COMMENT '活动ID',
  `uniacid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `openid` varchar(255) DEFAULT NULL COMMENT '微信用id',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
    `isagent` tinyint(1) DEFAULT '0',
  `username` varchar(255) DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机',
  `birthday` varchar(30) DEFAULT NULL COMMENT '性别',
  `pic` varchar(255) DEFAULT NULL COMMENT '照片',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '粉丝头像',
  `msg` text COMMENT '留言',
  `jointime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '报名时间',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '报名状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

delete from `baijiacms_modules` where `name`='activity';
delete from `baijiacms_modules_menu` where `module`='activity';
INSERT INTO `baijiacms_modules` (`icon`,`group`,`title`,`version`,`name`) VALUES ('icon-money', 'addons', '活动报名', '1.0', 'activity');
INSERT INTO `baijiacms_modules_menu`(`href`,`title`,`module`) VALUES ('".create_url('site',array('act' => 'activity','do' => 'activity','isaddons'=>'1','op'=>'display'))."', '活动管理', 'activity');

";
//&isaddons=1
mysqld_batch($sql);