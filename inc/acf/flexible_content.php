<?php
$layouts = [];
foreach (glob(__DIR__ . '/blocks/*.php') as $filename) {
    $layouts[basename($filename, '.php')] = include $filename;
}

$main_layouts = $layouts;
unset($main_layouts['property-block']);
unset($main_layouts['related_properties']);

// Main Flexible Content Group (for pages and other post types)
acf_add_local_field_group([
    'key' => 'group_flexible_content_main',
    'title' => 'Flexible Content',
    'fields' => [
        [
            'key' => 'field_681cb58e9f6fd',
            'label' => 'Blocks',
            'name' => 'flexible_content',
            'type' => 'flexible_content',
            'layouts' => $main_layouts,
            'button_label' => 'Add Block',
            'min' => '',
            'max' => '',
        ]
    ],
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
        // Add other post types here if needed
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
        0 => 'the_content',
    ),
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
]);

// Separate Flexible Content Group for Properties (only specific blocks)
$properties_layouts = [];
// Add only the blocks you want for properties
$allowed_blocks = ['property-block', 'related_properties']; // Replace with your actual block names

foreach ($allowed_blocks as $block_name) {
    if (isset($layouts[$block_name])) {
        $properties_layouts[$block_name] = $layouts[$block_name];
    }
}

acf_add_local_field_group([
    'key' => 'group_flexible_content_properties',
    'title' => 'Flexible Content',
    'fields' => [
        [
            'key' => 'field_properties_flexible',
            'label' => 'Blocks',
            'name' => 'flexible_content',
            'type' => 'flexible_content',
            'layouts' => $properties_layouts,
            'button_label' => 'Add Block',
            'min' => '',
            'max' => '',
        ]
    ],
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'properties',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
        0 => 'the_content',
    ),
    'active' => true,
    'description' => '',
    'show_in_rest' => 1,
]);
