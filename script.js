const stars = document.querySelectorAll('.rating input');

stars.forEach(star => {
    star.addEventListener('click', (e) => {
        stars.forEach(s => s.removeAttribute('checked'));
        let clickedStar = e.target;
        clickedStar.setAttribute('checked', 'checked');
    });
});
