jQuery(document).ready(function($) {
    'use strict';

    const TeznevisanClassicEditor = {
        init: function() {
            this.loadFontAwesome();
            this.enforceThemeFont();
            this.initTinyMCE();
            this.bindEvents();
            this.initTooltips();
            this.initShortcuts();
        },

        loadFontAwesome: function() {
            if ($('#fontawesome-7-pro-css').length === 0) {
                $('<link>', {
                    rel: 'stylesheet',
                    id: 'fontawesome-7-pro-css',
                    href: '/assets/fonts/fontawesome/css/all.css' // Adjust path if needed
                }).appendTo('head')
                  .on('load', () => console.log('Font Awesome 7 Pro CSS loaded'))
                  .on('error', () => console.error('Failed to load Font Awesome 7 Pro CSS'));
            }
        },

        enforceThemeFont: function() {
            // Apply theme font (e.g. IRANSans) to classic editor container and TinyMCE content iframe
            $('#postdivrich, .wp-editor-container, .wp-editor-area').css('font-family', "'IRANSans', Tahoma, sans-serif");
        },

        initTinyMCE: function() {
            if (typeof tinyMCE !== 'undefined') {
                tinyMCE.init({
                    selector: 'textarea.wp-editor-area',
                    language: 'fa', // Matches the fa.js file name
                    language_url: '/assets/js/tinymce/langs/fa.js', // Persian translation file path
                    language_load: false, // Only load this local language file
                    content_css: '/assets/css/editor-style.css', // Load your theme editor styles
                    height: 400, // Default editor height, can be dynamically changed
                    directionality: isRTL() ? 'rtl' : 'ltr',
                    setup: function(editor) {
                        editor.on('init', function() {
                            // Force theme font in editor content
                            editor.getDoc().body.style.fontFamily = "'IRANSans', Tahoma, sans-serif";
                        });
                    },
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table emoticons template paste help wordcount',
                    toolbar1: 'formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code preview',
                    toolbar2: 'fontselect fontsizeselect | forecolor backcolor | table | emoticons charmap | undo redo | help',
                    font_formats: 'IRANSans,Vazirmatn=Vazirmatn,sans-serif;Tahoma=Tahoma,Arial,sans-serif;Arial=Arial,sans-serif;Times New Roman=Times New Roman,serif',
                    style_formats: [
                        {title: 'تیتر اصلی', format: 'h1'},
                        {title: 'تیتر فرعی', format: 'h2'},
                        {title: 'پاراگراف مهم', selector: 'p', classes: 'important-paragraph'},
                        {title: 'متن هایلایت', inline: 'span', classes: 'highlight'}
                    ]
                });
            }
        },

        bindEvents: function() {
            $('#teznevisan-classic-settings-form').on('submit', this.saveSettings);
            $('.reset-defaults').on('click', this.resetDefaults);
            $('input[name="settings[default_editor_height]"]').on('input change', this.updateEditorHeight);
        },

        initTooltips: function() {
            $('.toolbar-group button[title]').tooltip({
                placement: 'top',
                trigger: 'hover'
            });
        },

        initShortcuts: function() {
            $(document).on('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.target.tagName === 'TEXTAREA') {
                    switch(e.which) {
                        case 83: // Ctrl+S
                            e.preventDefault();
                            $('#publish, #save-post').click();
                            break;
                        case 66: // Ctrl+B
                            e.preventDefault();
                            TeznevisanClassicEditor.wrapSelection('**', '**', e.target);
                            break;
                        case 73: // Ctrl+I
                            e.preventDefault();
                            TeznevisanClassicEditor.wrapSelection('*', '*', e.target);
                            break;
                    }
                }
            });
        },

        wrapSelection: function(before, after, element) {
            const start = element.selectionStart;
            const end = element.selectionEnd;
            const selectedText = element.value.substring(start, end);
            const replacement = before + selectedText + after;

            element.value = element.value.substring(0, start) + replacement + element.value.substring(end);
            element.setSelectionRange(start + before.length, start + before.length + selectedText.length);
            element.focus();
        },

        saveSettings: function(e) {
            e.preventDefault();
            const $form = $(this);
            const formData = new FormData($form[0]);
            formData.append('action', 'save_classic_editor_settings');
            formData.append('nonce', teznevisanClassicEditor.nonce);

            $.ajax({
                url: teznevisanClassicEditor.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $form.find('input[type="submit"]').prop('disabled', true).val('در حال ذخیره...');
                },
                success: function(response) {
                    const type = response.success ? 'success' : 'error';
                    const message = response.success ? teznevisanClassicEditor.strings.save_success : teznevisanClassicEditor.strings.save_error;
                    TeznevisanClassicEditor.showNotice(message, type);
                },
                error: function() {
                    TeznevisanClassicEditor.showNotice(teznevisanClassicEditor.strings.save_error, 'error');
                },
                complete: function() {
                    $form.find('input[type="submit"]').prop('disabled', false).val('ذخیره تنظیمات');
                }
            });
        },

        resetDefaults: function(e) {
            e.preventDefault();
            if (confirm(teznevisanClassicEditor.strings.confirm_reset)) {
                $('input[name="settings[force_classic_editor]"]').prop('checked', false);
                $('input[name="settings[default_editor_height]"]').val('400');
                $('input[name="settings[tinymce_toolbar]"]').prop('checked', true);
                $('input[name="settings[tinymce_plugins]"]').prop('checked', true);
                $('#teznevisan-classic-settings-form').submit();
            }
        },

        updateEditorHeight: function() {
            const height = $(this).val();
            $('.editor-content').css('min-height', height + 'px');
        },

        showNotice: function(message, type) {
            const $notice = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
            $('.wrap h1').after($notice);
            setTimeout(() => $notice.fadeOut(function() { $(this).remove(); }), 5000);
        }
    };

    window.TeznevisanClassicEditor = TeznevisanClassicEditor;
    TeznevisanClassicEditor.init();

    // Helper function to detect RTL layout (replace with your actual detection if needed)
    function isRTL() {
        return document.documentElement.getAttribute('dir') === 'rtl' ||
               $('body').hasClass('rtl');
    }
});
