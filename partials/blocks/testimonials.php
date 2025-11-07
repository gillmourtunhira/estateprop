<!-- Testimonials Block -->
<?php
$anchor = get_sub_field('anchor');
?>
<section class="testimonials my-5" <?php if ($anchor) : ?>id="<?php echo esc_attr($anchor); ?>" <?php endif; ?>>
    <div class="container testimonials-wrapper">
        <div class="label"><span class="badge text-bg-light">Testimonials</span></div>
        <?php if (get_sub_field('top_content')) : ?>
            <div class="top-content text-center my-4">
                <?php echo wp_kses_post(get_sub_field('top_content')); ?>
            </div>
        <?php endif; ?>
        <?php if (have_rows('testimonials_list')) : ?>
            <div class="testimonials-list">
                <?php while (have_rows('testimonials_list')) : the_row(); ?>
                    <div class="testimonial-item">
                        <div class="card h-100">
                            <div class="card-body">
                                <span><i class="fas fa-quote-left fa-2x text-info mb-3"></i></span>
                                <?php if (get_sub_field('quote')) : ?>
                                    <blockquote class="blockquote mb-3">
                                        <p class="mb-0"><?php echo wp_kses_post(get_sub_field('quote')); ?></p>
                                    </blockquote>
                                <?php endif; ?>
                                <?php if (get_sub_field('author') || get_sub_field('author_title')) : ?>
                                    <footer class="blockquote-footer">
                                        <div class="author-image">
                                            <?php if (get_sub_field('author_image')) :
                                                $author_image = get_sub_field('author_image'); ?>
                                                <img src="<?php echo esc_url($author_image['url']); ?>" alt="<?php echo esc_attr($author_image['alt']); ?>" class="rounded-circle">
                                            <?php endif; ?>
                                        </div>
                                        <div class="author-details">
                                            <?php if (get_sub_field('author')) : ?>
                                                <span class="author-name"><?php echo esc_html(get_sub_field('author')) . ','; ?></span>
                                            <?php endif; ?>
                                            <?php if (get_sub_field('author_title')) : ?>
                                                <span class="author-title"><?php echo esc_html(get_sub_field('author_title')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </footer>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- End Testimonials Block -->