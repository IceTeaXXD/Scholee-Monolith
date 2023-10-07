<div class="RegisterPage">
    <div class="LeftColumn">
        <div class="SectionText">
            <div class="Top">
                <div class="SecondaryHeadline">Register</div>
            </div>
        </div>
        <form class="register-form" method="post">
            <div class="TextField">
                <div class="LabelAndField">
                    <div class="Label">Full Name</div>
                    <div class="Field">
                        <input type="text" class="Text" placeholder="Enter your full name" name="name" id="fullname" required />
                    </div>
                </div>
            </div>
            <div class="TextField">
                <div class="LabelAndField">
                    <div class="Label">Email Address</div>
                    <div class="Field">
                        <input type="email" class="Text" placeholder="Enter your email address" name="email" id="email" required />
                    </div>
                </div>
            </div>
            <div class="TextField">
                <div class="LabelAndField">
                    <div class="Label">Password</div>
                    <div class="Field">
                        <input type="password" class="Text" placeholder="Enter your password" name="password" id="password" required />
                    </div>
                </div>
                <div class="Description">It must be a combination of minimum 8 letters and numbers</div>
                <div class="ErrorText"></div>
            </div>
            <button type="submit" class="Button">
                <div class="TextContainer">
                    <div class="ButtonText">Register</div>
                </div>
            </button>
            <div class="NoAccountYetSignUp">Already have an account? <a href="/login">Sign In</a></div>
        </form>
    </div>
    <div class="RightColumn"></div>
</div>

<script src="/public/js/register.js"></script>