<?php 
require __DIR__. '/__connect_db.php';

header('Content-Type: application/json');


$sid =  isset($_GET['sid'])? intval($_GET['sid']) : 0;
if(! empty($sid)){  //empty(0) = true
    $sql="DELETE FROM `order` WHERE sid=$sid";
    $stmt = $pdo->query($sql); //
}


if(isset($_SERVER['HTTP_REFERER'])){
    header("Location: ". $_SERVER['HTTP_REFERER']);
} else {
    header('Location: data_list.php');
}
?>