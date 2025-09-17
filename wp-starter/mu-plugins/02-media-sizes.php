<?php
/**
 * Media Optimization - Kagemann Creatives
 * 
 * This must-use plugin optimizes media handling for WordPress.
 * It includes image size optimization, WebP support, and lazy loading.
 * 
 * @package {{CLIENT_SLUG}}
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom image sizes
 */
function {{CLIENT_SLUG}}_add_image_sizes() {
    // Hero images
    add_image_size('hero-large', 1920, 1080, true);
    add_image_size('hero-medium', 1200, 675, true);
    add_image_size('hero-small', 800, 450, true);
    
    // Service images
    add_image_size('service-large', 600, 400, true);
    add_image_size('service-medium', 400, 300, true);
    add_image_size('service-small', 300, 200, true);
    
    // Team images
    add_image_size('team-large', 400, 400, true);
    add_image_size('team-medium', 300, 300, true);
    add_image_size('team-small', 200, 200, true);
    
    // Blog images
    add_image_size('blog-large', 800, 600, true);
    add_image_size('blog-medium', 600, 400, true);
    add_image_size('blog-small', 400, 300, true);
    
    // Thumbnail images
    add_image_size('thumbnail-large', 300, 300, true);
    add_image_size('thumbnail-medium', 200, 200, true);
    add_image_size('thumbnail-small', 150, 150, true);
}
add_action('after_setup_theme', '{{CLIENT_SLUG}}_add_image_sizes');

/**
 * Add WebP support
 */
function {{CLIENT_SLUG}}_add_webp_support($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('mime_types', '{{CLIENT_SLUG}}_add_webp_support');

/**
 * Generate WebP versions of uploaded images
 */
function {{CLIENT_SLUG}}_generate_webp_images($attachment_id) {
    $file_path = get_attached_file($attachment_id);
    $file_info = pathinfo($file_path);
    
    // Only process images
    if (!in_array(strtolower($file_info['extension']), array('jpg', 'jpeg', 'png'))) {
        return;
    }
    
    // Check if WebP is supported
    if (!function_exists('imagewebp')) {
        return;
    }
    
    // Generate WebP version
    $webp_path = $file_info['dirname'] . '/' . $file_info['filename'] . '.webp';
    
    switch (strtolower($file_info['extension'])) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($file_path);
            break;
        case 'png':
            $image = imagecreatefrompng($file_path);
            break;
        default:
            return;
    }
    
    if ($image) {
        imagewebp($image, $webp_path, 80);
        imagedestroy($image);
    }
}
add_action('add_attachment', '{{CLIENT_SLUG}}_generate_webp_images');

/**
 * Serve WebP images when supported
 */
function {{CLIENT_SLUG}}_serve_webp_images($content) {
    if (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false) {
        $content = preg_replace('/\.(jpg|jpeg|png)/i', '.webp', $content);
    }
    return $content;
}
add_filter('the_content', '{{CLIENT_SLUG}}_serve_webp_images');
add_filter('post_thumbnail_html', '{{CLIENT_SLUG}}_serve_webp_images');

/**
 * Add lazy loading to images
 */
function {{CLIENT_SLUG}}_add_lazy_loading($content) {
    // Add loading="lazy" to images
    $content = preg_replace('/<img(.*?)>/i', '<img$1 loading="lazy">', $content);
    
    // Add data-src for lazy loading
    $content = preg_replace('/<img([^>]*?)src="([^"]*?)"([^>]*?)>/i', '<img$1src="data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1 1\'%3E%3C/svg%3E" data-src="$2"$3>', $content);
    
    return $content;
}
add_filter('the_content', '{{CLIENT_SLUG}}_add_lazy_loading');
add_filter('post_thumbnail_html', '{{CLIENT_SLUG}}_add_lazy_loading');

/**
 * Optimize image quality
 */
function {{CLIENT_SLUG}}_optimize_image_quality($quality, $mime_type) {
    switch ($mime_type) {
        case 'image/jpeg':
            return 85;
        case 'image/png':
            return 90;
        case 'image/webp':
            return 80;
        default:
            return $quality;
    }
}
add_filter('jpeg_quality', function() { return 85; });
add_filter('wp_editor_set_quality', function() { return 85; });

/**
 * Remove default image sizes
 */
