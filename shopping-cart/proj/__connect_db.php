<?php
$db_host = 'localhost';  // 主機名稱
$db_name = 'meff19';  // 資料庫名稱
$db_user = 'chen1';
$db_pass = '';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db_host, $db_name);

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
} catch(PDOException $ex){
    echo 'Ex:'. $ex->getMessage();
}

if(! isset($_SESSION)){
    session_start();
}


