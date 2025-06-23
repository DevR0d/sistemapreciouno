@extends('intranet/layout')
@section('title', 'Guía de remision #' . ($guia->codigoguia ?? 'N/A'))
@section('subtitle', '')

@section('hideSearchBar', true)
@section('header-actions')
    <button type="button"
            class="btn btn-danger rounded-pill px-4 shadow-sm"
            onclick="window.location.href='/guiasremision'">
        <i class="fas fa-chevron-left me-2"></i> Volver al listado
    </button>
@endsection
@section('content')
    @vite('resources/css/views/prevencionistas/detalleguia.css')
    <div class="container-fluid py-2">
        <!-- Tarjeta principal -->
        <div class="card border-0 shadow">
            <!-- Encabezado con pestañas -->
            <div class="card-header bg-white p-0 border-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="detalles-tab" data-bs-toggle="tab" data-bs-target="#detalles" type="button" role="tab">
                            <i class="fas fa-info-circle me-1"></i> Detalles de la Guía
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="validacion-tab" data-bs-toggle="tab" data-bs-target="#validacion" type="button" role="tab">
                            <i class="fas fa-clipboard-check me-1"></i> Validación y Documentos
                        </button>
                    </li>
                </ul>
            </div>
            <!-- Contenido de pestañas -->
            <div class="card-body p-4 enable-scroll">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="detalles" role="tabpanel">
                        <!-- Botón de impresión -->
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="window.open('{{ route('guias.pdf', ['id' => $guia->idguia]) }}', '_blank')">
                                <i class="fas fa-file-pdf me-1"></i> EXPORTAR PDF
                            </button>
                        </div>
                        <div class="row">
                            <!-- Columna Datos Generales -->
                            <div class="col-12">
                                <div class="info-card bg-light p-3 mb-3 rounded">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 text-center">
                                        <i class="fas fa-file-signature me-2"></i>DATOS GENERALES
                                    </h6>
                                    <div class="row">
                                        @php
                                            $infoFields = [
                                              ['label' => 'N° Guía', 'id' => 'detalle-codigoguia', 'value' => $guia->codigoguia],
                                              ['label' => 'N° TIM', 'id' => 'detalle-numerotim', 'value' => $guia->numerotrasladotim],
                                              ['label' => 'Fecha Emisión', 'id' => 'detalle-fechaemision', 'value' => $guia->fechaemision],
                                              ['label' => 'Hora Emisión', 'id' => 'detalle-horaemision', 'value' => $guia->horaemision],
                                              ['label' => 'Razón Social', 'id' => 'detalle-razonsocial', 'value' => $guia->razonsocialguia, 'fullWidth' => true],
                                              ['label' => 'Motivo del traslado', 'id' => 'detalle-motivo', 'value' => $guia->motivotraslado],
                                              ['label' => 'Peso Total (kg)', 'id' => 'detalle-peso', 'value' => $guia->pesobrutototal],
                                              ['label' => 'Volumen (m³)', 'id' => 'detalle-volumen', 'value' => $guia->volumenproducto],
                                              ['label' => 'N° Bultos', 'id' => 'detalle-bultos', 'value' => $guia->numerobultopallet],
                                              ['label' => 'Observaciones', 'id' => 'detalle-observaciones', 'value' => $guia->observaciones, 'fullWidth' => true],
                                              ['label' => 'Razón Social', 'id' => 'detalle-empresa-razonsocial', 'value' => $tipoempresa->razonsocial ?? 'N/A', 'fullWidth' => true],
                                              ['label' => 'RUC', 'id' => 'detalle-empresa-ruc', 'value' => $tipoempresa->ruc ?? 'N/A'],
                                              ['label' => 'Cód. Establecimiento', 'id' => 'detalle-empresa-codigo', 'value' => $tipoempresa->codigoestablecimiento ?? 'N/A'],
                                              ['label' => 'Dirección', 'id' => 'detalle-empresa-direccion', 'value' => $tipoempresa->direccion ?? 'N/A', 'fullWidth' => true],
                                              ['label' => 'Departamento', 'id' => 'detalle-empresa-departamento', 'value' => $tipoempresa->departamento ?? 'N/A'],
                                              ['label' => 'Provincia', 'id' => 'detalle-empresa-provincia', 'value' => $tipoempresa->provincia ?? 'N/A'],
                                              ['label' => 'Ubigeo', 'id' => 'detalle-empresa-ubigeo', 'value' => $tipoempresa->ubigeo ?? 'N/A'],
                                            ];
                                        @endphp
                                        @foreach ($infoFields as $field)
                                            <div class="{{ !empty($field['fullWidth']) ? 'col-12' : 'col-6' }} mb-2">
                                                <span class="d-block text-muted small">{{ $field['label'] }}:</span>
                                                <strong id="{{ $field['id'] }}">{{ $field['value'] ?? 'N/A' }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Columna Unidad de Transporte del Conductor -->
                            <div class="col-12">
                                <div class="info-card bg-light p-3 mb-3 rounded">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 text-center">
                                        <i class="fas fa-user-tie me-2"></i> UNIDAD DE TRANSPORTE DEL CONDUCTOR
                                    </h6>
                                    <div class="row">
                                        @php
                                            $infoFields = [
                                                ['label' => 'Razón Social Transportista', 'value' => $transporte->nombre_razonsocial ?? 'N/A'],
                                                ['label' => 'N° RUC Transportista', 'value' => $transporte->ruc_transportista ?? 'N/A'],
                                                ['label' => 'Modalidad de traslado', 'value' => $transporte->modalidadtraslado ?? 'N/A'],
                                                ['label' => 'DNI del conductor', 'value' => $conductor->dni ?? 'N/A'],
                                                ['label' => 'Nombre del conductor', 'value' => $conductor->nombre ?? 'N/A'],
                                                ['label' => 'Estado del conductor', 'value' => $conductor->estado ?? 'N/A'],
                                                ['label' => 'N° Placa Vehículo Transportista', 'value' => $vehiculo->placa ?? 'N/A'],
                                                ['label' => 'N° Placa Vehículo Secundario', 'value' => $vehiculo->placasecundaria ?? 'N/A'],
                                            ];
                                        @endphp
                                        @foreach ($infoFields as $field)
                                            <div class="col-6 mb-2">
                                                <span class="d-block text-muted small">{{ $field['label'] }}:</span>
                                                <strong>{{ $field['value'] }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Tabla de Productos -->
                        <div class="mt-2 mb-0">
                            <h5 class="fw-bold text-primary mb-2">
                                <i class="fas fa-boxes me-2"></i> Productos de la Guía
                            </h5>
                            <div class="table-responsive mb-0">
                                <table class="table table-hover table-sm">
                                    <thead class="table-primary">
                                    <tr>
                                        <th width="15%" class="text-center">Código del producto</th>
                                        <th width="35%" class="text-center">Descripción</th>
                                        <th width="20%" class="text-center">Condición</th>
                                        <th width="10%" class="text-center">Cantidad recibida</th>
                                        <th width="10%" class="text-center">Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($detalleguia as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->codproducto ?? 'Sin descripción' }}</td>
                                            <td class="text-center">{{ $item->producto ?? 'Sin descripción' }}</td>
                                            <td class="text-center">{{ $item->condicion ?? 'Sin descripción' }}</td>
                                            <td class="text-center">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                                            <td class="text-center">
                        <span class="badge bg-{{ $item->estado === 'VALIDADO' ? 'success' : 'secondary' }}">
                            {{ $item->estado }}
                        </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                <i class="fas fa-box-open me-2"></i> No se encontraron productos en esta guía
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Validación y Documentos (combinación de Productos Validados y Documentos) -->
                <div class="tab-pane fade" id="validacion" role="tabpanel">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i> Productos validados clasificados por condición
                    </div>

                    <div class="accordion mb-4" id="accordionCondiciones">
                        <!-- Productos Buenos -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingBuenos">
                                <button class="accordion-button bg-success bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBuenos" aria-expanded="true">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Productos Buenos ({{ count($productosBuenos) }})
                                </button>
                            </h2>
                            <div id="collapseBuenos" class="accordion-collapse collapse show" aria-labelledby="headingBuenos" data-bs-parent="#accordionCondiciones">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="10%">Código</th>
                                                <th width="40%">Descripción</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="20%">Condición</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($productosBuenos as $item)
                                                <tr>
                                                    <td>{{ $item->codproducto ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $item->producto ?? 'Sin descripción' }}
                                                        @if(!empty($item->observaciones))
                                                            <small class="text-muted d-block">{{ $item->observaciones }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-success">{{ $item->nombretipocondicion ?? 'VALIDADO' }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        <i class="fas fa-box-open me-2"></i> No hay productos en estado Bueno
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Productos Regulares -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingRegulares">
                                <button class="accordion-button bg-warning bg-opacity-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRegulares">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Productos Regulares ({{ count($productosRegulares) }})
                                </button>
                            </h2>
                            <div id="collapseRegulares" class="accordion-collapse collapse" aria-labelledby="headingRegulares" data-bs-parent="#accordionCondiciones">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="10%">Código</th>
                                                <th width="40%">Descripción</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="20%">Condición</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($productosRegulares as $item)
                                                <tr>
                                                    <td>{{ $item->codproducto ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $item->producto ?? 'Sin descripción' }}
                                                        @if(!empty($item->observaciones))
                                                            <small class="text-muted d-block">{{ $item->observaciones }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-warning">{{ $item->nombretipocondicion ?? 'REGULAR' }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        <i class="fas fa-box-open me-2"></i> No hay productos en estado Regular
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Productos Dañados -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDanados">
                                <button class="accordion-button bg-danger bg-opacity-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDanados">
                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                    Productos Dañados ({{ count($productosDanados) }})
                                </button>
                            </h2>
                            <div id="collapseDanados" class="accordion-collapse collapse" aria-labelledby="headingDanados" data-bs-parent="#accordionCondiciones">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="10%">Código</th>
                                                <th width="40%">Descripción</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="20%">Condición</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($productosDanados as $item)
                                                <tr>
                                                    <td>{{ $item->codproducto ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $item->producto ?? 'Sin descripción' }}
                                                        @if(!empty($item->observaciones))
                                                            <small class="text-muted d-block">{{ $item->observaciones }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-danger">{{ $item->nombretipocondicion ?? 'DAÑADO' }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        <i class="fas fa-box-open me-2"></i> No hay productos Dañados
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Productos Pendientes -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPendientes">
                                <button class="accordion-button bg-secondary bg-opacity-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePendientes">
                                    <i class="fas fa-clock text-secondary me-2"></i>
                                    Productos Pendientes ({{ count($productosSinCondicion ?? []) }})
                                </button>
                            </h2>
                            <div id="collapsePendientes" class="accordion-collapse collapse" aria-labelledby="headingPendientes" data-bs-parent="#accordionCondiciones">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="10%">Código</th>
                                                <th width="40%">Descripción</th>
                                                <th width="15%">Cantidad</th>
                                                <th width="20%">Condición</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($productosSinCondicion as $item)
                                                <tr>
                                                    <td>{{ $item->codproducto ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $item->producto ?? 'Sin descripción' }}
                                                        @if(!empty($item->observaciones))
                                                            <small class="text-muted d-block">{{ $item->observaciones }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ number_format($item->cantidad ?? 0, 2) }}</td>
                                                    <td><span class="badge bg-secondary">PENDIENTE</span></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">
                                                        <i class="fas fa-box-open me-2"></i> No hay productos pendientes
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Validación -->
                    <div class="card border-primary mt-4">
                        <div class="card-header bg-primary bg-opacity-10">
                            <h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Resumen de Validación</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Fecha Validación:</strong>
                                        {{--                                            {{ $validacion->fechavalidacion ?? 'N/A' }}--}}
                                        16-05-2025
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Total Productos Validados:</strong> {{ number_format($totalValidados, 2) }}</p>
                                </div>
                            </div>
                            @if(!empty($validacion->observaciones))
                                <div class="alert alert-warning mt-3 mb-0">
                                    <strong><i class="fas fa-exclamation-circle me-2"></i>Observaciones:</strong>
                                    {{ $validacion->observaciones }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
