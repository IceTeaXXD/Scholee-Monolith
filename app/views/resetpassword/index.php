<div class="LoginPage">
    <div class="LeftColumn">
        <div class="SectionText">
            <div class="Top">
                <div class="SecondaryHeadline">Reset Your Password</div>
            </div>
        </div>
        <!-- action="/api/user/resetpassword.php" -->
        <form class="login-form" method="post">
            <div class="TextField">
                <div class="LabelAndField">
                    <?php if (isset($data['token'])) : ?>
                        <div class="Label">New Password</div>
                        <div class="Field">
                            <input type="password" class="Text" placeholder="Enter your new password" name="password" id="password">
                        </div>
                        <div class="Label">Confirm New Password</div>
                        <div class="Field">
                            <input type="password" class="Text" placeholder="Confirm your new password" name="password2" id="password2">
                        </div>
                        <input type="hidden" class="Text" placeholder="Enter your token" name="token" value="<?= $data['token'] ?>">
                    <?php else : ?>
                        <div class="Label">Email Address</div>
                        <div class="Field">
                            <input type="email" class="Text" placeholder="Enter your email address" name="email" required>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="ErrorText"></div>
            <div class="SuccessText"></div>
            <?php if (isset($data['token'])) : ?>
                <button type="submit" class="Button" style="margin-top:150px">
            <?php else : ?>
                <button type="submit" class="Button">
            <?php endif; ?>
            <div class="TextContainer">
                <div class="ButtonText">Reset Password</div>
            </div>
            </button>
        </form>
    </div>
    <div class="RightColumn" style="background-image: url('/public/image/assets/log-reg/forgot.webp');"></div>
</div>
<script src="/public/js/resetpassword.js"></script>