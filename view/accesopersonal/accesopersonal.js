/**
 * accesopersonal.js
 * Autenticación de colaboradores mediante Google Sign-In.
 * Permite iniciar sesión con credenciales de Google y valida
 * el acceso contra el backend antes de redirigir.
 */

/**
 * Inicia el flujo de autenticación de Google.
 * Obtiene la instancia de autenticación de gapi y solicita el inicio de sesión.
 */
function startGoogleSignIn(){
    const auth = gapi.auth2.getAuthInstance();
    auth.signIn();
}

/**
 * Procesa la respuesta de Google después del inicio de sesión.
 * @param {Object} response - Objeto con el credential token de Google.
 * Envía el token al backend (usuario.php?op=colaboradorgoogle) para validar
 * si el colaborador tiene acceso. Si respuesta=0 redirige a homecolaborador,
 * si respuesta=1 muestra mensaje de acceso denegado.
 */
function handleCredentialResponse(response){

    $.ajax({
        type: 'POST',
        url: '../../controller/usuario.php?op=colaboradorgoogle',
        contentType: 'application/json',
        headers: {"Content-Type": "application/json"},
        data: JSON.stringify({
            request_type:'user_auth',
            credential: response.credential
        }),
        success: function(data){
            console.log(data);
            if(data === "0"){
                window.location.href = '../../view/homecolaborador/'
            }else if (data === "1"){
                Swal.fire({
                    title: "Ingreso Colaborador",
                    text: "Su cuenta no tiene acceso.",
                    icon: "error",
                    confirmButtonColor: "#5156be",
                });
            }
        }
    })

    if(response && response.credential){
        const credentialToken = response.credential;
        const decodedToken = JSON.parse(atob(credentialToken.split('.')[1]));
    }
}