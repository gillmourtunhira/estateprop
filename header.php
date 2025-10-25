<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (!function_exists("_wp_render_title_tag")): ?>
        <title><?php echo esc_html(get_bloginfo("name")); ?></title>
    <?php endif; ?>
    <meta name="description" content="<?php echo esc_attr(
        get_bloginfo("description"),
    ); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header">
        <!-- Navbar Structure -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar">
            <div class="container">
                <!-- Brand/Logo -->
                <a class="navbar-brand" href="<?php echo esc_url(
                    home_url("/"),
                ); ?>">
                    <?php if (
                        function_exists("the_custom_logo") &&
                        has_custom_logo()
                    ) {
                        the_custom_logo();
                    } else {
                        echo get_bloginfo("name");
                    } ?>
                </a>

                <!-- Desktop Navigation -->
                <div class="collapse navbar-collapse">
                    <?php if (has_nav_menu("primary")) {
                        wp_nav_menu([
                            "theme_location" => "primary",
                            "container" => false,
                            "menu_class" => "navbar-nav mx-auto",
                            "fallback_cb" => false,
                            "depth" => 2,
                            "walker" => new Crafted_Nav_Walker(),
                        ]);
                    } ?>

                    <!-- Desktop CTA Button -->
                    <div class="d-none d-lg-block">
                        <a href="<?php echo esc_url(
                            get_permalink(get_page_by_path("get-started")),
                        ); ?>"
                           class="btn btn-success btn-get-started">
                            <?php _e("Get Started", "textdomain"); ?>
                        </a>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler d-lg-none" type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#mobileNavDrawer"
                        aria-controls="mobileNavDrawer"
                        aria-expanded="false"
                        aria-label="<?php _e(
                            "Toggle navigation",
                            "textdomain",
                        ); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- Mobile Side Drawer -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNavDrawer" aria-labelledby="mobileNavDrawerLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileNavDrawerLabel">
                    <?php echo get_bloginfo("name"); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php _e(
                    "Close",
                    "textdomain",
                ); ?>"></button>
            </div>
            <div class="offcanvas-body p-0">
                <?php if (has_nav_menu("primary")) {
                    wp_nav_menu([
                        "theme_location" => "primary",
                        "container" => "nav",
                        "container_class" => "nav flex-column mobile-nav",
                        "menu_class" => "",
                        "fallback_cb" => false,
                        "depth" => 1,
                        "walker" => new Crafted_Mobile_Nav_Walker(),
                    ]);
                } ?>

                <!-- Mobile CTA Button -->
                <div class="mobile-get-started">
                    <a href="<?php echo esc_url(
                        get_permalink(get_page_by_path("get-started")),
                    ); ?>"
                       class="btn btn-success btn-get-started w-100"
                       data-bs-dismiss="offcanvas">
                        <i class="fas fa-rocket me-2"></i><?php _e(
                            "Get Started",
                            "textdomain",
                        ); ?>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <?php wp_body_open(); ?>
    <main>
