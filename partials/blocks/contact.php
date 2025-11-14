<!-- Contact Section -->
<?php
$anchor = get_sub_field('anchor');
$description = get_sub_field('description');
$top_title = get_sub_field('top_title');
$contact_form_shortcode = get_sub_field('contact_form');
$background_image = get_sub_field('background_image');

// Meta Option fields
$address = crafted_get_business_address();
$email = crafted_get_business_email();
$phone = crafted_get_business_phone();
?>
<section class="contact-cta bg-<?php echo ($background_image) ? '' : 'info-subtle' ?>" style="background-image: url('<?php echo esc_url($background_image); ?>);" id="<?php echo esc_attr($anchor); ?>">
    <div class="container">
        <div class="contact-cta__wrapper">
            <!-- Left: Contact Form -->
            <div class="contact-cta__form">
                <?php echo wp_kses_post($top_title); ?>
                <div class="form-wrapper">
                    <?php echo do_shortcode($contact_form_shortcode); ?>
                </div>
            </div>

            <!-- Right: Text Content -->
            <div class="contact-cta__content">
                <?php echo wp_kses_post($description); ?>
                <ul class="contact-cta__info-list list-unstyled">
                    <?php if ($address) : ?>
                        <li class="contact-cta__info-item d-flex align-items-start mb-3">
                            <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                            <span><?php echo esc_html($address); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                        <li class="contact-cta__info-item d-flex align-items-center mb-3">
                            <i class="fas fa-phone-alt me-3"></i>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="text-decoration-none text-dark"><?php echo esc_html($phone); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                        <li class="contact-cta__info-item d-flex align-items-center mb-3">
                            <i class="fas fa-envelope me-3"></i>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="text-decoration-none text-dark"><?php echo esc_html($email); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>