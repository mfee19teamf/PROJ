<?php
// ALTER TABLE `hw_designer` ADD `artwork` VARCHAR(255) NULL AFTER `sid`; 記得曾加一個放檔案的
include __DIR__ . './partials/init.php';

header('Content-mobile:application/json');

//要放檔的資料夾
$folder = 'imgs/';
//允許上傳的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];
$output= [
    'success'=>false,
    'error' => '',
    'code'=> 0,
    'rowCount'=> 0,
    'postData' => $_POST,
];//要輸出的格式


if(!isset($_POST['name']) or !isset($_POST['email'])) {
    $output['error']='名稱錯誤或信箱錯誤';
    $output['code']='410';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}
//TODO:資料格式檢查
if(mb_strlen($_POST['name'])<1) { //mb_strlen一個檢視字串長度的函式。
    $output['code']= 410;

    echo json_encode($output);
    exit;

}
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $output['error']='信箱格式錯誤'; 
    $output['code']= 420;

    echo json_encode($output);
    exit;
}
$artwork = $_FILES['artwork'];

if(!empty($_FILES) and !empty($artwork)) { //else '未找到上傳的檔案'
    
    $ext = $imgTypes[$artwork['type']]; //取得副檔名
    
    if(!empty($ext)) { //else 未允許的副檔
        if(move_uploaded_file($artwork['tmp_name'],$folder.$artwork['name'])) { //else 檔案錯誤
            $output['success']=true;
            $sql="INSERT INTO `hw_designer`(
                `artwork`,`name`, `email`, `mobile`, 
                `directions`, `created_at`
               ) VALUES(
                   ?,?,?,?,
                   ?,NOW()
               )";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $folder.$artwork['name'],
                $_POST['name'],
                $_POST['email'],
                $_POST['mobile'],
                $_POST['directions']
            ]);
            $output['rowCount']=$stmt->rowCount();
            if($stmt->rowCount()==1){ // else 未上傳檔案
                $output['success']= true;
                $output['filename'] = $folder.$artwork['name'];
                $output['error']= '';
            }else{
                $output['error']= '未上傳檔案';
            }
        } else {
            $output['error']='檔案錯誤';
        }
    } else {
        $output['error']='未允許的副檔';
    }
} else {
    $output['error']='未找到上傳的檔案';
}


echo json_encode($output);

?>