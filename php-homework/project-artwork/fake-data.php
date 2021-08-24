<?php
include __DIR__ . './partials/init.php';

header('Content-Type:application/json');



$sql="INSERT INTO `hw_designer`(
    `name`, `email`, `mobile`, 
     `directions`, `created_at`
   ) VALUES(
       ?,?,?,
       ?,NOW()
   )";

$stmt = $pdo->prepare($sql);

$str='他希望本國奧委會可以重新考慮把空手道重新列入項目';

$chrArray = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);

for($i=0; $i<100; $i++){

    shuffle($chrArray);//隨機排敘

    // $ar=array_slice($chrArray,0,3);取前面三個元素

    $name=implode('',array_slice($chrArray,0,3)); //用空字串接起來三個字，把上面那一句話並到這來就只剩兩行code
    
    $stmt->execute([

        $name,
        uniqid().'@test.com',
        '09'.strval(rand(10000000,99999999)),
        date('Y-m-d',rand(strtotime('1990-01-01'),strtotime('2000-01-01'))),
        '台北市',
    
    ]);
     
}

echo 'ok';