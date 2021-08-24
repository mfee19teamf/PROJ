<?php
    include __DIR__.'./partials/init.php';
    $title = '設計師的';
?>
<?php include __DIR__.'./partials/html-head.php'; ?>
<?php include __DIR__.'./partials/navbar.php'; ?>
<div class="container">
    <h2>Hello creator :)</h2>
</div>
<?php include __DIR__.'./partials/scripts.php'; ?>
<?php include __DIR__.'./partials/html-foot.php'; ?>
<!-- 用這種方式，修改與維護方便，不用每一個檔案都開起來改，改原檔案，其他include的都一起改。
這樣此檔案就能當基本版型檔案，改中間container部分就可 -->