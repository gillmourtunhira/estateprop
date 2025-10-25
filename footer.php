<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-main">
                <h3 class="footer-title"><?php echo esc_html(
                                                get_bloginfo("name"),
                                            ); ?></h3>
                <p class="footer-description">
                    <?php echo esc_html(get_bloginfo("description")); ?>
                </p>
                <p class="footer-copyright">© 2025 <?php echo esc_html(
                                                        get_bloginfo("name"),
                                                    ); ?>. All rights reserved.</p>
            </div>
            <div class="footer-links">
                <?php if (has_nav_menu("footer")) {
                    wp_nav_menu([
                        "theme_location" => "footer",
                        "container" => false,
                        "menu_class" => "navbar-nav mx-auto",
                        "fallback_cb" => false,
                        "depth" => 1,
                    ]);
                } ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>