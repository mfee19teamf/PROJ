<?php
include __DIR__ . '/partials/init.php';
//啟動 Session功能


$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
];

$account = $_POST['account'];
$passowrd = $_POST['password'];
$sql = "SELECT * FROM `account_list` WHERE `account` = '$account' AND `password`='$passowrd';";
//$sql = "SELECT `account`,`password` FROM `account_list`;";

$users = $pdo->query($sql)->fetchall();


if ($users) {
    if ($account == 'admin') {
        $output['role'] = true; //admin login    
    } else {
        $output['role'] = false; //general user login
    }
    $output['success'] = true;
    $output['code'] = 200;
    $_SESSION['user'] = [
        'account' => $_POST['account'],

    ];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
} else {
}
