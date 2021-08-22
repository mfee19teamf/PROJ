<?php
require __DIR__. '/db_connect.php';

//如果沒有啟動session，就讓它啟動

if(! isset($_SESSION)){
    session_start();
}