var a = {
    num: document.querySelector('#num')
};
a.subtractNum = function (str) {
    if (this.num.value === '1') {
        alert('不能再少了');
        return;
    }
    this.num.value = parseInt(this.num.value) - 1;
}
a.addNum = function (str) {
    this.num.value = parseInt(this.num.value) + 1;
}