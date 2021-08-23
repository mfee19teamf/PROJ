<script src="https://kit.fontawesome.com/edd21fb7ea.js" crossorigin="anonymous"></script>
<?php
include __DIR__ . '/partials/init.php';
$title = '帳號列表';

//固定每一頁最多幾筆
$perPage = 3;


$keyword = isset($_GET['keyword']) ? ($_GET['keyword']) : '';

//用戶決定查看第幾頁，預設值為 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;



$where = 'WHERE 1 ';
if (!empty($keyword)) {
    // $where .= "AND `name` LIKE '%{$keyword}%' "; //sql injection
    $where .= sprintf("AND `name` LIKE %s ", $pdo->quote('%' . $keyword . '%'));
}

//總共有幾筆
$totalRows = $pdo->query("SELECT count(1) FROM account_list $where")
    ->fetch(PDO::FETCH_NUM)[0];

//總共有幾頁，才能生出分頁按鈕
$totalPages = ceil($totalRows / $perPage); //正數無條件進位

//page在安全範圍內
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
}



$sql = sprintf(
    "SELECT * FROM account_list %s ORDER BY sid DESC LIMIT %s, %s",
    $where,
    ($page - 1) * $perPage,
    $perPage
);

$rows = $pdo->query($sql)->fetchAll();
//$rows = $pdo->query("SELECT * FROM address_book ORDER BY sid DESC LIMIT 10")
//    ->fetchAll();



?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/mid_navbar.php'; ?>
<style>
    table tbody i.fas.fa-trash-alt {
        color: darkred;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col">
            <form action="data-list.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" value="<?= htmlentities($keyword) ?>" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) :  ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>

                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        <th scope="col">sid</th>
                        <th scope="col">name</th>
                        <th scope="col">帳號</th>
                        <th scope="col">密碼</th>
                        <th scope="col"><i class="fas fa-edit"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="data-delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm('確定要刪除編號為 <?= $r['sid'] ?>的資料嗎?')">

                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= htmlentities($r['sid']) ?></td>
                            <td><?= htmlentities($r['name']) ?></td>
                            <td><?= htmlentities($r['account']) ?></td>
                            <td><?= htmlentities($r['password']) ?></td>
                            <td>
                                <a href="data-edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <!-- strip_tags($r['address']) html所有標籤清掉 
                            避免XSS攻擊
                        htmlentities 跳脫一些> < 符號
                        -->
                        </tr>
                    <?php endforeach; ?>



                </tbody>
            </table>
        </div>
    </div>





</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>