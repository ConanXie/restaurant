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