-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 08 月 22 日 17:30
-- 伺服器版本： 10.4.20-MariaDB
-- PHP 版本： 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `proj`
--

-- --------------------------------------------------------

--
-- 資料表結構 `invitation`
--

CREATE TABLE `invitation` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `invitation`
--

INSERT INTO `invitation` (`sid`, `name`, `email`, `message`) VALUES
(4, '王頑皮', '1959@gmail.com', '快快報到2'),
(5, '林明明', '82727hjhd@jcjc.com', '小專順利'),
(8, '亞洲統神', '30678@30678.com', 'Toyz的狗'),
(9, '王小明', '6969669@guy.com', '可惡的武漢肺炎'),
(10, '李好', '3399889@jdhh.cihi', '好麻煩喔@@'),
(12, '王八蛋', '874747474@jhdhdd.djdjdj', '天竺鼠車車'),
(13, '王八蛋2', '847474@jhdhdd.dj', '天竺鼠車車2'),
(14, '再度測試', '87654@192728.ckcc', '會怎麼樣呢'),
(15, '亞洲統神', '123@999.com', '亂七八糟'),
(17, '測試2', '30678@gmail.com', '30678'),
(19, '亞洲統神', '123@999.com', '吃罐頭喔'),
(20, '肥羊', '30678@30678.com', '眼睛好了喔！'),
(21, '亞洲統神', '123@999.com', 'Toyz的狗，統神的貓'),
(22, '亞洲統神', '123@999.com', 'Toyz的狗，統神的貓'),
(26, '幕之內', 'ammm@kjkj.com', '可以寫入嗎？');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`sid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `invitation`
--
ALTER TABLE `invitation`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
