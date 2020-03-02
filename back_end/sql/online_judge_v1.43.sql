-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2020-03-02 14:00:09
-- 服务器版本： 5.7.26
-- PHP 版本： 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `online_judge`
--
CREATE DATABASE IF NOT EXISTS `online_judge` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `online_judge`;

-- --------------------------------------------------------

--
-- 表的结构 `authority`
--

DROP TABLE IF EXISTS `authority`;
CREATE TABLE IF NOT EXISTS `authority` (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `contest`
--

DROP TABLE IF EXISTS `contest`;
CREATE TABLE IF NOT EXISTS `contest` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `begin_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `frozen` double NOT NULL DEFAULT '0.2',
  `problems` varchar(512) NOT NULL,
  `colors` varchar(512) CHARACTER SET utf8mb4 NOT NULL COMMENT '题目对应颜色',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `contest_users`
--

DROP TABLE IF EXISTS `contest_users`;
CREATE TABLE IF NOT EXISTS `contest_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL COMMENT '比赛序号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `discuss`
--

DROP TABLE IF EXISTS `discuss`;
CREATE TABLE IF NOT EXISTS `discuss` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `contest_id` int(11) NOT NULL COMMENT '比赛id',
  `problem_id` int(11) NOT NULL COMMENT '题目id',
  `user_id` int(11) NOT NULL COMMENT '提问者id',
  `title` text NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '提问内容',
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提问时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否有管理员回复(0-没有，1-有)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `find_password`
--

DROP TABLE IF EXISTS `find_password`;
CREATE TABLE IF NOT EXISTS `find_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `nick` varchar(255) NOT NULL COMMENT '用户名',
  `token` varchar(16) NOT NULL COMMENT '验证码',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(64) NOT NULL,
  `desc` text,
  `group_creator` int(11) DEFAULT NULL COMMENT 'user_id of creator',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `group_problem`
--

DROP TABLE IF EXISTS `group_problem`;
CREATE TABLE IF NOT EXISTS `group_problem` (
  `group_id` int(11) NOT NULL COMMENT '团队序号',
  `problem_id` int(11) NOT NULL COMMENT '题目序号',
  PRIMARY KEY (`group_id`,`problem_id`),
  KEY `group_id` (`group_id`,`problem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `knowledge`
--

DROP TABLE IF EXISTS `knowledge`;
CREATE TABLE IF NOT EXISTS `knowledge` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `point` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `knowledge_relationship`
--

DROP TABLE IF EXISTS `knowledge_relationship`;
CREATE TABLE IF NOT EXISTS `knowledge_relationship` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(8) NOT NULL,
  `pre_knowledge_id` int(8) NOT NULL,
  `is_core` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `knowledge_id` (`knowledge_id`),
  KEY `pre_knowledge_id` (`pre_knowledge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `knowledge__problem`
--

DROP TABLE IF EXISTS `knowledge__problem`;
CREATE TABLE IF NOT EXISTS `knowledge__problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `knowledge_id` int(8) NOT NULL,
  `is_core` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `problem_id` (`problem_id`),
  KEY `knowledge_id` (`knowledge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `knowledge__tag`
--

DROP TABLE IF EXISTS `knowledge__tag`;
CREATE TABLE IF NOT EXISTS `knowledge__tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(8) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `knowledge_id` (`knowledge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `knowledge__user`
--

DROP TABLE IF EXISTS `knowledge__user`;
CREATE TABLE IF NOT EXISTS `knowledge__user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `knowledge_doing` json DEFAULT NULL,
  `knowledge_done` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `link` varchar(128) NOT NULL DEFAULT '""' COMMENT '跳转链接',
  `begintime` datetime NOT NULL COMMENT '开始时间',
  `endtime` datetime NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `user_id` int(11) NOT NULL,
  `privilege` varchar(33) NOT NULL,
  PRIMARY KEY (`user_id`,`privilege`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `problem`
--

DROP TABLE IF EXISTS `problem`;
CREATE TABLE IF NOT EXISTS `problem` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `background` text,
  `describe` text,
  `input_format` text,
  `output_format` text,
  `hint` text,
  `public` int(1) NOT NULL DEFAULT '1',
  `source` varchar(512) DEFAULT NULL,
  `ac` int(8) NOT NULL DEFAULT '0',
  `wa` int(8) NOT NULL DEFAULT '0',
  `tag` varchar(512) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `reply`
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE IF NOT EXISTS `reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discuss_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `role_group`
--

DROP TABLE IF EXISTS `role_group`;
CREATE TABLE IF NOT EXISTS `role_group` (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `authority` json DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `user_num` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `rotation`
--

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE IF NOT EXISTS `rotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `title` varchar(32) NOT NULL COMMENT '标题',
  `url` varchar(128) NOT NULL COMMENT '链接',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sample`
--

DROP TABLE IF EXISTS `sample`;
CREATE TABLE IF NOT EXISTS `sample` (
  `sample_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `input` varchar(512) DEFAULT NULL,
  `output` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sample_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `submit`
--

DROP TABLE IF EXISTS `submit`;
CREATE TABLE IF NOT EXISTS `submit` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `nick` varchar(64) CHARACTER SET utf8mb4 NOT NULL COMMENT '用户昵称',
  `problem_id` int(11) NOT NULL COMMENT '题目编号',
  `contest_id` int(11) DEFAULT '0' COMMENT '比赛id',
  `source_code` text NOT NULL COMMENT '源代码',
  `language` tinyint(4) NOT NULL DEFAULT '1' COMMENT '语言',
  `status` varchar(16) NOT NULL COMMENT '状态',
  `time` bigint(12) NOT NULL,
  `memory` int(11) NOT NULL,
  `submit_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `submit_log`
--

DROP TABLE IF EXISTS `submit_log`;
CREATE TABLE IF NOT EXISTS `submit_log` (
  `time` datetime NOT NULL,
  `ac` int(6) NOT NULL,
  `submit` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '标签序号',
  `name` varchar(64) NOT NULL COMMENT '标签名字',
  `description` varchar(200) NOT NULL COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '标签状态(0-禁用,1-正常)',
  `color` varchar(16) NOT NULL DEFAULT '#FFFFFF' COMMENT '标签颜色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `realname` varchar(32) NOT NULL,
  `school` varchar(64) NOT NULL,
  `major` varchar(64) NOT NULL,
  `class` varchar(32) NOT NULL,
  `contact` varchar(64) NOT NULL,
  `identity` int(2) NOT NULL DEFAULT '0',
  `desc` text,
  `mail` varchar(64) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `role_group` json DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 限制导出的表
--

--
-- 限制表 `knowledge_relationship`
--
ALTER TABLE `knowledge_relationship`
  ADD CONSTRAINT `knowledge_relationship_ibfk_1` FOREIGN KEY (`knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `knowledge_relationship_ibfk_2` FOREIGN KEY (`pre_knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE;

--
-- 限制表 `knowledge__problem`
--
ALTER TABLE `knowledge__problem`
  ADD CONSTRAINT `knowledge__problem_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `problem` (`problem_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `knowledge__problem_ibfk_2` FOREIGN KEY (`knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE;

--
-- 限制表 `knowledge__tag`
--
ALTER TABLE `knowledge__tag`
  ADD CONSTRAINT `knowledge__tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `knowledge__tag_ibfk_3` FOREIGN KEY (`knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `knowledge__user`
--
ALTER TABLE `knowledge__user`
  ADD CONSTRAINT `knowledge__user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- 限制表 `privilege`
--
ALTER TABLE `privilege`
  ADD CONSTRAINT `privilege_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- 限制表 `sample`
--
ALTER TABLE `sample`
  ADD CONSTRAINT `sample_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `problem` (`problem_id`) ON DELETE CASCADE;

--
-- 限制表 `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `user_group_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `privilege` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
