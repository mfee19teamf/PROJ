<?php
include __DIR__ . '/partials/init.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
//empty看是不是空值
if (!empty($sid)) {
    $sql = "DELETE FROM `address_book` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: data-list.php');
}


// $output['rowCount'] = $stmt->rowCount(); //刪除的筆數
// if ($stmt->rowCount() == 1) {
//     $output['success'] = true;
// }
// echo json_encode($output);
