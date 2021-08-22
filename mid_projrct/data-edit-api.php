<?php
include __DIR__ . '/partials/init.php';


header('Content-Type: application/json');



$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'rowCount' => 0,
    'code' => 0,
    'postData' => $_POST,

];
if(
    empty($_POST['sid']) or
    empty($_POST['name']) or
    empty($_POST['account']) or
    empty($_POST['password']) 
    ){
        echo json_encode($output);
        exit;
    }

//資料格式檢查
if (mb_strlen($_POST['name']) < 2) {
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}


$sql = "UPDATE `account_list` SET 
`name`=?,
`account`=?,
`password`=?
 WHERE `sid`=?";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['account'],
    $_POST['password'],
    $_POST['sid'],
]);

$output['rowCount'] = $stmt->rowCount(); //修改的筆數
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['error'] = '';
}else{
    $output['error'] = '資料沒有修改';
}
echo json_encode($output);
