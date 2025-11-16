jQuery(document).ready(function ($) {
  console.log("jQuery is working");

  $(".accordion-button").click(function () {
    $(this).next(".accordion-collapse").slideToggle();
  });

  // Property Gallery Slider
  jQuery(document).ready(function ($) {
    // Open gallery modal
    $("#open-gallery").on("click", function (e) {
      e.preventDefault();
      $("#property-gallery").modal("show");
    });

    // Optional: Reset carousel to first slide when modal closes
    $("#property-gallery").on("hidden.bs.modal", function () {
      $("#propertyGalleryCarousel").carousel(0);
    });
  });
});

// Smooth Scroll for Anchor Links
jQuery(document).ready(function ($) {
  $("a[href^='#']").on("click", function (e) {
    e.preventDefault();
    var target = this.hash;
    var $target = $(target);

    $("html, body").animate(
      {
        scrollTop: $target.offset().top,
      },
      800,
      function () {
        window.location.hash = target;
      },
    );
  });
});

// Remove p tag from content in a div and return the content only
jQuery(document).ready(function ($) {
  $("#submit-btn p").each(function () {
    var content = $(this).html();
    $(this).parent().html(content);
  });
});

// Handle click event on location cards
jQuery(document).ready(function ($) {
  $(".locations-grid").on("click", ".location-card", function () {
    const url = $(this).data("url");
    if (url) {
      window.location.href = url;
    }
  });
});
