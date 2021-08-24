<?php
// ALTER TABLE `hw_designer` ADD `artwork` VARCHAR(255) NULL AFTER `sid`; 記得曾加一個放檔案的
include __DIR__ . './partials/init.php';

// header('Content-Type:application/json');
// $output= [
//     'success'=>false,
//     'error' => '',
// ];

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
//intval();取得變量的整數值，給奇怪的東西的時候有一個轉換int機制->0則不啟動不是0則啟動
//為什麼不用prepare;1.因為他只有一個值2.我們加個了轉換成整數的功能
if(! empty($sid)){
    $sql="DELETE FROM `hw_designer` WHERE sid=$sid";//語法去PHPadm複製
    $stmt = $pdo->query($sql);}
//empty();檢查一個變量是否為空值空字串空陣列


// $_SERVER['HTTP_REFERER'] 判斷有沒有送檔頭過來，從哪連過來，不一定有資料
if(isset($_SERVER['HTTP_REFERER'])){
    header("Location:".$_SERVER['HTTP_REFERER']);//如果有 則連回去該頁
} else {
    header('Location: data-list.php');
}//直接轉向資料的第一頁
