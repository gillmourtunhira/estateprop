<?php

/**
 * Property Card Template
 */
?>
<div class="property-card">
    <a href="<?php the_permalink(); ?>" class="property-card-link">
        <div class="property-card__image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-property.jpg" alt="Default property image">
            <?php endif; ?>
            <?php
            $property_status = get_field('property_status');
            if ($property_status) : ?>
                <span class="property-badge"><?php echo esc_html($property_status); ?></span>
            <?php endif; ?>
        </div>

        <div class="property-card__content">
            <h3 class="property-title"><?php the_title(); ?></h3>
            <?php
            $address = get_field('address');
            if ($address) : ?>
                <p class="property-address"><?php echo esc_html($address); ?></p>
            <?php endif; ?>

            <?php
            $price = get_field('price');
            if ($price) : ?>
                <div class="property-price">$<?php echo esc_html(number_format($price)); ?></div>
            <?php endif; ?>

            <div class="property-features">
                <?php
                $bedrooms = get_field('bedrooms');
                if ($bedrooms) : ?>
                    <div class="feature">
                        <i class="fa-solid fa-bed"></i>
                        <span><?php echo esc_html($bedrooms); ?></span>
                        <small>Bedrooms</small>
                    </div>
                <?php endif; ?>

                <?php
                $bathrooms = get_field('bathrooms');
                if ($bathrooms) : ?>
                    <div class="feature">
                        <i class="fa-solid fa-bath"></i>
                        <span><?php echo esc_html($bathrooms); ?></span>
                        <small>Bathrooms</small>
                    </div>
                <?php endif; ?>

                <?php
                $total_area = get_field('total_area');
                if ($total_area) : ?>
                    <div class="feature">
                        <i class="fa-regular fa-square"></i>
                        <span><?php echo esc_html($total_area); ?></span>
                        <small>Total area</small>
                    </div>
                <?php endif; ?>

                <?php
                $garages = get_field('garages');
                if ($garages) : ?>
                    <div class="feature">
                        <i class="fa-solid fa-warehouse"></i>
                        <span><?php echo esc_html($garages); ?></span>
                        <small>Garages</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div>