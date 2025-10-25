<?php
$background_color = get_sub_field("background_color");
$background_file = get_sub_field("background_file");
$content_alignment = get_sub_field("content_alignment");
$tagline = get_sub_field("tagline");
$content = get_sub_field("content");
$screen_size = get_sub_field("screen_size");
$buttons = get_sub_field("buttons");

$file_url = $background_file['url'] ?? '';
$file_type = $background_file['mime_type'] ?? '';
$is_video = strpos($file_type, 'video') !== false;
?>
<section
    class="hero hero-<?php echo esc_attr($screen_size); ?> <?php echo (!$file_url ? 'bg-' . esc_attr($background_color) : ''); ?>">

    <?php if ($file_url): ?>
        <div class="hero__background">
            <?php if ($is_video): ?>
                <video autoplay muted loop playsinline>
                    <source src="<?php echo esc_url($file_url); ?>" type="<?php echo esc_attr($file_type); ?>">
                </video>
            <?php else: ?>
                <picture>
                    <img src="<?php echo esc_url($file_url); ?>" alt="" loading="lazy">
                </picture>
            <?php endif; ?>
            <div class="hero__overlay"></div>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="hero-content hero-text-<?php echo esc_attr($content_alignment); ?>">
            <?php if ($tagline): ?>
                <div class="badge"><?php echo esc_html($tagline); ?></div>
            <?php endif; ?>

            <div class="hero-content-top">
                <?php echo $content; ?>
            </div>

            <?php if ($buttons): ?>
                <div class="hero-buttons">
                    <?php foreach ($buttons as $button_row):
                        $button = $button_row["button"];
                        $button_color = $button_row["button_color"];
                        if ($button): ?>
                            <a href="<?php echo esc_url($button["url"]); ?>"
                                class="btn btn-lg btn-<?php echo esc_attr($button_color); ?>"
                                aria-label="<?php echo esc_attr($button["title"]); ?>">
                                <?php echo esc_html($button["title"]); ?>
                            </a>
                    <?php endif;
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="properties-grid my-5">
    <!-- Properties Filter -->
    <div class="properties-filter-cta">
        <form id="property-filter" class="filter-box bg-white shadow-sm rounded-4 d-flex align-items-center gap-3 flex-wrap" method="POST">

            <!-- Category -->
            <div class="flex-grow-1">
                <select name="category" class="form-select">
                    <option value="">Category</option>
                    <?php
                    $categories = get_terms([
                        'taxonomy' => 'property_category',
                        'hide_empty' => false,
                    ]);
                    if (!empty($categories) && !is_wp_error($categories)) {
                        foreach ($categories as $cat) {
                            echo '<option value="' . esc_attr($cat->slug) . '">' . esc_html($cat->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>


            <!-- Property Type -->
            <div class="flex-grow-1">
                <select name="property_type" class="form-select">
                    <option value="">Property Type</option>
                    <?php
                    $types = get_terms([
                        'taxonomy' => 'property_type',
                        'hide_empty' => false,
                    ]);
                    if (!empty($types) && !is_wp_error($types)) {
                        foreach ($types as $type) {
                            echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>


            <!-- Location -->
            <div class="flex-grow-1">
                <select name="location" class="form-select">
                    <option value="">Location</option>
                    <?php
                    $locations = get_terms([
                        'taxonomy' => 'property_location',
                        'hide_empty' => false,
                    ]);
                    if (!empty($locations) && !is_wp_error($locations)) {
                        foreach ($locations as $loc) {
                            echo '<option value="' . esc_attr($loc->slug) . '">' . esc_html($loc->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="button" id="reset-filter" class="btn btn-light btn-icon border">
                <i class="fas fa-sliders-h"></i>
            </button>

            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center px-4">
                <i class="fas fa-search me-2"></i> SEARCH
            </button>
        </form>
    </div>
    <!-- Properties Filter-->
    <div class="container">
        <div class="content py-5">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum quaerat saepe quod ut laboriosam! Delectus voluptatibus quaerat fuga laudantium fugiat in nulla, accusamus eaque magnam saepe quibusdam natus sunt temporibus.
        </div>
    </div>
</section>