
<?php 
session_start();
require __DIR__. '/__connect_db.php';

$title = '訂單資訊';

//用戶決定查看第幾頁 預設1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//固定每一頁最多幾筆
$perPage = 5;


//總共有幾筆
//   "SELECT count(1) FROM `order`"
$totalRows  = $pdo->query("SELECT count(1) FROM `order`")->fetch(PDO::FETCH_NUM)[0];



// 總共有幾頁

$totalPage = ceil($totalRows / $perPage); //正數無條件進位

//如果沒有資料 (讓PAGE的植在安全的範圍)
if ($page < 1) {
    header('Location:?page=1');
    exit;
};
if ($page > $totalPage) {
    header('Location:?page=' . $totalPage);
};


// echo "$totalRows , $totalPage"; exit;

//SELECT * FROM `order` ORDER BY sid DESC LIMIT 0 ,5    第0筆開始 取5筆
//拿資料 ORDER BY sid DESC 倒序 (最新的在前面)


$sql = sprintf(
    "SELECT * FROM `order` ORDER BY sid DESC LIMIT %s ,%s",
    ($page - 1) * $perPage,
    $perPage
);


$rows = $pdo->query($sql)
    ->fetchALL();






?>

<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<style>
    table tbody i.far.fa-trash-alt {
            color: red;
        }
</style>
<div class="container">
    <div class="row mt-4">
        <!-- 分頁按鈕 -->
        <div class="col d-flex justify-content-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <!-- 上一頁 -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                        <li class="page-item <?= $i == $page ?  'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- 下一頁 -->
                    <!-- disabled 沒有功能 -->
                    <li class="page-item <?= $page >= $totalPage ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
    <!-- table -->
    <div class="row">
        <div class="col">
            <table class="table  table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col"><i class="far fa-trash-alt"></i></th>
                        <th scope="col">訂單編號</th>
                        <th scope="col">會員ID</th>
                        <th scope="col">會員姓名</th>
                        <th scope="col">手機</th>
                        <th scope="col">地址</th>
                        <th scope="col">價格</th>
                        <th scope="col"><i class="fas fa-edit"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="data-delete.php?sid=<?= $r['sid'] ?>"
                                onclick="return confirm('確定要刪除編號為<?= $r['sid'] ?>的資料嗎')">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= $r['sid'] ?></td>
                            
                            <td><?= $r['memberID'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['mobile'] ?></td>
                            <td><?= $r['address'] ?></td>
                            <td><?= $r['orderprice'] ?></td>
                            <td>
                                <a href="data-edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

<?php include __DIR__ . '/parts/scripts.php'; ?>

<?php include __DIR__ . '/parts/html-foot.php'; ?>