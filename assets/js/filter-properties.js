jQuery(document).ready(function($) {
    $('#property-filter').on('submit', function(e) {
      e.preventDefault();
  
      var formData = $(this).serialize();
  
      $.ajax({
        url: propertiesAjax.ajax_url, // Provided by WP automatically if localized
        type: 'POST',
        data: {
          action: 'filter_properties',
          form_data: formData
        },
        beforeSend: function() {
          // Optional: show loader or disable button
        },
        success: function(response) {
          $('#property-results').html(response);
        }
      });
    });
  });
  