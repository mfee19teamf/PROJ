<?php include __DIR__ . '/partials/init.php'; ?>

<?php

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (!empty($sid)) {
    $sql = "DELETE FROM `ys_products` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}

// $_SERVER['HTTP_REFERER'] 從哪個頁面連過來
// 不一定每次都有資料
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ys_data_list.php');
}
