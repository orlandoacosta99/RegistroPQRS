<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carga bootstrap para tener acceso a BASE_URL desde .env
$bootstrapPath = __DIR__ . '/../../config/bootstrap.php';
if (file_exists($bootstrapPath)) {
    require_once $bootstrapPath;
}

$baseUrl = rtrim($_ENV['BASE_URL'] ?? 'http://localhost/RegistroPQRS/', '/') . '/';

// -------------------------------------------------------
// Fuente 1: error redirigido desde PHP (ErrorHandler)
// -------------------------------------------------------
$errorType    = $_SESSION['error_type']    ?? null;
$errorMessage = $_SESSION['error_message'] ?? null;
$errorCode    = $_SESSION['error_code']    ?? null;
$errorTime    = $_SESSION['error_time']    ?? date('d/m/Y H:i:s');
unset($_SESSION['error_type'], $_SESSION['error_message'], $_SESSION['error_code'], $_SESSION['error_time']);

// -------------------------------------------------------
// Fuente 2: error capturado por Apache (.htaccess ErrorDocument)
// -------------------------------------------------------
$httpCode = (int) ($_GET['code'] ?? $_SERVER['REDIRECT_STATUS'] ?? 0);

if ($errorType === null) {
    switch ($httpCode) {
        case 404:
            $errorType    = 'page_not_found';
            $errorMessage = 'La página que intentas acceder no existe o ha sido movida.';
            $errorCode    = 'HTTP-404';
            break;
        case 403:
            $errorType    = 'auth';
            $errorMessage = 'No tienes permiso para acceder a este recurso.';
            $errorCode    = 'HTTP-403';
            break;
        case 400:
            $errorType    = 'server';
            $errorMessage = 'La solicitud enviada no es válida.';
            $errorCode    = 'HTTP-400';
            break;
        case 500:
            $errorType    = 'server';
            $errorMessage = 'El servidor encontró un error interno. Por favor, intente más tarde.';
            $errorCode    = 'HTTP-500';
            break;
        case 503:
            $errorType    = 'server';
            $errorMessage = 'El servicio no está disponible temporalmente. Por favor, intente en unos minutos.';
            $errorCode    = 'HTTP-503';
            break;
        default:
            $errorType    = 'general';
            $errorMessage = 'Ha ocurrido un error inesperado en el sistema.';
            $errorCode    = 'HTTP-' . ($httpCode ?: 'ERR');
            break;
    }
}

// -------------------------------------------------------
// Configuración visual por tipo de error
// -------------------------------------------------------
$config = [
    'page_not_found' => [
        'titulo'      => 'Página No Encontrada',
        'icono'       => 'bx bx-search-alt',
        'color'       => 'warning',
        'badge'       => 'Error 404',
        'hint'        => 'Verifique que la URL sea correcta o use el botón de inicio para navegar.',
        'display_num' => '404',
    ],
    'db_connection' => [
        'titulo'      => 'Sin Conexión a la Base de Datos',
        'icono'       => 'bx bx-server',
        'color'       => 'danger',
        'badge'       => 'Error de Servidor',
        'hint'        => 'El servidor de base de datos no está disponible. Verifique que MySQL esté activo.',
        'display_num' => '500',
    ],
    'db_query' => [
        'titulo'      => 'Error en la Consulta',
        'icono'       => 'bx bx-data',
        'color'       => 'warning',
        'badge'       => 'Error de Base de Datos',
        'hint'        => 'Se produjo un error al procesar la operación solicitada en la base de datos.',
        'display_num' => '500',
    ],
    'server' => [
        'titulo'      => 'Error del Servidor',
        'icono'       => 'bx bx-cloud-lightning',
        'color'       => 'danger',
        'badge'       => 'Error 500',
        'hint'        => 'El servidor encontró una condición inesperada que impidió completar la solicitud.',
        'display_num' => '500',
    ],
    'auth' => [
        'titulo'      => 'Acceso No Autorizado',
        'icono'       => 'bx bx-lock-alt',
        'color'       => 'warning',
        'badge'       => 'Error 403',
        'hint'        => 'No tiene permisos para acceder a este recurso. Inicie sesión con una cuenta autorizada.',
        'display_num' => '403',
    ],
    'general' => [
        'titulo'      => 'Algo Salió Mal',
        'icono'       => 'bx bx-error-circle',
        'color'       => 'danger',
        'badge'       => 'Error',
        'hint'        => 'Ha ocurrido un error inesperado. Si el problema persiste, contacte al administrador.',
        'display_num' => 'ERR',
    ],
];

