<?php include __DIR__ . '/partials/init.php'; ?>

<?php
header('Content-Type: application/json');



$output = [
    'success' => false,
    'error' => '000',
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

// if (
//     empty($_POST['type']) or
//     empty($_POST['author']) or
//     empty($_POST['works']) or
//     empty($_POST['description']) or
//     empty($_POST['item_no']) or
//     empty($_POST['size(cm)']) or
//     empty($_POST['price']) or
//     empty($_POST['discounted_prices']) or
//     empty($_POST['quantity']) or
//     empty($_POST['visible']) or
//     empty($_POST['avatar'])
// ) {
//     echo json_encode($output);
//     exit;
// }




$sql = " UPDATE `ys_products` SET 
`type`=?,
`author`=?,
`works`=?,
`description`=?,
`item_no`=?,
`size(cm)`=?,
`price`=?,
`discounted_prices`=?,
`quantity`=?,
`visible`=?,
`images`=? 
WHERE  `sid`=? ";

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
    $_POST['sid'],
]);


$output['rowCount'] = $stmt->rowCount(); //修改的筆數

if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}

echo json_encode($output);
?>

