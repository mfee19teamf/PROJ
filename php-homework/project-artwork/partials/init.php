<?php

require __DIR__.'/db_connect.php'; //其他頁面去requireinit.php這個檔案就可以連資料庫連線的設定都寫好了

//如果沒有啟用 session 就讓它啟用
if(! isset($_SESSION)) {
    session_start();
}
?>
