<?php
require __DIR__ . '/__connect_db.php';
$title = '註冊';
?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">註冊帳號</h5>
                    <form name="form1" onsubmit="checkForm();return false;">
                        <div class="form-group">
                            <label for="name">name </label>
                            <input type="text" class="form-control" id="name" name="name">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="email">email </label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="address">住址</label>
                            <input type="text" class="form-control" id="address" name="address">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="bitherday">生日</label>
                            <input type="date" class="form-control" id="bitherday" name="bitherday">
                            <small class="form-text "></small>
                        </div>
                        <button type="submit" class="btn btn-primary">註冊</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
function checkForm() {
        

        const fd = new FormData(document.form1);
        fetch('data-insert-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if(obj.success){
                    alert('註冊成功');
                } else {
                    alert(obj.error);
                }
            })
        }
</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>