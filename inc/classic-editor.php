<?php
/**
 * Classic Editor with TinyMCE
 * Uses theme's IranSans font and Font Awesome 7 Pro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ClassicEditor {
    
    private $editor_id;
    private $content;
    private $settings;
    
    public function __construct($editor_id = 'classic-editor', $content = '', $settings = []) {
        $this->editor_id = sanitize_html_class($editor_id);
        $this->content = $content;
        $this->settings = wp_parse_args($settings, $this->get_default_settings());
        
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }
    
    private function get_default_settings() {
        return [
            'height' => 400,
            'menubar' => true,
            'toolbar' => 'full',
            'plugins' => 'all',
            'language' => 'fa',
            'directionality' => 'rtl',
            'font_family' => 'IranSans',
            'content_css' => true,
            'theme' => 'silver',
            'branding' => false,
            'resize' => true,
            'paste_as_text' => false,
            'paste_data_images' => true,
            'image_upload' => true,
            'file_picker' => true
        ];
    }
    
    public function enqueue_scripts() {
        // TinyMCE Core
        wp_enqueue_script(
            'tinymce-core',
            get_template_directory_uri() . '/assets/js/tinymce/tinymce.min.js',
            [],
            '6.8.3',
            true
        );
        
        // Persian Language
        wp_enqueue_script(
            'tinymce-lang-fa',
            get_template_directory_uri() . '/assets/js/tinymce/langs/fa.js',
            ['tinymce-core'],
            '6.8.3',
            true
        );
        
        // Font Awesome 7 Pro
        wp_enqueue_style(
            'fontawesome-pro-admin',
            get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css',
            [],
            '7.0.0'
        );
        
        // Editor Styles
        wp_enqueue_style(
            'classic-editor-styles',
            get_template_directory_uri() . '/assets/css/classic-editor.css',
            ['fontawesome-pro-admin'],
            '1.0.0'
        );
        
        // Initialize TinyMCE
        wp_add_inline_script('tinymce-lang-fa', $this->get_tinymce_init_script());
    }
    
    private function get_tinymce_init_script() {
    $config = $this->get_tinymce_config();
    
    return "
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure TinyMCE is loaded
        if (typeof tinymce === 'undefined') {
            console.error('TinyMCE not loaded');
            return;
        }
        
        // Load Persian language if not already loaded
        if (!tinymce.util.I18n.data.fa) {
            tinymce.util.I18n.add('fa', {
                'Bold': 'درشت',
                'Italic': 'مایل',
                'Underline': 'زیرخط',
                'Strikethrough': 'خط‌خورده',
                'Subscript': 'زیرنویس',
                'Superscript': 'بالانویس',
                'Cut': 'برش',
                'Copy': 'کپی',
                'Paste': 'چسباندن',
                'Select all': 'انتخاب همه',
                'New document': 'سند جدید',
                'Ok': 'تأیید',
                'Cancel': 'لغو',
                'Visual aids': 'کمک‌های بصری',
                'Font Family': 'خانواده فونت',
                'Font Sizes': 'اندازه فونت',
                'Formats': 'قالب‌ها',
                'Align left': 'چپ‌چین',
                'Align center': 'وسط‌چین',
                'Align right': 'راست‌چین',
                'Justify': 'بلوک‌چین',
                'Increase indent': 'افزایش تورفتگی',
                'Decrease indent': 'کاهش تورفتگی',
                'Undo': 'واگرد',
                'Redo': 'بازگرد',
                'Insert/edit link': 'درج/ویرایش پیوند',
                'Remove link': 'حذف پیوند',
                'Insert/edit image': 'درج/ویرایش تصویر',
                'Insert/edit media': 'درج/ویرایش رسانه',
                'Insert/edit video': 'درج/ویرایش ویدیو',
                'Insert table': 'درج جدول',
                'Table properties': 'ویژگی‌های جدول',
                'Delete table': 'حذف جدول',
                'Cell': 'سلول',
                'Row': 'سطر',
                'Column': 'ستون',
                'Insert time/date': 'درج زمان/تاریخ',
                'Insert/edit code sample': 'درج/ویرایش نمونه کد',
                'Color': 'رنگ',
                'Text color': 'رنگ متن',
                'Background color': 'رنگ پس‌زمینه',
                'Custom color': 'رنگ سفارشی',
                'Custom': 'سفارشی',
                'No color': 'بدون رنگ',
                'More...': 'بیشتر...',
                'Numbered list': 'لیست شماره‌دار',
                'Bullet list': 'لیست نقطه‌دار',
                'Show blocks': 'نمایش بلوک‌ها',
                'Show invisible characters': 'نمایش کاراکترهای پنهان',
                'Words: {0}': 'کلمات: {0}',
                'Insert Font Awesome Icon': 'درج آیکون Font Awesome',
                'Select Icon': 'انتخاب آیکون',
                'Icon': 'آیکون',
                'Size': 'اندازه',
                'Color': 'رنگ',
                'Search icons...': 'جستجوی آیکون‌ها...',
                'No icons found': 'آیکونی یافت نشد',
                'Insert icon': 'درج آیکون'
            });
        }
        
        // Initialize TinyMCE with enhanced config
        tinymce.init(" . json_encode($config, JSON_UNESCAPED_UNICODE) . ");
    });";
}
    
    private function get_tinymce_config(): array {
    return [
        'selector' => '#' . $this->editor_id,
        'height' => $this->settings['height'],
        'menubar' => $this->settings['menubar'],
        'toolbar_mode' => 'sliding',
        'plugins' => $this->get_plugins(),
        'toolbar' => $this->get_toolbar(),
        'language' => 'fa',
        'language_url' => get_template_directory_uri() . '/assets/js/tinymce/langs/fa.js',
        'directionality' => 'rtl',
        'skin' => 'oxide',
        'content_css' => $this->get_content_css(),
        'content_style' => $this->get_content_style(),
        'font_family_formats' => $this->get_font_families(),
        'font_size_formats' => '8px 9px 10px 11px 12px 14px 16px 18px 20px 22px 24px 26px 28px 36px 48px 72px',
        'block_formats' => 'پاراگراف=p; عنوان 1=h1; عنوان 2=h2; عنوان 3=h3; عنوان 4=h4; عنوان 5=h5; عنوان 6=h6; کد=pre',
        'branding' => false,
        'resize' => true,
        'paste_as_text' => false,
        'paste_data_images' => true,
        'automatic_uploads' => true,
        'images_upload_handler' => 'tez_tinymce_upload_handler',
        'valid_elements' => '*[*]',
        'extended_valid_elements' => 'i[class|style|aria-hidden],span[class|style],div[class|style]',
        'custom_elements' => 'i[class|style|aria-hidden]',
        'setup' => 'tez_tinymce_setup'
    ];
}

private function get_content_css(): string {
    return get_template_directory_uri() . '/assets/css/editor-fontawesome.css';
}

    private function get_plugins(): string 
{
    $plugins = [
        'advlist',          // Advanced list styles
        'autolink',         // Auto-convert URLs to links
        'autoresize',       // Auto-resize editor height
        'lists',            // Enhanced list functionality
        'link',             // Link dialog
        'image',            // Image dialog
        'charmap',          // Special characters
        'preview',          // Preview content
        'anchor',           // Anchor links
        'searchreplace',    // Search and replace
        'visualblocks',     // Visual blocks
        'code',             // HTML code editor
        'fullscreen',       // Fullscreen mode
        'insertdatetime',   // Insert date/time
        'media',            // Media embed
        'table',            // Table functionality
        'contextmenu',      // Context menu
        'paste',            // Enhanced paste
        'help',             // Help dialog
        'wordcount',        // Word count
        'emoticons',        // Emoticons (we'll replace with FA)
        'template',         // Content templates
        'codesample',       // Code samples
        'nonbreaking',      // Non-breaking spaces
        'pagebreak',        // Page breaks
        'directionality'    // RTL/LTR support
    ];
    
    return implode(' ', $plugins);
}
    
    private function get_toolbar(): string 
{
    $toolbar_rows = [
        'undo redo | bold italic underline strikethrough | fontfamily fontsize',
        'forecolor backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent',
        'link image media table | fontawesome customStyles persianTypo | code preview fullscreen help'
    ];
    
    return implode(' | ', $toolbar_rows);
}
    
    private function get_font_families() {
        return implode('; ', [
            'IranSans=IranSans, Arial, sans-serif',
            'Arial=Arial, sans-serif',
            'Helvetica=Helvetica, sans-serif',
            'Times New Roman=Times New Roman, serif',
            'Courier New=Courier New, monospace',
            'Verdana=Verdana, sans-serif',
            'Georgia=Georgia, serif',
            'Palatino=Palatino, serif',
            'Tahoma=Tahoma, sans-serif',
            'Geneva=Geneva, sans-serif',
            'Impact=Impact, sans-serif',
            'Trebuchet MS=Trebuchet MS, sans-serif'
        ]);
    }
    
    private function get_content_style() {
        return "
        body { 
            font-family: IranSans, Arial, sans-serif !important; 
            direction: rtl;
            font-size: 16px;  
            text-align: right; 
            line-height: 1.6;
            padding: 20px;
            max-width: none;
            margin: 0;
            background: #fff;
            color: #333;
        }
        
        p { 
            margin: 0 0 1rem 0; 
            font-family: IranSans, Arial, sans-serif;
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 { 
            font-family: IranSans, Arial, sans-serif !important;
            font-weight: bold;
            line-height: 1.4;
            margin: 1.5rem 0 1rem 0;
            color: #2c3e50;
        }
        
        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.75rem; }
        h4 { font-size: 1.5rem; }
        h5 { font-size: 1.25rem; }
        h6 { font-size: 1.1rem; }
        
        blockquote {
            border-right: 4px solid #3498db;
            border-left: none;
            padding: 1rem 2rem;
            margin: 1rem 0;
            background: #f8f9fa;
            font-style: italic;
        }
        
        ul, ol {
            margin: 1rem 0;
            padding-right: 2rem;
            padding-left: 0;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 1rem 0;
            direction: rtl;
        }
        
        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .fa, .fas, .far, .fal, .fad, .fab {
            font-family: 'Font Awesome 7 Pro' !important;
        }
        
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            direction: ltr;
            text-align: left;
            display: inline-block;
        }
        
        pre {
            background: #f4f4f4;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
            direction: ltr;
            text-align: left;
        }
        
        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
        .text-right { text-align: right !important; }
        .text-justify { text-align: justify !important; }
        
        .highlight {
            background-color: #fff3cd;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        
        .text-primary { color: #007bff !important; }
        .text-secondary { color: #6c757d !important; }
        .text-success { color: #28a745 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-warning { color: #ffc107 !important; }
        .text-info { color: #17a2b8 !important; }
        
        .bg-light { background-color: #f8f9fa !important; padding: 1rem; border-radius: 0.25rem; }
        .bg-primary { background-color: #007bff !important; color: white !important; padding: 0.5rem; border-radius: 0.25rem; }
        .bg-secondary { background-color: #6c757d !important; color: white !important; padding: 0.5rem; border-radius: 0.25rem; }
        
        .btn {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            margin: 0.25rem;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            text-decoration: none;
            cursor: pointer;
            font-family: IranSans, Arial, sans-serif;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        ";
    }
    
    private function get_style_formats() {
        return [
            [
                'title' => 'استایل‌های متن',
                'items' => [
                    ['title' => 'متن هایلایت', 'inline' => 'span', 'classes' => 'highlight'],
                    ['title' => 'متن کوچک', 'inline' => 'small'],
                    ['title' => 'متن بزرگ', 'inline' => 'span', 'styles' => ['font-size' => '1.2em']],
                    ['title' => 'کد درون‌خطی', 'inline' => 'code']
                ]
            ],
            [
                'title' => 'رنگ‌های متن',
                'items' => [
                    ['title' => 'آبی', 'inline' => 'span', 'classes' => 'text-primary'],
                    ['title' => 'خاکستری', 'inline' => 'span', 'classes' => 'text-secondary'],
                    ['title' => 'سبز', 'inline' => 'span', 'classes' => 'text-success'],
                    ['title' => 'قرمز', 'inline' => 'span', 'classes' => 'text-danger'],
                    ['title' => 'زرد', 'inline' => 'span', 'classes' => 'text-warning'],
                    ['title' => 'فیروزه‌ای', 'inline' => 'span', 'classes' => 'text-info']
                ]
            ],
            [
                'title' => 'زمینه‌ها',
                'items' => [
                    ['title' => 'زمینه روشن', 'block' => 'div', 'classes' => 'bg-light'],
                    ['title' => 'زمینه آبی', 'block' => 'div', 'classes' => 'bg-primary'],
                    ['title' => 'زمینه خاکستری', 'block' => 'div', 'classes' => 'bg-secondary']
                ]
            ],
            [
                'title' => 'دکمه‌ها',
                'items' => [
                    ['title' => 'دکمه اصلی', 'inline' => 'a', 'classes' => 'btn btn-primary', 'attributes' => ['href' => '#']],
                    ['title' => 'دکمه ثانویه', 'inline' => 'a', 'classes' => 'btn btn-secondary', 'attributes' => ['href' => '#']]
                ]
            ],
            [
    'title' => 'آیکون‌ها',
    'items' => [
        ['title' => 'آیکون خانه', 'inline' => 'i', 'classes' => 'fa-solid fa-home'],
        ['title' => 'آیکون کاربر', 'inline' => 'i', 'classes' => 'fa-solid fa-user'],
        ['title' => 'آیکون ایمیل', 'inline' => 'i', 'classes' => 'fa-solid fa-envelope'],
        ['title' => 'آیکون تلفن', 'inline' => 'i', 'classes' => 'fa-solid fa-phone'],
        ['title' => 'آیکون موقعیت', 'inline' => 'i', 'classes' => 'fa-solid fa-location-dot'],
        ['title' => 'آیکون زمان', 'inline' => 'i', 'classes' => 'fa-solid fa-clock'],
        ['title' => 'آیکون تاریخ', 'inline' => 'i', 'classes' => 'fa-solid fa-calendar'],
        ['title' => 'آیکون دانلود', 'inline' => 'i', 'classes' => 'fa-solid fa-download'],
        ['title' => 'آیکون آپلود', 'inline' => 'i', 'classes' => 'fa-solid fa-upload'],
        ['title' => 'آیکون جستجو', 'inline' => 'i', 'classes' => 'fa-solid fa-magnifying-glass'],
        ['title' => 'آیکون تنظیمات', 'inline' => 'i', 'classes' => 'fa-solid fa-gear'],
        ['title' => 'آیکون قفل', 'inline' => 'i', 'classes' => 'fa-solid fa-lock'],
        ['title' => 'آیکون ستاره', 'inline' => 'i', 'classes' => 'fa-solid fa-star'],
        ['title' => 'آیکون قلب', 'inline' => 'i', 'classes' => 'fa-solid fa-heart'],
        ['title' => 'آیکون چک', 'inline' => 'i', 'classes' => 'fa-solid fa-check'],
        ['title' => 'آیکون ضربدر', 'inline' => 'i', 'classes' => 'fa-solid fa-xmark']
    ]
]

        ];
    }
    
    private function get_color_map() {
        return [
            '#000000', 'سیاه',
            '#333333', 'خاکستری تیره',
            '#666666', 'خاکستری',
            '#999999', 'خاکستری روشن',
            '#CCCCCC', 'نقره‌ای',
            '#FFFFFF', 'سفید',
            '#FF0000', 'قرمز',
            '#00FF00', 'سبز',
            '#0000FF', 'آبی',
            '#FFFF00', 'زرد',
            '#FF00FF', 'بنفش',
            '#00FFFF', 'فیروزه‌ای',
            '#FF6600', 'نارنجی',
            '#FF9900', 'نارنجی روشن',
            '#339966', 'سبز دریایی',
            '#3366CC', 'آبی آسمانی',
            '#663399', 'بنفش تیره',
            '#CC3366', 'صورتی تیره'
        ];
    }
    
    public function render($name = '', $value = '', $attrs = []) {
        $textarea_attrs = wp_parse_args($attrs, [
            'id' => $this->editor_id,
            'name' => $name ?: $this->editor_id,
            'class' => 'classic-editor-textarea',
            'style' => 'width: 100%; min-height: 200px; font-family: IranSans, Arial, sans-serif; direction: rtl;'
        ]);
        
        $content = $value ?: $this->content;
        
        ob_start();
        ?>
        <div class="classic-editor-wrapper" data-editor-id="<?php echo esc_attr($this->editor_id); ?>">
            <textarea <?php echo $this->render_attributes($textarea_attrs); ?>><?php echo esc_textarea($content); ?></textarea>
        </div>
        
        <script type="text/javascript">
            // File Picker Callback
            function classic_editor_file_picker(callback, value, meta) {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', meta.filetype === 'image' ? 'image/*' : meta.filetype === 'media' ? 'video/*,audio/*' : '*/*');
                
                input.onchange = function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function() {
                            if (meta.filetype === 'image') {
                                callback(reader.result, {
                                    alt: file.name,
                                    title: file.name
                                });
                            } else {
                                callback(reader.result, {
                                    title: file.name
                                });
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                };
                
                input.click();
            }

            // TinyMCE Setup Function
