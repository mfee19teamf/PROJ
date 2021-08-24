<?php

$db_host='localhost';//主機名稱-要連的主機在哪
$db_name='mfee19'; //資料庫名稱
$db_user='root';//連線的用戶-如果有設定別的也可放別的名稱
$db_pass=''; //這個用戶連mySQL的密碼，之前沒設的話就空字串

//data source name
$dsn="mysql:host={$db_host};dbname={$db_name};charset=utf8"; //charset=utf8直接寫死就好因為不會動
//設定變數
$pdo_options=[    //一個array ,PDO是一類型($pdo是我們自己命名的變數名稱),兩個冒號(::)代表該屬性定義在類別裡
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  //pdo異常處理設定,ERRMODE_EXCEPTION: 主動丟擲 exceptions 異常，需要以try{}cath(){}輸出錯誤資訊。
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Pdo默認資料提取模式;FETCH_ASSOC:取出的值都是關聯式陣列
      PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8",//一連線後要執行的指令設定;SET NAMES utf8:一連線後資料庫的資料進出都用UTF8編碼。
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options); //做一個連線