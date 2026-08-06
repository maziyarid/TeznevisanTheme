/**
 * Admin JS - Improved Font Awesome 7 Pro Integration
 */

(function($) {
    'use strict';

    // Load Font Awesome 7 Pro CSS if not already loaded
    function loadFontAwesome() {
        if (!$('link#fontawesome-7-pro-css').length) {
            const faLink = document.createElement('link');
            faLink.id = 'fontawesome-7-pro-css';
            faLink.rel = 'stylesheet';
            faLink.href = '/assets/fonts/fontawesome/css/all.css'; // Adjust path to your FA7 Pro CSS
            document.head.appendChild(faLink);

            faLink.onload = function() {
                console.log('Font Awesome 7 Pro CSS loaded');
            };
            faLink.onerror = function() {
                console.error('Failed to load Font Awesome 7 Pro CSS');
            };
        }
    }

    $(document).ready(function() {
        console.log('TezNevisan Admin JS loaded');

        loadFontAwesome();

        initAdminEnhancements();
    });

    function initAdminEnhancements() {
        // Only run on our custom admin pages
        if (typeof teznevisanAdmin === 'undefined') {
            return;
        }

        loadDashboardStats();
        setInterval(loadDashboardStats, 300000);
        handleAdminNotices();
        initQuickActions();
    }

    function loadDashboardStats() {
        const $container = $('#dashboard-stats-container');
        if (!$container.length || typeof teznevisanAdmin === 'undefined') return;

        $.ajax({
            url: teznevisanAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'get_dashboard_stats',
                nonce: teznevisanAdmin.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateStatsDisplay(response.data);
                }
            },
            error: function() {
                console.error('Failed to load dashboard stats');
            }
        });
    }

    function updateStatsDisplay(stats) {
        let statsHtml = '<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">';

        $.each(stats, function(key, value) {
            statsHtml += `
                <div class="stat-item" style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border: 1px solid #dee2e6;">
                    <div class="stat-value" style="font-size: 2rem; font-weight: 700; color: #1fa547; margin-bottom: 0.5rem;">${value}</div>
                    <div class="stat-label" style="color: #666; font-size: 0.9rem;">${getStatLabel(key)}</div>
                </div>
            `;
        });

        statsHtml += '</div>';

        $('#dashboard-stats-container').html(statsHtml);
    }

    function getStatLabel(key) {
        const labels = {
            'services': 'خدمات',
            'inquiries': 'درخواست‌ها',
            'posts': 'مقالات',
            'subscribers': 'مشترکین'
        };
        return labels[key] || key;
    }

    function handleAdminNotices() {
        $('.notice-dismiss').on('click', function() {
            const $notice = $(this).closest('.notice');

            if ($notice.hasClass('teznevisan-welcome-notice')) {
                $.post(teznevisanAdmin.ajaxUrl, {
                    action: 'dismiss_welcome_notice',
                    nonce: teznevisanAdmin.nonce
                });
            }
        });

        setTimeout(function() {
            $('.notice-success').fadeOut();
        }, 5000);
    }

    function initQuickActions() {
        $('.quick-action, .action-btn').on('click', function() {
            const $this = $(this);
            const originalContent = $this.html();

            if ($this.attr('href') && !$this.attr('href').startsWith('#')) {
                $this.html('<i class="fa-solid fa-spinner fa-spin"></i> در حال بارگذاری...');

                setTimeout(function() {
                    $this.html(originalContent);
                }, 2000);
            }
        });

        $('.faq-question').on('click', function() {
            const $item = $(this).closest('.faq-item');
            const $answer = $item.find('.faq-answer');

            if ($item.hasClass('active')) {
                $item.removeClass('active');
                $answer.slideUp();
            } else {
                $('.faq-item').removeClass('active');
                $('.faq-answer').slideUp();
                $item.addClass('active');
                $answer.slideDown();
            }
        });
    }

})(jQuery);
