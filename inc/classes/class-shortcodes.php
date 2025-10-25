<?php
if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

class CraftedTheme_Shortcodes
{
    public function __construct()
    {
        add_shortcode("posts", [$this, "crafted_posts_shortcode"]);
        // You can register more here
        // add_shortcode( 'projects', [ $this, 'projects_shortcode' ] );
    }

    public function crafted_posts_shortcode($atts)
    {
        // Default attributes
        $atts = shortcode_atts(
            [
                "id" => "",
                "order" => "DESC",
            ],
            $atts,
            "posts",
        );

        // Safeguard for ACF
        if (!function_exists("get_sub_field")) {
            return "";
        }

        // Get Fields
        $hide_author_avatar = get_sub_field("hide_author_avatar");
        $selected_posts = get_sub_field("selected_posts") ?: [];
        $number_of_posts = !empty($selected_posts) ? count($selected_posts) : 3;

        // Fallback: get latest posts if none selected
        $query_args = [
            "post_type" => "post",
            "posts_per_page" => $number_of_posts,
            "orderby" => "date",
            "order" => $atts["order"],
        ];

        if (!empty($selected_posts)) {
            $query_args["post__in"] = $selected_posts;
            $query_args["orderby"] = "post__in";
        }

        $query = new WP_Query($query_args);

        ob_start();
        if ($query->have_posts()): ?>
            <?php while ($query->have_posts()):
                $query->the_post();
            ?>
                <?php get_template_part('template-parts/post', 'card', $query); ?>
            <?php
            endwhile; ?>
        <?php endif;
        wp_reset_postdata();
        $output = ob_get_clean();
        return $output;
    }
}
