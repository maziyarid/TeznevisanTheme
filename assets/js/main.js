/**
 * Main Theme JavaScript - Font Awesome 7 Pro Compatible
 */

jQuery(document).ready(function($) {
    'use strict';

    function loadFontAwesome() {
        if (!$('link#fontawesome-7-pro-css').length) {
            const faLink = document.createElement('link');
            faLink.id = 'fontawesome-7-pro-css';
            faLink.rel = 'stylesheet';
            faLink.href = '/assets/fonts/fontawesome/css/all.css'; // Adjust as needed
            document.head.appendChild(faLink);

            faLink.onload = () => console.log('Font Awesome 7 Pro CSS loaded');
            faLink.onerror = () => console.error('Failed to load Font Awesome 7 Pro CSS');
        }
    }

    console.log('TezNevisan Theme JS loaded');
    loadFontAwesome();

    // Initialize all components
    initTheme();
    initResponsive();
    initAnimations();
    initForms();
    initLazyLoading();

    $(window).on('load', function() {
        removeLoadingStates();
    });

    function initTheme() {
        console.log('Theme initialization started');
        $('body').addClass('theme-loaded');
        $('[title]').each(function() {
            $(this).attr('data-tooltip', $(this).attr('title'));
            $(this).removeAttr('title');
        });
        console.log('Theme initialization completed');
    }

    function initResponsive() {
        handleResponsiveNavigation();
        $('table').wrap('<div class="table-responsive"></div>');
        $('iframe[src*="youtube"], iframe[src*="vimeo"]').wrap('<div class="video-responsive"></div>');
    }

    function handleResponsiveNavigation() {
        const breakpoint = 768;
        $(window).on('resize', function() {
            const width = $(window).width();
            if (width > breakpoint) {
                $('.mobile-menu-overlay').fadeOut();
                $('body').removeClass('mobile-menu-open');
                $('.mobile-menu-toggle-enhanced').removeClass('active');
            }
        });
    }

    function initAnimations() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({scrollTop: target.offset().top - 100}, 600);
            }
        });

        if ('IntersectionObserver' in window) {
            const animateElements = document.querySelectorAll('[data-animate]');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, {threshold: 0.1, rootMargin: '50px'});
            animateElements.forEach(el => observer.observe(el));
        }
    }

    function initForms() {
        $('form').on('submit', function(e) {
            const form = $(this);
            if (!validateForm(form)) {
                e.preventDefault();
                return false;
            }
        });

        $('input[required], textarea[required], select[required]').on('blur', function() {
            validateField($(this));
        });
    }

    function validateForm(form) {
        let isValid = true;
        form.find('[required]').each(function() {
            if (!validateField($(this))) {
                isValid = false;
            }
        });
        return isValid;
    }

    function validateField(field) {
        const value = field.val().trim();
        const type = field.attr('type');
        let isValid = true;
        field.removeClass('error');
        field.next('.error-message').remove();
        if (field.attr('required') && !value) {
            addFieldError(field, 'این فیلد الزامی است');
            isValid = false;
        }
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                addFieldError(field, 'آدرس ایمیل معتبر نیست');
                isValid = false;
            }
        }
        if (type === 'tel' && value) {
            const phoneRegex = /^(\+98|0)?9\d{9}$/;
            if (!phoneRegex.test(value)) {
                addFieldError(field, 'شماره تماس معتبر نیست');
                isValid = false;
            }
        }
        return isValid;
    }

    function addFieldError(field, message) {
        field.addClass('error');
        field.after('<span class="error-message">' + message + '</span>');
    }

    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            $('img[data-src]').each(function() {
                $(this).attr('src', $(this).data('src'));
                $(this).attr('loading', 'lazy');
                $(this).removeAttr('data-src');
            });
        } else if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    function removeLoadingStates() {
        $('.loading').removeClass('loading');
        $('.skeleton').removeClass('skeleton');
        $('body').addClass('fully-loaded');
    }

    // Global utilities
    window.TeznevisanTheme = {
        showNotification: function(message, type) {
            type = type || 'info';
            const notification = $('<div class="notification ' + type + '">' + message + '</div>');
            $('body').append(notification);
            setTimeout(() => notification.addClass('show'), 100);
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        },
        scrollToElement: function(element, offset) {
            offset = offset || 100;
            const target = $(element);
            if (target.length) {
                $('html, body').animate({scrollTop: target.offset().top - offset}, 600);
            }
        }
    };
});
