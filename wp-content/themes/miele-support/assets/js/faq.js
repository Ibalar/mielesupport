/**
 * FAQ Accordion functionality
 */
(function() {
    'use strict';

    // Инициализация после загрузки DOM
    document.addEventListener('DOMContentLoaded', function() {
        initFaqAccordion();
    });

    function initFaqAccordion() {
        const faqItems = document.querySelectorAll('[data-faq-item]');
        
        if (!faqItems.length) return;

        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq__question');
            const answer = item.querySelector('.faq__answer');
            
            if (!question || !answer) return;

            question.addEventListener('click', function() {
                const isActive = item.classList.contains('is-active');
                
                // Закрыть все остальные элементы
                faqItems.forEach(function(otherItem) {
                    if (otherItem !== item && otherItem.classList.contains('is-active')) {
                        closeItem(otherItem);
                    }
                });
                
                // Переключить текущий элемент
                if (isActive) {
                    closeItem(item);
                } else {
                    openItem(item);
                }
            });
        });
    }

    function openItem(item) {
        const question = item.querySelector('.faq__question');
        const answer = item.querySelector('.faq__answer');
        
        item.classList.add('is-active');
        question.setAttribute('aria-expanded', 'true');
        
        // Установить max-height для анимации
        answer.style.maxHeight = answer.scrollHeight + 'px';
    }

    function closeItem(item) {
        const question = item.querySelector('.faq__question');
        const answer = item.querySelector('.faq__answer');
        
        item.classList.remove('is-active');
        question.setAttribute('aria-expanded', 'false');
        
        // Сбросить max-height
        answer.style.maxHeight = '0';
    }
})();