$(function () {
  "use strict";

  $("#wizard").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex) {
      if (currentIndex > newIndex) {
        return true;
      }
      var form = $(".form");
      form.validate();
      if (!form.valid()) {
        return false;
      } else {
        return true;
      }
    },
    onFinishing: function (event, currentIndex) {
      var form = $(".form");
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },
    onFinished: function (event, currentIndex) {
      var form = $(".form");
      $.ajax({
        data: form.serialize(),
        type: "POST",
        url: "register-intern.php",
        data: form.serialize(),
        success: function (response) {
          swalOpen(response);
        },
      });
      function swalOpen(data) {
        Swal.fire({
          icon: "success",
          title: "Done",
          // text: data.msg,
          timer: 3000,
        }).then(function () {
          window.location.href = "index.php";
        });
      }
    },
  });
});
