<?php

/**
 * Testimonials Block
 */

return [
    'key' => 'crafted_testimonials_block',
    'name' => 'testimonials',
    'label' => 'Testimonials Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => 'crafted_testimonials_anchor',
            'name' => 'anchor',
            'label' => 'Testimonials Anchor',
            'type' => 'text',
            'required' => 0,
            'wrapper' => [
                'width' => '50',
            ],
        ],
        [
            'key' => 'crafted_testimonials_top_content',
            'name' => 'top_content',
            'label' => 'Top Content',
            'type' => 'wysiwyg',
            'media_upload' => 0,
            'required' => 0,
        ],
        [
            'key' => 'crafted_testimonials_list',
            'name' => 'testimonials_list',
            'label' => 'Testimonials List',
            'type' => 'repeater',
            'required' => 0,
            'min' => 1,
            'layout' => 'block',
            'sub_fields' => [
                [
                    'key' => 'crafted_testimonial_quote',
                    'name' => 'quote',
                    'label' => 'Quote',
                    'type' => 'textarea',
                    'required' => 0,
                ],
                [
                    'key' => 'crafted_testimonial_author',
                    'name' => 'author',
                    'label' => 'Author',
                    'type' => 'text',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '33',
                    ],
                ],
                [
                    'key' => 'crafted_testimonial_author_title',
                    'name' => 'author_title',
                    'label' => 'Author Title',
                    'type' => 'text',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '33',
                    ],
                ],
                [
                    'key' => 'crafted_testimonial_author_image',
                    'name' => 'author_image',
                    'label' => 'Author Image',
                    'type' => 'file',
                    'mime_types' => 'jpg,jpeg,png,gif,svg',
                    'required' => 0,
                    'wrapper' => [
                        'width' => '33',
                    ],
                ],
            ],

            'min' => 0,
            'max' => 6,
        ],
    ],
];
