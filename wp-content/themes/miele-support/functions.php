<?php
defined('ABSPATH') || exit;

/* INCLUDES */
require_once get_template_directory() . '/inc/breadcrumbs.php';

/* THEME SETUP */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
});


/* MENUS */
register_nav_menus([
    'primary'        => 'Primary Menu',
    'burger_main'    => 'Burger Main',
]);

/* CPT: SERVICE */
function register_service_cpt() {
    register_post_type('service', [
        'label' => 'Services',
        'public' => true,
        'hierarchical' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'services'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_service_cpt');
add_action('after_switch_theme', function () {
    register_service_cpt();
    flush_rewrite_rules();
});

/* ACF OPTIONS */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'redirect'   => false,
    ]);

    acf_add_options_page([
        'page_title' => 'Service Settings',
        'menu_title' => 'Service Settings',
        'menu_slug'  => 'service-settings',
        'redirect'   => false,
    ]);
}

/* AJAX BLOG */
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts() {
    $page = intval($_GET['page']);

    $q = new WP_Query([
        'post_type' => 'post',
        'paged' => $page,
    ]);

    while ($q->have_posts()) {
        $q->the_post();
        get_template_part('template-parts/blog/card');
    }

    wp_die();
}

/* SCHEMA */
add_action('wp_head', function () {
    if (is_singular('service')) {
        get_template_part('template-parts/schema/service');
        if (get_field('faq')) {
            get_template_part('template-parts/schema/faq');
        }
    }

    if (is_single() && get_post_type() === 'post') {
        get_template_part('template-parts/schema/article');
    }
});


add_filter('acf/settings/save_json', function() {
    return get_template_directory() . '/acf-json';
});
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

/* ACF BLOCKS */
if (function_exists('acf_register_block_type')) {
    add_action('acf/init', function() {
        acf_register_block_type([
            'name'            => 'services-catalog',
            'title'           => __('Services Catalog'),
            'description'     => __('Display service categories with items in a grid layout'),
            'render_template' => 'template-parts/blocks/services-catalog.php',
            'category'        => 'layout',
            'icon'            => 'grid-view',
            'keywords'        => ['services', 'catalog', 'grid', 'category'],
            'mode'            => 'auto',
            'supports'        => [
                'align'           => true,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ],
        ]);
    });
}

/* MEGA MENU CACHE */
define('MEGA_MENU_CACHE_KEY', 'miele_mega_menu_cache');
define('MEGA_MENU_CACHE_TIME', 2 * HOUR_IN_SECONDS);

/**
 * Clear mega menu cache when service posts are updated
 */
function clear_mega_menu_cache($post_id) {
    if (get_post_type($post_id) !== 'service') {
        return;
    }
    delete_transient(MEGA_MENU_CACHE_KEY);
}
add_action('save_post_service', 'clear_mega_menu_cache');
add_action('delete_post', 'clear_mega_menu_cache');

/**
 * Get cached level 1 services for mega menu
 */
function get_cached_level1_services() {
    $cached = get_transient(MEGA_MENU_CACHE_KEY);

    if ($cached !== false) {
        return $cached;
    }

    $services = get_posts([
        'post_type' => 'service',
        'post_parent' => 0,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ]);

    set_transient(MEGA_MENU_CACHE_KEY, $services, MEGA_MENU_CACHE_TIME);

    return $services;
}

/**
 * Get children services for a parent service
 */
function get_service_children($parent_id, $check_visibility = true) {
    $args = [
        'post_type' => 'service',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ];

    $children = get_posts($args);

    if ($check_visibility) {
        $children = array_filter($children, function($child) {
            $show_in_menu = get_field('show_in_mega_menu', $child->ID);
            return $show_in_menu !== false;
        });
    }

    return $children;
}

/* CONTACT FORM AJAX HANDLER */
add_action('wp_ajax_contact_form_submit', 'handle_contact_form_submit');
add_action('wp_ajax_nopriv_contact_form_submit', 'handle_contact_form_submit');

