<?php
$anchor = get_sub_field('anchor');
$content = get_sub_field('content');

$accordion_id = 'accordion-' . get_the_ID() . '-' . get_row_index();
?>

<section <?php if ($anchor) { ?>id="<?php echo esc_attr($anchor); ?>"<?php } ?> class="accordion-block py-5">
  <div class="container">
  <div class="accordion accordion-flush" id="<?php echo esc_attr($accordion_id); ?>">
  <?php
    if (have_rows('items')) :
      while (have_rows('items')) : the_row();
      $title = get_sub_field('title');
      $content = get_sub_field('content');
      $accordion_id = 'accordion-' . get_the_ID() . '-' . get_row_index();
  ?>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($accordion_id); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr($accordion_id); ?>">
          <?php echo esc_html($title); ?>
      </button>
    </h2>
    <div id="<?php echo esc_attr($accordion_id); ?>" class="accordion-collapse collapse" data-bs-parent="#<?php echo esc_attr($accordion_id); ?>">
      <div class="accordion-body">
        <?php echo wp_kses_post($content); ?>
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