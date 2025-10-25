<?php

/**
 * Posts Cards Block
 */

return [
    "key" => "crafted_layout_posts_cards",
    "name" => "posts_cards",
    "label" => "Posts Cards Block",
    "display" => "block",
    "sub_fields" => [
        [
            "key" => "crafted_layout_posts_cards_anchor",
            "name" => "anchor",
            "label" => "Posts Cards Anchor",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
                "width" => "30",
            ],
        ],
        [
            "key" => "crafted_layout_posts_cards_description",
            "name" => "cards_description",
            "label" => "Cards Description",
            "type" => "wysiwyg",
            "required" => 0,
            "media_upload" => 0,
        ],
        [
            "key" => "crafted_layout_posts_selected_posts",
            "label" => "Selected Posts",
            "name" => "selected_posts",
            "type" => "relationship",
            "required" => 0,
            "post_type" => "post",
            "return_format" => "id",
        ],
        [
            "key" => "crafted_layout_posts_order",
            "label" => "Posts Order",
            "name" => "posts_order",
            "type" => "select",
            "required" => 0,
            "wrapper" => [
                "width" => "25",
            ],
            "choices" => [
                "asc" => "Ascending",
                "desc" => "Descending",
            ],
        ],
        [
            "key" => "crafted_layout_posts_hide_author_avatar",
            "label" => "Hide Author Avatar",
            "name" => "hide_author_avatar",
            "type" => "true_false",
            "required" => 0,
            "wrapper" => [
                "width" => "25",
            ],
        ],
    ],
];
