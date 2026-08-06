/*
 * TezNevisan Icon Picker
 * Version: 2.0 - Updated for Font Awesome 7 Pro
 */

(function($) {
    'use strict';

    // Font Awesome 7 Pro Icons List
    const fontAwesomeIcons = [
        // Solid Icons (fa-solid)
        'fa-solid fa-home', 'fa-solid fa-user', 'fa-solid fa-users', 'fa-solid fa-cog', 'fa-solid fa-magnifying-glass',
        'fa-solid fa-envelope', 'fa-solid fa-phone', 'fa-solid fa-mobile-button', 'fa-solid fa-globe', 'fa-solid fa-location-dot',
        'fa-solid fa-calendar', 'fa-solid fa-clock', 'fa-solid fa-bookmark', 'fa-solid fa-star', 'fa-solid fa-heart',
        'fa-solid fa-thumbs-up', 'fa-solid fa-thumbs-down', 'fa-solid fa-comment', 'fa-solid fa-comments', 'fa-solid fa-share',
        'fa-solid fa-download', 'fa-solid fa-upload', 'fa-solid fa-file', 'fa-solid fa-folder', 'fa-solid fa-image',
        'fa-solid fa-video', 'fa-solid fa-music', 'fa-solid fa-headphones', 'fa-solid fa-microphone', 'fa-solid fa-camera',
        'fa-solid fa-print', 'fa-solid fa-floppy-disk', 'fa-solid fa-pen-to-square', 'fa-solid fa-trash', 'fa-solid fa-copy',
        'fa-solid fa-scissors', 'fa-solid fa-clipboard', 'fa-solid fa-rotate-left', 'fa-solid fa-rotate-right', 'fa-solid fa-arrows-rotate',
        'fa-solid fa-lock', 'fa-solid fa-lock-open', 'fa-solid fa-key', 'fa-solid fa-shield-halved', 'fa-solid fa-eye',
        'fa-solid fa-eye-slash', 'fa-solid fa-plus', 'fa-solid fa-minus', 'fa-solid fa-xmark', 'fa-solid fa-check', 'fa-solid fa-question',
        'fa-solid fa-exclamation', 'fa-solid fa-info', 'fa-solid fa-triangle-exclamation', 'fa-solid fa-ban', 'fa-solid fa-stop',
        'fa-solid fa-play', 'fa-solid fa-pause', 'fa-solid fa-forward', 'fa-solid fa-backward', 'fa-solid fa-step-forward',
        'fa-solid fa-step-backward', 'fa-solid fa-forward-fast', 'fa-solid fa-backward-fast', 'fa-solid fa-volume-high', 'fa-solid fa-volume-low',
        'fa-solid fa-volume-xmark', 'fa-solid fa-brightness-high', 'fa-solid fa-adjust', 'fa-solid fa-paint-brush',
        'fa-solid fa-palette', 'fa-solid fa-droplet', 'fa-solid fa-fill-drip', 'fa-solid fa-marker', 'fa-solid fa-pencil',
        'fa-solid fa-highlighter', 'fa-solid fa-eraser', 'fa-solid fa-ruler', 'fa-solid fa-compass', 'fa-solid fa-calculator',
        'fa-solid fa-abacus', 'fa-solid fa-percent', 'fa-solid fa-dollar-sign', 'fa-solid fa-euro-sign',
        'fa-solid fa-pound-sign', 'fa-solid fa-yen-sign', 'fa-solid fa-ruble-sign', 'fa-solid fa-indian-rupee-sign', 'fa-solid fa-won-sign',
        'fa-solid fa-bitcoin', 'fa-solid fa-ethereum', 'fa-solid fa-credit-card', 'fa-solid fa-wallet', 'fa-solid fa-shopping-cart',
        'fa-solid fa-bag-shopping', 'fa-solid fa-store', 'fa-solid fa-shop', 'fa-solid fa-cash-register', 'fa-solid fa-receipt',
        'fa-solid fa-tag', 'fa-solid fa-tags', 'fa-solid fa-barcode', 'fa-solid fa-qrcode', 'fa-solid fa-barcode-scan',
        'fa-solid fa-car', 'fa-solid fa-truck', 'fa-solid fa-bus', 'fa-solid fa-taxi', 'fa-solid fa-motorcycle',
        'fa-solid fa-bicycle', 'fa-solid fa-person-walking', 'fa-solid fa-person-running', 'fa-solid fa-subway', 'fa-solid fa-train',
        'fa-solid fa-plane', 'fa-solid fa-helicopter', 'fa-solid fa-ship', 'fa-solid fa-anchor', 'fa-solid fa-rocket',
        'fa-solid fa-satellite', 'fa-solid fa-space-shuttle', 'fa-solid fa-ufo', 'fa-solid fa-globe', 'fa-solid fa-moon',
        'fa-solid fa-sun', 'fa-solid fa-cloud', 'fa-solid fa-cloud-showers-heavy', 'fa-solid fa-snowflake', 'fa-solid fa-bolt',
        'fa-solid fa-wind', 'fa-solid fa-tornado', 'fa-solid fa-hurricane', 'fa-solid fa-temperature-high', 'fa-solid fa-temperature-low',
        'fa-solid fa-thermometer', 'fa-solid fa-fire', 'fa-solid fa-blender', 'fa-solid fa-leaf', 'fa-solid fa-tree',
        'fa-solid fa-mountain', 'fa-solid fa-volcano', 'fa-solid fa-island-tropical', 'fa-solid fa-beach', 'fa-solid fa-water',
        'fa-solid fa-fish', 'fa-solid fa-whale', 'fa-solid fa-dolphin', 'fa-solid fa-turtle', 'fa-solid fa-dove',
        'fa-solid fa-eagle', 'fa-solid fa-owl', 'fa-solid fa-cat', 'fa-solid fa-dog', 'fa-solid fa-horse',
        'fa-solid fa-cow', 'fa-solid fa-pig', 'fa-solid fa-sheep', 'fa-solid fa-rabbit', 'fa-solid fa-mouse',
        'fa-solid fa-elephant', 'fa-solid fa-lion', 'fa-solid fa-tiger', 'fa-solid fa-bear', 'fa-solid fa-paw',
        'fa-solid fa-bone', 'fa-solid fa-spider', 'fa-solid fa-bug', 'fa-solid fa-butterfly', 'fa-solid fa-bee',
        'fa-solid fa-ladybug', 'fa-solid fa-ant',

        // Regular Icons (fa-regular)
        'fa-regular fa-user', 'fa-regular fa-envelope', 'fa-regular fa-file', 'fa-regular fa-folder', 'fa-regular fa-bookmark',
        'fa-regular fa-star', 'fa-regular fa-heart', 'fa-regular fa-thumbs-up', 'fa-regular fa-thumbs-down', 'fa-regular fa-comment',
        'fa-regular fa-comments', 'fa-regular fa-calendar', 'fa-regular fa-clock', 'fa-regular fa-image', 'fa-regular fa-images',
        'fa-regular fa-eye', 'fa-regular fa-eye-slash', 'fa-regular fa-lightbulb', 'fa-regular fa-bell', 'fa-regular fa-flag',
        'fa-regular fa-copy', 'fa-regular fa-save', 'fa-regular fa-edit', 'fa-regular fa-trash', 'fa-regular fa-check-circle',
        'fa-regular fa-times-circle', 'fa-regular fa-question-circle', 'fa-regular fa-exclamation-circle',
        'fa-regular fa-info-circle', 'fa-regular fa-plus-circle', 'fa-regular fa-minus-circle', 'fa-regular fa-play-circle',
        'fa-regular fa-pause-circle', 'fa-regular fa-stop-circle', 'fa-regular fa-arrow-alt-circle-up', 'fa-regular fa-arrow-alt-circle-down',
        'fa-regular fa-arrow-alt-circle-left', 'fa-regular fa-arrow-alt-circle-right', 'fa-regular fa-dot-circle',
        'fa-regular fa-circle', 'fa-regular fa-square', 'fa-regular fa-hand-pointer', 'fa-regular fa-hand-peace', 'fa-regular fa-handshake',

        // Light Icons (fa-light)
        'fa-light fa-house', 'fa-light fa-user', 'fa-light fa-cog', 'fa-light fa-magnifying-glass', 'fa-light fa-envelope',
        'fa-light fa-phone', 'fa-light fa-globe', 'fa-light fa-star', 'fa-light fa-heart', 'fa-light fa-comment',
        'fa-light fa-share', 'fa-light fa-download', 'fa-light fa-upload', 'fa-light fa-file', 'fa-light fa-folder',
        'fa-light fa-image', 'fa-light fa-video', 'fa-light fa-music', 'fa-light fa-camera', 'fa-light fa-pen-to-square',
        'fa-light fa-trash', 'fa-light fa-plus', 'fa-light fa-minus', 'fa-light fa-xmark', 'fa-light fa-check',
        'fa-light fa-lock', 'fa-light fa-lock-open', 'fa-light fa-eye', 'fa-light fa-eye-slash', 'fa-light fa-calendar',
        'fa-light fa-clock', 'fa-light fa-bookmark', 'fa-light fa-flag', 'fa-light fa-bell', 'fa-light fa-lightbulb',

        // Brand Icons (fa-brands)
        'fa-brands fa-telegram', 'fa-brands fa-whatsapp', 'fa-brands fa-instagram', 'fa-brands fa-twitter', 'fa-brands fa-facebook',
        'fa-brands fa-youtube', 'fa-brands fa-linkedin', 'fa-brands fa-github', 'fa-brands fa-gitlab', 'fa-brands fa-bitbucket',
        'fa-brands fa-google', 'fa-brands fa-microsoft', 'fa-brands fa-apple', 'fa-brands fa-android', 'fa-brands fa-windows',
        'fa-brands fa-linux', 'fa-brands fa-ubuntu', 'fa-brands fa-chrome', 'fa-brands fa-firefox', 'fa-brands fa-safari',
        'fa-brands fa-edge', 'fa-brands fa-opera', 'fa-brands fa-skype', 'fa-brands fa-slack', 'fa-brands fa-discord',
        'fa-brands fa-teamspeak', 'fa-brands fa-zoom', 'fa-brands fa-dropbox', 'fa-brands fa-google-drive', 'fa-brands fa-onedrive',
        'fa-brands fa-icloud', 'fa-brands fa-amazon', 'fa-brands fa-paypal', 'fa-brands fa-stripe', 'fa-brands fa-bitcoin',
        'fa-brands fa-ethereum', 'fa-brands fa-visa', 'fa-brands fa-mastercard', 'fa-brands fa-amex', 'fa-brands fa-discover'
    ];

    // Initialize icon picker
    function initIconPicker() {
        // Create icon picker HTML if it doesn't exist
        if ($('.teznevisan-icon-picker').length === 0) {
            createIconPickerHTML();
        }

        // Add icon picker to menu items
        if ($('body').hasClass('nav-menus-php')) {
            initMenuIconPicker();
        }

        // Add icon picker to meta boxes
        initMetaBoxIconPicker();
    }

    function createIconPickerHTML() {
        const iconPickerHTML = `
            <div class="teznevisan-icon-picker" style="display: none;">
                <div class="icon-picker-header">
                    <h3>انتخاب آیکون Font Awesome</h3>
                    <button type="button" class="icon-picker-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="icon-picker-search">
                    <input type="text" 
                           class="icon-search-input" 
                           placeholder="جستجو آیکون... (مثال: home, user, email)"
                           autocomplete="off">
                    <div class="icon-search-suggestions"></div>
                </div>
                
                <div class="icon-picker-categories">
                    <button type="button" class="icon-category active" data-category="all">همه</button>
                    <button type="button" class="icon-category" data-category="solid">Solid</button>
                    <button type="button" class="icon-category" data-category="regular">Regular</button>
                    <button type="button" class="icon-category" data-category="light">Light</button>
                    <button type="button" class="icon-category" data-category="brands">Brands</button>
                    <button type="button" class="icon-category" data-category="academic">آکادمیک</button>
                    <button type="button" class="icon-category" data-category="persian">ایرانی</button>
                </div>
                
                <div class="icon-picker-grid" id="iconPickerGrid">
                    <!-- Icons will be loaded here -->
                </div>
                
                <div class="icon-picker-footer">
                    <div class="selected-icon-info">
                        <span class="selected-icon-preview"></span>
                        <span class="selected-icon-name"></span>
                    </div>
                    <div class="icon-picker-actions">
                        <button type="button" class="button button-secondary icon-picker-cancel">لغو</button>
                        <button type="button" class="button button-primary icon-picker-select" disabled>انتخاب</button>
                    </div>
                </div>
            </div>
            
            <div class="teznevisan-icon-picker-overlay" style="display: none;"></div>
        `;

        $('body').append(iconPickerHTML);
        loadIconsToGrid();
        bindIconPickerEvents();
    }

    function loadIconsToGrid(category = 'all', searchTerm = '') {
        const $grid = $('#iconPickerGrid');
        $grid.empty();

        let filteredIcons = fontAwesomeIcons;

        // Filter by category
        if (category !== 'all') {
            filteredIcons = fontAwesomeIcons.filter(icon => {
                switch (category) {
                    case 'solid':
                        return icon.startsWith('fas ');
                    case 'regular':
                        return icon.startsWith('far ');
                    case 'light':
                        return icon.startsWith('fal ');
                    case 'brands':
                        return icon.startsWith('fab ');
                    case 'academic':
                        return icon.includes('graduation') || icon.includes('book') || 
                               icon.includes('university') || icon.includes('school') ||
                               icon.includes('education') || icon.includes('learn');
                    case 'persian':
                        return icon.includes('mosque') || icon.includes('persian') ||
                               icon.includes('tea') || icon.includes('crescent') ||
                               icon.includes('prayer') || icon.includes('quran');
                    default:
                        return true;
                }
            });
        }

        // Filter by search term
        if (searchTerm) {
            const searchLower = searchTerm.toLowerCase();
            filteredIcons = filteredIcons.filter(icon => 
                icon.toLowerCase().includes(searchLower)
            );
        }

        // Create icon elements
        filteredIcons.forEach(icon => {
            const $iconEl = $(`
                <div class="icon-picker-item" data-icon="${icon}" title="${icon}">
                    <i class="${icon}"></i>
                    <span class="icon-name">${icon.replace(/^fa[slrb] fa-/, '')}</span>
                </div>
            `);
            $grid.append($iconEl);
        });

        // Show message if no icons found
        if (filteredIcons.length === 0) {
            $grid.html('<div class="no-icons-found">آیکونی یافت نشد</div>');
        }
    }

    function bindIconPickerEvents() {
        const $picker = $('.teznevisan-icon-picker');
        const $overlay = $('.teznevisan-icon-picker-overlay');

        // Close picker
        $('.icon-picker-close, .icon-picker-cancel').on('click', closeIconPicker);
        $overlay.on('click', closeIconPicker);

        // Category filtering
        $('.icon-category').on('click', function() {
            const category = $(this).data('category');
            $('.icon-category').removeClass('active');
            $(this).addClass('active');
            
            const searchTerm = $('.icon-search-input').val();
            loadIconsToGrid(category, searchTerm);
        });

        // Search functionality
        let searchTimeout;
        $('.icon-search-input').on('input', function() {
            const searchTerm = $(this).val();
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const activeCategory = $('.icon-category.active').data('category');
                loadIconsToGrid(activeCategory, searchTerm);
                
                // Show search suggestions
                showSearchSuggestions(searchTerm);
            }, 300);
        });

        // Icon selection
        $(document).on('click', '.icon-picker-item', function() {
            $('.icon-picker-item').removeClass('selected');
            $(this).addClass('selected');
            
            const icon = $(this).data('icon');
            $('.selected-icon-preview').html(`<i class="${icon}"></i>`);
            $('.selected-icon-name').text(icon);
            $('.icon-picker-select').prop('disabled', false);
        });

        // Confirm selection
        $('.icon-picker-select').on('click', function() {
            const selectedIcon = $('.icon-picker-item.selected').data('icon');
            if (selectedIcon) {
                selectIcon(selectedIcon);
                closeIconPicker();
            }
        });

        // Keyboard navigation
        $picker.on('keydown', function(e) {
            switch (e.key) {
                case 'Escape':
                    closeIconPicker();
                    break;
                case 'Enter':
                    if (!$('.icon-picker-select').prop('disabled')) {
                        $('.icon-picker-select').click();
                    }
                    break;
                case 'ArrowUp':
                case 'ArrowDown':
                case 'ArrowLeft':
                case 'ArrowRight':
                    navigateIcons(e.key);
                    e.preventDefault();
                    break;
            }
        });
    }

    function showSearchSuggestions(searchTerm) {
        if (!searchTerm || searchTerm.length < 2) {
            $('.icon-search-suggestions').empty().hide();
            return;
        }

        const suggestions = [
            'home خانه', 'user کاربر', 'email ایمیل', 'phone تلفن', 'search جستجو',
            'book کتاب', 'graduation-cap فارغ‌التحصیلی', 'university دانشگاه', 'school مدرسه',
            'star ستاره', 'heart قلب', 'comment نظر', 'share اشتراک', 'download دانلود',
            'upload آپلود', 'file فایل', 'folder پوشه', 'image تصویر', 'video ویدیو',
            'music موزیک', 'camera دوربین', 'edit ویرایش', 'trash حذف', 'save ذخیره',
            'lock قفل', 'unlock باز کردن قفل', 'eye چشم', 'calendar تقویم', 'clock ساعت'
        ];

        const matchingSuggestions = suggestions.filter(suggestion => 
            suggestion.toLowerCase().includes(searchTerm.toLowerCase())
        );

        if (matchingSuggestions.length > 0) {
            const suggestionHTML = matchingSuggestions.slice(0, 5).map(suggestion => {
                const [english, persian] = suggestion.split(' ');
                return `<div class="suggestion-item" data-icon="${english}">${english} - ${persian || ''}</div>`;
            }).join('');

            $('.icon-search-suggestions').html(suggestionHTML).show();
        } else {
            $('.icon-search-suggestions').empty().hide();
        }
    }

    // Suggestion click handler
    $(document).on('click', '.suggestion-item', function() {
        const iconName = $(this).data('icon');
        $('.icon-search-input').val('fa-' + iconName);
        $('.icon-search-suggestions').hide();
        
        const activeCategory = $('.icon-category.active').data('category');
        loadIconsToGrid(activeCategory, 'fa-' + iconName);
    });

    function navigateIcons(key) {
        const $items = $('.icon-picker-item:visible');
        const $selected = $('.icon-picker-item.selected');
        
        if ($items.length === 0) return;
        
        let currentIndex = $selected.length ? $items.index($selected) : -1;
        let newIndex = currentIndex;
        
        const itemsPerRow = Math.floor($('#iconPickerGrid').width() / 80); // Approximate items per row
        
        switch (key) {
            case 'ArrowUp':
                newIndex = Math.max(0, currentIndex - itemsPerRow);
                break;
            case 'ArrowDown':
                newIndex = Math.min($items.length - 1, currentIndex + itemsPerRow);
                break;
            case 'ArrowLeft':
                newIndex = Math.max(0, currentIndex - 1);
                break;
            case 'ArrowRight':
                newIndex = Math.min($items.length - 1, currentIndex + 1);
                break;
        }
        
        if (newIndex !== currentIndex && newIndex >= 0) {
            $items.removeClass('selected');
            $items.eq(newIndex).addClass('selected').click();
            
            // Scroll to selected item
            const $newSelected = $items.eq(newIndex);
            const gridTop = $('#iconPickerGrid').scrollTop();
            const gridHeight = $('#iconPickerGrid').height();
            const itemTop = $newSelected.position().top;
            
            if (itemTop < 0 || itemTop > gridHeight - 80) {
                $('#iconPickerGrid').scrollTop(gridTop + itemTop - gridHeight / 2);
            }
        }
    }

    let currentTarget = null;

    function openIconPicker($trigger) {
        currentTarget = $trigger;
        $('.teznevisan-icon-picker, .teznevisan-icon-picker-overlay').show();
        
        // Reset picker state
        $('.icon-category').removeClass('active').first().addClass('active');
        $('.icon-search-input').val('').focus();
        $('.selected-icon-preview, .selected-icon-name').empty();
        $('.icon-picker-select').prop('disabled', true);
        $('.icon-picker-item').removeClass('selected');
        
        loadIconsToGrid();
        
        // Pre-select current icon if exists
        const currentIcon = $trigger.data('selected-icon');
        if (currentIcon) {
            setTimeout(() => {
                const $currentItem = $(`.icon-picker-item[data-icon="${currentIcon}"]`);
                if ($currentItem.length) {
                    $currentItem.click();
                    $currentItem[0].scrollIntoView({ block: 'center' });
                }
            }, 100);
        }
    }

    function closeIconPicker() {
        $('.teznevisan-icon-picker, .teznevisan-icon-picker-overlay').hide();
        currentTarget = null;
    }

    function selectIcon(iconClass) {
        if (currentTarget) {
            const $preview = currentTarget.find('.icon-preview');
            const $hiddenInput = currentTarget.find('input[type="hidden"]');
            const $selectElement = currentTarget.find('select');
            
            // Update preview
            $preview.html(`<i class="${iconClass}"></i>`);
            
            // Update value
            if ($hiddenInput.length) {
                $hiddenInput.val(iconClass);
            } else if ($selectElement.length) {
                $selectElement.val(iconClass);
            }
            
            // Store selected icon
            currentTarget.data('selected-icon', iconClass);
            
            // Trigger change event
            currentTarget.trigger('iconSelected', [iconClass]);
        }
    }

    // Menu icon picker integration
    function initMenuIconPicker() {
        // Add icon picker button to menu items
        $(document).on('menu-item-added', function(e, $menuItem) {
            addIconPickerToMenuItem($menuItem);
        });

        // Add to existing menu items
        $('.menu-item').each(function() {
            addIconPickerToMenuItem($(this));
        });
    }

    function addIconPickerToMenuItem($menuItem) {
        const $iconField = $menuItem.find('.field-icon');
        if ($iconField.length && !$iconField.hasClass('enhanced')) {
            $iconField.addClass('enhanced');
            
            const $select = $iconField.find('select');
            const currentValue = $select.val();
            
            const iconPickerHTML = `
                <div class="menu-icon-picker-wrapper">
                    <div class="icon-preview">${currentValue ? `<i class="${currentValue}"></i>` : '<i class="fas fa-icons"></i>'}</div>
                    <button type="button" class="button icon-picker-btn">انتخاب آیکون</button>
                    <input type="hidden" name="${$select.attr('name')}" value="${currentValue}">
                </div>
            `;
            
            $iconField.find('label').after(iconPickerHTML);
            $select.hide();
            
            // Bind click event
            $iconField.find('.icon-picker-btn').on('click', function(e) {
                e.preventDefault();
                openIconPicker($(this).closest('.menu-icon-picker-wrapper'));
            });
        }
    }

    // Meta box icon picker
    function initMetaBoxIconPicker() {
        $('.meta-icon-picker').each(function() {
            const $wrapper = $(this);
            const $input = $wrapper.find('input[type="text"]');
            const currentValue = $input.val();
            
            const iconPickerHTML = `
                <div class="meta-icon-picker-wrapper">
                    <div class="icon-preview">${currentValue ? `<i class="${currentValue}"></i>` : '<i class="fas fa-icons"></i>'}</div>
                    <button type="button" class="button icon-picker-btn">انتخاب آیکون</button>
                </div>
            `;
            
            $wrapper.append(iconPickerHTML);
            
            // Bind events
            $wrapper.find('.icon-picker-btn').on('click', function(e) {
                e.preventDefault();
                const $pickerWrapper = $(this).closest('.meta-icon-picker-wrapper');
                $pickerWrapper.data('input', $input);
                openIconPicker($pickerWrapper);
            });
            
            // Handle icon selection
            $wrapper.on('iconSelected', function(e, iconClass) {
                $input.val(iconClass).trigger('change');
            });
        });
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        initIconPicker();
    });

    // Export for global access
    window.TeznevisanIconPicker = {
        open: openIconPicker,
        close: closeIconPicker,
        icons: fontAwesomeIcons
    };

})(jQuery);

