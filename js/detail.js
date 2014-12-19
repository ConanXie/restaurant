var nav = {
    way: 'show-detail',
    detail: document.querySelector('#show-detail'),
    detailBox: document.querySelector('#detail'),
    evaluate: document.querySelector('#show-evaluate'),
    evaluateBox: document.querySelector('#evaluate')
};
nav.detail.addEventListener('click', function (e) {
    if (nav.way === e.target.id) {
        return;
    }
    nav.way = 'show-detail';
    nav.evaluateBox.style.display = 'none';
    nav.detailBox.style.display = 'block';
    e.target.className = 'now-box';
    nav.evaluate.className = '';
}, false);
nav.evaluate.addEventListener('click', function (e) {
    if (nav.way === e.target.id) {
        return;
    }
    nav.way = 'show-evaluate';
    nav.evaluateBox.style.display = 'block';
    nav.detailBox.style.display = 'none';
    e.target.className = 'now-box';
    nav.detail.className = '';
}, false);

var cart = {
    addCart: document.querySelector('#add-cart')
};
cart.addCart.addEventListener('click', function (e) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.responseText == 'success') {
                alert('已添加到购物车');
            } else {
                alert('请先登录');
            }
        }
    };
    xhr.open('post', 'addcart.php', true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xhr.send('userid=' + USERID + '&dishid=' + DISHID);
}, false);