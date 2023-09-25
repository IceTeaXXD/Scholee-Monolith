<div class="login-page">
    <div class="form">
        <form method="post" action = "/api/user/login.php">
            <h2></i> Login</h2>
            <input type="text" name="username" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" class="btn" href="#">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Sign in
            </button>
            <?php
            if(isset($data['error'])){
            ?>
                <div class="alert alert-danger"><?php echo "Login Gagal"; ?></div>
            <?php
            }
            ?>
            <p class="message">Not registered? <a href="/register">Create an account</a></p>
        </form>
    </div>
</div>