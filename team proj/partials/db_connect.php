<?php

$db_host = 'localhost';  // 主機名稱
$db_name = 'proj';  // 資料庫名稱
$db_user = 'Rocky';
$db_pass = '';

// data source name
$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);