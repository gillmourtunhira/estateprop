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
