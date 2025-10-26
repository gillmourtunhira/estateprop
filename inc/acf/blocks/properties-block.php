<?php

/**
 * Properties Block
 */

return [
    "key" => "crafted_layout_properties_block",
    "name" => "properties-block",
    "label" => "Properties Block",
    "display" => "block",

    "sub_fields" => [
        [
            "key" => "crafted_layout_properties_top_content",
            "name" => "top_content",
            "label" => "Top Content",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 0,
        ],
    ],

    "location" => [
        [
            [
                "param" => "post_type",
                "operator" => "==",
                "value" => "properties",
            ],
        ],
    ],
];
