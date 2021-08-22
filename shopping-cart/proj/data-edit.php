<?php 
require __DIR__. '/__connect_db.php';


$title = '修改資料';

$sid =  isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "SELECT * FROM `order` WHERE sid=$sid";
// echo $sql; exit;
$row = $pdo->query($sql)->fetch();

if (empty($row)) {
    header('Location:data-list.php');
    exit;
}

// echo json_encode($row,JSON_UNESCAPED_UNICODE); exit;


?>






<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改訂單</h5>
                    <form name="form1" onsubmit="checkForm();return false;">
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>"> <!-- 傳送資料給另一個PHP -->
                        

                        <div class="form-group">
                            <label for="memberID" >memberID *</label>
                            <input type="text" disabled class="form-control" id="memberID" name="memberID" value="<?= htmlentities($row['memberID'])?>"> <!-- value 顯示資料 htmlentities()特殊字元顯示 -->
                            <small class="form-text "></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($row['name'])?>"> <!-- value 顯示資料 -->
                            <small class="form-text "></small>
                        </div>


                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($row['mobile'])?>"> <!-- value 顯示資料 -->
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group">
                            <label for="address">address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlentities($row['address'])?>"> <!-- value 顯示資料 -->
                            <small class="form-text "></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="orderprice">orderprice</label>
                            <input type="text" class="form-control" id="orderprice" name="orderprice" value="<?= htmlentities($row['orderprice'])?>"> <!-- value 顯示資料 -->
                            <small class="form-text "></small>
                        </div>
                        

                        <button type="submit" class="btn btn-primary">修改</button>
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
            fetch('data-edit-api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功');
                    } else {
                        alert(obj.error);
                    }
                })


            }
</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>