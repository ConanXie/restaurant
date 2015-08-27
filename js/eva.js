var evaluate = {
    shades: document.querySelector('.shades'),
    evaBtn: document.querySelectorAll('.evaluate'),
    form: document.evaluate,
    content: document.evaluate.content,
    starBtn: document.querySelectorAll('.star-btn'),
    star: 0,
    init: function () {
        this.bindEvent();
    },
    bindEvent: function () {
        var that = this;
        for (var i = 0, len = this.evaBtn.length; i < len; i++) {
            this.evaBtn[i].addEventListener('click', function () {
                that.dish = this.dataset.dish;
                that.detail = this.dataset.detail;
                that.nowEvaBtn = this;
                that.shades.style.display = 'block';
                that.form.style.display = 'block';
            }, false);
        }
        this.shades.addEventListener('click', function () {
            that.closeForm();
        });
        var stararr = ['', ['&#xe8f2;', '&#xe8f4;', '&#xe8f4;', '&#xe8f4;', '&#xe8f4;'],['&#xe8f2;', '&#xe8f2;', '&#xe8f4;', '&#xe8f4;', '&#xe8f4;'], ['&#xe8f2;', '&#xe8f2;', '&#xe8f2;', '&#xe8f4;', '&#xe8f4;'], ['&#xe8f2;', '&#xe8f2;', '&#xe8f2;', '&#xe8f2;', '&#xe8f4;'], ['&#xe8f2;', '&#xe8f2;', '&#xe8f2;', '&#xe8f2;', '&#xe8f2;']]
        for (var i = 0, len = this.starBtn.length; i < len; i++) {
            this.starBtn[i].addEventListener('click', function () {
                var star = this.dataset.star;
                that.star = parseInt(star);
                for (var i = 0; i < 5; i++) {
                    that.starBtn[i].innerHTML = stararr[parseInt(star)][i];
                }
            }, false);
        }
        this.form.addEventListener('submit', function () {
            if (!that.star) {
                alert('别忘了打分');
                return;
            }
            if (!that.content.value) {
                alert('留下几句话呗');
                return;
            }
            var str = 'dishid=' + that.dish + '&detail=' + that.detail + '&star=' + that.star + '&content=' + that.content.value;
            var dishBox = that.nowEvaBtn.parentNode;
            dishBox.removeChild(that.nowEvaBtn);
            var p1 = document.createElement('p');
            var time = new Date();
            p1.className = 'star';
            p1.innerHTML = stararr[that.star].join('') + ' ' + time.getFullYear() + '-' + (time.getMonth() + 1) + '-' + time.getDate() + ' ' + time.getHours() + ':' + time.getMinutes() + ':' + time.getSeconds();
            var p2 = document.createElement('p');
            p2.innerHTML = that.content.value;
            dishBox.appendChild(p1);
            dishBox.appendChild(p2);
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    console.log(xhr.responseText);
                }
            };
            xhr.open('post', 'eva.php', true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send(str);
            that.closeForm();
        });
    },
    closeForm: function () {
        this.shades.style.display = 'none';
        this.form.style.display = 'none';
        var stararr = ['&#xe8f4;', '&#xe8f4;', '&#xe8f4;', '&#xe8f4;', '&#xe8f4;'];
        for (var i = 0; i < 5; i++) {
            this.starBtn[i].innerHTML = stararr[i];
        }
        this.content.value = '';
        this.star = 0;
    }
};
evaluate.init();