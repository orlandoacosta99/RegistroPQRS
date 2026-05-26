<?php
/*
        Controlador: usuario
        Propósito: Router de operaciones relacionadas con usuarios/colaboradores.
        Recibe el parámetro $_GET["op"] para determinar la acción a ejecutar.
        Opera como intermediario entre la vista y los modelos Usuario y Email.
    */
require_once("../config/conexion.php");
require_once("../models/Usuario.php");
require_once("../models/Email.php");

$usuario = new Usuario();
$email = new Email();

switch ($_GET["op"]) {

    /*
            op = "registrar"
            Registra un nuevo usuario externo desde el formulario de registro.
            Primero verifica que el correo no exista. Si es nuevo, inserta el
            usuario y envía un correo de confirmación. Retorna "1" si se registró
            correctamente o "0" si el correo ya está registrado.
        */
    case "registrar":
        $datos = $usuario->get_usuario_correo($_POST["usu_correo"]);
        if (is_array($datos) == true and count($datos) == 0) {
            $datos1 = $usuario->registrar_usuario($_POST["usu_nomape"], $_POST["usu_correo"], $_POST["usu_pass"], "../../assets/picture/avatar.png", 2);
            $email->registrar($datos1[0]["usu_id"]);
            echo "1";
        } else {
            echo "0";
        }
        break;

    /*
            op = "activar"
            Activa la cuenta de un usuario a partir del ID cifrado recibido
            desde el enlace de confirmación por correo.
        */
    case "activar":
        $usuario->activar_usuario($_POST["usu_id"]);
        break;

    /*
            op = "registrargoogle"
            Autenticación/registro mediante Google Sign-In para usuarios generales.
            Recibe el token JWT de Google, lo decodifica para obtener nombre, email y foto.
            Si el email no existe, registra un nuevo usuario (activo, est=1).
            Si ya existe, inicia sesión. Retorna "1" (nuevo) o "0" (existente).
        */
    case "registrargoogle":
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["CONTENT_TYPE"] === "application/json") {
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            if (!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth') {
                $credential = !empty($jsonObj->credential) ? $jsonObj->credential : '';

                $parts = explode(".", $credential);
                $header = base64_decode($parts[0]);
                $payload = base64_decode($parts[1]);
                $signature = base64_decode($parts[2]);

                $reponsePayload = json_decode($payload);

                if (!empty($reponsePayload)) {
                    $nombre = !empty($reponsePayload->name) ? $reponsePayload->name : '';
                    $email = !empty($reponsePayload->email) ? $reponsePayload->email : '';
                    $imagen = !empty($reponsePayload->picture) ? $reponsePayload->picture : '';
                }

                $datos = $usuario->get_usuario_correo($email);
                if (is_array($datos) == true and count($datos) == 0) {
                    $datos1 = $usuario->registrar_usuario($nombre, $email, "", $imagen, 1);

                    $_SESSION["usu_id"] = $datos1[0]["usu_id"];
                    $_SESSION["usu_nomape"] = $nombre;
                    $_SESSION["usu_correo"] = $email;
                    $_SESSION["usu_img"] =  $imagen;
                    $_SESSION["rol_id"] =  $datos1[0]["rol_id"];

                    echo "1";
                } else {
                    $usu_id = $datos[0]["usu_id"];

                    $_SESSION["usu_id"] = $usu_id;
                    $_SESSION["usu_nomape"] = $nombre;
                    $_SESSION["usu_correo"] = $email;
                    $_SESSION["usu_img"] =  $imagen;
                    $_SESSION["rol_id"] =  $datos[0]["rol_id"];

                    echo "0";
                }
            } else {
                echo json_encode(['error' => '¡Los datos de la cuenta no están disponibles!']);
            }
        }
        break;

    /*
            op = "colaboradorgoogle"
            Autenticación mediante Google Sign-In para colaboradores (rol 2 o 3).
            A diferencia de registrargoogle, si el correo no existe retorna "1"
            (usuario no registrado como colaborador) en lugar de crearlo.
            Si existe, inicia sesión y retorna "0".
        */
    case "colaboradorgoogle":
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["CONTENT_TYPE"] === "application/json") {
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            if (!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth') {
                $credential = !empty($jsonObj->credential) ? $jsonObj->credential : '';

                $parts = explode(".", $credential);
                $header = base64_decode($parts[0]);
                $payload = base64_decode($parts[1]);
                $signature = base64_decode($parts[2]);

                $reponsePayload = json_decode($payload);

                if (!empty($reponsePayload)) {
                    $nombre = !empty($reponsePayload->name) ? $reponsePayload->name : '';
                    $email = !empty($reponsePayload->email) ? $reponsePayload->email : '';
                    $imagen = !empty($reponsePayload->picture) ? $reponsePayload->picture : '';
                }

                $datos = $usuario->get_usuario_correo($email);
                if (is_array($datos) == true and count($datos) == 0) {
                    echo "1";
                } else {
                    $usu_id = $datos[0]["usu_id"];

                    $_SESSION["usu_id"] = $usu_id;
                    $_SESSION["usu_nomape"] = $nombre;
                    $_SESSION["usu_correo"] = $email;
                    $_SESSION["usu_img"] =  $imagen;
                    $_SESSION["rol_id"] = $datos[0]["rol_id"];

                    echo "0";
                }
            } else {
                echo json_encode(['error' => '¡Los datos de la cuenta no están disponibles!']);
            }
        }
        break;

    /*
            op = "guardaryeditar"
            Inserta o actualiza un colaborador según tenga o no ID.
            Si no tiene ID (nuevo): verifica que el correo no exista, inserta
            el colaborador y envía notificación. Retorna "1" (creado), "0" (correo existe).
            Si tiene ID (edición): actualiza los datos y retorna "2".
        */
    case "guardaryeditar":
        if (empty($_POST["usu_id"])) {
            $datos = $usuario->get_usuario_correo($_POST["usu_correo"]);
            if (is_array($datos) == true and count($datos) == 0) {
                $datos1 = $usuario->insert_colaborador($_POST["usu_nomape"], $_POST["usu_correo"], $_POST["rol_id"]);
                $email->nuevo_colaborador($datos1[0]["usu_id"]);
                echo "1";
            } else {
                echo "0";
            }
        } else {
            $usuario->update_colaborador($_POST["usu_id"], $_POST["usu_nomape"], $_POST["usu_correo"], $_POST["rol_id"]);
            echo "2";
        }
        break;

    /*
            op = "mostrar"
            Obtiene los datos de un colaborador por su ID y los retorna en formato JSON.
            Usado para cargar el formulario de edición con datos existentes.
        */
    case "mostrar":
        $datos = $usuario->get_usuario_id($_POST["usu_id"]);
        $output = [];
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["usu_id"]     = $row["usu_id"];
                $output["usu_nomape"] = $row["usu_nomape"];
                $output["usu_correo"] = $row["usu_correo"];
                $output["rol_id"]     = $row["rol_id"];
            }
            echo json_encode($output);
        }
        break;

    /*
            op = "eliminar"
            Realiza un borrado lógico del colaborador (est=0).
            Retorna "1" como confirmación.
        */
    case "eliminar":
        $usuario->eliminar_colaborador($_POST["usu_id"]);
        echo "1";
        break;

    /*
            op = "listar"
            Lista todos los colaboradores activos (rol 2 o 3) en formato DataTables.
            Retorna un JSON con estructura sEcho, iTotalRecords, iTotalDisplayRecords, aaData.
            Incluye botones de acción: permiso, editar y eliminar.
        */
    case "listar":
        $datos = $usuario->get_colaborador();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["usu_nomape"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["rol_nom"];
            $sub_array[] = $row["fech_crea"];
            $sub_array[] = '<button type="button" class="btn btn-soft-info waves-effect waves-light btn-sm" onClick="permiso(' . $row["usu_id"] . ')"><i class="bx bx-shield-quarter font-size-16 align-middle"></i></button>';
            $sub_array[] = '<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm" onClick="editar(' . $row["usu_id"] . ')"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>';
            $sub_array[] = '<button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar(' . $row["usu_id"] . ')"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
        break;

    /*
            op = "comboarea"
            Genera un <select> HTML con las áreas a las que el usuario autenticado
            tiene permiso de acceso. Retorna las opciones del combo.
        */
    case "comboarea":
        $datos = $usuario->get_usuario_permiso_area($_SESSION["usu_id"]);
        $html = "";
        $html .= "<option value=''>Seleccionar</option>";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['area_id'] . "'>" . $row['area_nom'] . "</option>";
            }
            echo $html;
        }
        break;

    case "mostrar_perfil":
        header('Content-Type: application/json');
        try {
            if (empty($_SESSION["usu_id"])) {
                echo json_encode(["error" => "Sesión no válida o expirada"]);
                exit;
            }
            $datos = $usuario->get_usuario_id($_SESSION["usu_id"]);
            if (!$datos || count($datos) == 0) {
                echo json_encode(["error" => "Usuario no encontrado"]);
                exit;
            }
            $row = $datos[0];
            echo json_encode([
                "usu_id"     => $row["usu_id"],
                "usu_nomape" => $row["usu_nomape"],
                "usu_correo" => $row["usu_correo"],
                "usu_img"    => $row["usu_img"] ?: "../../assets/picture/avatar-1.jpg"
            ]);
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
        break;

    case "actualizar_perfil":
        header('Content-Type: application/json');
        try {
            if (empty($_SESSION["usu_id"])) {
                echo json_encode(["status" => "error", "message" => "Sesión no válida o expirada"]);
                exit;
            }
            $usu_id     = $_SESSION["usu_id"];
            $usu_nomape = trim($_POST["usu_nomape"] ?? "");
            $usu_correo = trim($_POST["usu_correo"] ?? "");
            $cambiar_pass = intval($_POST["cambiar_pass"] ?? 0);

            if (empty($usu_nomape) || empty($usu_correo)) {
                echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
                exit;
            }
            if (!filter_var($usu_correo, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["status" => "error", "message" => "El formato del correo electrónico no es válido"]);
                exit;
            }

            // Verificar unicidad del correo (excluyendo el propio usuario)
            $existente = $usuario->get_usuario_correo($usu_correo);
            if (is_array($existente) && count($existente) > 0 && $existente[0]["usu_id"] != $usu_id) {
                echo json_encode(["status" => "error", "message" => "El correo ya está en uso por otro usuario"]);
                exit;
            }

            $nueva_password = null;
            if ($cambiar_pass == 1) {
                $pass_actual = trim($_POST["pass_actual"] ?? "");
                $pass_nueva  = trim($_POST["pass_nueva"]  ?? "");

                if (empty($pass_actual) || empty($pass_nueva)) {
                    echo json_encode(["status" => "error", "message" => "Complete todos los campos de contraseña"]);
                    exit;
                }
                if (!$usuario->validar_password_actual($usu_id, $pass_actual)) {
                    echo json_encode(["status" => "error", "message" => "La contraseña actual no es correcta", "error_field" => "pass_actual"]);
                    exit;
                }
                if (strlen($pass_nueva) < 6) {
                    echo json_encode(["status" => "error", "message" => "La nueva contraseña debe tener al menos 6 caracteres"]);
                    exit;
                }
                $nueva_password = $pass_nueva;
            }

            $datos = $usuario->actualizar_perfil_completo($usu_id, $usu_nomape, $usu_correo, $nueva_password);
            if ($datos && count($datos) > 0) {
                $_SESSION["usu_nomape"] = $usu_nomape;
                $_SESSION["usu_correo"] = $usu_correo;
                $row = $datos[0];
                echo json_encode([
                    "status"  => "success",
                    "message" => $cambiar_pass == 1 ? "Perfil y contraseña actualizados correctamente" : "Perfil actualizado correctamente",
                    "data"    => [
                        "usu_id"     => $row["usu_id"],
                        "usu_nomape" => $row["usu_nomape"],
                        "usu_correo" => $row["usu_correo"]
                    ]
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar el perfil. Intente nuevamente."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error interno: " . $e->getMessage()]);
        }
        break;

    case "subir_avatar":
        header('Content-Type: application/json');
        try {
            if (empty($_SESSION["usu_id"])) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Sesión no válida"]);
                exit;
            }

            if (!isset($_FILES["file"]) || $_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
                echo json_encode(["status" => "error", "message" => "No se recibió ningún archivo"]);
                exit;
            }

            $file     = $_FILES["file"];
            $maxBytes = 1 * 1024 * 1024; // 1 MB

            // Validar tamaño
            if ($file["size"] > $maxBytes) {
                echo json_encode(["status" => "error", "message" => "El archivo supera el máximo de 1 MB"]);
                exit;
            }

            // Validar tipo MIME real (no confiar solo en extensión)
            $finfo    = new finfo(FILEINFO_MIME_TYPE);
            $mimeReal = $finfo->file($file["tmp_name"]);
            $mimesOk  = ["image/jpeg", "image/png", "image/webp"];
            if (!in_array($mimeReal, $mimesOk)) {
                echo json_encode(["status" => "error", "message" => "Tipo de archivo no permitido. Use JPG, PNG o WEBP"]);
                exit;
            }

            $extMap = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
            $ext    = $extMap[$mimeReal];

            $usu_id  = $_SESSION["usu_id"];
            $dirBase = dirname(__DIR__) . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "picture" . DIRECTORY_SEPARATOR . "avatars" . DIRECTORY_SEPARATOR;
            if (!is_dir($dirBase)) {
                mkdir($dirBase, 0755, true);
            }

            $filename = "avatar_" . $usu_id . "_" . time() . "." . $ext;
            $destPath = $dirBase . $filename;

            // Generar miniatura 300×300 con GD y guardar
            $src = null;
            if ($mimeReal === "image/jpeg") {
                $src = imagecreatefromjpeg($file["tmp_name"]);
            } elseif ($mimeReal === "image/png") {
                $src = imagecreatefrompng($file["tmp_name"]);
            } elseif ($mimeReal === "image/webp") {
                $src = imagecreatefromwebp($file["tmp_name"]);
            }

            if ($src === false) {
                echo json_encode(["status" => "error", "message" => "No se pudo procesar la imagen"]);
                exit;
            }

            $srcW = imagesx($src);
            $srcH = imagesy($src);
            $thumb = imagecreatetruecolor(300, 300);

            // Fondo blanco para PNG con transparencia
            if ($mimeReal === "image/png") {
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                $transparente = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
                imagefill($thumb, 0, 0, $transparente);
            }

            // Recorte centrado para mantener proporción
            $ratio = min($srcW / 300, $srcH / 300);
            $cropW = (int)round(300 * $ratio);
            $cropH = (int)round(300 * $ratio);
            $offX  = (int)round(($srcW - $cropW) / 2);
            $offY  = (int)round(($srcH - $cropH) / 2);
            imagecopyresampled($thumb, $src, 0, 0, $offX, $offY, 300, 300, $cropW, $cropH);

            if ($mimeReal === "image/jpeg") {
                imagejpeg($thumb, $destPath, 90);
            } elseif ($mimeReal === "image/png") {
                imagepng($thumb, $destPath, 7);
            } elseif ($mimeReal === "image/webp") {
                imagewebp($thumb, $destPath, 90);
            }
            imagedestroy($src);
            imagedestroy($thumb);

            // Eliminar avatar anterior si es un archivo local (no URL externa, no avatar por defecto)
            $avatarAnterior = $_SESSION["usu_img"] ?? "";
            if (!empty($avatarAnterior)
                && strpos($avatarAnterior, "://") === false
                && strpos($avatarAnterior, "avatar-") === false
                && strpos($avatarAnterior, "avatar.png") === false
            ) {
                $rutaAnterior = dirname(__DIR__) . DIRECTORY_SEPARATOR . ltrim(str_replace("../../", "", $avatarAnterior), "/\\");
                if (is_file($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }

            $urlNueva = "../../assets/picture/avatars/" . $filename;
            $usuario->actualizar_avatar($usu_id, $urlNueva);
            $_SESSION["usu_img"] = $urlNueva;

            echo json_encode([
                "status"  => "success",
                "message" => "Imagen de perfil actualizada",
                "usu_img" => $urlNueva
            ]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error interno: " . $e->getMessage()]);
        }
        break;
}
