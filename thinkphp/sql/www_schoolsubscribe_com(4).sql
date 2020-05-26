-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-05-15 17:37:21
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
  `stu_sex` varchar(1) NOT NULL COMMENT '性别',
  `stu_password` varchar(200) NOT NULL COMMENT '密码',
  `stu_email` varchar(30) NOT NULL COMMENT '邮箱',
  `stu_phone` varchar(11) NOT NULL COMMENT '电话'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='学生信息';

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`stu_id`, `stu_name`, `stu_sex`, `stu_password`, `stu_email`, `stu_phone`) VALUES
('170220309', 'hqf', '男', 'ce6d25d0b6f50daa283fcb120601826fae163c73', '134@qq.com', '12345678901'),
('170220308', 'mk', '男', 'ce6d25d0b6f50daa283fcb120601826fae163c73', '134@qq.com', '1234567890');

-- --------------------------------------------------------

--
-- 表的结构 `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `seq` int(4) NOT NULL,
  `stu_id` varchar(20) NOT NULL,
  `t_id` varchar(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `subscribe`
--

INSERT INTO `subscribe` (`id`, `seq`, `stu_id`, `t_id`) VALUES
(11, 2020005, '170220309', '100002'),
(10, 2020004, '170220309', '100002'),
(9, 2020008, '170220309', '100002');

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE `teacher` (
  `t_id` varchar(6) NOT NULL COMMENT '教师的ID',
  `t_name` varchar(10) NOT NULL COMMENT '姓名',
  `t_sex` varchar(1) NOT NULL COMMENT '性别',
  `t_age` int(3) NOT NULL COMMENT '年龄',
  `t_email` varchar(20) NOT NULL,
  `t_phone` varchar(11) NOT NULL COMMENT '手机号',
  `t_password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`t_id`, `t_name`, `t_sex`, `t_age`, `t_email`, `t_phone`, `t_password`) VALUES
('100003', 'wgb', '女', 22, '123@qq.com', '17852227354', '123'),
('100002', 'wgq', '', 25, '123@qq.com', '12345678901', 'ce6d25d0b6f50daa283fcb120601826fae163c73');

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
  `free` int(1) NOT NULL DEFAULT '0' COMMENT '是否被预约'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `time`
--

INSERT INTO `time` (`seq`, `date`, `time_seg`, `class`, `place`, `t_id`, `free`) VALUES
(2020009, '2020-05-28', '第四大节', '英语', 'N211', '100003', 0),
(2020006, '2020-05-30', '第三大节', 'C语言', 'G102', '100002', 0),
(3, '2020-05-05', '第一大节', '体育', 'M107', '100002', 0),
(2020004, '2020-05-12', '第一大节', '体育', 'M107', '100002', 2),
(2020005, '2020-05-13', '第一大节', '体育', 'M108', '100002', 2),
(2020007, '2020-05-27', '第四大节', '计算机体系结构', 'N221', '100002', 0),
(2020008, '2020-05-18', '第四大节', '数据结构', 'N345', '100002', 2);

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
  ADD PRIMARY KEY (`id`);

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
-- 使用表AUTO_INCREMENT `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `time`
--
ALTER TABLE `time`
  MODIFY `seq` int(4) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=2020013;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
