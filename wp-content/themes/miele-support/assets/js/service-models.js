/**
 * Service models:
 * - Tablet (744-1023): "See More" loads cards in batches when total > 12
 * - Mobile (<744): horizontal slider via CSS only
 */
document.addEventListener('DOMContentLoaded', function () {
    const TABLET_QUERY = '(min-width: 744px) and (max-width: 1023px)';
    const INITIAL_VISIBLE = 12;
    const LOAD_STEP = 6;

    function applyTabletMode(section) {
        const grid = section.querySelector('.service-models__grid');
        const button = section.querySelector('.service-models__see-more');
        if (!grid || !button) return;

        const items = Array.from(grid.querySelectorAll('.service-models__item'));
        const total = items.length;
        const isTablet = window.matchMedia(TABLET_QUERY).matches;

        items.forEach((item) => item.classList.remove('service-models__item--tablet-hidden'));

        if (!isTablet || total <= INITIAL_VISIBLE) {
            button.hidden = true;
            button.disabled = true;
            return;
        }

        button.hidden = false;
        button.disabled = false;

        let visibleCount = INITIAL_VISIBLE;
        items.slice(visibleCount).forEach((item) => item.classList.add('service-models__item--tablet-hidden'));

        button.onclick = function () {
            visibleCount = Math.min(visibleCount + LOAD_STEP, total);
            items.slice(0, visibleCount).forEach((item) => item.classList.remove('service-models__item--tablet-hidden'));

            if (visibleCount >= total) {
                button.hidden = true;
                button.disabled = true;
            }
        };
    }

    function init() {
        document.querySelectorAll('.service-models').forEach(applyTabletMode);
    }

    init();
    window.addEventListener('resize', init);
});
