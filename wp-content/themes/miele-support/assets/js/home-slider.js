/**
 * Home slider drag scroll and wheel scroll
 */
document.addEventListener('DOMContentLoaded', function() {
    const wrappers = document.querySelectorAll('.home-slider__wrapper');
    
    wrappers.forEach(function(wrapper) {
        let isDown = false;
        let startX;
        let scrollLeft;
        
        // Mouse events for drag scroll
        wrapper.addEventListener('mousedown', function(e) {
            isDown = true;
            wrapper.classList.add('active');
            startX = e.pageX - wrapper.offsetLeft;
            scrollLeft = wrapper.scrollLeft;
        }, { passive: true });
        
        wrapper.addEventListener('mouseleave', function() {
            isDown = false;
            wrapper.classList.remove('active');
        }, { passive: true });
        
        wrapper.addEventListener('mouseup', function() {
            isDown = false;
            wrapper.classList.remove('active');
        }, { passive: true });
        
        wrapper.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - wrapper.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            wrapper.scrollLeft = scrollLeft - walk;
        });
        
        // Wheel scroll - horizontal scroll with mouse wheel
        wrapper.addEventListener('wheel', function(e) {
            if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                e.preventDefault();
                wrapper.scrollLeft += e.deltaY;
            }
        }, { passive: false });
    });
});