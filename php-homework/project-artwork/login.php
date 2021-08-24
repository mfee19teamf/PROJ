<?php

    include __DIR__.'./partials/init.php';
    $title = '登入';
    if(isset($_SESSION['user'])){
        header('Location:index_.php');
        exit;
    }
    //如果已經登入狀態則以下程式就不需要呈現(就不會看到輸入帳密的框框)，直接跳轉(redirect)設定檔頭header('Location:你要跳轉的檔案名')

?>
<?php include __DIR__. './partials/html-head.php'; ?>
<?php include __DIR__. './partials/navbar.php'; ?>
<style>
    form .form-group small {
        color: red;
        display: none;
        /* 先藏起來 */
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">

            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">登入</h5>

                    <form id="form1" name="forml" onsubmit="sendForm(); return false;">
                    <!-- html form 中的onsubmit在點submit按鈕時被觸發，如果return false;則結果不會被提交到action中去（也就是提交動作不會發生），如果不返回或者返回true，則執行提交動作。onsubmit和action兩個都是提交時出發的，不過：onsubmit是在表單中的確認按鈕被點選時出發的，一般是js函式，而action是在按鈕被點選之後出發的，一般是出發前台提交到後台的請求，而引起後台的回應。
                    
                    1.如果html中使用form的onsubmi屬性t進行提交前的資料驗證，需要驗證函式返回一個布林值，而且要寫成onsubmit=”return 函式名();” return不能少，否則無論函式返回true還是false都能夠提交，達不到驗證的目的。
                    
                    2.只能使用sunmit按鈕進行提交才觸發onsubmit事件，button按鈕的提交不能觸發onsubmit事件 -->
                        <div class="form-group">
                            <label for="account">帳號</label>
                            <input type="text" class="form-control" id="account" name="account">
                            <small class="form-text">填寫帳號</small>
                        </div>
                        <div class="form-group">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text">填寫密碼</small>
                        </div>

                        <button type="submit" class="btn btn-primary">登入</button>
                        <!-- button沒有特別宣告type則預設就是su預設就是submit。如如果不想直接提交那要設定type:button -->
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


<?php include __DIR__ . './partials/scripts.php'; ?>
<script>
    function sendForm(){
        let isPass = true;
        // 先預設是true會通過，然後通過檢查，如果有誤就false;如果相反先寫false然後下方一堆條件再true通過則需要設很多判斷式，比較麻煩。

        document.getElementById('account').nextElementSibling.style.display ='none';
        document.getElementById('password').nextElementSibling.style.display ='none';
        //表單檢查前要先把它關掉，如果上次檢查有誤，出現紅色提示字，那這次就算填了正確的資料，也會是紅色的提示字。所以要讓他reset讓她回復成原來的狀態。

        // document.getElementById 在 DOM 應用中相當的常見，用來取得頁面中特定 id 的元素值，與 document.getElementById 類似的語法還包含了像是 document.getElementByName 或是 document.getElementByTagName

        // document.getElementById 基本語法:document.getElementById("id");
        if(! document.getElementById('account').value){
            document.getElementById('account').nextElementSibling.style.display ='block';
            isPass = false ;
            //.form1.account.原本
            // form1表單的account欄位的值
        }
        // if(! document.form1.password.value)
        if(! document.getElementById('password').value){
            document.getElementById('password').nextElementSibling.style.display ='block';
            isPass = false ;
            // .form1.password.
        }
        
        if(isPass){

            const fd = new FormData(document.getElementById("form1"));

            fetch('login-api.php',{
                method:'POST',
                body:fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log('result', obj);
                if(obj.success){
                    location.href ='index_.php'; //跳轉到別的頁面
                }else {
                    alert(obj.error);
                    //偷懶XD
                }
            });
        }
        // 如果通過檢查才發送ajax
    }
    
</script>
<?php include __DIR__ . './partials/html-foot.php'; ?>
<!-- 用這種方式，修改與維護方便，不用每一個檔案都開起來改，改原檔案，其他include的都一起改。
這樣此檔案就能當基本版型檔案，改中間container部分就可 -->