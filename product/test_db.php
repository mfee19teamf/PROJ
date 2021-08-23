<?php

require __DIR__ . '/partials/init.php';

$stmt = $pdo->query("SELECT * FROM ys_products LIMIT 10");

// while(布林值) 當無法再取得資料，回傳 NULL 或 undefined -不確定- 就是false，迴圈結束
while ($r = $stmt->fetch()) {
    echo "<p>{$r['sid']}: {$r['works']}</p>";
}
