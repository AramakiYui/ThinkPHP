-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-05-28 18:39:51
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
('170150112', '马恺', '男', '9c34bdee6d4dd89b968a86767c8b62701f5c0eba', 'makai@qq.com', '17863164987'),
('170150101', '马化腾', '男', '49f880c69816d5f42ef03b53a484fcdc1875259c', 'mahuateng@tencent.com', '13312345678'),
('170150102', '马云', '女', 'e2999e1a3806c06141643fc018e96434ff96204e', 'mayun@alibaba.com', '19764351334'),
('170220309', '郝青锋', '男', '426bc0213630b562403cd5dc119d92508564974d', 'haoqingfeng@qq.com', '13412345678');

-- --------------------------------------------------------

--
-- 表的结构 `subscribe`
--

CREATE TABLE `subscribe` (
  `seq` int(4) NOT NULL,
  `stu_id` varchar(20) NOT NULL,
  `t_id` varchar(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `subscribe`
--

INSERT INTO `subscribe` (`seq`, `stu_id`, `t_id`) VALUES
(2020002, '170220309', '100001'),
(2020006, '170150112', '100001'),
(2020007, '170220309', '100001'),
(2020010, '170150101', '100002'),
(2020011, '170150102', '100002'),
(2020012, '170150112', '100002'),
(2020014, '170150112', '100003'),
(2020015, '170150112', '100003');

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE `teacher` (
  `t_id` varchar(6) NOT NULL COMMENT '教师的ID',
  `t_name` varchar(10) NOT NULL COMMENT '姓名',
  `t_sex` varchar(1) NOT NULL COMMENT '性别',
  `t_age` int(3) NOT NULL COMMENT '年龄',
  `t_email` varchar(30) NOT NULL,
  `t_phone` varchar(11) NOT NULL COMMENT '手机号',
  `t_password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`t_id`, `t_name`, `t_sex`, `t_age`, `t_email`, `t_phone`, `t_password`) VALUES
('100002', '刘杨', '女', 30, 'liuyang@hit.edu.cn', '13412345678', 'b29e1639b2ef2a54cdc8f9c4e37aee33980ddc3c'),
('100003', '董开坤', '男', 30, 'dongkaikun@hit.edu.cn', '13412345678', '81d6879da17d714a06e98eda3e35114aaf617a39'),
('100001', '李春山', '男', 30, 'lichunshan@hit.edu.com', '18300000000', '12386666bb8c8dcec02ae9bfb299e9a816686fdc');

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
(2020007, '2020-5-29', '第一大节', '软件工程', 'M101', '100001', 2),
(2020011, '2020-05-30', '第三大节', '离散数学', 'G101', '100002', 2),
(2020001, '2020-05-12', '第一大节', 'C语言', 'M107', '100001', 1),
(2020002, '2020-05-13', '第一大节', '工数', 'M108', '100001', 3),
(2020010, '2020-05-29', '第四大节', '密码学', 'G101', '100002', 2),
(2020006, '2020-5-30', '第一大节', '软件工程', 'M101', '100001', 2),
(2020012, '2020-05-31', '第一大节', '密码学', 'M201', '100002', 2),
(2020013, '2020-05-11', '第一大节', '计算机系统安全', 'M201', '100003', 1),
(2020014, '2020-05-12', '第二大节', '计算机系统安全', 'M202', '100003', 3),
(2020015, '2020-06-03', '第二大节', '计算机系统安全', 'M202', '100003', 2);

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
  MODIFY `seq` int(4) NOT NULL AUTO_INCREMENT COMMENT '序号', AUTO_INCREMENT=2020016;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
