<?php

/**
 * Contact Block
 */

return [
    "key" => "crafted_layout_contact",
    "name" => "contact",
    "label" => "Contact Block",
    "display" => "block",

    "sub_fields" => [
        [
            "key" => "crafted_layout_contact_anchor",
            "name" => "anchor",
            "label" => "Anchor",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
                "width" => "30",
            ],
        ],
        [
            "key" => "crafted_layout_contact_description",
            "name" => "description",
            "label" => "Description",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 0,
        ],
        [
            "key" => "crafted_layout_contact_details_description",
            "name" => "details_description",
            "label" => "Details Description",
            "type" => "text",
            "required" => 0,
        ],
        [
            "key" => "crafted_layout_contact_detail_email",
            "name" => "detail_email",
            "label" => "Detail Email",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
                "width" => "33",
            ],
        ],
        [
            "key" => "crafted_layout_contact_detail_phone",
            "name" => "detail_phone",
            "label" => "Detail Phone",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
                "width" => "33",
            ],
        ],
        [
            "key" => "crafted_layout_contact_detail_address",
            "name" => "detail_address",
            "label" => "Detail Address",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
                "width" => "33",
            ],
        ],
        [
            "key" => "crafted_layout_contact_form_social_links_description",
            "name" => "social_links_description",
            "label" => "Social Links Description",
            "type" => "text",
            "required" => 0,
        ],
        [
            "key" => "crafted_layout_contact_form_social_links",
            "name" => "social_links",
            "label" => "Social Links",
            "type" => "repeater",
            "required" => 0,
            "sub_fields" => [
                [
                    "key" => "crafted_layout_contact_form_social_links_icon",
                    "name" => "icon",
                    "label" => "Icon",
                    "type" => "text",
                    "required" => 0,
                ],
                [
                    "key" => "crafted_layout_contact_form_social_links_url",
                    "name" => "url",
                    "label" => "URL",
                    "type" => "text",
                    "required" => 0,
                ],
            ],
        ],
        [
            "key" => "crafted_layout_contact_form_top_title",
            "name" => "top_title",
            "label" => "Top Title",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 0,
        ],
        [
            "key" => "crafted_layout_contact_form",
            "name" => "contact_form",
            "label" => "Contact Form",
            "type" => "textarea",
            "placeholder" => "Enter contact form shortcode here, e.g. [gillmour_contact_form]",
            "required" => 0,
            "wrapper" => [
                "width" => "100",
            ],
        ],
    ],
];
