<?php
// ALTER TABLE `hw_designer` ADD `artwork` VARCHAR(255) NULL AFTER `sid`; 記得曾加一個放檔案的
include __DIR__ . './partials/init.php';

header('Content-Type:application/json');
//要放檔的資料夾
$folder = 'imgs/';
//允許上傳的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

$output= [
    'success'=>false,
    'error' => '資料欄位不足',
    'code'=> 0,
    'rowCount'=> 0,
    'postData' => $_POST,
    'files' => $_FILES,
];//要輸出的格式

//驗證email格式正確與否的程式碼
// var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));

//練習題:便免直接拜訪時的錯誤訊息
if(
    empty($_POST['sid']) or 
    empty($_POST['email']) or
    empty($_POST['mobile']) or
    empty($_POST['directions']) or
    empty($_FILES['artwork'])

){   
    echo json_encode($output);
    exit;
}

$artwork = $_FILES['artwork'];
//如果有上傳檔案
if(! empty($_FILES) and !empty($artwork)){
    
    $ext = $imgTypes[$artwork['type']]; //取得副檔名
    //如果是允許的檔案類型
    if(! empty($ext)){
        if(move_uploaded_file(
            $artwork['tmp_name'],
            $folder.$artwork['name']
        )){
            $sql ="UPDATE `hw_designer` SET `artwork`=? WHERE `sid`=?";
            $sql="UPDATE `hw_designer` SET 
                              `artwork`= ?,
                              `name`= ?,
                              `email`= ?,
                              `mobile`= ?,
                              `directions`= ? 
                              WHERE `sid`= ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $folder.$artwork['name'],
                $_POST['name'],
                $_POST['email'],
                $_POST['mobile'],
                $_POST['directions'],
                $_POST['sid']
            ]);

            $output['rowCount']=$stmt->rowCount();//修改的筆數,如果為一則成功(true)
            if($stmt->rowCount()==1){
                $output['success']= true;
                $output['filename'] = $folder.$artwork['name'];
                $output['error']= '';
            }else{
                $output['error']= '資料未修改';
            }
            echo json_encode($output);
        }
    }
}
