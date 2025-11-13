<!-- Team Section -->
<?php
$anchor = get_sub_field('anchor') ? 'id="' . esc_attr(get_sub_field('anchor')) . '"' : '';
$description = get_sub_field('description');
?>
<section class="team-section my-5" <?php echo $anchor; ?>>
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <?php if ($description): ?>
                    <div class="team-description">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4 text-lg-end d-none">
                <div class="navigation-buttons d-inline-flex">
                    <button class="nav-btn" id="prevBtn">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button class="nav-btn" id="nextBtn">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- CSS Grid Container -->
        <div class="team-container" id="teamContainer">
            <?php
            if (have_rows('items')):
                while (have_rows('items')) : the_row();
                    $name = get_sub_field('name');
                    $role = get_sub_field('role');
                    $photo = get_sub_field('photo');
                    $bio = get_sub_field('bio');
            ?>
                    <!-- Team Member -->
                    <div class="team-item">
                        <div class="team-card">
                            <div class="team-card-image" style="background-image: url(<?php echo esc_url($photo['url']); ?>);">
                                <div class="team-card-content">
                                    <h3 class="team-card-name"><?php echo esc_html($name); ?></h3>
                                    <p class="team-card-role"><?php echo esc_html($role); ?></p>
                                </div>
                            </div>
                            <div class="team-card-overlay">
                                <div class="overlay-content-top">
                                    <h3 class="overlay-name"><?php echo esc_html($name); ?></h3>
                                    <p class="overlay-role"><?php echo esc_html($role); ?></p>
                                    <p class="overlay-bio"><?php echo esc_html($bio); ?></p>
                                </div>
                                <div class="overlay-social">
                                    <?php
                                    if (have_rows('social_links')):
                                        while (have_rows('social_links')) : the_row();
                                            $platform = get_sub_field('platform');
                                            $url = get_sub_field('url');

                                            // Icon mapping
                                            $icons = [
                                                'linkedin' => 'fab fa-linkedin-in',
                                                'twitter' => 'fab fa-twitter',
                                                'instagram' => 'fab fa-instagram',
                                                'facebook' => 'fab fa-facebook-f',
                                                'github' => 'fab fa-github',
                                            ];

                                            if (isset($icons[$platform]) && $url):
                                    ?>
                                                <a href="<?php echo esc_url($url); ?>" class="social-icon" target="_blank" rel="noopener noreferrer">
                                                    <i class="<?php echo esc_attr($icons[$platform]); ?>"></i>
                                                </a>
                                    <?php
                                            endif;
                                        endwhile;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>