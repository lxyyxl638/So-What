-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-07-30 19:37:49
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
  `qid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `answer_vote`
--

INSERT INTO `answer_vote` (`uid`, `id`, `qid`, `aid`, `vote`, `date`) VALUES
(5, 7, 2, 5, 1, '2014-07-30 07:57:28'),
(1, 8, 2, 5, 1, '2014-07-30 08:28:11'),
(5, 9, 2, 14, 1, '2014-07-30 08:54:32'),
(5, 10, 7, 15, 1, '2014-07-30 11:01:38');

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
  `flushtime_of_answer_good` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `q2a_answer`
--

INSERT INTO `q2a_answer` (`id`, `uid`, `qid`, `content`, `email`, `realname`, `good`, `bad`, `date`, `flushtime_of_answer_good`) VALUES
(1, 1, 1, 'fdsjklafjdslk', '', '', 0, 0, '2014-07-29 00:27:07', '2014-07-30 10:57:52'),
(2, 1, 1, '我怎么知道', '', '', 0, 0, '2014-07-29 09:20:08', '2014-07-30 10:57:52'),
(3, 1, 1, '我怎么知道', '', '', 0, 0, '2014-07-29 09:20:09', '2014-07-30 10:57:52'),
(4, 5, 2, '你猜', '', '我是管理员', 0, 0, '2014-07-29 09:36:31', '2014-07-30 10:57:52'),
(5, 5, 2, '你猜', '', '我是管理员', 2, 0, '2014-07-30 08:28:11', '2014-07-30 10:57:52'),
(6, 5, 2, '只能说我输了', '', '我是管理员', 1, 0, '2014-07-30 05:08:04', '2014-07-30 10:57:52'),
(7, 5, 2, '这样遗憾或许更完美', '', '我是管理员', 0, 0, '2014-07-29 23:14:36', '2014-07-30 10:57:52'),
(8, 5, 2, '再没后场', '', '我是管理员', 0, 0, '2014-07-30 06:13:40', '2014-07-30 10:57:52'),
(9, 5, 2, '我怎么知道', '', '我是管理员', 0, 0, '2014-07-30 06:22:27', '2014-07-30 10:57:52'),
(10, 5, 6, '我怎么知道', '', '我是管理员', 0, 0, '2014-07-30 07:31:39', '2014-07-30 10:57:52'),
(11, 5, 5, '心碎的像街上的纸屑', '', '我是管理员', 0, 0, '2014-07-30 07:45:53', '2014-07-30 10:57:52'),
(12, 5, 5, '心碎的像街上的纸屑', '', '我是管理员', 0, 0, '2014-07-30 07:48:25', '2014-07-30 10:57:52'),
(14, 5, 2, '哈哈哈哈哈哈', '', '我是管理员', 1, 0, '2014-07-30 08:54:32', '2014-07-30 10:57:52'),
(15, 5, 7, '这样哈哈哈哈哈哈', '', '我是管理员', 1, 0, '2014-07-30 11:03:53', '2014-07-30 11:03:53'),
(16, 5, 5, '这样哈哈哈哈哈哈', '', '我是管理员', 0, 0, '2014-07-30 11:07:36', '2014-07-30 11:07:36');

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
  `flushtime_of_myquestion_new_answer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `q2a_question`
--

