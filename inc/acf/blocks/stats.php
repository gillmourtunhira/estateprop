<?php

/**
 * Stats Block
 */

return [
    'key' => 'crafted_layout_stats',
    'name' => 'stats',
    'label' => 'Stats Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => 'crafted_layout_stats_anchor',
            'name' => 'anchor',
            'label' => 'Stats Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
        [
            'key' => 'crafted_layout_stats_content',
            'name' => 'content',
            'label' => 'Stats Content',
            'type' => 'wysiwyg',
            'required' => 0,
            'media_upload' => 0
        ],
        [
            'key' => 'crafted_layout_stats_items',
            'name' => 'items',
            'label' => 'Stats Items',
            'type' => 'repeater',
            'layout' => 'block',
            'required' => 0,

            'sub_fields' => [
                [
                    'key' => 'crafted_layout_stats_item_icon',
                    'name' => 'icon',
                    'label' => 'Icon',
                    'type' => 'text',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '25',
                    ],
                ],
                [
                    'key' => 'crafted_layout_stats_item_number',
                    'name' => 'number',
                    'label' => 'Number',
                    'type' => 'number',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '25',
                    ],
                ],
                [
                    'key' => 'crafted_layout_stats_item_label',
                    'name' => 'label',
                    'label' => 'Label',
                    'type' => 'text',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '50',
                    ],
                ],
            ],
        ],
    ],
];
