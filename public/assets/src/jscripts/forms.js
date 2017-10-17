(function() {
  "use strict";
  window.addEventListener("load", function() {
    var form = document.getElementById("cafpe_form");
    form.addEventListener("submit", function(event) {
      if (form.checkValidity() == false) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add("was-validated");
    }, false);
  }, false);
}());
