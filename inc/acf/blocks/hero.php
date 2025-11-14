<?php

// Hero Block

return [
    "key" => "crafted_layout_hero",
    "name" => "hero",
    "label" => "Hero Block",
    "display" => "block",

    "sub_fields" => [
        [
            "key" => "crafted_layout_hero_background_image",
            "name" => "background_file",
            "label" => "Hero Background File",
            "type" => "file",
            "required" => 0,
            "mime_types" => "jpeg,jpg,png,svg,gif,webp,avif,mp4",
            "wrapper" => [
                "width" => "40",
            ],
        ],
        [
            "key" => "crafted_layout_hero_screen_size",
            "name" => "screen_size",
            "label" => "Screen Size",
            "type" => "select",
            "instructions" => "Select the hero screen size",
            "required" => 0,
            "choices" => [
                "" => "Default",
                "half" => "Half",
                "full" => "Full",
            ],
            "default_value" => "",
            "wrapper" => [
                "width" => "20",
            ],
        ],
        [
            "key" => "crafted_layout_hero_background_color",
            "name" => "background_color",
            "label" => "Background Color",
            "type" => "select",
            "required" => 0,
            "instructions" => "Select the background color style",
            "choices" => [
                "transparent" => "Transparent",
                "gradient" => "Gradient",
                "primary" => "Primary",
                "teal" => "Teal",
                "dark" => "Dark",
                "light" => "Light",
                "light-grey" => "Light Grey",
                "dark-grey" => "Dark Grey",
            ],
            "default_value" => "transparent",
            "wrapper" => [
                "width" => "20",
            ],
        ],
        [
            "key" => "crafted_layout_hero_content_alignment",
            "name" => "content_alignment",
            "label" => "Content Alignment",
            "type" => "select",
            "required" => 0,
            "instructions" => "Select the content alignment",
            "choices" => [
                "left" => "Left",
                "center" => "Center",
            ],
            "default_value" => "left",
            "wrapper" => [
                "width" => "20",
            ],
        ],
        [
            "key" => "crafted_layout_hero_tagline",
            "name" => "tagline",
            "label" => "Tagline",
            "type" => "text",
            "required" => 0,
        ],
        [
            "key" => "crafted_layout_hero_content",
            "name" => "content",
            "label" => "Content",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 1,
        ],
        [
            "key" => "crafted_layout_hero_buttons",
            "name" => "buttons",
            "label" => "Buttons",
            "type" => "repeater",
            "sub_fields" => [
                [
                    "key" => "crafted_layout_hero_button",
                    "name" => "button",
                    "label" => "Button",
                    "type" => "link",
                    "required" => 0,
                ],
                [
                    "key" => "crafted_layout_hero_button_color",
                    "name" => "button_color",
                    "label" => "Button Color",
                    "type" => "select",
                    "instructions" => "Select the button color style",
                    "required" => 0,
                    "choices" => [
                        "primary" => "Primary Color",
                        "secondary" => "Secondary Color",
                        "outline" => "Outline",
                        "dark" => "Dark",
                        "light" => "Light",
                        "accent" => "Accent Color",
                        "teal" => "Teal",
                    ],
                    "default_value" => "primary",
                ],
            ],
            "min" => 1,
            "max" => 2,
        ],
    ],

    "min" => "",
    "max" => "",
];
