
//flèches pour chaque section et mouvement lors du clique
var sections = document.querySelectorAll('.films-section');
sections.forEach(function (section) {
    var scrollWrapper = section.querySelector('.scrolling-wrapper');
    var scrollStep = 200;
    var scrollButtons = section.querySelectorAll('.scroll-btn');
    scrollButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (button.classList.contains('left')) {
                scrollWrapper.scrollLeft -= scrollStep;
            } else {
                scrollWrapper.scrollLeft += scrollStep;
            }
        });
    });
});


$('.carousel').carousel();

