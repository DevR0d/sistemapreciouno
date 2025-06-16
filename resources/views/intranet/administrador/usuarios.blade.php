@extends('intranet.layout')
@section('title', 'Usuarios')
@section('subtitle', 'Gestión de usuarios del sistema')

@section('header-actions')
    <button type="button" class="btn btn-danger rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#idmodalUsuarios">
        <i class="fa-solid fa-plus me-2"></i>
        Nuevo Usuario
    </button>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Estadísticas rápidas -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-user-shield text-primary fa-2x mb-2"></i>
                        <h4 class="text-primary mb-1">3</h4>
                        <small class="text-muted">Administradores</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check text-success fa-2x mb-2"></i>
                        <h4 class="text-success mb-1">12</h4>
                        <small class="text-muted">Prevencionistas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <i class="fas fa-users text-info fa-2x mb-2"></i>
                        <h4 class="text-info mb-1">15</h4>
                        <small class="text-muted">Total Usuarios</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-users me-2 text-primary"></i>
                        Lista de Usuarios
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="enable-scroll">
                    @livewire('usuarios.gestionusuario')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar usuario -->
    <div class="modal fade" id="idmodalUsuarios" tabindex="-1" aria-labelledby="idlabeltitleidmodalUsuarios" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="idlabeltitleidmodalUsuarios">
                        <i class="fas fa-user-plus me-2"></i>
                        Agregar Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="idformusuario" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" id="idusuario" name="idusuario" value="">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="idtxtnombre" class="form-label fw-semibold">
                                    <i class="fas fa-user me-1"></i>
                                    Nombre del Usuario
                                </label>
                                <input type="text" class="form-control" id="idtxtnombre" name="nombre" required>
                                <div class="invalid-feedback">
                                    Por favor, ingrese el nombre del usuario.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="idtxtemail" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-1"></i>
                                    Correo Electrónico
                                </label>
                                <input type="email" class="form-control" id="idtxtemail" name="email" required>
                                <div class="invalid-feedback">
                                    Por favor, ingrese un correo electrónico válido.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="idtxtpassword" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-1"></i>
                                    Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="idtxtpassword" name="password" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    La contraseña debe tener al menos 6 caracteres.
                                </div>
                                <small class="text-muted">Mínimo 6 caracteres</small>
                            </div>

                            <div class="col-md-6">
                                <label for="idselectrol" class="form-label fw-semibold">
                                    <i class="fas fa-user-tag me-1"></i>
                                    Rol del Usuario
                                </label>
                                <select class="form-select" id="idselectrol" name="idrol" required>
                                    <option value="">Seleccione un rol</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Prevencionista</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, seleccione un rol.
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información sobre roles:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>Administrador:</strong> Acceso completo al sistema</li>
                                        <li><strong>Prevencionista:</strong> Gestión de guías de remisión</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" form="idformusuario" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Filtro de búsqueda en tiempo real
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("filtroTabla");
        const tabla = document.querySelector("table");

        if (tabla) {
            const filas = tabla.querySelectorAll("tbody tr");

            input.addEventListener("keyup", function () {
                const valor = this.value.toLowerCase();

                filas.forEach(fila => {
                    const textoFila = fila.textContent.toLowerCase();
                    fila.style.display = textoFila.includes(valor) ? "" : "none";
                });
            });
        }
    });

    // Toggle para mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('idtxtpassword');
        const icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
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

    // Limpiar formulario al cerrar modal
    document.getElementById('idmodalUsuarios').addEventListener('hidden.bs.modal', function () {
        document.getElementById('idformusuario').reset();
        document.getElementById('idformusuario').classList.remove('was-validated');
        document.getElementById('idtxtpassword').type = 'password';
        document.querySelector('#togglePassword i').classList.remove('fa-eye-slash');
        document.querySelector('#togglePassword i').classList.add('fa-eye');
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
