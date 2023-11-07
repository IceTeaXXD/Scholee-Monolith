<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<div class="navbar-body">
    <nav>
        <div class="logo">
            <a href="/">
                <img src="/public/image/assets/navbar/logo-4.svg" alt="logo">
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
                    <li><a href="/scholarships">Scholarships</a></li>
                    <li><a href="/bookmarks">Bookmarks</a></li>
                    <li><a href="/registration">Registration</a></li>
                    <div class="dropdown">
                        <a class="dropdownHead">Document Preparation<span class="arrow-down-nav"></span></a>
                        <div class="dropdown-content">
                            <a href="/reviews">Check Document Review</a>
                            <a href="/reviews/add">Add Document</a>
                        </div>
                    </div>
                    <li><a href="/aboutus">About Us</a></li>
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
                    <li><a href="/scholarships/add">Add Scholarship</a></li>
                    <li><a href=" /scholarships">Scholarships</a></li>
                    <li><a href="/aboutus">About Us</a></li>
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
                    <li><a href="/aboutus">About Us</a></li>
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
                    <li><a href="/aboutus">About Us</a></li>
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
                <li><a href="/aboutus">About Us</a></li>
                <li class="login-button-container">
                    <button class="login-button" onclick="redirectToLogin()"><a>Login</a></button>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</div>

<script src="/public/js/navbar.js"></script>