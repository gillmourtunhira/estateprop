<?php
// show the template part only for properties post type single pages
if (is_singular('properties')) :
    get_template_part('template-parts/related-posts');
endif;
?>
<!-- Footer -->
<!-- footer.php or footer section -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <!-- Opening Hours -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Opening hours</h5>
                <?php
                $opening_times = crafted_get_opening_times();
                $days = array(
                    'monday' => 'Mon-Fri',
                    'saturday' => 'Sat-Sun'
                );
                ?>
                <?php if (!empty($opening_times['monday_closed']) || !empty($opening_times['monday_from'])): ?>
                    <p class="footer-hours">
                        Mon-Thurs
                        <?php if (!empty($opening_times['monday_closed'])): ?>
                            Closed
                        <?php else: ?>
                            <?php echo esc_html($opening_times['monday_from']); ?> - <?php echo esc_html($opening_times['monday_to']); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>

                <?php if (empty($opening_times['friday_closed']) || !empty($opening_times['friday_opening'])): ?>
                    <p class="footer-hours">
                        Friday
                        <?php if (!empty($opening_times['friday_closed'])): ?>
                            Closed
                        <?php else: ?>
                            <?php echo esc_html($opening_times['friday_from']); ?> - <?php echo esc_html($opening_times['friday_to']); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($opening_times['saturday_closed']) || !empty($opening_times['saturday_from'])): ?>
                    <p class="footer-hours">
                        Sat-Sun
                        <?php if (!empty($opening_times['saturday_closed'])): ?>
                            Closed
                        <?php else: ?>
                            <?php echo esc_html($opening_times['saturday_from']); ?> - <?php echo esc_html($opening_times['saturday_to']); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Find Us -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Find Us</h5>
                <?php if (crafted_get_business_address()): ?>
                    <p class="footer-address"><?php echo nl2br(esc_html(crafted_get_business_address())); ?></p>
                <?php endif; ?>

                <?php if (crafted_get_business_phone()): ?>
                    <p class="footer-contact">
                        <a href="tel:<?php echo esc_attr(crafted_get_business_phone()); ?>">
                            <?php echo esc_html(crafted_get_business_phone()); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (crafted_get_business_email()): ?>
                    <p class="footer-contact">
                        <a href="mailto:<?php echo esc_attr(crafted_get_business_email()); ?>">
                            <?php echo esc_html(crafted_get_business_email()); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Property Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-heading">Property</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/apartments')); ?>">Apartments</a></li>
                    <li><a href="<?php echo esc_url(home_url('/villas')); ?>">Villa's</a></li>
                    <li><a href="<?php echo esc_url(home_url('/houses')); ?>">Houses</a></li>
                    <li><a href="<?php echo esc_url(home_url('/commercial')); ?>">Commercial</a></li>
                </ul>
            </div>

            <!-- General Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-heading">Links</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url(home_url('/property')); ?>">Property</a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-2 col-md-12">
                <h5 class="footer-heading">Newsletter</h5>
                <p class="newsletter-text">Subscribe to our newletter</p>
                <?php if (crafted_get_newsletter_shortcode()): ?>
                    <div class="newsletter-form">
                        <?php echo do_shortcode(crafted_get_newsletter_shortcode()); ?>
                    </div>
                <?php else: ?>
                    <form class="newsletter-form-default">
                        <div class="input-group">
                            <input type="email" id="email" class="form-control" placeholder="Your email" aria-label="Email">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright mb-0">
                        <?php if (crafted_get_copyright()): ?>
                            <?php echo wp_kses_post(crafted_get_copyright()); ?>
                        <?php else: ?>
                            &copy;Copyright Real Estate <?php echo date('Y'); ?>. Design by Figma.guru
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="social-icons">
                        <?php
                        $social = crafted_get_social_links();
                        if ($social['facebook']):
                        ?>
                            <a href="<?php echo esc_url($social['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($social['x']): ?>
                            <a href="<?php echo esc_url($social['x']); ?>" target="_blank" rel="noopener" aria-label="X">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($social['instagram']): ?>
                            <a href="<?php echo esc_url($social['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($social['youtube']): ?>
                            <a href="<?php echo esc_url($social['youtube']); ?>" target="_blank" rel="noopener" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($social['linkedin']): ?>
                            <a href="<?php echo esc_url($social['linkedin']); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>