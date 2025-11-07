jQuery(document).ready(function ($) {
  // Convert price string to number
  function parsePrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  // Get badge color based on category
  function getBadgeColor(categorySlug) {
    const colors = {
      sold: "danger",
      "for-rent": "primary",
      "for-sale": "success",
    };
    return colors[categorySlug] || "success";
  }

  // Handle form submission
  $("#property-filter").on("submit", function (e) {
    e.preventDefault();

    const formData = $(this).serializeArray();
    const params = {};

    formData.forEach((field) => {
      if (field.value) params[field.name] = field.value;
    });

    const queryString = new URLSearchParams(params).toString();
    const apiURL = `/wp-json/properties/v1/search?${queryString}`;

    $("#property-results").html("<p>Loading properties...</p>");

    $.ajax({
      url: apiURL,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.length > 0) {
          let html = "";
          response.forEach((property) => {
            // Get category info
            const categoryName = property.category?.name || "For Sale";
            const categorySlug = property.category?.slug || "for-sale";
            const badgeColor = getBadgeColor(categorySlug);

            html += `
              <a href="${property.permalink}" class="property-card-link text-decoration-none text-underline-none" aria-labelledby="property-title-${property.id}">
                <div class="property-card">
                  <div class="property-card__image">
                    <img src="${property.image || "/wp-content/uploads/default.jpg"}"
                      alt="${property.title}">
                    <span class="property-badge bg-${badgeColor}">${categoryName}</span>
                  </div>
                  <div class="property-card__content">
                    <h3 id="property-title-${property.id}" class="property-title text-dark">${property.title}</h3>
                    ${property.suburb ? `<p class="property-address">${property.suburb}</p>` : ""}
                    ${property.price ? `<div class="property-price text-dark">$${parsePrice(property.price)}</div>` : ""}
                    <div class="property-features">
                      ${property.property_details?.[0]?.bedrooms_detail ? `<div class="feature text-dark"><div class="feature-icon-detail"><i class="fa-solid fa-bed"></i><span>${property.property_details[0].bedrooms_detail}</span></div><small>Bedrooms</small></div>` : ""}
                      ${property.property_details?.[0]?.bathrooms_detail ? `<div class="feature text-dark"><div class="feature-icon-detail"><i class="fa-solid fa-bath"></i><span>${property.property_details[0].bathrooms_detail}</span></div><small>Bathrooms</small></div>` : ""}
                      ${property.property_details?.[0]?.total_area_detail ? `<div class="feature text-dark"><div class="feature-icon-detail"><i class="fa-regular fa-square"></i><span>${property.property_details[0].total_area_detail}</span></div><small>Total area</small></div>` : ""}
                      ${property.property_details?.[0]?.garages_detail ? `<div class="feature text-dark"><div class="feature-icon-detail"><i class="fa-solid fa-warehouse"></i><span>${property.property_details[0].garages_detail}</span></div><small>Garages</small></div>` : ""}
                    </div>
                  </div>
                </div>
              </a>
            `;
          });
          $("#property-results").html(html);
        } else {
          $("#property-results").html("<p>No properties found.</p>");
        }
      },
      error: function (xhr) {
        console.error("API Error:", xhr);
        $("#property-results").html("<p>Error loading properties.</p>");
      },
    });

    // Handle reset button
    $("#reset-filter").on("click", function () {
      $("#property-filter")[0].reset();
      $("#property-filter").trigger("submit");
    });
  });
});

