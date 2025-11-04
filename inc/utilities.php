<?php
/*
 * Utilities
 */

// Register AJAX Actions
function load_more_posts_ajax()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $posts_per_page = 3;

    // Calculate offset based on page number
    // Page 1 shows posts 1-3 (offset 0)
    // Page 2 shows posts 4-6 (offset 3)
    // Page 3 shows posts 7-9 (offset 6)
    $offset = ($paged - 1) * $posts_per_page;

    $query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => $order,
    ]);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            get_template_part('template-parts/post', 'card', $query);
        endwhile;
    endif;

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax');

// AJAX Property Filter
function filter_properties_ajax()
{
    check_ajax_referer('property_filter_nonce', 'nonce');

    // Parse serialized form string into $_POST-style array
    parse_str($_POST['form_data'], $form_data);

    // Get filter parameters
    $category = sanitize_text_field($form_data['category'] ?? '');
    $type = sanitize_text_field($form_data['property_type'] ?? '');
    $location = sanitize_text_field($form_data['location'] ?? '');

    $args = [
        'post_type'      => 'properties',
        'posts_per_page' => -1,
        'tax_query'      => ['relation' => 'AND'],
    ];

    if (!empty($category)) {
        $args['tax_query'][] = [
            'taxonomy' => 'property_category',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    if (!empty($type)) {
        $args['tax_query'][] = [
            'taxonomy' => 'property_type',
            'field'    => 'slug',
            'terms'    => $type,
        ];
    }

    if (!empty($location)) {
        $args['tax_query'][] = [
            'taxonomy' => 'property_location',
            'field'    => 'slug',
            'terms'    => $location,
        ];
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // You can also use get_template_part('template-parts/property-card');
?>
            <div class="property-item">
                <h4><?php the_title(); ?></h4>
                <p><?php the_excerpt(); ?></p>
            </div>
<?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No properties found.</p>';
    }

    $html = ob_get_clean();

    wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_filter_properties', 'filter_properties_ajax');
add_action('wp_ajax_nopriv_filter_properties', 'filter_properties_ajax');


// Add User Role Agent and Property Capabilities
function add_agent_role_and_capabilities()
{
    // Add 'Agent' role if it doesn't exist
    if (!get_role('agent')) {
        add_role('agent', 'Agent', array(
            'read' => true,
            'edit_properties' => true,
            'publish_properties' => true,
            'edit_published_properties' => true,
            'delete_properties' => true,
            'delete_published_properties' => true,
            'upload_files' => true,
        ));
    }
}
add_action('init', 'add_agent_role_and_capabilities');

// Function to put a decimal point in large numbers
// E.g., 1000000 becomes 1.000.000
// Usage: echo format_large_number(1000000); // Outputs: 1.000.000
function format_large_number($number)
{
    return number_format($number, 0, '', ',');
}

// Calculate the price per square meter
function calculate_price_per_sqm($price_total, $area)
{
    if ($area > 0) {
        return round($price_total / $area);
    }
    return 0;
}

/**
 * Properties REST API Endpoint
 * Registers a custom REST API endpoint to fetch featured properties.
 */
function register_properties_rest_route()
{
    $args = array(
        'methods' => 'GET',
        'callback' => 'get_properties_data',
        'permission_callback' => 'check_same_domain_permission',
        'sanitize_callback' => null,
    );

    register_rest_route('properties/v1', '/featured', $args);
}
add_action('rest_api_init', 'register_properties_rest_route');

/**
 * Check REST API permissions.
 *
 * @return bool True if the request has permission, false otherwise.
 */
function check_same_domain_permission($request)
{
    $referer = $request->get_header('referer');
    $origin  = $request->get_header('origin');
    $site_url = home_url();

    // Normalize URLs (just in case)
    $site_url = rtrim($site_url, '/');

    // Allow internal requests (no referer/origin)
    if (empty($referer) && empty($origin)) {
        return true;
    }

    // Allow if referer or origin starts with our site URL
    if (
        (!empty($referer) && strpos($referer, $site_url) === 0) ||
        (!empty($origin) && strpos($origin, $site_url) === 0)
    ) {
        return true;
    }

    return new WP_Error(
        'rest_forbidden',
        __('Access denied: This endpoint is only accessible from the same domain.'),
        ['status' => 403]
    );
}


/**
 * Callback function to fetch featured properties data.
 *
 * @param WP_REST_Request $request The REST request object.
 * @return WP_REST_Response The response containing featured properties data.
 */
function get_properties_data($request)
{
    $cache_key = 'featured_properties_data';
    $cache_time = 5 * MINUTE_IN_SECONDS;
    $properties = get_transient($cache_key);

    if ($properties !== false) {
        return rest_ensure_response($properties);
    }

    $args = array(
        'post_type' => 'properties',
        'posts_per_page' => 5,
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);
    $properties_ids = $query->posts;
    $properties = array();

    if (!empty($properties_ids)) {
        foreach ($properties_ids as $property_id) {
            // Get the flexible content field
            $layouts = get_field('flexible_content', $property_id->ID);

            $property_data = array(
                'id' => $property_id->ID,
                'title' => get_the_title($property_id->ID),
                'image' => get_the_post_thumbnail_url($property_id->ID, 'medium'),
                'permalink' => get_permalink($property_id->ID),
            );

            // Loop through layouts to find the property-block
            if ($layouts) {
                foreach ($layouts as $layout) {
                    if ($layout['acf_fc_layout'] === 'property-block') {
                        $property_data['price'] = $layout['price'] ?? null;
                        $property_data['suburb'] = $layout['suburb_address'] ?? null;
                        $property_data['gallery'] = $layout['gallery'] ?? null;
                        $property_data['description'] = !empty($layout['description_content'])
                            ? strip_tags($layout['description_content'])
                            : null;
                        $property_data['property_details'] = $layout['property_details'] ?? null;
                        // $property_data['map_longitude'] = $layout['map_longitude'] ?? null;
                        // $property_data['map_latitude'] = $layout['map_latitude'] ?? null;
                        // $property_data['google_map'] = $layout['google_map'] ?? null;
                        $property_data['agent_info'] = $layout['agent_info'] ?? null;
                        break; // Found the property block, no need to continue
                    }
                }
            }

            $properties[] = $property_data;
        }
    }

    set_transient($cache_key, $properties, $cache_time);

    return rest_ensure_response($properties);
}