function tez_tinymce_setup(editor) {
    console.log('TinyMCE Editor initialized:', editor.id);
    
    editor.on('init', function() {
        // Inject FontAwesome CSS into editor iframe
        const doc = editor.getDoc();
        const head = doc.head || doc.getElementsByTagName('head')[0];
        
        if (head) {
            const faLink = doc.createElement('link');
            faLink.rel = 'stylesheet';
            faLink.href = '<?php echo get_template_directory_uri(); ?>/assets/fonts/fontawesome/css/all.css';
            head.appendChild(faLink);
            
            const fontLink = doc.createElement('link');
            fontLink.rel = 'stylesheet';
            fontLink.href = '<?php echo get_template_directory_uri(); ?>/assets/fonts/iransans/iransans.css';
            head.appendChild(fontLink);
        }
    });
}

// Upload Handler
function tez_tinymce_upload_handler(blobInfo, success, failure, progress) {
    const formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    formData.append('action', 'classic_editor_upload');
    formData.append('nonce', '<?php echo wp_create_nonce('classic_editor_upload'); ?>');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            success(result.data.url);
        } else {
            failure('خطا در آپلود فایل: ' + (result.data || 'نامعلوم'));
        }
    })
    .catch(() => {
        failure('خطا در آپلود فایل');
    });
}
            
            // Upload Handler
            function classic_editor_upload_handler(blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('action', 'classic_editor_upload');
                    formData.append('nonce', '<?php echo wp_create_nonce('classic_editor_upload'); ?>');
                    
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            resolve(data.location);
                        } else {
                            reject(data.message || 'Upload failed');
                        }
                    })
                    .catch(() => {
                        reject('Network error');
                    });
                });
            }
            
            // Setup Callback - Enhanced with full FA7 Pro picker
