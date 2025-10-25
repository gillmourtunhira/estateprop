<?php
$anchor = get_sub_field("anchor");
$background_colour = get_sub_field("background_colour");
$top_content = get_sub_field("top_content");
$content = get_sub_field("content");
$image_alignment = get_sub_field("image_alignment");
$image = get_sub_field("image");
?>

<!-- Media-Content Section -->
<section <?php if($anchor){ ?>id="<?php echo $anchor; ?>"<?php } ?> class="media-content bg-<?php echo $background_colour; ?> py-5">
        <div class="container media-content-wrapper">
            <?php if($top_content){ ?>
                <div class="section-header">
                    <?php echo $top_content; ?>
                </div>
            <?php } ?>
            <div class="row align-items-center justify-content-between g-0">
                <div class="col-12 col-lg-5 content-container p-lg-0 <?php echo ($image_alignment == 'right' ? 'order-lg-0' : 'order-lg-1') ?>">
                    <?php echo $content; ?>
                </div>
                <div class="col-12 col-lg-6 media-container">
                    <?php $image_id = Bootstrap_Image_Helper::getAttachmentIdFromUrl($image); ?>
                    <?php echo Bootstrap_Image_Helper::renderImage(
                            $image_id, 
                            'img-fluid media-img', 
                            [
                                'sm' => 'thumbnail',
                                'md' => 'medium',
                                'lg' => 'medium',
                                'xl' => 'large' 
                            ]
                        );
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Media-Content Section -->