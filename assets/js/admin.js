jQuery(document).ready(function ($) {
  $(document).on("click", ".js-panel-option-button[data-target]", function (e) {
    e.preventDefault();
    const target = $(this).data("target");
    $(".js-panel-tool").hide();
    $(".js-panel-tool-" + target).show();
    $(".js-panel-option-button").removeClass("active");
    $(this).addClass("active");
  });
});
