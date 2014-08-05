-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-08-05 17:00:44
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ci`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL DEFAULT '未填写',
  `password` varchar(128) NOT NULL DEFAULT '0',
  `realname` varchar(128) NOT NULL DEFAULT '未填写',
  `signupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastloginfail` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numloginfail` int(11) NOT NULL DEFAULT '0',
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `realname`, `signupdate`, `lastlogin`, `lastloginfail`, `numloginfail`, `active`) VALUES
(1, 'root@gmail.com', 'eSGZIPfDCyTN2BJ9CB9ZYrNsNjTn2L584dvijuMyq7eu53saTiuyA+1vsPSBd8JvMD9qJ8c6XDMdX5jhbZDqqg==', 'hahah哈哈哈', '2014-08-05 08:07:33', '2014-08-05 08:07:33', '2014-08-05 08:07:33', 0, 'Y'),
(2, 'root1@gmail.com', 'zb3Yb/nlISdm01m2gyWKMrmPbN+DCnIhfO7uM0jYSTr1r/dFnKcJtnOk2Ubu2SHROlRcCyVbFH2LhG2Xu1/c2w==', 'hahah哈哈哈', '2014-08-05 08:09:47', '2014-08-05 08:09:47', '2014-08-05 08:09:47', 0, 'Y');

-- --------------------------------------------------------

--
-- 表的结构 `user_city`
--

CREATE TABLE IF NOT EXISTS `user_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(128) NOT NULL DEFAULT '未填写',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `user_city`
--

INSERT INTO `user_city` (`id`, `city`) VALUES
(1, '上海'),
(2, '广东'),
(3, '北京');

-- --------------------------------------------------------

--
-- 表的结构 `user_college`
--

CREATE TABLE IF NOT EXISTS `user_college` (
  `city` varchar(128) NOT NULL DEFAULT '未填写',
  `college` varchar(128) NOT NULL DEFAULT '未填写',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_company`
--

CREATE TABLE IF NOT EXISTS `user_company` (
  `city` varchar(128) NOT NULL DEFAULT '未填写',
  `company` varchar(128) NOT NULL DEFAULT '未填写',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_major`
--

CREATE TABLE IF NOT EXISTS `user_major` (
  `major` varchar(128) NOT NULL DEFAULT '未填写',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user_major`
--

INSERT INTO `user_major` (`major`, `id`) VALUES
('CS', 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_position`
--

CREATE TABLE IF NOT EXISTS `user_position` (
  `position` varchar(32) NOT NULL DEFAULT '未填写',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `gender` enum('F','M') NOT NULL DEFAULT 'F',
  `realname` varchar(128) NOT NULL DEFAULT '未填写',
  `photo_upload` enum('Y','N') NOT NULL DEFAULT 'N',
  `occupation` enum('S','W') NOT NULL DEFAULT 'S',
  `job` varchar(128) NOT NULL DEFAULT '未填写',
  `jobtime` int(11) NOT NULL DEFAULT '0',
  `city` varchar(128) NOT NULL DEFAULT '未填写',
  `jobplace` varchar(128) NOT NULL DEFAULT '未填写',
  `bio` varchar(256) NOT NULL DEFAULT '未填写',
  `lastask` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user_profile`
--

INSERT INTO `user_profile` (`id`, `uid`, `gender`, `realname`, `photo_upload`, `occupation`, `job`, `jobtime`, `city`, `jobplace`, `bio`, `lastask`) VALUES
(1, 2, 'F', 'hahah哈哈哈', 'N', 'S', 'CS', 2012, 'Shanghai', 'SJTU', 'What the fuck', '2014-08-05 08:09:47');

--
-- 限制导出的表
--

--
-- 限制表 `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