function classic_editor_setup(editor) {
    // Register FontAwesome icon picker button
    editor.ui.registry.addButton('fontawesome', {
        text: 'آیکون',
        icon: 'emoji',
        tooltip: 'درج آیکون Font Awesome',
        onAction: function() {
            // Create comprehensive icon picker modal
            const iconCategories = {
                'solid': {
                    'label': 'Solid',
                    'icons': [
                        { name: 'خانه', class: 'fa-solid fa-house' },
                        { name: 'کاربر', class: 'fa-solid fa-user' },
                        { name: 'ایمیل', class: 'fa-solid fa-envelope' },
                        { name: 'تلفن', class: 'fa-solid fa-phone' },
                        { name: 'موقعیت', class: 'fa-solid fa-location-dot' },
                        { name: 'زمان', class: 'fa-solid fa-clock' },
                        { name: 'تاریخ', class: 'fa-solid fa-calendar' },
                        { name: 'دانلود', class: 'fa-solid fa-download' },
                        { name: 'آپلود', class: 'fa-solid fa-upload' },
                        { name: 'جستجو', class: 'fa-solid fa-magnifying-glass' },
                        { name: 'تنظیمات', class: 'fa-solid fa-gear' },
                        { name: 'قفل', class: 'fa-solid fa-lock' },
                        { name: 'ستاره', class: 'fa-solid fa-star' },
                        { name: 'قلب', class: 'fa-solid fa-heart' },
                        { name: 'تیک', class: 'fa-solid fa-check' },
                        { name: 'ضربدر', class: 'fa-solid fa-xmark' },
                        { name: 'سبد خرید', class: 'fa-solid fa-cart-shopping' },
                        { name: 'پرچم', class: 'fa-solid fa-flag' },
                        { name: 'پیغام', class: 'fa-solid fa-comment' },
                        { name: 'کامنت ها', class: 'fa-solid fa-comments' },
                        { name: 'فلش راست', class: 'fa-solid fa-arrow-right' },
                        { name: 'فلش چپ', class: 'fa-solid fa-arrow-left' },
                        { name: 'فلش بالا', class: 'fa-solid fa-arrow-up' },
                        { name: 'فلش پایین', class: 'fa-solid fa-arrow-down' },
                        { name: 'لیست', class: 'fa-solid fa-list' },
                        { name: 'کاربرهای گروه', class: 'fa-solid fa-users' },
                        { name: 'دوربین', class: 'fa-solid fa-camera' },
                        { name: 'میکروفون', class: 'fa-solid fa-microphone' },
                        { name: 'موسیقی', class: 'fa-solid fa-music' },
                        { name: 'قلم', class: 'fa-solid fa-pen' },
                        { name: 'نقشه', class: 'fa-solid fa-map' },
                        { name: 'ضمیمه', class: 'fa-solid fa-paperclip' },
                        { name: 'صفحه نمایش', class: 'fa-solid fa-desktop' },
                        { name: 'تلفن همراه', class: 'fa-solid fa-mobile-screen' },
                        { name: 'دست', class: 'fa-solid fa-hand' },
                        { name: 'تیک سبز', class: 'fa-solid fa-circle-check' },
                        { name: 'سطل زباله', class: 'fa-solid fa-trash' },
                        { name: 'ذخیره', class: 'fa-solid fa-floppy-disk' },
                        { name: 'تایمر', class: 'fa-solid fa-hourglass' },
                        { name: 'هشدار', class: 'fa-solid fa-triangle-exclamation' },
                        { name: 'فارغ التحصیل', class: 'fa-solid fa-graduation-cap' },
                        { name: 'کتاب', class: 'fa-solid fa-book' },
                        { name: 'کیف کار', class: 'fa-solid fa-briefcase' },
                        { name: 'ابزار', class: 'fa-solid fa-tools' },
                        { name: 'وبلاگ', class: 'fa-solid fa-blog' },
                        { name: 'روزنامه', class: 'fa-solid fa-newspaper' },
                        { name: 'اطلاعات', class: 'fa-solid fa-circle-info' }
                    ]
                },
                'regular': {
                    'label': 'Regular',
                    'icons': [
                        { name: 'خانه (خالی)', class: 'fa-regular fa-house' },
                        { name: 'کاربر (خالی)', class: 'fa-regular fa-user' },
                        { name: 'ایمیل (خالی)', class: 'fa-regular fa-envelope' },
                        { name: 'ستاره (خالی)', class: 'fa-regular fa-star' },
                        { name: 'قلب (خالی)', class: 'fa-regular fa-heart' },
                        { name: 'پیغام (خالی)', class: 'fa-regular fa-comment' },
                        { name: 'ساعت (خالی)', class: 'fa-regular fa-clock' },
                        { name: 'تاریخ (خالی)', class: 'fa-regular fa-calendar' }
                    ]
                },
                'brands': {
                    'label': 'Brands',
                    'icons': [
                        { name: 'واتساپ', class: 'fa-brands fa-whatsapp' },
                        { name: 'تلگرام', class: 'fa-brands fa-telegram' },
                        { name: 'اینستاگرام', class: 'fa-brands fa-instagram' },
                        { name: 'توییتر', class: 'fa-brands fa-twitter' },
                        { name: 'فیسبوک', class: 'fa-brands fa-facebook' },
                        { name: 'لینکدین', class: 'fa-brands fa-linkedin' },
                        { name: 'یوتیوب', class: 'fa-brands fa-youtube' },
                        { name: 'گوگل', class: 'fa-brands fa-google' }
                    ]
                }
            };
            
            // Create enhanced modal HTML
            let modalHTML = `
                <div class="fontawesome-picker-modal" style="direction: rtl; font-family: IRANSans, Arial, sans-serif;">
                    <div class="fa-picker-header">
                        <input type="text" id="fa-search" placeholder="جستجوی آیکون..." 
                               style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: IRANSans, sans-serif;">
                    </div>
                    
                    <div class="fa-picker-tabs" style="display: flex; margin-bottom: 15px; border-bottom: 1px solid #ddd;">
            `;
            
            // Add tabs for categories
            Object.keys(iconCategories).forEach((categoryKey, index) => {
                const category = iconCategories[categoryKey];
                modalHTML += `
                    <button class="fa-tab ${index === 0 ? 'active' : ''}" data-category="${categoryKey}" 
                            style="padding: 8px 16px; border: none; background: ${index === 0 ? '#1FA547' : '#f5f5f5'}; 
                                   color: ${index === 0 ? 'white' : '#333'}; cursor: pointer; font-family: IRANSans, sans-serif;">
                        ${category.label}
                    </button>
                `;
            });
            
            modalHTML += `
                    </div>
                    
                    <div class="fa-picker-content" style="max-height: 400px; overflow-y: auto;">
            `;
            
            // Add icon grids for each category
            Object.keys(iconCategories).forEach((categoryKey, categoryIndex) => {
                const category = iconCategories[categoryKey];
                modalHTML += `
                    <div class="fa-category-grid" data-category="${categoryKey}" 
                         style="display: ${categoryIndex === 0 ? 'grid' : 'none'}; 
                                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); 
                                gap: 8px; padding: 10px 0;">
                `;
                
                category.icons.forEach(icon => {
                    modalHTML += `
                        <div class="fa-icon-item" data-class="${icon.class}" 
                             style="display: flex; flex-direction: column; align-items: center; 
                                    padding: 12px 8px; border: 1px solid #ddd; border-radius: 4px; 
                                    cursor: pointer; transition: all 0.3s ease; background: white;">
                            <i class="${icon.class}" style="font-size: 24px; margin-bottom: 5px; color: #1FA547;"></i>
                            <span style="font-size: 10px; text-align: center; font-family: IRANSans, sans-serif;">${icon.name}</span>
                        </div>
                    `;
                });
                
                modalHTML += `</div>`;
            });
            
            modalHTML += `
                    </div>
                    
                    <div class="fa-picker-size" style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #ddd;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; font-family: IRANSans, sans-serif;">اندازه آیکون:</label>
                        <select id="fa-size" style="padding: 5px; border: 1px solid #ddd; border-radius: 4px; font-family: IRANSans, sans-serif;">
                            <option value="">عادی</option>
                            <option value="fa-xs">خیلی کوچک</option>
                            <option value="fa-sm">کوچک</option>
                            <option value="fa-lg">بزرگ</option>
                            <option value="fa-xl">خیلی بزرگ</option>
                            <option value="fa-2x">دو برابر</option>
                                                        <option value="fa-3x">سه برابر</option>
                            <option value="fa-4x">چهار برابر</option>
                            <option value="fa-5x">پنج برابر</option>
                        </select>
                    </div>
                    
                    <div class="fa-picker-color" style="margin-top: 10px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; font-family: IRANSans, sans-serif;">رنگ آیکون:</label>
                        <input type="color" id="fa-color" value="#1FA547" style="width: 50px; height: 30px; border: 1px solid #ddd; border-radius: 4px;">
                        <input type="text" id="fa-color-text" value="#1FA547" placeholder="#1FA547" 
                               style="margin-right: 10px; padding: 5px; width: 100px; border: 1px solid #ddd; border-radius: 4px; font-family: monospace;">
                    </div>
                </div>
            `;
            
            editor.windowManager.open({
                title: 'انتخاب آیکون Font Awesome',
                body: {
                    type: 'panel',
                    html: modalHTML
                },
                size: 'large',
                buttons: [
                    {
                        type: 'cancel',
                        text: 'لغو'
                    },
                    {
                        type: 'submit',
                        text: 'درج آیکون',
                        primary: true
                    }
                ],
                onSubmit: function(api) {
                    const selectedIcon = document.querySelector('.fa-icon-item.selected');
                    if (selectedIcon) {
                        const iconClass = selectedIcon.getAttribute('data-class');
                        const sizeClass = document.getElementById('fa-size').value;
                        const color = document.getElementById('fa-color-text').value;
                        
                        let finalClass = iconClass;
                        if (sizeClass) {
                            finalClass += ' ' + sizeClass;
                        }
                        
                        const iconHTML = `<i class="${finalClass}" style="color: ${color};"></i>`;
                        editor.insertContent(iconHTML);
                    }
                    api.close();
                },
                onCancel: function(api) {
                    api.close();
                }
            });
            
            // Add event listeners after modal opens
            setTimeout(() => {
                // Tab switching
                document.querySelectorAll('.fa-tab').forEach(tab => {
                    tab.addEventListener('click', function() {
                        const categoryKey = this.getAttribute('data-category');
                        
                        // Update tab appearance
                        document.querySelectorAll('.fa-tab').forEach(t => {
                            t.style.background = '#f5f5f5';
                            t.style.color = '#333';
                            t.classList.remove('active');
                        });
                        this.style.background = '#1FA547';
                        this.style.color = 'white';
                        this.classList.add('active');
                        
                        // Show/hide category grids
                        document.querySelectorAll('.fa-category-grid').forEach(grid => {
                            grid.style.display = 'none';
                        });
                        document.querySelector(`[data-category="${categoryKey}"]`).style.display = 'grid';
                    });
                });
                
                // Icon selection
                document.querySelectorAll('.fa-icon-item').forEach(item => {
                    item.addEventListener('click', function() {
                        // Remove previous selection
                        document.querySelectorAll('.fa-icon-item').forEach(i => {
                            i.style.background = 'white';
                            i.style.borderColor = '#ddd';
                            i.classList.remove('selected');
                        });
                        
                        // Select current item
                        this.style.background = '#e8f5e8';
                        this.style.borderColor = '#1FA547';
                        this.classList.add('selected');
                    });
                    
                    // Hover effects
                    item.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('selected')) {
                            this.style.background = '#f8f9fa';
                            this.style.borderColor = '#1FA547';
                        }
                    });
                    
                    item.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('selected')) {
                            this.style.background = 'white';
                            this.style.borderColor = '#ddd';
                        }
                    });
                });
                
                // Search functionality
                const searchInput = document.getElementById('fa-search');
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        document.querySelectorAll('.fa-icon-item').forEach(item => {
                            const iconName = item.querySelector('span').textContent.toLowerCase();
                            const iconClass = item.getAttribute('data-class').toLowerCase();
                            
                            if (iconName.includes(searchTerm) || iconClass.includes(searchTerm)) {
                                item.style.display = 'flex';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                }
                
                // Color picker sync
                const colorPicker = document.getElementById('fa-color');
                const colorText = document.getElementById('fa-color-text');
                
                if (colorPicker && colorText) {
                    colorPicker.addEventListener('change', function() {
                        colorText.value = this.value;
                        // Update preview if icon is selected
                        const selectedIcon = document.querySelector('.fa-icon-item.selected i');
                        if (selectedIcon) {
                            selectedIcon.style.color = this.value;
                        }
                    });
                    
                    colorText.addEventListener('input', function() {
                        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                            colorPicker.value = this.value;
                            // Update preview if icon is selected
                            const selectedIcon = document.querySelector('.fa-icon-item.selected i');
                            if (selectedIcon) {
                                selectedIcon.style.color = this.value;
                            }
                        }
                    });
                }
            }, 100);
        }
    });
    
    // Add other custom buttons
    editor.ui.registry.addButton('customStyles', {
        text: 'استایل',
        type: 'menubutton',
        fetch: function(callback) {
            const items = [
                {
                    type: 'menuitem',
                    text: 'متن هایلایت',
                    onAction: function() {
                        const selection = editor.selection.getContent();
                        if (selection) {
                            editor.insertContent(`<span style="background: #fff3cd; padding: 2px 6px; border-radius: 3px;">${selection}</span>`);
                        }
                    }
                },
                {
                    type: 'menuitem', 
                    text: 'کادر اطلاعات',
                    onAction: function() {
                        const selection = editor.selection.getContent() || 'متن اطلاعات شما';
                        editor.insertContent(`<div style="background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; padding: 15px; margin: 10px 0;"><i class="fa-solid fa-circle-info" style="color: #0c5460; margin-left: 8px;"></i>${selection}</div>`);
                    }
                },
                {
                    type: 'menuitem',
                    text: 'کادر هشدار',
                    onAction: function() {
                        const selection = editor.selection.getContent() || 'متن هشدار شما';
                        editor.insertContent(`<div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; padding: 15px; margin: 10px 0;"><i class="fa-solid fa-triangle-exclamation" style="color: #721c24; margin-left: 8px;"></i>${selection}</div>`);
                    }
                },
                {
                    type: 'menuitem',
                    text: 'کادر موفقیت',
                    onAction: function() {
                        const selection = editor.selection.getContent() || 'پیام موفقیت شما';
                        editor.insertContent(`<div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 15px; margin: 10px 0;"><i class="fa-solid fa-circle-check" style="color: #155724; margin-left: 8px;"></i>${selection}</div>`);
                    }
                },
                {
                    type: 'menuitem',
                    text: 'دکمه سفارشی',
                    onAction: function() {
                        editor.insertContent(`<a href="#" style="display: inline-block; background: #1FA547; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; margin: 5px 0;"><i class="fa-solid fa-arrow-left" style="margin-right: 8px;"></i>متن دکمه</a>`);
                    }
                }
            ];
            callback(items);
        }
    });
    
    // Add Persian typography button
    editor.ui.registry.addButton('persianTypo', {
        text: 'تایپو',
        type: 'menubutton',
        fetch: function(callback) {
            const items = [
                {
                    type: 'menuitem',
                    text: 'نیم‌فاصله',
                    onAction: function() {
                        editor.insertContent('‌');
                    }
                },
                {
                    type: 'menuitem',
                    text: 'فاصله مجازی',
                    onAction: function() {
                        editor.insertContent('‌');
                    }
                },
                {
                    type: 'menuitem',
                    text: 'ی فارسی',
                    onAction: function() {
                        const content = editor.getContent();
                        const corrected = content.replace(/ي/g, 'ی');
                        editor.setContent(corrected);
                    }
                },
                {
                    type: 'menuitem',
                    text: 'ک فارسی', 
                    onAction: function() {
                        const content = editor.getContent();
                        const corrected = content.replace(/ك/g, 'ک');
                        editor.setContent(corrected);
                    }
                }
            ];
            callback(items);
        }
    });
}

