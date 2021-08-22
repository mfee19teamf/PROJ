<?php
    include __DIR__. '/partials/init.php';
    $title = '資料列表';

    // 固定每一頁最多幾筆
    $perPage = 5;
    $qs = [];
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $where = ' WHERE 1 ';
    // 總共有幾筆
    $totalRows = $pdo->query("SELECT count(1) FROM invitation $where ")
        ->fetch(PDO::FETCH_NUM)[0];
    // 總共有幾頁, 才能生出分頁按鈕
    $totalPages = ceil($totalRows / $perPage); // 正數是無條件進位

    $rows = [];
    // 要有資料才能讀取該頁的資料
    if($totalRows!=0) {


        // 讓 $page 的值在安全的範圍
        if ($page < 1) {
            header('Location: ?page=1');
            exit;
        }
        if ($page > $totalPages) {
            header('Location: ?page=' . $totalPages);
            exit;
        }

        $sql = sprintf("SELECT * FROM invitation %s ORDER BY sid ASC LIMIT %s, %s",
            $where,
            ($page - 1) * $perPage,
            $perPage);

        $rows = $pdo->query($sql)->fetchAll();

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歷史訊息</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table tbody i.fas.fa-trash-alt {
            color: darkred;
            cursor: pointer;
        }
        table tbody i.fas.fa-trash-alt.ajaxDelete {
            color: darkorange;
            cursor: pointer;
        }
        table tbody i.fas.fa-edit {
            color: blue;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="contain overflow-hidden px-5">
    <div class="row">
        <div class="col">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
                    <a class="navbar-brand" href="mainpage.php">工商邀約</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="History_message.php">歷史訊息<span class="sr-only">(current)</span></a>
                        </li>
                        </ul>
                        <ul class="nav justify-content-end">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">登入</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">註冊</a>
                            </li>
                        </ul>
                    </div>
            </nav>



            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">

                    <li class="page-item <?= $page<=1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page-1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>

                    <?php for($i=$page-5; $i<=$page+5; $i++):
                        if($i>=1 and $i<=$totalPages):
                            $qs['page'] = $i;
                            ?>
                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                    </li>
                    <?php endif;
                        endfor; ?>

                    <li class="page-item <?= $page>=$totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page+1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>



            <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        <th scope="col"><i class="fas fa-edit"></i></th>
                        <th scope="col">編號</th>
                        <th scope="col">設計師姓名</th>
                        <th scope="col">您的信箱</th>
                        <th scope="col">邀約訊息</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($rows as $r): ?>
                        <tr data-sid="<?= $r['sid'] ?>">
                        <th scope="row">
                            <a href="History_delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm(`是否要刪除編號為 <?= $r['sid'] ?> 的資料？`)">
                                <i class="fas fa-trash-alt ajaxDelete"></i>
                            </a>
                        </th>
                        <th scope="row">
                            <a href="Edit_message.php?sid=<?= $r['sid'] ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </th>
                        <th scope="row"><?= $r['sid'] ?></th>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= htmlentities($r['message']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>         
        </div>
    </div>
</div>







<!-- <script>
    const myTable = document.querySelector('table');

    myTable.addEventListener('click', function(event){
        console.log(event.target);
        if(event.target.classList.contains('ajaxDelete')){
            console.log(event.target.closest('tr'));
            const tr = event.target.closest('tr');
            const sid = tr.getAttribute('data-sid');
            console.log(sid);

            if(confirm(`是否要刪除編號為 ${sid} 的資料？`)){
                fetch('History_message_delete.php?sid=' + sid)
                    .then(r=>r.json())
                    .then(obj=>{
                        if(obj.success){
                            tr.remove();  // 從 DOM 裡移除元素
                            // TODO: 1. 刷頁面, 2. 取得該頁的資料再呈現

                        } else {
                            alert(obj.error);
                        }
                    });
            }
        }
    });
</script> -->



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>