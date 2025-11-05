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
            "key" => "crafted_layout_contact_background_image",
            "name" => "background_image",
            "label" => "Background Image",
            "type" => "file",
            "mime_types" => "jpg,jpeg,png,gif",
            "return_format" => "url",
            "required" => 0,
            "wrapper" => [
                "width" => "70",
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
            "placeholder" => "Enter contact form shortcode here, e.g. [contact-form-7 id=123 title=Contact form]",
            "required" => 0,
            "wrapper" => [
                "width" => "100",
            ],
        ],
    ],
];
