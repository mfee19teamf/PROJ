<?php
//啟動session功能
session_start();
// session_destroy()清除所有的session，不建議

unset($_SESSION['user']);
// unset移除某個session變數的設定以及陣列裡的元素

header('Location:index_.php');





?>