/*
Property Archive Filters
*/
jQuery(function ($) {
  const $form = $("#property-filter-form");
  const $search = $("#property-search");
  const $grid = $("#properties-grid");
  const $pagination = $("#pagination");
  const $priceRange = $("#price-range");
  const $priceValue = $("#price-value");
  let currentPage = 1;

  function fetchProperties(page = 1) {
    currentPage = page;

    const filters = {
      location: $search.val(),
      property_type: $form
        .find("input[name='property_type[]']:checked")
        .map(function () {
          return $(this).val();
        })
        .get(),
      bedrooms: $form.find("input[name='bedrooms']:checked").val() || "",
      availability:
        $form.find("input[name='availability']:checked").val() || "",
      price_max: $priceRange.val(),
      page: currentPage,
      per_page: 6,
    };

    $grid.html('<div class="loading text-center w-100 py-5">Loading...</div>');
    $pagination.empty();

    $.ajax({
      url: propertiesAjax.rest_url + "properties/v1/search", // Fixed: Use full REST URL
      data: filters,
      method: "GET",
      success: function (response) {
        if (response.properties) {
          renderProperties(response.properties);
          if (response.pages > 1) {
            renderPagination(response.pages);
          }
        } else {
          renderProperties(response);
        }
      },
      error: function (xhr) {
        console.error("API error:", xhr);
        console.error("Response:", xhr.responseText);
        $grid.html("<p class='text-center py-5'>Error loading properties.</p>");
      },
    });
  }

  function renderProperties(properties) {
    if (!properties || !properties.length) {
      $grid.html("<p class='text-center py-5'>No properties found.</p>");
      return;
    }

    let html = "";
    properties.forEach((p) => {
      const img =
        p.image || "https://via.placeholder.com/400x250?text=No+Image";
      const id = p.id;
      const title = p.title;
      const suburb = p.suburb || "";
      const bedrooms = p.property_details?.[0]?.bedrooms_detail || "N/A";
      const bathrooms = p.property_details?.[0]?.bathrooms_detail || "N/A";
      const area = p.property_details?.[0]?.total_area_detail || "N/A";
      const garages = p.property_details?.[0]?.garages_detail || "N/A";
      const price = p.price
        ? "$" + p.price.toLocaleString()
        : "Contact for price";
      const link = p.permalink;

      // Get category info
      const categoryName = p.category?.name || "For Sale";
      const categorySlug = p.category?.slug || "for-sale";
      const badgeColor = getBadgeColor(categorySlug);

      html += `
        <a href="${link}" class="property-card-link text-decoration-none text-underline-none" aria-labelledby="property-title-${id}">
            <div class="property-card">
                <div class="property-card__image">
                    <img src="${img}" alt="${title}">
                    <span class="property-badge bg-${badgeColor}">${categoryName}</span>
                </div>
                <div class="property-card__content">
                    <h3 id="property-title-${id}" class="property-title text-dark">${title}</h3>
                    ${suburb ? `<p class="property-address">${suburb}</p>` : ""}
                    ${price ? `<div class="property-price text-dark">${price}</div>` : ""}

                    <div class="property-features">
                        <div class="feature text-dark">
                            <div class="feature-icon-detail">
                                <i class="fa-solid fa-bed" aria-hidden="true"></i>
                                <span>${bedrooms}</span>
                            </div>
                            <small>Bedrooms</small>
                        </div>
                        <div class="feature text-dark">
                            <div class="feature-icon-detail">
                                <i class="fa-solid fa-bath" aria-hidden="true"></i>
                                <span>${bathrooms}</span>
                            </div>
                            <small>Bathrooms</small>
                        </div>
                        <div class="feature text-dark">
                            <div class="feature-icon-detail">
                                <i class="fa-regular fa-square" aria-hidden="true"></i>
                                <span>${area}</span>
                            </div>
                            <small>Total area</small>
                        </div>
                        <div class="feature text-dark">
                            <div class="feature-icon-detail">
                                <i class="fa-solid fa-warehouse" aria-hidden="true"></i>
                                <span>${garages}</span>
                            </div>
                            <small>Garages</small>
                        </div>
                    </div>
                </div>
            </div>
        </a>
      `;
    });

    $grid.html(html);
  }

  function getBadgeColor(categorySlug) {
    const colors = {
      sold: "danger",
      "for-rent": "primary",
      "for-sale": "success",
    };
    return colors[categorySlug] || "success";
  }

  function renderPagination(totalPages) {
    if (!totalPages || totalPages <= 1) return;

    let html =
      '<ul class="pagination-list d-flex gap-2 justify-content-center">';
    for (let i = 1; i <= totalPages; i++) {
      const active = i === currentPage ? "active" : "";
      html += `<li><button class="page-btn ${active}" data-page="${i}">${i}</button></li>`;
    }
    html += "</ul>";

    $pagination.html(html);
  }

  // Event Listeners
  $form.on("change", "input, select", function () {
    fetchProperties(1);
  });

  $form.on("submit", function (e) {
    e.preventDefault();
    fetchProperties(1);
  });

  $search.on("keyup", function () {
    clearTimeout($.data(this, "timer"));
    const wait = setTimeout(() => fetchProperties(1), 400);
    $(this).data("timer", wait);
  });

  $pagination.on("click", ".page-btn", function () {
    const page = $(this).data("page");
    fetchProperties(page);
  });

  // Reset Filters
  $("body").on("click", "#reset-filters", function (e) {
    e.preventDefault();
    $form[0].reset();
    $priceRange.val(500000);
    updatePriceRange();
  });

  // Price Range Slider
  $priceRange.on("input", updatePriceRange);

  function updatePriceRange() {
    const max = parseInt($priceRange.val());
    $priceValue.text(`Up to $${max.toLocaleString()}`);
    fetchProperties(1);
  }

  // Initial Load
  fetchProperties();
});
