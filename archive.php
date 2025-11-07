<?php
get_header();

/**
 * Template: Archive Properties
 * AJAX Filtering + Search + Pagination
 */
?>

<section class="properties-archive py-5">
    <div class="container">
        <!-- Top Search -->
        <div class="properties-archive__search mb-4">
            <input type="text" id="property-search" class="form-control" placeholder="Search by city...">
        </div>

        <div class="properties-archive__inner d-flex">
            <!-- Sidebar Filters -->
            <aside class="properties-archive__sidebar pe-4">
                <form id="property-filter-form">
                    <!-- Property Type -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title">Property Type</h5>
                        <div class="filter-options">
                            <?php
                            $types = get_terms([
                                'taxonomy' => 'property_type',
                                'hide_empty' => true,
                            ]);
                            if (!empty($types) && !is_wp_error($types)) {
                                foreach ($types as $type) {
                                    echo '<label><input type="checkbox" name="property_type[]" value="' . esc_attr($type->slug) . '"> ' . esc_html($type->name) . '</label>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title">Maximum Price</h5>
                        <div class="price-range">
                            <input type="range" id="price-range" min="0" max="500000" value="500000" step="10000">
                            <div id="price-value" class="price-value">Up to $500,000</div>
                        </div>
                    </div>

                    <!-- Bedrooms -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title">Bedrooms</h5>
                        <div class="filter-options filter-options--grid">
                            <label><input type="radio" name="bedrooms" value="1"> 1</label>
                            <label><input type="radio" name="bedrooms" value="2"> 2</label>
                            <label><input type="radio" name="bedrooms" value="3"> 3</label>
                            <label><input type="radio" name="bedrooms" value="4"> 4+</label>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title">Availability</h5>
                        <div class="filter-options">
                            <label><input type="radio" name="availability" value="ready"> Ready to Move</label>
                            <label><input type="radio" name="availability" value="6-months"> Within 6 Months</label>
                            <label><input type="radio" name="availability" value="1-year"> Within 1 Year</label>
                            <label><input type="radio" name="availability" value="more-year"> More Than 1 Year</label>
                        </div>
                    </div>

                    <!-- Reset -->
                    <button type="button" id="reset-filters" class="btn btn-success w-100">Reset Filters</button>
                </form>
            </aside>

            <!-- Property Grid -->
            <main class="properties-archive__main flex-grow-1">
                <div id="properties-grid" class="properties-grid__container">
                    <!-- AJAX Results Go Here -->
                </div>

                <div id="pagination" class="pagination mt-4 d-flex justify-content-center">
                    <!-- AJAX Pagination -->
                </div>
            </main>
        </div>
    </div>
</section>

<?php
get_footer();
