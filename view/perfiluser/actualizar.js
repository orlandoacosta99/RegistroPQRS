/**
 * actualizar.js
 * Edición del perfil del usuario.
 * Permite modificar datos personales (nombres, correo), cambiar contraseña
 * con validación en cliente y subir/actualizar la foto de avatar mediante
 * Dropzone con subida automática al servidor.
 */
$(document).ready(function () {

    cargarDatosUsuario();

    $('#cambiar_password').change(function () {
        if ($(this).is(':checked')) {
            $('#password_fields').slideDown();
            $('#usu_pass_actual, #usu_pass_nueva, #usu_pass_confirmar').attr('required', true);
        } else {
            $('#password_fields').slideUp();
            $('#usu_pass_actual, #usu_pass_nueva, #usu_pass_confirmar')
                .attr('required', false).val('');
            limpiarErroresPassword();
        }
    });

    $('#documento_form').submit(function (e) {
        e.preventDefault();
        if (validarFormulario()) {
            guardarCambios();
        }
    });

    $(document).on('click', '#btnlimpiar', function () {
        $('#documento_form')[0].reset();
        limpiarErrores();
        $('#cambiar_password').prop('checked', false);
        $('#password_fields').hide();
        cargarDatosUsuario();
    });
});

function cargarDatosUsuario() {
    $.ajax({
        url: '../../controller/usuario.php?op=mostrar_perfil',
        type: 'POST',
        dataType: 'json',
        timeout: 10000,
        success: function (data) {
            if (data.error) {
                Swal.fire('Error', data.error, 'error');
                return;
            }
            $('#usu_id').val(data.usu_id || '');
            $('#usu_nomape').val(data.usu_nomape || '');
            $('#usu_correo').val(data.usu_correo || '');

            if (data.usu_img) {
                $('#profile-avatar').attr('src', data.usu_img);
            }
        },
        error: function (xhr, status) {
            let msg = 'Error de conexión';
            if (xhr.status === 404)       msg = 'Controlador no encontrado (404)';
            else if (xhr.status === 500)  msg = 'Error interno del servidor (500)';
            else if (status === 'timeout') msg = 'Tiempo de espera agotado';
            else if (status === 'parseerror') msg = 'Respuesta no válida del servidor';
            Swal.fire('Error de Conexión', msg, 'error');
        }
    });
}

function validarFormulario() {
    limpiarErrores();
    var ok = true;

    var correo  = $('#usu_correo').val().trim();
    var nombres = $('#usu_nomape').val().trim();

    if (!nombres) {
        mostrarError('#usu_nomape', 'Los nombres son obligatorios');
        ok = false;
    }

    if (!correo) {
        mostrarError('#usu_correo', 'El correo electrónico es obligatorio');
        ok = false;
    } else if (!validarEmail(correo)) {
        mostrarError('#usu_correo', 'El formato del correo no es válido');
        ok = false;
    }

    if ($('#cambiar_password').is(':checked')) {
        var actual     = $('#usu_pass_actual').val().trim();
        var nueva      = $('#usu_pass_nueva').val().trim();
        var confirmar  = $('#usu_pass_confirmar').val().trim();

        if (!actual) {
            mostrarError('#usu_pass_actual', 'Ingrese su contraseña actual');
            ok = false;
        }
        if (!nueva) {
            mostrarError('#usu_pass_nueva', 'Ingrese la nueva contraseña');
            ok = false;
        } else if (nueva.length < 6) {
            mostrarError('#usu_pass_nueva', 'Mínimo 6 caracteres');
            ok = false;
        }
        if (!confirmar) {
            mostrarError('#usu_pass_confirmar', 'Confirme la nueva contraseña');
            ok = false;
        } else if (nueva !== confirmar) {
            mostrarError('#usu_pass_confirmar', 'Las contraseñas no coinciden');
            mostrarError('#usu_pass_nueva', 'Las contraseñas no coinciden');
            ok = false;
        }
    }

    return ok;
}

