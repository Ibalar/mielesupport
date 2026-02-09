/**
 * Services Page Accordion functionality
 */
(function() {
    'use strict';

    // Initialize after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initServicesAccordion();
    });

    function initServicesAccordion() {
        const accordionItems = document.querySelectorAll('[data-services-accordion-item]');
        
        if (!accordionItems.length) return;

        accordionItems.forEach(function(item) {
            const header = item.querySelector('.services-accordion__header');
            const content = item.querySelector('.services-accordion__content');
            
            if (!header || !content) return;

            header.addEventListener('click', function() {
                const isActive = item.classList.contains('is-active');
                
                // Close all other accordion items (optional - remove this block if you want multiple open)
                accordionItems.forEach(function(otherItem) {
                    if (otherItem !== item && otherItem.classList.contains('is-active')) {
                        closeItem(otherItem);
                    }
                });
                
                // Toggle current item
                if (isActive) {
                    closeItem(item);
                } else {
                    openItem(item);
                }
            });
        });
    }

    function openItem(item) {
        const header = item.querySelector('.services-accordion__header');
        const content = item.querySelector('.services-accordion__content');
        
        item.classList.add('is-active');
        header.setAttribute('aria-expanded', 'true');
        
        // Set max-height for animation
        content.style.maxHeight = content.scrollHeight + 'px';
    }

    function closeItem(item) {
        const header = item.querySelector('.services-accordion__header');
        const content = item.querySelector('.services-accordion__content');
        
        item.classList.remove('is-active');
        header.setAttribute('aria-expanded', 'false');
        
        // Reset max-height
        content.style.maxHeight = '0';
    }
})();
