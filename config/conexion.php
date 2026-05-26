<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carga vendor autoload + variables .env antes que cualquier otra cosa
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/ErrorHandler.php';

/**
 * Clase Conectar — gestiona la conexión PDO a MySQL.
 *
 * Credenciales leídas desde variables de entorno (.env).
 * Implementa reintentos automáticos (3 intentos con 500 ms de pausa)
 * antes de redirigir a la página de error con logging completo.
 */
class Conectar
{
    protected $dbh;

    private static $maxRetries   = 3;
    private static $retryDelayMs = 500;

    /**
     * Establece la conexión PDO. Lee DB_* desde $_ENV con fallback a defaults.
     * Si los 3 intentos fallan, registra el error y redirige a view/Error/.
     */
    protected function conexion()
    {
        $host   = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname = $_ENV['DB_NAME'] ?? 'mesadepartes';
        $user   = $_ENV['DB_USER'] ?? 'root';
        $pass   = $_ENV['DB_PASS'] ?? '';

        $attempt       = 0;
        $lastException = null;

        while ($attempt < self::$maxRetries) {
            $attempt++;
            try {
                $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT            => 5,
                ];
                $this->dbh = new PDO($dsn, $user, $pass, $options);
                return $this->dbh;

            } catch (PDOException $e) {
                $lastException = $e;
                ErrorHandler::log(
                    'DB_CONNECTION',
                    "Intento {$attempt} de " . self::$maxRetries . " fallido: " . $e->getMessage()
                );
                if ($attempt < self::$maxRetries) {
                    usleep(self::$retryDelayMs * 1000);
                }
            }
        }

        // Todos los intentos fallaron — redirige a página de error
        $code = 'DB-' . date('YmdHis');
        ErrorHandler::log(
            'DB_CONNECTION_FATAL',
            'Todos los intentos de conexión fallaron. Último: ' . $lastException->getMessage(),
            ['code' => $code]
        );
        ErrorHandler::redirect(
            'db_connection',
            'No se pudo conectar a la base de datos después de ' . self::$maxRetries . ' intentos. '
            . 'Por favor, intente nuevamente en unos minutos.',
            $code
        );
    }

    /**
     * Establece el charset UTF-8 en la conexión activa.
     */
    public function set_names()
    {
        try {
            return $this->dbh->query("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            ErrorHandler::log('DB_QUERY', 'SET NAMES falló: ' . $e->getMessage());
        }
    }

    /**
     * Retorna la URL base del proyecto desde .env o valor por defecto.
     */
    public static function ruta(): string
    {
        return rtrim($_ENV['BASE_URL'] ?? 'http://localhost/RegistroPQRS/', '/') . '/';
    }

    /**
     * Ejecuta un prepared statement con manejo de errores centralizado.
     * En caso de fallo redirige a view/Error/ con logging completo.
     *
     * @param string $sql    Query con marcadores ?
     * @param array  $params Parámetros del prepared statement
     */
    protected function ejecutar(string $sql, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $code = 'QRY-' . date('YmdHis');
            ErrorHandler::log('DB_QUERY', $e->getMessage(), ['sql' => $sql, 'code' => $code]);
            ErrorHandler::redirect(
                'db_query',
                'Ocurrió un error al procesar la operación solicitada.',
                $code
            );
        }
    }
}
