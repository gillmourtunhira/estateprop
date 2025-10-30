<?php
$post_id = get_the_ID();
$user_id = get_the_author_meta('ID');

// ACF Fields
$description_content = get_sub_field('description_content');
$suburb_address = get_sub_field('suburb_address');
$price = get_sub_field('price');
$agent_info = get_sub_field('agent_info');
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
        <div class="row align-items-start">
            <!-- Left: Main content -->
            <div class="col-lg-8">
                <!-- Property Header -->
                <div class="property-header mb-4">
                    <?php // var_dump($price);
                    ?>
                    <span class="badge bg-<?php echo ($status === 'Sold') ? 'danger' : (($status === 'For Sale') ? 'success' : 'primary'); ?>"><?php echo $status; ?></span>
                    <h1 class="property-title mt-2"><?php the_title(); ?></h1>
                    <p class="property-location text-muted mb-2"><?php echo wp_kses_post($suburb_address); ?></p>
                    <div class="property-price fw-bold fs-4 text-dark">
                        $<?php echo format_large_number($price); ?> <span class="text-muted fs-6">/ $<?php echo calculate_price_per_sqm(intval($price), intval($total_area)); ?> per sq.m</span>
                    </div>
                </div>

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
                                                echo (is_bool($parking) ? 'Yes' : 'No');
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
                                                echo (is_bool($wifi) ? 'Yes' : 'No');
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
                                                echo (is_bool($cable_tv) ? 'Yes' : 'No');
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
                <div class="col-12 my-4 d-none">
                    <div class="small-map rounded-4 overflow-hidden">
                        <img src="https://picsum.photos/id/57/400/200?text=Map" class="img-fluid w-100" alt="Map preview">
                    </div>
                </div>
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

                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your mail">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your phone">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send message</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>