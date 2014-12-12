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
    var list = [
        {
            content: '<div class="list" id="list1"></div>'
        }, {
            content: '<div class="list" id="list2"></div>'
        }, {
            content: '<div class="list" id="list3"></div>'
        }
    ];
    var islider = new iSlider({
        type: 'dom',
        data: list,
        dom: document.getElementById('recommend'),
        isLooping: true,
        isAutoPlay: true,
        duration: 1000,
        onslidechange: function(idx) {
            islider.changeIndexDot();
        }
    });
    islider.renderDot({
            top: '230px',
            width: '90%',
            diameter: '0.8em',
            borderColor: '#fff',
    });
};