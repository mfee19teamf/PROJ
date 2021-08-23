<?php
// API 接收到資料然後回應給你需要的資料，其實就是library
// 自己寫當作網路上一個功能 又叫做webapi

// 因為還沒講到資料庫連線，這邊先用array建立多個可以登入的用戶資料，講義上只有一組

// 啟動 Session 功能
session_start();

$users = [
    'shin' => [
        'pw' => '123456',
        'nickname' => '小明',
    ],
    'der123' => [
        'pw' => '111111',
        'nickname' => '小華',
    ],
    'katie' => [
        'pw' => '111111',
        'nickname' => 'katie',
    ],
];


//輸出的格式
$output = [
    'success' => false,
    'error' => '',
    'code' => 0, //自己決定的追蹤碼，ex: 程式執行到哪一段
];

// 會拿到 POST 過來的 account 跟 password，因為不是用資料庫，所以要先檢查資料是否存在
// $_POST['account']

// 判斷有無帳號資料和密碼
if (!isset($_POST['account']) or !isset($_POST['password'])) {
    $output['error'] = '沒有帳號資料或沒有密碼';
    $output['code'] = 402;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($users[$_POST['account']])) {
    $output['error'] = '帳號有誤';
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit; // 直接離開 (中斷) 程式 ，php 容許程式執行到一半就結束
    // die('可以把中斷訊息寫在這邊'); // 和 exit 功能相同
}

$userData = $users[$_POST['account']];
if ($_POST['password'] !== $userData['pw']) {
    $output['error'] = '密碼錯誤';
    $output['code'] = 405;
} else {
    $output['success'] = true;
    $output['code'] = 200;

    $_SESSION['user'] = [
        'account' => $_POST['account'],
        'nickname' => $userData['nickname'],
    ];
}


echo json_encode($output, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES); //最後都一定要 + JSON_UNESCAPED_UNICODE
