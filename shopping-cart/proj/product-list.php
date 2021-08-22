<?php
require __DIR__ . '/__connect_db.php';
$title = '商品列表';
$perPage = 4;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;
$pageBtnQS = [];

$where = ' WHERE 1 ';
if (!empty($cate)) {
    $where .= " AND category_sid=$cate ";
    $pageBtnQS['cate'] = $cate;
}


// 總筆數
$t_sql = "SELECT COUNT(1) FROM product $where ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage); // 總頁數
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

$rows = [];
// 如果有資料
if ($totalRows > 0) {
    $sql = sprintf("SELECT * FROM product $where LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
}



?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<style>

    .mycard1 {
        border: 0.5px solid rgba(204, 204, 204, 0.267);;
        border-radius: 1px;
    }

    .mycard1 img {
        width: 100%;
        height: 309px;

    }
    h6{
        font-size: 1.8rem;
        margin-top: 10px;
    }
    span {
        font-size: 1.5rem;
        line-height: 2;
        font-weight: bold;
    }

    p {
        font-size: 0.8rem;
    }
</style>
<!-- <div class="container ">
<div class="row ">
    <div class="col">
        <div class="row">
            <div class="col d-flex justify-content-end ">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?php
                                                        $pageBtnQS['page'] = $page - 1;
                                                        echo http_build_query($pageBtnQS)
                                                        ?>">
                                <i class="fas fa-arrow-circle-left"></i>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++) :
                            $pageBtnQS['page'] = $i;
                        ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query($pageBtnQS) ?>">
                                    <?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?php
                                                        $pageBtnQS['page'] = $page + 1;
                                                        echo http_build_query($pageBtnQS)
                                                        ?>">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <img src="./imgs/No-001.jpg" alt="">
                </nav>
            </div>
        </div>
        <div class="row">
            <?php foreach ($rows as $r) : ?>
            <div class="col-md-3 product-unit" data-sid="<?= $r['sid'] ?>">
                <div class="mycard ">
                    <div class="myimg">
                        <img src="imgs/small/<?= $r['item_no'] ?>.jpg" class="card-img-top" alt="...">
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">畫名 : <?= $r['workname'] ?></h6>
                        <p class="card-text"><i class="fas fa-user-secret"></i> : <?= $r['author'] ?></p>
                        <p class="card-text"><i class="fas fa-dollar-sign"></i> : <?= $r['price'] ?></p>
                        <p class="card-text ">尺寸 : <?= $r['size'] ?></p>
                        <form class="mt-3">
                            <div class=" form-group">
                                <select class="form-control qty" style="display: inline-block; width: auto">
                                    <?php for ($i = 1; $i <= 10; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                <button type="button" class="ml-2 mb-1 btn btn-primary add-to-cart-btn"><i class="fas fa-cart-plus"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div> -->
<div class="container ">
    <div class="row ">
        <h6>畫作</h6>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-end ">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                                                    $pageBtnQS['page'] = $page - 1;
                                                    echo http_build_query($pageBtnQS)
                                                    ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) :
                        $pageBtnQS['page'] = $i;
                    ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query($pageBtnQS) ?>">
                                <?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                                                    $pageBtnQS['page'] = $page + 1;
                                                    echo http_build_query($pageBtnQS)
                                                    ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                </ul>
                <img src="./imgs/No-001.jpg" alt="">
            </nav>
        </div>
    </div>
    <div class="row">
        <?php foreach ($rows as $r) : ?>
            <div class="mycard1 product-unit col-md-3 mx-auto" data-sid="<?= $r['sid'] ?>">
                <img src="imgs/small/<?= $r['item_no'] ?>.jpg" alt="">
                <div>
                    <p>畫名 : <span> <?= $r['workname'] ?></span></p>
                    <p>作者 : <?= $r['author'] ?></p>
                    <p>價格 : <?= $r['price'] ?></p>
                    <p>尺寸 : <?= $r['size'] ?></p>
                    <form class="mt-3">
                        <div class=" form-group">
                            <select class="form-control qty" style="display: inline-block; width: 60px">
                                <?php for ($i = 1; $i <= 10; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                            <button type="button" class="ml-2 mb-2 btn btn-primary add-to-cart-btn"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>






</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    const btns = $('.add-to-cart-btn');

    btns.click(function() {
        const sid = $(this).closest('.product-unit').attr('data-sid');
        //const qty = $(this).prev().val();
        const qty = $(this).closest('.product-unit').find('.qty').val();

        //console.log({sid, qty});

        $.get('add-to-cart-api.php', {
            sid,
            qty
        }, function(data) {
            countCartObj(data);
        }, 'json');
    });
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>