<?php
/**
 * ErrorHandler — manejo centralizado de errores del sistema.
 * Registra en logs/errors.log y redirige a view/Error/ con contexto de sesión.
 */
class ErrorHandler
{
    private static $logFile = __DIR__ . '/../logs/errors.log';

    /**
     * Escribe una entrada en el archivo de log.
     *
     * @param string $type    Categoría del error (DB_CONNECTION, DB_QUERY, SERVER, etc.)
     * @param string $message Descripción técnica del error
     * @param array  $context Datos adicionales (query, parámetros, etc.)
     */
    public static function log(string $type, string $message, array $context = []): void
    {
        $timestamp  = date('Y-m-d H:i:s');
        $ip         = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $url        = ($_SERVER['REQUEST_URI'] ?? 'unknown');
        $contextStr = !empty($context) ? ' | ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        $entry      = "[$timestamp] [$type] [IP: $ip] [URL: $url] $message$contextStr" . PHP_EOL;

        $dir = dirname(self::$logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents(self::$logFile, $entry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Guarda el error en sesión y redirige a la página de error.
     *
     * @param string      $type    Tipo de error legible: 'db_connection' | 'db_query' | 'server' | 'auth'
     * @param string      $message Mensaje amigable para mostrar al usuario
     * @param string|null $code    Código de referencia (autogenerado si es null)
     */
    public static function redirect(string $type, string $message, ?string $code = null): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['error_type']    = $type;
        $_SESSION['error_message'] = $message;
        $_SESSION['error_code']    = $code ?? strtoupper($type) . '-' . date('YmdHis');
        $_SESSION['error_time']    = date('d/m/Y H:i:s');

        header('Location: ' . Conectar::ruta() . 'view/Error/');
        exit();
    }
}
