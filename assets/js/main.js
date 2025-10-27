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
