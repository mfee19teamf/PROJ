<?php
//啟動session
session_start();

// session_destroy(); //清除所有的session

unset($_SESSION['loginUser']); //清除某個session變數


header('Location:index_.php');



?>