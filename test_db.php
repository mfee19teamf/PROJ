<?php

require __DIR__ . '/partials/init.php';
$stmt = $pdo->query("SELECT * FROM address_book ");

echo json_encode($stmt->fetch(), JSON_UNESCAPED_UNICODE);
//PDO::FETCH_NUM PDO::FETCH_BOTH
//print_r($stmt->fetch(PDO::FETCH_ASSOC));
//echo json_encode($stmt->fetchALL(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
