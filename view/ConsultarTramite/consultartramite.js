/**
 * consultartramite.js
 * Consulta pública de trámites registrados por el usuario.
 * Muestra un DataTable con todos los documentos del usuario
 * y permite ver el detalle completo en un modal con dos sub-tablas
 * (Pendiente y Terminado).
 */
var tabla;

/**
 * Inicializa el DataTable principal al cargar la página.
 * Carga los datos desde documento.php?op=listarusuario.
 */
$(document).ready(function(){ 

    tabla = $("#listado_table").dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ajax":{
            url: '../../controller/documento.php?op=listarusuario',
            type : "get",
            dataType : "json",
            error:function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();

});

/**
 * Muestra el detalle completo de un trámite en un modal.
 * @param {number} doc_id - ID del documento a consultar.
 * Carga datos del documento y dos sub-tablas: Pendiente y Terminado.
 */
function ver(doc_id){
    $.post("../../controller/documento.php?op=mostrar",{doc_id:doc_id},function(data){
        data=JSON.parse(data);
        console.log(data);
        $("#area_nom").val(data.area_nom);
        $("#tra_nom").val(data.tra_nom);
        $("#doc_externo").val(data.doc_externo);
        $("#tip_nom").val(data.tip_nom);
        $("#tip_doc").val(data.tip_doc);
        $("#doc_dni").val(data.doc_dni);
        $("#doc_nom").val(data.doc_nom);
        $("#doc_descrip").val(data.doc_descrip);
        $("#doc_respuesta").val(data.doc_respuesta);
        $("#doc_id").val(data.doc_id);

        if (data.doc_estado == "Pendiente"){
            var resultado = "<span class='badge bg-warning'>Pendiente</span>";
        }else{
            var resultado = "<span class='badge bg-primary'>Terminado</span>";
        }

        $("#lbltramite").html("Nro Tramite: " + data.nrotramite +" | Usuario: " + data.usu_nomape + " | Correo: " + data.usu_correo + " | Adjunto: " + data.cant + " | Estado: " + resultado);

        tabla_detalle = $("#listado_table_detalle").dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "searching": false,
            "paging":false,
            lengthChange: false,
            colReorder: true,
            "ajax":{
                url: '../../controller/documento.php?op=listardetalle',
                type : "post",
                data: {doc_id:doc_id,det_tipo:'Pendiente'},
                dataType : "json",
                error:function(e){
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo":false,
            "iDisplayLength": 5,
            "autoWidth": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }).DataTable();

        tabla_detalle_respuesta = $("#respuesta_table_detalle").dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "searching": false,
            "paging":false,
            lengthChange: false,
            colReorder: true,
            "ajax":{
                url: '../../controller/documento.php?op=listardetalle',
                type : "post",
                data: {doc_id:doc_id,det_tipo:'Terminado'},
                dataType : "json",
                error:function(e){
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo":false,
            "iDisplayLength": 5,
            "autoWidth": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }).DataTable();

    });

    $("#mnt_detalle").modal('show');
}

function documento(det_id) {
    console.log(det_id);
}

function editar(doc_id) {
    $.post("../../controller/documento.php?op=mostrar", {doc_id: doc_id}, function(data) {
        data = JSON.parse(data);

        $("#edit_doc_id").val(data.doc_id);
        $("#edit_doc_externo").val(data.doc_externo);
        $("#edit_doc_dni").val(data.doc_dni);
        $("#edit_doc_nom").val(data.doc_nom);
        $("#edit_doc_descrip").val(data.doc_descrip);
        $("#edit_files").val('');

        $.post("../../controller/area.php?op=combo", function(html) {
            $('#edit_area_id').html(html);
            $('#edit_area_id').val(data.area_id);
        });

        $.post("../../controller/tramite.php?op=combo", function(html) {
            $('#edit_tra_id').html(html);
            $('#edit_tra_id').val(data.tra_id);
        });

        $.post("../../controller/tipo.php?op=combo", function(html) {
            $('#edit_tip_id').html(html);
            $('#edit_tip_id').val(data.tip_id);
        });

        $('#edit_tip_doc').val(data.tip_doc);

        var estadoBadge = data.doc_estado == "Pendiente"
            ? "<span class='badge bg-warning'>Pendiente</span>"
            : "<span class='badge bg-primary'>Terminado</span>";
        $("#edit_lbltramite").html("Editar Tramite: " + data.nrotramite + " | Estado: " + estadoBadge);

        $("#mnt_editar").modal('show');
    });
}

function guardarEdicion() {
    var area_id    = $("#edit_area_id").val();
    var tra_id     = $("#edit_tra_id").val();
    var tip_id     = $("#edit_tip_id").val();
    var tip_doc    = $("#edit_tip_doc").val();
    var doc_dni    = $("#edit_doc_dni").val().trim();
    var doc_nom    = $("#edit_doc_nom").val().trim();
    var doc_descrip = $("#edit_doc_descrip").val().trim();

    if (!area_id || !tra_id || !tip_id || !tip_doc || !doc_dni || !doc_nom || !doc_descrip) {
        Swal.fire({
            title: "Registro de PQRS",
            text: "Complete todos los campos obligatorios (*).",
            icon: "warning",
            confirmButtonColor: "#5156be",
        });
        return;
    }

    $('#btn_guardar_edicion').prop("disabled", true)
        .html('<i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i>Guardando...');

    var formData = new FormData();
    formData.append("doc_id",    $("#edit_doc_id").val());
    formData.append("area_id",   area_id);
    formData.append("tra_id",    tra_id);
    formData.append("doc_externo", $("#edit_doc_externo").val());
    formData.append("tip_id",    tip_id);
    formData.append("tip_doc",   tip_doc);
    formData.append("doc_dni",   doc_dni);
    formData.append("doc_nom",   doc_nom);
    formData.append("doc_descrip", doc_descrip);

    var files = $("#edit_files")[0].files;
    for (var i = 0; i < files.length; i++) {
        formData.append("file[]", files[i]);
    }

    $.ajax({
        url: "../../controller/documento.php?op=actualizar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            $('#btn_guardar_edicion').prop("disabled", false)
                .html('<i class="bx bx-save font-size-16 align-middle me-2"></i>Guardar');

            if (data == "1") {
                Swal.fire({
                    title: "Registro de PQRS",
                    text: "Tramite actualizado con exito.",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                }).then(function() {
                    $("#mnt_editar").modal('hide');
                    tabla.ajax.reload();
                });
            } else {
                Swal.fire({
                    title: "Registro de PQRS",
                    text: "Error al actualizar el tramite.",
                    icon: "error",
                    confirmButtonColor: "#5156be",
                });
            }
        }
    });
}

