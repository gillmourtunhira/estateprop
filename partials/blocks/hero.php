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