-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: 2018-08-16 18:37:41
-- 服务器版本： 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openjudge_db`
--
CREATE DATABASE IF NOT EXISTS `openjudge_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `openjudge_db`;

-- --------------------------------------------------------

--
-- 表的结构 `contest`
--

CREATE TABLE `contest` (
  `contestId` int(11) NOT NULL,
  `contestName` varchar(1024) NOT NULL,
  `contestProblem` varchar(1024) NOT NULL,
  `contestStartTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `contestEndTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE `notice` (
  `noticeId` int(11) NOT NULL,
  `title` varchar(2000) NOT NULL,
  `href` varchar(2000) DEFAULT '#',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`noticeId`, `title`, `href`, `time`, `user`, `status`) VALUES
(1, 'test', '#', '2018-08-16 16:30:01', 1, 0),
(2, '欢迎加入武汉理工大学计算机学院ACM协会', '#', '2018-08-16 16:30:01', 1, 1),
(3, '武汉理工大学计算机学院ACM协会首届招新赛报名即将开始', '#', '2018-08-16 16:30:01', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `problem`
--

CREATE TABLE `problem` (
  `problemId` int(11) NOT NULL,
  `problemNo` int(6) NOT NULL,
  `problemTitle` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sign`
--

CREATE TABLE `sign` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `cardNo` varchar(10) NOT NULL,
  `class` varchar(30) NOT NULL,
  `qq` varchar(30) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `dorm` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `status` int(2) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `team`
--

CREATE TABLE `team` (
  `teamId` int(11) NOT NULL,
  `teamCNnick` varchar(1024) NOT NULL,
  `teamENnick` varchar(1024) NOT NULL,
  `teamPasswd` varchar(45) NOT NULL,
  `teamMail` varchar(100) NOT NULL,
  `teamPhone` varchar(12) NOT NULL,
  `teamPlays` varchar(1024) NOT NULL,
  `isOnsite` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `userType` int(1) NOT NULL DEFAULT '0',
  `userStat` int(1) NOT NULL DEFAULT '1',
  `userMail` varchar(100) DEFAULT NULL,
  `userPasswd` varchar(24) NOT NULL,
  `userNick` varchar(45) NOT NULL,
  `userName` varchar(45) NOT NULL,
  `userGender` int(1) NOT NULL,
  `userPhone` varchar(12) DEFAULT NULL,
  `userAlias` varchar(1024) DEFAULT NULL,
  `joinTime` timestamp NULL DEFAULT NULL,
  `exitTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`contestId`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`noticeId`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`problemId`),
  ADD UNIQUE KEY `problemNo` (`problemNo`);

--
-- Indexes for table `sign`
--
ALTER TABLE `sign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`teamId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `contest`
--
ALTER TABLE `contest`
  MODIFY `contestId` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `notice`
--
ALTER TABLE `notice`
  MODIFY `noticeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `problem`
--
ALTER TABLE `problem`
  MODIFY `problemId` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `sign`
--
ALTER TABLE `sign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `team`
--
ALTER TABLE `team`
  MODIFY `teamId` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