INSERT INTO `q2a_question` (`id`, `uid`, `email`, `realname`, `title`, `content`, `view_num`, `like_num`, `answer_num`, `date`, `flushtime_of_myquestion_new_answer`) VALUES
(1, 1, '', 'Don''t forget the meeting!Reminder', '0', '0', 1, 0, 3, '2014-07-29 15:20:09', '0000-00-00 00:00:00'),
(2, 1, '', 'Don''t forget the meeting!Reminder', '0', 'fdsjklafjdslk', 0, 0, 7, '2014-07-30 08:52:12', '0000-00-00 00:00:00'),
(3, 1, '', 'Don''t forget the meeting!Reminder', '明天是星期几', '如题', 0, 0, 0, '2014-07-29 08:17:01', '0000-00-00 00:00:00'),
(4, 1, '', 'Don''t forget the meeting!Reminder', '怎么处理失恋', '如题', 0, 0, 0, '2014-07-29 08:19:01', '0000-00-00 00:00:00'),
(5, 1, '', 'Don''t forget the meeting!Reminder', '如何泡妹子', '如题', 0, 0, 3, '2014-07-30 11:07:36', '2014-07-30 11:07:36'),
(6, 1, '', 'Don''t forget the meeting!Reminder', '如何泡妹子', '如题', 0, 0, 1, '2014-07-30 07:31:39', '0000-00-00 00:00:00'),
(7, 5, '', '我是管理员', '怎么哈哈哈哈', '这样哈哈哈哈哈哈', 0, 0, 1, '2014-07-30 11:29:29', '2014-07-30 11:29:29');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `realname`, `signupdate`, `lastlogin`, `lastloginfail`, `numloginfail`) VALUES
(1, '307571482@qq.com', '3t78DzktRP7z4Zlif5oIVUIIRxe5KcwQgVPmdzsk/3Z86B2jblOEYxKpN+0SfbmHOztcocg4fLrhrSC/H4lB4w==', 'Don''t forget the meeting!Reminder', '2014-07-28 03:01:07', '2014-07-30 08:28:06', '0000-00-00 00:00:00', 0),
(3, '30757148@qq.com', 'Rl4MZoQMU1sgVvWOrHwftK7NqLDC5yOJo8ADFRSVzx+MJQw7x+buVY1CnPiXc+jCOGvhI8xS/4zdq27T6tIJWQ==', 'Don''t forget the meeting!Reminder', '2014-07-28 03:08:01', '2014-07-28 03:08:01', '0000-00-00 00:00:00', 0),
(5, 'root@gmail.com', 'I5QatMxjT9071QYLf6rudKOyXHy/DGWoEiz6UN3RI73xx1O0hS33kF1nRjzAem4G/qLD8bgGQoSP57Q1irhp/g==', '我是管理员', '2014-07-29 00:47:49', '2014-07-30 08:29:49', '0000-00-00 00:00:00', 0),
(6, 'lxyyxl638@gmail.com', 'U0d8H495Iw1RDg+/qsfrbKF0DXhSMYpo+XZSlNj+cUWQjP7YNEwXjWkOsm0dqD9NEC4XHNaE667mosh5HvJNig==', '哦啊', '2014-07-29 03:41:36', '2014-07-29 03:41:36', '0000-00-00 00:00:00', 0),
(7, 'lxyyxl63@gmail.com', '4dg8a7FvWBzIKHhSNMVIRAAWHVNENw4HQaALtzMMHa1JssJWNEB07coo+SpxFyA0QJ7DxYyQNC+NtsYkpQuGCQ==', '哦啊', '2014-07-29 03:41:46', '2014-07-29 03:41:46', '0000-00-00 00:00:00', 0),
(8, 'lxyyxl6@gmail.com', '0EpdlzRE7AyeIkHGH6ME+7+Yjw+YHfOH56oku+76KvQ0OCHSJGdW1gHG0s3SHJ3k3HOQFpXvxl8pGKPwzpGkfA==', '哦啊', '2014-07-29 03:41:50', '2014-07-29 03:41:50', '0000-00-00 00:00:00', 0);

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
  `letter_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `letter_id` (`letter_id`),
  KEY `receiver` (`receiver`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `user_message`
--

INSERT INTO `user_message` (`id`, `receiver`, `sender`, `message`, `look`, `letter_id`, `date`) VALUES
(1, '307571482@qq.com', '307571482@qq.com', 'what the fuck', 0, 1, '2014-07-29 03:13:49'),
(2, 'root@gmail.com', '307571482@qq.com', 'what the fuck', 0, 2, '2014-07-29 03:14:31'),
(3, 'root@gmail.com', '307571482@qq.com', 'what the fuck', 0, 2, '2014-07-29 03:15:16'),
(4, 'root@gmail.com', '307571482@qq.com', 'what the fuck', 0, 2, '2014-07-29 03:15:19'),
(5, 'root@gmail.com', 'lxyyxl6@gmail.com', 'what the fuck1', 0, 3, '2014-07-29 03:43:36'),
(6, '307571482@qq.com', 'lxyyxl6@gmail.com', 'what the fuck1', 1, 4, '2014-07-29 11:34:37'),
(7, 'lxyyxl63@gmail.com', 'lxyyxl6@gmail.com', 'what the fuck1', 0, 5, '2014-07-29 03:46:44'),
(8, 'lxyyxl638@gmail.com', 'lxyyxl6@gmail.com', 'what the fuck10', 0, 6, '2014-07-29 03:48:06'),
(9, 'lxyyxl6@gmail.com', '307571482@qq.com', 'fasfaf', 1, 6, '2014-07-29 11:06:28'),
(10, 'lxyyxl6@gmail.com', '307571482@qq.com', 'fasfaf', 1, 6, '2014-07-29 11:06:28');

-- --------------------------------------------------------

--
-- 表的结构 `user_message_date`
--

CREATE TABLE IF NOT EXISTS `user_message_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid_1` int(11) NOT NULL,
  `uid_2` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `user_message_date`
--

INSERT INTO `user_message_date` (`id`, `uid_1`, `uid_2`, `date`) VALUES
(1, 1, 1, '0000-00-00 00:00:00'),
(2, 1, 5, '2014-07-29 03:15:19'),
(3, 5, 8, '2014-07-29 03:43:36'),
(4, 1, 8, '2014-07-29 03:46:32'),
(5, 7, 8, '2014-07-29 03:46:44'),
(6, 6, 8, '2014-07-29 03:48:05');

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
  `flushtime_of_new_answer` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `flushtime_of_answer_good` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `user_profile`
--

INSERT INTO `user_profile` (`id`, `uid`, `realname`, `photo`, `job`, `jobid`, `jobtime`, `city`, `jobplace`, `lastask`, `gender`, `description`, `flushtime_of_new_answer`, `flushtime_of_answer_good`) VALUES
(1, 1, 'Don''t forget the meeting!Reminder', '', 0, '0', '2014-07-29 14:22:27', '', '', '2014-07-29 08:22:27', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'Don''t forget the meeting!Reminder', '', 0, '0', '2014-07-29 14:22:27', '', '', '2014-07-29 08:22:27', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, 'Don''t forget the meeting!Reminder', '', 0, 'CS', '0000-00-00 00:00:00', '上海', '我是supery', '0000-00-00 00:00:00', 1, '我是supery', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5, '我是管理员', '', 0, NULL, '2014-07-30 10:51:57', '', '', '2014-07-30 10:51:56', 0, '', '2014-07-29 21:31:44', '2014-07-29 23:20:54'),
(6, 6, '哦啊', '', 0, NULL, '2014-07-29 09:41:36', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 7, '哦啊', '', 0, NULL, '2014-07-29 09:41:46', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 8, '哦啊', '', 0, NULL, '2014-07-29 09:41:50', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `user_question`
--

CREATE TABLE IF NOT EXISTS `user_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flushtime_of_new_answer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `user_question`
--

INSERT INTO `user_question` (`id`, `uid`, `qid`, `date`, `flushtime_of_new_answer`) VALUES
(4, 5, 2, '2014-07-29 10:10:46', '2014-07-30 11:05:11'),
(5, 5, 1, '2014-07-29 21:27:16', '2014-07-30 11:05:11'),
(7, 5, 6, '2014-07-30 07:31:23', '2014-07-30 11:05:11'),
(8, 5, 5, '2014-07-30 11:11:13', '2014-07-30 11:11:13');

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
-- 限制表 `user_message`
--
ALTER TABLE `user_message`
  ADD CONSTRAINT `user_message_ibfk_1` FOREIGN KEY (`letter_id`) REFERENCES `user_message_date` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