function guardarCambios() {
    var formData = {
        usu_nomape:   $('#usu_nomape').val().trim(),
        usu_correo:   $('#usu_correo').val().trim(),
        cambiar_pass: $('#cambiar_password').is(':checked') ? 1 : 0
    };

    if (formData.cambiar_pass == 1) {
        formData.pass_actual = $('#usu_pass_actual').val().trim();
        formData.pass_nueva  = $('#usu_pass_nueva').val().trim();
    }

    var $btn = $('#btnguardar');
    $btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin align-middle me-1"></i> Guardando...');

    $.ajax({
        url: '../../controller/usuario.php?op=actualizar_perfil',
        type: 'POST',
        data: formData,
        dataType: 'json',
        timeout: 15000,
        success: function (response) {
            if (response.status === 'success') {
                actualizarNombreHeader(response.data);
                Swal.fire({
                    title: '¡Éxito!',
                    text: response.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                if (formData.cambiar_pass == 1) {
                    $('#cambiar_password').prop('checked', false);
                    $('#password_fields').slideUp();
                    $('#usu_pass_actual, #usu_pass_nueva, #usu_pass_confirmar')
                        .val('').attr('required', false);
                }
            } else {
                Swal.fire('Error', response.message || 'Error desconocido', 'error');
                if (response.error_field === 'pass_actual') {
                    mostrarError('#usu_pass_actual', response.message);
                }
            }
        },
        error: function (xhr) {
            var msg = xhr.status === 500 ? 'Error interno del servidor (500)' : 'Error de conexión';
            Swal.fire('Error', msg, 'error');
        },
        complete: function () {
            $btn.prop('disabled', false)
                .html('<i class="bx bx-save align-middle me-1"></i>Guardar Cambios');
        }
    });
}

function actualizarNombreHeader(data) {
    if (data && data.usu_nomape) {
        $('.user-name-text').text(data.usu_nomape);
    }
    if (data && data.usu_correo) {
        $('[data-user-email]').text(data.usu_correo);
    }
}

Dropzone.autoDiscover = false;

var myDropzone = new Dropzone('#dropzone-avatar', {
    url: '../../controller/usuario.php?op=subir_avatar',
    paramName: 'file',
    maxFilesize: 1,
    maxFiles: 1,
    acceptedFiles: 'image/jpeg,image/png,image/webp',
    addRemoveLinks: true,
    dictRemoveFile: 'Quitar',
    dictDefaultMessage: '',
    autoProcessQueue: true,
    clickable: true
});

myDropzone.on('maxfilesexceeded', function (file) {
    myDropzone.removeAllFiles();
    myDropzone.addFile(file);
});

myDropzone.on('addedfile', function (file) {
    if (file.size > 1 * 1024 * 1024) {
        Swal.fire({
            title: 'Registro de PQRS',
            text: 'El archivo "' + file.name + '" supera el máximo de 1 MB.',
            icon: 'error',
            confirmButtonColor: '#5156be'
        });
        myDropzone.removeFile(file);
        return;
    }
    $('#avatar-error').text('');
});

myDropzone.on('success', function (file, response) {
    if (response.status === 'success') {
        $('#profile-avatar').attr('src', response.usu_img + '?t=' + Date.now());
        Swal.fire({
            title: '¡Foto actualizada!',
            text: response.message,
            icon: 'success',
            timer: 1800,
            showConfirmButton: false
        });
        $('img.rounded-circle[src]').not('#profile-avatar').each(function () {
            if ($(this).closest('#topnav, .navbar, header').length) {
                $(this).attr('src', response.usu_img + '?t=' + Date.now());
            }
        });
        setTimeout(function () { myDropzone.removeAllFiles(); }, 1500);
    } else {
        $('#avatar-error').text(response.message || 'Error al subir la imagen');
        myDropzone.removeFile(file);
    }
});

myDropzone.on('error', function (file, response) {
    var msg = (typeof response === 'object' && response.message) ? response.message : 'Error al subir la imagen';
    $('#avatar-error').text(msg);
    myDropzone.removeFile(file);
});

function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function mostrarError(campo, mensaje) {
    $(campo).addClass('is-invalid');
    $(campo).next('.validation-error').text(mensaje);
}

function limpiarErrores() {
    $('.form-control').removeClass('is-invalid');
    $('.validation-error').text('');
    limpiarErroresPassword();
}

function limpiarErroresPassword() {
    $('#usu_pass_actual, #usu_pass_nueva, #usu_pass_confirmar').removeClass('is-invalid');
    $('#usu_pass_actual, #usu_pass_nueva, #usu_pass_confirmar')
        .next('.validation-error').text('');
}
