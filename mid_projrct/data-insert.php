<?php
include __DIR__ . '/partials/init.php';
$title = '新增資料';
?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/mid_navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <div class="form-group">
                            <label for="exampleInputEmail1">name</label>
                            <input type="text" class="form-control" id="name" name="name" require>
                            <!-- 必填 -->
                            <small class="form-text">

                            </small>
                        </div>
                       
                        
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">帳號</label>
                            <input type="text" class="form-control" id="account" name="account">
                            <small class="form-text">

                            </small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">密碼</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text">

                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
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
            fetch('account-insert-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json()).then(obj => {
                    console.log(obj);
                })
                .catch(error => { //把錯誤訊息接下來
                    console.log('error:', error);
                });
        }


    }
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>