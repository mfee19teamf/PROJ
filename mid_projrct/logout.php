<?php
//啟動 Session功能
session_start();

//session_destroy()  清除所有session
unset($_SESSION['user']);

//echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
header('Location: index_.php');