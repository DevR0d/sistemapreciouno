@extends('intranet/layout')
@section('title', 'Guiasderemision')

@section('header-actions')
    <a href="{{ route('vistaaddguiaremision') }}"
       class="btn btn-danger rounded-pill px-4 shadow-sm"
       id="btnnuevaguia">
        <i class="fa-solid fa-plus-minus me-2"></i>
        Nueva Guía
    </a>
@endsection

@section('content')
    <div class="enable-scroll">
        <!-- Tabla Livewire -->
        @livewire('guias-remision.guias-remision')
    </div>
@endsection
<script>
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
