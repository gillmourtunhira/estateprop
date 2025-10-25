<?php
/**
 * Content
 */

return [
  'key' => 'crafted_layout_content',
  'name' => 'content',
  'label' => 'Content Block',
  'display' => 'block',

  'sub_fields' => [
    [
      'key' => 'crafted_layout_content_value',
      'label' => 'Content',
      'name' => 'content',
      'type' => 'wysiwyg',
      'required' => 1,
      'tabs' => 'all',
      'toolbar' => 'full',
      'media_upload' => 0,
    ],
  ],

  'min' => '',
  'max' => '',
];
