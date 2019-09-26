-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019-09-25 20:16:45
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_judge`
--
CREATE DATABASE IF NOT EXISTS `online_judge` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `online_judge`;

-- --------------------------------------------------------

--
-- 表的结构 `contest`
--

DROP TABLE IF EXISTS `contest`;
CREATE TABLE `contest` (
  `contest_id` int(11) NOT NULL,
  `contest_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `begin_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `frozen` double NOT NULL DEFAULT '0.2',
  `problems` varchar(512) NOT NULL,
  `colors` varchar(512) CHARACTER SET utf8mb4 NOT NULL COMMENT '题目对应颜色',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `find_password`
--

DROP TABLE IF EXISTS `find_password`;
CREATE TABLE `find_password` (
  `id` int(11) NOT NULL COMMENT '序号',
  `nick` varchar(255) NOT NULL COMMENT '用户名',
  `token` varchar(16) NOT NULL COMMENT '验证码',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
CREATE TABLE `group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(64) NOT NULL,
  `desc` text,
  `group_creator` int(11) DEFAULT NULL COMMENT 'user_id of creator',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `id` int(11) NOT NULL COMMENT '序号',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `link` varchar(128) NOT NULL DEFAULT '""' COMMENT '跳转链接',
  `begintime` datetime NOT NULL COMMENT '开始时间',
  `endtime` datetime NOT NULL COMMENT '结束时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`id`, `title`, `content`, `link`, `begintime`, `endtime`) VALUES
(1, 'test1', 'test', '""', '2019-03-28 00:00:00', '2019-03-31 00:00:00'),
(2, 'test2', 'test', '""', '2019-03-30 00:00:00', '2019-03-31 00:00:00'),
(3, 'test3', 'test', '""', '2019-03-27 00:00:00', '2019-03-28 00:00:00'),
(4, 'test4', 'test', '""', '2019-03-28 00:00:00', '2019-03-30 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
  `user_id` int(11) NOT NULL,
  `privilege` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `problem`
--

DROP TABLE IF EXISTS `problem`;
CREATE TABLE `problem` (
  `problem_id` int(11) NOT NULL,
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
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `rotation`
--

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE `rotation` (
  `id` int(11) NOT NULL COMMENT '序号',
  `title` varchar(32) NOT NULL COMMENT '标题',
  `url` varchar(128) NOT NULL COMMENT '链接',
  `status` tinyint(4) NOT NULL COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
CREATE TABLE `sample` (
  `sample_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `input` varchar(512) DEFAULT NULL,
  `output` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `submit`
--

DROP TABLE IF EXISTS `submit`;
CREATE TABLE `submit` (
  `id` int(11) NOT NULL COMMENT '序号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `nick` varchar(64) CHARACTER SET utf8mb4 NOT NULL COMMENT '用户昵称',
  `problem_id` int(11) NOT NULL COMMENT '题目编号',
  `contest_id` int(11) DEFAULT NULL COMMENT '比赛id',
  `source_code` text NOT NULL COMMENT '源代码',
  `language` tinyint(4) NOT NULL DEFAULT '1' COMMENT '语言',
  `status` varchar(16) NOT NULL COMMENT '状态',
  `time` varchar(16) NOT NULL,
  `memory` varchar(16) NOT NULL,
  `submit_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
CREATE TABLE `submit_log` (
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
('2019-04-12 16:39:55', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
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
  `state` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `nick`, `password`, `realname`, `school`, `major`, `class`, `contact`, `identity`, `desc`, `mail`, `ac_problem`, `wa_problem`, `wa_num`, `submit_data`, `state`) VALUES
(1, '123', '12345678', '1', '1', '1', '14', '123', 0, NULL, '1@163.com', '[]', '[]', 0, '[]', 0),
(2, 'kdl12138', '123456', 'kdl', 'wut', 'cs', 'zy', '13282560058', 0, NULL, 'ssbljw@163.com', '[]', '[]', 0, '[]', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`contest_id`);

--
-- Indexes for table `find_password`
--
ALTER TABLE `find_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`user_id`,`privilege`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`problem_id`);

--
-- Indexes for table `rotation`
--
ALTER TABLE `rotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sample`
--
ALTER TABLE `sample`
  ADD PRIMARY KEY (`sample_id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `submit`
--
ALTER TABLE `submit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`group_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `contest`
--
ALTER TABLE `contest`
  MODIFY `contest_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `find_password`
--
ALTER TABLE `find_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `group`
--
ALTER TABLE `group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `problem`
--
ALTER TABLE `problem`
  MODIFY `problem_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `rotation`
--
ALTER TABLE `rotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `sample`
--
ALTER TABLE `sample`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `submit`
--
ALTER TABLE `submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
