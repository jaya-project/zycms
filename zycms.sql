-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 05 月 11 日 16:18
-- 服务器版本: 5.5.38
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lvquan`
--

-- --------------------------------------------------------

--
-- 表的结构 `zycms_ad`
--

CREATE TABLE IF NOT EXISTS `zycms_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `name` varchar(255) NOT NULL COMMENT '广告名',
  `url` varchar(255) NOT NULL COMMENT '链接地址',
  `thumb` varchar(255) NOT NULL COMMENT '广告图片',
  `sort` int(10) unsigned NOT NULL COMMENT '排序字段',
  `pid` int(10) unsigned NOT NULL COMMENT '广告位ID',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='广告表' AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_admin`
--

CREATE TABLE IF NOT EXISTS `zycms_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `is_enable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用(1:启用, 0:禁用)',
  `rid` int(10) unsigned NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `zycms_admin`
--

INSERT INTO `zycms_admin` (`id`, `username`, `password`, `create_time`, `is_enable`, `rid`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2015-06-10 07:22:20', 1, 0);
-- --------------------------------------------------------

--
-- 表的结构 `zycms_ad_position`
--

CREATE TABLE IF NOT EXISTS `zycms_ad_position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `name` varchar(255) NOT NULL COMMENT '广告位名称',
  `is_enable` tinyint(3) unsigned NOT NULL COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='广告位表' AUTO_INCREMENT=4 ;



-- --------------------------------------------------------

--
-- 表的结构 `zycms_archives`
--

CREATE TABLE IF NOT EXISTS `zycms_archives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(1024) NOT NULL COMMENT '文章标题',
  `sub_title` varchar(1024) NOT NULL COMMENT '文章副标题',
  `tag` varchar(1024) NOT NULL COMMENT '标签',
  `thumb` varchar(1024) NOT NULL COMMENT '缩略图',
  `seo_title` varchar(1024) NOT NULL COMMENT 'SEO标题',
  `abstract` varchar(1024) NOT NULL COMMENT '摘要',
  `seo_keywords` varchar(1024) NOT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(2048) NOT NULL COMMENT 'SEO描述',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `author` varchar(255) NOT NULL COMMENT '文章作者',
  `source` varchar(1024) NOT NULL COMMENT '文章来源',
  `sort` int(10) unsigned NOT NULL COMMENT '排序',
  `click_count` int(10) unsigned NOT NULL COMMENT '点击次数',
  `recommend_type` varchar(255) NOT NULL COMMENT '推荐类型(热销,推荐等)',
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `sub_column` varchar(255) NOT NULL COMMENT '副栏目ID',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除(1,已删除 0,未删除)',
  `delay_time` int(10) NOT NULL DEFAULT '0' COMMENT '延迟发布时间',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章主表' AUTO_INCREMENT=14 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_areas`
--

CREATE TABLE IF NOT EXISTS `zycms_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaid` varchar(20) NOT NULL,
  `area` varchar(50) NOT NULL,
  `cityid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='行政区域县区信息表' AUTO_INCREMENT=3145 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_article`
--

