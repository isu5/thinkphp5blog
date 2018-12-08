/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tpauth

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-01 19:27:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog_admin`
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin`;
CREATE TABLE `blog_admin` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(20) NOT NULL,
  `encrypt` char(6) NOT NULL,
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of blog_admin
-- ----------------------------
INSERT INTO `blog_admin` VALUES ('1', 'admin', 'd55661f6c7417888f8c4e516a52d5872', '1541069546', '127.0.0.1', 'Iru3SE', '0');
INSERT INTO `blog_admin` VALUES ('2', 'isu5com', 'b6b5710a1e54851cd3fb7223f7d671a6', '1541069892', '127.0.0.1', 'ITW2Td', '1541069892');

-- ----------------------------
-- Table structure for `blog_admin_logs`
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin_logs`;
CREATE TABLE `blog_admin_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `resource_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源id，如果是0证明是添加？，此字段不设置为无符号',
  `title` varchar(255) NOT NULL COMMENT '日志标题',
  `log_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1get，2post，3put，4deldet',
  `log_url` varchar(255) NOT NULL COMMENT '访问url',
  `log_ip` bigint(15) NOT NULL COMMENT '操作ip',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态，保留字段',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台用户操作日志表';

-- ----------------------------
-- Records of blog_admin_logs
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `blog_auth_group`;
CREATE TABLE `blog_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of blog_auth_group
-- ----------------------------
INSERT INTO `blog_auth_group` VALUES ('1', '超级管理员', '1', '1');
INSERT INTO `blog_auth_group` VALUES ('2', '审核管理员', '1', '');
INSERT INTO `blog_auth_group` VALUES ('3', '日志管理员', '1', '1,6,7');

-- ----------------------------
-- Table structure for `blog_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `blog_auth_group_access`;
CREATE TABLE `blog_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组权限明细表';

-- ----------------------------
-- Records of blog_auth_group_access
-- ----------------------------
INSERT INTO `blog_auth_group_access` VALUES ('1', '1');
INSERT INTO `blog_auth_group_access` VALUES ('2', '3');

-- ----------------------------
-- Table structure for `blog_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `blog_auth_rule`;
CREATE TABLE `blog_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) NOT NULL COMMENT '父节点',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '节点地址',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '节点名称',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '0' COMMENT '是否菜单显示 0否 1是',
  `icon` varchar(30) NOT NULL COMMENT '节点图标',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '节点等级',
  `sort` mediumint(9) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of blog_auth_rule
-- ----------------------------
INSERT INTO `blog_auth_rule` VALUES ('1', '0', 'Index/index', '仪表盘', '1', '1', '1', 'fa-home', '1', '0');
INSERT INTO `blog_auth_rule` VALUES ('2', '0', 'Admin/admin', '后台权限管理', '1', '1', '1', 'fa-users', '1', '0');
INSERT INTO `blog_auth_rule` VALUES ('3', '2', 'Admin/role', '后台角色权限', '1', '1', '1', 'fa-cogs', '2', '0');
INSERT INTO `blog_auth_rule` VALUES ('4', '2', 'Admin/node', '后台菜单列表', '1', '1', '1', 'fa-sitemap', '2', '0');
INSERT INTO `blog_auth_rule` VALUES ('5', '2', 'Admin/index', '后台角色列表', '1', '1', '1', 'fa-user', '2', '0');
INSERT INTO `blog_auth_rule` VALUES ('6', '0', 'Admin/admin_log', '日志管理', '1', '1', '1', 'fa-info-circle', '1', '0');
INSERT INTO `blog_auth_rule` VALUES ('7', '6', 'admin_log/index', '操作日志', '1', '1', '1', 'fa-info-circle', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('8', '3', 'Admin/role_add', '添加角色', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('9', '3', 'Admin/role_edit', '编辑角色', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('10', '3', 'Admin/role_del', '删除角色', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('15', '4', 'Admin/node_add', '添加权限', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('16', '4', 'Admin/node_edit', '编辑权限', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('17', '4', 'Admin/node_del', '删除权限', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('18', '5', 'Admin/add', '添加管理员', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('19', '5', 'Admin/edit', '编辑管理员', '1', '1', '0', '', '3', '0');
INSERT INTO `blog_auth_rule` VALUES ('20', '5', 'Admin/del', '删除管理员', '1', '1', '0', '', '3', '0');
