<?php
/*
* Post Types
*/

/**
 * Register Properties Custom Post Type
 * Add this code to your theme's functions.php or a custom plugin
 */

// Register Properties Custom Post Type
function register_properties_post_type() {
    $labels = array(
        'name'                  => _x('Properties', 'Post Type General Name', 'textdomain'),
        'singular_name'         => _x('Property', 'Post Type Singular Name', 'textdomain'),
        'menu_name'             => __('Properties', 'textdomain'),
        'name_admin_bar'        => __('Property', 'textdomain'),
        'archives'              => __('Property Archives', 'textdomain'),
        'attributes'            => __('Property Attributes', 'textdomain'),
        'parent_item_colon'     => __('Parent Property:', 'textdomain'),
        'all_items'             => __('All Properties', 'textdomain'),
        'add_new_item'          => __('Add New Property', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'new_item'              => __('New Property', 'textdomain'),
        'edit_item'             => __('Edit Property', 'textdomain'),
        'update_item'           => __('Update Property', 'textdomain'),
        'view_item'             => __('View Property', 'textdomain'),
        'view_items'            => __('View Properties', 'textdomain'),
        'search_items'          => __('Search Property', 'textdomain'),
        'not_found'             => __('Not found', 'textdomain'),
        'not_found_in_trash'    => __('Not found in Trash', 'textdomain'),
        'featured_image'        => __('Property Image', 'textdomain'),
        'set_featured_image'    => __('Set property image', 'textdomain'),
        'remove_featured_image' => __('Remove property image', 'textdomain'),
        'use_featured_image'    => __('Use as property image', 'textdomain'),
        'insert_into_item'      => __('Insert into property', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this property', 'textdomain'),
        'items_list'            => __('Properties list', 'textdomain'),
        'items_list_navigation' => __('Properties list navigation', 'textdomain'),
        'filter_items_list'     => __('Filter properties list', 'textdomain'),
    );

    $args = array(
        'label'                 => __('Property', 'textdomain'),
        'description'           => __('Properties listings and information', 'textdomain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies'            => array('property_category', 'property_type', 'property_location'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-home',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable Gutenberg editor
        'rewrite'               => array('slug' => 'properties'),
    );

    register_post_type('properties', $args);
}
add_action('init', 'register_properties_post_type', 0);


// Register Property Category Taxonomy
function register_property_category_taxonomy() {
    $labels = array(
        'name'                       => _x('Property Categories', 'Taxonomy General Name', 'textdomain'),
        'singular_name'              => _x('Property Category', 'Taxonomy Singular Name', 'textdomain'),
        'menu_name'                  => __('Categories', 'textdomain'),
        'all_items'                  => __('All Categories', 'textdomain'),
        'parent_item'                => __('Parent Category', 'textdomain'),
        'parent_item_colon'          => __('Parent Category:', 'textdomain'),
        'new_item_name'              => __('New Category Name', 'textdomain'),
        'add_new_item'               => __('Add New Category', 'textdomain'),
        'edit_item'                  => __('Edit Category', 'textdomain'),
        'update_item'                => __('Update Category', 'textdomain'),
        'view_item'                  => __('View Category', 'textdomain'),
        'separate_items_with_commas' => __('Separate categories with commas', 'textdomain'),
        'add_or_remove_items'        => __('Add or remove categories', 'textdomain'),
        'choose_from_most_used'      => __('Choose from the most used', 'textdomain'),
        'popular_items'              => __('Popular Categories', 'textdomain'),
        'search_items'               => __('Search Categories', 'textdomain'),
        'not_found'                  => __('Not Found', 'textdomain'),
        'no_terms'                   => __('No categories', 'textdomain'),
        'items_list'                 => __('Categories list', 'textdomain'),
        'items_list_navigation'      => __('Categories list navigation', 'textdomain'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'property-category'),
    );

    register_taxonomy('property_category', array('properties'), $args);
}
add_action('init', 'register_property_category_taxonomy', 0);


// Register Property Type Taxonomy
function register_property_type_taxonomy() {
    $labels = array(
        'name'                       => _x('Property Types', 'Taxonomy General Name', 'textdomain'),
        'singular_name'              => _x('Property Type', 'Taxonomy Singular Name', 'textdomain'),
        'menu_name'                  => __('Property Types', 'textdomain'),
        'all_items'                  => __('All Types', 'textdomain'),
        'parent_item'                => __('Parent Type', 'textdomain'),
        'parent_item_colon'          => __('Parent Type:', 'textdomain'),
        'new_item_name'              => __('New Type Name', 'textdomain'),
        'add_new_item'               => __('Add New Type', 'textdomain'),
        'edit_item'                  => __('Edit Type', 'textdomain'),
        'update_item'                => __('Update Type', 'textdomain'),
        'view_item'                  => __('View Type', 'textdomain'),
        'separate_items_with_commas' => __('Separate types with commas', 'textdomain'),
        'add_or_remove_items'        => __('Add or remove types', 'textdomain'),
        'choose_from_most_used'      => __('Choose from the most used', 'textdomain'),
        'popular_items'              => __('Popular Types', 'textdomain'),
        'search_items'               => __('Search Types', 'textdomain'),
        'not_found'                  => __('Not Found', 'textdomain'),
        'no_terms'                   => __('No types', 'textdomain'),
        'items_list'                 => __('Types list', 'textdomain'),
        'items_list_navigation'      => __('Types list navigation', 'textdomain'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'property-type'),
    );

    register_taxonomy('property_type', array('properties'), $args);
}
add_action('init', 'register_property_type_taxonomy', 0);


// Register Property Location Taxonomy
function register_property_location_taxonomy() {
    $labels = array(
        'name'                       => _x('Locations', 'Taxonomy General Name', 'textdomain'),
        'singular_name'              => _x('Location', 'Taxonomy Singular Name', 'textdomain'),
        'menu_name'                  => __('Locations', 'textdomain'),
        'all_items'                  => __('All Locations', 'textdomain'),
        'parent_item'                => __('Parent Location', 'textdomain'),
        'parent_item_colon'          => __('Parent Location:', 'textdomain'),
        'new_item_name'              => __('New Location Name', 'textdomain'),
        'add_new_item'               => __('Add New Location', 'textdomain'),
        'edit_item'                  => __('Edit Location', 'textdomain'),
        'update_item'                => __('Update Location', 'textdomain'),
        'view_item'                  => __('View Location', 'textdomain'),
        'separate_items_with_commas' => __('Separate locations with commas', 'textdomain'),
        'add_or_remove_items'        => __('Add or remove locations', 'textdomain'),
        'choose_from_most_used'      => __('Choose from the most used', 'textdomain'),
        'popular_items'              => __('Popular Locations', 'textdomain'),
        'search_items'               => __('Search Locations', 'textdomain'),
        'not_found'                  => __('Not Found', 'textdomain'),
        'no_terms'                   => __('No locations', 'textdomain'),
        'items_list'                 => __('Locations list', 'textdomain'),
        'items_list_navigation'      => __('Locations list navigation', 'textdomain'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'location'),
    );

    register_taxonomy('property_location', array('properties'), $args);
}
add_action('init', 'register_property_location_taxonomy', 0);


// Flush rewrite rules on theme activation (run once)
function properties_rewrite_flush() {
    register_properties_post_type();
    register_property_category_taxonomy();
    register_property_type_taxonomy();
    register_property_location_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'properties_rewrite_flush');


// Optional: Add default terms when CPT is registered
function add_default_property_terms() {
    // Add default categories
    if (!term_exists('For Sale', 'property_category')) {
        wp_insert_term('For Sale', 'property_category', array('slug' => 'for-sale'));
    }
    if (!term_exists('For Rent', 'property_category')) {
        wp_insert_term('For Rent', 'property_category', array('slug' => 'for-rent'));
    }
    if (!term_exists('Sold', 'property_category')) {
        wp_insert_term('Sold', 'property_category', array('slug' => 'sold'));
    }

    // Add default property types
    $types = array('House', 'Apartment', 'Condo', 'Villa', 'Studio', 'Townhouse');
    foreach ($types as $type) {
        if (!term_exists($type, 'property_type')) {
            wp_insert_term($type, 'property_type', array('slug' => strtolower($type)));
        }
    }

    // Add default locations
    $locations = array('Downtown', 'Suburbs', 'Waterfront', 'Countryside');
    foreach ($locations as $location) {
        if (!term_exists($location, 'property_location')) {
            wp_insert_term($location, 'property_location', array('slug' => strtolower($location)));
        }
    }
}
add_action('init', 'add_default_property_terms');
?>