// CSS for icon picker (injected)
const iconPickerCSS = `
.teznevisan-icon-picker {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90vw;
    max-width: 800px;
    height: 80vh;
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    z-index: 999999;
    display: flex;
    flex-direction: column;
    font-family: 'IRANSans', sans-serif;
    direction: rtl;
}

.teznevisan-icon-picker-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999998;
    backdrop-filter: blur(5px);
}

.icon-picker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #1fa547, #4caf50);
    color: white;
    border-radius: 12px 12px 0 0;
}

.icon-picker-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.icon-picker-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-picker-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.icon-picker-search {
    padding: 1.5rem 2rem 1rem;
    border-bottom: 1px solid #f1f3f4;
    position: relative;
}

.icon-search-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-family: inherit;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.icon-search-input:focus {
    outline: none;
    border-color: #1fa547;
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.icon-search-suggestions {
    position: absolute;
    top: 100%;
    left: 2rem;
    right: 2rem;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 10;
    max-height: 200px;
    overflow-y: auto;
}

.suggestion-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f1f3f4;
    transition: background-color 0.3s ease;
}

.suggestion-item:hover {
    background: #f8f9fa;
}

.suggestion-item:last-child {
    border-bottom: none;
}

.icon-picker-categories {
    display: flex;
    padding: 1rem 2rem;
    gap: 0.5rem;
    border-bottom: 1px solid #f1f3f4;
    overflow-x: auto;
}

.icon-category {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #495057;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.3s ease;
    font-family: inherit;
    font-size: 0.9rem;
}

.icon-category:hover {
    background: #e9ecef;
}

.icon-category.active {
    background: #1fa547;
    color: white;
    border-color: #1fa547;
}

.icon-picker-grid {
    flex: 1;
    padding: 1.5rem 2rem;
    overflow-y: auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 1rem;
    max-height: 400px;
}

.icon-picker-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem 0.5rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    text-align: center;
    min-height: 80px;
}

.icon-picker-item:hover {
    border-color: #1fa547;
    background: rgba(31, 165, 71, 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(31, 165, 71, 0.2);
}

.icon-picker-item.selected {
    border-color: #1fa547;
    background: #1fa547;
    color: white;
    transform: scale(1.05);
}

.icon-picker-item i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.icon-name {
    font-size: 0.7rem;
    text-align: center;
    word-break: break-all;
    line-height: 1.2;
}

.no-icons-found {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #6c757d;
    font-size: 1.1rem;
}

.icon-picker-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
    border-radius: 0 0 12px 12px;
}

.selected-icon-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.selected-icon-preview {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

.selected-icon-preview i {
    font-size: 1.5rem;
    color: #1fa547;
}

.selected-icon-name {
    font-weight: 600;
    color: #495057;
}

.icon-picker-actions {
    display: flex;
    gap: 1rem;
}

.icon-picker-actions .button {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.icon-picker-cancel {
    background: #6c757d;
    color: white;
    border: none;
}

.icon-picker-cancel:hover {
    background: #5a6268;
}

.icon-picker-select {
    background: #1fa547;
    color: white;
    border: none;
}

.icon-picker-select:hover:not(:disabled) {
    background: #1e7e34;
}

.icon-picker-select:disabled {
    background: #ced4da;
    cursor: not-allowed;
}

/* Menu item icon picker */
.menu-icon-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.5rem;
}

.menu-icon-picker-wrapper .icon-preview {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    color: #1fa547;
}

.menu-icon-picker-wrapper .icon-picker-btn {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

/* Meta box icon picker */
.meta-icon-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.meta-icon-picker-wrapper .icon-preview {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    color: #1fa547;
    font-size: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .teznevisan-icon-picker {
        width: 95vw;
        height: 85vh;
    }
    
    .icon-picker-header,
    .icon-picker-search,
    .icon-picker-categories,
    .icon-picker-grid,
    .icon-picker-footer {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .icon-picker-grid {
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        gap: 0.5rem;
    }
    
    .icon-picker-item {
        min-height: 60px;
        padding: 0.5rem 0.25rem;
    }
    
    .icon-picker-item i {
        font-size: 1.2rem;
        margin-bottom: 0.25rem;
    }
    
    .icon-name {
        font-size: 0.6rem;
    }
    
    .icon-picker-footer {
        flex-direction: column;
        gap: 1rem;
    }
    
    .icon-picker-actions {
        width: 100%;
        justify-content: stretch;
    }
    
    .icon-picker-actions .button {
        flex: 1;
    }
}

/* Scrollbar styling for icon grid */
.icon-picker-grid::-webkit-scrollbar {
    width: 8px;
}

.icon-picker-grid::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.icon-picker-grid::-webkit-scrollbar-thumb {
    background: #1fa547;
    border-radius: 4px;
}

.icon-picker-grid::-webkit-scrollbar-thumb:hover {
    background: #1e7e34;
}
`;

// Inject CSS
const styleSheet = document.createElement('style');
styleSheet.textContent = iconPickerCSS;
document.head.appendChild(styleSheet);