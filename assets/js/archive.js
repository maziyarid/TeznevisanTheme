/**
 * Archive and listing pages functionality
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        console.log('Archive JS loaded');
        
        initArchiveFeatures();
        initFiltering();
        initSorting();
        initLoadMore();
        initGridToggle();
        initSearchWithinResults();
    });
    
    /**
     * Initialize Archive Features
     */
    function initArchiveFeatures() {
        // Fade in archive items
        $('.archive-item').each(function(index) {
            $(this).css({
                opacity: 0,
                transform: 'translateY(30px)'
            }).delay(index * 100).animate({
                opacity: 1
            }, 600).css({
                transform: 'translateY(0)'
            });
        });
        
        // Initialize lazy loading for archive images
        initArchiveLazyLoading();
        
        // Archive item hover effects
        $('.archive-item').hover(
            function() {
                $(this).find('.archive-image').css('transform', 'scale(1.05)');
            },
            function() {
                $(this).find('.archive-image').css('transform', 'scale(1)');
            }
        );
    }
    
    /**
     * Initialize Filtering
     */
    function initFiltering() {
        const $filterBtns = $('.filter-btn');
        const $archiveGrid = $('.archive-grid');
        const $archiveItems = $('.archive-item');
        
        if (!$filterBtns.length || !$archiveItems.length) return;
        
        $filterBtns.on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const filter = $this.data('filter');
            
            // Update active filter button
            $filterBtns.removeClass('active');
            $this.addClass('active');
            
            // Show loading
            $archiveGrid.addClass('loading');
            
            // Filter items
            if (filter === 'all') {
                $archiveItems.fadeIn(300);
            } else {
                $archiveItems.each(function() {
                    const $item = $(this);
                    const itemCategories = $item.data('categories');
                    
                    if (itemCategories && itemCategories.includes(filter)) {
                        $item.fadeIn(300);
                    } else {
                        $item.fadeOut(300);
                    }
                });
            }
            
            // Remove loading after animation
            setTimeout(() => {
                $archiveGrid.removeClass('loading');
                updateResultsCount();
            }, 300);
            
            // Update URL without reload
            updateURL('filter', filter);
        });
    }
    
    /**
     * Initialize Sorting
     */
    function initSorting() {
        const $sortSelect = $('.sort-select');
        const $archiveGrid = $('.archive-grid');
        
        if (!$sortSelect.length) return;
        
        $sortSelect.on('change', function() {
            const sortBy = $(this).val();
            const $items = $('.archive-item').get();
            
            $archiveGrid.addClass('loading');
            
            $items.sort(function(a, b) {
                let aValue, bValue;
                
                switch (sortBy) {
                    case 'date-desc':
                        aValue = new Date($(a).data('date'));
                        bValue = new Date($(b).data('date'));
                        return bValue - aValue;
                        
                    case 'date-asc':
                        aValue = new Date($(a).data('date'));
                        bValue = new Date($(b).data('date'));
                        return aValue - bValue;
                        
                    case 'title-asc':
                        aValue = $(a).data('title').toLowerCase();
                        bValue = $(b).data('title').toLowerCase();
                        return aValue.localeCompare(bValue);
                        
                    case 'title-desc':
                        aValue = $(a).data('title').toLowerCase();
                        bValue = $(b).data('title').toLowerCase();
                        return bValue.localeCompare(aValue);
                        
                    case 'price-asc':
                        aValue = parseFloat($(a).data('price')) || 0;
                        bValue = parseFloat($(b).data('price')) || 0;
                        return aValue - bValue;
                        
                    case 'price-desc':
                        aValue = parseFloat($(a).data('price')) || 0;
                        bValue = parseFloat($(b).data('price')) || 0;
                        return bValue - aValue;
                        
                    default:
                        return 0;
                }
            });
            
            // Fade out items
            $('.archive-item').fadeOut(200, function() {
                // Reorder DOM elements
                $.each($items, function(index, item) {
                    $archiveGrid.append(item);
                });
                
                // Fade in items with stagger
                $('.archive-item').each(function(index) {
                    $(this).delay(index * 50).fadeIn(300);
                });
                
                setTimeout(() => {
                    $archiveGrid.removeClass('loading');
                }, 500);
            });
            
            updateURL('sort', sortBy);
        });
    }
    
    /**
     * Initialize Load More
     */
    function initLoadMore() {
        const $loadMoreBtn = $('.load-more-btn');
        const $archiveGrid = $('.archive-grid');
        
        if (!$loadMoreBtn.length) return;
        
        $loadMoreBtn.on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const page = parseInt($this.data('page')) + 1;
            const maxPages = parseInt($this.data('max-pages'));
            
            // Show loading
            $this.addClass('loading').html('<i class="fas fa-spinner fa-spin"></i> در حال بارگذاری...');
            
            // AJAX request
            $.ajax({
                url: teznevisanTheme.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: page,
                    nonce: teznevisanTheme.nonce,
                    post_type: $this.data('post-type'),
                    category: getURLParameter('filter'),
                    sort: getURLParameter('sort')
                },
                success: function(response) {
                    if (response.success && response.data.html) {
                        const $newItems = $(response.data.html);
                        
                        // Hide new items initially
                        $newItems.css({
                            opacity: 0,
                            transform: 'translateY(30px)'
                        });
                        
                        // Append to grid
                        $archiveGrid.append($newItems);
                        
                        // Animate new items
                        $newItems.each(function(index) {
                            $(this).delay(index * 100).animate({
                                opacity: 1
                            }, 600).css({
                                transform: 'translateY(0)'
                            });
                        });
                        
                        // Update button
                        $this.data('page', page);
                        
                        if (page >= maxPages) {
                            $this.fadeOut(300, function() {
                                $(this).replaceWith('<p class="no-more-posts">همه محتوا نمایش داده شد</p>');
                            });
                        } else {
                            $this.removeClass('loading').html('<i class="fas fa-plus"></i> نمایش بیشتر');
                        }
                        
                        // Initialize lazy loading for new items
                        initArchiveLazyLoading();
                        
                        updateResultsCount();
                    } else {
                        $this.removeClass('loading').html('<i class="fas fa-exclamation-triangle"></i> خطا در بارگذاری');
                    }
                },
                error: function() {
                    $this.removeClass('loading').html('<i class="fas fa-exclamation-triangle"></i> خطا در بارگذاری');
                }
            });
        });
    }
    
    /**
     * Initialize Grid Toggle
     */
    function initGridToggle() {
        const $gridToggle = $('.grid-toggle');
        const $archiveGrid = $('.archive-grid');
        
        if (!$gridToggle.length || !$archiveGrid.length) return;
        
        $gridToggle.on('click', '.toggle-btn', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const view = $this.data('view');
            
            // Update active button
            $gridToggle.find('.toggle-btn').removeClass('active');
            $this.addClass('active');
            
            // Update grid class
            $archiveGrid.removeClass('grid-view list-view').addClass(view + '-view');
            
            // Store preference
            localStorage.setItem('archive-view', view);
            
            updateURL('view', view);
        });
        
        // Load saved preference
        const savedView = localStorage.getItem('archive-view') || 'grid';
        $gridToggle.find('.toggle-btn[data-view="' + savedView + '"]').trigger('click');
    }
    
    /**
     * Initialize Search Within Results
     */
    function initSearchWithinResults() {
        const $searchInput = $('.search-within-results');
        
        if (!$searchInput.length) return;
        
        let searchTimeout;
        
        $searchInput.on('input', function() {
            const query = $(this).val().toLowerCase().trim();
            
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                filterBySearch(query);
            }, 300);
        });
    }
    
    /**
     * Filter items by search query
     */
    function filterBySearch(query) {
        const $archiveItems = $('.archive-item');
        
        if (query === '') {
            $archiveItems.fadeIn(300);
        } else {
            $archiveItems.each(function() {
                const $item = $(this);
                const title = $item.data('title').toLowerCase();
                const excerpt = $item.find('.archive-excerpt').text().toLowerCase();
                
                if (title.includes(query) || excerpt.includes(query)) {
                    $item.fadeIn(300);
                } else {
                    $item.fadeOut(300);
                }
            });
        }
        
        setTimeout(() => {
            updateResultsCount();
        }, 300);
    }
    
    /**
     * Initialize Lazy Loading for Archive Images
     */
    function initArchiveLazyLoading() {
        if ('IntersectionObserver' in window) {
            const lazyImages = document.querySelectorAll('.archive-image img[data-src]');
            
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const $img = $(img);
                        
                        // Create a new image to preload
                        const newImg = new Image();
                        newImg.onload = function() {
                            $img.attr('src', img.dataset.src);
                            $img.removeClass('lazy-loading').addClass('lazy-loaded');
                        };
                        newImg.src = img.dataset.src;
                        
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.forEach(img => {
                img.classList.add('lazy-loading');
                imageObserver.observe(img);
            });
        }
    }
    
    /**
     * Update results count
     */
    function updateResultsCount() {
        const $resultsCount = $('.results-count');
        const visibleItems = $('.archive-item:visible').length;
        const totalItems = $('.archive-item').length;
        
        if ($resultsCount.length) {
            if (visibleItems === totalItems) {
                $resultsCount.html(`نمایش همه ${totalItems} نتیجه`);
            } else {
                $resultsCount.html(`نمایش ${visibleItems} از ${totalItems} نتیجه`);
            }
        }
    }
    
    /**
     * Update URL parameters
     */
    function updateURL(param, value) {
        if (history.pushState) {
            const url = new URL(window.location);
            if (value && value !== 'all') {
                url.searchParams.set(param, value);
            } else {
                url.searchParams.delete(param);
            }
            history.pushState(null, '', url);
        }
    }
    
    /**
     * Get URL parameter
     */
    function getURLParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    /**
     * Initialize on page load based on URL parameters
     */
    function initFromURL() {
        const filter = getURLParameter('filter');
        const sort = getURLParameter('sort');
        const view = getURLParameter('view');
        
        if (filter) {
            $('.filter-btn[data-filter="' + filter + '"]').trigger('click');
        }
        
        if (sort) {
            $('.sort-select').val(sort).trigger('change');
        }
        
        if (view) {
            $('.toggle-btn[data-view="' + view + '"]').trigger('click');
        }
    }
    
    // Initialize from URL on page load
    $(window).on('load', initFromURL);
    
    // Handle browser back/forward buttons
    $(window).on('popstate', initFromURL);
    
})(jQuery);