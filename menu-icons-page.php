<?php
/**
 * Menu Icons Admin Page
 * Teznevisan Theme - Visual Icon Management
 */

if (!defined("ABSPATH") || !current_user_can("manage_options")) {
    exit;
}

$menu_icons = get_option("teznevisan_menu_icons", array());
if (!is_array($menu_icons)) {
    $menu_icons = array();
}

// Get current menu items
$menu_locations = get_nav_menu_locations();
$menu_items = array();

if (isset($menu_locations["primary"])) {
    $menu_object = wp_get_nav_menu_object($menu_locations["primary"]);
    if ($menu_object) {
        $menu_items = wp_get_nav_menu_items($menu_object->term_id);
    }
}
?>

<div class="wrap teznevisan-menu-icons">
    <h1 class="wp-heading-inline">
        <i class="fas fa-icons"></i> 
        مدیریت آیکون‌های منو
    </h1>
    
    <p class="description">
        از این صفحه می‌توانید برای آیتم‌های منوی اصلی خود آیکون انتخاب کنید. آیکون‌ها به صورت خودکار در منو نمایش داده می‌شوند.
    </p>

    <div class="icon-management-container">
        <!-- Current Menu Items -->
        <div class="current-menu-section">
            <h2><i class="fas fa-list"></i> آیتم‌های منوی فعلی</h2>
            
            <?php if ($menu_items): ?>
                <form id="menu-icons-form" method="post">
                    <div class="menu-items-grid">
                        <?php foreach ($menu_items as $index => $item): 
                            $current_icon = "";
                            foreach ($menu_icons as $saved_icon) {
                                if (strpos($item->url, $saved_icon["url"]) !== false) {
                                    $current_icon = $saved_icon["icon"];
                                    break;
                                }
                            }
                        ?>
                            <div class="menu-item-card" data-item-id="<?php echo $item->ID; ?>">
                                <div class="menu-item-header">
                                    <h3><?php echo esc_html($item->title); ?></h3>
                                    <span class="menu-url"><?php echo esc_html($item->url); ?></span>
                                </div>
                                
                                <div class="icon-selection-area">
                                    <label>آیکون انتخابی:</label>
                                    <div class="current-icon-display">
                                        <span class="icon-preview" id="preview-<?php echo $item->ID; ?>">
                                            <?php if ($current_icon): ?>
                                                <i class="<?php echo esc_attr($current_icon); ?>"></i>
                                            <?php else: ?>
                                                <i class="fas fa-circle"></i>
                                            <?php endif; ?>
                                        </span>
                                        <input type="text" 
                                               name="menu_items[<?php echo $item->ID; ?>][icon]" 
                                               value="<?php echo esc_attr($current_icon); ?>" 
                                               class="icon-input" 
                                               placeholder="fas fa-home"
                                               data-target="preview-<?php echo $item->ID; ?>">
                                    </div>
                                    
                                    <button type="button" class="button icon-picker-btn" data-target="<?php echo $item->ID; ?>">
                                        <i class="fas fa-palette"></i> انتخاب آیکون
                                    </button>
                                </div>
                                
                                <input type="hidden" name="menu_items[<?php echo $item->ID; ?>][title]" value="<?php echo esc_attr($item->title); ?>">
                                <input type="hidden" name="menu_items[<?php echo $item->ID; ?>][url]" value="<?php echo esc_attr($item->url); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="submit-section">
                        <button type="submit" class="button button-primary button-large">
                            <i class="fas fa-save"></i> ذخیره آیکون‌های منو
                        </button>
                        
                        <button type="button" id="clear-all-icons" class="button button-secondary">
                            <i class="fas fa-trash"></i> پاک کردن همه آیکون‌ها
                        </button>
                    </div>
                    
                    <?php wp_nonce_field("teznevisan_menu_nonce", "nonce"); ?>
                </form>
            <?php else: ?>
                <div class="no-menu-notice">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>منویی تعریف نشده است</h3>
                    <p>ابتدا یک منو ایجاد کنید و آن را به موقعیت "منوی اصلی" اختصاص دهید.</p>
                    <a href="<?php echo admin_url("nav-menus.php"); ?>" class="button button-primary">
                        <i class="fas fa-plus"></i> ایجاد منو
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Icon Picker Modal -->
        <div id="icon-picker-modal" class="icon-picker-modal">
            <div class="icon-picker-content">
                <div class="icon-picker-header">
                    <h2><i class="fas fa-icons"></i> انتخاب آیکون Font Awesome</h2>
                    <button type="button" class="icon-picker-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="icon-search-container">
                    <input type="text" id="icon-search" placeholder="جستجو آیکون..." class="icon-search-input">
                    <i class="fas fa-search icon-search-icon"></i>
                </div>
                
                <div class="icon-categories">
                    <button type="button" class="icon-category-btn active" data-category="all">
                        <i class="fas fa-th"></i> همه
                    </button>
                    <button type="button" class="icon-category-btn" data-category="solid">
                        <i class="fas fa-star"></i> Solid
                    </button>
                    <button type="button" class="icon-category-btn" data-category="brands">
                        <i class="fab fa-font-awesome"></i> Brands
                    </button>
                </div>
                
                <div class="icon-picker-grid" id="icon-picker-grid">
                    <!-- Icons will be populated by JavaScript -->
                </div>
                
                <div class="icon-picker-footer">
                    <button type="button" class="button button-secondary icon-picker-cancel">
                        <i class="fas fa-times"></i> انصراف
                    </button>
                    <button type="button" class="button button-primary icon-picker-select" disabled>
                        <i class="fas fa-check"></i> انتخاب آیکون
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.teznevisan-menu-icons {
    font-family: "IRANSans", sans-serif;
    direction: rtl;
}