// Enhanced init callback
function classic_editor_init_callback(editor) {
    console.log('TinyMCE Editor initialized successfully:', editor.id);
    
    // Apply custom styles to editor content
    editor.on('init', function() {
        const doc = editor.getDoc();
        const head = doc.head || doc.getElementsByTagName('head')[0];
        
        // Add FontAwesome to editor content
        const faLink = doc.createElement('link');
        faLink.rel = 'stylesheet';
        faLink.href = '<?php echo TEZNEVISAN_ASSETS_URL; ?>/fonts/fontawesome/css/all.css';
        head.appendChild(faLink);
        
        // Add IRANSans font
        const fontLink = doc.createElement('link');
        fontLink.rel = 'stylesheet';
        fontLink.href = '<?php echo TEZNEVISAN_ASSETS_URL; ?>/fonts/iransans/iransans.css';
        head.appendChild(fontLink);
        
        // Apply body styles
        doc.body.style.fontFamily = 'IRANSans, Arial, sans-serif';
        doc.body.style.fontSize = '16px';
        doc.body.style.lineHeight = '1.6';
        doc.body.style.direction = 'rtl';
        doc.body.style.textAlign = 'right';
    });
    
    // Auto-save functionality
    editor.on('change keyup', function() {
        clearTimeout(editor.autoSaveTimer);
        editor.autoSaveTimer = setTimeout(function() {
            // Auto-save logic here if needed
            console.log('Content auto-saved');
        }, 3000);
    });
    
    // Enhanced paste handling
    editor.on('paste', function(e) {
        setTimeout(function() {
            // Clean up pasted content
            let content = editor.getContent();
            
            // Fix Persian characters
            content = content.replace(/ي/g, 'ی').replace(/ك/g, 'ک');
            
            // Clean MS Word artifacts
            content = content.replace(/<o:p\s*\/?>|<\/o:p>/gi, '');
            content = content.replace(/<!--[\s\S]*?-->/g, '');
            
            editor.setContent(content);
        }, 100);
    });
}

