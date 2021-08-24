<?php
include __DIR__ . './partials/init.php';

$data="john's cat";
echo $pdo->quote($data);
//字串SQL跳脫(\)，而且自動加單引號