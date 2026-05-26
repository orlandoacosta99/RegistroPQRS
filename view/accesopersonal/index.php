<?php
require_once("../../config/conexion.php");
if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
    require_once("../../models/Usuario.php");
    $usuario = new Usuario();
    $usuario->login_colaborador();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Colaborador |  Registro de PQRS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <?php
    require_once("../html/head.php");
    ?>
</head>

<body>

    <!-- <body data-layout="horizontal"> -->
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="index-1.html" class="d-block auth-logo">
                                        <img src="../../assets/picture/logo-sm-1.svg" alt="" height="28"> <span class="logo-txt">Code</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Registro de PQRS (Colaborador)</h5>
                                        <p class="text-muted mt-2">Ingrese sus credenciales de Colaborador.</p>
                                    </div>
                                    <form class="custom-form mt-4 pt-2" action="" method="post">

                                        <?php
                                        if (isset($_GET["m"])) {
                                            switch ($_GET["m"]) {
                                                case "1":
                                        ?>
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <i class="mdi mdi-block-helper me-2"></i>
                                                        Correo Electronico no encontrado.
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php
                                                    break;

                                                case "2":
                                                ?>
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <i class="mdi mdi-block-helper me-2"></i>
                                                        Campos Vacios.
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php
                                                    break;

                                                case "3":
                                                ?>
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <i class="mdi mdi-block-helper me-2"></i>
                                                        Contraseña Incorrecta.
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                        <?php
                                                    break;
                                            }
                                        }
                                        ?>

                                        <div class="mb-3">
                                            <label class="form-label">Correo Electronico</label>
                                            <input type="email" class="form-control" id="usu_correo" name="usu_correo" placeholder="Ingrese Correo Electronico" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Contraseña</label>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="">
                                                        <a href="../../view/recuperarcolaborador/index.php" class="text-muted">Olvidaste tu contraseña?</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" id="usu_pass" name="usu_pass" placeholder="Ingrese Contraseña" aria-label="Password" aria-describedby="password-addon" required>
                                                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remember-check">
                                                    <label class="form-check-label" for="remember-check">
                                                        Recuerdame
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" name="enviar" value="si">
                                            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Acceder</button>
                                        </div>
                                    </form>

                                    <div class="mt-4 pt-2 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="font-size-14 mb-3 text-muted fw-medium">- Acceder con -</h5>
                                        </div>

                                        <ul class="list-inline mb-0">

                                            <li class="list-inline-item">

                                                <!--TODO: Botón "Iniciar sesión con Google" con atributos de datos HTML para la API -->
                                                <div id="g_id_onload"
                                                    data-client_id="1013986495579-bvrdis9mqq2uirapcgk2n8napef4c8ti.apps.googleusercontent.com"
                                                    data-context="signin"
                                                    data-ux_mode="popup"
                                                    data-callback="handleCredentialResponse"
                                                    data-auto_prompt="false">
                                                </div>

                                                <!--TODO: Configuración del botón de inicio de sesión con Google -->
                                                <div class="g_id_signin"
                                                    data-type="standard"
                                                    data-shape="rectangular"
                                                    data-theme="outline"
                                                    data-text="signin_with"
                                                    data-size="large"
                                                    data-logo_alignment="left"></div>

                                            </li>

                                        </ul>
                                    </div>
                                    <div class="mt-5 text-center">
                                         
                                            <p class="text-muted mb-0">Volver a <a href="../../" class="text-primary fw-semibold"> Inicio</a> </p>
                                        </div>
                                </div>
                                 
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                        </script> orlandoacosta99 <i class="mdi mdi-heart text-danger"></i> RegistroPQRS.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <?php require_once("../html/carrusel.php") ?>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>

    <?php
    require_once("../html/js.php");
    ?>
    <script type="text/javascript" src="accesopersonal.js"></script>
</body>

</html>