// File picker callback
function classic_editor_file_picker(callback, value, meta) {
    // Create file input
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    
    if (meta.filetype === 'image') {
        input.setAttribute('accept', 'image/*');
    } else if (meta.filetype === 'media') {
        input.setAttribute('accept', 'video/*,audio/*');
    } else {
        input.setAttribute('accept', '*/*');
    }
    
    input.onchange = function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                // For images, return the data URL directly
                if (file.type.startsWith('image/')) {
                    callback(reader.result, { alt: file.name });
                } else {
                    // For other files, you might want to upload them to server
                    // and return the URL
                    callback(reader.result, { title: file.name });
                }
            };
            reader.readAsDataURL(file);
        }
    };
    
    input.click();
}

// Upload handler for drag & drop
function classic_editor_upload_handler(blobInfo, success, failure) {
    const formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    formData.append('action', 'classic_editor_upload');
    formData.append('nonce', '<?php echo wp_create_nonce('classic_editor_upload'); ?>');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            success(result.data.url);
        } else {
            failure('خطا در آپلود فایل: ' + (result.data || 'نامعلوم'));
        }
    })
    .catch(() => {
        failure('خطا در آپلود فایل');
    });
}
            
            // Init Callback
            function classic_editor_init_callback(editor) {
                editor.on('change', function() {
                    editor.save();
                });
                
                // Ensure RTL direction
                const body = editor.getBody();
                if (body) {
                    body.style.fontFamily = 'IranSans, Arial, sans-serif';
                    body.dir = 'rtl';
                    body.style.textAlign = 'right';
                }
                
                console.log('Classic Editor initialized:', editor.id);
            }
        </script>
        
        <style>
            .classic-editor-wrapper {
                position: relative;
                margin: 1rem 0;
            }
            
            .classic-editor-wrapper .tox.tox-tinymce {
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                border: 1px solid #e1e5e9;
                font-family: IranSans, Arial, sans-serif;
            }
            
            .classic-editor-wrapper .tox .tox-toolbar__primary {
                background: #f8f9fa;
            }
            
            .classic-editor-wrapper .tox .tox-edit-area__iframe {
                border-radius: 0 0 8px 8px;
            }
            
            .classic-editor-wrapper .tox-tinymce.mce-focused {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            }
            
            .classic-editor-wrapper .tox .tox-menubar,
            .classic-editor-wrapper .tox .tox-toolbar,
            .classic-editor-wrapper .tox .tox-toolbar__overflow {
                font-family: IranSans, Arial, sans-serif;
                direction: rtl;
            }
            
            .classic-editor-wrapper .tox .tox-tbtn {
                font-family: IranSans, Arial, sans-serif;
            }
            
            .classic-editor-textarea {
                font-family: IranSans, Arial, sans-serif !important;
                direction: rtl !important;
                text-align: right !important;
                border: 1px solid #e1e5e9;
                border-radius: 8px;
                padding: 1rem;
                resize: vertical;
                line-height: 1.6;
            }
            
            .classic-editor-textarea:focus {
                outline: none;
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            }
            
            @font-face {
                font-family: 'IranSans';
                src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/IranSans.woff2') format('woff2'),
                     url('<?php echo get_template_directory_uri(); ?>/assets/fonts/IranSans.woff') format('woff');
                font-weight: normal;
                font-style: normal;
                font-display: swap;
            }
        </style>
        <?php
        return ob_get_clean();
    }
    
    private function render_attributes($attrs) {
        $output = '';
        foreach ($attrs as $key => $value) {
            if (!empty($value)) {
                $output .= sprintf('%s="%s" ', esc_attr($key), esc_attr($value));
            }
        }
        return trim($output);
    }

    private function get_fontawesome_icons() {
    return [
        'solid' => [
            'house' => 'fa-solid fa-house',
            'user' => 'fa-solid fa-user',
            'envelope' => 'fa-solid fa-envelope',
            'phone' => 'fa-solid fa-phone',
            'location-dot' => 'fa-solid fa-location-dot',
            'clock' => 'fa-solid fa-clock',
            'calendar' => 'fa-solid fa-calendar',
            'download' => 'fa-solid fa-download',
            'upload' => 'fa-solid fa-upload',
            'magnifying-glass' => 'fa-solid fa-magnifying-glass',
            'gear' => 'fa-solid fa-gear',
            'lock' => 'fa-solid fa-lock',
            'star' => 'fa-solid fa-star',
            'heart' => 'fa-solid fa-heart',
            'check' => 'fa-solid fa-check',
            'xmark' => 'fa-solid fa-xmark',
            'cart-shopping' => 'fa-solid fa-cart-shopping',
            'flag' => 'fa-solid fa-flag',
            'comment' => 'fa-solid fa-comment',
            'comments' => 'fa-solid fa-comments',
            'arrow-right' => 'fa-solid fa-arrow-right',
            'arrow-left' => 'fa-solid fa-arrow-left',
            'arrow-up' => 'fa-solid fa-arrow-up',
            'arrow-down' => 'fa-solid fa-arrow-down',
            'list' => 'fa-solid fa-list',
            'users' => 'fa-solid fa-users',
            'camera' => 'fa-solid fa-camera',
            'microphone' => 'fa-solid fa-microphone',
            'music' => 'fa-solid fa-music',
            'pen' => 'fa-solid fa-pen',
            'map' => 'fa-solid fa-map',
            'paperclip' => 'fa-solid fa-paperclip',
            'desktop' => 'fa-solid fa-desktop',
            'mobile-screen' => 'fa-solid fa-mobile-screen',
            'hand' => 'fa-solid fa-hand',
            'circle-check' => 'fa-solid fa-circle-check',
            'trash' => 'fa-solid fa-trash',
            'floppy-disk' => 'fa-solid fa-floppy-disk',
            'hourglass' => 'fa-solid fa-hourglass',
            'triangle-exclamation' => 'fa-solid fa-triangle-exclamation',
            'graduation-cap' => 'fa-solid fa-graduation-cap',
            'book' => 'fa-solid fa-book',
            'briefcase' => 'fa-solid fa-briefcase',
            'tools' => 'fa-solid fa-tools',
            'blog' => 'fa-solid fa-blog',
            'newspaper' => 'fa-solid fa-newspaper',
            'circle-info' => 'fa-solid fa-circle-info'
        ],
        'regular' => [
            'house' => 'fa-regular fa-house',
            'user' => 'fa-regular fa-user',
            'envelope' => 'fa-regular fa-envelope',
            'star' => 'fa-regular fa-star',
            'heart' => 'fa-regular fa-heart',
            'comment' => 'fa-regular fa-comment',
            'clock' => 'fa-regular fa-clock',
            'calendar' => 'fa-regular fa-calendar'
        ],
        'brands' => [
            'whatsapp' => 'fa-brands fa-whatsapp',
            'telegram' => 'fa-brands fa-telegram',
            'instagram' => 'fa-brands fa-instagram',
            'twitter' => 'fa-brands fa-twitter',
            'facebook' => 'fa-brands fa-facebook',
            'linkedin' => 'fa-brands fa-linkedin',
            'youtube' => 'fa-brands fa-youtube',
            'google' => 'fa-brands fa-google'
        ]
    ];
}
    
    public static function ajax_upload_handler() {
        check_ajax_referer('classic_editor_upload', 'nonce');
        
        if (!current_user_can('upload_files')) {
            wp_die(json_encode(['success' => false, 'message' => 'شما مجاز به آپلود فایل نیستید.']));
        }
        
        if (!isset($_FILES['file'])) {
            wp_die(json_encode(['success' => false, 'message' => 'هیچ فایلی انتخاب نشده است.']));
        }
        
        $uploaded_file = $_FILES['file'];
        $upload_overrides = ['test_form' => false];
        $movefile = wp_handle_upload($uploaded_file, $upload_overrides);
        
        if ($movefile && !isset($movefile['error'])) {
            wp_die(json_encode([
                'success' => true,
                'location' => $movefile['url'],
                'message' => 'فایل با موفقیت آپلود شد.'
            ]));
        } else {
            wp_die(json_encode([
                'success' => false,
                'message' => $movefile['error'] ?? 'خطا در آپلود فایل.'
            ]));
        }
    }
    
    public function get_content() {
        return $this->content;
    }
    
    public function set_content($content) {
        $this->content = $content;
        return $this;
    }
    
    public function update_settings($settings) {
        $this->settings = wp_parse_args($settings, $this->settings);
        return $this;
    }
}

