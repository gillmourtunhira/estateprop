<?php
$query = isset($args) ? $args : null;
$hide_author_avatar = get_sub_field("hide_author_avatar");
$author_id = $query->post->post_author;
?>
<div class="col-sm-12 col-md-6 col-lg-4 mb-4">
    <div class="card text-dark card-has-bg click-col" style="background-image:url('<?php echo get_the_post_thumbnail_url(
                                                                                        $query->post->ID,
                                                                                    ); ?>');">
        <img class="card-img d-none" src="<?php echo get_the_post_thumbnail_url(
                                                $query->post->ID,
                                            ); ?>" alt="<?php echo get_the_title($query->post->ID,); ?>">
        <div class="card-img-overlay d-flex flex-column">
            <div class="card-body">
                <small class="card-meta mb-2 text-decoration-none text-white"><?php echo get_the_category_list(
                                                                                    ", ",
                                                                                    "hello",
                                                                                    $query->post->ID,
                                                                                ); ?></small>
                <h4 class="card-title mt-2">
                    <a class="text-white text-decoration-none" href="<?php echo get_the_permalink(
                                                                            $query->post->ID,
                                                                        ); ?>"><?php echo get_the_title($query->post->ID,); ?></a>
                </h4>
                <small class="text-white"><i class="far fa-clock"></i> <?php echo get_the_date(
                                                                            "F j, Y",
                                                                        ); ?></small>
            </div>
            <div class="card-footer">
                <?php if (!$hide_author_avatar): ?>
                    <div class="d-flex media align-items-center gap-2">
                        <img class="mr-3 rounded-circle" src="<?php echo esc_url(
                                                                    get_avatar_url($author_id),
                                                                ); ?>" alt="Generic placeholder image" style="max-width:50px">
                        <div class="media-body">
                            <h6 class="my-0 text-white d-block"><?php
                                                                $author_id = $query->post->post_author;
                                                                echo get_the_author_meta(
                                                                    "display_name",
                                                                    $author_id,
                                                                );
                                                                ?></h6>
                            <?php
                            $description = get_the_author_meta(
                                "description",
                                $query->post->ID,
                            );
                            if (!empty($description)) {
                                echo "<small>" .
                                    $description .
                                    "</small>";
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>