function {{CLIENT_SLUG}}_remove_default_image_sizes($sizes) {
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', '{{CLIENT_SLUG}}_remove_default_image_sizes');

/**
 * Add responsive image attributes
 */
function {{CLIENT_SLUG}}_add_responsive_image_attributes($attr, $attachment, $size) {
    // Add srcset for responsive images
    if (isset($attr['src'])) {
        $src = $attr['src'];
        $srcset = array();
        
        // Add different sizes
        $sizes = array(
            'thumbnail' => 150,
            'medium' => 300,
            'large' => 1024,
            'full' => 1920
        );
        
        foreach ($sizes as $size_name => $width) {
            $image = wp_get_attachment_image_src($attachment->ID, $size_name);
            if ($image) {
                $srcset[] = $image[0] . ' ' . $width . 'w';
            }
        }
        
        if (!empty($srcset)) {
            $attr['srcset'] = implode(', ', $srcset);
            $attr['sizes'] = '(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw';
        }
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', '{{CLIENT_SLUG}}_add_responsive_image_attributes', 10, 3);

/**
 * Compress images on upload
 */
function {{CLIENT_SLUG}}_compress_uploaded_images($attachment_id) {
    $file_path = get_attached_file($attachment_id);
    $file_info = pathinfo($file_path);
    
    // Only process images
    if (!in_array(strtolower($file_info['extension']), array('jpg', 'jpeg', 'png'))) {
        return;
    }
    
    // Check if image processing is available
    if (!function_exists('imagecreatefromjpeg') || !function_exists('imagejpeg')) {
        return;
    }
    
    // Get image dimensions
    $image_info = getimagesize($file_path);
    if (!$image_info) {
        return;
    }
    
    $width = $image_info[0];
    $height = $image_info[1];
    $mime_type = $image_info['mime'];
    
    // Skip if image is too small
    if ($width < 100 || $height < 100) {
        return;
    }
    
    // Create image resource
    switch ($mime_type) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($file_path);
            break;
        case 'image/png':
            $image = imagecreatefrompng($file_path);
            break;
        default:
            return;
    }
    
    if (!$image) {
        return;
    }
    
    // Compress and save
    switch ($mime_type) {
        case 'image/jpeg':
            imagejpeg($image, $file_path, 85);
            break;
        case 'image/png':
            imagepng($image, $file_path, 9);
            break;
    }
    
    imagedestroy($image);
}
add_action('add_attachment', '{{CLIENT_SLUG}}_compress_uploaded_images');

/**
 * Add image optimization settings to admin
 */
function {{CLIENT_SLUG}}_add_image_optimization_settings() {
    add_options_page(
        'Image Optimization',
        'Image Optimization',
        'manage_options',
        'image-optimization',
        '{{CLIENT_SLUG}}_image_optimization_page'
    );
}
add_action('admin_menu', '{{CLIENT_SLUG}}_add_image_optimization_settings');

/**
 * Image optimization settings page
 */
function {{CLIENT_SLUG}}_image_optimization_page() {
    if (isset($_POST['submit'])) {
        update_option('{{CLIENT_SLUG}}_image_quality', intval($_POST['image_quality']));
        update_option('{{CLIENT_SLUG}}_webp_enabled', isset($_POST['webp_enabled']));
        update_option('{{CLIENT_SLUG}}_lazy_loading', isset($_POST['lazy_loading']));
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    $image_quality = get_option('{{CLIENT_SLUG}}_image_quality', 85);
    $webp_enabled = get_option('{{CLIENT_SLUG}}_webp_enabled', true);
    $lazy_loading = get_option('{{CLIENT_SLUG}}_lazy_loading', true);
    ?>
    <div class="wrap">
        <h1>Image Optimization Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">Image Quality</th>
                    <td>
                        <input type="range" name="image_quality" min="60" max="100" value="<?php echo $image_quality; ?>" />
                        <span><?php echo $image_quality; ?>%</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">WebP Support</th>
                    <td>
                        <input type="checkbox" name="webp_enabled" <?php checked($webp_enabled); ?> />
                        <label>Enable WebP image generation</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Lazy Loading</th>
                    <td>
                        <input type="checkbox" name="lazy_loading" <?php checked($lazy_loading); ?> />
                        <label>Enable lazy loading for images</label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Add image optimization info to media library
 */
function {{CLIENT_SLUG}}_add_media_library_info($form_fields, $post) {
    if (strpos($post->post_mime_type, 'image/') === 0) {
        $file_path = get_attached_file($post->ID);
        $file_size = filesize($file_path);
        $file_size_mb = round($file_size / 1024 / 1024, 2);
        
        $form_fields['file_size'] = array(
            'label' => 'File Size',
            'input' => 'html',
            'html' => $file_size_mb . ' MB'
        );
        
        // Check if WebP version exists
        $webp_path = str_replace(array('.jpg', '.jpeg', '.png'), '.webp', $file_path);
        if (file_exists($webp_path)) {
            $form_fields['webp_version'] = array(
                'label' => 'WebP Version',
                'input' => 'html',
                'html' => '<span style="color: green;">✓ Available</span>'
            );
        }
    }
    
    return $form_fields;
}
add_filter('attachment_fields_to_edit', '{{CLIENT_SLUG}}_add_media_library_info', 10, 2);

/**
 * Optimize existing images
 */
function {{CLIENT_SLUG}}_optimize_existing_images() {
    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => -1,
        'post_status' => 'inherit'
    ));
    
    foreach ($attachments as $attachment) {
        {{CLIENT_SLUG}}_compress_uploaded_images($attachment->ID);
        {{CLIENT_SLUG}}_generate_webp_images($attachment->ID);
    }
}

/**
 * Add bulk optimization action
 */
function {{CLIENT_SLUG}}_add_bulk_optimization_action($bulk_actions) {
    $bulk_actions['optimize_images'] = 'Optimize Images';
    return $bulk_actions;
}
add_filter('bulk_actions-upload', '{{CLIENT_SLUG}}_add_bulk_optimization_action');

/**
 * Handle bulk optimization
 */
function {{CLIENT_SLUG}}_handle_bulk_optimization($redirect_to, $doaction, $post_ids) {
    if ($doaction !== 'optimize_images') {
        return $redirect_to;
    }
    
    foreach ($post_ids as $post_id) {
        {{CLIENT_SLUG}}_compress_uploaded_images($post_id);
        {{CLIENT_SLUG}}_generate_webp_images($post_id);
    }
    
    $redirect_to = add_query_arg('bulk_optimized', count($post_ids), $redirect_to);
    return $redirect_to;
}
add_filter('handle_bulk_actions-upload', '{{CLIENT_SLUG}}_handle_bulk_optimization', 10, 3);

/**
 * Show bulk optimization notice
 */
function {{CLIENT_SLUG}}_bulk_optimization_notice() {
    if (!empty($_REQUEST['bulk_optimized'])) {
        $count = intval($_REQUEST['bulk_optimized']);
        printf('<div class="notice notice-success"><p>%d images optimized successfully!</p></div>', $count);
    }
}
add_action('admin_notices', '{{CLIENT_SLUG}}_bulk_optimization_notice');

/**
 * Add image optimization to admin bar
 */
function {{CLIENT_SLUG}}_add_admin_bar_optimization($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_node(array(
        'id' => 'optimize-images',
        'title' => 'Optimize Images',
        'href' => admin_url('upload.php?action=optimize_images'),
        'meta' => array(
            'title' => 'Optimize all images'
        )
    ));
}
add_action('admin_bar_menu', '{{CLIENT_SLUG}}_add_admin_bar_optimization', 100);

/**
 * Handle admin bar optimization action
 */
function {{CLIENT_SLUG}}_handle_admin_bar_optimization() {
    if (isset($_GET['action']) && $_GET['action'] === 'optimize_images') {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to perform this action.');
        }
        
        {{CLIENT_SLUG}}_optimize_existing_images();
        
        wp_redirect(admin_url('upload.php?optimized=1'));
        exit;
    }
}
add_action('admin_init', '{{CLIENT_SLUG}}_handle_admin_bar_optimization');

/**
 * Show optimization notice
 */
function {{CLIENT_SLUG}}_optimization_notice() {
    if (isset($_GET['optimized'])) {
        echo '<div class="notice notice-success"><p>All images have been optimized!</p></div>';
    }
}
add_action('admin_notices', '{{CLIENT_SLUG}}_optimization_notice');
