<?php

require __DIR__. '/partials/init.php';

// 做資料表的存取
$stmt=$pdo->query("SELECT * FROM hw_designer LIMIT 1"); //"SELECT*FROM hw_designer"直接放你要加進來的資料名稱(SQL);
// 使用$pdo->query就是給SQL指定一個代理人也就是PDOstatement;
// LIMIT 4代表最多拿出4筆資料，假設總共5萬多筆，寫了fetchALL會GG
//這個結果是拿到一個操作資料的statement物件



while($r=$stmt->fetch()){
   echo "<p>{$r['sid']}:{$r['name']}</p>";

}
// ($r=$stmt->fetch()是布林值，用=是因為呼叫$stmt->fetch()所得的值設定給$r這個變數，如果裡面有值>true，就會執行;拿到最後一筆沒資料了就回傳空值>false迴圈結束。

// 此程式意思為一次拿一筆資料出來，有資料就執行裡面，沒資料就離開

//上方已限定了最多4筆資料，所以只會執行4次

//也可以用printf