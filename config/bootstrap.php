<?php
/**
 * bootstrap.php — Carga de variables de entorno.
 *
 * Implementa un parser propio de .env que funciona SIN Composer/phpdotenv.
 * Esto garantiza que las variables estén disponibles en $_ENV
 * independientemente del estado de include/vendor/.
 *
 * Orden de carga:
 *  1. Parser integrado lee .env → popula $_ENV, $_SERVER y putenv()
 *  2. Autoloader de Composer (si vendor/ existe)
 *  3. Autoloader de Composer registrado — el parser propio es suficiente
 */

// ----------------------------------------------------------
// 1. Parser integrado de .env — no requiere Composer ni extensiones
// ----------------------------------------------------------
$_envFile = __DIR__ . '/../.env';

if (file_exists($_envFile) && is_readable($_envFile)) {
    $lines = file($_envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // Ignorar comentarios y líneas vacías
        if ($line === '' || $line[0] === '#') {
            continue;
        }

        // Debe contener al menos un "=" para ser un par clave=valor
        if (strpos($line, '=') === false) {
            continue;
        }

        // Separar clave y valor — limit 2 para preservar "=" en valores como URLs
        $parts = explode('=', $line, 2);
        $name  = trim($parts[0]);
        $value = isset($parts[1]) ? trim($parts[1]) : '';

        // Eliminar comillas simples o dobles envolventes del valor
        // Ej: APP_NAME="Mesa de Partes" → Mesa de Partes
        $len = strlen($value);
        if ($len >= 2) {
            $first = $value[0];
            $last  = substr($value, -1);
            if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                $value = substr($value, 1, $len - 2);
            }
        }

        // Ignorar claves vacías
        if ($name === '') {
            continue;
        }

        // Solo setear si la variable no existe ya en el entorno real
        // (respeta variables definidas por el servidor/sistema operativo)
        if (!isset($_ENV[$name])) {
            $_ENV[$name]    = $value;
            $_SERVER[$name] = $value;
        }
        if (getenv($name) === false) {
            putenv("{$name}={$value}");
        }
    }
}

unset($_envFile, $lines, $line, $parts, $name, $value, $len, $first, $last);

// ----------------------------------------------------------
// 2. Autoloader de Composer (PHPMailer + phpdotenv si fue instalado)
// ----------------------------------------------------------
$_vendorAutoload = __DIR__ . '/../include/vendor/autoload.php';

if (file_exists($_vendorAutoload)) {
    require_once $_vendorAutoload;
}

unset($_vendorAutoload);

// ----------------------------------------------------------
// 3. Autoloader de Composer ya cargó phpdotenv si fue instalado.
//    El parser integrado (paso 1) es suficiente para cargar .env.
//    No se llama a Dotenv\Dotenv directamente para evitar errores
//    cuando la librería no está presente en vendor/.
// ----------------------------------------------------------
