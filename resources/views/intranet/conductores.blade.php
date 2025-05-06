@extends('intranet/layout')
@section('title', 'Conductores')

@section('content')
    <div class="container-fluid py-2">
        <!-- Título -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Conductores</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#idmodalConductoress">
                <i class="fa-solid fa-plus-minus"></i>
                Agregar Nuevo
            </button>
        </div>

        <!-- Barra de búsqueda -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Buscar...">
            </div>
        </div>

        <!-- Tabla -->
        @livewire('Conductores.Conductoresslive')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="idmodalConductoress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="idformConductores" class="needs-validation">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="idtxtnombre" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="idtxtsku" name="sku" required>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="idselectestado" name="estado" required>
                                <option value="">Seleccione un estado para el Conductores</option>
                                <option value="Excelente">Sin daño</option>
                                <option value="Malogrado">Con daño</option>
                                {{--                                <option value="Cantidad no concuerda">Incompleto</option>--}}
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
