-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-11-18 14:25:34
-- 服务器版本： 5.7.14-log
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmarks`
--

-- --------------------------------------------------------

--
-- 表的结构 `bookmark`
--

CREATE TABLE `bookmark` (
  `username` varchar(16) NOT NULL,
  `bm_URL` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `bookmark`
--

INSERT INTO `bookmark` (`username`, `bm_URL`) VALUES
('asina', 'http://www.runoob.com/'),
('asina', 'http://www.w3school.com.cn/'),
('asina', 'http://www.runoob.com/html/html-tutorial.html'),
('erbao', 'http://www.runoob.com/'),
('asina', 'http://www.runoob.com/css/css-tutorial.html'),
('asina', 'http://www.w3school.com.cn/b.asp'),
('asina', 'http://www.w3school.com.cn/d.asp'),
('erbao', 'http://www.w3school.com.cn/');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `passwd` char(40) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`username`, `passwd`, `email`) VALUES
('asina', '10c2182eeb966fad5d202fd317d8f45601348f66', '2016968116@qq.com'),
('erbao', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2016968116@qq.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD KEY `username` (`username`),
  ADD KEY `bm_URL` (`bm_URL`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
