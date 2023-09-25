<div class="register-page">
    <div class="form">
        <form id="register-form" method="post" action="/api/user/register.php">
            <h2>Register</h2>
            <input type="text" placeholder="Full Name *" name="name" required />
            <input type="email" placeholder="Email *" name="email" required />
            <input type="password" placeholder="Password *" name="password" required />
            <button type="submit" class="btn">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Register
            </button>
            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger"><?php echo $data['error']; ?></div>
            <?php endif; ?>
            <p class="message">Already registered? <a href="/login">Sign In</a></p>
        </form>
    </div>
</div>
