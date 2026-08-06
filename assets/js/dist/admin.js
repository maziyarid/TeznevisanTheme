/**
 * Teznevisan Admin JavaScript
 * Enhanced admin interface functionality
 */
(function ($) {
    'use strict';

    class TeznevisanAdmin {
        constructor() {
            this.config = teznevisanAdmin || {};
            this.init();
        }

        init() {
            this.setupAdminEnhancements();
            this.fixAdminIcons();
            this.setupEditorEnhancements();
            this.initializeWidgets();
            this.bindEvents();
        }

        setupAdminEnhancements() {
            // Force IRANSans font in admin
            $('body.wp-admin').addClass('iranSans-loaded');

            // Add theme branding to admin footer
            this.addThemeBranding();

            // Enhance admin notifications
            this.enhanceNotifications();
        }

        addThemeBranding() {
            $('#wpfooter').prepend(`
                <div class="teznevisan-admin-branding" style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 12px;
                    padding: 12px;
                    background: #f8f9fa;
                    border-radius: 6px;
                    border-right: 4px solid #1FA547;
                ">
                    <i class="fa-solid fa-palette" style="color: #1FA547; font-size: 18px;"></i>
                    <div>
                        <strong style="color: #1FA547;">تم تزنویسان</strong>
                        <small style="display: block; color: #666; font-size: 12px;">
                            ویرایشگر حرفه‌ای با پشتیبانی کامل از فارسی
                        </small>
                    </div>
                </div>
            `);
        }

        enhanceNotifications() {
            $('.notice').each(function () {
                const $notice = $(this);

                if (!$notice.find('.notice-icon').length) {
                    let icon = 'fa-solid fa-circle-info';

                    if ($notice.hasClass('notice-success')) {
                        icon = 'fa-solid fa-circle-check';
                    } else if ($notice.hasClass('notice-error')) {
                        icon = 'fa-solid fa-circle-exclamation';
                    } else if ($notice.hasClass('notice-warning')) {
                        icon = 'fa-solid fa-triangle-exclamation';
                    }

                    $notice.prepend(`<i class="notice-icon ${icon}" style="margin-left: 8px; color: inherit;"></i>`);
                }
            });
        }

        fixAdminIcons() {
            // Fix admin menu icons
            $('#adminmenu .wp-menu-image').each((_, el) => {
                const $img = $(el);

                if (!$img.find('.fa, [class^="fa-"]').length) {
                    const menuId = $img.closest('li').attr('id') || '';
                    const icon = this.getMenuIcon(menuId);

                    if (icon) {
                        $img.html(`<i class="${icon}" aria-hidden="true"></i>`);
                    }
                }
            });

            // Fix dashboard widget icons
            $('.postbox h2, .postbox h3').each((_, el) => {
                const $title = $(el);
                const text = $title.text().toLowerCase();

                if (!$title.find('.fa').length) {
                    let icon = '';

                    if (text.includes('درحال حاضر') || text.includes('right now')) {
                        icon = 'fa-solid fa-tachometer-alt';
                    } else if (text.includes('فعالیت') || text.includes('activity')) {
                        icon = 'fa-solid fa-chart-line';
                    } else if (text.includes('پیش‌نویس') || text.includes('draft')) {
                        icon = 'fa-solid fa-file-alt';
                    }

                    if (icon) {
                        $title.prepend(`<i class="${icon}" style="margin-left: 8px; color: #1FA547;"></i>`);
                    }
                }
            });
        }

        getMenuIcon(menuId) {
            const iconMap = {
                'menu-dashboard': 'fa-solid fa-tachometer-alt',
                'menu-posts': 'fa-solid fa-file-alt',
                'menu-media': 'fa-solid fa-photo-video',
                'menu-pages': 'fa-solid fa-file',
                'menu-comments': 'fa-solid fa-comments',
                'menu-appearance': 'fa-solid fa-paint-brush',
                'menu-plugins': 'fa-solid fa-plug',
                'menu-users': 'fa-solid fa-users',
                'menu-tools': 'fa-solid fa-tools',
                'menu-settings': 'fa-solid fa-cog',
                'menu-posts-services': 'fa-solid fa-cogs',
                'menu-posts-testimonials': 'fa-solid fa-star',
                'menu-posts-portfolio': 'fa-solid fa-briefcase'
            };

            return iconMap[menuId] || null;
        }

        setupEditorEnhancements() {
            if ($('#post').length) {
                this.enhanceClassicEditor();
            }
            this.enhanceMediaLibrary();

            if (typeof tinymce !== 'undefined') {
                tinymce.on('AddEditor', (e) => {
                    const editor = e.editor;
                    editor.on('init', () => {
                        editor.on('paste', () => {
                            setTimeout(() => {
                                const content = editor.getContent();
                                const convertedContent = this.convertToPersianNumbers(content);
                                if (content !== convertedContent) {
                                    editor.setContent(convertedContent);
                                }
                            }, 100);
                        });
                        editor.on('change', () => {
                            this.showAutoSaveIndicator();
                        });
                    });
                });
            }
            this.addPersianWordCount();
        }

        enhanceClassicEditor() {
            if ($('#content_tbl').length && !$('#persian-helpers').length) {
                $('#content_tbl').before(`
                    <div id="persian-helpers" style="
                        padding: 8px 12px;
                        background: #f8f9fa;
                        border: 1px solid #e0e0e0;
                        border-radius: 4px;
                        margin-bottom: 8px;
                        font-size: 13px;
                    ">
                        <strong>کمک‌های تایپوگرافی فارسی:</strong>
                        <button type="button" class="button-link persian-helper" data-action="fix-persian-y">اصلاح ی فارسی</button>
                        <button type="button" class="button-link persian-helper" data-action="fix-persian-k">اصلاح ک فارسی</button>
                        <button type="button" class="button-link persian-helper" data-action="add-zwnj">نیم‌فاصله</button>
                    </div>
                `);
            }

            $('.persian-helper').on('click', (e) => {
                const action = $(e.target).data('action');
                const editor = window.tinymce?.get('content');

                if (editor) {
                    let content = editor.getContent();

                    switch (action) {
                        case 'fix-persian-y':
                            content = content.replace(/ي/g, 'ی');
                            break;
                        case 'fix-persian-k':
                            content = content.replace(/ك/g, 'ک');
                            break;
                        case 'add-zwnj':
                            editor.insertContent('‌');
                            return;
                    }

                    editor.setContent(content);
                    this.showAdminNotice('تغییرات اعمال شد', 'success');
                }
            });
        }

        enhanceMediaLibrary() {
            $(document).on('click', '.media-button-select', () => {
                setTimeout(() => {
                    if ($('.media-sidebar').length && !$('#fa-icon-search').length) {
                        $('.media-sidebar').prepend(`
                            <div class="fa-icon-helper" style="
                                padding: 12px;
                                background: #f8f9fa;
                                border: 1px solid #e0e0e0;
                                border-radius: 4px;
                                margin-bottom: 12px;
                            ">
                                <h3 style="margin: 0 0 8px 0; font-size: 14px;">درج سریع آیکون</h3>
                                <input type="text" id="fa-icon-search" placeholder="نام آیکون (مثال: house, user)" style="
                                    width: 100%;
                                    padding: 6px;
                                    border: 1px solid #ddd;
                                    border-radius: 3px;
                                    font-size: 13px;
                                ">
                                <button type="button" id="insert-fa-icon" class="button button-small" style="
                                    width: 100%;
                                    margin-top: 6px;
                                ">درج آیکون</button>
                            </div>
                        `);

                        $('#insert-fa-icon').on('click', () => {
                            const iconName = $('#fa-icon-search').val().trim();
                            if (iconName) {
                                const iconClass = `fa-solid fa-${iconName}`;
                                const editor = window.parent.tinymce?.get('content');
                                if (editor) {
                                    editor.insertContent(`<i class="${iconClass}" aria-hidden="true"></i> `);
                                    window.parent.tb_remove();
                                }
                            }
                        });
                    }
                }, 500);
            });
        }

        initializeWidgets() {
            $('.widgets-holder-wrap').each(function () {
                const $holder = $(this);
                if (!$holder.find('.tez-widget-helper').length) {
                    $holder.prepend(`
                        <div class="tez-widget-helper" style="
                            background: linear-gradient(135deg, #1FA547, #2FD65A);
                            color: white;
                            padding: 12px;
                            border-radius: 6px;
                            margin-bottom: 12px;
                            font-size: 13px;
                        ">
                            <i class="fa-solid fa-lightbulb" style="margin-left: 8px;"></i>
                            <strong>راهنما:</strong> برای بهترین تجربه، از ویجت‌های تزنویسان استفاده کنید.
                        </div>
                    `);
                }
            });
        }

        bindEvents() {
            $(document).ajaxStart(() => this.showLoadingIndicator())
                       .ajaxStop(() => this.hideLoadingIndicator());

            $('form').on('submit', (e) => {
                if (!this.validateForm($(e.target))) {
                    e.preventDefault();
                    this.showAdminNotice('لطفاً فیلدهای ضروری را پر کنید', 'error');
                }
            });

            $('input[type="text"], textarea').on('input', this.debounce((e) => {
                this.autoSaveField($(e.target));
            }, 1000));
        }

        validateForm($form) {
            let isValid = true;

            $form.find('[required]').each(function () {
                const $field = $(this);
                if (!$field.val().trim()) {
                    $field.addClass('error');
                    isValid = false;
                } else {
                    $field.removeClass('error');
                }
            });

            return isValid;
        }

        autoSaveField($field) {
            if ($field.data('auto-save') && this.config.ajaxUrl) {
                $.post(this.config.ajaxUrl, {
                    action: 'teznevisan_auto_save_field',
                    field_name: $field.attr('name'),
                    field_value: $field.val(),
                    nonce: this.config.nonce
                }).done(() => {
                    $field.addClass('auto-saved');
                    setTimeout(() => $field.removeClass('auto-saved'), 2000);
                });
            }
        }

        showLoadingIndicator() {
            if (!$('#tez-loading').length) {
                $('body').append(`
                    <div id="tez-loading" style="
                        position: fixed;
                        top: 32px;
                        left: 50%;
                        transform: translateX(-50%);
                        background: #1FA547;
                        color: white;
                        padding: 8px 16px;
                        border-radius: 4px;
                        font-size: 13px;
                        z-index: 99999;
                        font-family: IRANSans, Arial, sans-serif;
                    ">
                        <i class="fa-solid fa-spinner fa-spin" style="margin-left: 6px;"></i>
                        در حال پردازش...
                    </div>
                `);
            }
        }

        hideLoadingIndicator() {
            $('#tez-loading').fadeOut(300, function () {
                $(this).remove();
            });
        }

        showAdminNotice(message, type = 'info', dismissible = true) {
            const typeClasses = {
                success: 'notice-success',
                error: 'notice-error',
                warning: 'notice-warning',
                info: 'notice-info'
            };

            const icons = {
                success: 'fa-solid fa-circle-check',
                error: 'fa-solid fa-circle-exclamation',
                warning: 'fa-solid fa-triangle-exclamation',
                info: 'fa-solid fa-circle-info'
            };

            const noticeClass = `notice ${typeClasses[type]} ${dismissible ? 'is-dismissible' : ''}`;

            const $notice = $(`
                <div class="${noticeClass}" style="display: flex; align-items: center; gap: 8px;">
                    <i class="${icons[type]}" style="color: inherit; font-size: 16px;"></i>
                    <p style="margin: 0;">${message}</p>
                </div>
            `);

            $('.wrap h1').first().after($notice);

            if (dismissible) {
                $notice.find('.notice-dismiss').on('click', () => {
                    $notice.fadeOut();
                });
            }

            setTimeout(() => {
                $notice.fadeOut();
            }, 5000);
        }

        addPersianWordCount() {
            if ($('#content').length && !$('#persian-word-count').length) {
                $('#content').after(`
                    <div id="persian-word-count" style="
                        margin-top: 8px;
                        padding: 6px 12px;
                        background: #f8f9fa;
                        border-radius: 4px;
                        font-size: 12px;
                        color: #666;
                    ">
                        تعداد کلمات فارسی: <span class="count">0</span>
                    </div>
                `);

                $('#content').on('input', () => {
                    const content = $('#content').val();
                    const wordCount = this.countPersianWords(content);
                    $('#persian-word-count .count').text(wordCount);
                });
            }
        }

        countPersianWords(text) {
            const plainText = text.replace(/<[^>]*>/g, '');
            const persianWords = plainText.match(/[\u0600-\u06FF\u0750-\u077F]+/g);
            return persianWords ? persianWords.length : 0;
        }

        convertToPersianNumbers(content) {
            const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            for (let i = 0; i < englishNumbers.length; i++) {
                const regex = new RegExp(englishNumbers[i], 'g');
                content = content.replace(regex, persianNumbers[i]);
            }
            return content;
        }

        showAutoSaveIndicator() {
            if (!$('#auto-save-indicator').length) {
                $('#titlediv').after(`
                    <div id="auto-save-indicator" style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        background: #28a745;
                        color: white;
                        padding: 4px 8px;
                        border-radius: 0 0 4px 0;
                        font-size: 11px;
                        z-index: 1000;
                    ">
                        <i class="fa-solid fa-save" style="margin-left: 4px;"></i>
                        ذخیره خودکار
                    </div>
                `);

                setTimeout(() => {
                    $('#auto-save-indicator').fadeOut();
                }, 2000);
            }
        }

        debounce(func, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }
    }

    // Initialize admin enhancements
    $(document).ready(() => {
        if (typeof window.TeznevisanAdmin === 'undefined') {
            window.TeznevisanAdmin = new TeznevisanAdmin();
        }
    });

})(jQuery);

// Add admin-specific CSS
const adminStyles = document.createElement('style');
adminStyles.textContent = `
.auto-saved {
    border-color: #28a745 !important;
    box-shadow: 0 0 0 1px #28a745 !important;
}
.error {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 1px #dc3545 !important;
}
.iranSans-loaded * {
    font-family: 'IRANSans', -apple-system, BlinkMacSystemFont, sans-serif !important;
}
.persian-helper {
    margin: 0 8px;
    color: #1FA547 !important;
    text-decoration: none;
    font-weight: 600;
}
.persian-helper:hover {
    color: #178A3A !important;
}
.teznevisan-admin-branding {
    font-family: 'IRANSans', Arial, sans-serif !important;
}
`;
document.head.appendChild(adminStyles);
