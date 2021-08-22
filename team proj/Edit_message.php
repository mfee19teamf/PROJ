<?php
    include __DIR__. '/partials/init.php';
    $title = '修改資料';

    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

    $sql = "SELECT * FROM `invitation` WHERE sid=$sid";

 //    echo $sql; exit;

    $r = $pdo->query($sql)->fetch();

    if(empty($r)){
        header('Location: History_message.php');
        exit;
    }
    // echo json_encode($r, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增訊息</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        form .form-group small {
            color: red;
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



            <form name="form1" onsubmit="checkForm(); return false;">
                <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                <div class="form-group">
                    <label for="exampleFormControlInput1">設計師姓名</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= htmlentities($r['name']) ?>">
                    <small class="form-text "></small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">您的信箱</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?= htmlentities($r['email']) ?>">
                    <small class="form-text "></small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">邀約訊息</label>
                    <textarea class="form-control" col= "30" rows="3" id="message" name="message" ><?= htmlentities($r['message']) ?></textarea>
                    <small class="form-text "></small>
                </div>
                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
        </div>
    </div>
</div>



<script>
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    const name = document.querySelector('#name');
    const email = document.querySelector('#email');

    function checkForm(){
        // 欄位的外觀要回復原來的狀態
        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px #CCCCCC solid';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';

        let isPass = true;
        if(name.value.length < 2){
            isPass = false;
            name.nextElementSibling.innerHTML = '請填寫正確的姓名';
            name.style.border = '1px red solid';
        }

        if(! email_re.test(email.value)){
            isPass = false;
            email.nextElementSibling.innerHTML = '請填寫正確的 Email 格式';
            email.style.border = '1px red solid';
        }

        if(isPass){
            const fd = new FormData(document.form1);
            fetch('Edit_message_api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功');
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error=>{
                    console.log('error:', error);
                });
            }
        }
</script>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>