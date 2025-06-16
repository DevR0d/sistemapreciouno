@extends('intranet/layout')
@section('title', 'Productos de Guía')
@section('hidePageHeader', true)
@section('content')
    @vite('resources/css/views/prevencionistas/detalleguia.css')
    <div class="container-fluid py-2" style="overflow-y: auto; max-height: 90vh;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0 text-dark fw-bold">
                <i class="fas fa-truck me-2 text-primary"></i>
                Guía de Remisión <span class="text-primary">#{{ $guia->codigoguia ?? 'N/A' }}</span>
            </h2>
            <button type="button"
                    class="btn btn-outline-primary rounded-pill px-4 shadow-sm"
                    onclick="window.location.href='/guiasremision'">
                <i class="fas fa-chevron-left me-2"></i> Volver al listado
            </button>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <ul class="nav nav-tabs" id="tabsGuia" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabDetalle" type="button">
                            <i class="fas fa-info-circle me-1"></i> Detalles de la Guía
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabValidacion" type="button">
                            <i class="fas fa-clipboard-check me-1"></i> Validación y Documentos
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane fade show active" id="tabDetalle">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('guias.pdf', ['id' => $guia->idguia]) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                        </a>
                    </div>

                    <!-- DATOS GENERALES -->
                    <div class="row">
                        <div class="col-12">
                            <div class="bg-light p-4 rounded mb-4 shadow-sm">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-file-signature me-2"></i>Datos De La Guía
                                </h5>
                                <div class="row">
                                    @php
                                        $infoFields = [
                                            ['Nº Guía', $guia->codigoguia],
                                            ['Nº TIM', $guia->numerotrasladotim],
                                            ['Fecha Emisión', $guia->fechaemision],
                                            ['Hora Emisión', $guia->horaemision],
                                            ['Razón Social de la Guía', $guia->razonsocialguia],
                                            ['Motivo del traslado', $guia->motivotraslado],
                                            ['Peso Total (kg)', $guia->pesobrutototal],
                                            ['Volumen (m³)', $guia->volumenproducto],
                                            ['Nº Bultos', $guia->numerobultopallet],
                                            ['Observaciones', $guia->observaciones],
                                            ['Conductor', $guia->conductor->nombre ?? 'N/A'],
                                            ['DNI del Conductor', $guia->conductor->dni ?? 'N/A'],
                                            ['Empresa Remitente', $guia->empresa->razonsocial ?? 'N/A'],
                                            ['RUC Empresa', $guia->empresa->ruc ?? 'N/A'],
                                            ['Dirección Empresa', $guia->empresa->direccion ?? 'N/A'],
                                            ['Ubigeo Empresa', $guia->empresa->ubigeo ?? 'N/A'],
                                        ];
                                    @endphp
                                    @foreach ($infoFields as [$label, $value])
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <span class="text-muted small">{{ $label }}:</span><br>
                                            <strong>{{ $value ?? 'N/A' }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA DE PRODUCTOS -->
                    <div class="mt-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="fas fa-boxes me-2"></i> Productos de la Guía
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Condición</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($detalleguia as $item)
                                    <tr>
                                        <td>{{ $item->idproducto }}</td>
                                        <td>{{ $item->codproducto }}</td>
                                        <td>{{ $item->producto }}</td>
                                        <td>{{ $item->condicion }}</td>
                                        <td>{{ number_format($item->cant ?? 0, 2) }}</td>
                                        <td><span class="badge bg-{{ $item->estado === 'VALIDADO' ? 'success' : 'warning' }}">{{ $item->estado }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No hay productos en esta guía</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB VALIDACION -->
                <div class="tab-pane fade" id="tabValidacion">
                    <div class="alert alert-info"><i class="fas fa-info-circle me-2"></i> Resumen de productos por condición</div>

                    <!-- VALIDACIONES -->
                    @php
                        $tipos = [
                            ['label' => 'Buenos', 'items' => $productosBuenos, 'color' => 'success'],
                            ['label' => 'Regulares', 'items' => $productosRegulares, 'color' => 'warning'],
                            ['label' => 'Dañados', 'items' => $productosDanados, 'color' => 'danger'],
                            ['label' => 'Pendientes', 'items' => $productosSinCondicion, 'color' => 'secondary'],
                        ];
                    @endphp
                    <div class="accordion" id="accordionValidacion">
                        @foreach ($tipos as $index => $tipo)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }} bg-{{ $tipo['color'] }} bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                        <i class="fas fa-circle me-2 text-{{ $tipo['color'] }}"></i>
                                        Productos {{ $tipo['label'] }} ({{ count($tipo['items']) }})
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#accordionValidacion">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Unidad</th>
                                                    <th>Condición</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($tipo['items'] as $item)
                                                    <tr>
                                                        <td>{{ $item->codproducto }}</td>
                                                        <td>{{ $item->producto }} @if($item->observaciones)<small class="text-muted d-block">{{ $item->observaciones }}</small>@endif</td>
                                                        <td>{{ number_format($item->cantidad ?? 0, 2) }}</td>
                                                        <td>{{ $item->unidadmedida ?? 'N/A' }}</td>
                                                        <td><span class="badge bg-{{ $tipo['color'] }}">{{ $item->nombretipocondicion ?? strtoupper($tipo['label']) }}</span></td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="5" class="text-center text-muted">No hay productos en esta categoría</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- RESUMEN VALIDACION -->
                    <div class="card mt-4">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Resumen de Validación</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha Validación:</strong> {{ $validacion->fechavalidacion ?? 'N/A' }}</p>
                            <p><strong>Total Productos:</strong> {{ $validacion->cantrecibidarevision ?? 0 }}</p>
                            @if (!empty($validacion->observaciones))
                                <div class="alert alert-warning mt-3">
                                    <strong>Observaciones:</strong> {{ $validacion->observaciones }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
