<?php
/**
 * Search Form Template
 * Modern, accessible search form
 * 
 * @package Teznevisan
 * @version 2.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field-<?php echo uniqid(); ?>" class="screen-reader-text">
        <?php _e('جستجو برای:', 'teznevisan'); ?>
    </label>
    
    <div class="search-form-wrapper">
        <input type="search" 
               id="search-field-<?php echo uniqid(); ?>" 
               class="search-field" 
               placeholder="<?php esc_attr_e('عنوان، کلمات کلیدی یا دسته‌بندی...', 'teznevisan'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" 
               autocomplete="off"
               aria-label="<?php esc_attr_e('فیلد جستجو', 'teznevisan'); ?>" />
        
        <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('ارسال جستجو', 'teznevisan'); ?>">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="screen-reader-text"><?php _e('جستجو', 'teznevisan'); ?></span>
    </button>

    </div>
    
    <!-- Quick Search Suggestions (Optional) -->
    <div class="search-suggestions" style="display: none;">
        <h4 class="suggestions-title"><?php _e('جستجوهای محبوب:', 'teznevisan'); ?></h4>
        <div class="suggestions-tags">
            <?php
            $popular_tags = get_tags(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 8,
            ));
            
            if ($popular_tags) :
                foreach ($popular_tags as $tag) :
            ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                   class="suggestion-tag">
                    <?php echo esc_html($tag->name); ?>
                </a>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</form>
