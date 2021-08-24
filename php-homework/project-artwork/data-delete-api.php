<?php
// ALTER TABLE `hw_designer` ADD `artwork` VARCHAR(255) NULL AFTER `sid`; 記得曾加一個放檔案的
include __DIR__ . './partials/init.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$output = [
    'success'=> false,
    'error'=>'沒有給 sid',
    'sid'=> $sid,
];

//也可以在判斷之前先select該筆資料在不在，不在就可以直接說該筆資料不存在
if(! empty($sid)){
    //判斷是否為空值，不是才進{}運行程式，是空值直接echo
    $sql="DELETE FROM `hw_designer` WHERE sid=$sid";//語法去PHPadm複製
    $stmt = $pdo->query($sql);

    if($stmt->rowCount()==1){
        $output['success']=true;
        $output['error']=''; //刪除成功則錯誤訊息清掉
    }else {
        $out['error']='刪除失敗,(可能無該筆資料)';//刪除筆數為0則success=>false，錯誤訊息給'刪除失敗'

    }
}

echo json_encode($output,JSON_UNESCAPED_UNICODE);
//相較於data-delete.php較為正式，用ajax處理