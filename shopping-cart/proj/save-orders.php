<?php
require __DIR__ . '/__connect_db.php';

$pKeys = array_keys($_SESSION['cart']);

$rows = []; // 預設值
$data_ar = []; // dict

// 有登入才能結帳
if (!isset($_SESSION['loginUser'])) {
    header('Location: product-list.php');
    exit;
}

if (!empty($pKeys)) {
    $sql = sprintf("SELECT * FROM product WHERE sid IN(%s)", implode(',', $pKeys));
    $rows = $pdo->query($sql)->fetchAll();
    $total = 0;
    foreach ($rows as $r) {
        $r['quantity'] = $_SESSION['cart'][$r['sid']];
        $data_ar[$r['sid']] = $r;
        $total += $r['quantity'] * $r['price'];
    }
} else {
    header('Location: product-list.php');
    exit;
}

$o_sql = "INSERT INTO `order`( `memberID`, `name`, `mobile`, `address`, `orderprice`, `create_at`) VALUES (?, ?, ?, ?, ?, NOW())";
$o_stmt = $pdo->prepare($o_sql);
$o_stmt->execute([
    
    $_SESSION['loginUser']['id'],
    $_SESSION['loginUser']['name'],
    $_SESSION['loginUser']['mobile'],
    $_SESSION['loginUser']['address'],
    $total,
]);

$order_sid = $pdo->lastInsertId(); // 最近新增資料的 PK

$od_sql = "INSERT INTO `order_detail`(`orderID`, `item_no`, `quantity`) VALUES ( ?, ?, ?)";
$od_stmt = $pdo->prepare($od_sql);

foreach ($_SESSION['cart'] as $p_sid => $qty) {
    $od_stmt->execute([
       
        $order_sid,
        $p_sid,
        $qty,
    ]);
}

unset($_SESSION['cart']); // 清除購物車內容

?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="container">
    <div class="alert alert-success" role="alert">
        感謝訂購 訂單編號 : <?= $order_sid ?>
    </div>

</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>

<?php include __DIR__ . '/parts/html-foot.php'; ?>