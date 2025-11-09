<?php
$top_content = get_sub_field('top_content');
?>
<section class="properties-grid my-5">
    <!-- Properties Filter -->
    <div class="properties-filter-cta">
        <form id="property-filter" class="filter-box bg-white shadow-sm rounded-4 d-flex align-items-center gap-3 flex-wrap" method="POST">

            <!-- Category -->
            <div class="flex-grow-1">
                <select name="category" class="form-select">
                    <option value="">Category</option>
                    <?php
                    $categories = get_terms([
                        'taxonomy' => 'property_category',
                        'hide_empty' => false,
                    ]);
                    if (!empty($categories) && !is_wp_error($categories)) {
                        foreach ($categories as $cat) {
                            echo '<option value="' . esc_attr($cat->slug) . '">' . esc_html($cat->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>


            <!-- Property Type -->
            <div class="flex-grow-1">
                <select name="property_type" class="form-select">
                    <option value="">Property Type</option>
                    <?php
                    $types = get_terms([
                        'taxonomy' => 'property_type',
                        'hide_empty' => false,
                    ]);
                    if (!empty($types) && !is_wp_error($types)) {
                        foreach ($types as $type) {
                            echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>


            <!-- Location -->
            <div class="flex-grow-1">
                <select name="location" class="form-select">
                    <option value="">Location</option>
                    <?php
                    $locations = get_terms([
                        'taxonomy' => 'property_location',
                        'hide_empty' => false,
                    ]);
                    if (!empty($locations) && !is_wp_error($locations)) {
                        foreach ($locations as $loc) {
                            echo '<option value="' . esc_attr($loc->slug) . '">' . esc_html($loc->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center px-4">
                <i class="fas fa-search me-2"></i> SEARCH
            </button>
            <button type="button" id="reset-filter-button" class="btn btn-danger" style="display: none;">
                <i class="fa-solid fa-ban"></i>
            </button>
        </form>
    </div>
    <!-- Properties Filter-->
    <div class="container">
        <div class="content py-4 text-center">
            <?php
            if ($top_content) {
                echo wp_kses_post(wpautop($top_content));
            }
            ?>
        </div>
        <div class="properties-grid__container" id="property-results">
            <?php
            if (is_singular('properties')) {
                $post_id = get_the_ID();
            } else {
                $post_id = '';
            }
            echo do_shortcode('[properties_cards number_of_properties="' . esc_attr(get_sub_field('number_of_properties')) . '" post_id="' . esc_attr($post_id) . '"]');
            ?>
        </div>
    </div>
</section>