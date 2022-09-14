jQuery(document).ready(function ($) {
  (() => {
    const $form = $(".js-wif-form");
    const $submitButton = $form.find(".js-wif-submit-button");
    const $resetElement = $form.find(".js-wif-reset");

    const enableSubmit = () => {
      $submitButton.attr("disabled", false);
    };

    const disabledSubmit = () => {
      $submitButton.attr("disabled", true);
    };

    const showReset = () => {
      $resetElement.show();
    };

    const hideReset = () => {
      $resetElement.hide();
    };

    const validateForm = () => {
      let valid = true;
      $(".js-wif-dropdown", $form).each((i, element) => {
        const value = $(element).val();
        const required = $(element).attr("required");
        if (required && !value) valid = false;
      });
      return valid;
    };

    const handleFormValidity = (valid) => {
      if (valid) {
        enableSubmit();
        showReset();
      } else {
        disabledSubmit();
      }
    };

    if ($form.length > 0) {
      let valid = validateForm();
      handleFormValidity(valid);
    }

    $(".js-wif-dropdown", $form).on("change", () => {
      let valid = validateForm();
      handleFormValidity(valid);
    });

    $resetElement.on("click", () => {
      $(".js-wif-dropdown", $form).each((i, element) => {
        $("option:first", element).prop("selected", true);
      });
      hideReset();
      disabledSubmit();
    });
  })();
});
