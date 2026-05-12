document.addEventListener('DOMContentLoaded', function () {
    const grids = document.querySelectorAll('.js-news-archive-grid');
    if (!grids.length) return;

    const desktopMq = window.matchMedia('(min-width: 1024px)');
    const tabletMq = window.matchMedia('(min-width: 744px) and (max-width: 1023px)');

    function getLimit() {
        if (desktopMq.matches) return 9;
        if (tabletMq.matches) return 8;
        return null;
    }

    function applyGrid(grid) {
        const section = grid.closest('.container-fluid');
        if (!section) return;
        const button = section.querySelector('.js-news-archive-load-more');
        const cards = Array.from(grid.querySelectorAll('.news-card'));
        if (!button) return;

        cards.forEach((card) => {
            card.hidden = false;
        });

        const limit = getLimit();
        if (!limit || cards.length <= limit) {
            button.parentElement.style.display = limit ? 'none' : 'none';
            return;
        }

        cards.forEach((card, idx) => {
            if (idx >= limit) card.hidden = true;
        });

        button.parentElement.style.display = 'flex';
        button.onclick = function () {
            cards.forEach((card) => {
                card.hidden = false;
            });
            button.parentElement.style.display = 'none';
        };
    }

    function init() {
        grids.forEach(applyGrid);
    }

    init();
    window.addEventListener('resize', init);
});
