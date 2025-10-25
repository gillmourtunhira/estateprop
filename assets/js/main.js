jQuery(document).ready(function ($) {
  console.log("jQuery is working");

  $(".accordion-button").click(function () {
    $(this).next(".accordion-collapse").slideToggle();
  });
});