function handle_contact_form_submit() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['contact_form_nonce'] ?? '', 'contact_form_submit')) {
        wp_send_json_error(['message' => 'Security check failed.']);
    }

    // Sanitize input data - Step 1
    $category = sanitize_text_field($_POST['category'] ?? '');
    $problem_description = sanitize_textarea_field($_POST['problem_description'] ?? '');
    $coi = sanitize_text_field($_POST['coi'] ?? '');

    // Sanitize input data - Step 2
    $appointment_date = sanitize_text_field($_POST['appointment_date'] ?? '');
    $appointment_time = sanitize_text_field($_POST['appointment_time'] ?? '');

    // Sanitize input data - Step 3
    $full_name = sanitize_text_field($_POST['full_name'] ?? '');
    $address = sanitize_textarea_field($_POST['address'] ?? '');
    $city = sanitize_text_field($_POST['city'] ?? '');
    $postcode = sanitize_text_field($_POST['postcode'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');

    // Handle file upload
    $coi_file = null;
    $coi_file_path = '';
    if (!empty($_FILES['coi_file']) && $_FILES['coi_file']['error'] === UPLOAD_ERR_OK) {
        $uploaded_file = $_FILES['coi_file'];
        
        // Validate file type
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_type = wp_check_filetype_and_ext($uploaded_file['tmp_name'], $uploaded_file['name']);
        
        if (in_array($file_type['type'], $allowed_types)) {
            // Validate file size (5MB max)
            $max_size = 5 * 1024 * 1024;
            if ($uploaded_file['size'] <= $max_size) {
                // Upload to WordPress uploads directory
                $upload = wp_handle_upload($uploaded_file, ['test_form' => false]);
                if (!isset($upload['error'])) {
                    $coi_file = $upload['url'];
                    $coi_file_path = $upload['file'];
                }
            }
        }
    }

    // Validate required fields
    $errors = [];

    // Step 1 validation
    if (empty($category)) {
        $errors[] = 'Category is required.';
    }
    if (empty($problem_description)) {
        $errors[] = 'Problem description is required.';
    }
    if (empty($coi)) {
        $errors[] = 'COI selection is required.';
    }

    // Step 2 validation
    if (empty($appointment_date)) {
        $errors[] = 'Appointment date is required.';
    }
    if (empty($appointment_time)) {
        $errors[] = 'Appointment time is required.';
    } elseif (!in_array($appointment_time, ['8am-12pm', '12pm-4pm', '4pm-8pm'])) {
        $errors[] = 'Invalid appointment time selected.';
    }

    // Step 3 validation
    if (empty($full_name)) {
        $errors[] = 'Full name is required.';
    }
    if (empty($address)) {
        $errors[] = 'Address is required.';
    }
    if (empty($city)) {
        $errors[] = 'City is required.';
    }
    if (empty($postcode)) {
        $errors[] = 'Postcode is required.';
    }
    if (empty($phone)) {
        $errors[] = 'Phone number is required.';
    }
    if (empty($email) || !is_email($email)) {
        $errors[] = 'Valid email is required.';
    }

    if (!empty($errors)) {
        wp_send_json_error(['message' => implode(' ', $errors)]);
    }

    // Get admin email from ACF or use WordPress admin email
    $admin_email = get_field('form_admin_email') ?: get_option('admin_email');

    // Format COI for display
    $coi_display = [
        'yes' => 'Yes',
        'no' => 'No',
        'not_sure' => 'Not Sure',
    ];
    $coi_text = $coi_display[$coi] ?? $coi;

    // Format appointment time for display
    $time_display = [
        '8am-12pm' => '8:00 AM - 12:00 PM',
        '12pm-4pm' => '12:00 PM - 4:00 PM',
        '4pm-8pm' => '4:00 PM - 8:00 PM',
    ];
    $appointment_time_text = $time_display[$appointment_time] ?? $appointment_time;

    // Build email subject
    $subject = sprintf(
        '[%s] New Service Request: %s - %s',
        get_bloginfo('name'),
        ucfirst($category),
        $full_name
    );

    // Build email message
    $message = "New Service Request\n";
    $message .= "========================\n\n";
    
    $message .= "APPLIANCE DETAILS:\n";
    $message .= "------------------------\n";
    $message .= "Category: " . ucfirst($category) . "\n";
    $message .= "Problem Description:\n" . $problem_description . "\n";
    $message .= "Certificate of Insurance: " . $coi_text . "\n";
    if ($coi_file) {
        $message .= "COI File: " . $coi_file . "\n";
    }
    $message .= "\n";
    
    $message .= "APPOINTMENT DETAILS:\n";
    $message .= "------------------------\n";
    $message .= "Date: " . $appointment_date . "\n";
    $message .= "Time: " . $appointment_time_text . "\n";
    $message .= "\n";
    
    $message .= "CONTACT INFORMATION:\n";
    $message .= "------------------------\n";
    $message .= "Name: " . $full_name . "\n";
    $message .= "Address: " . $address . "\n";
    $message .= "City: " . $city . "\n";
    $message .= "Postcode: " . $postcode . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Email: " . $email . "\n\n";
    
    $message .= "Submitted from: " . get_bloginfo('name') . "\n";
    $message .= "Date: " . current_time('mysql') . "\n";

    // Set email headers
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>',
        'Reply-To: ' . $full_name . ' <' . $email . '>',
    ];

    // Prepare attachments if file exists
    $attachments = [];
    if ($coi_file_path && file_exists($coi_file_path)) {
        $attachments[] = $coi_file_path;
    }

    // Send email
    $sent = wp_mail($admin_email, $subject, $message, $headers, $attachments);

    if ($sent) {
        wp_send_json_success([
            'message' => 'Your request has been submitted successfully.',
        ]);
    } else {
        wp_send_json_error(['message' => 'Failed to send email. Please try again later.']);
    }
}

