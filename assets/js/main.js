jQuery(document).ready(function ($) {
  (() => {
    const $form = $(".js-wif-form");
    const $submitButton = $form.find(".js-wif-submit-button");

    const enableSubmit = () => {
      console.log($submitButton, "submitbutton");
      $submitButton.attr("disabled", false);
    };

    const disabledSubmit = () => {
      $submitButton.attr("disabled", true);
    };

    const validateForm = () => {
      let valid = true;
      $form.each((element) => {
        const value = $(element).val();
        const required = $(element).attr("required");
        if (required && !value) valid = false;
      });
      return valid;
    };

    $(".wif-filter select").on("change", (e) => {
      let valid = validateForm();
      console.log(valid);
      if (valid) {
        enableSubmit();
      } else {
        disabledSubmit();
      }
    });
  })();
});
