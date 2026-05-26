<?php
    /*
        Controlador: email
        Propósito: Router de operaciones relacionadas con el envío de correos.
        Recibe el parámetro $_GET["op"] para determinar la acción a ejecutar.
        Opera como intermediario entre la vista y los modelos Email y Usuario.
    */
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    require_once("../models/Email.php");

    $usuario = new Usuario();
    $email = new Email();

    switch($_GET["op"]){

        /*
            op = "recuperar"
            Procesa la solicitud de recuperación de contraseña.
            Verifica que el correo exista en la BD. Si existe, envía un
            correo con una nueva contraseña temporal y retorna "1".
            Si no existe, retorna "0".
        */
        case "recuperar":
            $datos = $usuario->get_usuario_correo($_POST["usu_correo"]);
            if(is_array($datos) == true and count($datos) == 0){
                echo "0";
            }else{
                $email->recuperar($_POST["usu_correo"]);
                echo "1";
            }
            break;
    }
?>