.icon-management-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.current-menu-section {
    padding: 20px;
}

.current-menu-section h2 {
    margin-bottom: 20px;
    color: #1FA547;
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu-items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.menu-item-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    transition: all 0.3s ease;
}

.menu-item-card:hover {
    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.1);
    transform: translateY(-2px);
}

.menu-item-header h3 {
    margin: 0 0 5px 0;
    color: #333;
    font-size: 1.1rem;
}

.menu-url {
    font-size: 0.85rem;
    color: #666;
    word-break: break-all;
}

.icon-selection-area {
    margin-top: 15px;
}

.icon-selection-area label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.current-icon-display {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.icon-preview {
    width: 40px;
    height: 40px;
    background: #1FA547;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.icon-input {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
    direction: rtl;
}

.icon-picker-btn {
    width: 100%;
    margin-top: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.submit-section {
    background: #f1f1f1;
    padding: 20px;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 15px;
    justify-content: flex-start;
}

.submit-section .button {
    display: flex;
    align-items: center;
    gap: 8px;
}

.no-menu-notice {
    text-align: center;
    padding: 40px;
    color: #666;
}

.no-menu-notice i {
    font-size: 3rem;
    color: #ffc107;
    margin-bottom: 15px;
    display: block;
}

/* Icon Picker Modal */
.icon-picker-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 100000;
}

.icon-picker-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 800px;
    max-height: 80%;
    display: flex;
    flex-direction: column;
}

.icon-picker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.icon-picker-header h2 {
    margin: 0;
    color: #1FA547;
    display: flex;
    align-items: center;
    gap: 10px;
}

.icon-picker-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #666;
    cursor: pointer;
    padding: 5px;
}

