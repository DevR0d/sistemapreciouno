@extends('intranet/layout')
@section('title', 'Productos')
@section('subtitle', 'Gestión del catálogo de productos')

@section('header-actions')
    <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#idmodalProductos">
        <i class="fa-solid fa-plus me-2"></i>
        Nuevo Producto
    </button>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Tabla de productos -->
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-boxes me-2 text-primary"></i>
                        Lista de Productos
                        <span class="badge bg-secondary ms-2" data-results-count>Cargando...</span>
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                    @livewire('producto.productoslive')
            </div>
        </div>
    </div>
    <!-- Modal para agregar/editar producto -->
    <div class="modal fade" id="idmodalProductos" tabindex="-1" aria-labelledby="idlabeltitlemodalproductos" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="idlabeltitlemodalproductos">
                        <i class="fas fa-plus-circle me-2"></i>
                        Agregar Nuevo Producto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="idformproducto" class="needs-validation" data-validate novalidate>
                        @csrf
                        <input type="hidden" id="idproducto" name="idproducto" value="">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="codigoproducto" class="form-label fw-semibold">
                                    <i class="fas fa-barcode me-1"></i>
                                    Código del Producto
                                </label>
                                <input type="text" class="form-control" id="idtxtcodigoproducto" name="codigoproducto" required
                                       data-bs-toggle="tooltip" title="Ingrese el código único del producto">
                                <div class="invalid-feedback">
                                    Por favor, ingrese el código del producto.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tipoinventario" class="form-label fw-semibold">
                                    <i class="fas fa-tags me-1"></i>
                                    Tipo de Inventario
                                </label>
                                <select class="form-select" id="idselectinventario" name="tipoinventario" required>
                                    <option value="">Seleccione un tipo...</option>
                                    <option value="Tottus Oriente">Tottus Oriente</option>
                                    <option value="Tottus">Tottus</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, seleccione un tipo de inventario.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="nombre" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1"></i>
                                    Nombre del Producto
                                </label>
                                <input type="text" class="form-control" id="idtxtnombre" name="nombre" required
                                       data-bs-toggle="tooltip" title="Ingrese el nombre descriptivo del producto">
                                <div class="invalid-feedback">
                                    Por favor, ingrese el nombre del producto.
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong> La fecha de registro se asignará automáticamente al guardar el producto.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" form="idformproducto" class="btn btn-primary" data-loading="Guardando...">
                        <i class="fas fa-save me-1"></i>Guardar Producto
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Limpiar formulario al cerrar modal
        document.getElementById('idmodalProductos').addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('idformproducto');
            form.reset();
            form.classList.remove('was-validated');

            // Limpiar validaciones personalizadas
            const inputs = form.querySelectorAll('.is-valid, .is-invalid');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });

            const feedbacks = form.querySelectorAll('.invalid-feedback, .valid-feedback');
            feedbacks.forEach(feedback => {
                if (!feedback.textContent.includes('Por favor')) {
                    feedback.remove();
                }
            });
        });

        // Formatear código de producto en tiempo real
        document.getElementById('idtxtcodigoproducto').addEventListener('input', function() {
            // Solo permitir números
            this.value = this.value.replace(/[^0-9]/g, '');

            // Limitar a 20 caracteres
            if (this.value.length > 20) {
                this.value = this.value.substring(0, 20);
            }
        });

        // Capitalizar nombre del producto
        document.getElementById('idtxtnombre').addEventListener('input', function() {
            // Capitalizar primera letra de cada palabra
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        });

        // Notificaciones de éxito/error para acciones
        document.addEventListener('notification:action', function(e) {
            const { action, notification } = e.detail;

            switch(action) {
                case 'view':
                    showInfo('Redirigiendo a detalle del producto...');
                    break;
                case 'print':
                    showInfo('Preparando impresión...');
                    window.print();
                    break;
                case 'refresh':
                    location.reload();
                    break;
            }
        });
    });
    //buscador
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("filtroTabla");
        const tabla = document.querySelector("table");
        const filas = tabla.querySelectorAll("tbody tr");

        input.addEventListener("keyup", function () {
            const valor = this.value.trim().toLowerCase();

            filas.forEach(fila => {
                const textoCompleto = fila.textContent.toLowerCase();
                fila.style.display = textoCompleto.includes(valor) ? "" : "none";
            });
        });
    });
</script>
@endsection
