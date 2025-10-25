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
    ],
];