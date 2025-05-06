@extends('intranet/layout')
@section('title','Guiasderemision')

@section('content')
    <div class="container-fluid py-2">
        <!-- Título y botón -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Guías de Remisión</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#idmodalguiasremision">
                <i class="fa-solid fa-plus-minus"></i>
                Agregar Nueva Guía
            </button>
        </div>

        <!-- Barra de búsqueda unificada -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar por número de guía, producto, estado...">
                    <button class="btn btn-outline-secondary" type="button">Buscar</button>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        @livewire('guias-remision.guias-remision')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="idmodalguiasremision" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Guía de Remisión</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="idformguiasremision" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="idtxttim" class="form-label">N° TIM (Guía de Remisión)</label>
                                <input type="text" class="form-control" id="idtxttim" name="tim" required>
                                <div class="invalid-feedback">Por favor ingrese el número TIM.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="idtxtmotivotraslado" class="form-label">Motivo de Traslado</label>
                                <input type="text" class="form-control" id="idtxtmotivotraslado" name="motivotraslado" required>
                                <div class="invalid-feedback">Por favor ingrese el motivo.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="idtxtselectorigen" class="form-label">Origen</label>
                                <input type="text" class="form-control" id="idtxtselectorigen" name="origen" required>
                                <div class="invalid-feedback">Por favor ingrese el origen.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="idtxtselectdestino" class="form-label">Destino</label>
                                <input type="text" class="form-control" id="idtxtselectdestino" name="destino" required>
                                <div class="invalid-feedback">Por favor ingrese el destino.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="idselectestado" class="form-label">Estado</label>
                                <select class="form-select" id="idselectestado" name="estado" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En transito">En tránsito</option>
                                    <option value="Entregado">Entregado</option>
                                    <option value="Rechazado">Rechazado</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione un estado.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="idselectcantidadenviada" class="form-label">Cantidad Enviada</label>
                                <input type="number" class="form-control" id="idselectcantidadenviada" name="cantidadenviada" required>
                                <div class="invalid-feedback">Por favor ingrese la cantidad.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="idselectvehiculo" class="form-label">Vehículo</label>
                                <select class="form-select" id="idselectvehiculo" name="idvehiculo" required>
                                    <option value="">Seleccione un vehículo...</option>
                                    @foreach($vehiculos as $vehiculo)
                                        <option value="{{ $vehiculo->idvehiculo }}">
                                            {{ $vehiculo->placa }} - {{ $vehiculo->marca }}
                                        </option>
                                    @endforeach
                                </select>

                                <select class="form-select" id="idselectconductor" name="idconductor" required>
                                    <option value="">Seleccione un conductor...</option>
                                    @foreach($conductores as $conductor)
                                        <option value="{{ $conductor->idconductor }}">
                                            {{ $conductor->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="idtxtobservacion" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="idtxtobservacion" name="observacion" rows="2"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save me-1"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa-solid fa-times me-1"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
