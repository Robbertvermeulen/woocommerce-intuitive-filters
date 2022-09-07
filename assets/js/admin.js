jQuery(document).ready(function ($) {
  const addShortCodeToTextArea = (type, id) => {
    const $textarea = $(".js-editor-textarea");
    let value = $textarea.val();
    let shortCode = ["{{"];
    shortCode.push(type);
    if (id) shortCode.push("id=" + id);
    shortCode.push("}}");
    const updatedValue = value.trimRight() + " " + shortCode.join(" ");
    $textarea.val(updatedValue);
    inActivatePanelTools();
  };

  const inActivatePanelTools = () => {
    $(".js-panel-tool").hide();
    $(".js-panel-option-button-opener").removeClass("active");
  };

  $(document)
    .on(
      "click",
      ".js-panel-option-button-opener[data-tool-type]",
      function (e) {
        e.preventDefault();
        const target = $(this).data("tool-type");
        inActivatePanelTools();
        $(".js-panel-tool-" + target).show();
        $(this).addClass("active");
      }
    )
    .on("click", ".js-panel-tool-add-button", function (e) {
      e.preventDefault();
      const $parent = $(this).parents(".js-panel-tool");
      const $dropdown = $parent.find(".js-panel-tool-dropdown");
      const type = $parent.data("tool-type");
      const id = $dropdown.val();
      addShortCodeToTextArea(type, id);
    })
    .on("click", ".js-panel-option-button-add", function (e) {
      e.preventDefault();
      const type = $(this).data("tool-type");
      addShortCodeToTextArea(type);
    });
});
