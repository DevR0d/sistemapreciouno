@extends('intranet/layout')
@section('title', 'Vehículos')
@section('subtitle', 'Gestión de la flota vehicular')

@section('header-actions')
    <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm" id="btnnuevovehiculo">
        <i class="fa-solid fa-plus me-2"></i>
        Nuevo Vehículo
    </button>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Tabla de vehículos -->
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-truck me-2 text-primary"></i>
                        Lista de Vehículos
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                @livewire('vehiculo.vechiculo')
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar vehículo -->
    <div class="modal fade" id="idmodalvehiculo" tabindex="-1" aria-labelledby="idlabeltitlemodalvehiculo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="idlabeltitlemodalvehiculo">
                        <i class="fas fa-truck me-2"></i>
                        Nuevo Vehículo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="idformvechiculo" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" id="idvehiculo" name="idvehiculo" value="">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="placa" class="form-label fw-semibold">
                                    <i class="fas fa-id-card me-1"></i>
                                    Placa Principal
                                </label>
                                <input type="text" class="form-control text-uppercase" id="idtxtplaca" name="placa"
                                       placeholder="Ej: ABC-123" required maxlength="8">
                                <div class="invalid-feedback">
                                    Por favor, ingrese la placa del vehículo.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="placasecundaria" class="form-label fw-semibold">
                                    <i class="fas fa-id-card-alt me-1"></i>
                                    Placa Secundaria / Remolque
                                </label>
                                <input type="text" class="form-control text-uppercase" id="idtxtplacasecundaria"
                                       name="placasecundaria" placeholder="Ej: MSKU869736-6" required>
                                <div class="invalid-feedback">
                                    Por favor, ingrese la placa secundaria.
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información:</strong> Las placas se convertirán automáticamente a mayúsculas.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" form="idformvechiculo" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Vehículo
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Convertir a mayúsculas automáticamente
    document.getElementById('idtxtplaca').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    document.getElementById('idtxtplacasecundaria').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Validación del formulario
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
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