// Initialize AJAX handlers
add_action('wp_ajax_classic_editor_upload', ['ClassicEditor', 'ajax_upload_handler']);
add_action('wp_ajax_nopriv_classic_editor_upload', ['ClassicEditor', 'ajax_upload_handler']);

/**
 * Helper function to create editor instance
 */
function create_classic_editor($id = 'classic-editor', $content = '', $settings = []) {
    return new ClassicEditor($id, $content, $settings);
}

/**
 * Helper function to render editor
 */
function render_classic_editor($id = 'classic-editor', $name = '', $value = '', $settings = [], $attrs = []) {
    $editor = new ClassicEditor($id, $value, $settings);
    return $editor->render($name, $value, $attrs);
}

/**
 * Example usage in template:
 * 
 * <?php
 * // Simple usage
 * echo render_classic_editor('my-editor', 'content_field', 'Initial content here');
 * 
 * // Advanced usage with custom settings
 * $custom_settings = [
 *     'height' => 500,
 *     'toolbar' => 'undo redo | bold italic | link image',
 *     'plugins' => 'link image lists'
 * ];
 * echo render_classic_editor('advanced-editor', 'advanced_content', '', $custom_settings);
 * 
 * // With custom attributes
 * $attrs = ['data-required' => 'true', 'placeholder' => 'متن خود را اینجا وارد کنید...'];
 * echo render_classic_editor('custom-editor', 'custom_field', '', [], $attrs);
 * ?>
 */

