/**
 * Home catalog drag scroll and wheel scroll
 */
document.addEventListener('DOMContentLoaded', function() {
    const grids = document.querySelectorAll('.home-catalog__grid');
    
    grids.forEach(function(grid) {
        let isDown = false;
        let startX;
        let scrollLeft;
        
        // Mouse events for drag scroll
        grid.addEventListener('mousedown', function(e) {
            isDown = true;
            grid.classList.add('active');
            startX = e.pageX - grid.offsetLeft;
            scrollLeft = grid.scrollLeft;
        }, { passive: true });
        
        grid.addEventListener('mouseleave', function() {
            isDown = false;
            grid.classList.remove('active');
        }, { passive: true });
        
        grid.addEventListener('mouseup', function() {
            isDown = false;
            grid.classList.remove('active');
        }, { passive: true });
        
        grid.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - grid.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            grid.scrollLeft = scrollLeft - walk;
        });
        
        // Wheel scroll - horizontal scroll with mouse wheel
        grid.addEventListener('wheel', function(e) {
            if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                e.preventDefault();
                grid.scrollLeft += e.deltaY;
            }
        }, { passive: false });
    });
});