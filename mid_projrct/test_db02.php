<?php

require __DIR__ . '/partials/init.php';
$stmt = $pdo->query("SELECT * FROM address_book ");

//echo json_encode($stmt->fetch(), JSON_UNESCAPED_UNICODE);

while ($r = $stmt->fetch()) {
    echo "<p>{$r['name']}</p>";
}
