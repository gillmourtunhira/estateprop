<?php
$post_id = get_the_ID();
$user_id = get_the_author_meta('ID');

// ACF Fields
$description_content = get_sub_field('description_content');
$suburb_address = get_sub_field('suburb_address');
$price = get_sub_field('price');
$agent_info = get_sub_field('agent_info');
$longitude = get_sub_field('map_longitude');
$latitude = get_sub_field('map_latitude');
$property_details = get_sub_field('property_details');
// Get the total area from property details repeater field
$total_area = '';
if ($property_details && is_array($property_details)) {
    $first_row = $property_details[0];
    if (isset($first_row['total_area_detail'])) {
        $total_area = $first_row['total_area_detail'];
    }
}

$agent_fullname = '';
if ($agent_info) {
    $agent_fullname = $agent_info['user_firstname'] . ' ' . $agent_info['user_lastname'];
}

// Taxonomies
$property_category = get_the_terms($post_id, 'property_category');
$status = '';
if ($property_category && !is_wp_error($property_category)) {
    $status = $property_category[0]->name;
}
$property_type = get_the_terms($post_id, 'property_type');
$property_location = get_the_terms($post_id, 'property_location');

// Meta Data
$post_author_id = get_post_field('post_author', $post_id);
$author_name = get_the_author_meta('display_name', $post_author_id);
?>
<section class="single-property py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Property Header -->
                <div class="property-header mb-4">
                    <div class="property-header-details">
                        <span class="badge bg-<?php echo ($status === 'Sold') ? 'danger' : (($status === 'For Sale') ? 'success' : 'primary'); ?>"><?php echo $status; ?></span>
                        <h1 class="property-title mt-2"><?php the_title(); ?></h1>
                        <p class="property-location text-muted mb-2"><?php echo wp_kses_post($suburb_address); ?></p>
                    </div>
                    <div class="property-price fw-bold text-dark">
                        <h3>$<?php echo format_large_number($price); ?></h3>
                        <span class="text-muted fs-6">/ $<?php echo calculate_price_per_sqm(intval($price), intval($total_area)); ?> per sq.m</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-start">
            <!-- Left: Main content -->
            <div class="col-lg-8">
                <!-- Property Gallery -->
                <div class="property-gallery mb-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="main-image rounded-4 overflow-hidden">
                                <?php
                                $post_thumbnail_id = get_post_thumbnail_id($post_id);
                                if ($post_thumbnail_id) : ?>
                                    <img src="<?php echo esc_url(wp_get_attachment_image_url($post_thumbnail_id, 'large')); ?>" class="img-fluid w-100" alt="Main property image">
                                <?php endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Details -->
                <div class="property-details">
                    <h4>Property details</h4>
                    <div class="details-grid mt-3">

                        <?php
                        if (have_rows('property_details')) :
                            while (have_rows('property_details')) : the_row();
                                $total_area = get_sub_field('total_area_detail');
                                $bedrooms = get_sub_field('bedrooms_detail');
                                $bathrooms = get_sub_field('bathrooms_detail');
                                $floor = get_sub_field('floor_detail');
                                $garages = get_sub_field('garages_detail');
                                $parking = get_sub_field('parking_detail');
                                $construction_year = get_sub_field('construction_year_detail');
                                $wifi = get_sub_field('wifi_detail');
                                $cable_tv = get_sub_field('cable_tv_detail');
                        ?>
                                <!--You can loop through sub-fields here if needed-->
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-ruler-combined"></i>
                                        <span>Total area</span>
                                    </div>
                                    <div>
                                        <strong><?php echo esc_attr($total_area); ?> sqm</strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-bed"></i>
                                        <span>Bedrooms</span>
                                    </div>
                                    <div>
                                        <strong><?php echo esc_attr($bedrooms); ?></strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-bath"></i>
                                        <span>Bathrooms</span>
                                    </div>
                                    <div>
                                        <strong><?php echo esc_attr($bathrooms); ?></strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-layer-group"></i>
                                        <span>Floor</span>
                                    </div>
                                    <div>
                                        <strong><?php echo esc_attr($floor); ?></strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-square-parking"></i>
                                        <span>Parking</span>
                                    </div>
                                    <div>
                                        <strong><?php
                                                echo ($parking ? 'Yes' : 'No');
                                                ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-warehouse"></i>
                                        <span>Garages</span>
                                    </div>
                                    <div>
                                        <strong><?php echo esc_attr($garages); ?></strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-calendar-alt"></i>
                                        <span>Construction Year</span>
                                    </div>
                                    <div>
                                        <strong><?php echo esc_attr($construction_year); ?></strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-wifi"></i>
                                        <span>Wi-Fi</span>
                                    </div>
                                    <div>
                                        <strong><?php
                                                echo ($wifi ? 'Yes' : 'No');
                                                ?></strong>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="icon-label-wrapper">
                                        <i class="fa-solid fa-tv"></i>
                                        <span>Cable TV</span>
                                    </div>
                                    <div>
                                        <strong><?php
                                                echo ($cable_tv ? 'Yes' : 'No');
                                                ?></strong>
                                    </div>
                                </div>
                        <?php endwhile;
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Description -->
                <div class="property-description mt-5">
                    <?php
                    if ($description_content) : ?>
                        <h4>Description</h4>
                        <div class="description-content mt-3">
                            <?php echo wp_kses_post($description_content); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Local Anemities -->
                <section class="local-anemities my-5">
                    <?php
                    $top_label = get_sub_field('local_amenities_label');
                    $local_amenities = get_sub_field('local_amenities');
                    ?>
                    <div class="container px-0">
                        <?php if ($top_label) : ?>
                            <h5 class="fw-bold mb-4"><?php echo esc_html($top_label); ?></h5>
                        <?php endif; ?>

                        <?php if (!empty($local_amenities) && is_array($local_amenities)) : ?>

                            <?php
                            foreach ($local_amenities as $amenity) :
                            ?>
                                <div class="category mb-4">
                                    <h6 class="fw-semibold mb-3">
                                        <i class="fa-solid fa-<?= $amenity['amenity_category_icon'] ?> me-2 text-secondary"></i> <?= $amenity['amenity_category_label'] ?>
                                    </h6>
                                    <?php
                                    if (!empty($amenity['amenity_items']) && is_array($amenity['amenity_items'])) : ?>
                                        <ul class="list-unstyled mb-0">
                                            <?php foreach ($amenity['amenity_items'] as $item) : ?>
                                                <li class="d-flex justify-content-between border-bottom py-2">
                                                    <span><?= esc_attr__($item['amenity_name']) ?></span>
                                                    <span class="text-muted"><?= esc_attr__($item['amenity_distance']) ?> km(s)</span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        <?php endif; ?>
                    </div>
                </section>
                <!-- End Local Anemities-->
            </div>

            <!-- Right: Contact Agent -->
            <div class="col-lg-4">
                <div class="col-12">
                    <div class="small-image rounded-4 overflow-hidden position-relative">
                        <img src="<?php echo esc_url(wp_get_attachment_image_url($post_thumbnail_id, 'large')); ?>" class="img-fluid w-100" alt="Show all photos">

                        <div class="overlay d-flex flex-column align-items-center justify-content-center" id="open-gallery">
                            <?php
                            $gallery = get_sub_field('gallery');
                            $image_count = ($gallery) ? count($gallery) : 0;
                            ?>
                            <i class="fa-solid fa-camera mb-1"></i>
                            <h3 class="fw-bold mb-0">See all</h3>
                            <span><?php echo $image_count; ?> Photos</span>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade property-gallery" id="property-gallery" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content bg-dark text-white border-0">
                                <div class="modal-body p-0 position-relative">
                                    <button type="button" class="btn-close btn-close-white position-absolute end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                                    <div id="propertyGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php if ($gallery): $i = 0;
                                                foreach ($gallery as $image): ?>
                                                    <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                                        <img src="<?php echo esc_url($image['url']); ?>" class="d-block w-100" alt="Property Image">
                                                    </div>
                                            <?php $i++;
                                                endforeach;
                                            endif; ?>
                                        </div>

                                        <button class="carousel-control-prev" type="button" data-bs-target="#propertyGalleryCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#propertyGalleryCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Map -->
                <?php if (!empty($latitude && $longitude)) :
                    $api_key = crafted_get_google_maps_api_key();
                ?>
                    <div class="col-12 my-4">
                        <div class="small-map rounded-4 overflow-hidden">
                            <iframe
                                width="100%"
                                height="250"
                                style="border:0"
                                loading="lazy"
                                allowfullscreen
                                src="https://www.google.com/maps/embed/v1/view?key=<?php echo esc_attr($api_key); ?>&center=<?php echo esc_attr($latitude); ?>,<?php echo esc_attr($longitude); ?>&zoom=14&maptype=roadmap">
                            </iframe>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- End Map -->
                <div class="contact-agent bg-dark text-white my-4 p-4 rounded-4">
                    <h5 class="mb-4">Contact agent</h5>
                    <div class="agent-info d-flex align-items-center mb-4">
                        <div class="agent-photo rounded-circle overflow-hidden me-3" style="width: 60px; height: 60px;">
                            <?php
                            $agent_photo_url = '';
                            $agent_photo = get_user_meta($agent_info['ID'], 'agent_photo', true);
                            $photo = wp_get_attachment_image_src($agent_photo, 'thumbnail');
                            if ($photo) {
                                $agent_photo_url = $photo[0];
                            } else {
                                $agent_photo_url = get_avatar_url($agent_info['ID']);
                            }
                            ?>
                            <img src="<?php echo esc_url($agent_photo_url); ?>" class="img-fluid w-100" alt="Agent photo">
                        </div>
                        <div>
                            <strong><?php echo ($agent_fullname) ? $agent_fullname : $author_name; ?></strong><br>
                            <small><?php echo get_user_meta($agent_info['ID'], 'agent_phone', true); ?></small><br>
                            <small class="text-white">
                                <?php echo ($agent_info) ? $agent_info['user_email'] : get_user_meta($agent_info['ID'], 'agent_contact_email', true); ?>
                            </small>
                        </div>
                    </div>

                    <div class="agent-contact-form">
                        <?php
                        $agent_ct7_form = sanitize_text_field(get_user_meta($agent_info['ID'], 'agent_contact_form_shortcode', true));
                        if ($agent_ct7_form) :
                            echo do_shortcode($agent_ct7_form);
                        else :
                            echo '<p>Please contact the agent via the provided email or phone number.</p>';
                        endif;
                        ?>
                    </div>

                    <div class="whatsapp-button">
                        <?php
                        $whatsapp_phone = sanitize_text_field(get_user_meta($agent_info['ID'], 'agent_whatsapp', true));

                        if ($whatsapp_phone) :
                            $cleaned_phone = preg_replace('/\D+/', '', $whatsapp_phone); // Remove non-digit characters
                            $property_title = get_the_title();
                            $property_link = get_permalink();
                            $whatsapp_text = rawurlencode("Good day {$agent_fullname}, I want to enquire about property {$property_title}. You can view it here: {$property_link}");
                            $whatsapp_link = 'https://wa.me/+263' . $cleaned_phone . '?text=' . $whatsapp_text;
                        ?>
                            <a href="<?php echo esc_url($whatsapp_link); ?>" target="_blank" class="btn btn-success w-100">
                                <i class="fa-brands fa-whatsapp me-2"></i> Chat on WhatsApp
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <!--Share Button Grey background-->
                <div class="share-button mt-3 rounded-4 p-3 bg-light d-flex align-items-center justify-content-center border border-success">
                    <?php
                    $property_title = get_the_title();
                    $property_link = get_permalink();
                    $share_text = rawurlencode("Check out this property: {$property_title} - {$property_link}");
                    $twitter_share_link = 'https://twitter.com/intent/tweet?text=' . $share_text;
                    $facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($property_link);
                    $linkedin_share_link = 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode($property_link);
                    ?>
                    <span class="me-2">Share:</span>
                    <div class="share-links d-flex gap-2">
                        <a href="<?php echo esc_url($twitter_share_link); ?>" target="_blank" class="me-2">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="<?php echo esc_url($facebook_share_link); ?>" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="<?php echo esc_url($linkedin_share_link); ?>" target="_blank" class="ms-2">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>