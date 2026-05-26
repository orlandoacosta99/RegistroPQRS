<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Confirmar |  Registro de PQRS</title>
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
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="../../assets/picture/logo-sm.svg" alt="" height="28"> <span class="logo-txt">Minia</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title rounded-circle bg-light">
                                                <i class="bx bx-mail-send h2 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="p-2 mt-4">
                                            <h4>Gracias por Confirmar !</h4>
                                            <p class="text-muted">Su cuenta a sido validada, ya puede regresar a la pantalla principal y acceder al sistema de Registro de PQRS.</p>
                                            <div class="mt-4">
                                                <a href="../../index.php" class="btn btn-primary w-100">Regresar a Acceder</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                        </script> orlandoacosta99 <i class="mdi mdi-heart text-danger"></i> mesadepartes.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>

                <?php require_once("../html/carrusel.php") ?>

            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>


    <?php
    require_once("../html/js.php");
    ?>

    <script type="text/javascript" src="confirmar.js"></script>

</body>

</html>