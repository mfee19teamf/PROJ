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



//來源不名一律用這個
$sql="UPDATE `order` SET 
                        
                        
                        `name`=?,
                        `mobile`=?,
                        `address`=?,
                        `orderprice`=?
                        WHERE `sid`=?";
$stmt = $pdo->prepare($sql); //prepare()準備 execute($_POST[''],$_POST[''],)執行 對應每個問號
$stmt->execute([
    
    
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