<!-- Locations Block -->
<?php
$anchor = get_sub_field('anchor');
$description = get_sub_field('description');
?>
<section class="locations py-5 bg-white" id="<?php echo esc_attr($anchor); ?>">
    <div class="container locations-wrapper">
        <div class="top-content text-center mb-5">
            <?php if (!empty($description)) : ?>
                <div class="description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="locations-grid">
            <?php
            $terms = get_terms([
                'taxonomy' => 'property_location',
                'hide_empty' => false,
            ]);

            if (!empty($terms) && !is_wp_error($terms)) :
                foreach ($terms as $term) :
                    $term_image_id = get_term_meta($term->term_id, 'property_location_image', true);
                    $term_image_url = wp_get_attachment_image_url($term_image_id, 'large');
            ?>
                    <?php
                    $location_archive_link = get_post_type_archive_link('properties');
                    if ($location_archive_link) {
                        $location_archive_link = add_query_arg('location', $term->slug, $location_archive_link);
                    }
                    ?>
                    <div class="location-card" data-location="<?php echo esc_attr($term->slug); ?>" data-url="<?php echo esc_url($location_archive_link ?: '#'); ?>" style="cursor: pointer;">
                        <div class="location-image" style="background-image: url('<?php echo esc_url($term_image_url); ?>');">
                            <div class="overlay"></div>
                            <div class="location-info">
                                <h3 class="location-name"><?php echo esc_html($term->name); ?></h3>
                                <p class="property-count"><?php echo esc_html($term->count); ?> properties</p>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            else :
                echo '<p>No locations found.</p>';
            endif;
            ?>
        </div>
    </div>
</section>
<!-- End Locations Block -->