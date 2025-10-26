<?php
$post_id = get_the_ID();

// ACF Fields
$description_content = get_sub_field('description_content');
$suburb_address = get_sub_field('suburb_address');
$price = get_sub_field('price');
$agent_info = get_sub_field('agent_info');

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
                    <span class="badge bg-<?php echo ($status === 'Sold') ? 'danger' : 'success'; ?>"><?php echo $status; ?></span>
                    <h1 class="property-title mt-2"><?php the_title(); ?></h1>
                    <p class="property-location text-muted mb-2"><?php echo wp_kses_post($suburb_address); ?></p>
                    <div class="property-price fw-bold fs-4 text-dark">
                        $<?php format_large_number($price); ?> <span class="text-muted fs-6">/ $1200 per sq.ft</span>
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

                <!-- Description -->
                <div class="property-description mb-5">
                    <?php
                    if ($description_content) : ?>
                        <h4>Description</h4>
                        <div class="description-content mt-3">
                            <?php echo wp_kses_post($description_content); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Property Details -->
                <div class="property-details">
                    <h4>Property details</h4>
                    <div class="details-grid mt-3">
                        <div class="detail-item">
                            <i class="fa-solid fa-ruler-combined"></i>
                            <span>Total area</span>
                            <strong>100 sq.ft</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-bed"></i>
                            <span>Bedrooms</span>
                            <strong>2</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-bath"></i>
                            <span>Bathrooms</span>
                            <strong>2</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Floor</span>
                            <strong>3rd</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-elevator"></i>
                            <span>Elevator</span>
                            <strong>Yes</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-square-parking"></i>
                            <span>Parking</span>
                            <strong>2</strong>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Contact Agent -->
            <div class="col-lg-4">
                <div class="col-12">
                    <div class="small-image rounded-4 overflow-hidden position-relative">
                        <img src="https://picsum.photos/id/42/400/200" class="img-fluid w-100" alt="Show all photos">
                        <div class="overlay d-flex flex-column align-items-center justify-content-center">
                            <i class="fa-solid fa-camera mb-1"></i>
                            <span>Show all<br><strong>12 photos</strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-4">
                    <div class="small-map rounded-4 overflow-hidden">
                        <img src="https://picsum.photos/id/57/400/200?text=Map" class="img-fluid w-100" alt="Map preview">
                    </div>
                </div>
                <div class="contact-agent bg-dark text-white p-4 rounded-4">
                    <h5 class="mb-4">Contact agent</h5>
                    <div class="agent-info d-flex align-items-center mb-4">
                        <div class="agent-photo rounded-circle overflow-hidden me-3" style="width: 60px; height: 60px;">
                            <img src="https://picsum.photos/id/1005/100/100" class="img-fluid w-100" alt="Agent photo">
                        </div>
                        <div>
                            <strong><?php echo ($agent_fullname) ? $agent_fullname : $author_name; ?></strong><br>
                            <small>(431) 402-2459</small><br>
                            <small class="text-white">rsamartin@optonline.net</small>
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