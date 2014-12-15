<?php
    require('header.php');
?>
<link rel="stylesheet" href="css/joinin.css">
<div id="join-box">
    <div class="join-nav">
        <div id="login" class="now-form">登录</div>
        <div id="signup">注册</div>
    </div>
    <div class="login-box">
        <form action="loginVerify.php" method="post" name="login" onsubmit="return loginForm.checkForm();">
            <input type="text" id="login-username" name="username" placeholder="用户名/邮箱" required autocomplete="on" value="" />
            <input type="password" id="login-password" name="password" placeholder="密码" required autocomplete="on" value="" />
            <input type="submit" name="submit" value="登录" />
            <div id="login-error" class="error-box"></div>
        </form>
        <a href="">忘记密码？</a>
    </div>
    <div class="signup-box">
        <form action="index.php" method="post" name="signup" onsubmit="return signupForm.checkForm();">
            <input type="text" id="signup-username" name="username" placeholder="用户名" required />
            <input type="password" id="signup-password" name="password" placeholder="密码" required />
            <input type="email" id="email" name="email" placeholder="邮箱" required />
            <input type="submit" name="submit" value="注册" />
            <div id="signup-error" class="error-box"></div>
        </form>
    </div>
    <script src="js/joinin.js"></script>
</div>
<?php
    require('footer.php');
?>