CREATE TABLE IF NOT EXISTS `zycms_article` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `body` text COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_channel`
--

CREATE TABLE IF NOT EXISTS `zycms_channel` (
  `channel_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '内容模型ID',
  `channel_name` varchar(255) NOT NULL COMMENT '内容模型名称',
  `table_struct` text NOT NULL COMMENT '表结构(序列化)',
  `table_name` varchar(255) NOT NULL COMMENT '表名',
  PRIMARY KEY (`channel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='内容模型' AUTO_INCREMENT=4 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_cities`
--

CREATE TABLE IF NOT EXISTS `zycms_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cityid` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `provinceid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='行政区域地州市信息表' AUTO_INCREMENT=346 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_column`
--

CREATE TABLE IF NOT EXISTS `zycms_column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `column_name` varchar(255) NOT NULL COMMENT '栏目名称',
  `english_name` varchar(255) NOT NULL COMMENT '栏目英文名',
  `channel_id` int(10) unsigned NOT NULL COMMENT '模型ID',
  `pid` int(10) unsigned NOT NULL COMMENT '父栏目ID',
  `column_thumb` varchar(255) NOT NULL COMMENT '栏目图片',
  `summary` text NOT NULL COMMENT '栏目摘要',
  `seo_title` varchar(255) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(1024) NOT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(2048) NOT NULL COMMENT 'SEO描述',
  `content` text NOT NULL COMMENT '栏目内容',
  `is_nav` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否是导航(0,不是 1,是)',
  `sort` int(10) unsigned NOT NULL COMMENT '排序字段',
  `level` tinyint(3) unsigned NOT NULL COMMENT '分类级别',
  `rule_type` int(11) NOT NULL COMMENT '规则类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='栏目表' AUTO_INCREMENT=89 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_flink`
--

CREATE TABLE IF NOT EXISTS `zycms_flink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '友链ID',
  `name` varchar(255) NOT NULL COMMENT '友链名称',
  `url` varchar(1024) NOT NULL COMMENT '友链地址',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='友情链接表' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_forms`
--

CREATE TABLE IF NOT EXISTS `zycms_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '表单ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL COMMENT '表单名',
  `table_name` varchar(255) NOT NULL COMMENT '表名',
  `table_struct` text NOT NULL COMMENT '表单结构',
  `recevied` varchar(255) NOT NULL COMMENT '接收邮箱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='自定义表单表' AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_hot_search`
--

CREATE TABLE IF NOT EXISTS `zycms_hot_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '热搜关键词ID',
  `keywords` varchar(255) NOT NULL COMMENT '热搜关键词',
  `url` varchar(255) NOT NULL COMMENT '热搜链接',
  `sort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='热搜关键词表' AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_image`
--

CREATE TABLE IF NOT EXISTS `zycms_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `image_path` varchar(255) NOT NULL COMMENT '图片路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_keywords`
--

CREATE TABLE IF NOT EXISTS `zycms_keywords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '关键词',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '关键词链接地址',
  `target` char(10) CHARACTER SET utf8 NOT NULL COMMENT '是否新窗口打开',
  `style` varchar(1024) CHARACTER SET utf8 NOT NULL COMMENT '样式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='文章关键词表' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_member`
--

CREATE TABLE IF NOT EXISTS `zycms_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `true_name` varchar(255) NOT NULL COMMENT '会员真实姓名',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `email` varchar(255) NOT NULL COMMENT '邮箱地址',
  `address` varchar(1024) NOT NULL COMMENT '详细地址',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `phone` varchar(20) NOT NULL COMMENT '移动电话',
  `sex` tinyint(3) unsigned NOT NULL COMMENT '性别(1,男 2,女)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员表' AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_message`
--

CREATE TABLE IF NOT EXISTS `zycms_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `title` varchar(255) NOT NULL COMMENT '留言标题',
  `content` text NOT NULL COMMENT '留言内容',
  `mid` int(10) unsigned NOT NULL COMMENT '所属会员(若为0属于系统)',
  `pid` int(10) unsigned NOT NULL COMMENT '若为0, 则为新留言  若为留言ID, 则为回复',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `level` tinyint(3) unsigned NOT NULL COMMENT '消息层级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_nav`
--

CREATE TABLE IF NOT EXISTS `zycms_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航ID',
  `pid` int(10) unsigned NOT NULL COMMENT '导航父ID',
  `name` varchar(255) NOT NULL COMMENT '导航名称',
  `url` varchar(255) NOT NULL COMMENT '导航地址',
  `sort` int(10) unsigned NOT NULL COMMENT '排序',
  `position` tinyint(3) unsigned NOT NULL COMMENT '导航位置(1, 顶部导航 2, 尾部导航)',
  `level` int(10) unsigned NOT NULL COMMENT '导航级别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='导航表' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_opera_log`
--

CREATE TABLE IF NOT EXISTS `zycms_opera_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` int(11) NOT NULL COMMENT 'ip2long之后的ip地址',
  `opera_time` int(10) unsigned NOT NULL COMMENT '操作时间',
  `cm` varchar(255) NOT NULL COMMENT '控制器和方法',
  `user` varchar(255) NOT NULL COMMENT '操作用户',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='操作日志表' AUTO_INCREMENT=799 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_order`
--

CREATE TABLE IF NOT EXISTS `zycms_order` (
  `order_number` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单号',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `state` tinyint(3) unsigned NOT NULL COMMENT '订单状态(0, 未处理  1, 已处理)',
  `total` float NOT NULL COMMENT '订单总价',
  `mid` int(10) unsigned NOT NULL COMMENT '会员ID',
  `note` text NOT NULL COMMENT '订单备注',
  PRIMARY KEY (`order_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_order_product`
--

CREATE TABLE IF NOT EXISTS `zycms_order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `product_id` int(10) unsigned NOT NULL COMMENT '产品ID',
  `amount` int(10) unsigned NOT NULL COMMENT '产品数量',
  `price` double unsigned NOT NULL COMMENT '产品单价',
  `order_number` int(10) unsigned NOT NULL COMMENT '产品订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单产品表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_piece`
--

CREATE TABLE IF NOT EXISTS `zycms_piece` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '碎片ID',
  `name` varchar(255) NOT NULL COMMENT '碎片名称',
  `content` text NOT NULL COMMENT '碎片内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='内容碎片表' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_products`
--

CREATE TABLE IF NOT EXISTS `zycms_products` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID',
  `body` text COMMENT '内容',
  `yingyong` varchar(255) DEFAULT NULL,
  `yanse` varchar(255) DEFAULT NULL,
  `jingzhong` varchar(255) DEFAULT NULL,
  `tedian` text,
  `images` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_provinces`
--

CREATE TABLE IF NOT EXISTS `zycms_provinces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provinceid` varchar(20) NOT NULL,
  `province` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='省份信息表' AUTO_INCREMENT=35 ;


-- --------------------------------------------------------

--
-- 表的结构 `zycms_relationship`
--

CREATE TABLE IF NOT EXISTS `zycms_relationship` (
  `roleid` int(10) unsigned NOT NULL COMMENT '角色ID',
  `rid` int(10) unsigned NOT NULL COMMENT '权限ID',
  PRIMARY KEY (`roleid`,`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关系表';

-- --------------------------------------------------------

--
-- 表的结构 `zycms_right`
--

CREATE TABLE IF NOT EXISTS `zycms_right` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `name` varchar(255) NOT NULL COMMENT '权限名称',
  `resource` varchar(1024) NOT NULL COMMENT '权限资源',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限表' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `zycms_right`
--

INSERT INTO `zycms_right` (`id`, `name`, `resource`) VALUES
(1, '模型管理', 'admin@channel_list,admin@channel_add'),
(3, '栏目管理', 'admin@column_list,admin@column_add'),
(4, '文档管理', 'admin@document_list,admin@document_add'),
(5, '广告管理', 'admin@ad_position,admin@ad_list'),
(6, '内容碎片管理', 'admin@piece_list'),
(7, '自定义表单', 'admin@form_list,admin@form_management'),
(8, '用户管理', 'admin@right_list,admin@role_list,admin@user_list'),
(9, '工具', 'admin@database_backup,admin@sitemap,admin@qr_code,admin@auto_push,admin@bat_export,admin@black_list,admin@opera_log,admin@ico_management,admin@access_tongji'),
(10, '系统设置管理', 'admin@base_set,admin@nav_set,admin@water_image'),
(11, '友情链接', 'admin@flink'),
(12, '关键词管理', 'admin@hot_search,admin@keywords'),
(13, '生成静态', 'admin@build_html'),
(15, '回收站', 'admin@recycle_bin'),
(16, '会员管理', 'admin@member_list,admin@order_list,admin@message_list'),
(17, '通用模板管理', 'admin@templates');

-- --------------------------------------------------------

--
-- 表的结构 `zycms_role`
--

CREATE TABLE IF NOT EXISTS `zycms_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `name` varchar(255) NOT NULL COMMENT '角色名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=10 ;



-- --------------------------------------------------------

--
-- 表的结构 `zycms_rule`
--

CREATE TABLE IF NOT EXISTS `zycms_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(10) unsigned NOT NULL COMMENT '栏目ID',
  `destination_rule` varchar(2048) NOT NULL COMMENT '目标路径规则',
  `source_rule` varchar(2048) NOT NULL COMMENT '源路径规则',
  `type` tinyint(3) unsigned NOT NULL COMMENT '生成类型(1. 单页  2.列表 3.详细)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='规则表' AUTO_INCREMENT=276 ;

-- --------------------------------------------------------

--
-- 表的结构 `zycms_tongji`
--

CREATE TABLE IF NOT EXISTS `zycms_tongji` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_agent` varchar(255) NOT NULL COMMENT '用户代理(什么浏览器)',
  `ip` int(11) NOT NULL COMMENT 'ip地址',
  `date` date NOT NULL COMMENT '访问时间',
  `referer` varchar(255) NOT NULL COMMENT '访问网站来源',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='统计表' AUTO_INCREMENT=338 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
