var Join = function () {
    this.way = 'login';
    this.login = document.querySelector('#login');
    this.loginBox = document.querySelector('.login-box');
    this.signup = document.querySelector('#signup');
    this.signupBox = document.querySelector('.signup-box');

    var that = this;
    this.login.addEventListener('click', function (e) {
        if (that.way === e.target.id) {
            return;
        }
        that.way = 'login';
        that.signupBox.style.display = 'none';
        that.loginBox.style.display = 'block';
        e.target.className = 'now-form';
        that.signup.className = '';
    }, false);
    this.signup.addEventListener('click', function (e) {
        if (that.way === e.target.id) {
            return;
        }
        that.way = 'signup';
        that.loginBox.style.display = 'none';
        that.signupBox.style.display = 'block';
        e.target.className = 'now-form';
        that.login.className = '';
    }, false);
};
var theJoin = new Join();

var loginForm = {
    form: document.login,
    username: document.login.username,
    password: document.login.password,
    errorBox: document.querySelector('#login-error'),
    isUserPass: 1,
    isPwPass: 1,
    usernamePattern: /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$|^[\w\d]+$/,
    passwordPattern: /^[\w\d]+$/,

    init: function () {
        this.verityUsername();
        this.verityPassword();
    },
    verityUsername: function () {
        var that = this;
        this.username.addEventListener('blur', function (e) {
            if (this.value.length < 4) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '用户名长度小于4';
                that.isUserPass = 0;
                return;
            }
            if (!that.usernamePattern.test(this.value)) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '邮箱格式错误，或者用户名包含除字母、数字、下划线之外的其他字符';
                that.isUserPass = 0;
                return;
            }
            var xhr = new XMLHttpRequest();
            var self = this;
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.responseText == 'no user') {
                        that.errorBox.style.display = 'block';
                        that.errorBox.style.top = self.offsetTop + 42 + 'px';
                        that.errorBox.innerHTML = '用户名或邮箱不存在';
                        that.isUserPass = 0;
                    } else {
                        that.isUserPass = 1;
                        that.errorBox.style.display = 'none';
                    }
                }
            };
            xhr.open('post', 'verify.php', true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send('username=' + self.value);
        }, false);
    },
    verityPassword: function () {
        var that = this;
        this.password.addEventListener('blur', function (e) {
            if (this.value.length < 6) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '密码长度小于6';
                that.isPwPass = 0;
                return;
            }
            if (!that.passwordPattern.test(this.value)) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '密码包含除字母、数字、下划线之外的其他字符';
                that.isPwPass = 0;
                return;
            }
            var xhr = new XMLHttpRequest();
            var self = this;
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.responseText == 'password error') {
                        that.errorBox.style.display = 'block';
                        that.errorBox.style.top = self.offsetTop + 42 + 'px';
                        that.errorBox.innerHTML = '密码错误';
                        that.isPwPass = 0;
                    } else {
                        that.isPwPass = 1;
                        that.errorBox.style.display = 'none';
                    }
                }
            };
            xhr.open('post', 'verify.php', true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send('username=' + that.username.value + '&password=' + this.value);
        }, false);
    },
    checkForm: function () {
        console.log(this.isUserPass +', ' + this.isPwPass)
        if (!this.isUserPass || !this.isPwPass) {
            return false;
        }
    }
};
loginForm.init();

var signupForm = {
    form: document.signup,
    username: document.signup.username,
    password: document.signup.password,
    email: document.signup.email,
    errorBox: document.querySelector('#signup-error'),
    isUserPass: 0,
    isPwPass: 0,
    isEmailPass: 0,
    usernamePattern: /^[\w\d]+$/,
    passwordPattern: /^[\w\d]+$/,
    emailPattern: /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/,

    init: function () {
        this.verityUsername();
        this.verityPassword();
        this.verityEmail();
    },
    verityUsername: function () {
        var that = this;
        this.username.addEventListener('blur', function (e) {
            if (this.value.length < 4) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '用户名长度小于4';
                that.isUserPass = 0;
                return;
            }
            if (!that.usernamePattern.test(this.value)) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '用户名包含除字母、数字、下划线之外的其他字符';
                that.isUserPass = 0;
                return;
            }
            var xhr = new XMLHttpRequest();
            var self = this;
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.responseText == 'user exist') {
                        that.errorBox.style.display = 'block';
                        that.errorBox.style.top = self.offsetTop + 42 + 'px';
                        that.errorBox.innerHTML = '该用户名已注册';
                        that.isUserPass = 0;
                    } else {
                        that.isUserPass = 1;
                        that.errorBox.style.display = 'none';
                    }
                }
            };
            xhr.open('post', 'verify.php', true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send('username=' + this.value);
        }, false);
    },
    verityPassword: function () {
        var that = this;
        this.password.addEventListener('blur', function (e) {
            if (this.value.length < 6) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '密码长度小于6';
                that.isPwPass = 0;
                return;
            }
            if (!that.passwordPattern.test(this.value)) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '密码包含除字母、数字、下划线之外的其他字符';
                that.isPwPass = 0;
                return;
            }
            that.isPwPass = 1;
            that.errorBox.style.display = 'none';
        }, false);
    },
    verityEmail: function () {
        var that = this;
        this.email.addEventListener('blur', function (e) {
            if (!that.emailPattern.test(this.value)) {
                that.errorBox.style.display = 'block';
                that.errorBox.style.top = this.offsetTop + 42 + 'px';
                that.errorBox.innerHTML = '邮箱格式错误';
                that.isEmailPass = 0;
                return;
            }
            var xhr = new XMLHttpRequest();
            var self = this;
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.responseText == 'user exist') {
                        that.errorBox.style.display = 'block';
                        that.errorBox.style.top = self.offsetTop + 42 + 'px';
                        that.errorBox.innerHTML = '该邮箱已注册';
                        that.isEmailPass = 0;
                    } else {
                        that.isEmailPass = 1;
                        that.errorBox.style.display = 'none';
                    }
                }
            };
            xhr.open('post', 'verify.php', true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send('username=' + this.value);
        }, false);
    },
    checkForm: function () {
        if (!this.isUserPass || !this.isPwPass || !this.isEmailPass) {
            return false;
        }
    }
};
signupForm.init();