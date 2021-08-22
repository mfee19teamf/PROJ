<?php
if (!isset($page_name)) {
    $page_name = '';
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index_.php">Designer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $page_name == 'product-list' ? 'active' : '' ?>">
                    <a class="nav-link" href="product-list.php">商品列表</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="data-list.php">訂單列表</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item <?= $page_name == 'data-insert' ? 'active' : '' ?>">
                    <a class="nav-link" href="cart-list.php"><i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-pill badge-info cart-count"></span></a>
                </li>
                <?php if (isset($_SESSION['loginUser'])) : ?>
                    <li class="nav-item active">
                        <a class="nav-link"> <?= $_SESSION['loginUser']['name'] ?> </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="profile-edit.php">編輯個人資料</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php">登出</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data-insert.php">註冊</a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
</nav>