<?php

// Include ACF
require_once get_template_directory() . "/inc/acf.php";
require_once get_template_directory() .
    "/inc/classes/class-crafted-nav-walker.php";
require_once get_template_directory() . "/inc/classes/Bootstrap_Helper.php";
require_once get_template_directory() . "/inc/classes/class-shortcodes.php";
require_once get_template_directory() . "/inc/utilities.php";
require_once get_template_directory() . "/inc/post-types.php";
require_once get_template_directory() . "/inc/theme-options.php";

new CraftedTheme_Shortcodes();

/**
 * Enqueue theme styles and scripts.
 */
function crafted_theme_enqueue_assets()
{
    // Fonts
    wp_enqueue_style(
        "google-fonts",
        "https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap",
        [],
        "1.0.0",
        "all",
    );
    // Font Awesome
    wp_enqueue_style(
        "font-awesome",
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css",
        [],
        "6.4.0",
    );
    // Enqueue styles
    wp_enqueue_style(
        "crafted-theme-style",
        get_template_directory_uri() . "/dist/css/main.css",
        ["google-fonts", "font-awesome"],
        time(),
        "all",
    );

    // Enqueue scripts
    wp_enqueue_script(
        "crafted-theme-script",
        get_template_directory_uri() . "/dist/js/main.js",
        ["jquery"],
        "1.0.0",
        true,
    );

    wp_enqueue_script(
        'load-more',
        get_template_directory_uri() . '/assets/js/load-more.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'properties-ajax',
        get_template_directory_uri() . '/assets/js/properties-ajax.js',
        ['jquery'],
        null,
        true
    );

    // Localize once with all necessary data
    wp_localize_script('properties-ajax', 'propertiesAjax', [
        'rest_url' => esc_url(rest_url('/')),
        'ajax_url' => admin_url('admin-ajax.php'),
        'filter_nonce' => wp_create_nonce('property_filter_nonce'),
        'load_more_nonce' => wp_create_nonce('load_more_nonce'),
        'posts_per_page' => get_option('posts_per_page'),
        'text' => [
            'loading' => __('Loading...', 'crafted-theme'),
            'no_more' => __('No more properties', 'crafted-theme'),
            'error' => __('Something went wrong', 'crafted-theme'),
        ]
    ]);
}
add_action("wp_enqueue_scripts", "crafted_theme_enqueue_assets");

// Theme setup
function crafted_setup()
{
    // Add default posts and comments RSS feed links to head
    add_theme_support("automatic-feed-links");

    // Enable title tag support
    add_theme_support("title-tag");

    // Enable post thumbnails
    add_theme_support("post-thumbnails");

    // Enable excerpt
    add_theme_support("excerpt");

    // Register navigation menus
    register_nav_menus([
        "primary" => esc_html__("Primary Menu", "crafted-theme"),
        "footer" => esc_html__("Footer Menu", "crafted-theme"),
        "properties" => esc_html__("Properties Menu", "crafted-theme"),
    ]);

    // HTML5 support
    add_theme_support("html5", [
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
    ]);

    // Add custom logo support
    add_theme_support("custom-logo", [
        "height" => 100,
        "width" => 400,
        "flex-height" => true,
        "flex-width" => true,
    ]);

    // Add editor styles
    add_theme_support("editor-styles");
    add_editor_style("dist/css/editor-style.min.css");

    // Add support for responsive embeds
    add_theme_support("responsive-embeds");

    // Add support for full and wide blocks
    add_theme_support("align-wide");
}
add_action("after_setup_theme", "crafted_setup");

function remove_features()
{
    // Remove featured image on pages in editor
    remove_post_type_support("page", "thumbnail");
    remove_post_type_support("page", "page-attributes");
}
add_action("init", "remove_features");

// SVG support
function add_svg_support($file_types)
{
    $new_filetypes = [];
    $new_filetypes["svg"] = "image/svg+xml";
    return array_merge($file_types, $new_filetypes);
}
add_filter("upload_mimes", "add_svg_support");

function svg_sanitization($data, $file, $filename, $mimes)
{
    // Check if file is SVG
    if (!empty($data["ext"]) && $data["ext"] === "svg") {
        if ($data["type"] === "image/svg+xml") {
            // Validate SVG content
            $content = file_get_contents($file);
            // Basic security check - look for script tags or dangerous attributes
            if (
                preg_match("/.*?<script.*?>.*?<\/script>.*?/is", $content) ||
                preg_match(
                    "/.*?(onload|onerror|onclick|onmouseover)=.*?/is",
                    $content,
                )
            ) {
                $data["ext"] = "";
                $data["type"] = "";
            }
        }
    }
    return $data;
}
add_filter("wp_check_filetype_and_ext", "svg_sanitization", 10, 4);

function display_svg_in_media_library()
{
    echo '
    <style>
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action("admin_head", "display_svg_in_media_library");

function crafted_excerpt_length($length)
{
    return 20;
}
add_filter("excerpt_length", "crafted_excerpt_length");

// Add theme support for custom logo
function theme_setup()
{
    add_theme_support("custom-logo", [
        "height" => 50,
        "width" => 200,
        "flex-height" => true,
        "flex-width" => true,
    ]);
}
add_action("after_setup_theme", "theme_setup");

// Pre-get posts
add_action("pre_get_posts", function ($query) {
    if (!is_admin() && $query->is_main_query()) {
        $query->set("posts_per_page", 3);
    }
});

/**
 * Get fields from ACF block saved in post content
 */
function get_acf_block_data($post_id, $block_name = 'acf/property-block')
{
    $content = get_post_field('post_content', $post_id);

    if (empty($content)) return [];

    $blocks = parse_blocks($content);

    foreach ($blocks as $block) {
        if (
            !empty($block['blockName']) &&
            $block['blockName'] === $block_name &&
            !empty($block['attrs']['data'])
        ) {
            return $block['attrs']['data'];
        }
    }

    return [];
}

/**
 * Set site title to replace wordpress logo on login screen
 *
 * @param string $title
 * @return string
 */

function crafted_login_logo()
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            <?php if (has_custom_logo()) : ?>background-image: url(<?php echo esc_url($logo[0]); ?>);
            background-size: contain;
            width: 100%;
            height: 100px;
            <?php else : ?>background-image: none;
            width: auto;
            height: auto;
            text-indent: 0;
            <?php endif; ?>
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'crafted_login_logo');

function crafted_login_headertext($text)
{
    if (has_custom_logo()) {
        return '';
    } else {
        return get_bloginfo('name');
    }
}
add_filter('login_headertext', 'crafted_login_headertext');
function crafted_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'crafted_login_logo_url');
