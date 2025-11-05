<!-- Contact Section -->
<?php
$anchor = get_sub_field('anchor');
$description = get_sub_field('description');
$top_title = get_sub_field('top_title');
$contact_form_shortcode = get_sub_field('contact_form');
$background_image = get_sub_field('background_image');
?>
<section class="contact-cta" style="background-image: url('<?php echo esc_url($background_image); ?>);" id="<?php echo esc_attr($anchor); ?>">
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
            </div>
        </div>
    </div>
</section>