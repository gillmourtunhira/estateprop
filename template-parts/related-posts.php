<div class="container related-posts--content">
    <?php
    $related_title = crafted_get_related_posts_content_title();
    $related_posts_content = crafted_get_related_posts_content();
    if ($related_title) {
        echo '<h2 class="fw-bold related-posts--title mb-3">' . esc_html($related_title) . '</h2>';
    }
    if ($related_posts_content) {
        echo '<div class="related-posts--text mb-4">' . wp_kses_post(wpautop($related_posts_content)) . '</div>';
    }
    ?>
</div>
<div class="container related-posts properties-grid__container my-4">
    <?php
    echo do_shortcode('[properties_cards number_of_properties="3" post_id="' . get_the_ID() . '"]');
    ?>
</div>