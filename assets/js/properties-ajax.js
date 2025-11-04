jQuery(document).ready(function ($) {
  $("#property-filter").on("submit", function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      url: propertiesAjax.ajax_url,
      type: "POST",
      data: {
        action: "filter_properties",
        nonce: propertiesAjax.filter_nonce, // 👈 must match 'nonce' in PHP check
        form_data: formData,
      },
      beforeSend: function () {
        $("#property-results").html("<p>Loading properties...</p>");
      },
      success: function (response) {
        if (response.success) {
          $("#property-results").html(response.data.html);
        } else {
          $("#property-results").html("<p>No properties found.</p>");
        }
      },
      error: function (xhr) {
        console.error("Error:", xhr.responseText);
        $("#property-results").html("<p>Error loading properties.</p>");
      },
    });
  });
});
