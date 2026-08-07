/**
 * Single Post JavaScript - Complete Implementation
 * Version: 3.0.0
 */

(function($) {
    'use strict';

    const SinglePost = {
        
        init: function() {
            this.readingProgress();
            this.tableOfContents();
            this.starRating();
            this.likeDislike();
            this.copyLink();
            this.commentLogin();
            this.videoResponsive();
            this.smoothScroll();
            this.stickyElements();
            this.scrollToTop();
            this.lazyLoadImages();
        },

        /**
         * Reading Progress Bar
         */
        readingProgress: function() {
            const progressBar = $('.reading-progress-fill');
            if (!progressBar.length) return;

            $(window).on('scroll', function() {
                const windowHeight = $(window).height();
                const documentHeight = $(document).height();
                const scrollTop = $(window).scrollTop();
                const progress = (scrollTop / (documentHeight - windowHeight)) * 100;
                
                progressBar.css('width', Math.min(progress, 100) + '%');
            });
        },

        /**
         * Table of Contents
         */
        tableOfContents: function() {
            const toc = $('.table-of-contents');
            if (!toc.length) return;

            // Toggle TOC
            $('.toc-toggle').on('click', function() {
                toc.toggleClass('collapsed');
                $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
            });

            // Smooth scroll to headings
            $('.toc-link').on('click', function(e) {
                e.preventDefault();
                const target = $(this).attr('href');
                const offset = 120;
                
                $('html, body').animate({
                    scrollTop: $(target).offset().top - offset
                }, 600);

                // Update active state
                $('.toc-link').removeClass('active');
                $(this).addClass('active');
            });

            // Highlight active section on scroll
            $(window).on('scroll', function() {
                let scrollPos = $(window).scrollTop() + 150;
                
                $('.entry-content h2, .entry-content h3').each(function() {
                    const heading = $(this);
                    const headingTop = heading.offset().top;
                    const headingId = heading.attr('id');
                    
                    if (scrollPos >= headingTop) {
                        $('.toc-link').removeClass('active');
                        $('.toc-link[href="#' + headingId + '"]').addClass('active');
                    }
                });
            });
        },

        /**
         * Star Rating System (IP-Based)
         */
        starRating: function() {
            const widget = $('.star-rating-widget');
            if (!widget.length) return;

            const postId = widget.data('post-id');

            // Star hover effect
            $('.star-label').on('mouseenter', function() {
                const value = $(this).prev('input').val();
                $('.star-label').each(function(index) {
                    if ((5 - index) <= value) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });
            });

            $('.stars-input').on('mouseleave', function() {
                $('.star-label').removeClass('hover');
            });

            // Submit rating
            $('input[name="star-rating"]').on('change', function() {
                const rating = $(this).val();
                const $this = $(this);

                // Disable all inputs
                $('input[name="star-rating"]').prop('disabled', true);

                $.ajax({
                    url: teznevisanSingle.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'submit_rating',
                        nonce: teznevisanSingle.nonce,
                        post_id: postId,
                        rating_type: 'star',
                        rating_value: rating
                    },
                    success: function(response) {
                        if (response.success) {
                            SinglePost.showToast(teznevisanSingle.strings.rating_success, 'success');
                            
                            // Update display
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function() {
                        SinglePost.showToast(teznevisanSingle.strings.error, 'error');
                        $('input[name="star-rating"]').prop('disabled', false);
                    }
                });
            });
        },

        /**
         * Like/Dislike System (IP-Based)
         */
        likeDislike: function() {
            const widget = $('.like-dislike-widget');
            if (!widget.length) return;

            const postId = widget.data('post-id');

            $('.like-btn, .dislike-btn').on('click', function() {
                const $btn = $(this);
                const action = $btn.data('action');
                const ratingValue = action === 'like' ? 1 : -1;

                if ($btn.prop('disabled')) return;

                // Disable both buttons
                $('.like-btn, .dislike-btn').prop('disabled', true);

                $.ajax({
                    url: teznevisanSingle.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'submit_rating',
                        nonce: teznevisanSingle.nonce,
                        post_id: postId,
                        rating_type: action,
                        rating_value: ratingValue
                    },
                    success: function(response) {
                        if (response.success) {
                            $btn.addClass('active');
                            
                            // Update counts
                            $('.like-count').text(response.data.likes);
                            $('.dislike-count').text(response.data.dislikes);

                            SinglePost.showToast('نظر شما ثبت شد!', 'success');
                        }
                    },
                    error: function() {
                        SinglePost.showToast(teznevisanSingle.strings.error, 'error');
                        $('.like-btn, .dislike-btn').prop('disabled', false);
                    }
                });
            });
        },

        /**
         * Copy Link to Clipboard
         */
        copyLink: function() {
            $('.share-button.share-copy, .share-copy').on('click', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(function() {
                        SinglePost.showToast(teznevisanSingle.strings.copied, 'success');
                    });
                } else {
                    // Fallback
                    const $temp = $('<input>');
                    $('body').append($temp);
                    $temp.val(url).select();
                    document.execCommand('copy');
                    $temp.remove();
                    SinglePost.showToast(teznevisanSingle.strings.copied, 'success');
                }
            });
        },

        /**
         * Comment Login Trigger
         */
        commentLogin: function() {
            $('#comment-login-trigger').on('click', function(e) {
                e.preventDefault();
                // Trigger your Telegram login modal
                if (typeof window.openTelegramLogin === 'function') {
                    window.openTelegramLogin();
                } else {
                    $('#open-telegram-login').trigger('click');
                }
            });
        },

        /**
         * Responsive Video Embeds
         */
        videoResponsive: function() {
            $('.entry-content iframe, .featured-video-container iframe').each(function() {
                if (!$(this).parent().hasClass('responsive-video-wrapper') && 
                    !$(this).parent().hasClass('featured-video-container')) {
                    $(this).wrap('<div class="responsive-video-wrapper"></div>');
                }
            });
        },

        /**
         * Smooth Scroll for Anchor Links
         */
        smoothScroll: function() {
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && 
                    location.hostname == this.hostname) {
                    let target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    
                    if (target.length) {
                        e.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top - 100
                        }, 600);
                    }
                }
            });
        },

        /**
         * Sticky Sidebar
         */
        stickyElements: function() {
            if ($(window).width() > 1024) {
                const sidebar = $('.single-post-sidebar');
                if (!sidebar.length) return;

                const sidebarTop = sidebar.offset().top;
                const headerHeight = $('.site-header').outerHeight() || 70;

                $(window).on('scroll', function() {
                    const scrollTop = $(window).scrollTop();
                    
                    if (scrollTop > sidebarTop - headerHeight - 20) {
                        sidebar.addClass('sticky');
                        sidebar.css('top', headerHeight + 20 + 'px');
                    } else {
                        sidebar.removeClass('sticky');
                        sidebar.css('top', '');
                    }
                });
            }
        },

        /**
         * Scroll to Top Button
         */
        scrollToTop: function() {
            // Create button if doesn't exist
            if (!$('.scroll-to-top').length) {
                $('body').append('<button class="scroll-to-top" aria-label="بازگشت به بالا"><i class="fa-solid fa-arrow-up"></i></button>');
            }

            const $scrollBtn = $('.scroll-to-top');

            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 300) {
                    $scrollBtn.addClass('visible');
                } else {
                    $scrollBtn.removeClass('visible');
                }
            });

            $scrollBtn.on('click', function() {
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        },

        /**
         * Lazy Load Images
         */
        lazyLoadImages: function() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('img.lazy').forEach(function(img) {
                    imageObserver.observe(img);
                });
            }
        },

        /**
         * Show Toast Notification
         */
        showToast: function(message, type = 'info') {
            // Create toast container if doesn't exist
            if (!$('.toast-container').length) {
                $('body').append('<div class="toast-container"></div>');
            }

            const icons = {
                success: 'fa-circle-check',
                error: 'fa-circle-xmark',
                info: 'fa-circle-info'
            };

            const toast = $(`
                <div class="toast ${type}">
                    <i class="fa-solid ${icons[type]}"></i>
                    <span class="toast-message">${message}</span>
                </div>
            `);

            $('.toast-container').append(toast);

            // Auto remove after 3 seconds
            setTimeout(function() {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        SinglePost.init();
    });

    // Make showToast globally accessible
    window.Teznevisan = window.Teznevisan || {};
    window.Teznevisan.showToast = SinglePost.showToast;

})(jQuery);