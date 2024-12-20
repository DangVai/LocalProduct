<div class="header">
    <div class="box_logo">
        <img src="/public/images/logo.j" alt="">
    </div>
    <div class="nav">
        <p><b>Home</b></p>
        <p><b>Thời Trang</b></p>
        <p><b>Ẩm thực</b></p>
         <p><b>Khác</b></p>
    </div>
    
    <div class="account">
        <div class="box-account">
            <i class="fa-regular fa-user"></i>
        </div>
    </div>
    <div class="name-user">
        <p>
            <?php echo ($userName) ?>
        </p>
        <div class="dropdown-menu" id="account-menu">
            <div>
                <a href="../public/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
            </div>
            <div>
                <a href=""><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings</a>
            </div>
            <div>
                <a href=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
            </div>
            <div>
                <a href="public/login.php"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log in</a>
            </div>
            <div>
                <a href="controllers/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log out</a>
            </div>
        </div>
    </div>
</div>