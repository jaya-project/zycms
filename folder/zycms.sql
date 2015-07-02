#
# TABLE STRUCTURE FOR: zycms_ad
#

DROP TABLE IF EXISTS `zycms_ad`;

CREATE TABLE `zycms_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `name` varchar(255) NOT NULL COMMENT '广告名',
  `thumb` varchar(255) NOT NULL COMMENT '广告图片',
  `sort` int(10) unsigned NOT NULL COMMENT '排序字段',
  `pid` int(10) unsigned NOT NULL COMMENT '广告位ID',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='广告表';

INSERT INTO `zycms_ad` (`id`, `name`, `thumb`, `sort`, `pid`) VALUES ('2', '首页广告一', '/uploads/2015/06/16/2015_06_16_1434445774.jpg', '1', '1');
INSERT INTO `zycms_ad` (`id`, `name`, `thumb`, `sort`, `pid`) VALUES ('3', '首页广告二', '/uploads/2015/06/16/2015_06_16_1434445854.jpg', '2', '1');
INSERT INTO `zycms_ad` (`id`, `name`, `thumb`, `sort`, `pid`) VALUES ('4', '首页广告三', '/uploads/2015/06/17/2015_06_17_1434527391.jpg', '3', '1');


#
# TABLE STRUCTURE FOR: zycms_ad_position
#

DROP TABLE IF EXISTS `zycms_ad_position`;

CREATE TABLE `zycms_ad_position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `name` varchar(255) NOT NULL COMMENT '广告位名称',
  `is_enable` tinyint(3) unsigned NOT NULL COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='广告位表';

INSERT INTO `zycms_ad_position` (`id`, `name`, `is_enable`) VALUES ('1', '首页幻灯片', '1');


#
# TABLE STRUCTURE FOR: zycms_admin
#

DROP TABLE IF EXISTS `zycms_admin`;

CREATE TABLE `zycms_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用(1:启用, 0:禁用)',
  `rid` int(10) unsigned NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `zycms_admin` (`id`, `username`, `password`, `create_time`, `is_enable`, `rid`) VALUES ('1', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2015-06-10 07:22:20', '1', '0');


#
# TABLE STRUCTURE FOR: zycms_archives
#

DROP TABLE IF EXISTS `zycms_archives`;

CREATE TABLE `zycms_archives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(1024) NOT NULL COMMENT '文章标题',
  `sub_title` varchar(1024) NOT NULL COMMENT '文章副标题',
  `tag` varchar(1024) NOT NULL COMMENT '标签',
  `thumb` varchar(1024) NOT NULL COMMENT '缩略图',
  `seo_title` varchar(1024) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(1024) NOT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(2048) NOT NULL COMMENT 'SEO描述',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `author` varchar(255) NOT NULL COMMENT '文章作者',
  `source` varchar(1024) NOT NULL COMMENT '文章来源',
  `sort` int(10) unsigned NOT NULL COMMENT '排序',
  `click_count` int(10) unsigned NOT NULL COMMENT '点击次数',
  `recommend_type` varchar(255) NOT NULL COMMENT '推荐类型(热销,推荐等)',
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章主表';

#
# TABLE STRUCTURE FOR: zycms_article
#

DROP TABLE IF EXISTS `zycms_article`;

CREATE TABLE `zycms_article` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `body` text COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: zycms_channel
#

DROP TABLE IF EXISTS `zycms_channel`;

