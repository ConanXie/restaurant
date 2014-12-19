// 菜肴列表管理类
var Dish = function (cate) {
    this.dishBox = document.querySelector('#dish-box');
    this.load = document.querySelector('#load-more');
    this.page = 2;
    this.isAjax = 1;
    this.ruleList = document.querySelector('#rule-list');
    this.nowSort = document.querySelector('#now-sort');
    this.sortRule = document.querySelectorAll('.sort-rule');
    this.rule = 'default';
    this.cate = cate;

    this.init();
};
Dish.prototype = {
    init: function () {
        var that = this;
        if (this.nowSort) {
            this.nowSort.addEventListener('click', function (e) {
                that.ruleList.style.display = 'block';
                e.stopPropagation();
            }, false);
        }
        document.body.addEventListener('click', function (e) {
            if (that.ruleList) {
                that.ruleList.style.display = 'none';
            }
            e.stopPropagation();
        }, false);
        this.ruleEvent();
    },
    initData: function () {
        this.page = 1;
        this.isAjax = 1;
    },
    ruleEvent: function () {
        var that = this;
        for (var i = 0, len = that.sortRule.length; i < len; i++) {
            this.sortRule[i].addEventListener('click', function (e) {
                if (e.target.dataset.rule != that.rule) {
                    that.clearDish();
                    that.initData();
                    that.rule = e.target.dataset.rule;
                    that.loadMore();
                    for (var i = 0, len = that.sortRule.length; i < len; i++) {
                        that.sortRule[i].className = 'sort-rule';
                    }
                    e.target.className = 'sort-rule now-rule';
                    that.nowSort.innerHTML = e.target.innerHTML + '<span>&#xe8a1;</span>'
                }
                that.ruleList.style.display = 'none';
                e.stopPropagation();
            }, false);
        }
    },
    clearDish: function () {
        var page = document.querySelectorAll('.page');
        for (var i = 0, len = page.length; i < len; i++) {
            this.dishBox.removeChild(page[i]);
        }
        this.load.style.display = 'block';
    },
    loadMore: function () {
        if (this.isAjax) {
            var that = this;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 1) {
                    window.onscroll = null;
                }
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == 'no more') {
                        that.isAjax = 0;
                        that.load.style.display = 'none';
                        return;
                    }
                    var div = document.createElement('div');
                    div.className = 'page';
                    div.innerHTML = xhr.responseText;
                    that.dishBox.appendChild(div);
                    that.page++;
                    window.onscroll = that.onscroll;
                }
            };
            xhr.open('get', 'loadmore.php?cate=' + that.cate + '&page=' + that.page + '&rule=' + that.rule, true);
            xhr.send(null);
        }
    },
    onscroll: function () {
        var scrollBottom = document.body.scrollHeight - document.body.scrollTop - document.documentElement.clientHeight;
        var that = this;
        if (scrollBottom <= 47) {
            theDish.loadMore();
        }
    }
};
window.onload = function () {
    var menuButton = document.querySelector('#menu-button'),
        shade = document.querySelector('#shade'),
        aside = document.querySelector('aside');
    menuButton.addEventListener('click', function () {
        shade.style.display = 'block';
        document.documentElement.style.overflowY = 'hidden';
        aside.style.webkitTransform = 'translateX(0)';
    }, false);
    shade.addEventListener('click', function () {
        shade.style.display = 'none';
        document.documentElement.style.overflowY = 'auto';
        aside.style.webkitTransform = 'translateX(-110%)';
    });

};