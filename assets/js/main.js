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

  // Create and add scroll to top button
  const $scrollBtn = $("<button>")
    .html('<i class="fas fa-arrow-up"></i>')
    .addClass("scroll-to-top")
    .css({
      position: "fixed",
      bottom: "20px",
      right: "20px",
      width: "50px",
      height: "50px",
      borderRadius: "50%",
      backgroundColor: "#87c65f",
      color: "white",
      border: "none",
      cursor: "pointer",
      opacity: "0",
      visibility: "hidden",
      transition: "all 0.3s ease",
      zIndex: "1000",
      boxShadow: "0 4px 12px rgba(59, 130, 246, 0.3)",
    });

  $("body").append($scrollBtn);

  // Show/hide scroll button based on scroll position
  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 300) {
      $scrollBtn.css({
        opacity: "1",
        visibility: "visible",
      });
    } else {
      $scrollBtn.css({
        opacity: "0",
        visibility: "hidden",
      });
    }
  });

  // Scroll to top functionality
  $scrollBtn.on("click", function () {
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      800,
    );
  });
});
