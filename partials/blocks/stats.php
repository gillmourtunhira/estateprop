<!-- Stats --->
<?php
$anchor = get_sub_field('anchor') ? 'id="' . esc_attr(get_sub_field('anchor')) . '"' : '';
$content = get_sub_field('content');
$items = get_sub_field('items');
?>
<section class="stats-section py-5" id="<?php echo esc_attr($anchor); ?>">
    <div class="container">
        <div class="row text-center gy-4">
            <?php
            if (!empty($items) && is_array($items)) {
                foreach ($items as $item) :
                    $icon = !empty($item['icon']) ? $item['icon'] : '';
                    $number = !empty($item['number']) ? $item['number'] : '';
                    $label = !empty($item['label']) ? $item['label'] : '';
            ?>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <i class="fa-solid fa-<?= $icon ?> mb-3"></i>
                            <h3 class="fw-bold mb-1"><?= $number ?></h3>
                            <p class="mb-0"><?= $label ?></p>
                        </div>
                    </div>
            <?php
                endforeach;
            }
            ?>
        </div>
    </div>
</section>