/**
 * WordPress Block Editor Alternative
 * For those who prefer the classic editor over Gutenberg
 */
class WP_Classic_Editor {
    
    public function __construct() {
        add_action('admin_init', [$this, 'disable_gutenberg']);
        add_filter('use_block_editor_for_post', '__return_false');
        add_filter('use_block_editor_for_post_type', '__return_false');
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }
    
    public function disable_gutenberg() {
        // Remove Gutenberg styles and scripts
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
    }
    
    public function enqueue_admin_scripts($hook) {
        if (in_array($hook, ['post.php', 'post-new.php', 'page.php', 'page-new.php'])) {
            // Custom admin styles for classic editor
            wp_add_inline_style('admin-bar', '
                .post-php .wp-editor-area,
                .post-new-php .wp-editor-area {
                    font-family: IranSans, Arial, sans-serif !important;
                    direction: rtl !important;
                }
                
                .wp-editor-container .mce-top-part::before {
                    font-family: IranSans, Arial, sans-serif !important;
                }
                
                #wp-content-editor-tools {
                    direction: rtl;
                }
                
                .wp-editor-tabs .wp-switch-editor {
                    font-family: IranSans, Arial, sans-serif;
                }
            ');
        }
    }
}

// Initialize WordPress Classic Editor support
new WP_Classic_Editor();
?>