<?php
$anchor = get_sub_field("anchor");
$cards_description = get_sub_field("cards_description");
$posts_order = get_sub_field("posts_order");
?>

<section id="<?php echo esc_attr($anchor); ?>" class="posts-cards my-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ($cards_description): ?>
                    <div class="cards-description">
                        <?php echo wp_kses_post($cards_description); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <div class="row">
                    <?php echo do_shortcode('[posts count="3" order="' . $posts_order . '"]'); ?>
                </div>
            </div>
        </div>
    </div>
</section>