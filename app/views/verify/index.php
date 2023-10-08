<div class="verify">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="verify-text">
                <?php if (isset($data['token'])) : ?>
                    <h1 class="Title"> Account Verified</h1>
                    <p class="Message">Thank you for verifying your account. You can now login to your account.</p>
                <?php else : ?>
                    <h1 class="Title">Verify your account</h1>
                    <p class="Message">Thank you for registering. Please check your email to verify your account.</p>
                    <?php endif; ?>
                    <a href="/login">Click here to login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/public/js/verify.js"></script>