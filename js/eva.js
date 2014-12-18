var eva = {
    way: 'show-detail',
    detail: document.querySelector('#show-detail'),
    detailBox: document.querySelector('#detail'),
    evaluate: document.querySelector('#show-evaluate'),
    evaluateBox: document.querySelector('#evaluate')
};
eva.detail.addEventListener('click', function (e) {
    if (eva.way === e.target.id) {
        return;
    }
    eva.way = 'show-detail';
    eva.evaluateBox.style.display = 'none';
    eva.detailBox.style.display = 'block';
    e.target.className = 'now-box';
    eva.evaluate.className = '';
}, false);
eva.evaluate.addEventListener('click', function (e) {
    if (eva.way === e.target.id) {
        return;
    }
    eva.way = 'show-evaluate';
    eva.evaluateBox.style.display = 'block';
    eva.detailBox.style.display = 'none';
    e.target.className = 'now-box';
    eva.detail.className = '';
}, false);