-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `online_judge`;

DROP TABLE IF EXISTS `authority`;
CREATE TABLE `authority` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `authority` (`id`, `name`, `enabled`) VALUES
(1,	'add',	1),
(2,	'delete',	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `enabled` = VALUES(`enabled`);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `contest`;
CREATE TABLE `contest` (
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

INSERT INTO `contest` (`contest_id`, `contest_name`, `begin_time`, `end_time`, `frozen`, `problems`, `colors`, `status`) VALUES
(1000,	'test',	'2019-10-15 08:12:47',	'2019-10-15 08:12:47',	0.2,	'[\"1001\",\"1002\"]',	'[\"#FFFFFF\",\"#FF00FF\"]',	1),
(1001,	'test',	'2019-10-16 08:12:47',	'2019-10-17 08:12:47',	0.2,	'[\"1001\",\"1002\"]',	'[\"#FFFFFF\",\"#FF00FF\"]',	1),
(1002,	'test1',	'2019-12-31 16:00:00',	'2020-01-01 16:00:00',	0,	'[\"1003\"]',	'[\"#FFFFFF\"]',	1)
ON DUPLICATE KEY UPDATE `contest_id` = VALUES(`contest_id`), `contest_name` = VALUES(`contest_name`), `begin_time` = VALUES(`begin_time`), `end_time` = VALUES(`end_time`), `frozen` = VALUES(`frozen`), `problems` = VALUES(`problems`), `colors` = VALUES(`colors`), `status` = VALUES(`status`);

DROP TABLE IF EXISTS `contest_users`;
CREATE TABLE `contest_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL COMMENT '比赛序号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `contest_users` (`id`, `contest_id`, `user_id`) VALUES
(1,	1001,	1),
(2,	1001,	2),
(3,	1002,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `contest_id` = VALUES(`contest_id`), `user_id` = VALUES(`user_id`);

DROP TABLE IF EXISTS `discuss`;
CREATE TABLE `discuss` (
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

INSERT INTO `discuss` (`id`, `contest_id`, `problem_id`, `user_id`, `title`, `content`, `time`, `status`) VALUES
(1,	1001,	1001,	1,	'wyhsb',	'wyhsb',	'2019-10-13 15:49:45',	1),
(2,	1001,	1001,	1,	'wyhsb',	'wyhsb',	'2019-10-13 15:56:46',	0),
(3,	1001,	1001,	2,	'ssss',	'wyhsb',	'2019-10-13 15:59:34',	0),
(4,	1001,	1001,	1,	'ssss',	'wyhsb',	'2019-10-13 16:00:31',	8),
(5,	1002,	1001,	1,	'ssss',	'wyhsb',	'2019-10-13 16:00:31',	8),
(6,	0,	1001,	1,	'ssss',	'wyhsb',	'2019-10-13 16:00:31',	8)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `contest_id` = VALUES(`contest_id`), `problem_id` = VALUES(`problem_id`), `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `content` = VALUES(`content`), `time` = VALUES(`time`), `status` = VALUES(`status`);

DROP TABLE IF EXISTS `find_password`;
CREATE TABLE `find_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `nick` varchar(255) NOT NULL COMMENT '用户名',
  `token` varchar(16) NOT NULL COMMENT '验证码',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `find_password` (`id`, `nick`, `token`, `time`, `state`) VALUES
(1,	'kdl12138',	'wTzBAVKdEu',	'2019-07-11 08:38:21',	1),
(2,	'kdl12138',	'c7YmY3Dx3Q',	'2019-07-11 08:46:05',	1),
(3,	'kdl12138',	'hkmranXaGp',	'2019-07-11 08:46:49',	1),
(4,	'kdl12138',	'w4uRYf7Wsj',	'2019-07-11 08:47:36',	1),
(5,	'kdl12138',	'ypN8LkmmkH',	'2019-07-11 08:47:39',	1),
(6,	'kdl12138',	'v48VXkTCAN',	'2019-07-11 08:47:59',	1),
(7,	'kdl12138',	'pYD42DzGeY',	'2019-07-11 08:48:36',	1),
(8,	'kdl12138',	'UYwWrcDA8s',	'2019-07-11 08:49:04',	1),
(9,	'kdl12138',	'2yzzRGVbzf',	'2019-07-11 08:52:01',	1),
(10,	'kdl1213',	'suWTeVCFEf',	'2019-07-11 08:52:31',	1),
(11,	'kdl1213',	'W6tQU4wE7u',	'2019-07-11 08:53:27',	1),
(12,	'kdl1213',	'jHUhCF8VHp',	'2019-07-11 08:53:36',	1),
(13,	'kdl1213',	'hBpzU7x7qV',	'2019-07-11 08:54:13',	0),
(14,	'kdl12138',	'K6jRBHYPT5',	'2019-07-11 08:54:17',	0)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `nick` = VALUES(`nick`), `token` = VALUES(`token`), `time` = VALUES(`time`), `state` = VALUES(`state`);

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(64) NOT NULL,
  `desc` text,
  `group_creator` int(11) DEFAULT NULL COMMENT 'user_id of creator',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `knowledge`;
CREATE TABLE `knowledge` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `point` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `knowledge` (`id`, `name`, `point`) VALUES
(1,	'tree',	1),
(3,	'force',	1),
(4,	'graph',	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `point` = VALUES(`point`);

DROP TABLE IF EXISTS `knowledge_relationship`;
CREATE TABLE `knowledge_relationship` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(8) NOT NULL,
  `pre_knowledge_id` int(8) NOT NULL,
  `is_core` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `knowledge_id` (`knowledge_id`),
  KEY `pre_knowledge_id` (`pre_knowledge_id`),
  CONSTRAINT `knowledge_relationship_ibfk_1` FOREIGN KEY (`knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE,
  CONSTRAINT `knowledge_relationship_ibfk_2` FOREIGN KEY (`pre_knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `knowledge_relationship` (`id`, `knowledge_id`, `pre_knowledge_id`, `is_core`) VALUES
(2,	3,	1,	0),
(3,	3,	4,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `knowledge_id` = VALUES(`knowledge_id`), `pre_knowledge_id` = VALUES(`pre_knowledge_id`), `is_core` = VALUES(`is_core`);

DROP TABLE IF EXISTS `knowledge__problem`;
CREATE TABLE `knowledge__problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `knowledge_id` int(8) NOT NULL,
  `is_core` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `problem_id` (`problem_id`),
  KEY `knowledge_id` (`knowledge_id`),
  CONSTRAINT `knowledge__problem_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `problem` (`problem_id`) ON DELETE CASCADE,
  CONSTRAINT `knowledge__problem_ibfk_2` FOREIGN KEY (`knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `knowledge__problem` (`id`, `problem_id`, `knowledge_id`, `is_core`) VALUES
(1,	1001,	3,	0),
(3,	1002,	1,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `problem_id` = VALUES(`problem_id`), `knowledge_id` = VALUES(`knowledge_id`), `is_core` = VALUES(`is_core`);

DROP TABLE IF EXISTS `knowledge__tag`;
CREATE TABLE `knowledge__tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowledge_id` int(8) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `knowledge_id` (`knowledge_id`),
  CONSTRAINT `knowledge__tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `knowledge__tag_ibfk_3` FOREIGN KEY (`knowledge_id`) REFERENCES `knowledge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `knowledge__tag` (`id`, `knowledge_id`, `tag_id`) VALUES
(1,	1,	1),
(2,	1,	2),
(4,	3,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `knowledge_id` = VALUES(`knowledge_id`), `tag_id` = VALUES(`tag_id`);

DROP TABLE IF EXISTS `knowledge__user`;
CREATE TABLE `knowledge__user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `knowledge_doing` json DEFAULT NULL,
  `knowledge_done` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `knowledge__user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `knowledge__user` (`id`, `user_id`, `knowledge_doing`, `knowledge_done`) VALUES
(9,	1,	'[\"tree\"]',	'[{\"name\": \"graph\", \"score\": 100}]')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `knowledge_doing` = VALUES(`knowledge_doing`), `knowledge_done` = VALUES(`knowledge_done`);

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `link` varchar(128) NOT NULL DEFAULT '""' COMMENT '跳转链接',
  `begintime` datetime NOT NULL COMMENT '开始时间',
  `endtime` datetime NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `notice` (`id`, `title`, `content`, `link`, `begintime`, `endtime`) VALUES
(1,	'test1',	'test',	'\"\"',	'2019-03-28 00:00:00',	'2019-03-31 00:00:00'),
(2,	'test2',	'test',	'\"\"',	'2019-03-30 00:00:00',	'2019-03-31 00:00:00'),
(3,	'test3',	'test',	'\"\"',	'2019-03-27 00:00:00',	'2019-03-28 00:00:00'),
(4,	'test4',	'test',	'\"\"',	'2019-03-28 00:00:00',	'2019-03-30 00:00:00')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `content` = VALUES(`content`), `link` = VALUES(`link`), `begintime` = VALUES(`begintime`), `endtime` = VALUES(`endtime`);

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
  `user_id` int(11) NOT NULL,
  `privilege` varchar(33) NOT NULL,
  PRIMARY KEY (`user_id`,`privilege`),
  CONSTRAINT `privilege_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `problem`;
CREATE TABLE `problem` (
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

INSERT INTO `problem` (`problem_id`, `title`, `background`, `describe`, `input_format`, `output_format`, `hint`, `public`, `source`, `ac`, `wa`, `tag`, `status`) VALUES
(1001,	'wyhsb',	'# wyhsb\n\n* s\n* s\n* wyhsb',	'~~wyh~~sb',	'* wyhsb',	'## wyhsb',	'wyhsb\n\n* * *\n\n',	1,	'',	0,	0,	'[\"1\",\"2\"]',	2),
(1002,	'wyhsb',	'wyhsb',	'wyhsb',	'wyhsb',	'wyhsb',	'wyhsb',	1,	NULL,	0,	0,	NULL,	2),
(1003,	'test',	'test~~t~~',	'test',	'test',	'test',	'test',	1,	'test',	0,	0,	'',	2)
ON DUPLICATE KEY UPDATE `problem_id` = VALUES(`problem_id`), `title` = VALUES(`title`), `background` = VALUES(`background`), `describe` = VALUES(`describe`), `input_format` = VALUES(`input_format`), `output_format` = VALUES(`output_format`), `hint` = VALUES(`hint`), `public` = VALUES(`public`), `source` = VALUES(`source`), `ac` = VALUES(`ac`), `wa` = VALUES(`wa`), `tag` = VALUES(`tag`), `status` = VALUES(`status`);

DROP TABLE IF EXISTS `reply`;
CREATE TABLE `reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discuss_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `reply` (`id`, `discuss_id`, `user_id`, `content`, `time`) VALUES
(1,	1,	1,	'wyhqssb',	'2019-10-13 15:52:12'),
(2,	1,	1,	'wyhsb',	'2019-10-13 16:02:05'),
(3,	1,	1,	'wyhsb',	'2019-10-13 16:02:43')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `discuss_id` = VALUES(`discuss_id`), `user_id` = VALUES(`user_id`), `content` = VALUES(`content`), `time` = VALUES(`time`);

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `role_group`;
CREATE TABLE `role_group` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `authority` json DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `user_num` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `role_group` (`id`, `group_name`, `authority`, `enabled`, `user_num`) VALUES
(2,	'admin',	'{\"auth\": []}',	1,	0),
(3,	'problemEditor',	'{\"auth\": []}',	1,	0),
(4,	'super',	'{\"auth\": []}',	1,	1),
(5,	'guest',	'{\"auth\": []}',	1,	0)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `group_name` = VALUES(`group_name`), `authority` = VALUES(`authority`), `enabled` = VALUES(`enabled`), `user_num` = VALUES(`user_num`);

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE `rotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `title` varchar(32) NOT NULL COMMENT '标题',
  `url` varchar(128) NOT NULL COMMENT '链接',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `rotation` (`id`, `title`, `url`, `status`) VALUES
(1,	'test',	'xxx',	1),
(2,	'test',	'xxxx',	0),
(3,	'test',	'xxxxx',	1),
(4,	'test',	'xxxx',	1),
(5,	'test',	'xxxxx',	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `url` = VALUES(`url`), `status` = VALUES(`status`);

DROP TABLE IF EXISTS `sample`;
CREATE TABLE `sample` (
  `sample_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `input` varchar(512) DEFAULT NULL,
  `output` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sample_id`),
  KEY `problem_id` (`problem_id`),
  CONSTRAINT `sample_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `problem` (`problem_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sample` (`sample_id`, `problem_id`, `input`, `output`) VALUES
(1,	1001,	'wyhsb',	'wyhsb'),
(2,	1001,	'wyhsb',	'wyhsb')
ON DUPLICATE KEY UPDATE `sample_id` = VALUES(`sample_id`), `problem_id` = VALUES(`problem_id`), `input` = VALUES(`input`), `output` = VALUES(`output`);

DROP TABLE IF EXISTS `submit`;
CREATE TABLE `submit` (
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

INSERT INTO `submit` (`id`, `user_id`, `nick`, `problem_id`, `contest_id`, `source_code`, `language`, `status`, `time`, `memory`, `submit_time`) VALUES
(1,	1,	'',	123,	0,	'123',	1,	'1',	0,	0,	'2019-03-31 14:09:47'),
(2,	123,	'',	123,	1001,	'122',	1,	'2',	0,	0,	'2019-03-31 20:10:06'),
(3,	1,	'',	1001,	1001,	'',	1,	'AC',	0,	0,	'2019-03-31 13:00:00'),
(4,	1,	'',	1002,	1001,	'',	1,	'WA',	0,	0,	'2019-03-31 13:00:00'),
(5,	2,	'',	1002,	1001,	'',	1,	'WA',	0,	0,	'2019-03-31 13:00:00')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `nick` = VALUES(`nick`), `problem_id` = VALUES(`problem_id`), `contest_id` = VALUES(`contest_id`), `source_code` = VALUES(`source_code`), `language` = VALUES(`language`), `status` = VALUES(`status`), `time` = VALUES(`time`), `memory` = VALUES(`memory`), `submit_time` = VALUES(`submit_time`);

DROP TABLE IF EXISTS `submit_log`;
CREATE TABLE `submit_log` (
  `time` datetime NOT NULL,
  `ac` int(6) NOT NULL,
  `submit` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `submit_log` (`time`, `ac`, `submit`) VALUES
('2019-03-25 00:00:00',	123,	1234),
('2019-03-26 00:00:00',	123,	12345),
('2019-03-27 00:00:00',	1234,	12345),
('2019-03-28 00:00:00',	1234,	12345),
('2019-03-31 14:45:00',	1,	2),
('2019-04-01 10:38:03',	0,	0),
('2019-04-02 22:43:52',	0,	0),
('2019-04-03 00:00:00',	0,	0),
('2019-04-06 12:16:27',	0,	0),
('2019-04-07 17:02:52',	0,	0),
('2019-04-08 13:29:20',	0,	0),
('2019-04-09 19:23:07',	0,	0),
('2019-04-10 00:00:01',	0,	0),
('2019-04-12 16:39:55',	0,	0),
('2019-09-26 08:58:00',	0,	0),
('2019-09-27 14:29:25',	0,	0),
('2019-09-28 09:11:53',	0,	0),
('2019-10-01 02:34:21',	0,	0),
('2019-10-14 00:00:00',	0,	0),
('2019-10-15 00:00:00',	0,	0),
('2019-10-13 00:00:00',	0,	0),
('2019-10-12 00:00:00',	0,	0),
('2019-10-11 00:00:00',	0,	0),
('2019-10-10 00:00:00',	0,	0),
('2019-10-09 00:00:00',	0,	0),
('2019-10-08 00:00:00',	0,	0),
('2019-10-07 00:00:00',	0,	0),
('2019-10-06 00:00:00',	0,	0),
('2019-10-05 00:00:00',	0,	0),
('2019-10-04 00:00:00',	0,	0),
('2019-10-03 00:00:00',	0,	0),
('2019-10-02 00:00:00',	0,	0)
ON DUPLICATE KEY UPDATE `time` = VALUES(`time`), `ac` = VALUES(`ac`), `submit` = VALUES(`submit`);

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '标签序号',
  `name` varchar(64) NOT NULL COMMENT '标签名字',
  `description` varchar(200) NOT NULL COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '标签状态(0-禁用,1-正常)',
  `color` varchar(16) NOT NULL DEFAULT '#FFFFFF' COMMENT '标签颜色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tag` (`id`, `name`, `description`, `status`, `color`) VALUES
(1,	'贪心',	'瞎吉儿搞',	1,	'#7E42A1'),
(2,	'数学',	'ljw的最爱',	1,	''),
(3,	'暴力',	'',	1,	'#4FB21A'),
(4,	'Floyd',	'alskfjalkgjlajsg',	1,	'')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `description` = VALUES(`description`), `status` = VALUES(`status`), `color` = VALUES(`color`);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
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

INSERT INTO `users` (`user_id`, `nick`, `password`, `realname`, `school`, `major`, `class`, `contact`, `identity`, `desc`, `mail`, `status`, `role_group`) VALUES
(1,	'123',	'eb5637cef0d0ba8a35a8091116d07561',	'1',	'1',	'1',	'14',	'123',	0,	NULL,	'1@163.com',	0,	'null'),
(2,	'kdl12138',	'87d9bb400c0634691f0e3baaf1e2fd0d',	'kdl',	'wut',	'cs',	'zy',	'13282560058',	3,	'1234',	'ssbljw@163.com',	0,	'null'),
(3,	'lxh001',	'19991107',	'1',	'1',	'1',	'1',	'1',	3,	'111',	'1',	0,	'{\"group\": [\"super\"]}'),
(4,	'kdl12137',	'87d9bb400c0634691f0e3baaf1e2fd0d',	'123',	'123',	'3123',	'123',	'13282560058',	0,	'123',	'ssbljw@163.com',	0,	'[]')
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `nick` = VALUES(`nick`), `password` = VALUES(`password`), `realname` = VALUES(`realname`), `school` = VALUES(`school`), `major` = VALUES(`major`), `class` = VALUES(`class`), `contact` = VALUES(`contact`), `identity` = VALUES(`identity`), `desc` = VALUES(`desc`), `mail` = VALUES(`mail`), `status` = VALUES(`status`), `role_group` = VALUES(`role_group`);

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_group_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `privilege` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `user_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2020-02-28 03:44:13
