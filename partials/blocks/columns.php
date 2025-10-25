<?php
$anchor = get_sub_field('anchor') ? 'id="' . esc_attr(get_sub_field('anchor')) . '"' : '';
$top_content = get_sub_field('top_content');
?>
<section class="content-columns my-5" <?php echo $anchor; ?>>
    <div class="container">
        <?php if ($top_content) : ?>
            <div class="row mb-4">
                <div class="col-12 top-content">
                    <?php echo wp_kses_post($top_content); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_rows('content_columns')) : ?>
            <div class="row columns">
                <?php while (have_rows('content_columns')) : the_row();
                    $column = get_sub_field('column');
                ?>
                    <div class="col-12 col-md-6 col-lg-4 column">
                        <?php echo wp_kses_post($column); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

</section>