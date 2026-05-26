<?php
/*
        Modelo: Usuario
        Extiende: Conectar (config/conexion.php)
        Propósito: Gestiona autenticación, registro, activación, recuperación
                   y CRUD de usuarios/colaboradores del sistema.
                   Las contraseñas se cifran con AES-256-CBC.
    */
class Usuario extends Conectar
{

    private $key    = '';
    private $cipher = 'aes-256-cbc';

    public function __construct()
    {
        // $_ENV es la fuente primaria; getenv() cubre configuraciones donde
        // variables_order en php.ini no incluye 'E' pero putenv() sí funcionó.
        $this->key    = $_ENV['AES_KEY']    ?? (getenv('AES_KEY')    ?: '');
        $this->cipher = $_ENV['AES_CIPHER'] ?? (getenv('AES_CIPHER') ?: 'aes-256-cbc');
    }

    /*
            login()
            Valida credenciales del formulario de inicio de sesión general (rol_id=1).
            Descifra la contraseña almacenada con AES-256-CBC y la compara con la ingresada.
            Si coincide, inicializa variables de sesión y redirige a view/home/.
            En caso de error redirige a index.php con código m=1 (email no existe),
            m=2 (campos vacíos) o m=3 (contraseña incorrecta).
        */
    public function login()
    {
        $conectar = parent::conexion();
        parent::set_names();
        if (isset($_POST["enviar"])) {
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];
            if (empty($correo) and empty($pass)) {
                header("Location:" . conectar::ruta() . "index.php?m=2");
                exit();
            } else {
                $sql = "SELECT * FROM tm_usuario WHERE usu_correo = ? AND rol_id = 1";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $correo);
                $sql->execute();
                $resultado = $sql->fetch();
                if ($resultado) {
                    $textoCifrado = $resultado["usu_pass"];

                    $iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($this->cipher));
                    $cifradoSinIV = substr(base64_decode($textoCifrado), openssl_cipher_iv_length($this->cipher));
                    $textoDecifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

                    if ($textoDecifrado == $pass) {
                        if (is_array($resultado) and count($resultado) > 0) {
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["usu_nomape"] = $resultado["usu_nomape"];
                            $_SESSION["usu_correo"] = $resultado["usu_correo"];
                            $_SESSION["usu_img"] = $resultado["usu_img"];
                            $_SESSION["rol_id"] = $resultado["rol_id"];
                            header("Location:" . Conectar::ruta() . "view/Home/");
                            exit();
                        }
                    } else {
                        header("Location:" . Conectar::ruta() . "index.php?m=3");
                        exit();
                    }
                } else {
                    header("Location:" . Conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
    }

    /*
            login_colaborador()
            Valida credenciales para acceso de personal (rol_id IN 2,3).
            Misma lógica de descifrado que login(), pero redirige a
            view/accesopersonal/ en caso de error y a view/homecolaborador/ si es exitoso.
        */
    public function login_colaborador()
    {
        $conectar = parent::conexion();
        parent::set_names();
        if (isset($_POST["enviar"])) {
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];
            if (empty($correo) and empty($pass)) {
                header("Location:" . conectar::ruta() . "view/accesopersonal/index.php?m=2");
                exit();
            } else {
                $sql = "SELECT * FROM tm_usuario WHERE usu_correo = ? AND rol_id IN (2,3)";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $correo);
                $sql->execute();
                $resultado = $sql->fetch();
                if ($resultado) {
                    $textoCifrado = $resultado["usu_pass"];

                    $iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($this->cipher));
                    $cifradoSinIV = substr(base64_decode($textoCifrado), openssl_cipher_iv_length($this->cipher));
                    $textoDecifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

                    if ($textoDecifrado == $pass) {
                        if (is_array($resultado) and count($resultado) > 0) {
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["usu_nomape"] = $resultado["usu_nomape"];
                            $_SESSION["usu_correo"] = $resultado["usu_correo"];
                            $_SESSION["usu_img"] = $resultado["usu_img"];
                            $_SESSION["rol_id"] = $resultado["rol_id"];
                            header("Location:" . Conectar::ruta() . "view/homecolaborador/");
                            exit();
                        }
                    } else {
                        header("Location:" . Conectar::ruta() . "view/accesopersonal/index.php?m=3");
                        exit();
                    }
                } else {
                    header("Location:" . Conectar::ruta() . "view/accesopersonal/index.php?m=1");
                    exit();
                }
            }
        }
    }

    /*
            registrar_usuario($usu_nomape, $usu_correo, $usu_pass, $usu_img, $est)
            Inserta un nuevo usuario en tm_usuario.
            Cifra la contraseña con AES-256-CBC antes de almacenarla.
            Retorna el ID del registro insertado mediante last_insert_id().
        */
    public function registrar_usuario($usu_nomape, $usu_correo, $usu_pass, $usu_img, $est)
    {
        /* TODO: Encriptar la contraseña */
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($usu_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);

        /* TODO: Obtener la conexión a la base de datos utilizando el método de la clase padre */
        $conectar = parent::conexion();
        /* TODO: Establecer el juego de caracteres a UTF-8 utilizando el método de la clase padre */
        parent::set_names();
        /* TODO: Consulta SQL para insertar un nuevo usuario en la tabla tm_usuario */
        $sql = "INSERT INTO tm_usuario
                (usu_nomape,usu_correo,usu_pass,usu_img,rol_id,est)
                VALUES
                (?,?,?,?,1,?)";
        /* TODO:Preparar la consulta SQL */
        $sql = $conectar->prepare($sql);
        /* TODO: Vincular los valores a los parámetros de la consulta */
        $sql->bindValue(1, $usu_nomape);
        $sql->bindValue(2, $usu_correo);
        $sql->bindValue(3, $textoCifrado);
        $sql->bindValue(4, $usu_img);
        $sql->bindValue(5, $est);
        /* TODO: Ejecutar la consulta SQL */
        $sql->execute();

        $sql1 = "select last_insert_id() as 'usu_id'";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $sql1->fetchAll();
    }

    /*
            get_usuario_correo($usu_correo)
            Busca un usuario por su dirección de correo electrónico.
            Retorna un array con los datos del usuario o vacío si no existe.
        */
    public function get_usuario_correo($usu_correo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario
                WHERE usu_correo = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_correo);
        $sql->execute();
        return $sql->fetchAll();
    }

    /*
            get_usuario_id($usu_id)
            Busca un usuario por su ID numérico.
            Retorna un array con los datos del usuario o vacío si no existe.
        */
    public function get_usuario_id($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_usuario
                WHERE usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $sql->fetchAll();
    }

    /*
            activar_usuario($usu_id)
            Activa la cuenta de un usuario cambiando est=1 y asignando fech_acti=NOW().
            El parámetro $usu_id llega cifrado desde el enlace de confirmación,
            por lo que primero se descifra con AES-256-CBC antes de ejecutar el UPDATE.
        */
    public function activar_usuario($usu_id)
    {
        $iv_dec = substr(base64_decode($usu_id), 0, openssl_cipher_iv_length($this->cipher));
        $cifradoSinIV = substr(base64_decode($usu_id), openssl_cipher_iv_length($this->cipher));
        $textoDecifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                    SET
                        est=1,
                        fech_acti = NOW()
                    WHERE
                        usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $textoDecifrado);
        $sql->execute();
    }

    /*
            recuperar_usuario($usu_correo, $usu_pass)
            Actualiza la contraseña de un usuario identificado por correo.
            Cifra la nueva contraseña con AES-256-CBC antes de almacenarla.
        */
    public function recuperar_usuario($usu_correo, $usu_pass)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($usu_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                SET
                usu_pass = ?
                WHERE
                usu_correo = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $textoCifrado);
        $sql->bindValue(2, $usu_correo);
        $sql->execute();
    }

    /*
            insert_colaborador($usu_nomape, $usu_correo, $rol_id)
            Inserta un nuevo colaborador (rol 2 o 3) en tm_usuario con est=1.
            Asigna una imagen por defecto (avatar.png).
            Retorna el ID del registro insertado.
        */
    public function insert_colaborador($usu_nomape, $usu_correo, $rol_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_usuario
            (usu_nomape,usu_correo,usu_img,rol_id,est)
            VALUES
            (?,?,'../../assets/picture/avatar.png',?,1)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nomape);
        $sql->bindValue(2, $usu_correo);
        $sql->bindValue(3, $rol_id);
        $sql->execute();

        $sql1 = "select last_insert_id() as 'usu_id'";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $sql1->fetchAll();
    }

    /*
            get_colaborador()
            Lista todos los colaboradores activos (est=1) con rol 2 o 3.
            Hace JOIN con tm_rol para obtener el nombre del rol.
            Retorna un array con id, nombre, correo, rol y fecha de creación.
        */
    public function get_colaborador()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                tm_usuario.usu_id,
                tm_usuario.usu_nomape,
                tm_usuario.usu_correo,
                tm_usuario.rol_id,
                tm_rol.rol_nom,
                tm_usuario.fech_crea
                FROM tm_usuario
                INNER JOIN tm_rol ON tm_usuario.rol_id = tm_rol.rol_id
                WHERE tm_usuario.est = 1
                AND tm_usuario.rol_id IN (2,3)
                ORDER BY usu_nomape";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }

    /*
            update_colaborador($usu_id, $usu_nomape, $usu_correo, $rol_id)
            Actualiza los datos de un colaborador: nombre, correo y rol.
            Asigna la fecha de modificación (fech_modi) con NOW().
        */
    public function update_colaborador($usu_id, $usu_nomape, $usu_correo, $rol_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
            SET
                usu_nomape = ?,
                usu_correo = ?,
                rol_id = ?,
                fech_modi = NOW()
            WHERE
                usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nomape);
        $sql->bindValue(2, $usu_correo);
        $sql->bindValue(3, $rol_id);
        $sql->bindValue(4, $usu_id);
        $sql->execute();
    }

    /*
            eliminar_colaborador($usu_id)
            Realiza un borrado lógico del colaborador: cambia est=0 y asigna fech_elim=NOW().
            No elimina físicamente el registro de la base de datos.
        */
    public function eliminar_colaborador($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                    SET
                        est = 0,
                        fech_elim = NOW()
                    WHERE
                        usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
    }

    /*
            get_usuario_permiso_area($usu_id)
            Obtiene las áreas a las que un usuario tiene permiso de acceso.
            Hace JOIN con tm_area y filtra solo permisos activos (aread_permi='Si').
            Retorna un array asociativo con id, área, permiso, nombre y correo del área.
        */
    public function get_usuario_permiso_area($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                td_area_detalle.aread_id,
                td_area_detalle.area_id,
                td_area_detalle.aread_permi,
                tm_area.area_nom,
                tm_area.area_correo 
                FROM td_area_detalle
                INNER JOIN tm_area ON tm_area.area_id = td_area_detalle.area_id
                WHERE 
                td_area_detalle.usu_id = ?
                AND td_area_detalle.aread_permi = 'Si'
                AND tm_area.est=1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }
    
    public function validar_password_actual($usu_id, $password_actual)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT usu_pass FROM tm_usuario WHERE usu_id = ? AND est = 1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        $resultado = $sql->fetch();

        if ($resultado) {
            $textoCifrado = $resultado["usu_pass"];
            $iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($this->cipher));
            $cifradoSinIV = substr(base64_decode($textoCifrado), openssl_cipher_iv_length($this->cipher));
            $textoDecifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);
            return $textoDecifrado === $password_actual;
        }

        return false;
    }

    public function actualizar_perfil_completo($usu_id, $usu_nomape, $usu_correo, $nueva_password = null)
    {
        $conectar = parent::conexion();
        parent::set_names();

        if ($nueva_password !== null) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
            $cifrado = openssl_encrypt($nueva_password, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $sql = "UPDATE tm_usuario
                    SET usu_nomape = ?,
                        usu_correo = ?,
                        usu_pass   = ?,
                        fech_modi  = NOW()
                    WHERE usu_id = ? AND est = 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_nomape);
            $sql->bindValue(2, $usu_correo);
            $sql->bindValue(3, $textoCifrado);
            $sql->bindValue(4, $usu_id);
        } else {
            $sql = "UPDATE tm_usuario
                    SET usu_nomape = ?,
                        usu_correo = ?,
                        fech_modi  = NOW()
                    WHERE usu_id = ? AND est = 1";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_nomape);
            $sql->bindValue(2, $usu_correo);
            $sql->bindValue(3, $usu_id);
        }

        if ($sql->execute()) {
            return $this->get_usuario_id($usu_id);
        }

        return false;
    }

    public function actualizar_avatar($usu_id, $usu_img)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_usuario
                SET usu_img   = ?,
                    fech_modi = NOW()
                WHERE usu_id = ? AND est = 1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_img);
        $sql->bindValue(2, $usu_id);
        return $sql->execute();
    }
}
