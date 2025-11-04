<?php
if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

class CraftedTheme_Shortcodes
{
    public function __construct()
    {
        add_shortcode("posts", [$this, "crafted_posts_shortcode"]);
        add_shortcode('properties_cards', [$this, 'property_cards_from_api_shortcode']);
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

    /**
     * Properties Cards Shortcode
     *
     * Usage: [properties_cards]
     * Calls your REST endpoint and renders property cards
     */
    public function property_cards_from_api_shortcode($atts)
    {
        $atts = shortcode_atts([
            'endpoint' => rest_url('properties/v1/featured'), // default endpoint
            'per_row'  => 3, // optional, not used directly here but kept for future styling hooks
            'number_of_properties' => 3, // optional, can be used to modify endpoint query
            'post_id' => 0, // optional, can be used to modify endpoint query
        ], $atts, 'property_cards_from_api');

        // Build the endpoint URL dynamically if needed
        $endpoint = add_query_arg([
            'per_page' => intval($atts['number_of_properties']),
        ], $atts['endpoint']);

        // Call the REST endpoint
        $response = wp_remote_get($atts['endpoint'], [
            'timeout' => 10,
        ]);

        // Error handling
        if (is_wp_error($response)) {
            return '<p class="property-cards-error">Unable to load properties.</p>';
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (empty($data) || json_last_error() !== JSON_ERROR_NONE) {
            return '<p class="property-cards-error">Invalid properties data.</p>';
        }

        // Filter out the current property (if post_id is provided)
        if (!empty($atts['post_id'])) {
            $data = array_filter($data, function ($p) use ($atts) {
                return isset($p['id']) && intval($p['id']) !== intval($atts['post_id']);
            });
        }

        // Limit the number of properties (in case API doesn’t handle per_page)
        $data = array_slice($data, 0, intval($atts['number_of_properties']));

        // Build markup
        ob_start();
        ?>
        <?php foreach ($data as $p) :
            // safe defaults
            $id        = isset($p['id']) ? intval($p['id']) : 0;
            $title     = isset($p['title']) ? $p['title'] : '';
            $permalink = isset($p['permalink']) ? $p['permalink'] : '#';
            $image     = !empty($p['image']) ? $p['image'] : get_template_directory_uri() . '/assets/images/placeholder.png';
            $suburb    = isset($p['suburb']) ? $p['suburb'] : '';
            $price     = isset($p['price']) ? $p['price'] : '';
            $formatted_price = $price !== '' && is_numeric($price) ? number_format_i18n((float) $price) : $price;
            $details   = isset($p['property_details'][0]) && is_array($p['property_details'][0]) ? $p['property_details'][0] : [];

            $bedrooms  = isset($details['bedrooms_detail']) ? $details['bedrooms_detail'] : (isset($p['bedrooms_detail']) ? $p['bedrooms_detail'] : '');
            $bathrooms = isset($details['bathrooms_detail']) ? $details['bathrooms_detail'] : (isset($p['bathrooms_detail']) ? $p['bathrooms_detail'] : '');
            $area      = isset($details['total_area_detail']) ? $details['total_area_detail'] : (isset($p['total_area_detail']) ? $p['total_area_detail'] : '');
            $garages   = isset($details['garages_detail']) ? $details['garages_detail'] : (isset($p['garages_detail']) ? $p['garages_detail'] : '');
        ?>
            <a href="<?php echo esc_url($permalink); ?>" class="property-card-link text-decoration-none text-underline-none" aria-labelledby="property-title-<?php echo esc_attr($id); ?>">
                <div class="property-card">
                    <div class="property-card__image">
                        <?php
                        $image_src = '';
                        if (get_the_post_thumbnail_url($id, 'full')) {
                            $image_src = get_the_post_thumbnail_url($id, 'full');
                        } else {
                            $image_src = $image;
                        }
                        ?>
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($title); ?>">
                        <?php
                        // Get category terms for the property by id
                        $terms = get_the_terms($id, 'property_category');
                        if ($terms && !is_wp_error($terms)) {
                            $term_names = wp_list_pluck($terms, 'name');
                            if (!empty($term_names)) {
                                $term_badge_color = '';
                                // set badge color based on category name
                                switch (strtolower($term_names[0])) {
                                    case 'sold':
                                        $term_badge_color = 'bg-danger';
                                        break;
                                    case 'for rent':
                                        $term_badge_color = 'bg-primary';
                                        break;
                                    default:
                                        $term_badge_color = 'bg-success';
                                        break;
                                }
                                echo '<span class="property-badge ' . esc_attr($term_badge_color) . '">' . esc_html($term_names[0]) . '</span>';
                            } else {
                                echo '<span class="property-badge">For Sale</span>';
                            }
                        } else {
                            echo '<span class="property-badge">For Sale</span>';
                        }
                        ?>
                    </div>

                    <div class="property-card__content">

                        <h3 id="property-title-<?php echo esc_attr($id); ?>" class="property-title text-dark"><?php echo esc_html($title); ?></h3>
                        <?php if ($suburb) : ?>
                            <p class="property-address"><?php echo esc_html($suburb); ?></p>
                        <?php endif; ?>

                        <?php if ($formatted_price) : ?>
                            <div class="property-price text-dark">$<?php echo esc_html($formatted_price); ?></div>
                        <?php endif; ?>

                        <div class="property-features">
                            <div class="feature text-dark">
                                <div class="feature-icon-detail">
                                    <i class="fa-solid fa-bed" aria-hidden="true"></i>
                                    <span><?php echo esc_html($bedrooms); ?></span>
                                </div>
                                <small>Bedrooms</small>
                            </div>
                            <div class="feature text-dark">
                                <div class="feature-icon-detail">
                                    <i class="fa-solid fa-bath" aria-hidden="true"></i>
                                    <span><?php echo esc_html($bathrooms); ?></span>
                                </div>
                                <small>Bathrooms</small>
                            </div>
                            <div class="feature text-dark">
                                <div class="feature-icon-detail">
                                    <i class="fa-regular fa-square" aria-hidden="true"></i>
                                    <span><?php echo esc_html($area); ?></span>
                                </div>
                                <small>Total area</small>
                            </div>
                            <div class="feature text-dark">
                                <div class="feature-icon-detail">
                                    <i class="fa-solid fa-warehouse" aria-hidden="true"></i>
                                    <span><?php echo esc_html($garages); ?></span>
                                </div>
                                <small>Garages</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
<?php

        return ob_get_clean();
    }
}
