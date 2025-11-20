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


// Add User Role Agent and Property Capabilities
function add_agent_role_and_capabilities()
{

    // Create Agent role if not exists
    if (!get_role('agent')) {
        add_role('agent', 'Agent', ['read' => true]);
    }

    $roles = ['agent', 'administrator'];

    // All CPT capabilities
    $caps = [
        'read',
        'read_property',
        'read_private_properties',

        'edit_property',
        'edit_properties',
        'edit_others_properties',
        'edit_published_properties',

        'publish_properties',

        'delete_property',
        'delete_properties',
        'delete_others_properties',
        'delete_published_properties',

        'upload_files',

        // Property Category
        'manage_property_categories',
        'edit_property_categories',
        'delete_property_categories',
        'assign_property_categories',

        // Property Type
        'manage_property_types',
        'edit_property_types',
        'delete_property_types',
        'assign_property_types',

        // Property Location
        'manage_property_locations',
        'edit_property_locations',
        'delete_property_locations',
        'assign_property_locations',
    ];

    foreach ($roles as $role_key) {
        $role = get_role($role_key);
        if (!$role) continue;

        foreach ($caps as $cap) {
            $role->add_cap($cap);
        }
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
        'posts_per_page' => -1,
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
                'image' => get_the_post_thumbnail_url($property_id->ID, 'large'),
                'permalink' => get_permalink($property_id->ID),
            );

            // Get property category
            $terms = get_the_terms($property_id->ID, 'property_category');
            if ($terms && !is_wp_error($terms)) {
                $property_data['category'] = array(
                    'name' => $terms[0]->name,
                    'slug' => $terms[0]->slug,
                );
            } else {
                $property_data['category'] = array(
                    'name' => 'For Sale',
                    'slug' => 'for-sale',
                );
            }

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

// Modern REST API Endpoint for Property Search
add_action('rest_api_init', function () {
    register_rest_route('properties/v1', '/search', [
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'crafted_get_properties',
        'permission_callback' => 'check_same_domain_permission',
        'args' => [
            'category'      => ['required' => false, 'type' => 'string'],
            'property_type' => ['required' => false, 'type' => 'array'],
            'location'      => ['required' => false, 'type' => 'string'],
            'search'        => ['required' => false, 'type' => 'string'],
            'bedrooms'      => ['required' => false, 'type' => 'string'],
            'availability'  => ['required' => false, 'type' => 'string'],
            'price_min'     => ['required' => false, 'type' => 'integer'],
            'price_max'     => ['required' => false, 'type' => 'integer'],
            'per_page'      => ['required' => false, 'type' => 'integer', 'default' => 6],
            'page'          => ['required' => false, 'type' => 'integer', 'default' => 1],
            'exclude_id'    => ['required' => false, 'type' => 'integer', 'default' => 0],
        ],
    ]);
});

// Modern REST API Callback for Property Search
function crafted_get_properties(WP_REST_Request $request)
{
    $category     = sanitize_text_field($request->get_param('category'));
    $type         = is_array($request->get_param('property_type')) ? array_map('sanitize_text_field', $request->get_param('property_type')) : [];
    $location     = esc_sql($request->get_param('location'));
    $search       = sanitize_text_field($request->get_param('search'));
    $bedrooms     = sanitize_text_field($request->get_param('bedrooms'));
    $availability = sanitize_text_field($request->get_param('availability'));
    $price_min    = intval($request->get_param('price_min'));
    $price_max    = intval($request->get_param('price_max'));
    $per_page     = intval($request->get_param('per_page')) ?: 6;
    $page         = intval($request->get_param('page')) ?: 1;
    $exclude      = intval($request->get_param('exclude_id'));

    // Start with a large query to filter in PHP (since ACF flexible content isn't queryable via WP_Query)
    $args = [
        'post_type'      => 'properties',
        'posts_per_page' => -1, // Get all, we'll filter and paginate in PHP
        'post_status'    => 'publish',
    ];

    // Search functionality
    if (!empty($search)) {
        $args['s'] = $search;
    }

    // Build taxonomy filters
    $tax_query = [];

    if ($category) {
        $tax_query[] = [
            'taxonomy' => 'property_category',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    if (!empty($type) && is_array($type)) {
        $tax_query[] = [
            'taxonomy' => 'property_type',
            'field'    => 'slug',
            'terms'    => $type,
        ];
    }

    if ($location) {
        // Search for terms that match the location query (slug or name)
        $term_ids = get_terms([
            'taxonomy'   => 'property_location',
            'name__like' => $location,
            'fields'     => 'ids',
            'hide_empty' => true,
        ]);

        // Also check for exact slug match
        $term_by_slug = get_term_by('slug', $location, 'property_location');
        if ($term_by_slug) {
            $term_ids[] = $term_by_slug->term_id;
        }

        if (!empty($term_ids)) {
            $tax_query[] = [
                'taxonomy' => 'property_location',
                'field'    => 'term_id',
                'terms'    => array_unique($term_ids),
            ];
        } else {
            // If no location is found, we can ensure no results are returned for this query part
            // by querying for a non-existent term.
            $tax_query[] = [
                'taxonomy' => 'property_location',
                'field'    => 'slug',
                'terms'    => 'non-existent-location-' . time(),
            ];
        }
    }

    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    if ($exclude) {
        $args['post__not_in'] = [$exclude];
    }

    $query = new WP_Query($args);
    $all_properties = [];

    // Collect all properties with their data
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $layouts = get_field('flexible_content', $id);

        $property = [
            'id'        => $id,
            'title'     => get_the_title($id),
            'image'     => get_the_post_thumbnail_url($id, 'large'),
            'permalink' => get_permalink($id),
        ];

        // Get property category
        $terms = get_the_terms($id, 'property_category');
        if ($terms && !is_wp_error($terms)) {
            $property['category'] = [
                'name' => $terms[0]->name,
                'slug' => $terms[0]->slug,
            ];
        } else {
            $property['category'] = [
                'name' => 'For Sale',
                'slug' => 'for-sale',
            ];
        }

        // Get property location
        $location_terms = get_the_terms($id, 'property_location');
        if ($location_terms && !is_wp_error($location_terms)) {
            $property['location'] = [
                'name' => $location_terms[0]->name,
                'slug' => $location_terms[0]->slug,
            ];
        }

        // Extract property details from flexible content
        if ($layouts) {
            foreach ($layouts as $layout) {
                if ($layout['acf_fc_layout'] === 'property-block') {
                    $property['price']            = isset($layout['price']) ? floatval($layout['price']) : null;
                    $property['suburb']           = $layout['suburb_address'] ?? null;
                    $property['gallery']          = $layout['gallery'] ?? null;
                    $property['description']      = !empty($layout['description_content'])
                        ? strip_tags($layout['description_content'])
                        : null;
                    $property['property_details'] = $layout['property_details'] ?? null;
                    $property['agent_info']       = $layout['agent_info'] ?? null;

                    // Extract specific details for filtering
                    if (!empty($layout['property_details']) && is_array($layout['property_details'])) {
                        foreach ($layout['property_details'] as $detail) {
                            if (isset($detail['bedrooms_detail'])) {
                                // Handle both numeric and string values, extract just the number
                                $bedroom_value = $detail['bedrooms_detail'];
                                // Remove any non-numeric characters except numbers
                                $property['bedrooms_count'] = intval(preg_replace('/[^0-9]/', '', $bedroom_value));
                            }
                            if (isset($detail['bathrooms_detail'])) {
                                $bathroom_value = $detail['bathrooms_detail'];
                                $property['bathrooms_count'] = intval(preg_replace('/[^0-9]/', '', $bathroom_value));
                            }
                        }
                    }
                    break;
                }
            }
        }

        $all_properties[] = $property;
    }

    wp_reset_postdata();

    // Now filter by bedrooms and price in PHP
    $filtered_properties = array_filter($all_properties, function ($property) use ($bedrooms, $price_min, $price_max) {
        $passes = true;

        // Filter by bedrooms
        if (!empty($bedrooms)) {
            $bedroom_filter = intval($bedrooms);
            $property_bedrooms = $property['bedrooms_count'] ?? 0;

            // If filter is 4, match 4 or more
            if ($bedroom_filter >= 4) {
                $passes = $passes && ($property_bedrooms >= 4);
            } else {
                $passes = $passes && ($property_bedrooms == $bedroom_filter);
            }
        }

        // Filter by price range
        if ($price_min > 0 || $price_max > 0) {
            $property_price = $property['price'] ?? 0;

            if ($price_min > 0 && $property_price < $price_min) {
                $passes = false;
            }

            if ($price_max > 0 && $price_max < 5000000 && $property_price > $price_max) {
                $passes = false;
            }
        }

        return $passes;
    });

    // Reset array keys
    $filtered_properties = array_values($filtered_properties);

    // Manual pagination
    $total = count($filtered_properties);
    $offset = ($page - 1) * $per_page;
    $results = array_slice($filtered_properties, $offset, $per_page);

    // Return results with pagination meta
    $response = [
        'properties' => $results,
        'total' => $total,
        'pages' => ceil($total / $per_page),
        'current_page' => $page,
        'per_page' => $per_page,
    ];

    return rest_ensure_response($response);
}

/**
 * Add image field to "Add New" form in property location taxonomy
 *
 * @param string $taxonomy The taxonomy slug.
 */
function property_location_add_image_field($taxonomy)
{
?>
    <div class="form-field term-group">
        <label for="property_location_image"><?php _e('Category Image', 'crafted-theme'); ?></label>
        <input type="hidden" id="property_location_image" name="property_location_image" value="">
        <div id="property_location_image_preview"></div>
        <button type="button" class="button upload_image_button"><?php _e('Upload Image', 'crafted-theme'); ?></button>
        <button type="button" class="button remove_image_button" style="display:none;"><?php _e('Remove Image', 'crafted-theme'); ?></button>
    </div>
<?php
}
add_action('property_location_add_form_fields', 'property_location_add_image_field');

/**
 * Add image field to "Edit" form in property location taxonomy
 *
 * @param WP_Term $term The term object.
 */
function property_location_edit_image_field($term)
{
    $image_id = get_term_meta($term->term_id, 'property_location_image', true);
    $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="property_location_image"><?php _e('Category Image', 'crafted-theme'); ?></label></th>
        <td>
            <input type="hidden" id="property_location_image" name="property_location_image" value="<?php echo esc_attr($image_id); ?>">
            <div id="property_location_image_preview">
                <?php if ($image_url): ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width:100%; height:auto;">
                <?php endif; ?>
            </div>
            <button type="button" class="button upload_image_button"><?php _e('Upload Image', 'crafted-theme'); ?></button>
            <button type="button" class="button remove_image_button" style="<?php echo $image_url ? '' : 'display:none;'; ?>"><?php _e('Remove Image', 'crafted-theme'); ?></button>
        </td>
    </tr>
<?php
}
add_action('property_location_edit_form_fields', 'property_location_edit_image_field');

/**
 * Save the image field when a term is created or edited
 *
 * @param int $term_id The term ID.
 */
function save_property_location_image($term_id)
{
    if (isset($_POST['property_location_image'])) {
        $image_id = sanitize_text_field($_POST['property_location_image']);
        update_term_meta($term_id, 'property_location_image', $image_id);
    }
}
add_action('created_property_location', 'save_property_location_image');
add_action('edited_property_location', 'save_property_location_image');

/**
 * Enqueue Media Uploader scripts for taxonomy image fields
 *
 * @param string $hook The current admin page.
 */
function property_location_image_enqueue($hook)
{
    if ('edit-tags.php' !== $hook && 'term.php' !== $hook) return;
    if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] !== 'property_location') return;

    wp_enqueue_media();
    wp_add_inline_script('jquery', "
             jQuery(document).ready(function($) {
                 var frame;
                 $('.upload_image_button').on('click', function(e) {
                     e.preventDefault();
                     var button = $(this);

                     if (frame) frame.open();
                     frame = wp.media({
                         title: 'Select or Upload Image',
                         button: { text: 'Use this image' },
                         multiple: false
                     });

                     frame.on('select', function() {
                         var attachment = frame.state().get('selection').first().toJSON();
                         $('#property_location_image').val(attachment.id);
                         $('#property_location_image_preview').html('<img src=\"' + attachment.sizes.thumbnail.url + '\" style=\"max-width:100px;height:auto;\" />');
                         $('.remove_image_button').show();
                     });

                     frame.open();
                 });

                 $('.remove_image_button').on('click', function(e) {
                     e.preventDefault();
                     $('#property_location_image').val('');
                     $('#property_location_image_preview').html('');
                     $(this).hide();
                 });
             });
         ");
}
add_action('admin_enqueue_scripts', 'property_location_image_enqueue');
