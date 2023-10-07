<div class="LoginPage">
    <div class="LeftColumn">
        <div class="SectionText">
            <div class="Top">
                <div class="SecondaryHeadline">Reset Your Password</div>
            </div>
        </div>
        <form class="login-form" method="post" action="/api/user/resetpassword.php">
            <div class="TextField">
                <div class="LabelAndField">
                    <div class="Label">Email Address</div>
                    <div class="Field">
                        <input type="text" class="Text" placeholder="Enter your email address" name="email">
                    </div>
                </div>
            </div>
            <button type="submit" class="Button">
                <div class="TextContainer">
                    <div class="ButtonText">Reset Password</div>
                </div>
            </button>
        </form>
    </div>
    <div class="RightColumn"></div>
</div>