<?php
/**
 * Schema Markup Functions
 * 
 * @package Teznevisan
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output Organization Schema
 */
function teznevisan_organization_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url(),
        'logo' => array(
            '@type' => 'ImageObject',
            'url' => TEZNEVISAN_ASSETS_URI . '/images/teznevisan.svg',
            'width' => 300,
            'height' => 100
        ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'telephone' => get_theme_mod('phone_number', '09162352304'),
            'contactType' => 'Customer Service',
            'areaServed' => 'IR',
            'availableLanguage' => 'Persian'
        ),
        'sameAs' => array_filter(array(
            get_theme_mod('telegram_url'),
            get_theme_mod('instagram_url'),
            get_theme_mod('linkedin_url'),
        ))
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}
add_action('wp_head', 'teznevisan_organization_schema');

/**
 * Output Article Schema for Single Posts
 */
function teznevisan_article_schema() {
    if (!is_single()) {
        return;
    }
    
    $post_id = get_the_ID();
    $schema_type = get_post_meta($post_id, 'schema_type', true) ?: 'Article';
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => $schema_type,
        'headline' => get_the_title(),
        'description' => get_the_excerpt(),
        'image' => array(
            '@type' => 'ImageObject',
            'url' => get_the_post_thumbnail_url($post_id, 'full'),
            'width' => 1200,
            'height' => 675
        ),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => array(
            '@type' => 'Organization',
            'name' => 'تزنویسان',
            'url' => home_url()
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => TEZNEVISAN_ASSETS_URI . '/images/teznevisan.svg'
            )
        ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id' => get_permalink()
        )
    );
    
    // Add rating if available
    $rating = teznevisan_get_post_rating();
    if ($rating > 0) {
        $ratings_count = get_post_meta($post_id, 'ratings_count', true) ?: 1;
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => $rating,
            'ratingCount' => $ratings_count
        );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    
    // FAQ Schema if enabled
    $enable_faq = get_post_meta($post_id, 'enable_faq_schema', true);
    if ($enable_faq) {
        $faq_items = get_post_meta($post_id, 'faq_items', true);
        if ($faq_items) {
            $faq_data = json_decode($faq_items, true);
            if ($faq_data && is_array($faq_data)) {
                teznevisan_faq_schema($faq_data);
            }
        }
    }
}
add_action('wp_head', 'teznevisan_article_schema');

/**
 * Output FAQ Schema
 */
function teznevisan_faq_schema($faq_items) {
    $main_entity = array();
    
    foreach ($faq_items as $item) {
        if (isset($item['question']) && isset($item['answer'])) {
            $main_entity[] = array(
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $item['answer']
                )
            );
        }
    }
    
    if (empty($main_entity)) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $main_entity
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}

/**
 * Output Breadcrumb Schema
 */
function teznevisan_breadcrumb_schema() {
    if (is_front_page()) {
        return;
    }
    
    $items = array(
        array(
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'خانه',
            'item' => home_url()
        )
    );
    
    $position = 2;
    
    if (is_category()) {
        $category = get_queried_object();
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $category->name,
            'item' => get_category_link($category)
        );
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $categories[0]->name,
                'item' => get_category_link($categories[0])
            );
        }
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}
add_action('wp_head', 'teznevisan_breadcrumb_schema');

/**
 * Output Website Schema
 */
function teznevisan_website_schema() {
    if (!is_front_page()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}')
            ),
            'query-input' => 'required name=search_term_string'
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}
add_action('wp_head', 'teznevisan_website_schema');
?>
