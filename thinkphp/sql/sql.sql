-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-05-07 18:12:51
-- 服务器版本： 5.7.26
-- PHP 版本： 5.6.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `www.schoolsubscribe.com`
--

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `stu_id` varchar(20) NOT NULL COMMENT '学生用户名',
  `stu_name` varchar(10) NOT NULL COMMENT '姓名',
  `stu_sex` tinyint(1) NOT NULL COMMENT '性别',
  `stu_num` varchar(9) NOT NULL COMMENT '学号',
  `stu_password` varchar(20) NOT NULL COMMENT '密码',
  `stu_email` varchar(30) NOT NULL COMMENT '邮箱',
  `stu_phone` varchar(11) NOT NULL COMMENT '电话'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生信息';

-- --------------------------------------------------------

--
-- 表的结构 `subscribe`
--

CREATE TABLE `subscribe` (
  `seq` int(4) NOT NULL,
  `stu_id` varchar(20) NOT NULL,
  `t_id` varchar(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE `teacher` (
  `t_id` varchar(6) NOT NULL COMMENT '教师的ID',
  `t_name` varchar(10) NOT NULL COMMENT '姓名',
  `t_sex` tinyint(1) NOT NULL COMMENT '性别',
  `t_age` int(3) NOT NULL COMMENT '年龄',
  `t_phone` varchar(11) NOT NULL COMMENT '手机号',
  `t_password` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`t_id`, `t_name`, `t_sex`, `t_age`, `t_phone`, `t_password`) VALUES
('100001', '王冠群', 0, 25, '17852227353', '123123');

-- --------------------------------------------------------

--
-- 表的结构 `time`
--

CREATE TABLE `time` (
  `seq` int(4) NOT NULL COMMENT '序号',
  `date` varchar(10) NOT NULL COMMENT '日期',
  `time_seg` varchar(10) NOT NULL COMMENT '时间段',
  `class` varchar(7) NOT NULL COMMENT '课程',
  `place` varchar(10) NOT NULL COMMENT '地点',
  `t_id` varchar(6) NOT NULL COMMENT '老师id',
  `free` tinyint(1) NOT NULL COMMENT '是否被预约'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `time`
--

INSERT INTO `time` (`seq`, `date`, `time_seg`, `class`, `place`, `t_id`, `free`) VALUES
(1, '20200507', '第一大节', '语文', 'M108', '100001', 0);

--
-- 转储表的索引
--

--
-- 表的索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stu_id`);

--
-- 表的索引 `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`seq`,`stu_id`,`t_id`);

--
-- 表的索引 `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`t_id`);

--
-- 表的索引 `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`seq`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `time`
--
ALTER TABLE `time`
  MODIFY `seq` int(4) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
