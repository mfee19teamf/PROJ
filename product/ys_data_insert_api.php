<?php include __DIR__ . '/partials/init.php'; ?>

<?php
header('Content-Type: application/json');





$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

// TODO:資料格式檢查
if (mb_strlen($_POST['works']) < 2) {
    $output['error'] = '商品名稱過短';
    $output['code'] = 410;

    echo json_encode($output);
    exit;
}






$sql = "INSERT INTO `ys_products`( `type`, `author`, `works`, `description`, `item_no`, `size(cm)`, `price`, `discounted_prices`, `quantity`, `visible`, `images`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['type'],
    $_POST['author'],
    $_POST['works'],
    $_POST['description'],
    $_POST['item_no'],
    $_POST['size(cm)'],
    $_POST['price'],
    $_POST['discounted_prices'],
    $_POST['quantity'],
    $_POST['visible'],
    $_POST['images'],
]);


$output['rowCount'] = $stmt->rowCount(); //新增的筆數

if ($stmt['rowCount'] == 1) {
    $output['success'] = true;
   
}

echo json_encode($output);