$cfg = $config[$errorType] ?? $config['general'];
?>
<!doctype html>
<html lang="es">

<head>
    <!--
        <base> DEBE ir primero para que todos los paths relativos de head.php
        (../../assets/...) resuelvan correctamente desde cualquier URL de error.
    -->
    <base href="<?= htmlspecialchars($baseUrl . 'view/Error/') ?>">

    <meta charset="utf-8">
    <title>Error <?= htmlspecialchars($cfg['display_num']) ?> | Registro de PQRS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <?php require_once('../html/head.php'); ?>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="error-page-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">

                    <div class="card error-card p-4 p-md-5">
                        <div class="card-body text-center">

                            <!-- Número de error grande -->
                            <div class="error-num text-<?= $cfg['color'] ?> mb-2">
                                <?= htmlspecialchars($cfg['display_num']) ?>
                            </div>

                            <!-- Ícono contextual -->
                            <div class="error-icon-wrapper bg-<?= $cfg['color'] ?>-subtle text-<?= $cfg['color'] ?>">
                                <i class="<?= $cfg['icono'] ?>"></i>
                            </div>

                            <!-- Badge de categoría -->
                            <span class="badge bg-<?= $cfg['color'] ?>-subtle text-<?= $cfg['color'] ?> mb-3 px-3 py-2">
                                <?= htmlspecialchars($cfg['badge']) ?>
                            </span>

                            <!-- Título -->
                            <h3 class="fw-semibold mb-3"><?= htmlspecialchars($cfg['titulo']) ?></h3>

                            <!-- Mensaje amigable -->
                            <p class="text-muted mb-4">
                                <?= htmlspecialchars($errorMessage) ?>
                            </p>

                            <!-- Sugerencia técnica -->
                            <div class="alert alert-light text-start mb-4" role="alert">
                                <i class="bx bx-info-circle me-2"></i>
                                <small><?= htmlspecialchars($cfg['hint']) ?></small>
                            </div>

                            <!-- Código de referencia para soporte -->
                            <?php if ($errorCode): ?>
                                <div class="mb-4">
                                    <small class="text-muted d-block mb-1">
                                        Código de referencia para soporte técnico:
                                    </small>
                                    <span class="error-code-box d-inline-block">
                                        <i class="bx bx-hash me-1"></i><?= htmlspecialchars($errorCode) ?>
                                    </span>
                                    <div class="text-muted mt-1">
                                        <i class="bx bx-time-five me-1"></i><?= htmlspecialchars($errorTime) ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Botones de acción -->
                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center mt-4">
                                <a href="../../index.php"
                                    class="btn btn-primary waves-effect waves-light action-btn">
                                    <i class="bx bx-home-alt me-2"></i>Ir al Inicio
                                </a>
                                <button type="button"
                                    onclick="history.back()"
                                    class="btn btn-outline-secondary waves-effect action-btn">
                                    <i class="bx bx-arrow-back me-2"></i>Volver Atrás
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Pie -->
                    <div class="mb-3 bg-transparent border-primary">
                        <p class="text-center mt-3 mb-0">
                            <small style="color: #f7f7f7 !important;"> <!-- Color deseado -->
                                <i class="bx bx-building-house me-1"></i>Registro de PQRS — orlandoacosta99
                                &nbsp;|&nbsp;Si el error persiste, contacte al administrador del sistema.
                            </small>
                        </p>
                    </div>

                </div>
            </div>

            <!-- Imagen decorativa -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-6 col-xl-4 text-center">
                    <img src="../../assets/picture/error-img.png"
                        alt="Ilustración de error"
                        class="img-fluid">
                </div>
            </div>

        </div>
    </div>

    <?php require_once('../html/js.php'); ?>
</body>

</html>