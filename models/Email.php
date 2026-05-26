<?php
/*
    Modelo: Email
    Extiende: PHPMailer\PHPMailer\PHPMailer
    Propósito: Envío de correos transaccionales vía SMTP (Gmail).
               Gestiona confirmación de registro, recuperación de contraseña,
               notificación de nuevo trámite y respuesta de trámite.
               Credenciales leídas desde variables de entorno (.env).
*/

// bootstrap.php ya carga el autoloader vía config/conexion.php,
// pero se guarda require_once como red de seguridad.
require_once __DIR__ . '/../include/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Usuario.php';

class Email extends PHPMailer
{
    protected $gCorreo     = '';
    protected $gContrasena = '';

    private $key    = '';
    private $cipher = 'aes-256-cbc';

    /**
     * Constructor: carga credenciales desde variables de entorno.
     * PHPMailer acepta $exceptions = true para lanzar excepciones en lugar de retornar false.
     */
    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);
        // getenv() como fallback si variables_order en php.ini omite 'E'
        $this->gCorreo     = $_ENV['MAIL_USERNAME'] ?? (getenv('MAIL_USERNAME') ?: '');
        $this->gContrasena = $_ENV['MAIL_PASSWORD'] ?? (getenv('MAIL_PASSWORD') ?: '');
        $this->key         = $_ENV['AES_KEY']       ?? (getenv('AES_KEY')       ?: '');
        $this->cipher      = $_ENV['AES_CIPHER']    ?? (getenv('AES_CIPHER')    ?: 'aes-256-cbc');
    }

    /**
     * Configura los parámetros SMTP comunes leyendo desde $_ENV.
     * Centraliza la configuración para evitar repetición en cada método.
     */
    private function configurarSMTP(string $fromLabel = ''): void
    {
        $this->isSMTP();
        $this->Host       = $_ENV['MAIL_HOST'] ?? (getenv('MAIL_HOST') ?: 'smtp.gmail.com');
        $this->Port       = (int) ($_ENV['MAIL_PORT'] ?? (getenv('MAIL_PORT') ?: 465));
        $this->SMTPAuth   = true;

        $encryption = strtolower($_ENV['MAIL_ENCRYPTION'] ?? (getenv('MAIL_ENCRYPTION') ?: 'ssl'));
        $this->SMTPSecure = ($encryption === 'tls')
            ? PHPMailer::ENCRYPTION_STARTTLS
            : PHPMailer::ENCRYPTION_SMTPS;

        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->CharSet  = 'UTF8';

        $fromName = $fromLabel ?: ($_ENV['MAIL_FROM_NAME'] ?? (getenv('MAIL_FROM_NAME') ?: 'Registro PQRS'));
        $this->setFrom($this->gCorreo, $fromName);
    }

    /*
        registrar($usu_id)
        Envía un correo de confirmación de registro al usuario.
        Cifra el ID del usuario con AES-256-CBC para generar un enlace seguro
        de activación (view/confirmar/?id=...).
        Carga la plantilla registrar.html y reemplaza xlinkcorreourl con el enlace.
        Retorna true si se envió correctamente, false en caso de error.
    */
    public function registrar(int $usu_id): bool
    {
        $usuario = new Usuario();
        $datos   = $usuario->get_usuario_id($usu_id);

        $iv           = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado      = openssl_encrypt((string) $usu_id, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        $textoCifrado = base64_encode($iv . $cifrado);

        $this->configurarSMTP('Registro en Registro PQRS');
        $this->addAddress($datos[0]['usu_correo']);
        $this->isHTML(true);
        $this->Subject = 'Registro PQRS — Confirmación de Registro';

        $url    = Conectar::ruta() . 'view/confirmar/?id=' . $textoCifrado;
        $cuerpo = file_get_contents(__DIR__ . '/../assets/email/registrar.html');
        $cuerpo = str_replace('xlinkcorreourl', $url, $cuerpo);

        $this->Body    = $cuerpo;
        $this->AltBody = 'Confirmar Registro';

        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            error_log('[Email::registrar] ' . $e->getMessage());
            return false;
        }
    }

    /*
        recuperar($usu_correo)
        Envía un correo con una nueva contraseña temporal generada aleatoriamente.
        Primero genera la pass con generarXPassUsu(), la actualiza en la BD
        mediante recuperar_usuario(), luego envía el correo con la plantilla recuperar.html.
        Retorna true si se envió correctamente, false en caso de error.
    */
    public function recuperar(string $usu_correo): bool
    {
        $usuario  = new Usuario();
        $datos    = $usuario->get_usuario_correo($usu_correo);
        $xpassusu = $this->generarXPassUsu();
        $usuario->recuperar_usuario($usu_correo, $xpassusu);

        $this->configurarSMTP('Recuperar Contraseña — Registro PQRS');
        $this->addAddress($datos[0]['usu_correo']);
        $this->isHTML(true);
        $this->Subject = 'Registro PQRS — Recuperación de Contraseña';

        $cuerpo = file_get_contents(__DIR__ . '/../assets/email/recuperar.html');
        $cuerpo = str_replace('xpassusu',     $xpassusu,        $cuerpo);
        $cuerpo = str_replace('xlinksistema', Conectar::ruta(), $cuerpo);

        $this->Body    = $cuerpo;
        $this->AltBody = 'Recupera Contraseña';

        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            error_log('[Email::recuperar] ' . $e->getMessage());
            return false;
        }
    }

    public function nuevo_colaborador(int $usu_id): bool
    {
        $usuario  = new Usuario();
        $datos    = $usuario->get_usuario_id($usu_id);
        $xpassusu = $this->generarXPassUsu();
        $usuario->recuperar_usuario($datos[0]['usu_correo'], $xpassusu);

        $this->configurarSMTP('Bienvenido Colaborador — Registro PQRS');
        $this->addAddress($datos[0]['usu_correo']);
        $this->isHTML(true);
        $this->Subject = 'Registro PQRS — Acceso de Colaborador';

        $url    = Conectar::ruta() . 'view/accesopersonal/';
        $cuerpo = file_get_contents(__DIR__ . '/../assets/email/nuevocolaborador.html');
        $cuerpo = str_replace('xemail',       $datos[0]['usu_correo'], $cuerpo);
        $cuerpo = str_replace('xpassusu',     $xpassusu,              $cuerpo);
        $cuerpo = str_replace('xlinksistema', $url,                   $cuerpo);

        $this->Body    = $cuerpo;
        $this->AltBody = 'Acceso de Colaborador';

        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            error_log('[Email::nuevo_colaborador] ' . $e->getMessage());
            return false;
        }
    }

    /*
        generarXPassUsu()
        (Privado) Genera una contraseña temporal aleatoria de 6 caracteres.
        Combina 3 caracteres alfanuméricos de md5(rand()) y 3 dígitos numéricos.
    */
    private function generarXPassUsu(): string
    {
        $parteAlfanumerica = substr(md5((string) rand()), 0, 3);
        $parteNumerica     = str_pad((string) rand(0, 999), 3, '0', STR_PAD_LEFT);
        return substr($parteAlfanumerica . $parteNumerica, 0, 6);
    }

    /*
        enviar_registro($doc_id)
        Envía un correo de notificación al usuario y al área correspondiente
        cuando se registra un nuevo trámite.
        Carga la plantilla enviar.html y reemplaza los placeholders
        con los datos del documento (nrotramite, area, tramite, etc.).
        Retorna true si se envió correctamente, false en caso de error.
    */
    public function enviar_registro(int $doc_id): bool
    {
        $documento = new Documento();
        $datos     = $documento->get_documento_x_id($doc_id);

        $this->configurarSMTP('Nuevo Trámite — Registro PQRS');
        $this->addAddress($datos[0]['usu_correo']);
        $this->addAddress($datos[0]['area_correo']);
        $this->isHTML(true);
        $this->Subject = 'Registro PQRS — Nuevo Trámite Registrado';

        $cuerpo = file_get_contents(__DIR__ . '/../assets/email/enviar.html');
        $cuerpo = str_replace('xlinksistema', Conectar::ruta(),         $cuerpo);
        $cuerpo = str_replace('xnrotramite',  $datos[0]['nrotramite'],  $cuerpo);
        $cuerpo = str_replace('xarea',        $datos[0]['area_nom'],    $cuerpo);
        $cuerpo = str_replace('xtramite',     $datos[0]['tra_nom'],     $cuerpo);
        $cuerpo = str_replace('xnroexterno',  $datos[0]['doc_externo'], $cuerpo);
        $cuerpo = str_replace('xtipo',        $datos[0]['tip_nom'],     $cuerpo);
        $cuerpo = str_replace('xcant',        $datos[0]['cant'],        $cuerpo);

        $this->Body    = $cuerpo;
        $this->AltBody = 'Nuevo Trámite Registrado';

        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            error_log('[Email::enviar_registro] ' . $e->getMessage());
            return false;
        }
    }

    /*
        respuesta_registro($doc_id)
        Envía un correo de respuesta al usuario cuando su trámite es respondido.
        Carga la plantilla respuesta.html y reemplaza los placeholders
        con los datos del documento.
        Retorna true si se envió correctamente, false en caso de error.
    */
    public function respuesta_registro(int $doc_id): bool
    {
        $documento = new Documento();
        $datos     = $documento->get_documento_x_id($doc_id);

        $this->configurarSMTP('Respuesta de Trámite — Registro PQRS');
        $this->addAddress($datos[0]['usu_correo']);
        $this->isHTML(true);
        $this->Subject = 'Registro PQRS — Respuesta a su Trámite';

        $cuerpo = file_get_contents(__DIR__ . '/../assets/email/respuesta.html');
        $cuerpo = str_replace('xlinksistema', Conectar::ruta(),         $cuerpo);
        $cuerpo = str_replace('xnrotramite',  $datos[0]['nrotramite'],  $cuerpo);
        $cuerpo = str_replace('xarea',        $datos[0]['area_nom'],    $cuerpo);
        $cuerpo = str_replace('xtramite',     $datos[0]['tra_nom'],     $cuerpo);
        $cuerpo = str_replace('xnroexterno',  $datos[0]['doc_externo'], $cuerpo);
        $cuerpo = str_replace('xtipo',        $datos[0]['tip_nom'],     $cuerpo);
        $cuerpo = str_replace('xcant',        $datos[0]['cant'],        $cuerpo);

        $this->Body    = $cuerpo;
        $this->AltBody = 'Respuesta de Trámite';

        try {
            $this->send();
            return true;
        } catch (Exception $e) {
            error_log('[Email::respuesta_registro] ' . $e->getMessage());
            return false;
        }
    }
}
