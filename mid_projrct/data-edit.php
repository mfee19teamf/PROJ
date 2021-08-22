<?php
include __DIR__ . '/partials/init.php';
$title = '修改資料';
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


$sql = "SELECT * FROM `account_list` WHERE sid =$sid";

$row = $pdo->query($sql)->fetch();

//如果$row空值，回列表頁
if (empty($row)) {
    header('Location: data-list.php');
    exit;
}

//echo json_encode($row, JSON_UNESCAPED_UNICODE);
?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/mid_navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1">name</label>
                            <input type="text" class="form-control" id="name" name="name" require value="<?= $row['name'] ?>">
                            <!-- 必填 -->
                            <small class="form-text">

                            </small>
                        </div>



                        <div class="form-group">
                            <label for="exampleInputEmail1">帳號</label>
                            <input type="text" class="form-control" id="account" name="account" value="<?= $row['account'] ?>">
                            <small class="form-text">

                            </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">密碼</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?= $row['password'] ?>">
                            <small class="form-text">

                            </small>
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
    const name = document.querySelector('#name');

    function checkForm() {
        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px #CCCCCC solid';

        let isPass = true;
        if (name.value.length < 2) {
            isPass = false;
            name.nextElementSibling.innerHTML = '請填寫正確的姓名';
            name.style.border = '1px red solid';
        }

        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('data-edit-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功');
                    } else {
                        alert(obj.error);
                    };
                })
                .catch(error => { //把錯誤訊息接下來
                    console.log('error:', error);
                });
        }


    }
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>