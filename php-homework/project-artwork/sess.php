<?php
//啟動session功能
session_start();

header('Content-Type:application/json'); //呈現方式設定成json

echo json_encode($_SESSION,JSON_UNESCAPED_UNICODE);


//單純在查看session的狀態，主要是用來除錯
?>