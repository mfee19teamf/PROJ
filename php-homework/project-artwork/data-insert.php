<?php
// ALTER TABLE `hw_designer` ADD `artwork` VARCHAR(255) NULL AFTER `sid`; 記得曾加一個放檔案的
include __DIR__ . './partials/init.php';
$title = '新增資料';
?>
<?php include __DIR__ . './partials/html-head.php'; ?>
<?php include __DIR__ . './partials/navbar.php'; ?>
<style>
    form .form-group small {
        color: red;
    }
</style>
<div class="container">
    <div class="row col-m-6">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">新增資料</h5>

                <form name="form1" onsubmit="checkForm();return false;">
                    <!--onsubmit:表單送出去之前觸發; return false;返回錯誤的處理結果;終止處理;阻止提交表單;阻止執行預設的行為 -->
                    <div class="form-group">
                        <label for="artwork	">作品圖檔 *</label>
                        <input type="file" class="form-control" id="artwork" name="artwork">
                        <!-- required必填的欄位，可加也可不加 -->
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="name">作品名稱 *</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <!-- required必填的欄位，可加也可不加 -->
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">電子郵件 *</label>
                        <input type="text" class="form-control" id="email" name="email">
                        <small class="form-text "></small>
                    </div>
                    <div class="form-group">
                        <label for="mobile">手機號碼</label>
                        <input type="text" class="form-control" id="mobile" name="mobile">
                        <small class="form-text"></small>
                    </div>
                
                    <div class="form-group">
                        <label for="directions">說明</label>
                        <input type="text" class="form-control" id="directions" name="directions">
                        <small class="form-text"></small>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>



    </div>
</div>
<?php include __DIR__ . './partials/scripts.php'; ?>
<script>
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    const name = document.querySelector('#name');
    const email = document.querySelector('#email');
    //element = document.querySelector(selectors); 回傳 document 第一個符合特定選擇器群組的元素,selectors 是以逗號分隔，包含一個或多個 CSS 選擇器的字串。

    // email.style.border = '1px red solid'; //這是當沒填email時框框會變紅的寫法
    function checkForm() {

        //TODO:欄位的外觀要回復原來的狀態
        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px solid #CCCCCC';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px solid #CCCCCC';



        //TODO: 資料欄位檢查(todo代辦事項)

        //如果格式不符，要有欄位提示的不同外觀

        let isPass = true;
       
            
        
        if (name.value.length < 1) {
            isPass = false;
            name.nextElementSibling.innerHTML = '請填寫的作品名稱';
            name.style.border = '1px red solid';

        }
        if (! email_re.test(email.value)) {
                isPass = false;
                email.nextElementSibling.innerHTML = '請填寫正確的電子郵件格式';
                email.style.border = '1px red solid';

            }
        if (isPass) {
                const fd = new FormData(document.form1);
                fetch('data-insert-api.php', {
                        method: 'POST',
                        body: fd
                    })
                    .then(r => r.json())
                    .then(obj => {
                        console.log(obj);
                        if(obj.success){
                            location.href ='data-list.php'; //新增資料成功則跳轉至data-list頁面

                        }else{
                            alert(obj.error);//新增失敗則跳出警告
                        }
                    })
                    .catch(error => {
                        console.log('error:', error);
                        //萬一回傳的資料類型(json/txt)輸出設定錯誤時的錯誤處理
                    });
            }//層層條件都通過了才發ajax
        }
</script>
<?php include __DIR__ . './partials/html-foot.php'; ?>
<!-- 用這種方式，修改與維護方便，不用每一個檔案都開起來改，改原檔案，其他include的都一起改。
這樣此檔案就能當基本版型檔案，改中間container部分就可 -->