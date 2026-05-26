/**
 * confirmar.js
 * Confirmación/activación de cuenta de usuario.
 * Lee un parámetro "id" desde la URL, lo decodifica (base64 con espacios
 * reemplazados por +) y envía el ID al backend para activar la cuenta.
 */
$(document).ready(function(){
    const url = window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    const confirmar = params.get("id");
    const decoded_id = decodeURIComponent(confirmar);
    const id = decoded_id.replace(/\s/g, '+');

    console.log(id);

    $.post("../../controller/usuario.php?op=activar",{usu_id : id},function (data){

    });
});