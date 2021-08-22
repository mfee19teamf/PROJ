<?php
include __DIR__ . '/partials/init.php';
//echo json_encode($_POST);

header('Content-Type: application/json');

// print_r($_POST);

$output = [
    'success' => false,
    'error' => '',
    'rowCount' => 0,
    'code' => 0,
    'postData' => $_POST,

];
//資料格式檢查
if (mb_strlen($_POST['name']) < 2) {
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}




$sql = "INSERT INTO `account_list`(
    `name`, `account`, `password`
) VALUES (
    ?,?,?
)";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['account'],
    $_POST['password'],
]);

$output['rowCount'] = $stmt->rowCount(); //新增的筆數
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
}
echo json_encode($output);
