/**
 * Service models grid - See More toggle and drag/wheel scroll
 */
document.addEventListener('DOMContentLoaded', function() {
    // See More button functionality
    const seeMoreButtons = document.querySelectorAll('.service-models__see-more');
    
    seeMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const grid = this.closest('.service-models').querySelector('.service-models__grid');
            const buttonText = this.querySelector('.service-models__see-more-text');
            const buttonIcon = this.querySelector('.service-models__see-more-icon');
            
            // Toggle collapsed class
            grid.classList.toggle('service-models__grid--collapsed');
            
            // Update button text
            if (grid.classList.contains('service-models__grid--collapsed')) {
                buttonText.textContent = 'Показать еще';
                buttonIcon.style.transform = 'rotate(0deg)';
            } else {
                buttonText.textContent = 'Свернуть';
                buttonIcon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Legacy drag/wheel scroll (if wrapper exists)
    const wrappers = document.querySelectorAll('.service-models__wrapper');
    
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
