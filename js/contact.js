var contact = {
    contactList: document.querySelector('#contact-list'),
    deleteBtn: document.querySelectorAll('.delete'),
    editBtn: document.querySelectorAll('.edit'),
    addBtn: document.querySelector('#add-cont'),
    shades: document.querySelector('.shades'),
    form: document.cont,

    init: function () {
        this.bindEvent();
    },
    bindEvent: function () {
        var that = this;
        for (var i = 0, len = this.deleteBtn.length; i < len; i++) {
            this.deleteBtn[i].addEventListener('click', function () {
                this.parentNode.style.display = 'none';
                var id = this.dataset.id;
                that.manaAjax({
                    way: 'delete',
                    id: id
                });
            }, false);
        }
        for (i = 0; i < len; i++) {
            this.editBtn[i].addEventListener('click', function () {
                that.showForm();
                that.id = this.dataset.id;
                that.cont = this.parentNode.querySelector('.cont');
                that.form.name.value = that.cont.querySelector('.li-name').dataset.value;
                that.form.phone.value = that.cont.querySelector('.li-phone').dataset.value;
                that.form.address.value = that.cont.querySelector('.li-address').dataset.value;
                that.way = 'edit';
            }, false);
        }
        this.addBtn.addEventListener('click', function () {
            that.way = 'add';
            that.showForm();
            that.form.name.value = '';
            that.form.phone.value = '';
            that.form.address.value = '';
        }, false);
        this.shades.addEventListener('click', function () {
            that.hiddenForm();
        }, false);
        this.form.submit.addEventListener('click', function () {
            if (that.form.name.value == '' || that.form.phone.value == '' || that.form.address.value == '') {
                return;
            }
            that.hiddenForm();
            var name = that.form.name.value;
            var phone = that.form.phone.value;
            var address = that.form.address.value;
            if (that.way == 'edit') {
                that.cont.querySelector('.li-name').innerHTML = '联系人：' + name;
                that.cont.querySelector('.li-name').dataset.value = name;
                that.cont.querySelector('.li-phone').innerHTML = '电话：' + phone;
                that.cont.querySelector('.li-phone').dataset.value = phone;
                that.cont.querySelector('.li-address').innerHTML = '地址：' + address;
                that.cont.querySelector('.li-address').dataset.value = address;
            } else if (that.way == 'add') {
                var li = document.createElement('li');
                li.innerHTML = '<div class="cont"><p class="li-name" data-value="' + name + '">联系人：' + name + '</p><p class="li-phone" data-value="' + phone + '">电话：' + phone + '</p><p class="li-address" data-value="' + address + '">地址：' + address + '</p></div>';
                that.contactList.appendChild(li);
            }
            that.manaAjax({
                way: that.way,
                id: that.id,
                name: name,
                phone: phone,
                address: address
            });
        }, false);
    },
    manaAjax: function (obj) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
            }
        };
        xhr.open('post', 'manacont.php', true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.send('way=' + obj.way + '&id=' + obj.id + '&name=' + obj.name + '&phone=' + obj.phone + '&address=' + obj.address);
    },
    hiddenForm: function () {
        this.shades.style.display = 'none';
        this.form.style.display = 'none';
    },
    showForm: function () {
        this.shades.style.display = 'block';
        this.form.style.display = 'block';
    }
};
contact.init();