<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<div class="navbar-body">
    <nav>
        <div class="logo">
            <a href="/">
                <img src="../../../public/image/logo-4.svg" alt="logo">
            </a>
        </div>
        <div class="hamburger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <ul class="nav-links">
            <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['role'] == 'student') {
            ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/scholarships">List Beasiswa</a></li>
                    <li><a href="/bookmarks">Bookmark</a></li>
                    <div class="dropdown">
                        <a class="dropdownHead">Document Preparation<span class="arrow-down"></span></a>
                        <div class="dropdown-content">
                            <a href="/reviews">Check Document Review</a>
                            <a href="/reviews/add">Add Document</a>
                        </div>
                    </div>
                    <div class="profile">
                        <a class="dropbtn">
                            <?php echo $_SESSION['username']; ?>
                            <span class="arrow-down"></span>
                        </a>
                        <div class="dropdown-content">
                            <a href="/profile">Profile</a>
                            <a href="/api/user/logout.php">Logout</a>
                        </div>
                    </div>
                <?php   } else if ($_SESSION['role'] == 'admin') { ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/scholarships/add">Add Beasiswa</a></li>
                    <li><a href=" /scholarships">List Beasiswa</a></li>
                    <div class="profile">
                        <a class="dropbtn">
                            <?php echo $_SESSION['username']; ?>
                            <span class="arrow-down"></span>
                        </a>
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
                    <div class="profile">
                        <a class="dropbtn">
                            <?php echo $_SESSION['username']; ?>
                            <span class="arrow-down"></span>
                        </a>
                        <div class="dropdown-content">
                            <a href="/profile">Profile</a>
                            <a href="/api/user/logout.php">Logout</a>
                        </div>
                    </div>
                <?php
                } else if ($_SESSION['role'] == 'reviewer') {
                ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/reviews">Review Documents</a></li>
                    <div class="profile">
                        <a class="dropbtn">
                            <?php echo $_SESSION['username']; ?>
                            <span class="arrow-down"></span>
                        </a>
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
                <li class="login-button-container">
                    <li><button class="login-button" onclick="redirectToLogin()"><a>Login</a></button></li>
            </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</div>

<script src="/public/js/navbar.js"></script>