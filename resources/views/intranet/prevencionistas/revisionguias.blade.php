@extends('intranet/layout')
@section('title', 'Validacion Guia Conteo')

@section('hideSearchBar', true)
@section('header-actions')
    <button type="button"
            class="btn btn-outline-primary rounded-pill px-4 shadow-sm"
            onclick="window.location.href='/guiasremision'">
        <i class="fas fa-chevron-left me-2"></i> Volver al listado
    </button>
@endsection
@section('content')
    @vite('resources/css/views/prevencionistas/revisionguias.css')
    @if ($guia->estado == 'Confirmado')
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <!-- Icono de éxito -->
                    <div class="bg-success bg-opacity-10 d-inline-flex p-4 rounded-circle mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>

                    <!-- Título principal -->
                    <h2 class="fw-bold text-success mb-3">
                        <i class="fas fa-clipboard-check me-2"></i> ¡Validación Exitosa!
                    </h2>

                    <!-- Subtítulo -->
                    <p class="lead mb-4">
                        La guía de remisión <span class="fw-bold text-primary">{{ $guia->codigoguia }}</span> ha sido
                        validada correctamente
                    </p>

                    <!-- Sello de aprobación -->
                    <div class="mt-5">
                        <div class="position-relative d-inline-block">
                            <div class="position-absolute top-0 start-50 translate-middle">
                                <div class="bg-white p-2 rounded-circle shadow-sm">
                                    <i class="fas fa-stamp text-success" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="border border-2 border-success rounded p-4 pt-5" style="opacity: 0.8;">
                                <p class="mb-0 small text-muted">Validado por el prevencionista:</p>
                                <p class="mb-0 fw-bold">Sistema de Gestión Logística</p>
                                <p class="small text-muted">{{ now()->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Botón para regresar -->
                    <div class="mt-4">
                        <a href="{{ route('vistaguiasderemision') }}" class="btn btn-outline-success">
                            <i class="fas fa-arrow-left me-2"></i> Regresar a Listado de Guías
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid py-3" id="divvalidacionguiarevicion">
            <div class="row g-3">
                <!-- Primer Card (más estrecho) -->
                <div class="col-xl-3 col-lg-4 col-md-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary bg-opacity-10 p-0 border-0">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item flex-grow-1 text-center">
                                    <a class="nav-link active py-2" id="options-tab" data-bs-toggle="tab" href="#options">
                                        <i class="fas fa-cog me-2"></i>Datos
                                    </a>
                                </li>
                                <li class="nav-item flex-grow-1 text-center">
                                    <a class="nav-link py-2" id="products-tab" data-bs-toggle="tab" href="#products">
                                        <i class="fas fa-boxes me-2"></i>Productos
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body tab-content p-0" style="overflow-y: auto; max-height: 500px;">
                            <!-- Pestaña de opciones -->
                            <div class="tab-pane fade show active p-3" id="options">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <p>idguia</p>
                                        <span>{{ $guia->idguia ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <p>Fecha Emision</p>
                                        <span>{{ $guia->fechaemision ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <p>Hora Emision</p>
                                        <span>{{ $guia->horaemision ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <p>Tim</p>
                                        <span>{{ $guia->numerotrasladotim ?? 'N/A' }}</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Pestaña de productos -->
                            <div class="tab-pane fade p-3" id="products" data-total-productos="{{ count($detalleguia) }}"
                                data-productos="{{ json_encode($detalleguia) }}" data-guia="{{ json_encode($guia) }}">
                                @forelse($detalleguia as $dt)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="small text-muted">
                                                {{ $dt->producto ?? 'Producto' }}</p>
                                            <p class="small text-muted">Código:
                                                {{ $dt->codproducto ?? 'codigoproducto' }}</p>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $dt->cant ?? 0 }}</span>
                                        {{--                                        boton de agregar --}}
                                        <button class="btn btn-sm btn-outline-primary btn-seleccionar-producto"
                                            data-codigo="{{ $dt->codproducto ?? '' }}"
                                            data-nombre="{{ $dt->producto ?? '' }}" data-id="{{ $dt->idproducto ?? '' }}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted py-3">
                                        <i class="fas fa-box-open me-2"></i> No hay productos en esta guía
                                    </li>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Segundo Card (más ancho) -->
                <div class="col-xl-9 col-lg-8 col-md-7">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-info bg-opacity-10 py-2 border-0">
                            <h6 class="mb-0 text-info fw-bold"><i class="fas fa-list me-2"></i>Listado Principal</h6>
                        </div>

                        <div class="card-body p-3">

                            <!-- Formulario para agregar productos -->
                            <div class="row g-2 mb-3 align-items-end">
                                <!-- Código -->
                                <div class="col-md-3">
                                    <label for="idtxtcodigoproducto_guiarevision"
                                        class="form-label small fw-bold">Código</label>
                                    <input type="hidden" id="idproductocarritogia_revision">
                                    <input type="text" class="form-control form-control-sm"
                                        id="idtxtcodigoproducto_guiarevision" pattern="\d{8}" maxlength="8"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-4">
                                    <label for="idtxtnombreproducto_guiarevision" class="form-label small fw-bold">Nombre
                                        del Producto</label>
                                    <input type="text" class="form-control form-control-sm"
                                        id="idtxtnombreproducto_guiarevision" readonly>
                                </div>

                                <!-- Cantidad -->
                                <div class="col-md-2">
                                    <label for="idtxtcantidadproducto_guiarevision"
                                        class="form-label small fw-bold">Cantidad</label>
                                    <input type="number" class="form-control form-control-sm"
                                        id="idtxtcantidadproducto_guiarevision">
                                </div>

                                <!-- Estado -->
                                <div class="col-md-2">
                                    <label for="idselectestadoproducto_guiarevision"
                                        class="form-label small fw-bold">Estado</label>
                                    <select class="form-select form-select-sm" id="idselectestadoproducto_guiarevision">
                                        <option value="Bueno">Bueno</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Dañado">Dañado</option>
                                    </select>
                                </div>

                                <!-- Botón de agregar (solo icono) -->
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-primary btn-sm h-100"
                                        id="idbtnagregarproducto_guiarevision" title="Agregar producto">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="liveAlert" class="alert alert-warning alert-dismissible py-2 mb-2 fade show d-none"
                                role="alert" style="padding-left: 1rem; padding-right: 1rem;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <span id="alertMessage"></span>
                                </div>
                            </div>

                            <!-- Tabla de productos agregados -->
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="tablaProductos_guiarevision">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="15%">Código</th>
                                            <th width="40%">Producto</th>
                                            <th width="15%">Cantidad</th>
                                            <th width="20%">Estado</th>
                                            <th width="10%">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los productos se agregarán aquí dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción alineados a la derecha -->
            <div class="d-flex justify-content-end mt-3 gap-2">
                <button type="button" class="btn btn-outline-danger btn-sm px-3" id="btncancelar_guiarevision">
                    <i class="fas fa-times-circle me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success btn-sm px-3" id="btnguardar_guiarevision">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </div>

        <div class="container-fluid d-none flex-column" style="height: 91vh;" id="divresultadovalidacionguiarevicion">
            <!-- Encabezado -->
            <div class="py-3 border-bottom bg-white">
                <div class="d-flex justify-content-between align-items-center px-2">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-clipboard-check me-2"></i>Reporte de Validación
                    </h4>
                    <div class="text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="row flex-grow-1 overflow-hidden m-0" style="overflow-y: auto;">
                <!-- Panel de estadísticas -->
                <div class="col-md-4 p-3 bg-white border-end">
                    <h5 class="fw-bold mb-3 text-secondary">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </h5>

                    <div id="miAlertaocurrencia" class="alert alert-primary" role="alert" style="display: none;">
                        No se encontro Ocurrencia
                    </div>

                    <!-- Tarjetas de resumen -->
                    <div class="row g-3 mb-4">
                        <!-- Productos Recibidos -->
                        <div class="col-md-6">
                            <div class="card border-success border-2">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-check-circle text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-muted small">Recibidos</h6>
                                            <h3 class="mb-0 text-success" id="idh3recibidos">142</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Productos Faltantes -->
                        <div class="col-md-6">
                            <div class="card border-danger border-2">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-times-circle text-danger fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-muted small">Faltantes</h6>
                                            <h3 class="mb-0 text-danger" id="idh3faltantes">18</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Productos Vencidos -->
                        <div class="col-md-6">
                            <div class="card border-warning border-2">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-muted small">Dañádos</h6>
                                            <h3 id="idh3danados" class="mb-0 text-warning">7</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Productos Buenos -->
                        <div class="col-md-6">
                            <div class="card border-info border-2">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-bolt text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-muted small">Buenos</h6>
                                            <h3 id="idh3buenos" class="mb-0 text-info">5</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalle completo de productos -->
                <div class="col-md-8 p-3 overflow-auto">
                    <div style="max-height: calc(100vh - 175px); overflow-y: auto;">
                        <!-- Lista de productos faltantes -->
                        <div class="mb-3">
                            <h6 id="titulo-faltantes" class="fw-bold text-danger mb-2">
                                <i class="fas fa-list-ul me-1"></i> Productos Faltantes (0)
                            </h6>
                            <div id="lista-faltantes" class="list-group small">
                                <!-- Dinámico -->
                            </div>
                        </div>

                        <!-- Lista de productos buenos -->
                        <div class="mb-3">
                            <h6 id="titulo-bueno" class="fw-bold text-success mb-2">
                                <i class="fas fa-check-circle me-1"></i> Productos Buenos (0)
                            </h6>
                            <div id="lista-bueno" class="list-group small">
                                <!-- Dinámico -->
                            </div>
                        </div>

                        <!-- Lista de productos regulares -->
                        <div class="mb-3">
                            <h6 id="titulo-regular" class="fw-bold text-warning mb-2">
                                <i class="fas fa-exclamation-circle me-1"></i> Productos Regulares (0)
                            </h6>
                            <div id="lista-regular" class="list-group small">
                                <!-- Dinámico -->
                            </div>
                        </div>

                        <!-- Lista de productos dañados -->
                        <div class="mb-3">
                            <h6 id="titulo-dañado" class="fw-bold text-danger mb-2">
                                <i class="fas fa-times-circle me-1"></i> Productos Dañados (0)
                            </h6>
                            <div id="lista-dañado" class="list-group small">
                                <!-- Dinámico -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con botones -->
            <div class="border-top">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <button class="btn btn-outline-secondary" id="idbtnregresa_guiarevision">
                        <i class="fas fa-arrow-left me-2"></i> Regresar
                    </button>
                    <button class="btn btn-success" id="btnconfirmarvalidacionguia">
                        <i class="fas fa-check-circle me-2"></i> Confirmar Validación
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Efecto de confeti opcional -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

    <script>
        let productos = [];
        let productosguardadosguia;
        let dataguia;
        let totalProductosguia;
        let contadorId = 0;
        let tokenlarave;

        if (typeof jQuery == 'undefined') {
            alert('jQuery NO está cargado');
        }

        $(document).ready(function() {
            const container = document.getElementById('products');
            totalProductosguia = container.dataset.totalProductos;
            productosguardadosguia = JSON.parse(container.dataset.productos);
            dataguia = JSON.parse(container.dataset.guia);
            tokenlarave = document.querySelector('meta[name="csrf-token"]').content;

            if (dataguia["estado"] === "Confirmado") {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: {
                        y: 0.6
                    }
                });
            }

            // alert('jQuery está cargado, versión: ' + $.fn.jquery);
            // 1. Prevenir el comportamiento por defecto del Enter en todo el formulario
            $('#idformaddguiasremision').on('keypress', function(e) {
                if (e.which === 13 && !$(e.target).is('textarea, [type="submit"]')) {
                    e.preventDefault();
                }
            });

            // Para detectar cambios en inputs y selects
            $('#idtxtcodigoproducto_guiarevision').on('input', function() {
                $('#idtxtnombreproducto_guiarevision').val('');
                $('#idtxtcantidadproducto_guiarevision').val('');
                $('#idproductocarritogiaremision').val('');
                $('#idselectestadoproducto_guiarevision').val('Bueno');
            });

            // $('#idformaddguiasremision').on('change', 'input, select', function(e) {
            //     console.log('Cambio detectado en:', this.id);
            //     console.log('Nuevo valor:', $(this).val());
            //
            //     // Aquí puedes agregar tu lógica de validación
            // });

            // 2. Manejador específico para el campo de código de producto
            // Evento para manejar Enter (código 13 es la tecla Enter)
            $('#idtxtcodigoproducto_guiarevision').keypress(function(e) {
                if (e.which === 13) { // 13 es el código de la tecla Enter
                    e.preventDefault();
                    const codigo = $(this).val().trim();

                    // Resetear estilo si había error previo
                    $(this).removeClass('border-danger');

                    if (codigo) {
                        buscarproductocodigo(codigo);
                    }
                }
            });

            // 3. Manejador para navegación entre campos
            $('.form-control:not(#idtxtcodigoproducto_guiarevision), .form-select').keypress(function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    const $current = $(this);

                    // Si es el último campo antes del botón agregar
                    if ($current.is('#idselectestadoproducto_guiarevision')) {
                        $('#idbtnagregarproducto_guiarevision').click();
                        $('#idtxtcodigoproducto_guiarevision').focus();
                    }
                    // Para otros campos
                    else {
                        const inputs = $current.closest('.row').find('.form-control, .form-select');
                        const currentIndex = inputs.index(this);
                        if (currentIndex < inputs.length - 1) {
                            inputs.eq(currentIndex + 1).focus();
                        }
                    }
                }
            });

            // Evento para botón agregar
            $('#idbtnagregarproducto_guiarevision').click(function(e) {
                agregarProductoAlCarrito();
            });

            //escuh el botoon click del cancelar
            $('#btncancelar_guiarevision').click(function(e) {
                window.location.replace("/guiasremision");
            });
            $('#idbtnregresa_guiarevision').click(function(e) {
                $("#divresultadovalidacionguiarevicion").addClass("d-none").removeClass("d-flex");
                $("#divvalidacionguiarevicion").removeClass("d-none").addClass("d-block");
            });
            $('#btnconfirmarvalidacionguia').click(async function(e) {
                await confirmarregistro();
            });


            // Evento delegado para eliminar
            $('#tablaProductos_guiarevision').on('click', '.btn-eliminar', function() {
                eliminarProducto($(this).closest('tr').data('id'));
            });

            // Evento para resetear el estilo al escribir
            $('#idtxtcodigoproducto_guiarevision').on('input', function() {
                $(this).removeClass('border-danger');
            });

            $('#btnguardar_guiarevision').click(function(e) {
                validaarocurrencias();
            });

            // Evento para seleccionar producto desde la lista
            $(document).on('click', '.btn-seleccionar-producto', function() {
                const codigo = $(this).data('codigo');
                const nombre = $(this).data('nombre');
                const id = $(this).data('id');

                $('#idtxtcodigoproducto_guiarevision').val(codigo);
                $('#idtxtnombreproducto_guiarevision').val(nombre);
                $('#idproductocarritogia_revision').val(id);

                // Enfocar el campo de cantidad
                $('#idtxtcantidadproducto_guiarevision').focus();

                // Buscar automáticamente el producto (opcional)
                buscarproductocodigo(codigo);
            });
        });

        function buscarproductocodigo(codigo) {
            const $codigoInput = $('#idtxtcodigoproducto_guiarevision');
            const $btnAgregar = $('#idbtnagregarproducto_guiarevision');

            // Validación: campo vacío
            if (!codigo || codigo.trim() === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo vacío',
                    text: 'Por favor, ingrese el código del producto para buscarlo.',
                    confirmButtonText: 'Entendido'
                });
                $codigoInput.addClass('border-danger').focus();
                return;
            }

            // Validación: longitud o formato incorrecto
            if (!/^[0-9]{6,20}$/.test(codigo)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Código inválido',
                    text: 'El código debe tener entre 6 y 20 dígitos numéricos.',
                    confirmButtonText: 'Corregir'
                });
                $codigoInput.addClass('border-danger').focus();
                return;
            }

            // Desactivar campos y mostrar spinner
            $codigoInput.prop('disabled', true);
            $('#idtxtcantidadproducto_guiarevision').prop('disabled', true);
            $('#idselectestadoproducto_guiarevision').prop('disabled', true);
            $btnAgregar.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            // Petición AJAX
            $.ajax({
                url: '/buscarproductocodigo',
                method: 'POST',
                data: {
                    codigoproducto: codigo,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $btnAgregar.prop('disabled', false).html('<i class="fas fa-plus"></i>');
                    $codigoInput.prop('disabled', false);
                    $('#idtxtcantidadproducto_guiarevision').prop('disabled', false);
                    $('#idselectestadoproducto_guiarevision').prop('disabled', false);

                    if (response.data !== null && response.data.length > 0) {
                        $('#idtxtnombreproducto_guiarevision').val(response.data[0]["nombre"]);
                        $('#idproductocarritogia_revision').val(response.data[0]["idproducto"]);
                        $('#idtxtcantidadproducto_guiarevision').focus();
                        $codigoInput.removeClass('border-danger');
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Producto no encontrado',
                            text: `No se encontró ningún producto con el código "${codigo}".`,
                            confirmButtonText: 'Verificar'
                        });
                        $codigoInput.addClass('border-danger').focus();
                        $('#idtxtnombreproducto_guiarevision').val('');
                        $('#idtxtcantidadproducto_guiarevision').val('');
                        $('#idproductocarritogia_revision').val('');
                        $('#idselectestadoproducto_guiarevision').val('Bueno');
                    }
                },
                error: function(xhr) {
                    $btnAgregar.prop('disabled', false).html('<i class="fas fa-plus"></i>');
                    $codigoInput.prop('disabled', false);
                    $codigoInput.addClass('border-danger');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error de servidor',
                        text: 'No se pudo completar la búsqueda. Intenta nuevamente.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }


        function agregarProductoAlCarrito() {
            const idproducto = parseInt($('#idproductocarritogia_revision').val());
            const codigo = $('#idtxtcodigoproducto_guiarevision').val().trim();
            const nombre = $('#idtxtnombreproducto_guiarevision').val().trim();
            const cantidad = parseInt($('#idtxtcantidadproducto_guiarevision').val());
            const estado = $('#idselectestadoproducto_guiarevision').val();

            // Validación de campos obligatorios
            if (!idproducto || !codigo || !nombre) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Debe ingresar un producto válido con su código',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Validación de cantidad
            if (isNaN(cantidad)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Cantidad inválida',
                    text: 'Debe ingresar una cantidad numérica.',
                    confirmButtonText: 'Corregir'
                });
                $('#idtxtcantidadproducto_guiarevision').focus();
                return;
            }

            if (cantidad <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Cantidad no válida',
                    text: 'La cantidad debe ser mayor a cero.',
                    confirmButtonText: 'Corregir'
                });
                $('#idtxtcantidadproducto_guiarevision').focus();
                return;
            }

            // Verificar si el producto está en la guía original
            const productoEnGuia = productosguardadosguia.find(p => p.idproducto === idproducto);
            if (!productoEnGuia) {
                Swal.fire({
                    icon: 'error',
                    title: 'Producto no permitido',
                    text: 'Este producto no está incluido en la guía de remisión.',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verificar si se excede la cantidad disponible
            const cantidadYaAgregada = productos
                .filter(p => p.idproducto === idproducto)
                .reduce((total, p) => total + p.cantidad, 0);

            const disponible = productoEnGuia.cant - cantidadYaAgregada;
            if (cantidad > disponible) {
                Swal.fire({
                    icon: 'error',
                    title: 'Cantidad excedida',
                    html: `Solo quedan <strong>${disponible}</strong> unidades disponibles en la guía.`,
                    confirmButtonText: 'Corregir'
                });
                return;
            }

            // Verificar producto duplicado (por estado)
            const productoDuplicado = productos.find(p => p.idproducto === idproducto && p.estado === estado);
            if (productoDuplicado) {
                Swal.fire({
                    icon: 'info',
                    title: 'Producto duplicado',
                    text: 'Ya agregaste este producto con el mismo estado.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Si pasa todas las validaciones
            const producto = {
                id: contadorId++,
                idproducto,
                codigo,
                nombre,
                cantidad,
                estado
            };

            productos.push(producto);
            actualizarTablaProductos();

            // Limpiar campos
            $('#idtxtcodigoproducto_guiarevision').val('').focus();
            $('#idtxtnombreproducto_guiarevision').val('');
            $('#idtxtcantidadproducto_guiarevision').val('');
            $('#idproductocarritogia_revision').val('');
            $('#idselectestadoproducto_guiarevision').val('Bueno');
        }


        function actualizarTablaProductos() {
            const tbody = $('#tablaProductos_guiarevision tbody').empty();

            productos.forEach(producto => {
                tbody.append(`
                    <tr data-id="${producto.id}">
                        <td>${producto.codigo}</td>
                        <td>${producto.nombre}</td>
                        <td>${producto.cantidad}</td>
                        <td>${producto.estado}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger btn-eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        function eliminarProducto(id) {
            productos = productos.filter(p => p.id !== id);
            actualizarTablaProductos();
        }

        function mostrarAlerta(mensaje, tipo = 'warning') {
            const alertDiv = $('#liveAlert');
            const alertMessage = $('#alertMessage');

            // Cambiar clase según tipo (warning, danger, success, etc.)
            alertDiv.removeClass('alert-warning alert-danger alert-success')
                .addClass(`alert-${tipo}`);

            // Establecer mensaje
            alertMessage.text(mensaje);

            // Mostrar alerta
            alertDiv.removeClass('d-none');

            // Auto-ocultar después de 5 segundos
            setTimeout(() => {
                alertDiv.addClass('d-none');
            }, 3000);
        }

        // Mostrar la alerta con nuevo texto
        function mostrarAlertaOcurrencia(mensaje, tipo = 'primary') {
            // Cambiar clase para el tipo (primary, success, danger, etc)
            $('#miAlertaocurrencia').removeClass('alert-primary alert-success alert-danger alert-warning')
                .addClass('alert-' + tipo);

            // Cambiar el texto
            $('#miAlertaocurrencia').text(mensaje);

            // Mostrar con efecto de fade
            $('#miAlertaocurrencia').fadeIn();
        }

        async function validaarocurrencias() {
            if (productos.length === 0) {
                mostrarAlerta("es necesario que agregue productos a la canasta")
                return;
            }

            // 1. Calcular total de productos (suma de todas las cantidades)
            window.SweetAlertProgressOpen1([{
                title: "Validando la guia..."
            }]);
            const totalProductos = productos.reduce((sum, producto) => sum + producto.cantidad, 0);

            // 2. Calcular productos por estado
            const productosDanados = productos.filter(p => p.estado === 'Dañado').reduce((sum, producto) => sum +
                producto.cantidad, 0);
            const productosResueltos = productos.filter(p => p.estado === 'Regular').reduce((sum, producto) => sum +
                producto.cantidad, 0);
            const productosBuenos = productos.filter(p => p.estado === 'Bueno').reduce((sum, producto) => sum + producto
                .cantidad, 0);

            // 3. Calcular productos faltantes
            const productosFaltantes = calcularProductosFaltantes(productos, productosguardadosguia);
            // const totalFaltantes = productosFaltantes.reduce((sum, item) => sum + item.faltante, 0);

            // 4. Generar todas las listas
            const productosPorEstado = {
                'Bueno': productos.filter(p => p.estado === 'Bueno'),
                'Regular': productos.filter(p => p.estado === 'Regular'),
                'Dañado': productos.filter(p => p.estado === 'Dañado')
            };

            mostrarResultadosFaltantes(productosFaltantes);
            generarListaPorEstado('Bueno', productosPorEstado['Bueno']);
            generarListaPorEstado('Regular', productosPorEstado['Regular']);
            generarListaPorEstado('Dañado', productosPorEstado['Dañado']);

            $('#idh3recibidos').text(totalProductos);
            $('#idh3danados').text(productosDanados);
            $('#idh3resueltos').text(productosResueltos);
            $('#idh3buenos').text(productosBuenos);

            if (parseInt(productosDanados) === 0 && parseInt($('#idh3faltantes').text().trim()) === 0) {
                // Ocultar inmediatamente
                $('#miAlertaocurrencia').fadeOut();
                // mostrarAlertaOcurrencia('¡Operación completada con éxito!', 'success');
            } else {
                mostrarAlertaOcurrencia('¡Ocurrencia Detectada!', 'danger');
            }

            await new Promise(resolve => setTimeout(resolve, 3000));
            window.SweetAlertProgressClose1();
            $("#divvalidacionguiarevicion").addClass("d-none").removeClass("d-flex");
            $("#divresultadovalidacionguiarevicion").removeClass("d-none").addClass("d-flex");
        }

        function calcularProductosFaltantes(productosCarrito, productosGuia) {
            // 1. Agrupar productos del carrito por ID (sumando cantidades)
            const productosCarritoAgrupados = productosCarrito.reduce((acumulador, producto) => {
                if (!acumulador[producto.idproducto]) {
                    acumulador[producto.idproducto] = {
                        id: producto.idproducto,
                        nombre: producto.nombre,
                        cantidadTotal: 0
                    };
                }
                acumulador[producto.idproducto].cantidadTotal += producto.cantidad;
                return acumulador;
            }, {});

            // 2. Procesar productos de la guía para encontrar faltantes
            const productosFaltantes = [];

            productosGuia.forEach(productoGuia => {
                const productoEnCarrito = productosCarritoAgrupados[productoGuia.idproducto];
                const cantidadEnGuia = productoGuia.cant;
                const cantidadEnCarrito = productoEnCarrito ? productoEnCarrito.cantidadTotal : 0;
                const faltante = cantidadEnGuia - cantidadEnCarrito;

                if (faltante > 0) {
                    productosFaltantes.push({
                        id: productoGuia.idproducto,
                        codigo: productoGuia.codigo ||
                            `PROD-${productoGuia.idproducto.toString().padStart(5, '0')}`,
                        nombre: productoGuia.producto || productoGuia.nombre,
                        requerido: cantidadEnGuia,
                        registrado: cantidadEnCarrito,
                        faltante: faltante
                    });
                }
            });

            return productosFaltantes;
        }

        function mostrarResultadosFaltantes(productosFaltantes) {
            const contenedor = document.getElementById('lista-faltantes');
            contenedor.innerHTML = '';

            // Calcular total faltante
            const faltanteactual = productosFaltantes.reduce((sum, item) => sum + item.faltante, 0);
            $('#idh3faltantes').text(faltanteactual);
            $('#titulo-faltantes').text(`Productos faltantes (${faltanteactual})`);

            // Mostrar cada producto faltante
            if (productosFaltantes.length === 0) {
                contenedor.innerHTML = `
                    <div class="alert alert-success">
                        Todos los productos están completos
                    </div>
                `;
            } else {
                productosFaltantes.forEach(producto => {
                    const item = document.createElement('div');
                    item.className = 'list-group-item';
                    item.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <span>${producto.codigo} - ${producto.nombre}</span>
                            <span class="badge bg-danger">${producto.faltante}</span>
                        </div>
                    `;
                    contenedor.appendChild(item);
                });
            }
        }

        // Función para generar lista por estado
        function generarListaPorEstado(estado, productosEstado) {
            const contenedor = $(`#lista-${estado.toLowerCase()}`); // Cambia este selector
            contenedor.empty();

            const total = productosEstado.reduce((sum, p) => sum + p.cantidad, 0);
            const color = {
                'Bueno': 'success',
                'Regular': 'warning',
                'Dañado': 'danger'
            } [estado];

            $(`#titulo-${estado.toLowerCase()}`).html(`
                <i class="fas fa-${estado === 'Bueno' ? 'check-circle' : estado === 'Regular' ? 'exclamation-circle' : 'times-circle'} me-1"></i>
                Productos ${estado} (${total})
            `);

            if (productosEstado.length === 0) {
                contenedor.append(`
                    <div class="list-group-item py-2 text-center text-muted">
                        No hay productos en estado ${estado}
                    </div>
                `);
                return;
            }

            productosEstado.forEach(producto => {
                contenedor.append(`
                    <div class="list-group-item py-2 d-flex justify-content-between align-items-center">
                        <span>${producto.codigo || `PROD-${producto.id.toString().padStart(5, '0')}`} - ${producto.nombre}</span>
                        <span class="badge bg-${color}">${producto.cantidad}</span>
                    </div>
                `);
            });
        }

        async function confirmarregistro() {

            // Validar productos (solo si los campos están completos)
            if (productos.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Productos requeridos',
                    text: 'Agregue al menos un producto',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            const pregunta = await window.SweetAlertpreguntarSI_NO("¿Estas seguro de confirmar?");
            if (pregunta) {
                const datos = {
                    idguia: dataguia["idguia"],
                    productos: productos, // <- Aquí incluimos el array de productos
                    _token: tokenlarave // Token CSRF
                };

                // Enviar datos al servidor (AJAX)
                $.ajax({
                    url: "/registrarvalidacionguia", // Ruta en Laravel
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(datos),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (!response.result) {
                            console.log('Estructura de respuesta inválida');
                        }

                        window.location.reload();
                        // window.location.replace('/guiasremision');
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Ocurrió un error al guardar'
                        });
                    }
                });
            }
        }
    </script>
@endpush
