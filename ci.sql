-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-16 15:11:15
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
-- 表的结构 `q2a_answers`
--

CREATE TABLE IF NOT EXISTS `q2a_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL,
  `answer` text NOT NULL,
  `username` varchar(128) NOT NULL,
  `good` int(11) NOT NULL,
  `bad` int(11) NOT NULL,
  `date` varchar(20) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `q2a_answers`
--

INSERT INTO `q2a_answers` (`id`, `qid`, `answer`, `username`, `good`, `bad`, `date`, `title`) VALUES
(1, 1, '我怎么知道？', 'lxylxy', 1, 0, NULL, NULL),
(2, 3, '天涯何处无芳草，何必非在身边找', 'lxylxy', 2, 0, NULL, NULL),
(3, 1, '你猜', 'lxyyxl638', 0, 0, '13-07-14 16:53', '当今最红的职业'),
(4, 3, 'aaaaaa', 'lxyyxl638', 1, 0, '13-07-14 17:02', '失恋了怎么办'),
(5, 4, 'aaaaaaaaaaaaaaa', 'lxyyxl638', 0, 0, '13-07-14 17:02', '失恋了怎么办'),
(6, 7, '显然会啊', 'lxyyxl638', 0, 0, '13-07-14 17:15', '今晚阿根廷会赢吗'),
(7, 7, '会啊', 'lxyyxl638', 0, 0, '13-07-14 17:18', '今晚阿根廷会赢吗'),
(8, 8, '你猜', 'mochaking', 1, 0, '16-07-14 12:28', '怎么找到妹纸');

-- --------------------------------------------------------

--
-- 表的结构 `q2a_questions`
--

CREATE TABLE IF NOT EXISTS `q2a_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `answer_num` int(11) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL,
  `view_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `q2a_questions`
--

INSERT INTO `q2a_questions` (`id`, `username`, `realname`, `title`, `text`, `answer_num`, `date`, `view_num`) VALUES
(1, 'lxylxylxy', '0', '当今最红的职业', '如题', NULL, '13-07-14 9:17', NULL),
(2, 'lxylxylxy', '0', '你是谁', '我是你', NULL, '13-07-14 9:17', NULL),
(3, 'lxylxy', '0', '失恋了怎么办', '凉拌', NULL, '13-07-14 9:28', NULL),
(4, 'lxyyxl638', '0', '失恋了怎么办', '失恋了想跳天台', NULL, '13-07-14 16:53', NULL),
(5, 'lxyyxl638', '0', '我能成功吗', '如题', 0, '13-07-14 17:06', 3),
(6, 'lxyyxl638', '0', '你是谁', '', 0, '13-07-14 17:12', 0),
(7, 'lxyyxl638', '林小阳', '今晚阿根廷会赢吗', '如题', 1, '13-07-14 17:14', 2),
(8, 'mochaking', 'XQZ', '怎么找到妹纸', '怎么找到优质妹纸', 1, '16-07-14 12:28', 2);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `signupdate` varchar(20) DEFAULT NULL,
  `lastlogin` varchar(20) DEFAULT NULL,
  `lastloginfail` varchar(20) DEFAULT NULL,
  `numloginfail` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`uid`, `username`, `password`, `signupdate`, `lastlogin`, `lastloginfail`, `numloginfail`) VALUES
(1, 'lxyyxl638', 'rnYaTsw+DwiPQbbuJdzb1LmC9MCF7jfW5DezDTm6kVBPWxWCTVf4ITY5PSxqUp03TANMROMWO/Gif/Vj3XXmKg==', '13-07-14 15:45', '15-07-14 10:01', '0', 0),
(2, 'mochaking', 'oLnN/7ozj+Fziu0/WvsT0fjZ2Hrov88/5aRs9rPEM23CO96qacRvpKzqRTg7MrkkpdWK9BCUtpYaboWZlknoog==', '16-07-14 12:27', '16-07-14 12:27', '0', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `photo` varchar(128) NOT NULL,
  `lastask` varchar(20) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user_profile`
--

INSERT INTO `user_profile` (`id`, `uid`, `realname`, `email`, `photo`, `lastask`, `username`) VALUES
(1, 1, '林小阳', '0', '0', '13-07-14 17:14', 'lxyyxl638'),
(2, 2, 'XQZ', '0', '0', '16-07-14 12:28', 'mochaking');

--
-- 限制导出的表
--

--
-- 限制表 `q2a_answers`
--
ALTER TABLE `q2a_answers`
  ADD CONSTRAINT `q2a_answers_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `q2a_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
