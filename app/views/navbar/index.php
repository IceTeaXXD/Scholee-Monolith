<div class="navbar-body">
    <nav>
        <a href="/">
            <div class="logo">
                <span class="logo-text">Beasis Wah</span>
            </div>
        </a>
        <div class="hamburger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <ul class="nav-links">
            <?php 
                if (isset($_SESSION['username'])) { 
                    if($_SESSION['role'] == 'student'){
            ?>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="">Jason</a></li>
                <li><a href="/scholarships">List Beasiswa</a></li>
                <li><a href="">Bookmark</a></li>
                <li><a href="">Cek CV</a></li>
                <div class="dropdown">
                    <a href="#" class="dropbtn"><?php echo $_SESSION['username']; ?></a>
                    <div class="dropdown-content">
                        <a href="/profile">Profile</a>
                        <a href="/api/user/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        <?php   } else if ($_SESSION['role'] == 'admin') {?>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/scholarships/add">Add Beasiswa</a></li>
            <li><a href=" /scholarships">List Beasiswa</a></li>
            <div class="dropdown">
                <a href="#" class="dropbtn"><?php echo $_SESSION['username']; ?></a>
                <div class="dropdown-content">
                    <a href="/profile">Profile</a>
                    <a href="/api/user/logout.php">Logout</a>
                </div>
            </div>
            <?php 
                    } else if ($_SESSION['role'] == 'super admin') {
            ?>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/admin/add">Add User</a></li>
            <li><a href="/admin/list">List User</a></li>
            <div class="dropdown">
                <a href="#" class="dropbtn"><?php echo $_SESSION['username']; ?></a>
                <div class="dropdown-content">
                    <a href="/profile">Profile</a>
                    <a href="/api/user/logout.php">Logout</a>
                </div>
            </div>
            <?php
                    }
                } else { 
            ?>
                <li><a href="/">Home</a></li>
                <li><a href="">Nadil</a></li>
                <li><a href="">Our Products</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">Contact Us</a></li>
                <li><button class="login-button" onclick="redirectToLogin()"><a>Login</a></button></li>
            <?php 
                } 
            ?>
        </ul>
    </nav>
</div>

<script src="/public/js/navbar.js"></script>