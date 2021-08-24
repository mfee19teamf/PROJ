    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto"> 
          <!-- mr-auto是marginRight-auto意即右方有一個margin而靠左 -->
            <li class="nav-item active">
              <a class="nav-link" href="data-list.php">藝廊</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="data-insert.php">新增</a>
            </li>
            
          </ul>
          
          <ul class="navbar-nav">
            <!-- 有登入的 -->
            <?php if(isset($_SESSION['user'])): ?>
            <!-- 沒有登入的時後才顯示這兩個按鈕 -->
            <li class="nav-item active">
              <a class="nav-link"><?= $_SESSION['user']['nickname']?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="profile-edit.php">編輯個人資料</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">登出</a>
            </li>
            <?php else: ?>
              <li class="nav-item active">
              <a class="nav-link" href="login.php">登入</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">註冊</a>
            </li>
            <?php endif; ?>
            
            
            
          </ul>
         
        </div>
        </div>
    </nav>