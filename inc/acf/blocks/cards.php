<?php

// Cards Block
return [
    "key" => "crafted_layout_cards",
    "name" => "cards",
    "label" => "Cards Block",
    "display" => "block",

    "sub_fields" => [
        [
            'key' => 'crafted_layout_cards_anchor',
            'name' => 'anchor',
            'label' => 'Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
              'width' => '30',
            ],
        ],
        [
            'key' => 'crafted_layout_cards_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'wysiwyg',
            'media_upload' => 0,
            'required' => 0,
        ],
        [
            'key' => 'crafted_layout_cards_items',
            'label' => 'Cards',
            'name' => 'items',
            'type' => 'repeater',
            'required' => 0,
            'layout' => 'block',
            'sub_fields' => [
                [
                    'key' => 'crafted_layout_cards_item_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'wysiwyg',
                    'media_upload' => 0,
                    'required' => 1,
                ],
                [
                    'key' => 'crafted_layout_cards_item_image_icon_option',
                    'label' => 'Icon Option',
                    'name' => 'icon_option',
                    'type' => 'true_false',
                    'required' => 0,
                    'ui' => 1,
                    'ui_on_text' => 'Icon',
                    'ui_off_text' => 'Image',
                    'default_value' => 1,
                    'wrapper' => [
                        'width' => '20',
                    ],
                ],
                [
                    'key' => 'crafted_layout_cards_item_image_font_awesome_icon',
                    'label' => 'Font-Awesome Icon',
                    'name' => 'font_awesome_icon',
                    'type' => 'text',
                    'placeholder' => __('fa-globe'),
                    'required' => 0,
                    'wrapper' => [
                        'width' => '20',
                    ],
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'crafted_layout_cards_item_image_icon_option',
                                'operator' => '==',
                                'value' => '1',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'crafted_layout_cards_item_image_icon_image',
                    'label' => 'Image',
                    'name' => 'icon_image',
                    'type' => 'file',
                    'mime_types' => 'jpg,jpeg,png,svg,avif,webp',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '20',
                    ],
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'crafted_layout_cards_item_image_icon_option',
                                'operator' => '==',
                                'value' => '0',
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'crafted_layout_cards_item_link',
                    'label' => 'Link',
                    'name' => 'link',
                    'type' => 'link',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '40',
                    ],
                ],
            ],
        ],
    ]
];