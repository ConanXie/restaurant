var calculate = {
    allCart: document.querySelectorAll('.checkbox'),
    checkAll: document.querySelector('#check-all'),
    showPrice: document.querySelector('#sum-price'),
    sumPrice: 0,
    calPrice: function () {
        this.sumPrice = 0;
        for (var i = 0, len = this.allCart.length; i < len; i++) {
            if (this.allCart[i].checked) {
                var parent = this.allCart[i].parentNode.parentNode;
                this.sumPrice += parseInt(parent.dataset.num)*parent.dataset.price;
            }
        }
        this.showPrice.innerHTML = this.sumPrice;
    },
    checkAllDish: function () {
        var that = this;
        this.checkAll.addEventListener('click', function () {
            for (var i = 0, len = that.allCart.length; i < len; i++) {
                if (that.allCart[i].parentNode.parentNode.style.display == 'none') {
                    continue;
                }
                that.allCart[i].checked = that.checkAll.checked;
            }
            that.calPrice();
        }, false);
    }
};
calculate.checkAllDish();
var Cart = function (node) {
    this.node = node;
    this.num = this.node.dataset.num;
    this.check = this.node.querySelector('.checkbox');
    this.dishNum = this.node.querySelector('.dish-num');
    this.editBtn = this.node.querySelector('.edit-btn');
    this.editBox = this.node.querySelector('.edit-box');
    this.subtractBtn = this.node.querySelector('.subtract-btn');
    this.numNow = this.node.querySelector('.num-now');
    this.plusBtn = this.node.querySelector('.plus-btn');
    this.deleteBtn = this.node.querySelector('.delete-btn');
    this.finishBth = this.node.querySelector('.finish-btn');
    this.init();
};
Cart.prototype = {
    init: function () {
        this.showEdit();
        this.finishEdit();
        this.subtractOne();
        this.plusOne();
        this.deleteCart();
        this.checkDish();
    },
    checkDish: function () {
        this.check.addEventListener('click', function () {
            calculate.calPrice();
            if (!this.checked) {
                calculate.checkAll.checked = this.checked;
            }
        }, false);
    },
    showEdit: function () {
        var that = this;
        this.editBtn.addEventListener('click', function (e) {
            that.editBox.style.display = 'block';
        }, false);
    },
    finishEdit: function () {
        var that = this;
        this.finishBth.addEventListener('click', function (e) {
            if (that.node.dataset.num === that.numNow.value) {
                that.editBox.style.display = 'none';
                return;
            }
            that.cartAjax({
                way: 'edit',
                cartid: that.node.dataset.cartid,
                num: that.numNow.value
            });
            that.editBox.style.display = 'none';
            that.node.dataset.num = that.numNow.value;
            that.dishNum.innerHTML = 'x' + that.numNow.value;
            calculate.calPrice();
        }, false);
    },
    subtractOne: function () {
        var that = this;
        this.subtractBtn.addEventListener('click', function (e) {
            if (that.numNow.value === '1') {
                alert('不能再少了');
                return;
            }
            that.numNow.value = parseInt(that.numNow.value) - 1;
        }, false);
    },
    plusOne: function () {
        var that = this;
        this.plusBtn.addEventListener('click', function (e) {
            that.numNow.value = parseInt(that.numNow.value) + 1;
        }, false);
    },
    deleteCart: function () {
        var that = this;
        this.deleteBtn.addEventListener('click', function (e) {
            if (confirm('确定删除？')) {
                that.node.style.display = 'none';
                that.check.checked = false;
                calculate.calPrice();
                that.cartAjax({
                    way: 'delete',
                    cartid: that.node.dataset.cartid,
                    dishid: that.node.dataset.dishid
                });
            }
        }, false);
    },
    cartAjax: function (obj) {
        var xhr = new XMLHttpRequest();
        var that = this;
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                // console.log(xhr.responseText);
            }
        };
        xhr.open('post', 'manacart.php', true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.send('way=' + obj.way + '&cartid=' + obj.cartid + '&num=' + obj.num + '&dishid=' + obj.dishid);
    }
};
var cartBox = document.querySelectorAll('.cart-box');
for (var i = 0, len = cartBox.length; i < len; i++) {
    new Cart(cartBox[i]);
}