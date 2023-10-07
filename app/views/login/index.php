<div class="LoginPage">
    <div class="LeftColumn">
        <div class="SectionText">
            <div class="Top">
                <div class="SecondaryHeadline">Log In</div>
            </div>
        </div>
        <form class="login-form" method="post">
            <div class="TextField">
                <div class="LabelAndField">
                    <div class="Label">Email Address</div>
                    <div class="Field">
                        <input type="text" class="Text" placeholder="Enter your email address" name="email">
                    </div>
                </div>
            </div>
            <div class="TextField">
                <div class="LabelAndField">
                    <div class="Label">Password</div>
                    <div class="Field">
                        <input type="password" class="Text" placeholder="Enter your password" name="password" id="password">
                    </div>
                </div>
                <div class="ErrorText"></div>
            </div>
            <button type="submit" class="Button">
                <div class="TextContainer">
                    <div class="ButtonText">Log In</div>
                </div>
            </button>
            <div class="NoAccountYetSignUp">No account yet? <a href="/register">Sign Up</a></div>
            <div class="NoAccountYetSignUp">Forgot your password? <a href="/resetpassword">Reset Password</a></div>
        </form>
    </div>
    <div class="RightColumn"></div>
</div>
<script src="/public/js/login.js"></script>