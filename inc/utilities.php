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

// AJAX handler for property filtering
function filter_properties_ajax()
{
    // Verify nonce
    check_ajax_referer('property_filter_nonce', 'nonce');

    // Get filter parameters
    $category = sanitize_text_field($_POST['property_category']);
    $type = sanitize_text_field($_POST['property_type']);
    $location = sanitize_text_field($_POST['property_location']);

    // Build WP_Query arguments
    $args = array(
        'post_type' => 'properties', // Your CPT slug
        'posts_per_page' => -1,
        'tax_query' => array('relation' => 'AND')
    );

    // Add taxonomy filters
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'property_category',
            'field' => 'slug',
            'terms' => $category
        );
    }

    if (!empty($type)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => $type
        );
    }

    if (!empty($location)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'property_location',
            'field' => 'slug',
            'terms' => $location
        );
    }

    // Execute query
    $query = new WP_Query($args);

    // Build HTML response
    $html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $html .= '<div class="property-item">';
            $html .= '<h4>' . get_the_title() . '</h4>';
            $html .= '<p>' . get_the_excerpt() . '</p>';
            $html .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $html = '<p>No properties found.</p>';
    }

    wp_send_json_success(array('html' => $html));
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
