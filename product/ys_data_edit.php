<?php
include __DIR__ . '/partials/init.php';

$title = '修改資料';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "SELECT * FROM `ys_products` WHERE sid=$sid";

// echo $sql; exit;

$r = $pdo->query($sql)->fetch();

if (empty($r)) {
    header('Location: ys_data_list.php');
    exit;
}
// 先看看功能是否正常
// echo json_encode($row, JSON_UNESCAPED_UNICODE);

?>


<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<style>
    form .form-group small {
        color: red;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>
                    <!-- `type``author``works``description``item_no``size(cm)``price``discounted_prices``quantity``images` -->
                    <form name="form1" onsubmit="checkForm(); return false">


                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">

                        <div class="form-group">
                            <label for="type">type/類型</label>
                            <input type="text" class="form-control" id="type" name="type" value="<?= htmlentities($r['type']) ?>">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="author">author/作者</label>
                            <input type="text" class="form-control" id="author" name="author" value="<?= htmlentities($r['author']) ?>" required>
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="works">works/商品名稱</label>
                            <input type="text" class="form-control" id="works" name="works" value="<?= htmlentities($r['works']) ?>">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="description">description/商品介紹</label>

                            <textarea class="form-control" id="description" name="description" cols="30" rows="3"><?= htmlentities($r['description']) ?></textarea>

                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="item_no">item_no/品號</label>
                            <input type="text" class="form-control" id="item_no" name="item_no" value="<?= htmlentities($r['item_no']) ?>">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="size(cm)">size(cm)/尺寸</label>
                            <input type="text" class="form-control" id="size(cm)" name="size(cm)" value="<?= htmlentities($r['size(cm)']) ?>">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="price">price/價格</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $r['price'] ?>" required>
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="discounted_prices">discounted_prices/優惠價</label>
                            <input type="text" class="form-control" id="discounted_prices" name="discounted_prices" value="<?= $r['discounted_prices'] ?>">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="quantity">quantity/數量</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" value="<?= $r['quantity'] ?>" required>
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="visible">visible/上下架</label>
                            <input type="text" class="form-control" id="visible" name="visible" value="<?= $r['visible'] ?>">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="images">images/商品圖</label>
                            <input type="text" class="form-control" id="images" name="images" ">
                            <!-- <img src=" <?= $r['images'] ?>" alt="" width="300px"> -->
                        </div>

                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<script>
    const works = document.querySelector('#works');

    function checkForm() {

        // 欄位外觀要恢復原本的狀態
        works.nextElementSibling.innerHTML = '';
        works.style.border = '1px #cccccc solid';

        // TODO: 資料欄位檢查，如果格式不符要有提示不同外觀
        let isPass = true;
        if (works.value.length < 2) {
            isPass = false;
            works.nextElementSibling.innerHTML = '請填寫商品名稱';
            works.style.border = '1px red solid';
        }


        // 用來處理 fetch 錯誤的方式- catch(O) trycatch(X)，避免JS停下
        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('ys_data_edit_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error => {
                    console.log('error:', error);
                });
        }
    }
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>