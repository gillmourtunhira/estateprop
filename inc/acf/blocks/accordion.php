<?php
/**
 * Accordion Block
 */

return [
    'key' => 'crafted_layout_accordion',
    'name' => 'accordion',
    'label' => 'Accordion Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => 'crafted_layout_accordion_anchor',
            'name' => 'anchor',
            'label' => 'Accordion Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
        [
            'key' => 'crafted_layout_accordion_content',
            'name' => 'content',
            'label' => 'Accordion Content',
            'type' => 'wysiwyg',
            'required' => 0,
            'media_upload' => 0
        ],
        [
            'key' => 'crafted_layout_accordion_items',
            'name' => 'items',
            'label' => 'Accordion Items',
            'type' => 'repeater',
            'layout' => 'block',
            'required' => 0,
            'sub_fields' => [
                [
                    'key' => 'crafted_layout_accordion_item_title',
                    'name' => 'title',
                    'label' => 'Title',
                    'type' => 'text',
                    'required' => 1,
                ],
                [
                    'key' => 'crafted_layout_accordion_item_content',
                    'name' => 'content',
                    'label' => 'Content',
                    'type' => 'wysiwyg',
                    'required' => 1,
                    'media_upload' => 0,
                ],
            ],
        ]
    ],
];
