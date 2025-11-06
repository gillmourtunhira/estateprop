<?php

/**
 * Locations Block
 */

return [
    "key" => "crafted_layout_locations",
    "name" => "locations",
    "label" => "Locations Block",
    "display" => "block",

    "sub_fields" => [
        [
            'key' => 'crafted_layout_locations_anchor',
            'name' => 'anchor',
            'label' => 'Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '30',
            ],
        ],
        [
            'key' => 'crafted_layout_locations_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'wysiwyg',
            'media_upload' => 0,
            'required' => 0,
        ],
    ],
];
