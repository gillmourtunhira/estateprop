<?php

/**
 * Team Cards Block
 */

return [
    "key" => "crafted_layout_team_cards",
    "name" => "team_cards",
    "label" => "Team Cards Block",
    "display" => "block",

    "sub_fields" => [
        [
            'key' => 'crafted_layout_team_cards_anchor',
            'name' => 'anchor',
            'label' => 'Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '30',
            ],
        ],
        [
            'key' => 'crafted_layout_team_cards_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'wysiwyg',
            'media_upload' => 0,
            'required' => 0,
        ],
        [
            'key' => 'crafted_layout_team_cards_items',
            'label' => 'Team Members',
            'name' => 'items',
            'type' => 'repeater',
            'required' => 0,
            'layout' => 'block',
            'sub_fields' => [
                [
                    'key' => 'crafted_layout_team_cards_item_name',
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '30',
                    ],
                ],
                [
                    'key' => 'crafted_layout_team_cards_item_role',
                    'label' => 'Role',
                    'name' => 'role',
                    'type' => 'text',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '70',
                    ],
                ],
                [
                    'key' => 'crafted_layout_team_cards_item_photo',
                    'label' => 'Photo',
                    'name' => 'photo',
                    'type' => 'image',
                    'required' => 0,
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'wrapper' => [
                        'width' => '25',
                    ],
                ],
                [
                    'key' => 'crafted_layout_team_cards_item_bio',
                    'label' => 'Bio',
                    'name' => 'bio',
                    'type' => 'textarea',
                    'media_upload' => 0,
                    'required' => 0,
                    'wrapper' => [
                        'width' => '75',
                    ],
                ],
                [
                    'key' => 'crafted_layout_team_cards_item_social_links',
                    'label' => 'Social Links',
                    'name' => 'social_links',
                    'type' => 'repeater',
                    'required' => 0,
                    'layout' => 'table',
                    'sub_fields' => [
                        [
                            'key' => 'crafted_layout_team_cards_item_social_link_platform',
                            'label' => 'Platform',
                            'name' => 'platform',
                            'type' => 'select',
                            'choices' => [
                                'twitter' => 'Twitter',
                                'linkedin' => 'LinkedIn',
                                'instagram' => 'Instagram',
                            ],
                            'required' => 0,
                        ],
                        [
                            'key' => 'crafted_layout_team_cards_item_social_link_url',
                            'label' => 'URL',
                            'name' => 'url',
                            'type' => 'url',
                            'required' => 0,
                        ],
                    ],
                    "min" => 3,
                    "max" => 3,
                ],
            ],
        ],
    ],
    "min" => "",
    "max" => "",
];
