-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-29 02:32:52
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
-- 表的结构 `answer_vote`
--

CREATE TABLE IF NOT EXISTS `answer_vote` (
  `uid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `q2a_answer`
--

CREATE TABLE IF NOT EXISTS `q2a_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `content` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `good` int(11) NOT NULL,
  `bad` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `q2a_answer`
--

INSERT INTO `q2a_answer` (`id`, `uid`, `qid`, `content`, `email`, `realname`, `good`, `bad`, `date`) VALUES
(1, 1, 1, 'fdsjklafjdslk', '', '', 0, 0, '2014-07-29 00:27:07');

-- --------------------------------------------------------

--
-- 表的结构 `q2a_question`
--

CREATE TABLE IF NOT EXISTS `q2a_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `view_num` int(11) NOT NULL,
  `like_num` int(11) NOT NULL,
  `answer_num` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `q2a_question`
--

INSERT INTO `q2a_question` (`id`, `uid`, `email`, `realname`, `title`, `content`, `view_num`, `like_num`, `answer_num`, `date`) VALUES
(1, 1, '', 'Don''t forget the meeting!Reminder', '0', '0', 1, 0, 1, '2014-07-29 00:24:33'),
(2, 1, '', 'Don''t forget the meeting!Reminder', '0', 'fdsjklafjdslk', 0, 0, 0, '2014-07-28 18:18:44');

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tag_question`
--

CREATE TABLE IF NOT EXISTS `tag_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `signupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastloginfail` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `numloginfail` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `realname`, `signupdate`, `lastlogin`, `lastloginfail`, `numloginfail`) VALUES
(1, '307571482@qq.com', '3t78DzktRP7z4Zlif5oIVUIIRxe5KcwQgVPmdzsk/3Z86B2jblOEYxKpN+0SfbmHOztcocg4fLrhrSC/H4lB4w==', 'Don''t forget the meeting!Reminder', '2014-07-28 03:01:07', '2014-07-28 18:04:06', '0000-00-00 00:00:00', 0),
(3, '30757148@qq.com', 'Rl4MZoQMU1sgVvWOrHwftK7NqLDC5yOJo8ADFRSVzx+MJQw7x+buVY1CnPiXc+jCOGvhI8xS/4zdq27T6tIJWQ==', 'Don''t forget the meeting!Reminder', '2014-07-28 03:08:01', '2014-07-28 03:08:01', '0000-00-00 00:00:00', 0),
(4, 'root@gmail.com', '/o8Cz7l4eAIZZFOaMBI8zQVVjP+0SFe1emOOSJdgOf6BMN80F9+0wXqTISdGscpvJJKjpsA7mChd5UgbxPdgfA==', '我是管理员', '2014-07-28 18:31:33', '2014-07-28 18:32:03', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_company`
--

CREATE TABLE IF NOT EXISTS `user_company` (
  `city` varchar(128) NOT NULL,
  `company` varchar(128) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  KEY `company` (`company`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_job`
--

CREATE TABLE IF NOT EXISTS `user_job` (
  `job` varchar(32) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `job` (`job`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_major`
--

CREATE TABLE IF NOT EXISTS `user_major` (
  `major` varchar(128) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `major` (`major`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user_major`
--

INSERT INTO `user_major` (`major`, `id`) VALUES
('CS', 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_message`
--

CREATE TABLE IF NOT EXISTS `user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(128) NOT NULL,
  `sender` varchar(128) NOT NULL,
  `message` varchar(256) NOT NULL,
  `look` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `photo` varchar(128) NOT NULL,
  `job` int(11) NOT NULL,
  `jobid` varchar(20) DEFAULT NULL,
  `jobtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city` varchar(128) NOT NULL,
  `jobplace` varchar(128) NOT NULL,
  `lastask` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gender` int(11) NOT NULL,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `user_profile`
--

INSERT INTO `user_profile` (`id`, `uid`, `realname`, `photo`, `job`, `jobid`, `jobtime`, `city`, `jobplace`, `lastask`, `gender`, `description`) VALUES
(1, 1, 'Don''t forget the meeting!Reminder', '', 0, '0', '2014-07-29 00:18:44', '', '', '2014-07-28 18:18:44', 0, ''),
(2, 1, 'Don''t forget the meeting!Reminder', '', 0, '0', '2014-07-29 00:18:44', '', '', '2014-07-28 18:18:44', 0, ''),
(3, 3, 'Don''t forget the meeting!Reminder', '', 0, 'CS', '0000-00-00 00:00:00', '上海', '我是supery', '0000-00-00 00:00:00', 1, '我是supery'),
(4, 4, '我是管理员', '', 0, NULL, '2014-07-29 00:31:33', '', '', '0000-00-00 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `user_school`
--

CREATE TABLE IF NOT EXISTS `user_school` (
  `city` varchar(128) NOT NULL,
  `school` varchar(128) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  KEY `school` (`school`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_tag`
--

CREATE TABLE IF NOT EXISTS `user_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 限制导出的表
--

--
-- 限制表 `q2a_answer`
--
ALTER TABLE `q2a_answer`
  ADD CONSTRAINT `q2a_answer_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `q2a_question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
