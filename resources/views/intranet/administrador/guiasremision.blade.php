@extends('intranet/layout')
@section('title','Guiasderemision')

@section('content')
    <div class="container-fluid py-3">
        <!-- Barra de búsqueda y acciones -->
        <div class="row mb-4 align-items-center">
            <!-- Campo de búsqueda -->
            <div class="col-md-5 mb-2 mb-md-0">
                <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
                    <input type="text"
                           id="filtroTabla"
                           class="form-control"
                           placeholder="Filtrar por código, razón social o N° de pedido">
                </div>
            </div>

            <!-- Selector de items por página -->
            <div class="col-md-3 mb-2 mb-md-0">
                <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-list-ol"></i>
            </span>
                    <select class="form-select" wire:model.live="perPage" aria-label="Items por página">
                        <option value="10">10 por página</option>
                        <option value="25">25 por página</option>
                        <option value="50">50 por página</option>
                        <option value="100">100 por página</option>
                    </select>
                </div>
            </div>
            <!-- Botón de agregar -->
            <div class="col-md-4 text-md-end">
                <a href="{{ route('vistaaddguiaremisionadministrador') }}"
                   class="btn btn-primary w-40 w-md-auto"
                   id="btnnuevaguia">
                    <i class="fa-solid fa-plus-minus me-2"></i>
                    Nueva Guía
                </a>
            </div>
        </div>
    </div>
    <div class="enable-scroll">
        <!-- Tabla Livewire -->
        @livewire('guiasremisionadministrador')
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("filtroTabla");
        const tabla = document.querySelector("table");
        const filas = tabla.querySelectorAll("tbody tr");

        input.addEventListener("keyup", function () {
            const valor = this.value.toLowerCase();

            filas.forEach(fila => {
                const textoFila = fila.textContent.toLowerCase();
                fila.style.display = textoFila.includes(valor) ? "" : "none";
            });
        });
    });
</script>
