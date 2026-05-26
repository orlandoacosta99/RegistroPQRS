<div id="mnt_editar" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="edit_lbltramite">Editar Tramite</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_documento_form">
                    <div class="row">
                        <input type="hidden" id="edit_doc_id" name="doc_id">

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Area (*)</label>
                                <select class="form-select form-select-sm" name="area_id" id="edit_area_id" required>
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Tramite (*)</label>
                                <select class="form-select form-select-sm" name="tra_id" id="edit_tra_id" required>
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Nro Externo</label>
                                <input class="form-control form-control-sm" type="text" name="doc_externo" id="edit_doc_externo">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo (*)</label>
                                <select class="form-select form-select-sm" name="tip_id" id="edit_tip_id" required>
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo Documento (*)</label>
                                <select class="form-select form-select-sm" name="tip_doc" id="edit_tip_doc" required>
                                    <option value="">Seleccionar</option>
                                    <option value="cedula_ciudadania">Cédula de Ciudadanía</option>
                                    <option value="cedula_extranjeria">Cédula de Extranjería</option>
                                    <option value="tarjeta_identidad">Tarjeta de Identidad</option>
                                    <option value="pasaporte">Pasaporte</option>
                                    <option value="registro_civil">Registro Civil</option>
                                    <option value="certificado_existencia">Certificado de Existencia y Representación Legal</option>
                                    <option value="nit">NIT</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">DNI / RUC (*)</label>
                                <input class="form-control form-control-sm" type="text" name="doc_dni" id="edit_doc_dni" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre / Razon Social (*)</label>
                                <input class="form-control form-control-sm" type="text" name="doc_nom" id="edit_doc_nom" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Descripción (*)</label>
                                <textarea class="form-control form-control-sm" rows="4" name="doc_descrip" id="edit_doc_descrip" required></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Agregar Nuevos Documentos Adjuntos <small class="text-muted">(PDF, máx. 5 archivos, 2 MB c/u)</small></label>
                                <input class="form-control form-control-sm" type="file" id="edit_files" name="file[]" multiple accept=".pdf">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="btn_guardar_edicion" onclick="guardarEdicion()">
                    <i class="bx bx-save font-size-16 align-middle me-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
