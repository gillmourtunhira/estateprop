<?php

/**
 * Properties Block
 */

return [
    "key" => "crafted_layout_properties_block",
    "name" => "properties",
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
        [
            "key" => "crafted_layout_properties_number_of_properties",
            "name" => "number_of_properties",
            "label" => "Number of Properties",
            "type" => "number",
            "default_value" => 6,
            "required" => 1,
        ],
    ],
];
