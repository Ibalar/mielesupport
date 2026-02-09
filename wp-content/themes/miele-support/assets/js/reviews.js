/**
 * Reviews carousel drag scroll and wheel scroll
 */
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.reviews__wrapper');
    
    sliders.forEach(function(slider) {
        let isDown = false;
        let startX;
        let scrollLeft;
        
        // Mouse events for drag scroll
        slider.addEventListener('mousedown', function(e) {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        }, { passive: true });
        
        slider.addEventListener('mouseleave', function() {
            isDown = false;
            slider.classList.remove('active');
        }, { passive: true });
        
        slider.addEventListener('mouseup', function() {
            isDown = false;
            slider.classList.remove('active');
        }, { passive: true });
        
        slider.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            slider.scrollLeft = scrollLeft - walk;
        });
        
        // Wheel scroll - horizontal scroll with mouse wheel
        slider.addEventListener('wheel', function(e) {
            if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                e.preventDefault();
                slider.scrollLeft += e.deltaY;
            }
        }, { passive: false });
    });
});
