<?php
add_action('acf/init', 'crafted_acf_init');
function crafted_acf_init()
{
    // require_once __DIR__ . '/acf/buttons.php';
    require_once __DIR__ . '/acf/flexible_content.php';

    // Add agent user fields
    add_agent_user_fields();
}

// Add ACF fields for Agent users
function add_agent_user_fields()
{
    acf_add_local_field_group([
        'key' => 'group_agent_fields',
        'title' => 'Agent Information',
        'fields' => [
            [
                'key' => 'field_agent_phone',
                'label' => 'Phone Number',
                'name' => 'agent_phone',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'key' => 'field_agent_whatsapp',
                'label' => 'WhatsApp Number',
                'name' => 'agent_whatsapp',
                'type' => 'text',
                'instructions' => 'Include country code (e.g., +263771234567)',
                'required' => 0,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'key' => 'field_agent_whatsapp_link',
                'label' => 'WhatsApp Link',
                'name' => 'agent_whatsapp_link',
                'type' => 'url',
                'instructions' => 'Full WhatsApp link (e.g., https://wa.me/263771234567)',
                'required' => 0,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'key' => 'field_agent_email',
                'label' => 'Contact Email',
                'name' => 'agent_contact_email',
                'type' => 'email',
                'instructions' => 'Public contact email (if different from login email)',
                'required' => 0,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'key' => 'field_agent_bio',
                'label' => 'Agent Bio',
                'name' => 'agent_bio',
                'type' => 'textarea',
                'rows' => 4,
                'required' => 0,
            ],
            [
                'key' => 'field_agent_photo',
                'label' => 'Agent Photo',
                'name' => 'agent_photo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'required' => 0,
            ],
            [
                'key' => 'field_agent_license',
                'label' => 'License Number',
                'name' => 'agent_license',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'key' => 'field_agent_company',
                'label' => 'Company/Agency',
                'name' => 'agent_company',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'user_role',
                    'operator' => '==',
                    'value' => 'agent',
                ],
            ],
        ],
        'position' => 'normal',
        'style' => 'default',
    ]);
}
