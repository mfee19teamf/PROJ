<?php
include __DIR__ . '/partials/init.php';
$title = '美食區';
if (isset($_SESSION['sid'])) {
    $sql = "SELECT * FROM `account_list` WHERE `sid`='$sid';";
    $datai = $pdo->query($sql)->fetch();
    exit;
}
?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/mid_navbar.php'; ?>
<div class="container">
    <h2>Hello PHP</h2>
</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>