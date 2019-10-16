-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2019-10-15 14:31:04
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
CREATE DATABASE IF NOT EXISTS `online_judge` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `online_judge`;

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
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `contest`
--

INSERT INTO `contest` (`contest_id`, `contest_name`, `begin_time`, `end_time`, `frozen`, `problems`, `colors`, `status`) VALUES
(1000, 'test', '2019-10-15 08:12:47', '2019-10-15 08:12:47', 0.2, '[\"1001\",\"1002\"]', '[\"#FFFFFF\",\"#FF00FF\"]', 1),
(1001, 'test', '2019-10-15 08:12:47', '2019-10-15 08:12:47', 0.2, '[\"1001\",\"1002\"]', '[\"#FFFFFF\",\"#FF00FF\"]', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `discuss`
--

INSERT INTO `discuss` (`id`, `contest_id`, `problem_id`, `user_id`, `title`, `content`, `time`, `status`) VALUES
(1, 1001, 1001, 1, 'wyhsb', 'wyhsb', '2019-10-13 15:49:45', 1),
(2, 1001, 1001, 1, 'wyhsb', 'wyhsb', '2019-10-13 15:56:46', 0),
(3, 1001, 1001, 1, 'ssss', 'wyhsb', '2019-10-13 15:59:34', 0),
(4, 1001, 1001, 1, 'ssss', 'wyhsb', '2019-10-13 16:00:31', 8);

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `find_password`
--

INSERT INTO `find_password` (`id`, `nick`, `token`, `time`, `state`) VALUES
(1, 'kdl12138', 'wTzBAVKdEu', '2019-07-11 08:38:21', 1),
(2, 'kdl12138', 'c7YmY3Dx3Q', '2019-07-11 08:46:05', 1),
(3, 'kdl12138', 'hkmranXaGp', '2019-07-11 08:46:49', 1),
(4, 'kdl12138', 'w4uRYf7Wsj', '2019-07-11 08:47:36', 1),
(5, 'kdl12138', 'ypN8LkmmkH', '2019-07-11 08:47:39', 1),
(6, 'kdl12138', 'v48VXkTCAN', '2019-07-11 08:47:59', 1),
(7, 'kdl12138', 'pYD42DzGeY', '2019-07-11 08:48:36', 1),
(8, 'kdl12138', 'UYwWrcDA8s', '2019-07-11 08:49:04', 1),
(9, 'kdl12138', '2yzzRGVbzf', '2019-07-11 08:52:01', 1),
(10, 'kdl1213', 'suWTeVCFEf', '2019-07-11 08:52:31', 1),
(11, 'kdl1213', 'W6tQU4wE7u', '2019-07-11 08:53:27', 1),
(12, 'kdl1213', 'jHUhCF8VHp', '2019-07-11 08:53:36', 1),
(13, 'kdl1213', 'hBpzU7x7qV', '2019-07-11 08:54:13', 0),
(14, 'kdl12138', 'K6jRBHYPT5', '2019-07-11 08:54:17', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`id`, `title`, `content`, `link`, `begintime`, `endtime`) VALUES
(1, 'test1', 'test', '\"\"', '2019-03-28 00:00:00', '2019-03-31 00:00:00'),
(2, 'test2', 'test', '\"\"', '2019-03-30 00:00:00', '2019-03-31 00:00:00'),
(3, 'test3', 'test', '\"\"', '2019-03-27 00:00:00', '2019-03-28 00:00:00'),
(4, 'test4', 'test', '\"\"', '2019-03-28 00:00:00', '2019-03-30 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `problem`
--

INSERT INTO `problem` (`problem_id`, `title`, `background`, `describe`, `input_format`, `output_format`, `hint`, `public`, `source`, `ac`, `wa`, `tag`, `status`) VALUES
(1001, 'wyhsb', 'wyhsb', 'wyhsb', 'wyhsb', 'wyhsb', 'wyhsb', 1, NULL, 0, 0, NULL, 1),
(1002, 'wyhsb', 'wyhsb', 'wyhsb', 'wyhsb', 'wyhsb', 'wyhsb', 1, NULL, 0, 0, NULL, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `reply`
--

INSERT INTO `reply` (`id`, `discuss_id`, `user_id`, `content`, `time`) VALUES
(1, 1, 1, 'wyhqssb', '2019-10-13 15:52:12'),
(2, 1, 1, 'wyhsb', '2019-10-13 16:02:05'),
(3, 1, 1, 'wyhsb', '2019-10-13 16:02:43');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `rotation`
--

INSERT INTO `rotation` (`id`, `title`, `url`, `status`) VALUES
(1, 'test', 'xxx', 1),
(2, 'test', 'xxxx', 0),
(3, 'test', 'xxxxx', 1),
(4, 'test', 'xxxx', 1),
(5, 'test', 'xxxxx', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sample`
--

INSERT INTO `sample` (`sample_id`, `problem_id`, `input`, `output`) VALUES
(1, 1001, 'wyhsb', 'wyhsb'),
(2, 1001, 'wyhsb', 'wyhsb');

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
  `contest_id` int(11) DEFAULT NULL COMMENT '比赛id',
  `source_code` text NOT NULL COMMENT '源代码',
  `language` tinyint(4) NOT NULL DEFAULT '1' COMMENT '语言',
  `status` varchar(16) NOT NULL COMMENT '状态',
  `time` varchar(16) NOT NULL,
  `memory` varchar(16) NOT NULL,
  `submit_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `submit`
--

INSERT INTO `submit` (`id`, `user_id`, `nick`, `problem_id`, `contest_id`, `source_code`, `language`, `status`, `time`, `memory`, `submit_time`) VALUES
(1, 123, '', 123, NULL, '123', 1, '1', '', '', '2019-03-31 14:09:47'),
(2, 123, '', 123, NULL, '122', 1, '2', '', '', '2019-03-31 20:10:06'),
(3, 0, '', 0, NULL, '', 1, '0', '', '', '2019-03-31 13:00:00');

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

--
-- 转存表中的数据 `submit_log`
--

INSERT INTO `submit_log` (`time`, `ac`, `submit`) VALUES
('2019-03-25 00:00:00', 123, 1234),
('2019-03-26 00:00:00', 123, 12345),
('2019-03-27 00:00:00', 1234, 12345),
('2019-03-28 00:00:00', 1234, 12345),
('2019-03-31 14:45:00', 1, 2),
('2019-04-01 10:38:03', 0, 0),
('2019-04-02 22:43:52', 0, 0),
('2019-04-03 00:00:00', 0, 0),
('2019-04-06 12:16:27', 0, 0),
('2019-04-07 17:02:52', 0, 0),
('2019-04-08 13:29:20', 0, 0),
('2019-04-09 19:23:07', 0, 0),
('2019-04-10 00:00:01', 0, 0),
('2019-04-12 16:39:55', 0, 0),
('2019-09-26 08:58:00', 0, 0),
('2019-09-27 14:29:25', 0, 0),
('2019-09-28 09:11:53', 0, 0),
('2019-10-01 02:34:21', 0, 0),
('2019-10-14 00:00:00', 0, 0),
('2019-10-15 00:00:00', 0, 0),
('2019-10-13 00:00:00', 0, 0),
('2019-10-12 00:00:00', 0, 0),
('2019-10-11 00:00:00', 0, 0),
('2019-10-10 00:00:00', 0, 0),
('2019-10-09 00:00:00', 0, 0),
('2019-10-08 00:00:00', 0, 0),
('2019-10-07 00:00:00', 0, 0),
('2019-10-06 00:00:00', 0, 0),
('2019-10-05 00:00:00', 0, 0),
('2019-10-04 00:00:00', 0, 0),
('2019-10-03 00:00:00', 0, 0),
('2019-10-02 00:00:00', 0, 0);

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
  `ac_problem` text NOT NULL,
  `wa_problem` text NOT NULL,
  `wa_num` int(11) NOT NULL DEFAULT '0',
  `submit_data` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `nick`, `password`, `realname`, `school`, `major`, `class`, `contact`, `identity`, `desc`, `mail`, `ac_problem`, `wa_problem`, `wa_num`, `submit_data`, `status`) VALUES
(1, '123', 'eb5637cef0d0ba8a35a8091116d07561', '1', '1', '1', '14', '123', 0, NULL, '1@163.com', '[]', '[]', 0, '[]', 0),
(2, 'kdl12138', '123456', 'kdl', 'wut', 'cs', 'zy', '13282560058', 0, NULL, 'ssbljw@163.com', '[]', '[]', 0, '[]', 0);

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

DELIMITER $$
--
-- 事件
--
DROP EVENT `add_log`$$
CREATE DEFINER=`root`@`localhost` EVENT `add_log` ON SCHEDULE EVERY 1 DAY STARTS '2019-03-31 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
DECLARE ac, submitt int DEFAULT 0;
SELECT COUNT(*) into ac
FROM `submit` 
WHERE time > date_sub(now(), INTERVAL 1 DAY) 
AND time < CURRENT_TIMESTAMP
AND submit.status = "AC";

SELECT COUNT(*) into submitt
FROM `submit` 
WHERE time > date_sub(now(), INTERVAL 1 DAY) 
AND time < CURRENT_TIMESTAMP;
        
INSERT INTO `submit_log` VALUES(CURRENT_TIMESTAMP, ac, submitt);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
