/**
 * recuperar.js
 * Recuperación de contraseña para usuarios del sistema.
 * Valida que el correo no esté vacío, envía solicitud al backend
 * (email.php?op=recuperar) y si es exitoso redirige al login.
 */
$(document).ready(function () {});

$(document).on("click", "#btnrecuperar", function () {
  var usu_correo = $("#usu_correo").val();

  if (usu_correo === "") {
    Swal.fire({
      title: "Recuperar",
      text: "El campo esta vacio, por favor validar.",
      icon: "error",
      confirmButtonColor: "#5156be",
    });
  } else {
    $.post(
      "../../controller/email.php?op=recuperar",
      { usu_correo: usu_correo },
      function (datos) {
        if (datos == 1) {
          Swal.fire({
            title: "Recuperar",
            text: "Se cambio la contraseña, y se envio a su correo electronico.",
            icon: "success",
            confirmButtonColor: "#5156be",
          }).then(() => {
            window.location.href = "../../index.php";
          });
        } else {
          Swal.fire({
            title: "Recuperar",
            text: "El correo electronico no existe.",
            icon: "error",
            confirmButtonColor: "#5156be",
          });
        }
      },
    );
  }
});
