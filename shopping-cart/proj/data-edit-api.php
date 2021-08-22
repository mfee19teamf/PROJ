<?php 
include __DIR__. '/__connect_db.php';
// echo json_encode($_POST);
header('Content-Type: application/json');

$output=[
'success' => false,
'error' => '',
'code' => 0,
'rowCount' => 0,
'postData' => $_POST,

];

if(
    empty($_POST['sid'])or
    empty($_POST['name'])or
    empty($_POST['email'])or
    empty($_POST['mobile'])or
    empty($_POST['bithday'])
    ){
        $output['error']='有欄位沒有填寫';
        $output['code']=440;
        echo json_encode($output,JSON_UNESCAPED_UNICODE);
        exit;
    }



//來源不名一律用這個
$sql="UPDATE `order` SET 
                        
                        `memberID`=?,
                        `name`=?,
                        `mobile`=?,
                        `address`=?,
                        `orderprice`=?
                        WHERE `sid`=?";
$stmt = $pdo->prepare($sql); //prepare()準備 execute($_POST[''],$_POST[''],)執行 對應每個問號
$stmt->execute([
    
    $_POST['memberID'],
    $_POST['name'],
    $_POST['mobile'],
    $_POST['address'],
    $_POST['orderprice'],
    $_POST['sid'],
]);

$output['rowCount'] = $stmt ->rowCount(); //修改的筆數
if($stmt->rowCount()==1){
    $output['success'] =true;
    $output['error']='';
}else{
    $output['error']='沒有修改';
}
echo json_encode($output);
?>