CREATE TABLE `zycms_channel` (
  `channel_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '内容模型ID',
  `channel_name` varchar(255) NOT NULL COMMENT '内容模型名称',
  `table_struct` text NOT NULL COMMENT '表结构(序列化)',
  `table_name` varchar(255) NOT NULL COMMENT '表名',
  PRIMARY KEY (`channel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='内容模型';

INSERT INTO `zycms_channel` (`channel_id`, `channel_name`, `table_struct`, `table_name`) VALUES ('9', '文章', 'a:1:{i:0;a:4:{s:6:\"fields\";s:4:\"body\";s:12:\"label_fields\";s:6:\"内容\";s:12:\"channel_type\";s:8:\"htmltext\";s:6:\"vlaues\";s:0:\"\";}}', 'article');
INSERT INTO `zycms_channel` (`channel_id`, `channel_name`, `table_struct`, `table_name`) VALUES ('12', '产品', 'a:4:{i:0;a:4:{s:6:\"fields\";s:6:\"number\";s:12:\"label_fields\";s:6:\"编号\";s:12:\"channel_type\";s:4:\"text\";s:6:\"values\";s:0:\"\";}i:1;a:4:{s:6:\"fields\";s:5:\"place\";s:12:\"label_fields\";s:6:\"产地\";s:12:\"channel_type\";s:6:\"select\";s:6:\"values\";s:27:\"江西,广东,湖南,湖北\";}i:2;a:4:{s:6:\"fields\";s:6:\"detail\";s:12:\"label_fields\";s:12:\"详细说明\";s:12:\"channel_type\";s:8:\"htmltext\";s:6:\"values\";s:0:\"\";}i:3;a:4:{s:6:\"fields\";s:4:\"spec\";s:12:\"label_fields\";s:12:\"规格参数\";s:12:\"channel_type\";s:8:\"htmltext\";s:6:\"values\";s:0:\"\";}}', 'product');


#
# TABLE STRUCTURE FOR: zycms_column
#

DROP TABLE IF EXISTS `zycms_column`;

CREATE TABLE `zycms_column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `column_name` varchar(255) NOT NULL COMMENT '栏目名称',
  `channel_id` int(10) unsigned NOT NULL COMMENT '模型ID',
  `pid` int(10) unsigned NOT NULL COMMENT '父栏目ID',
  `column_thumb` varchar(255) NOT NULL COMMENT '栏目图片',
  `seo_title` varchar(255) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(1024) NOT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(2048) NOT NULL COMMENT 'SEO描述',
  `content` text NOT NULL COMMENT '栏目内容',
  `is_nav` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是导航(0,不是;1,是)',
  `sort` int(10) unsigned NOT NULL COMMENT '排序字段',
  `level` tinyint(3) unsigned NOT NULL COMMENT '分类级别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='栏目表';

INSERT INTO `zycms_column` (`id`, `column_name`, `channel_id`, `pid`, `column_thumb`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `is_nav`, `sort`, `level`) VALUES ('4', '厨房家居', '11', '1', '/uploads/2015/06/13/2015_06_13_1434176629.jpg', '', '', '', '', '0', '2', '2');
INSERT INTO `zycms_column` (`id`, `column_name`, `channel_id`, `pid`, `column_thumb`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `is_nav`, `sort`, `level`) VALUES ('5', '新闻中心', '9', '0', '', '', '', '', '', '0', '1', '1');
INSERT INTO `zycms_column` (`id`, `column_name`, `channel_id`, `pid`, `column_thumb`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `is_nav`, `sort`, `level`) VALUES ('6', '内部新闻', '9', '5', '', '', '', '', '', '0', '1', '2');
INSERT INTO `zycms_column` (`id`, `column_name`, `channel_id`, `pid`, `column_thumb`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `is_nav`, `sort`, `level`) VALUES ('7', '产品中心', '12', '0', '', '', '', '', '', '0', '0', '1');


#
# TABLE STRUCTURE FOR: zycms_feedback
#

DROP TABLE IF EXISTS `zycms_feedback`;

CREATE TABLE `zycms_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user` varchar(255) DEFAULT NULL COMMENT '姓名',
  `company` varchar(255) DEFAULT NULL COMMENT '公司',
  `contact` varchar(255) DEFAULT NULL COMMENT '联系方式',
  `address` varchar(255) DEFAULT NULL COMMENT '联系地址',
  `content` text COMMENT '留言内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `zycms_feedback` (`id`, `user`, `company`, `contact`, `address`, `content`) VALUES ('1', '姓名', '公司', '联系方式', '联系地址', '留言内容');
INSERT INTO `zycms_feedback` (`id`, `user`, `company`, `contact`, `address`, `content`) VALUES ('2', '齐庆', '朝阳网络', '13800138000', '旗峰路', '测试内容');


#
# TABLE STRUCTURE FOR: zycms_forms
#

DROP TABLE IF EXISTS `zycms_forms`;

CREATE TABLE `zycms_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '表单ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL COMMENT '表单名',
  `table_name` varchar(255) NOT NULL COMMENT '表名',
  `table_struct` text NOT NULL COMMENT '表单结构',
  `recevied` varchar(255) NOT NULL COMMENT '接收邮箱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='自定义表单表';

INSERT INTO `zycms_forms` (`id`, `name`, `table_name`, `table_struct`, `recevied`) VALUES ('4', '在线留言', 'feedback', 'a:5:{i:0;a:3:{s:6:\"fields\";s:4:\"user\";s:12:\"label_fields\";s:6:\"姓名\";s:9:\"form_type\";s:4:\"text\";}i:1;a:4:{s:6:\"fields\";s:7:\"company\";s:12:\"label_fields\";s:6:\"公司\";s:9:\"form_type\";s:4:\"text\";s:6:\"values\";s:0:\"\";}i:2;a:4:{s:6:\"fields\";s:7:\"contact\";s:12:\"label_fields\";s:12:\"联系方式\";s:9:\"form_type\";s:4:\"text\";s:6:\"values\";s:0:\"\";}i:3;a:4:{s:6:\"fields\";s:7:\"address\";s:12:\"label_fields\";s:12:\"联系地址\";s:9:\"form_type\";s:4:\"text\";s:6:\"values\";s:0:\"\";}i:4;a:4:{s:6:\"fields\";s:7:\"content\";s:12:\"label_fields\";s:12:\"留言内容\";s:9:\"form_type\";s:8:\"textarea\";s:6:\"values\";s:0:\"\";}}', '770290355@qq.com');


#
# TABLE STRUCTURE FOR: zycms_image
#

DROP TABLE IF EXISTS `zycms_image`;

CREATE TABLE `zycms_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `image_path` varchar(255) NOT NULL COMMENT '图片路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表';

#
# TABLE STRUCTURE FOR: zycms_piece
#

DROP TABLE IF EXISTS `zycms_piece`;

CREATE TABLE `zycms_piece` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '碎片ID',
  `name` varchar(255) NOT NULL COMMENT '碎片名称',
  `content` text NOT NULL COMMENT '碎片内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='内容碎片表';

INSERT INTO `zycms_piece` (`id`, `name`, `content`) VALUES ('2', '12321321312321', '<p>3213213213213312321</p>');


#
# TABLE STRUCTURE FOR: zycms_product
#

DROP TABLE IF EXISTS `zycms_product`;

CREATE TABLE `zycms_product` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `number` varchar(255) DEFAULT NULL COMMENT '编号',
  `place` varchar(255) DEFAULT NULL COMMENT '产地',
  `detail` text COMMENT '详细说明',
  `spec` text COMMENT '规格参数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: zycms_role
#

DROP TABLE IF EXISTS `zycms_role`;

CREATE TABLE `zycms_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `name` varchar(255) NOT NULL COMMENT '角色名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

