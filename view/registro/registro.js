/**
 * registro.js
 * Registro de nuevo usuario en el sistema.
 * Valida campos del formulario usando la librería Validator.js
 * (correo, nombres, contraseña mín. 8 caracteres y coincidencia),
 * envía los datos al backend y redirige al login tras éxito.
 * También soporta registro/login con Google Sign-In.
 */
var timerInterval;

function init() {
    $("#mnt_form").on("submit", function (e) {
        e.preventDefault();

        if(isFormValid()){
            registrar(e);
        }else{
            displayValidationMessages();
        }
    });
}

function isFormValid(){
    return validateEmail() && validateText("usu_nomape") && validatePassword() && validatePasswordMatch();
}

function validateEmail(){
    var email = $("#usu_correo").val();
    var isValid = validator.isEmail(email);
    displayErrorMessage("#usu_correo",isValid,"Ingrese Correo Electrónico");
    return isValid;
}

function validateText(fieldId){
    var value = $("#" + fieldId).val();
    var isValid = validator.isLength(value,{min:1});
    displayErrorMessage("#" + fieldId ,isValid,"Este campo es obligatorio.");
    return isValid;
}

function validatePassword(){
    var password = $("#usu_pass").val();
    var isValid = validator.isLength(password,{min: 8});
    displayErrorMessage("#usu_pass" ,isValid,"La contraseña debe tener al menos 8 caracteres.");
    return isValid;
}

function validatePasswordMatch(){
    var password = $("#usu_pass").val();
    var confirmPassword = $("#usu_pass_confir").val();
    var isValid = validator.equals(password,confirmPassword);
    displayErrorMessage("#usu_pass_confir" ,isValid,"Las contraseñas no coinciden.");
    return isValid;
}

function displayErrorMessage(fieldSelector, isValid, message){
    var errorField = $(fieldSelector).next(".validation-error");
    errorField.text(isValid ? "" : message);
    errorField.toggleClass("text-danger", !isValid);
}

function displayValidationMessages(){
    validateEmail();
    validateText("usu_nomape");
    validatePassword();
    validatePasswordMatch();
}

function registrar(){
    var formData = new FormData($("#mnt_form")[0]);
    $.ajax({
        url: "../../controller/usuario.php?op=registrar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            if (datos == 1){
                Swal.fire({
                    title: "Registro",
                    text: "Se registro correctamente. Por Favor iniciar sesion. Redireccionando en 10 segundos.",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: function(){
                        Swal.showLoading();
                        timerInterval = setInterval(function () {
                            var content = Swal.getHtmlContainer();
                            if (!content) return;
                            var countdownElement = content.querySelector("b");
                            if (countdownElement) {
                              countdownElement.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                            }
                        }, 100);
                    },
                    didClose: function(){
                        clearInterval(timerInterval);
                        window.location.href = "../../index.php";
                    },
                }).then(function(result){
                    if (result.dismiss === Swal.DismissReason.timer) {
                    }
                });
            }else if (datos == 0){
                Swal.fire({
                    title: "Registro",
                    text: "El correo electronico ya existe.",
                    icon: "error",
                    confirmButtonColor: "#5156be",
                });
            }
        }
    });
}

function startGoogleSignIn(){
    const auth = gapi.auth2.getAuthInstance();
    auth.signIn();
}

function handleCredentialResponse(response){

    $.ajax({
        type: 'POST',
        url: '../../controller/usuario.php?op=registrargoogle',
        contentType: 'application/json',
        headers: {"Content-Type": "application/json"},
        data: JSON.stringify({
            request_type:'user_auth',
            credential: response.credential
        }),
        success: function(data){
            console.log(data);
            if(data === "0"){
                window.location.href = '../home/'
            }else if (data === "1"){
                window.location.href = '../home/'
            }
        }
    })

    if(response && response.credential){
        const credentialToken = response.credential;
        const decodedToken = JSON.parse(atob(credentialToken.split('.')[1]));
    }
}

init();
