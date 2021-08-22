<?php
include __DIR__. '/partials/init.php';

// header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

// 練習題：避免直接拜訪時的錯誤訊息
// 資料格式檢查
if(mb_strlen($_POST['name'])<2){
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 420;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "INSERT INTO `invitation`(`name`, `email`, `message`) VALUES (?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
$_POST['name'],
$_POST['email'],
$_POST['message'],
]);

$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if($stmt->rowCount()==1){
$output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);