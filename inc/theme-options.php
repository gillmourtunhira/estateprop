<?php

/**
 * Theme Options Page
 * Adds a Theme Options page in the WordPress admin to manage business information,
 */

// Add Theme Options menu
function crafted_add_theme_options_page()
{
    add_theme_page(
        'Theme Options',
        'Theme Options',
        'manage_options',
        'crafted-options',
        'crafted_render_options_page'
    );
}
add_action('admin_menu', 'crafted_add_theme_options_page');

// Register settings
function crafted_register_settings()
{
    register_setting('crafted_options', 'crafted_opening_times');
    register_setting('crafted_options', 'crafted_business_address');
    register_setting('crafted_options', 'crafted_business_email');
    register_setting('crafted_options', 'crafted_business_phone');
    register_setting('crafted_options', 'crafted_social_x');
    register_setting('crafted_options', 'crafted_social_facebook');
    register_setting('crafted_options', 'crafted_social_linkedin');
    register_setting('crafted_options', 'crafted_social_instagram');
    register_setting('crafted_options', 'crafted_social_youtube');
    register_setting('crafted_options', 'crafted_copyright');
    register_setting('crafted_options', 'crafted_newsletter_shortcode');
    register_setting('crafted_options', 'crafted_related_posts_content_title');
    register_setting('crafted_options', 'crafted_related_posts_content');
}
add_action('admin_init', 'crafted_register_settings');

