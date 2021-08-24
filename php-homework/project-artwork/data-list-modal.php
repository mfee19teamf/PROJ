<?php
include __DIR__ . './partials/init.php';
$title = '藝廊';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//Q1:用戶決定查看第幾頁，預設為1

//Q2:總共有幾筆資料，才能知道總共有幾頁，才能生出分頁按鈕

$perPage = 2;
//固定每一頁做多只有2筆
//SELECT count(1) FROM hw_designer 計算總共有幾筆，把該程式碼丟去SQL裡
$totalRows = $pdo->query("SELECT count(1) FROM hw_designer")->fetch(PDO::FETCH_NUM)[0];
//用索引式陣列，不需要欄位名稱了
//echo $totalRows; exit;這是測試有沒有設定成功

if ($totalPages != 0) {
    //要有資料才能讀取該頁資料   

    $totalPages = ceil($totalRows / $perPage);
    //頁面無條件進位算一頁
    //echo"$totalRows,$totalPages";exit;測試有沒有設定成功

    if ($page < 1) {
        header('Location: ?=page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }
    //讓page的值在安全範圍內，即使外人去網址欄亂輸入也不會看到錯誤頁

    $sql = sprintf("SELECT*FROM /* hw_designer */ ORDER BY sid DESC LIMIT  %s, %s", ($page - 1) * $perPage, $perPage);

    //拿到的值就會是分頁的狀態，先排序(升降冪)完後第幾筆到第幾筆(%s, %s)，之後定義s怎麼計算;
    //($page-1)*$perPage,$perPage:
    //($page-1)是頁碼，第一頁第1筆是編碼0
    //*$perPage一頁有幾筆的意思
    //,$perPage:每一頁固定幾筆

    // 第一頁的資料是從第1筆但索引值是0，然後兩筆(0/1)
    // 第二頁的資料是從第3筆但索引值是2，然後兩筆(2/3)
    // 第三頁的資料是從第5筆但索引值是4，然後兩筆(4/5)

    $rows = $pdo->query($sql)
        ->fetchALL();
}
//資料全部拿出來給$rows這個變數
//ORDER BY sid DESC:資料呈現降冪排列




?>
<!-- -------------資料讀取/觸發----------------- -->

<!-- -------------view資料呈現----------------- -->
<?php include __DIR__ . './partials/html-head.php'; ?>
<?php include __DIR__ . './partials/navbar.php'; ?>
<style>
    table tbody i.fas.fa-trash-alt {
        color: darkred;
    }

    table tbody i.fas.fa-trash-alt.ajaxDelete {
        color: darkorange;
        cursor: pointer;
        /* 可以改變滑鼠游標的形狀，設定在文字或圖片上面，當滑鼠移上去時，就可以看到滑鼠游標的形狀 */
    }
</style>
<div class="container">
    <div class="row justify-content-end">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">
                    <!-- d-flex justify-content-end讓頁數按鈕靠右 -->

                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <!-- 當頁數<=1時就不能再往下點，失能 -->
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                            <!-- <i class="fas fa-arrow-circle-left"></i>一個icon左箭頭的 -->
                        </a>
                    </li>
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) : //一頁只顯示五頁可以點,但頁碼不可能有負數，所以設一個if條件;頁碼i一定要大於等於1才輸出，且小於等於總頁數
                        if ($i >= 1 and $i <= $totalPages) : ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <!-- <?= $i == $page ? 'active' : '' ?>:當點擊到該數字頁會反白 -->
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                <!-- <?= $i ?>顯示頁數，前面的href="?page=<?= $i ?> 是當你點擊時會加入到URL也就是你的網址php?page=$i-->
                            </li>
                    <?php endif;
                    endfor; ?>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <!-- 當頁數>=最末頁時就不能再往下點 -->
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                            <!-- <i class="fas fa-arrow-circle-right"></i>一個icon右箭頭的 -->
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!-- 放表格 -->

            <table class="table table-striped table-bordered">
                <!-- table-bordered加邊框屬性 -->
                <thead>
                    <tr>
                        <!-- `sid`, `name`, `email`, `mobile`, `upload date`, `directions`, `created_at` -->
                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        <th scope="col"><i class="fas fa-trash-alt"></i>ajax</th>
                        <th scope="col">sid</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">mobile</th>
                        <th scope="col">directions</th>
                        <th scope="col">created_at</th>
                        <th scope="col"><i class="fas fa-edit"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr data-sid="<?= $r['sid'] ?>">
                            <!-- 我們自己創造定義的屬性前面都會加data-這項系統就知道是我們自己定義的而不會跟預設定義功能打架 -->
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-trash-alt"></i>
                                </button>
                                >
                            </td>
                            <td>

                                <i class="fas fa-trash-alt ajaxDelete"></i>

                            </td>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['mobile'] ?></td>
                            <td><?= htmlentities($r['directions']) ?></td>
                            
                            <!-- <td><?= strip_tags($r['directions']) ?></td> -->
                            <!-- 方法1:strip_tags這個標籤可以讓字串裡的所有標籤都丟掉，避免他人輸入程式碼惡搞你的網頁 -->
                            <!-- 方法2:htmlentities可把字串做特殊符號的跳脫ex:小於大於符號 -->
                            <td><?= $r['created_at'] ?></td>
                            <!-- 方法2:htmlentities可把字串做特殊符號的跳脫ex:小於大於符號 -->
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
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



<?php include __DIR__ . './partials/scripts.php'; ?>
<script>
    const myTable = document.querySelector('table');
    //針對container容器標籤
    myTable.addEventListener('click', function(event) {

        //判斷有無點到該目標橘色垃圾桶icon
        if (event.target.classList.contains('ajaxDelete')) {
            // console.log(event.target.closest('tr')); //如果你有點到classname裡的列表classList有包含ajaxDelete的橘色垃圾桶icon，則往外找最接近的tr標籤
            const tr = event.target.closest('tr');
            const sid = tr.getAttribute('data-sid');
            console.log(sid);
            // console.log(`tr.dataset.sid:`,tr.dataset.sid);也可以這樣寫:detaset是可以取得開頭為data-的屬性資料

            if (confirm(`是否刪除編號為 ${sid} 的資料?`)) { //注意是`不是'
                fetch('data-delete-api.php?sid=' + sid) //這裡的+是與sid數值串接 而不是相加 相加ex:10 + +sid第二個+就變成轉換成數值
                    .then(r => r.json())
                    .then(obj => {
                        if (obj.success) {
                            tr.remove(); //從DOM裡移除元素
                            //TODO: 1刷頁面 2.取得該頁面資料再呈現
                            location.reload();
                        } else {
                            alert(obj.error);
                        }
                    });
            }
        }

    });
    // addEventListener 方法可以用來綁定元素的事件處理函數，第一個參數 eventType 是事件名稱，第二個參數 listener 是事件處理函數。可以對一個元素同時指定多個事件處理函數。
</script>
<?php include __DIR__ . './partials/html-foot.php'; ?>
<!-- 用這種方式，修改與維護方便，不用每一個檔案都開起來改，改原檔案，其他include的都一起改。
這樣此檔案就能當基本版型檔案，改中間container部分就可 -->