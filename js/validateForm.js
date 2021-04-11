/*
  Author: Adam Minaker
  Date: 4/11/2021
  Description: Form validation for GotNext.
*/
(function () {
  "use strict";

  // Fetch all the forms to apply Bootstrap validation styles to.
  var forms = document.querySelectorAll(".needs-validation");

  // Loop through them and prevent submission.
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();