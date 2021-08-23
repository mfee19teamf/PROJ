<?php
// 查看狀態，用來除錯
session_start();
 
header('Content-Type: application/json');

echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);