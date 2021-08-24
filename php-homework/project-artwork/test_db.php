<?php

require __DIR__. '/partials/init.php';

// 做資料表的存取
$stmt=$pdo->query("SELECT * FROM hw_designer LIMIT 4"); //"SELECT*FROM hw_designer"直接放你要加進來的資料名稱(SQL);使用$pdo->query就是給SQL指定一個代理人也就是PDOstatement;LIMIT 4代表最多拿出4筆資料，假設總共5萬多筆，寫了fetchALL會GG
//這個結果是拿到一個操作資料的statement物件

print_r( $stmt->fetch(PDO::FETCH_ASSOC)); //fetch(mode;你要取得資料的模式);取得資料的模式當初就有在partials/db_connect.php這個檔案裡設定了做算裡面沒做設定也會拿到關聯式陣列樣子。NUM是索引式陣列樣/BOTH是兩個都拿到

// fetch是拿一筆資料而已，如果要拿到所有的資料要把fetch改成fetchALL。小心使用fetchALL，資料數太多會吃很多記憶體

// echo json_encode( $stmt->fetch(PDO::FETCH_ASSOC),JSON_UNESCAPED_UNICODE);
// 也可以變成json-關聯式陣列