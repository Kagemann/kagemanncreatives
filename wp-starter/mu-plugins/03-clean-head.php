<?php
/**
 * Clean Head - Kagemann Creatives
 * 
 * This must-use plugin cleans up the WordPress head section by removing
 * unnecessary elements and optimizing performance.
 * 
 * @package {{CLIENT_SLUG}}
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove unnecessary WordPress head elements
 */
function {{CLIENT_SLUG}}_clean_head() {
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove Windows Live Writer manifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove WordPress shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove adjacent posts links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove emoji scripts and styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove REST API link
    remove_action('wp_head', 'rest_output_link_wp_head');
    
    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove oEmbed-specific JavaScript
    remove_action('wp_head', 'wp_oembed_add_host_js');
    
    // Remove feed links
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    
    // Remove canonical link (we'll add our own)
    remove_action('wp_head', 'rel_canonical');
    
    // Remove prev/next links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    
    // Remove index link
    remove_action('wp_head', 'index_rel_link');
    
    // Remove start link
    remove_action('wp_head', 'start_post_rel_link');
    
    // Remove parent post link
    remove_action('wp_head', 'parent_post_rel_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove EditURI link
    remove_action('wp_head', 'rsd_link');
    
    // Remove pingback link
    remove_action('wp_head', 'wp_generator');
    
    // Remove dns-prefetch
    remove_action('wp_head', 'wp_resource_hints', 2);
}
add_action('init', '{{CLIENT_SLUG}}_clean_head');

/**
 * Remove unnecessary admin head elements
 */
function {{CLIENT_SLUG}}_clean_admin_head() {
    // Remove WordPress version from admin
    remove_action('admin_head', 'wp_generator');
    
    // Remove emoji scripts from admin
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('admin_init', '{{CLIENT_SLUG}}_clean_admin_head');

/**
 * Add custom canonical link
 */
function {{CLIENT_SLUG}}_add_canonical_link() {
    if (is_singular()) {
        $canonical = get_permalink();
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    } elseif (is_home() || is_front_page()) {
        $canonical = home_url('/');
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    } elseif (is_category() || is_tag() || is_tax()) {
        $canonical = get_term_link(get_queried_object());
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    } elseif (is_author()) {
        $canonical = get_author_posts_url(get_queried_object_id());
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    } elseif (is_date()) {
        $canonical = get_year_link(get_query_var('year'));
        if (get_query_var('monthnum')) {
            $canonical = get_month_link(get_query_var('year'), get_query_var('monthnum'));
        }
        if (get_query_var('day')) {
            $canonical = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
        }
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_canonical_link', 1);

/**
 * Add preconnect links for performance
 */
function {{CLIENT_SLUG}}_add_preconnect_links() {
    // Preconnect to Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
    
    // Preconnect to Google Analytics
    echo '<link rel="preconnect" href="https://www.google-analytics.com" crossorigin />' . "\n";
    
    // Preconnect to external domains (add your own)
    $external_domains = array(
        'https://www.googletagmanager.com',
        'https://www.google.com',
        'https://fonts.googleapis.com',
        'https://fonts.gstatic.com'
    );
    
    foreach ($external_domains as $domain) {
        echo '<link rel="preconnect" href="' . esc_url($domain) . '" crossorigin />' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_preconnect_links', 1);

/**
 * Add DNS prefetch for external resources
 */
function {{CLIENT_SLUG}}_add_dns_prefetch() {
    $dns_prefetch_domains = array(
        '//fonts.googleapis.com',
        '//fonts.gstatic.com',
        '//www.google-analytics.com',
        '//www.googletagmanager.com',
        '//www.google.com',
        '//www.gstatic.com'
    );
    
    foreach ($dns_prefetch_domains as $domain) {
        echo '<link rel="dns-prefetch" href="' . esc_url($domain) . '" />' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_dns_prefetch', 1);

/**
 * Add viewport meta tag
 */
function {{CLIENT_SLUG}}_add_viewport_meta() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />' . "\n";
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_viewport_meta', 1);

/**
 * Add theme color meta tag
 */
function {{CLIENT_SLUG}}_add_theme_color_meta() {
    $theme_color = get_theme_mod('primary_color', '#007cba');
    echo '<meta name="theme-color" content="' . esc_attr($theme_color) . '" />' . "\n";
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_theme_color_meta', 1);

/**
 * Add Apple touch icons
 */
function {{CLIENT_SLUG}}_add_apple_touch_icons() {
    $icon_sizes = array(57, 60, 72, 76, 114, 120, 144, 152, 180);
    
    foreach ($icon_sizes as $size) {
        $icon_url = get_site_icon_url($size);
        if ($icon_url) {
            echo '<link rel="apple-touch-icon" sizes="' . $size . 'x' . $size . '" href="' . esc_url($icon_url) . '" />' . "\n";
        }
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_apple_touch_icons', 1);

/**
 * Add manifest link
 */
function {{CLIENT_SLUG}}_add_manifest_link() {
    $manifest_url = get_template_directory_uri() . '/manifest.json';
    echo '<link rel="manifest" href="' . esc_url($manifest_url) . '" />' . "\n";
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_manifest_link', 1);

/**
 * Add Open Graph meta tags
 */
function {{CLIENT_SLUG}}_add_open_graph_meta() {
    if (is_singular()) {
        global $post;
        
        $title = get_the_title();
        $description = get_the_excerpt();
        $url = get_permalink();
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        
        if (!$image) {
            $image = get_site_icon_url(512);
        }
        
        echo '<meta property="og:type" content="article" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
        
        // Article specific
        echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c')) . '" />' . "\n";
        echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c')) . '" />' . "\n";
        
        // Author
        $author = get_the_author_meta('display_name', $post->post_author);
        echo '<meta property="article:author" content="' . esc_attr($author) . '" />' . "\n";
        
    } elseif (is_home() || is_front_page()) {
        $title = get_bloginfo('name');
        $description = get_bloginfo('description');
        $url = home_url('/');
        $image = get_site_icon_url(512);
        
        echo '<meta property="og:type" content="website" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_open_graph_meta', 1);

/**
 * Add Twitter Card meta tags
 */
function {{CLIENT_SLUG}}_add_twitter_card_meta() {
    if (is_singular()) {
        global $post;
        
        $title = get_the_title();
        $description = get_the_excerpt();
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        
        if (!$image) {
            $image = get_site_icon_url(512);
        }
        
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
        
    } elseif (is_home() || is_front_page()) {
        $title = get_bloginfo('name');
        $description = get_bloginfo('description');
        $image = get_site_icon_url(512);
        
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_twitter_card_meta', 1);

/**
 * Add structured data (JSON-LD)
 */
function {{CLIENT_SLUG}}_add_structured_data() {
    if (is_singular()) {
        global $post;
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'description' => get_the_excerpt(),
            'url' => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author_meta('display_name', $post->post_author)
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url(512)
                )
            )
        );
        
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        if ($image) {
            $schema['image'] = $image;
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
        
    } elseif (is_home() || is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url('/'),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_structured_data', 1);

/**
 * Add security headers
 */
function {{CLIENT_SLUG}}_add_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }
}
add_action('send_headers', '{{CLIENT_SLUG}}_add_security_headers');

/**
 * Remove unnecessary query strings from static resources
 */
function {{CLIENT_SLUG}}_remove_query_strings($src) {
    $output = preg_split("/(&ver|\?ver)/", $src);
    return $output[0];
}
add_filter('script_loader_src', '{{CLIENT_SLUG}}_remove_query_strings', 15, 1);
add_filter('style_loader_src', '{{CLIENT_SLUG}}_remove_query_strings', 15, 1);

/**
 * Add preload for critical resources
 */
function {{CLIENT_SLUG}}_add_preload_resources() {
    // Preload critical CSS
    $critical_css = get_template_directory_uri() . '/assets/css/critical.css';
    echo '<link rel="preload" href="' . esc_url($critical_css) . '" as="style" />' . "\n";
    
    // Preload critical fonts
    $critical_fonts = array(
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'
    );
    
    foreach ($critical_fonts as $font) {
        echo '<link rel="preload" href="' . esc_url($font) . '" as="style" />' . "\n";
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_add_preload_resources', 1);

/**
 * Add resource hints for performance
 */
function {{CLIENT_SLUG}}_add_resource_hints($hints, $relation_type) {
    if ($relation_type === 'preconnect') {
        $hints[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => true
        );
        $hints[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => true
        );
    }
    
    return $hints;
}
add_filter('wp_resource_hints', '{{CLIENT_SLUG}}_add_resource_hints', 10, 2);

/**
 * Optimize WordPress head order
 */
function {{CLIENT_SLUG}}_optimize_head_order() {
    // Remove default WordPress head actions
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    
    // Add our optimized head elements in the correct order
    add_action('wp_head', '{{CLIENT_SLUG}}_add_viewport_meta', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_theme_color_meta', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_preconnect_links', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_dns_prefetch', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_preload_resources', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_canonical_link', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_open_graph_meta', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_twitter_card_meta', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_structured_data', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_apple_touch_icons', 1);
    add_action('wp_head', '{{CLIENT_SLUG}}_add_manifest_link', 1);
}
add_action('init', '{{CLIENT_SLUG}}_optimize_head_order');
