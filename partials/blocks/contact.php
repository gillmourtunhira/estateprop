<!-- Contact Section -->
<?php
$anchor = get_sub_field('anchor');
$description = get_sub_field('description');
$details_description = get_sub_field('details_description');
$detail_email = get_sub_field('detail_email');
$detail_phone = get_sub_field('detail_phone');
$detail_address = get_sub_field('detail_address');
$social_links_description = get_sub_field('social_links_description');
$social_links = get_sub_field('social_links');
$contact_form = get_sub_field('contact_form');
$form_top_title = get_sub_field('top_title');
?>
<section id="<?php echo $anchor; ?>" class="contact py-5">
    <div class="container">
        <div class="section-header">
            <?php echo $description; ?>
        </div>
        <div class="contact-content">
            <div class="contact-info">
                <h3 class="contact-subtitle"><?php echo $details_description; ?></h3>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><?php echo $detail_email; ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span><?php echo $detail_phone; ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo $detail_address; ?></span>
                    </div>
                </div>
                <div class="social-links">
                    <h4 class="social-title"><?php echo $social_links_description; ?></h4>
                    <div class="social-buttons">
                        <?php foreach ($social_links as $social_link) { ?>
                            <a href="<?php echo $social_link['url']; ?>" target="_blank" class="btn btn-outline btn-icon" alt="View Social Profile" aria-label="View Social Profile" role="link">
                                <i class="fab <?php echo $social_link['icon']; ?>"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="contact-form-wrapper">
                <div class="card">
                    <div class="card-header">
                        <?php echo $form_top_title; ?>
                    </div>
                    <div class="card-content">
                        <?php echo do_shortcode('[gillmour_contact_form]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>