<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <h2 id="search-heading" class="sr-only"><?php _e('Search the site', 'teznevisan'); ?></h2>
    <div class="search-input-wrapper">
        <input type="search" class="search-input" placeholder="<?php _e('Search the site...', 'teznevisan'); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="<?php _e('Search term', 'teznevisan'); ?>">
        <button type="submit" class="search-submit" aria-label="<?php _e('Search', 'teznevisan'); ?>">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>