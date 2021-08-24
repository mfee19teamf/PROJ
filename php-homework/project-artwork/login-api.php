<?php
include __DIR__.'/partials/init.php';

//可以登入的用戶資料
$users =[
    'light' =>[
        'pw'=>'123456',
        'nickname'=>'燈燈',
    ],
    'orange' =>[
        'pw'=>'123',
        'nickname'=>'一顆橘子',
    ],
   
];


//這是要輸出的格式
$output =[
    'success'=> false,
    'error'=> '',
    'code'=>0,
];
//判斷有無帳號密碼
if(!isset($_POST['account']) or !isset($_POST['password'])){
    $output['error']='查無帳號資料或密碼';
    $output['code']='400';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}


//判斷是不是在設定內的帳密
if(!isset($users[$_POST['account']])){
    $output['error']='帳號錯誤';
    $output['code']='401';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit; //直接離開(中斷)程式。另一個function是die();裡面可以放字串或數字也可不寫
    //錯誤之後也是可以寫else但是就還要再寫，可以直接離開exit就可
   
}
$usersData = $users[$_POST['account']];
if ($_POST['password'] !== $usersData['pw'])
{
    $output['error']='密碼錯誤';
    $output['code']= 405; //錯誤編號隨便給的
 
} else {
    $output['success']=true;
    $output['code']= 200;

    $_SESSION['user']=[
        'account' =>$_POST['account'],
        'nickname'=>$usersData['nickname'],
    ];
}


echo json_encode($output,JSON_UNESCAPED_UNICODE);
//後方要加一個UNICODE屬性，中文字才能正常顯示，且亦不跳脫亞洲其他文字


?>