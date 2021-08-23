<?php
include __DIR__ . '/partials/init.php';

$title = '資料列表';

//query string parameters
$qs = [];

//關鍵字查詢
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';


// 固定每一頁最多幾筆
$perPage = 5;

// 建立分頁功能
// 用戶決定查看第幾頁，預設值為 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$where = ' WHERE 1 ';
if (!empty($keyword)) {
    // $where .= " AND `author` LIKE '%$keyword%' ";  //有 sql injection漏洞
    $where .= sprintf(" AND `author` LIKE %s ", $pdo->quote('%' . $keyword . '%'));

    $qs['keyword'] = $keyword;
}

// 總共有幾筆
$totalRows = $pdo->query("SELECT count(1) FROM ys_products $where")->fetch(PDO::FETCH_NUM)[0];
// echo $totalRows;exit; // 測試是否有成功抓到資料筆數

// 總共有幾頁，才能產生出分頁按鈕
$totalPages = ceil($totalRows / $perPage); //正數是無條件進位
// echo "$totalRows,$totalPages"; exit; // 測試

// 讓page的值在安全範圍
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
}


// 可以在任何位置設定取得資料庫某張表的資料，但不要在任何地方隨便要資料，最好在前面集中處理
// 以下把資料庫內容輸出
// SELECT*FROM address_book ORDER BY sid DESC LIMIT 0,5 //從第一頁開始，從索引值0開始，最多5筆

$sql = sprintf(
    "SELECT*FROM ys_products %s ORDER BY sid DESC LIMIT %s,%s",
    $where,
    ($page - 1) * $perPage,
    $perPage
);

// echo $sql;

$rows = $pdo->query($sql)
    ->fetchAll(); //因為有限定5筆，不用怕資料量太大，用fetchAll()即可



?>

<?php include __DIR__ . '/partials/html-head.php'; ?>
<!-- 以下是html內容 -->
<?php include __DIR__ . '/partials/navbar.php'; ?>

<style>
    table tbody i.fas.fa-trash-alt {
        color: red;
    }
</style>

<div class="container">
    <div class="row mt-2">
        <div class="row">
            <div class="col">
                <form action="ys-data-list.php" class="form-inline my-2 my-lg-0 ml-4">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" value="<?= htmlentities($keyword) ?>" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">

                    <li class="page-item"><a class="page-link" href="?$page=1">Back to page1</a></li>

                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $qs['page'] = $page - 1;
                                                    echo http_build_query($qs) ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>

                    <?php for ($i = $page - 5; $i <= $totalPages + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                            $qs['page'] = $i;

                    ?>
                            <!-- 連結是 ? 開頭時，表示 url 的資源是相同的檔案 -->
                            <!--  -->
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                            </li>
                    <?php endif;
                    endfor; ?>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $qs['page'] = $page + 1;
                                                    echo http_build_query($qs) ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <!-- `sid`, `type`, `author`, `works`, `description`, `item_no`, `size(cm)`, `price`, `discounted prices`, `quantity`, `visible`, `categories_sid`, `images` -->
                <thead>
                    <tr>
                        <th scope="col"> <i class="far fa-edit"></i></th>
                        <th scope="col">sid</th>
                        <th scope="col">type</th>
                        <th scope="col">author</th>
                        <th scope="col">works</th>
                        <th scope="col">description</th>
                        <th scope="col">item_no</th>
                        <th scope="col">size(cm)</th>
                        <th scope="col">price</th>
                        <th scope="col">discounted_prices</th>
                        <th scope="col">quantity</th>
                        <th scope="col">visible</th>
                        <th scope="col">images</th>
                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="ys_data_edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['type'] ?></td>
                            <td><?= $r['author'] ?></td>
                            <td><?= $r['works'] ?></td>
                            <td><?= $r['description'] ?></td>
                            <td><?= $r['item_no'] ?></td>
                            <td><?= $r['size(cm)'] ?></td>
                            <td><?= $r['price'] ?></td>
                            <td><?= $r['discounted_prices'] ?></td>
                            <td><?= $r['quantity'] ?></td>
                            <td><?= $r['visible'] ?></td>
                            <td><?= $r['images'] ?></td>
                            <td>
                                <!-- 告訴他 sid 是多少 -->
                                <a href="ys_data_delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm('資料刪除後就無法復原囉，確認要刪除編號為<?= $r['sid'] ?>的資料嗎?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>