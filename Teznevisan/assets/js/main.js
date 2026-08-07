/**
 * Teznevisan Main JavaScript - Professional Edition
 * Version: 3.0.0
 * Complete functionality with animations and effects
 */

(function($) {
    'use strict';

    const Teznevisan = {
        /**
         * Initialize all functions
         */
        init: function() {
            this.removePreload();
            this.setupMobileMenu();
            this.setupSearch();
            this.setupBackToTop();
            this.setupDarkMode();
            this.setupAccessibility();
            this.setupUserMenu();
            this.setupTelegramLogin();
            this.setupHeader();
            this.setupSmoothScroll();
            this.setupEdgePanel();
            this.setupChaty();
            this.setupAnimations();
            this.setupLazyLoading();
            this.setupFormValidation();
            this.setupTooltips();
            this.setupNewsletterForm();
        },

        /**
         * Remove preload class to enable transitions
         */
        removePreload: function() {
            $(window).on('load', function() {
                $('body').removeClass('preload');
            });
        },

        /**
         * Mobile Menu Setup
         */
        setupMobileMenu: function() {
            const toggle = $('#mobile-menu-toggle');
            const menu = $('#mobile-navigation');
            const overlay = $('.mobile-menu-overlay');
            const close = $('.mobile-menu-close');

            // Toggle menu
            toggle.on('click', function(e) {
                e.stopPropagation();
                const isActive = $('body').hasClass('mobile-menu-active');
                
                if (isActive) {
                    Teznevisan.closeMobileMenu();
                } else {
                    Teznevisan.openMobileMenu();
                }
            });

            // Close menu
            close.on('click', function() {
                Teznevisan.closeMobileMenu();
            });

            overlay.on('click', function() {
                Teznevisan.closeMobileMenu();
            });

            // Close on escape
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('body').hasClass('mobile-menu-active')) {
                    Teznevisan.closeMobileMenu();
                }
            });

            // Submenu toggles
            $('.submenu-toggle').on('click', function(e) {
                e.preventDefault();
                const $this = $(this);
                const $parent = $this.parent();
                const $submenu = $this.next('.mobile-submenu');

                // Close other submenus
                $('.mobile-submenu').not($submenu).removeClass('active');
                $('.mobile-menu-item').not($parent).removeClass('active');

                // Toggle current submenu
                $parent.toggleClass('active');
                $submenu.toggleClass('active');
            });

            // Mobile login button
            $('#mobile-telegram-login').on('click', function() {
                Teznevisan.closeMobileMenu();
                $('#open-telegram-login').trigger('click');
            });
        },

        openMobileMenu: function() {
            $('body').addClass('mobile-menu-active');
            $('#mobile-menu-toggle').addClass('is-active').attr('aria-expanded', 'true');
            $('#mobile-navigation').attr('aria-hidden', 'false');
        },

        closeMobileMenu: function() {
            $('body').removeClass('mobile-menu-active');
            $('#mobile-menu-toggle').removeClass('is-active').attr('aria-expanded', 'false');
            $('#mobile-navigation').attr('aria-hidden', 'true');
        },

        /**
         * Search Modal Setup
         */
        setupSearch: function() {
            const btn = $('#search-toggle');
            const modal = $('#search-modal');
            const close = $('.search-modal-close');
            const overlay = $('.search-modal-overlay');
            const input = $('.search-field');

            // Open modal
            btn.on('click', function(e) {
                e.preventDefault();
                modal.addClass('active').attr('aria-hidden', 'false');
                $('body').css('overflow', 'hidden');
                setTimeout(() => input.focus(), 300);
            });

            // Close modal
            close.on('click', function() {
                Teznevisan.closeSearchModal();
            });

            overlay.on('click', function(e) {
                if ($(e.target).is(overlay)) {
                    Teznevisan.closeSearchModal();
                }
            });

            // Close on escape
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && modal.hasClass('active')) {
                    Teznevisan.closeSearchModal();
                }
            });

            // AJAX Search
            input.on('input', Teznevisan.debounce(function() {
                const query = $(this).val();
                
                if (query.length < 2) {
                    $('.search-results').empty();
                    return;
                }

                $.ajax({
                    url: teznevisanData.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'teznevisan_search',
                        search: query,
                        nonce: teznevisanData.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            Teznevisan.displaySearchResults(response.data);
                        }
                    }
                });
            }, 300));
        },

        closeSearchModal: function() {
            $('#search-modal').removeClass('active').attr('aria-hidden', 'true');
            $('body').css('overflow', '');
            $('.search-field').val('');
            $('.search-results').empty();
        },

        displaySearchResults: function(results) {
            let html = '';
            
            if (results && results.length) {
                results.forEach(r => {
                    html += `
                        <a href="${r.url}" class="search-result-item">
                            <strong>${r.title}</strong>
                            <p>${r.excerpt}</p>
                        </a>
                    `;
                });
            } else {
                html = '<p style="text-align: center; color: var(--gray-500); padding: 2rem;">نتیجه‌ای یافت نشد</p>';
            }
            
            $('.search-results').html(html);
        },

        /**
         * Back to Top Button
         */
        setupBackToTop: function() {
            const btn = $('#scroll-to-top, #back-to-top-footer');
            
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    btn.addClass('visible').fadeIn();
                } else {
                    btn.removeClass('visible').fadeOut();
                }
            });

            btn.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 800, 'swing');
            });
        },

        /**
         * Dark Mode Toggle
         */
        setupDarkMode: function() {
            const toggle = $('#dark-mode-toggle');
            const html = $('html');
            
            // Load saved theme
            const currentTheme = localStorage.getItem('teznevisan-theme') || 'light';
            this.applyTheme(currentTheme);

            toggle.on('click', function(e) {
                e.preventDefault();
                const current = html.attr('data-theme') || 'light';
                const next = current === 'light' ? 'dark' : 'light';
                
                Teznevisan.applyTheme(next);
                localStorage.setItem('teznevisan-theme', next);
                
                // Show toast
                Teznevisan.showToast(
                    next === 'dark' ? 'حالت تاریک فعال شد' : 'حالت روشن فعال شد',
                    'success'
                );
            });
        },

        applyTheme: function(theme) {
            $('html').attr('data-theme', theme);
        },

        /**
         * Accessibility Panel
         */
        setupAccessibility: function() {
            const btn = $('#accessibility-toggle');
            const panel = $('#accessibility-panel');
            const close = $('.accessibility-close');
            
            // Toggle panel
            btn.on('click', function(e) {
                e.preventDefault();
                const isHidden = panel.attr('aria-hidden') === 'true';
                panel.attr('aria-hidden', !isHidden);
            });

            close.on('click', function() {
                panel.attr('aria-hidden', 'true');
            });

            // Font size increase
            $('#increase-font').on('change', function() {
                const isChecked = this.checked;
                $('body').toggleClass('font-increased', isChecked);
                localStorage.setItem('a11y_font', isChecked ? '1' : '0');
            });

            // High contrast
            $('#high-contrast').on('change', function() {
                const isChecked = this.checked;
                $('body').toggleClass('high-contrast', isChecked);
                localStorage.setItem('a11y_contrast', isChecked ? '1' : '0');
            });

            // Underline links
            $('#underline-links').on('change', function() {
                const isChecked = this.checked;
                $('body').toggleClass('underline-links', isChecked);
                localStorage.setItem('a11y_underline', isChecked ? '1' : '0');
            });

            // Reduce motion
            $('#reduce-motion').on('change', function() {
                const isChecked = this.checked;
                $('body').toggleClass('reduce-motion', isChecked);
                localStorage.setItem('a11y_motion', isChecked ? '1' : '0');
            });

            // Reset button
            $('.reset-accessibility').on('click', function() {
                $('#increase-font, #high-contrast, #underline-links, #reduce-motion').prop('checked', false);
                $('body').removeClass('font-increased high-contrast underline-links reduce-motion');
                localStorage.removeItem('a11y_font');
                localStorage.removeItem('a11y_contrast');
                localStorage.removeItem('a11y_underline');
                localStorage.removeItem('a11y_motion');
                Teznevisan.showToast('تنظیمات دسترسی‌پذیری بازنشانی شد', 'info');
            });

            // Load saved settings
            if (localStorage.getItem('a11y_font') === '1') {
                $('#increase-font').prop('checked', true);
                $('body').addClass('font-increased');
            }
            if (localStorage.getItem('a11y_contrast') === '1') {
                $('#high-contrast').prop('checked', true);
                $('body').addClass('high-contrast');
            }
            if (localStorage.getItem('a11y_underline') === '1') {
                $('#underline-links').prop('checked', true);
                $('body').addClass('underline-links');
            }
            if (localStorage.getItem('a11y_motion') === '1') {
                $('#reduce-motion').prop('checked', true);
                $('body').addClass('reduce-motion');
            }
        },

        /**
         * User Menu Dropdown
         */
        setupUserMenu: function() {
            const toggle = $('.user-menu-toggle');
            const dropdown = $('.user-menu-dropdown');
            const wrapper = $('.user-menu-wrapper');

            toggle.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                wrapper.toggleClass('active');
                dropdown.toggleClass('active');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.user-menu-wrapper').length) {
                    wrapper.removeClass('active');
                    dropdown.removeClass('active');
                }
            });
        },

        /**
         * Telegram Login Modal
         */
        setupTelegramLogin: function() {
            const openBtn = $('#open-telegram-login');
            const modal = $('#telegram-login-modal');
            const close = $('.telegram-login-close');
            const overlay = $('.telegram-login-overlay');

            openBtn.on('click', function(e) {
                e.preventDefault();
                modal.addClass('active').attr('aria-hidden', 'false');
                $('body').css('overflow', 'hidden');
                
                // Load Telegram widget
                const container = $('#telegram-widget-container');
                if (!container.find('script').length) {
                    const script = document.createElement('script');
                    script.async = true;
                    script.src = 'https://telegram.org/js/telegram-widget.js?22';
                    script.dataset.telegramLogin = 'TeznevisanBot';
                    script.dataset.size = 'large';
                    script.dataset.authUrl = window.location.href.split('?')[0] + '?tg_auth=1';
                    script.dataset.requestAccess = 'write';
                    container[0].appendChild(script);
                }
            });

            close.on('click', function() {
                Teznevisan.closeTelegramModal();
            });

            overlay.on('click', function(e) {
                if ($(e.target).is(overlay)) {
                    Teznevisan.closeTelegramModal();
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && modal.hasClass('active')) {
                    Teznevisan.closeTelegramModal();
                }
            });
        },

        closeTelegramModal: function() {
            $('#telegram-login-modal').removeClass('active').attr('aria-hidden', 'true');
            $('body').css('overflow', '');
        },

        /**
         * Header Scroll Effects
         */
        setupHeader: function() {
            const header = $('#site-header');
            let lastScroll = 0;
            const delta = 5;

            $(window).on('scroll', function() {
                const scrollTop = $(this).scrollTop();

                // Add scrolled class
                if (scrollTop > 100) {
                    header.addClass('scrolled');
                } else {
                    header.removeClass('scrolled');
                }

                // Hide/show header on scroll
                if (Math.abs(lastScroll - scrollTop) <= delta) {
                    return;
                }

                if (scrollTop > lastScroll && scrollTop > header.outerHeight()) {
                    header.addClass('header-hidden');
                } else {
                    if (scrollTop + $(window).height() < $(document).height()) {
                        header.removeClass('header-hidden');
                    }
                }

                lastScroll = scrollTop;
            });
        },

        /**
         * Smooth Scroll for Anchor Links
         */
        setupSmoothScroll: function() {
            $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').on('click', function(e) {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                    location.hostname === this.hostname) {
                    
                    const target = $(this.hash);
                    const $target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    
                    if ($target.length) {
                        e.preventDefault();
                        const headerHeight = $('#site-header').outerHeight() || 70;
                        const offset = 20;
                        
                        $('html, body').animate({
                            scrollTop: $target.offset().top - headerHeight - offset
                        }, 800, 'swing');

                        // Close mobile menu if open
                        if ($('body').hasClass('mobile-menu-active')) {
                            Teznevisan.closeMobileMenu();
                        }
                    }
                }
            });
        },

        /**
         * Edge Panel (Floating Tools)
         */
        setupEdgePanel: function() {
            const panel = $('#edge-panel');
            const toggle = $('.edge-toggle');

            toggle.on('click', function() {
                panel.toggleClass('active');
            });

            // Close on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#edge-panel').length) {
                    panel.removeClass('active');
                }
            });
        },

        /**
         * Chaty (Floating Contact Buttons)
         */
        setupChaty: function() {
            const container = $('#chaty-container');
            const toggle = $('.chaty-toggle');

            toggle.on('click', function(e) {
                e.stopPropagation();
                container.toggleClass('active');
            });

            // Close on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#chaty-container').length) {
                    container.removeClass('active');
                }
            });
        },

        /**
         * Scroll Animations
         */
        setupAnimations: function() {
            if ('IntersectionObserver' in window) {
                const animateElements = document.querySelectorAll('[data-animate]:not(.animated)');
                
                const animationObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const element = entry.target;
                            const animation = element.getAttribute('data-animate');
                            const delay = element.getAttribute('data-delay') || 0;
                            
                            setTimeout(() => {
                                element.classList.add('animated', animation);
                            }, delay);
                            
                            animationObserver.unobserve(element);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                animateElements.forEach(element => {
                    animationObserver.observe(element);
                });
            }
        },

        /**
         * Lazy Loading Images
         */
        setupLazyLoading: function() {
            if ('IntersectionObserver' in window) {
                const lazyImages = document.querySelectorAll('img[loading="lazy"], img[data-src]');
                
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                            }
                            
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            }
        },

        /**
         * Form Validation
         */
        setupFormValidation: function() {
            $('form').on('submit', function(e) {
                let isValid = true;
                const $form = $(this);
                const requiredFields = $form.find('[required]');

                requiredFields.each(function() {
                    const $field = $(this);
                    
                    if (!$field.val().trim()) {
                        isValid = false;
                        $field.addClass('error');
                        
                        $field.one('input', function() {
                            $(this).removeClass('error');
                        });
                    } else {
                        $field.removeClass('error');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    Teznevisan.showToast('لطفاً تمام فیلدهای ضروری را پر کنید.', 'error');
                }
            });

            // Email validation
            $('input[type="email"]').on('blur', function() {
                const email = $(this).val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !emailRegex.test(email)) {
                    $(this).addClass('error');
                    Teznevisan.showToast('لطفاً یک ایمیل معتبر وارد کنید.', 'warning');
                } else {
                    $(this).removeClass('error');
                }
            });

            // Phone validation
            $('input[type="tel"]').on('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                this.value = value;
            });
        },

        /**
         * Tooltips
         */
        setupTooltips: function() {
            const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
            
            tooltipTriggers.forEach(trigger => {
                trigger.addEventListener('mouseenter', function() {
                    const tooltipText = this.dataset.tooltip;
                    const tooltip = document.createElement('div');
                    tooltip.className = 'custom-tooltip';
                    tooltip.textContent = tooltipText;
                    document.body.appendChild(tooltip);

                    const triggerRect = this.getBoundingClientRect();
                    const tooltipRect = tooltip.getBoundingClientRect();

                    tooltip.style.cssText = `
                        position: fixed;
                        top: ${triggerRect.top - tooltipRect.height - 10}px;
                        left: ${triggerRect.left + (triggerRect.width / 2) - (tooltipRect.width / 2)}px;
                        background: var(--gray-900);
                        color: white;
                        padding: 0.5rem 1rem;
                        border-radius: var(--radius-md);
                        font-size: 0.875rem;
                        z-index: 9999;
                        pointer-events: none;
                        animation: fadeIn 0.2s ease;
                    `;

                    this._tooltip = tooltip;
                });

                trigger.addEventListener('mouseleave', function() {
                    if (this._tooltip) {
                        this._tooltip.remove();
                        this._tooltip = null;
                    }
                });
            });
        },

        /**
         * Newsletter Form
         */
        setupNewsletterForm: function() {
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                const email = $form.find('input[type="email"]').val();

                if (!email) {
                    Teznevisan.showToast('لطفاً ایمیل خود را وارد کنید.', 'warning');
                    return;
                }

                // Simulate AJAX request
                const $button = $form.find('button');
                const originalHTML = $button.html();
                $button.html('<i class="fa-solid fa-spinner fa-spin"></i>').prop('disabled', true);

                setTimeout(() => {
                    Teznevisan.showToast('با موفقیت در خبرنامه عضو شدید!', 'success');
                    $form[0].reset();
                    $button.html(originalHTML).prop('disabled', false);
                }, 1500);
            });
        },

        /**
         * Show Toast Notification
         */
        showToast: function(message, type = 'info') {
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            const toast = $(`
                <div class="teznevisan-toast toast-${type}">
                    <i class="fa-solid ${icons[type]}"></i>
                    <span>${message}</span>
                </div>
            `).css({
                position: 'fixed',
                top: '80px',
                right: '20px',
                background: colors[type],
                color: 'white',
                padding: '1rem 1.5rem',
                borderRadius: 'var(--radius-md)',
                boxShadow: 'var(--shadow-xl)',
                zIndex: 10000,
                display: 'flex',
                alignItems: 'center',
                gap: '0.75rem',
                animation: 'slideInRight 0.3s ease',
                fontFamily: 'var(--font-family)',
                minWidth: '250px'
            });

            $('body').append(toast);

            setTimeout(() => {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        },

        /**
         * Copy to Clipboard
         */
        copyToClipboard: function(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    this.showToast('کپی شد!', 'success');
                }).catch(() => {
                    this.fallbackCopyToClipboard(text);
                });
            } else {
                this.fallbackCopyToClipboard(text);
            }
        },

        fallbackCopyToClipboard: function(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            
            try {
                document.execCommand('copy');
                this.showToast('کپی شد!', 'success');
            } catch (err) {
                this.showToast('خطا در کپی کردن', 'error');
            }
            
            document.body.removeChild(textarea);
        },

        /**
         * Debounce Function
         */
        debounce: function(fn, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => fn.apply(this, args), delay);
            };
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        Teznevisan.init();
    });

    // Page loaded
    $(window).on('load', function() {
        $('body').removeClass('loading').addClass('page-loaded');
        $('.page-loader').fadeOut(300);
    });

    // Add inline styles for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .animated {
            animation-duration: 0.6s;
            animation-fill-mode: both;
        }

        .fadeIn { animation-name: fadeIn; }
        .fadeInUp { animation-name: slideUp; }
        .slideUp { animation-name: slideUp; }
        .zoomIn { animation-name: zoomIn; }

        .no-scroll {
            overflow: hidden;
        }

        .form-control.error {
            border-color: var(--danger-color);
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        img.loaded {
            animation: fadeIn 0.3s ease;
        }
    `;
    document.head.appendChild(style);

    // Expose Teznevisan to global scope
    window.Teznevisan = Teznevisan;

})(jQuery);