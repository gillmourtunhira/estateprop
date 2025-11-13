<?php
$anchor = get_sub_field("anchor");
$top_description = get_sub_field("description");
$items = get_sub_field("items");
?>
<!-- Cards Section -->
<section class="cards py-5" <?php if ($anchor) { ?>id="<?php echo $anchor; ?>" <?php } ?>>
    <div class="container">
        <div class="section-header text-center">
            <?php echo $top_description; ?>
        </div>
        <div class="cards-grid">
            <?php if ($items) : ?>
                <?php foreach ($items as $item) { ?>
                    <div class="card">
                        <div class="card-icon">
                            <?php if ($item['icon_option']) { ?>
                                <i class="fas <?php echo $item['font_awesome_icon']; ?>"></i>
                            <?php } else { ?>
                                <img src="<?php echo $item['icon_image']['url']; ?>" alt="<?php echo $item['icon_image']['alt']; ?>" class="card-icon-img img-fluid">
                            <?php } ?>
                        </div>
                        <div class="description">
                            <?php echo $item['description']; ?>
                        </div>
                        <?php if ($item['link']) { ?>
                            <div class="link">
                                <a href="<?php echo $item['link']['url']; ?>" class="btn btn-primary rounded-3"><?php echo $item['link']['title'] ?></i></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Cards Section End -->