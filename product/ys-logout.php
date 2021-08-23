<?php
// 查看狀態，用來除錯
session_start();

// session_destroy(); //整個摧毀清除所有的 session *不建議使用*
unset($_SESSION['user']); // 移除某個 session 變數

header('Location: ys_index_.php');
