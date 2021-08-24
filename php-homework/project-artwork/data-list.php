<?php
    include __DIR__. '/partials/init.php';
    $title = '資料列表';

    // 固定每一頁最多幾筆
    $perPage = 5;

    // query string parameters
    $qs = [];

    // 關鍵字查詢
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    //Q1:用戶決定查看第幾頁，預設為1

    //Q2:總共有幾筆資料，才能知道總共有幾頁，才能生出分頁按鈕

    $where = ' WHERE 1 ';
    if(! empty($keyword)){
        // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞
        $where .= sprintf(" AND `name` LIKE %s ", $pdo->quote('%'. $keyword. '%'));

        $qs['keyword'] = $keyword;
    }
    //關鍵字篩選


    // 總共有幾筆
    $totalRows = $pdo->query("SELECT count(1) FROM hw_designer $where ")
        ->fetch(PDO::FETCH_NUM)[0];
    // 總共有幾頁, 才能生出分頁按鈕
    //用索引式陣列，不需要欄位名稱了
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

        $sql = sprintf("SELECT * FROM hw_designer %s ORDER BY sid DESC LIMIT %s, %s",
            $where,
            ($page - 1) * $perPage,
                $perPage);

        $rows = $pdo->query($sql)->fetchAll();

    }
    //拿到的值就會是分頁的狀態，先排序(升降冪)完後第幾筆到第幾筆(%s, %s)，之後定義s怎麼計算;
//($page-1)*$perPage,$perPage:
//($page-1)是頁碼，第一頁第1筆是編碼0
//*$perPage一頁有幾筆的意思
//,$perPage:每一頁固定幾筆

// 第一頁的資料是從第1筆但索引值是0，然後兩筆(0/1)
// 第二頁的資料是從第3筆但索引值是2，然後兩筆(2/3)
// 第三頁的資料是從第5筆但索引值是4，然後兩筆(4/5)

//資料全部拿出來給$rows這個變數
//ORDER BY sid DESC:資料呈現降冪排列

?>
<!-- -------------資料讀取/觸發----------------- -->

<!-- -------------view資料呈現----------------- -->
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
    <style>
        table tbody i.fas.fa-trash-alt {
            color: darkred;
        }
        table tbody i.fas.fa-trash-alt.ajaxDelete {
            color: darkorange;
            cursor: pointer;
        }
        /* 可以改變滑鼠游標的形狀，設定在文字或圖片上面，當滑鼠移上去時，就可以看到滑鼠游標的形狀 */
    </style>
<div class="container">
    <div class="row" >
        <div class="col">
            <form action="data-list.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end"><!-- d-flex justify-content-end讓頁數按鈕靠右 -->
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search"
                       value="<?= htmlentities($keyword) ?>"
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">

                    <li class="page-item <?= $page<=1 ? 'disabled' : '' ?>">
                    <!-- 當頁數<=1時就不能再往下點，失能 -->
                        <a class="page-link" href="?<?php
                        $qs['page']=$page-1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                            <!-- <i class="fas fa-arrow-circle-left"></i>一個icon左箭頭的 -->
                        </a>
                    </li>

                    <?php for($i=$page-5; $i<=$page+5; $i++):
                        if($i>=1 and $i<=$totalPages):
                            $qs['page'] = $i;
                            //一頁只顯示五頁可以點,但頁碼不可能有負數，所以設一個if條件;頁碼i一定要大於等於1才輸出，且小於等於總頁數
                            ?>
                            
                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                     <!-- <?= $i==$page ? 'active':''?>:當點擊到該數字頁會反白 -->
                        <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                            <!-- <?=$i?>顯示頁數，前面的href="?page=<?=$i?> 是當你點擊時會加入到URL也就是你的網址php?page=$i-->
                    </li>
                    <?php endif;
                        endfor; ?>

                    <li class="page-item <?= $page>=$totalPages ? 'disabled' : '' ?>">
                     <!-- 當頁數>=最末頁時就不能再往下點 -->
                        <a class="page-link" href="?<?php
                        $qs['page']=$page+1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                            <!-- <i class="fas fa-arrow-circle-right"></i>一個icon右箭頭的 -->
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
    <div class="row">
         <!-- 放表格 -->
        <div class="col">
            <table class="table table-striped table-bordered">
                 <!-- table-bordered加邊框屬性 -->
                <thead>
                <tr>
                     <!-- `sid`, `name`, `email`, `mobile`, `directions`, `created_at` -->
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                    <th scope="col"><i class="fas fa-trash-alt"> ajax</i></th>
                    <th scope="col">sid</th>
                    <th scope="col">artwork</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">mobile</th>
                    <th scope="col">directions</th>
                    <th scope="col">create_at</th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($rows as $r): ?>
                <tr data-sid="<?= $r['sid'] ?>">
                 <!-- 我們自己創造定義的屬性前面都會加data-這項系統就知道是我們自己定義的而不會跟預設定義功能打架 -->
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>
                        <i class="fas fa-trash-alt ajaxDelete"></i>
                    </td>
                    <td><?= $r['sid'] ?></td>
                    <td><img src=<?= $r['artwork'] ?> width="140" height="140"></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    
                    <!--
                    <td><?= strip_tags($r['directions']) ?></td>
                    -->
                    <td><?= htmlentities($r['directions']) ?></td>
                    <td><?= ($r['created_at']) ?></td>
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


</div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除注意</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary modal-del-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>


<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    const myTable = document.querySelector('table');
    const modal = $('#exampleModal');

    myTable.addEventListener('click', function(event){

        // 判斷有沒有點到橙色的垃圾筒
        if(event.target.classList.contains('ajaxDelete')){
            // console.log(event.target.closest('tr'));
            const tr = event.target.closest('tr');
            const sid = tr.getAttribute('data-sid');

            console.log(`tr.dataset.sid:`, tr.dataset.sid); // 也可以這樣拿

            if(confirm(`是否要刪除編號為 ${sid} 的資料？`)){
                fetch('data-delete-api.php?sid=' + sid)
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

    let willDeleteId = 0;
    $('.del1btn').on('click', function(event){
        willDeleteId = event.target.closest('tr').dataset.sid;
        console.log(willDeleteId);
        modal.find('.modal-body').html(`確定要刪除編號為 ${willDeleteId} 的資料嗎？`);
    });

    // 按了確定刪除的按鈕
    modal.find('.modal-del-btn').on('click', function(event){
        console.log(`data-delete.php?sid=${willDeleteId}`);
        location.href = `data-delete.php?sid=${willDeleteId}`;
    });

    // modal 一開始顯示時觸發
    modal.on('show.bs.modal', function(event){
        // console.log(event.target);
    });
</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>
<!-- 用這種方式，修改與維護方便，不用每一個檔案都開起來改，改原檔案，其他include的都一起改。
這樣此檔案就能當基本版型檔案，改中間container部分就可 -->