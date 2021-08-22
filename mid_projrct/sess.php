<?php
//啟動 Session功能
session_start();

header('Content-Type: application/json');

echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
