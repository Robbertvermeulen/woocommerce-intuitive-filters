/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************!*\
  !*** ./src/admin.js ***!
  \**********************/
jQuery(document).ready(function ($) {
  const addShortCodeToTextArea = name => {
    const $textarea = $(".js-editor-textarea");
    let value = $textarea.val();
    let shortCode = ["{{"];
    shortCode.push(name);
    shortCode.push("}}");
    const updatedValue = value.trimRight() + " " + shortCode.join(" ");
    $textarea.val(updatedValue);
    inActivatePanelTools();
  };

  const inActivatePanelTools = () => {
    $(".js-panel-tool").hide();
    $(".js-panel-option-button-opener").removeClass("active");
  };

  $(document).on("click", ".js-panel-option-button-opener[data-tool-type]", function (e) {
    e.preventDefault();
    const target = $(this).data("tool-type");
    inActivatePanelTools();
    $(".js-panel-tool-" + target).show();
    $(this).addClass("active");
  }).on("click", ".js-panel-tool-add-button", function (e) {
    e.preventDefault();
    const $parent = $(this).parents(".js-panel-tool");
    const $dropdown = $parent.find(".js-panel-tool-dropdown");
    const name = $dropdown.val();
    addShortCodeToTextArea(name);
  }).on("click", ".js-panel-option-button-add", function (e) {
    e.preventDefault();
    const name = $(this).data("tool-type");
    addShortCodeToTextArea(name);
  }).on("change", ".js-category-mode-selector", function (e) {
    const mode = $("option:selected", this).data("category-mode");
    $(".js-category-mode-element").hide();
    $(".js-category-mode-" + mode).show();
  });
});
/******/ })()
;
//# sourceMappingURL=admin.js.map