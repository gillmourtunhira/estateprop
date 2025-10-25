<?php

// Media-Content Block

return [
    "key" => "crafted_layout_media_content",
    "name" => "media-content",
    "label" => "Media Content Block",
    "display" => "block",
    "sub_fields" => [
        [
            "key" => "crafted_layout_media_content_anchor",
            "name" => "anchor",
            "label" => "Anchor",
            "type" => "text",
            "required" => 0,
            "wrapper" => [
              "width" => "50",
            ],
          ],
          [
            "key" => "crafted_layout_media_content_background_colour",
            "name" => "background_colour",
            "label" => "Background Colour",
            "type" => "select",
            "required" => 0,
            "instructions" => "Select the background colour",
            "choices" => [
              "white" => "White",
              "black" => "Black",
              "green" => "Green",
              "primary" => "Primary",
              "secondary" => "Secondary",
              "teal" => "Teal",
            ],
            "default_value" => "white",
            "wrapper" => [
              "width" => "50",
            ],
          ],
          [
            "key" => "crafted_layout_media_content_image_alignment",
            "name" => "image_alignment",
            "label" => "Image Alignment",
            "type" => "select",
            "required" => 0,
            "choices" => [
              "left" => "Left",
              "right" => "Right",
            ],
            "default_value" => "left",
            "wrapper" => [
              "width" => "50",
            ],
          ],
          [
            "key" => "crafted_layout_media_content_image",
            "name" => "image",
            "label" => "Image",
            "type" => "file",
            "mime_types" => "jpg,jpeg,png,gif,webp,avif",
            "required" => 0,
            "wrapper" => [
              "width" => "50",
            ],
            "return_format" => "url",
          ],
          [
            "key" => "crafted_layout_media_content_top_content_option",
            "name" => "top_content_option",
            "label" => "Top Content Option",
            "instructions" => "Select if you want to add top content",
            "type" => "true_false",
            "ui" => true,
            "required" => 0,
            "ui_on_text" => "Yes",
            "ui_off_text" => "No",
          ],
          [
            "key" => "crafted_layout_media_content_top_content",
            "name" => "top_content",
            "label" => "Top Content",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 0,
            "conditional_logic" => [
              [
                [
                  "field" => "crafted_layout_media_content_top_content_option",
                  "operator" => "==",
                  "value" => "1",
                ],
              ],
            ],
          ],
          [
            "key" => "crafted_layout_media_content_content",
            "name" => "content",
            "label" => "Content",
            "type" => "wysiwyg",
            "media_upload" => 0,
            "required" => 1,
          ],
    ],
];