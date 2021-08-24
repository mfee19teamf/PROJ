<?php
include __DIR__ . './partials/init.php';
$title = '修改個人資料';

if(! isset($_SESSION['user'])){
    header('Location: index_.php');
    exit;
}
$sid = isset($_GET['sid']) ? intval($_GET['user']['sid']) : 0; //跟其他頁一樣先拿到主鍵
$sql = "SELECT * FROM `hw_designer` WHERE sid=$sid";

$r = $pdo->query($sql)->fetch();//假設一筆資料叫row，因為只有一筆資料就直接拿不用中間再多一個變數

//除錯:可以先輸入echo $sql;exit; 看看得到甚麼結果然後丟去phpadmin/sql看看得到甚麼結果

if(empty($r)){
    header('Location:index_.php');//空陣列.false.空字串.0，則轉向回到列表頁
    exit;
}

// echo json_encode($row,JSON_UNESCAPED_UNICODE);
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
                <h5 class="card-title">修改個人資料</h5>

                <form name="form1" onsubmit="checkForm(); return false;">
                     <!--onsubmit:表單送出去之前觸發; return false;返回錯誤的處理結果;終止處理;阻止提交表單;阻止執行預設的行為 -->
                    <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                    <div class="form-group">
                        <label for="name">作品名稱 *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($r['name']) ?>">
                        <!--htmlentities把字符轉換為HTML實體 -->
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">電子郵件 *</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= htmlentities($r['email']) ?>">
                        <small class="form-text "></small>
                    </div>
                    <div class="form-group">
                        <label for="mobile">手機</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($r['mobile']) ?>">
                        <small class="form-text"></small>
                    </div>
                   <div class="form-group">
                        <label for="directions">說明</label>
                        <textarea class="form-control" id="directions" name="directions" cols="30" rows="3"><?= htmlentities($r['directions']) ?></textarea>
                
                    <!-- textarea可填寫較多的字，注意點不要換行，不然就只能在屬性標籤間換行，不然輸入欄裡的文字會沒有靠左對齊 -->
                       
                        <small class="form-text"></small>
                    </div>
                    <!-- //在標籤裡加上value值的標籤是讓人可以修改的 -->
                    <button type="submit" class="btn btn-primary">修改</button>
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
            name.nextElementSibling.innerHTML = '請填寫作品名稱';
            name.style.border = '1px red solid';

        }
        if (! email_re.test(email.value)) {
                isPass = false;
                email.nextElementSibling.innerHTML = '請填寫正確的電子郵件格式';
                email.style.border = '1px red solid';

            }
        if (isPass) {
                const fd = new FormData(document.form1);
                fetch('data-edit-api.php', {
                        method: 'POST',
                        body: fd
                    })
                    .then(r => r.json())
                    .then(obj => {
                        console.log(obj);
                        if(obj.success){
                            alert('修改成功');

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
