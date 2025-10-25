<?php
/*
 * Utilities
 */

// Register AJAX Actions
function load_more_posts_ajax()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $posts_per_page = 3;

    // Calculate offset based on page number
    // Page 1 shows posts 1-3 (offset 0)
    // Page 2 shows posts 4-6 (offset 3)
    // Page 3 shows posts 7-9 (offset 6)
    $offset = ($paged - 1) * $posts_per_page;

    $query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => $order,
    ]);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            get_template_part('template-parts/post', 'card', $query);
        endwhile;
    endif;

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax');