/* JS */

function theme_script($handle, $file, $deps = [], $in_footer = true) {
    wp_enqueue_script(
        $handle,
        get_template_directory_uri() . '/assets/js/' . $file,
        $deps,
        filemtime(get_template_directory() . '/assets/js/' . $file),
        $in_footer
    );
}





/* Style */

function theme_style($handle, $file, $deps = []) {
    wp_enqueue_style(
        $handle,
        get_template_directory_uri() . '/assets/css/' . $file,
        $deps,
        filemtime(get_template_directory() . '/assets/css/' . $file)
    );
}

add_action('wp_enqueue_scripts', function () {

    // CSS
    theme_style('reset', 'reset.css');
    theme_style('base', 'base.css', ['reset']);
    theme_style('breadcrumbs', 'breadcrumbs.css', ['base']);
    theme_style('header', 'header.css', ['base']);
    theme_style('hero', 'hero.css', ['base']);
    theme_style('advantages', 'advantages.css', ['base']);
    theme_style('service-advantages', 'service-advantages.css', ['base']);
    theme_style('section5', 'section5.css', ['base']);
    theme_style('section6', 'section6.css', ['base']);
    theme_style('home-catalog', 'home-catalog.css', ['base']);
    theme_style('benefits', 'benefits.css', ['base']);
    theme_style('home-slider', 'home-slider.css', ['base']);
    theme_style('faq', 'faq.css', ['base']);
    theme_style('reviews', 'reviews.css', ['base']);
    theme_style('service-areas', 'service-areas.css', ['base']);
    theme_style('service-category-grid', 'service-category-grid.css', ['base']);
    theme_style('service-text-on-image', 'service-text-on-image.css', ['base']);
    theme_style('service-text-block', 'service-text-block.css', ['base']);
    theme_style('service-models', 'service-models.css', ['base']);
    theme_style('service-problems', 'service-problems.css', ['base']);
    theme_style('service-error-codes', 'service-error-codes.css', ['base']);
    theme_style('service-error-codes-table', 'service-error-codes-table.css', ['base']);
    theme_style('service-pricing-table', 'service-pricing-table.css', ['base']);
    theme_style('service-pricing-comparison', 'service-pricing-comparison.css', ['base']);
    theme_style('service-trust-cta', 'service-trust-cta.css', ['base']);
    theme_style('service-accent', 'service-accent.css', ['base']);
    theme_style('service-accent-buttons', 'service-accent-buttons.css', ['base']);
    theme_style('cta-secondary', 'cta-secondary.css', ['base']);
    theme_style('page-services', 'page-services.css', ['base']);
    theme_style('services-catalog', 'services-catalog.css', ['base']);
    theme_style('catalog-description', 'catalog-description.css', ['base']);
    theme_style('footer', 'footer.css', ['base']);
    theme_style('news', 'news.css', ['base']);
    theme_style('news-hero', 'news-hero.css', ['base']);
    theme_style('news-tags', 'news-tags.css', ['base']);
    theme_style('contact', 'contact.css', ['base']);

    // JS
    theme_script('header-js', 'header.js');
    theme_script('services-catalog-js', 'services-catalog.js');
    theme_script('faq-js', 'faq.js');
    theme_script('reviews-js', 'reviews.js');
    theme_script('home-catalog-js', 'home-catalog.js');
    theme_script('home-slider-js', 'home-slider.js');
    theme_script('page-services-js', 'page-services.js');
    theme_script('service-models-js', 'service-models.js');

    // News tags script for blog/archive pages
    if (is_home() || is_page_template('page-blog.php') || (is_archive() && get_post_type() === 'post')) {
        theme_script('news-tags-js', 'news-tags.js');
    }

    // Contact form script for contact page
    if (is_page_template('page-contact.php')) {
        theme_script('contact-form-js', 'contact-form.js');
        wp_localize_script('contact-form-js', 'mieleSupportAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('contact_form_submit'),
        ]);
    }

});

