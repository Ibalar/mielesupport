/**
 * News Tags Filter Functionality
 * Handles filtering posts by tags on the news/blog archive pages
 */
(function() {
    'use strict';

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initTagFiltering();
    });

    /**
     * Initialize tag filtering functionality
     */
    function initTagFiltering() {
        const tagLinks = document.querySelectorAll('.news-tags__link');
        const newsGrid = document.querySelector('.news-archive__grid');

        if (!tagLinks.length || !newsGrid) {
            return;
        }

        // Get current tag from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const currentTag = urlParams.get('tag');

        // Set active state based on URL parameter
        updateActiveTag(currentTag);

        // Add click handlers to tag links
        tagLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const tag = this.getAttribute('data-tag');

                // Update URL without page reload for JavaScript filtering
                if (tag === 'all') {
                    urlParams.delete('tag');
                } else {
                    urlParams.set('tag', tag);
                }

                const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                window.history.pushState({ tag: tag }, '', newUrl);

                // Update active state
                updateActiveTag(tag === 'all' ? null : tag);

                // Filter posts
                filterPostsByTag(tag);
            });
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            const params = new URLSearchParams(window.location.search);
            const tag = params.get('tag');
            updateActiveTag(tag);
            filterPostsByTag(tag || 'all');
        });
    }

    /**
     * Update the active state of tag buttons
     * @param {string|null} activeTag - The currently active tag slug
     */
    function updateActiveTag(activeTag) {
        const tagLinks = document.querySelectorAll('.news-tags__link');

        tagLinks.forEach(function(link) {
            const linkTag = link.getAttribute('data-tag');

            if ((activeTag === null || activeTag === '') && linkTag === 'all') {
                link.classList.add('is-active');
                link.setAttribute('aria-current', 'true');
            } else if (activeTag === linkTag) {
                link.classList.add('is-active');
                link.setAttribute('aria-current', 'true');
            } else {
                link.classList.remove('is-active');
                link.removeAttribute('aria-current');
            }
        });
    }

    /**
     * Filter posts by the selected tag
     * @param {string} tag - The tag slug to filter by, or 'all' to show all
     */
    function filterPostsByTag(tag) {
        const newsCards = document.querySelectorAll('.news-card');

        if (tag === 'all') {
            // Show all posts
            newsCards.forEach(function(card) {
                card.style.display = '';
                card.classList.remove('is-hidden');
            });
        } else {
            // Filter posts by tag
            newsCards.forEach(function(card) {
                const cardTags = card.getAttribute('data-tags');

                if (cardTags && cardTags.split(',').includes(tag)) {
                    card.style.display = '';
                    card.classList.remove('is-hidden');
                } else {
                    card.style.display = 'none';
                    card.classList.add('is-hidden');
                }
            });
        }

        // Update empty state visibility
        updateEmptyState();
    }

    /**
     * Show/hide empty state message based on visible posts
     */
    function updateEmptyState() {
        const newsGrid = document.querySelector('.news-archive__grid');
        const visibleCards = newsGrid.querySelectorAll('.news-card:not(.is-hidden)');
        const emptyState = document.querySelector('.news-archive__empty');

        if (emptyState) {
            if (visibleCards.length === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
    }
})();
