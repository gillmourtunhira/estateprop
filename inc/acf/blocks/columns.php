<?php

/**
 * Columns Block
 */

return [
    'key' => 'crafted_layout_columns',
    'name' => 'columns',
    'label' => 'Columns Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => 'crafted_layout_columns_anchor',
            'name' => 'anchor',
            'label' => 'Columns Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
        [
            'key' => 'crafted_layout_columns_content',
            'name' => 'top_content',
            'label' => 'Top Content',
            'type' => 'wysiwyg',
            'required' => 0,
            'media_upload' => 0
        ],
        [
            'key' => 'crafted_layout_content_columns',
            'name' => 'content_columns',
            'label' => 'Content Columns',
            'type' => 'repeater',
            'required' => 0,
            'min' => 1,
            'max' => 3,
            'layout' => 'block',
            'sub_fields' => [
                [
                    'key' => 'crafted_layout_content_column',
                    'name' => 'column',
                    'label' => 'Column',
                    'type' => 'wysiwyg',
                    'required' => 0,
                    'media_upload' => 0,
                ],
            ],
        ],
    ],
];
