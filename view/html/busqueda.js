/**
 * busqueda.js
 * Búsqueda contextual por página.
 * Detecta la sección actual y conecta el campo del header con el DataTable
 * de esa página (o lo deshabilita cuando no aplica).
 */
(function () {
    'use strict';

    // ── Mapa de secciones ────────────────────────────────────────────────────
    // key        : fragmento del pathname (en minúsculas)
    // placeholder: texto del input
    // hasTable   : true → hay un #listado_table que filtrar
    var PAGES = {
        mntusuario:       { placeholder: 'Buscar colaborador...',    hasTable: true  },
        mntarea:          { placeholder: 'Buscar área...',           hasTable: true  },
        mnttramite:       { placeholder: 'Buscar trámite...',        hasTable: true  },
        mnttipo:          { placeholder: 'Buscar tipo...',           hasTable: true  },
        mntrol:           { placeholder: 'Buscar rol...',            hasTable: true  },
        gestionartramite: { placeholder: 'Buscar expediente...',     hasTable: true  },
        consultartramite: { placeholder: 'Buscar trámite...',        hasTable: true  },
        buscartramite:    { placeholder: 'Buscar expediente...',     hasTable: true  },
        home:             { placeholder: null,                       hasTable: false },
        homecolaborador:  { placeholder: null,                       hasTable: false },
        nuevotramite:     { placeholder: null,                       hasTable: false },
        perfiluser:       { placeholder: null,                       hasTable: false }
    };

    var _debounceTimer = null;

    // ── Detección de página ──────────────────────────────────────────────────
    function detectPage() {
        var path = window.location.pathname.toLowerCase();
        for (var key in PAGES) {
            if (path.indexOf(key) !== -1) {
                return { key: key, config: PAGES[key] };
            }
        }
        return null;
    }

    // ── Filtrar DataTable ────────────────────────────────────────────────────
    function filtrarTabla(term) {
        if (!$.fn.DataTable || !$.fn.DataTable.isDataTable('#listado_table')) {
            // Tabla aún no inicializada → reintenta una vez tras 400 ms
            setTimeout(function () { filtrarTabla(term); }, 400);
            return;
        }
        $('#listado_table').DataTable().search(term).draw();
    }

    // ── Función global llamada por el botón del header ───────────────────────
    window.ejecutarBusqueda = function () {
        var page = detectPage();
        if (!page || !page.config.hasTable) return;
        var term = $('#busquedaGlobal').val().trim();
        filtrarTabla(term);
    };

    // ── Inicialización ───────────────────────────────────────────────────────
    $(document).ready(function () {
        var page   = detectPage();
        var $input = $('#busquedaGlobal');
        var $btn   = $('#formBusqueda button[type="button"]');

        // Buscar el input del menú móvil (dropdown que no tiene id)
        var $mobileInput = $('#page-header-search-dropdown')
            .closest('.dropdown')
            .find('input[type="text"]');

        if (page && page.config.hasTable) {
            // ── Página con tabla ─────────────────────────────────────────────
            if (page.config.placeholder) {
                $input.attr('placeholder', page.config.placeholder);
                $mobileInput.attr('placeholder', page.config.placeholder);
            }

            // Búsqueda en tiempo real: inmediata al vaciar, debounce 300 ms al escribir
            $input.on('input', function () {
                clearTimeout(_debounceTimer);
                var term = $(this).val().trim();
                if (term === '') {
                    filtrarTabla('');
                } else {
                    _debounceTimer = setTimeout(function () { filtrarTabla(term); }, 300);
                }
            });

            // Enter en desktop
            $input.on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(_debounceTimer);
                    filtrarTabla($(this).val().trim());
                }
            });

            // Sincronizar móvil → desktop y disparar búsqueda
            $mobileInput.on('input', function () {
                clearTimeout(_debounceTimer);
                var term = $(this).val();
                $input.val(term);
                var trimmed = term.trim();
                if (trimmed === '') {
                    filtrarTabla('');
                } else {
                    _debounceTimer = setTimeout(function () { filtrarTabla(trimmed); }, 300);
                }
            });
            $mobileInput.on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var term = $(this).val().trim();
                    $input.val(term);
                    clearTimeout(_debounceTimer);
                    filtrarTabla(term);
                }
            });
            $mobileInput.closest('form').on('submit', function (e) {
                e.preventDefault();
            });

        } else {
            // ── Página sin tabla: deshabilitar campo ─────────────────────────
            $input
                .val('')
                .attr('placeholder', 'Búsqueda no disponible aquí')
                .prop('disabled', true)
                .addClass('text-muted');
            $btn.prop('disabled', true);
            $mobileInput
                .attr('placeholder', 'Búsqueda no disponible aquí')
                .prop('disabled', true);
        }
    });
})();
