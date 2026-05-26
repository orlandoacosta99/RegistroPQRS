<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
if (isset($_SESSION["usu_id"])) {
?>
    <!doctype html>
    <html lang="es">

    <head>
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>Registro de PQRS | Editar Perfil</title>
        <?php require_once("../html/head.php") ?>
        <style>
            .avatar-wrapper {
                position: relative;
                width: 120px;
                height: 120px;
                margin: 0 auto 1rem;
            }
            .avatar-wrapper img {
                width: 120px;
                height: 120px;
                object-fit: cover;
                border-radius: 50%;
                border: 3px solid #e2e8f0;
            }
            .dropzone-avatar {
                border: 2px dashed #ced4da;
                border-radius: 8px;
                padding: 16px;
                text-align: center;
                cursor: pointer;
                background: #f8f9fa;
                min-height: unset !important;
            }
            .dropzone-avatar:hover {
                border-color: #5156be;
                background: #f0f0ff;
            }
            .dropzone-avatar .dz-message {
                margin: 0;
            }
            .dropzone-avatar .dz-preview .dz-image img {
                border-radius: 50%;
                width: 80px;
                height: 80px;
                object-fit: cover;
            }
        </style>
    </head>

    <body>

        <div id="layout-wrapper">

            <?php require_once("../html/header.php") ?>
            <?php require_once("../html/menu.php") ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Información de la Cuenta</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Editar Perfil</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Ingrese toda la información requerida.</h4>
                                            <p class="card-title-desc">Actualice su información personal y configure su contraseña.</p>
                                            <p class="card-title-desc mb-0">(*) Datos obligatorios.</p>
                                        </div>

                                        <div class="card-body">

                                            <!-- Foto de perfil actual -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h5 class="mb-3">Foto de Perfil</h5>
                                                </div>
                                                <div class="col-lg-3 text-center">
                                                    <div class="avatar-wrapper">
                                                        <img id="profile-avatar"
                                                             src="../../assets/picture/avatar-1.jpg"
                                                             alt="Foto de perfil">
                                                    </div>
                                                    <small class="text-muted">Imagen actual</small>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div id="dropzone-avatar" class="dropzone dropzone-avatar">
                                                        <div class="dz-message">
                                                            <i class="bx bx-image-add font-size-24 text-muted d-block mb-1"></i>
                                                            <span class="text-muted">
                                                                Arrastra y suelta o haz clic para cambiar la foto<br>
                                                                <small>JPG, PNG o WEBP · Máximo 1 MB · Se recorta a 300×300 px</small>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="avatar-error" class="text-danger mt-1 small"></div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- Datos personales -->
                                            <form method="post" id="documento_form">
                                                <input type="hidden" id="usu_id" name="usu_id">
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="usu_nomape" class="form-label">Nombres y Apellidos *</label>
                                                            <input type="text" class="form-control" id="usu_nomape" name="usu_nomape"
                                                                   placeholder="Ingrese Nombres y Apellidos" required>
                                                            <div class="validation-error text-danger small"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="usu_correo" class="form-label">Correo *</label>
                                                            <input type="email" class="form-control" id="usu_correo" name="usu_correo"
                                                                   placeholder="Ingrese su correo electrónico" required>
                                                            <div class="validation-error text-danger small"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Cambio de contraseña -->
                                                    <div class="col-12">
                                                        <hr class="my-4">
                                                        <h5 class="mb-3">Cambiar Contraseña</h5>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="cambiar_password">
                                                            <label class="form-check-label" for="cambiar_password">
                                                                Deseo cambiar mi contraseña
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div id="password_fields" class="row g-3" style="display: none;">
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label for="usu_pass_actual" class="form-label">Contraseña Actual</label>
                                                                <input type="password" class="form-control" id="usu_pass_actual"
                                                                       name="usu_pass_actual" placeholder="Contraseña actual">
                                                                <div class="validation-error text-danger small"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label for="usu_pass_nueva" class="form-label">Nueva Contraseña</label>
                                                                <input type="password" class="form-control" id="usu_pass_nueva"
                                                                       name="usu_pass_nueva" placeholder="Nueva contraseña">
                                                                <div class="validation-error text-danger small"></div>
                                                                <div class="form-text">Mínimo 6 caracteres</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label for="usu_pass_confirmar" class="form-label">Confirmar Contraseña</label>
                                                                <input type="password" class="form-control" id="usu_pass_confirmar"
                                                                       name="usu_pass_confirmar" placeholder="Confirmar nueva contraseña">
                                                                <div class="validation-error text-danger small"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                                        <button type="button" id="btnlimpiar"
                                                                class="btn btn-secondary waves-effect waves-light">
                                                            <i class="bx bx-reset align-middle me-1"></i>Limpiar
                                                        </button>
                                                        <button type="submit" id="btnguardar"
                                                                class="btn btn-primary waves-effect waves-light">
                                                            <i class="bx bx-save align-middle me-1"></i>Guardar Cambios
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <?php require_once("../html/footer.php") ?>

            </div>

        </div>

        <?php require_once("../html/sidebar.php") ?>

        <div class="rightbar-overlay"></div>

        <?php require_once("../html/js.php") ?>

        <script type="text/javascript" src="actualizar.js"></script>

    </body>

    </html>
<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>
