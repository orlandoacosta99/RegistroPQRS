<?php
    require_once("../../config/conexion.php");
    require_once("../../models/Rol.php");
    $rol = new Rol();
    $datos = $rol->validar_menu_x_rol($_SESSION["rol_id"],"iniciocolaborador");
    if(isset($_SESSION["usu_id"]) and count($datos)>0){
?>
<!doctype html>
<html lang="es">
    <head>
        <title>Registro de PQRS | Inicio Registro de PQRS</title>
        <?php require_once("../html/head.php")?>
    </head>

    <body>

        <div id="layout-wrapper">

            <?php require_once("../html/header.php")?>

            <?php require_once("../html/menu.php")?>

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Inicio Colaborador</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Starter Page</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>

                                <div class="card border border-primary">
                                    <div class="card-header bg-transparent border-primary">
                                        <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Instrucciones para el registro de Registro de PQRS</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Leer Atentamente:</h5>
                                        <p class="card-text">Bienvenido al sistema de Registro de PQRS - Módulo Colaborador. A continuación se detallan los pasos para utilizar cada una de las pantallas disponibles.</p>

                                        <div class="card mt-3 mb-3 border border-secondary">
                                            <div class="card-header bg-transparent border-secondary">
                                                <h6 class="my-0"><i class="mdi mdi-format-list-bulleted me-2"></i>Índice de Contenidos</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <ul class="mb-0">
                                                            <li><a href="#nuevo-tramite">📋 Nuevo Trámite</a></li>
                                                            <li><a href="#consultar-tramite">🔍 Consultar Trámite</a></li>
                                                            <li><a href="#buscar-tramite">🔎 Buscar Trámite</a></li>
                                                            <li><a href="#gestionar-tramite">⚙️ Gestionar Trámite</a></li>
                                                            <li><a href="#mnt-area">🏢 Mantenimiento de Área</a></li>
                                                            <li><a href="#mnt-tramite">📄 Mantenimiento de Trámite</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul class="mb-0">
                                                            <li><a href="#mnt-tipo">🏷️ Mantenimiento de Tipo</a></li>
                                                            <li><a href="#mnt-rol">👥 Mantenimiento de Rol</a></li>
                                                            <li><a href="#mnt-colaborador">👤 Mantenimiento de Colaborador</a></li>
                                                            <li><a href="#acceso-personal">🔑 Acceso Personal</a></li>
                                                            <li><a href="#perfil-usuario">👤 Perfil de Usuario</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h6 class="card-title mt-4" id="nuevo-tramite">📋 Nuevo Trámite</h6>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Nuevo Trámite"</strong> para acceder al formulario de registro.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Seleccione el <strong>Área</strong> de destino (campo obligatorio). Esta indica a qué departamento o área se dirigirá su documento.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Seleccione el tipo de <strong>Trámite</strong> que desea registrar (campo obligatorio).</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Si cuenta con un <strong>Número Externo</strong> de documento, ingréselo en el campo correspondiente (opcional).</p>
                                        <p class="card-text"><strong>Paso 5:</strong> Seleccione el <strong>Tipo</strong> de documento (campo obligatorio).</p>
                                        <p class="card-text"><strong>Paso 6:</strong> Ingrese su <strong>DNI o RUC</strong> (campo obligatorio) y su <strong>Nombre o Razón Social</strong> (campo obligatorio).</p>
                                        <p class="card-text"><strong>Paso 7:</strong> Escriba una <strong>Descripción</strong> detallada del trámite que está realizando (campo obligatorio).</p>
                                        <p class="card-text"><strong>Paso 8:</strong> Adjunte los archivos de respaldo haciendo clic en el área de carga o arrastrando los archivos. Puede adjuntar un máximo de <strong>5 archivos PDF</strong>, cada uno con un peso máximo de <strong>2 MB</strong> (opcional).</p>
                                        <p class="card-text"><strong>Paso 9:</strong> Haga clic en el botón <strong>"Guardar"</strong> para registrar el trámite. Si no adjuntó archivos, el sistema le preguntará si desea continuar de todas formas.</p>
                                        <p class="card-text"><strong>Paso 10:</strong> Una vez registrado, el sistema mostrará un mensaje de éxito con el <strong>Número de Trámite</strong> asignado. Anótelo para futuras consultas. Puede hacer clic en <strong>"Limpiar"</strong> para resetear el formulario.</p>

                                        <h6 class="card-title mt-4" id="consultar-tramite">🔍 Consultar Trámite</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Consultar Trámite"</strong> para acceder al listado de todos sus trámites registrados.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> En la tabla se mostrarán todos sus trámites con la siguiente información: <strong>Nro. Trámite, Área, Trámite, Doc. Externo, Tipo, Documento, Nombre, Estado</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Utilice el campo <strong>"Buscar"</strong> para filtrar los trámites por cualquier columna.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Puede exportar el listado a <strong>Excel, CSV, PDF o copiarlo</strong> usando los botones disponibles en la parte superior de la tabla.</p>
                                        <p class="card-text"><strong>Paso 5:</strong> Para ver los detalles de un trámite, haga clic en el botón de acción correspondiente en la columna final de la fila del trámite.</p>
                                        <p class="card-text"><strong>Paso 6:</strong> En la ventana de detalles podrá ver: <strong>Área, Trámite, Doc. Externo, Tipo, DNI/RUC, Nombre, Descripción, Respuesta</strong> y el <strong>Estado</strong> del trámite (Pendiente o Terminado).</p>
                                        <p class="card-text"><strong>Paso 7:</strong> Dentro de los detalles, se muestran dos tablas: <strong>Seguimiento Pendiente</strong> (acciones en proceso) y <strong>Seguimiento Terminado</strong> (acciones completadas).</p>
                                        <p class="card-text"><strong>Paso 8:</strong> El estado <strong>"Pendiente"</strong> indica que el trámite está en proceso. El estado <strong>"Terminado"</strong> indica que el trámite ha sido resuelto.</p>

                                        <h6 class="card-title mt-4" id="buscar-tramite">🔎 Buscar Trámite</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Buscar Trámite"</strong> para acceder al listado general de trámites.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> En la tabla se mostrarán todos los trámites del sistema con: <strong>Nro. Trámite, Área, Trámite, Doc. Externo, Tipo, Documento, Nombre, Estado</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Utilice el campo <strong>"Buscar"</strong> para filtrar trámites por cualquier dato.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para ver los detalles completos de un trámite, haga clic en el botón de acción en la última columna de la fila correspondiente.</p>
                                        <p class="card-text"><strong>Paso 5:</strong> En la ventana de detalles podrá consultar: <strong>Área, Trámite, Doc. Externo, Tipo, DNI/RUC, Nombre, Descripción, Respuesta</strong> y los <strong>Documentos Adjuntos</strong> tanto del trámite como de la respuesta.</p>
                                        <p class="card-text"><strong>Paso 6:</strong> Todos los campos son de solo lectura en esta vista. Haga clic en <strong>"Cerrar"</strong> para salir de los detalles.</p>

                                        <h6 class="card-title mt-4" id="gestionar-tramite">⚙️ Gestionar Trámite</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Gestionar Trámite"</strong> para acceder a la gestión de trámites.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Seleccione un <strong>Área</strong> del filtro desplegable para ver los trámites asignados a esa área (campo obligatorio).</p>
                                        <p class="card-text"><strong>Paso 3:</strong> En la tabla se mostrarán los trámites del área seleccionada con: <strong>Nro. Trámite, Área, Trámite, Doc. Externo, Tipo, Documento, Nombre, Estado</strong>.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para gestionar un trámite, haga clic en el botón de acción en la última columna de la fila correspondiente.</p>
                                        <p class="card-text"><strong>Paso 5:</strong> En la ventana de detalles podrá revisar toda la información del trámite y los <strong>Documentos Adjuntos</strong> del remitente.</p>
                                        <p class="card-text"><strong>Paso 6:</strong> Ingrese la <strong>Respuesta</strong> al trámite en el campo de texto correspondiente (campo obligatorio).</p>
                                        <p class="card-text"><strong>Paso 7:</strong> Si desea adjuntar documentos de respuesta, arrástrelos al área de carga o haga clic para seleccionarlos. Máximo <strong>5 archivos PDF</strong> de <strong>2 MB</strong> cada uno (opcional).</p>
                                        <p class="card-text"><strong>Paso 8:</strong> Haga clic en <strong>"Guardar"</strong> para enviar la respuesta y cambiar el estado del trámite a <strong>"Terminado"</strong>.</p>

                                        <h6 class="card-title mt-4" id="mnt-area">🏢 Mantenimiento de Área</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Mnt. Área"</strong> para administrar las áreas de la organización.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Haga clic en <strong>"Nuevo Registro"</strong> para agregar un área. Complete el <strong>Nombre</strong> y <strong>Correo</strong> del área, luego haga clic en <strong>"Guardar"</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Para <strong>editar</strong> un área existente, haga clic en el botón de edición en la fila correspondiente, modifique los campos y guarde los cambios.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para <strong>eliminar</strong> un área, haga clic en el botón de eliminar en la fila correspondiente y confirme la acción.</p>

                                        <h6 class="card-title mt-4" id="mnt-tramite">📄 Mantenimiento de Trámite</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Mnt. Trámite"</strong> para administrar los tipos de trámite.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Haga clic en <strong>"Nuevo Registro"</strong> para agregar un trámite. Complete el <strong>Nombre</strong> y <strong>Descripción</strong>, luego haga clic en <strong>"Guardar"</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Para <strong>editar</strong> un trámite, haga clic en el botón de edición en la fila correspondiente, modifique los campos y guarde.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para <strong>eliminar</strong> un trámite, haga clic en el botón de eliminar en la fila correspondiente y confirme la acción.</p>

                                        <h6 class="card-title mt-4" id="mnt-tipo">🏷️ Mantenimiento de Tipo</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Mnt. Tipo"</strong> para administrar los tipos de documento.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Haga clic en <strong>"Nuevo Registro"</strong> para agregar un tipo. Complete el <strong>Nombre</strong> y haga clic en <strong>"Guardar"</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Para <strong>editar</strong> un tipo, haga clic en el botón de edición en la fila correspondiente, modifique el nombre y guarde.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para <strong>eliminar</strong> un tipo, haga clic en el botón de eliminar en la fila correspondiente y confirme la acción.</p>

                                        <h6 class="card-title mt-4" id="mnt-rol">👥 Mantenimiento de Rol</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Mnt. Rol"</strong> para administrar los roles del sistema.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Haga clic en <strong>"Nuevo Registro"</strong> para crear un rol. Ingrese el <strong>Nombre</strong> del rol y haga clic en <strong>"Guardar"</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Para <strong>editar</strong> un rol, haga clic en el botón de edición en la fila correspondiente, modifique el nombre y guarde.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para <strong>eliminar</strong> un rol, haga clic en el botón de eliminar en la fila correspondiente y confirme la acción.</p>
                                        <p class="card-text"><strong>Paso 5:</strong> Para <strong>asignar permisos</strong> a un rol, haga clic en el botón de permisos en la fila del rol. Seleccione los módulos del menú a los que tendrá acceso el rol y guarde los cambios.</p>

                                        <h6 class="card-title mt-4" id="mnt-colaborador">👤 Mantenimiento de Colaborador</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Mnt. Colaborador"</strong> para administrar los usuarios del sistema.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Haga clic en <strong>"Nuevo Registro"</strong> para crear un colaborador. Complete <strong>Nombre, Correo, Contraseña</strong> y seleccione el <strong>Rol</strong> asignado, luego haga clic en <strong>"Guardar"</strong>.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Para <strong>editar</strong> un colaborador, haga clic en el botón de edición en la fila correspondiente, modifique los campos y guarde.</p>
                                        <p class="card-text"><strong>Paso 4:</strong> Para <strong>eliminar</strong> un colaborador, haga clic en el botón de eliminar en la fila correspondiente y confirme la acción.</p>
                                        <p class="card-text"><strong>Paso 5:</strong> Para <strong>asignar permisos especiales</strong> a un colaborador, haga clic en el botón de permisos en la fila del colaborador y configure los accesos individuales.</p>
                                        <p class="card-text"><strong>Paso 6:</strong> Para <strong>activar/desactivar</strong> un colaborador, utilice el botón correspondiente en la fila del usuario.</p>

                                        <h6 class="card-title mt-4" id="acceso-personal">🔑 Acceso Personal</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Desde el menú principal, haga clic en <strong>"Acceso Personal"</strong> para gestionar los accesos al sistema.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Revise la lista de colaboradores y sus permisos actuales de acceso.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Modifique los permisos de acceso según las necesidades de su organización.</p>

                                        <h6 class="card-title mt-4" id="perfil-usuario">👤 Perfil de Usuario</h6>
                                        <p class="card-text"><a href="#layout-wrapper" class="text-muted"><i class="mdi mdi-arrow-up-bold me-1"></i>Volver al índice</a></p>
                                        <p class="card-text"><strong>Paso 1:</strong> Haga clic en su <strong>nombre de usuario</strong> en la parte superior derecha de la pantalla y seleccione <strong>"Perfil"</strong>.</p>
                                        <p class="card-text"><strong>Paso 2:</strong> Puede actualizar su <strong>nombre, correo</strong> y otros datos personales.</p>
                                        <p class="card-text"><strong>Paso 3:</strong> Para cambiar su <strong>contraseña</strong>, ingrese la contraseña actual y la nueva contraseña, luego guarde los cambios.</p>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>

                <?php require_once("../html/footer.php")?>

            </div>

        </div>

        <?php require_once("../html/sidebar.php")?>

        <div class="rightbar-overlay"></div>

        <?php require_once("../html/js.php")?>

    </body>
</html>
<?php
  }else{
    header("Location:".Conectar::ruta()."index.php");
  }
?>