.icon-search-container {
    position: relative;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.icon-search-input {
    width: 100%;
    padding: 12px 40px 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
    direction: rtl;
}

.icon-search-icon {
    position: absolute;
    right: 35px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.icon-categories {
    display: flex;
    gap: 10px;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
}

.icon-category-btn {
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 8px 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.icon-category-btn:hover,
.icon-category-btn.active {
    background: #1FA547;
    color: white;
    border-color: #1FA547;
}

.icon-picker-grid {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 8px;
    max-height: 400px;
}

.icon-grid-item {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    color: #333;
}

.icon-grid-item:hover {
    background: #e9ecef;
    transform: scale(1.05);
}

.icon-grid-item.selected {
    background: #1FA547;
    color: white;
    border-color: #178A3A;
    transform: scale(1.1);
}

.icon-picker-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-top: 1px solid #e9ecef;
    gap: 15px;
}

.icon-picker-footer .button {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 120px;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .menu-items-grid {
        grid-template-columns: 1fr;
    }
    
    .icon-picker-content {
        width: 95%;
        height: 90%;
    }
    
    .icon-picker-grid {
        grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
    }
    
    .icon-grid-item {
        width: 50px;
        height: 50px;
        font-size: 1rem;
    }
    
    .submit-section {
        flex-direction: column;
    }
    
    .icon-categories {
        flex-wrap: wrap;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    let selectedIcon = "";
    let targetItemId = "";
    
    // FontAwesome Icons Database
    const fontAwesomeIcons = {
        solid: [
            "fas fa-home", "fas fa-tools", "fas fa-info-circle", "fas fa-phone", "fas fa-envelope",
            "fas fa-user", "fas fa-cog", "fas fa-star", "fas fa-heart", "fas fa-search",
            "fas fa-shopping-cart", "fas fa-book", "fas fa-graduation-cap", "fas fa-pen",
            "fas fa-file-alt", "fas fa-clipboard", "fas fa-chart-bar", "fas fa-trophy",
            "fas fa-lightbulb", "fas fa-check", "fas fa-times", "fas fa-edit", "fas fa-trash",
            "fas fa-download", "fas fa-upload", "fas fa-print", "fas fa-share", "fas fa-link",
            "fas fa-tag", "fas fa-bookmark", "fas fa-calendar", "fas fa-clock", "fas fa-bell",
            "fas fa-comment", "fas fa-comments", "fas fa-thumbs-up", "fas fa-thumbs-down",
            "fas fa-fire", "fas fa-bolt", "fas fa-magic", "fas fa-shield-alt", "fas fa-lock",
            "fas fa-unlock", "fas fa-key", "fas fa-wrench", "fas fa-hammer", "fas fa-screwdriver",
            "fas fa-paint-brush", "fas fa-palette", "fas fa-camera", "fas fa-video",
            "fas fa-music", "fas fa-headphones", "fas fa-microphone", "fas fa-volume-up",
            "fas fa-play", "fas fa-pause", "fas fa-stop", "fas fa-forward", "fas fa-backward",
            "fas fa-step-forward", "fas fa-step-backward", "fas fa-eject", "fas fa-random",
            "fas fa-repeat", "fas fa-list", "fas fa-th", "fas fa-th-list", "fas fa-table",
            "fas fa-columns", "fas fa-sort", "fas fa-sort-up", "fas fa-sort-down"
        ],
        brands: [
            "fab fa-facebook", "fab fa-twitter", "fab fa-instagram", "fab fa-youtube",
            "fab fa-linkedin", "fab fa-github", "fab fa-telegram", "fab fa-whatsapp",
            "fab fa-apple", "fab fa-google", "fab fa-microsoft", "fab fa-amazon",
            "fab fa-adobe", "fab fa-android", "fab fa-css3", "fab fa-html5",
            "fab fa-js", "fab fa-react", "fab fa-vue", "fab fa-angular",
            "fab fa-wordpress", "fab fa-drupal", "fab fa-joomla", "fab fa-shopify"
        ]
    };
    
    // Populate icon grid
    function populateIconGrid(category = "all") {
        const grid = $("#icon-picker-grid");
        grid.empty();
        
        let iconsToShow = [];
        
        if (category === "all") {
            iconsToShow = [...fontAwesomeIcons.solid, ...fontAwesomeIcons.brands];
        } else {
            iconsToShow = fontAwesomeIcons[category] || [];
        }
        
        iconsToShow.forEach(function(iconClass) {
            const iconItem = $(`
                <div class="icon-grid-item" data-icon="${iconClass}" title="${iconClass}">
                    <i class="${iconClass}"></i>
                </div>
            `);
            
            iconItem.on("click", function() {
                $(".icon-grid-item").removeClass("selected");
                $(this).addClass("selected");
                selectedIcon = $(this).data("icon");
                $(".icon-picker-select").prop("disabled", false);
            });
            
            grid.append(iconItem);
        });
    }
    
    // Initialize icon grid
    populateIconGrid();
    
    // Icon picker button click
    $(".icon-picker-btn").on("click", function() {
        targetItemId = $(this).data("target");
        selectedIcon = "";
        $(".icon-grid-item").removeClass("selected");
        $(".icon-picker-select").prop("disabled", true);
        $("#icon-picker-modal").show();
    });
    
    // Close modal
    $(".icon-picker-close, .icon-picker-cancel").on("click", function() {
        $("#icon-picker-modal").hide();
    });
    
    // Category filter
    $(".icon-category-btn").on("click", function() {
        $(".icon-category-btn").removeClass("active");
        $(this).addClass("active");
        const category = $(this).data("category");
        populateIconGrid(category);
    });
    
    // Icon search
    $("#icon-search").on("input", function() {
        const searchTerm = $(this).val().toLowerCase();
        $(".icon-grid-item").each(function() {
            const iconClass = $(this).data("icon").toLowerCase();
            if (iconClass.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Select icon
    $(".icon-picker-select").on("click", function() {
        if (selectedIcon && targetItemId) {
            $(`input[name="menu_items[${targetItemId}][icon]"]`).val(selectedIcon);
            $(`#preview-${targetItemId}`).html(`<i class="${selectedIcon}"></i>`);
            $("#icon-picker-modal").hide();
        }
    });
    
    // Input change handler
    $(".icon-input").on("input", function() {
        const iconClass = $(this).val();
        const targetId = $(this).data("target");
        $(`#${targetId}`).html(`<i class="${iconClass}"></i>`);
    });
    
    // Form submission
    $("#menu-icons-form").on("submit", function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append("action", "save_menu_icons");
        
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert("آیکون‌های منو با موفقیت ذخیره شد!");
                    location.reload();
                } else {
                    alert("خطا در ذخیره: " + response.data);
                }
            },
            error: function() {
                alert("خطا در ارتباط با سرور");
            }
        });
    });
    
    // Clear all icons
    $("#clear-all-icons").on("click", function() {
        if (confirm("آیا مطمئن هستید که می‌خواهید همه آیکون‌ها را پاک کنید؟")) {
            $(".icon-input").val("");
            $(".icon-preview").html("<i class=\"fas fa-circle\"></i>");
        }
    });
    
    // Close modal on outside click
    $("#icon-picker-modal").on("click", function(e) {
        if (e.target === this) {
            $(this).hide();
        }
    });
});
</script>';
            file_put_contents($admin_dir . '/menu-icons-page.php', $menu_icons_content);
        }
>>>>>>> REPLACE