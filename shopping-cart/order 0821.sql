-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-08-21 16:24:01
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
-- 資料庫: `meff19`
--

-- --------------------------------------------------------

--
-- 資料表結構 `order`
--

CREATE TABLE `order` (
  `sid` int(11) NOT NULL COMMENT '訂單編號',
  `memberID` varchar(255) NOT NULL COMMENT '會員ID',
  `name` varchar(255) NOT NULL COMMENT '會員姓名',
  `mobile` varchar(255) NOT NULL COMMENT '手機',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `orderprice` varchar(255) NOT NULL COMMENT '訂單總價',
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `order`
--

INSERT INTO `order` (`sid`, `memberID`, `name`, `mobile`, `address`, `orderprice`, `create_at`) VALUES
(1, '1', '陳小明', '0977777777', '台北市', '1200', '2021-08-15 11:29:03'),
(2, '2', '王小明', '0911111111', '新北市', '1000', '2021-08-15 11:57:34'),
(3, '5', '王小明2', '0911111111', '新北市', '1000', '2021-08-15 11:57:34'),
(4, '10', '李志年', '0905456789', '新北市', '800', '2021-08-15 11:57:34'),
(5, '3', '陳柏念', '0915454597', '新北市', '1000', '2021-08-15 11:57:34'),
(6, '6', '陳曉安', '091546785', '新北市', '1100', '2021-08-15 11:57:34'),
(10, '7', '郭志翔', '0911115142', '新北市', '1000', '2021-08-15 11:57:34'),
(11, '7', '蔡文宏', '09020902', '高雄市', '1120', '2021-08-15 11:57:34'),
(15, '3', '1680', 'fdgdf', 'dfgdfg', 'dfg', '2021-08-19 15:40:13'),
(21, '1', '陳小明', '0977777777', '台北市', '5555', '2021-08-19 19:26:37'),
(40, '4', '王小明', '0900-111-111', '台南市', '5560', '2021-08-20 12:48:28'),
(47, '4', '王小明', '0900-111-111', '台南市', '200', '2021-08-20 15:07:57'),
(53, '5', '李世昌3', '0933-666-888', '台北市', '2000', '2021-08-21 20:44:04'),
(54, '12', '李大仁', '0911-222-444', '', '300', '2021-08-21 22:09:56'),
(55, '13', '陳小華', '0911-222-888', '', '1000', '2021-08-21 22:12:16'),
(56, '14', '勒布朗', '0921-111-111', '台北市板橋區', '1900', '2021-08-21 22:17:07'),
(57, '15', '王大陸', '0911-555-999', '台北市大安區', '2100', '2021-08-21 22:20:53');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`sid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order`
--
ALTER TABLE `order`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '訂單編號', AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