// Render the options page
function crafted_render_options_page()
{
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('crafted_options');
            do_settings_sections('crafted_options');
            ?>

            <table class="form-table">
                <!-- Opening Times -->
                <tr>
                    <th scope="row">
                        <label>Opening Times</label>
                    </th>
                    <td>
                        <?php
                        $opening_times = get_option('crafted_opening_times', array());
                        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

                        foreach ($days as $day) {
                            $day_lower = strtolower($day);
                            $from = isset($opening_times[$day_lower . '_from']) ? $opening_times[$day_lower . '_from'] : '';
                            $to = isset($opening_times[$day_lower . '_to']) ? $opening_times[$day_lower . '_to'] : '';
                            $closed = isset($opening_times[$day_lower . '_closed']) ? $opening_times[$day_lower . '_closed'] : '';
                        ?>
                            <div style="margin-bottom: 10px;">
                                <strong style="display: inline-block; width: 100px;"><?php echo esc_html($day); ?>:</strong>
                                <label>
                                    <input type="checkbox"
                                        name="crafted_opening_times[<?php echo esc_attr($day_lower); ?>_closed]"
                                        value="1"
                                        <?php checked($closed, '1'); ?>>
                                    Closed
                                </label>
                                <span style="margin: 0 10px;">or</span>
                                <input type="time"
                                    name="crafted_opening_times[<?php echo esc_attr($day_lower); ?>_from]"
                                    value="<?php echo esc_attr($from); ?>"
                                    style="width: 100px;">
                                <span style="margin: 0 5px;">to</span>
                                <input type="time"
                                    name="crafted_opening_times[<?php echo esc_attr($day_lower); ?>_to]"
                                    value="<?php echo esc_attr($to); ?>"
                                    style="width: 100px;">
                            </div>
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <!-- Business Address -->
                <tr>
                    <th scope="row">
                        <label for="crafted_business_address">Business Address</label>
                    </th>
                    <td>
                        <textarea id="crafted_business_address"
                            name="crafted_business_address"
                            rows="3"
                            class="large-text"><?php echo esc_textarea(get_option('crafted_business_address')); ?></textarea>
                    </td>
                </tr>

                <!-- Business Email -->
                <tr>
                    <th scope="row">
                        <label for="crafted_business_email">Business Email</label>
                    </th>
                    <td>
                        <input type="email"
                            id="crafted_business_email"
                            name="crafted_business_email"
                            value="<?php echo esc_attr(get_option('crafted_business_email')); ?>"
                            class="regular-text">
                    </td>
                </tr>

                <!-- Business Phone -->
                <tr>
                    <th scope="row">
                        <label for="crafted_business_phone">Business Phone</label>
                    </th>
                    <td>
                        <input type="tel"
                            id="crafted_business_phone"
                            name="crafted_business_phone"
                            value="<?php echo esc_attr(get_option('crafted_business_phone')); ?>"
                            class="regular-text">
                    </td>
                </tr>

                <!-- Social Links -->
                <tr>
                    <th scope="row">
                        <label>Social Media Links</label>
                    </th>
                    <td>
                        <div style="margin-bottom: 10px;">
                            <label for="crafted_social_x" style="display: inline-block; width: 100px;">X (Twitter):</label>
                            <input type="url"
                                id="crafted_social_x"
                                name="crafted_social_x"
                                value="<?php echo esc_attr(get_option('crafted_social_x')); ?>"
                                class="regular-text"
                                placeholder="https://x.com/username">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="crafted_social_facebook" style="display: inline-block; width: 100px;">Facebook:</label>
                            <input type="url"
                                id="crafted_social_facebook"
                                name="crafted_social_facebook"
                                value="<?php echo esc_attr(get_option('crafted_social_facebook')); ?>"
                                class="regular-text"
                                placeholder="https://facebook.com/username">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="crafted_social_linkedin" style="display: inline-block; width: 100px;">LinkedIn:</label>
                            <input type="url"
                                id="crafted_social_linkedin"
                                name="crafted_social_linkedin"
                                value="<?php echo esc_attr(get_option('crafted_social_linkedin')); ?>"
                                class="regular-text"
                                placeholder="https://linkedin.com/company/username">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="crafted_social_instagram" style="display: inline-block; width: 100px;">Instagram:</label>
                            <input type="url"
                                id="crafted_social_instagram"
                                name="crafted_social_instagram"
                                value="<?php echo esc_attr(get_option('crafted_social_instagram')); ?>"
                                class="regular-text"
                                placeholder="https://instagram.com/username">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="crafted_social_youtube" style="display: inline-block; width: 100px;">YouTube:</label>
                            <input type="url"
                                id="crafted_social_youtube"
                                name="crafted_social_youtube"
                                value="<?php echo esc_attr(get_option('crafted_social_youtube')); ?>"
                                class="regular-text"
                                placeholder="https://youtube.com/@username">
                        </div>
                    </td>
                </tr>

                <!-- Related Posts Content Title -->
                <tr>
                    <th scope="row">
                        <label for="crafted_related_posts_content_title">Related Posts Content Title</label>
                    </th>
                    <td>
                        <input type="text"
                            id="crafted_related_posts_content_title"
                            name="crafted_related_posts_content_title"
                            value="<?php echo esc_attr(get_option('crafted_related_posts_content_title')); ?>"
                            class="large-text">
                        <p class="description">Title to display above related posts section.</p>
                    </td>
                </tr>

                <!-- Related Posts Content -->
                <tr>
                    <th scope="row">
                        <label for="crafted_related_posts_content">Related Posts Content</label>
                    </th>
                    <td>
                        <textarea id="crafted_related_posts_content"
                            name="crafted_related_posts_content"
                            rows="5"
                            class="large-text"><?php echo esc_textarea(get_option('crafted_related_posts_content')); ?></textarea>
                        <p class="description">Content to display above related posts section.</p>
                    </td>
                </tr>

                <!-- Copyright Text -->
                <tr>
                    <th scope="row">
                        <label for="crafted_copyright">Copyright Text</label>
                    </th>
                    <td>
                        <textarea id="crafted_copyright"
                            name="crafted_copyright"
                            rows="3"
                            class="large-text"><?php echo esc_textarea(get_option('crafted_copyright')); ?></textarea>
                        <p class="description">You can use HTML here. Example: &copy; 2025 Your Company Name. All rights reserved.</p>
                    </td>
                </tr>

                <!-- Newsletter Shortcode -->
                <tr>
                    <th scope="row">
                        <label for="crafted_newsletter_shortcode">Newsletter Form Shortcode</label>
                    </th>
                    <td>
                        <input type="text"
                            id="crafted_newsletter_shortcode"
                            name="crafted_newsletter_shortcode"
                            value="<?php echo esc_attr(get_option('crafted_newsletter_shortcode')); ?>"
                            class="large-text"
                            placeholder="[contact-form-7 id='123']">
                        <p class="description">Paste your newsletter form shortcode here.</p>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Helper functions to retrieve options in your theme
function crafted_get_opening_times()
{
    return get_option('crafted_opening_times', array());
}

function crafted_get_business_address()
{
    return get_option('crafted_business_address');
}

function crafted_get_business_email()
{
    return get_option('crafted_business_email');
}

function crafted_get_business_phone()
{
    return get_option('crafted_business_phone');
}

function crafted_get_social_links()
{
    return array(
        'x' => get_option('crafted_social_x'),
        'facebook' => get_option('crafted_social_facebook'),
        'linkedin' => get_option('crafted_social_linkedin'),
        'instagram' => get_option('crafted_social_instagram'),
        'youtube' => get_option('crafted_social_youtube'),
    );
}

function crafted_get_related_posts_content_title()
{
    return get_option('crafted_related_posts_content_title');
}

function crafted_get_related_posts_content()
{
    return get_option('crafted_related_posts_content');
}

function crafted_get_copyright()
{
    return get_option('crafted_copyright');
}

function crafted_get_newsletter_shortcode()
{
    return get_option('crafted_newsletter_shortcode');
}

// Example usage in your theme templates:
/*
// Display opening times
$opening_times = crafted_get_opening_times();
if (!empty($opening_times['monday_from'])) {
    echo 'Monday: ' . esc_html($opening_times['monday_from']) . ' - ' . esc_html($opening_times['monday_to']);
}

// Display business info
echo esc_html(crafted_get_business_phone());
echo esc_html(crafted_get_business_email());

// Display social links
$social = crafted_get_social_links();
if ($social['facebook']) {
    echo '<a href="' . esc_url($social['facebook']) . '">Facebook</a>';
}

// Display copyright
echo wp_kses_post(crafted_get_copyright());

// Display newsletter form
echo do_shortcode(crafted_get_newsletter_shortcode());
*/
?>