@extends('intranet/layout')
@section('title', 'Guía de Remisión Electrónica #' . ($guia->codigoguia ?? 'N/A'))
@section('subtitle', '')

@section('hideSearchBar', true)
@section('header-actions')
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-success btn-sm"
                onclick="window.open('{{ route('guias.pdf', ['id' => $guia->idguia]) }}', '_blank')">
            <i class="fas fa-file-pdf me-1"></i> Exportar PDF
        </button>
        <button type="button" class="btn btn-outline-primary btn-sm"
                onclick="window.print()">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
        <button type="button"
                class="btn btn-danger rounded-pill px-4 shadow-sm"
                onclick="window.location.href='/guiasremision'">
            <i class="fas fa-chevron-left me-2"></i> Volver
        </button>
    </div>
@endsection

@section('content')
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; }
            .card { box-shadow: none !important; border: 1px solid #000 !important; }
        }
        
        .guia-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border-radius: 8px 8px 0 0;
        }
        
        .guia-section {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .section-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: #495057;
        }
        
        .data-row {
            border-bottom: 1px solid #f1f3f4;
            padding: 0.5rem 0;
        }
        
        .data-row:last-child {
            border-bottom: none;
        }
        
        .label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .value {
            font-weight: 500;
            color: #212529;
        }
        
        .stamp {
            position: relative;
            border: 3px solid #28a745;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: rgba(40, 167, 69, 0.1);
            transform: rotate(-15deg);
        }
        
        .stamp-text {
            text-align: center;
            font-weight: bold;
            color: #28a745;
            font-size: 0.75rem;
            line-height: 1.2;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 6rem;
            color: rgba(0, 0, 0, 0.05);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
        
        .qr-placeholder {
            width: 80px;
            height: 80px;
            border: 2px dashed #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .electronic-signature {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 1rem;
            background: #f8f9fa;
            text-align: center;
        }
        
        .validation-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            margin: 0.5rem 0;
        }
    </style>

    <div class="container-fluid py-3">
        <!-- Marca de agua -->
        <div class="watermark d-none d-print-block">ORIGINAL</div>
        
        <div class="content-wrapper">
            <!-- Encabezado Principal de la Guía -->
            <div class="card shadow-lg mb-4">
                <div class="guia-header p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                <i class="fas fa-truck fa-3x mb-2"></i>
                                <h4 class="mb-0">PRECIO UNO</h4>
                                <small>Sistema Logístico</small>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h2 class="mb-2">GUÍA DE REMISIÓN ELECTRÓNICA</h2>
                            <p class="mb-0">Documento Tributario Electrónico</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="border border-light rounded p-3">
                                <h3 class="mb-1">{{ $guia->codigoguia ?? 'N/A' }}</h3>
                                <small>N° de Guía</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Emisor y Receptor -->
            <div class="row mb-4">
                <!-- Datos del Emisor -->
                <div class="col-md-6">
                    <div class="guia-section">
                        <div class="section-header">
                            <i class="fas fa-building me-2"></i>DATOS DEL EMISOR
                        </div>
                        <div class="p-3">
                            <div class="data-row">
                                <div class="label">Razón Social:</div>
                                <div class="value">{{ $tipoempresa->razonsocial ?? 'HIPERMERCADOS TOTTUS S.A.' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">RUC:</div>
                                <div class="value">{{ $tipoempresa->ruc ?? '20393864886' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Dirección:</div>
                                <div class="value">{{ $tipoempresa->direccion ?? 'Av. Centenario No. 2086' }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="data-row">
                                        <div class="label">Departamento:</div>
                                        <div class="value">{{ $tipoempresa->departamento ?? 'UCAYALI' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="data-row">
                                        <div class="label">Provincia:</div>
                                        <div class="value">{{ $tipoempresa->provincia ?? 'CORONEL PORTILLO' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="label">Ubigeo:</div>
                                <div class="value">{{ $tipoempresa->ubigeo ?? '150118' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Datos del Receptor -->
                <div class="col-md-6">
                    <div class="guia-section">
                        <div class="section-header">
                            <i class="fas fa-user-tie me-2"></i>DATOS DEL RECEPTOR
                        </div>
                        <div class="p-3">
                            <div class="data-row">
                                <div class="label">Cliente:</div>
                                <div class="value">{{ $guia->razonsocialguia ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Fecha de Emisión:</div>
                                <div class="value">{{ \Carbon\Carbon::parse($guia->fechaemision)->format('d/m/Y') ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Hora de Emisión:</div>
                                <div class="value">{{ $guia->horaemision ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Motivo del Traslado:</div>
                                <div class="value">
                                    <span class="badge bg-primary">{{ $guia->motivotraslado ?? 'Venta' }}</span>
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="label">N° TIM:</div>
                                <div class="value">{{ $guia->numerotrasladotim ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Transporte -->
            <div class="guia-section mb-4">
                <div class="section-header">
                    <i class="fas fa-shipping-fast me-2"></i>DATOS DEL TRANSPORTE
                </div>
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="data-row">
                                <div class="label">Empresa Transportista:</div>
                                <div class="value">{{ $transporte->nombre_razonsocial ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">RUC Transportista:</div>
                                <div class="value">{{ $transporte->ruc_transportista ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Modalidad:</div>
                                <div class="value">{{ $transporte->modalidadtraslado ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="data-row">
                                <div class="label">Conductor:</div>
                                <div class="value">{{ $conductor->nombre ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">DNI Conductor:</div>
                                <div class="value">{{ $conductor->dni ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Estado Conductor:</div>
                                <div class="value">
                                    <span class="badge bg-success">{{ $conductor->estado ?? 'Activo' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="data-row">
                                <div class="label">Placa Vehículo:</div>
                                <div class="value">{{ $vehiculo->placa ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Placa Remolque:</div>
                                <div class="value">{{ $vehiculo->placasecundaria ?? 'N/A' }}</div>
                            </div>
                            <div class="data-row">
                                <div class="label">Estado Vehículo:</div>
                                <div class="value">
                                    <span class="badge bg-success">{{ $vehiculo->estado ?? 'Activo' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalle de Productos -->
            <div class="guia-section mb-4">
                <div class="section-header">
                    <i class="fas fa-boxes me-2"></i>DETALLE DE PRODUCTOS TRANSPORTADOS
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th width="5%">Item</th>
                                <th width="15%">Código EAN/SKU</th>
                                <th width="45%">Descripción del Producto</th>
                                <th width="10%">Unidad</th>
                                <th width="10%">Cantidad</th>
                                <th width="15%">Estado/Condición</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($detalleguia as $index => $item)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <code>{{ $item->codproducto ?? 'N/A' }}</code>
                                    </td>
                                    <td>{{ $item->producto ?? 'Sin descripción' }}</td>
                                    <td class="text-center">UND</td>
                                    <td class="text-center fw-bold">{{ number_format($item->cantidad ?? 0, 0) }}</td>
                                    <td class="text-center">
                                        @if($item->estado === 'VALIDADO')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>{{ $item->condicion }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>{{ $item->estado }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                        No se encontraron productos en esta guía
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Resumen de Carga -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="guia-section">
                        <div class="section-header">
                            <i class="fas fa-weight-hanging me-2"></i>RESUMEN DE CARGA
                        </div>
                        <div class="p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="data-row">
                                        <div class="label">Peso Bruto Total:</div>
                                        <div class="value">{{ number_format($guia->pesobrutototal ?? 0, 2) }} Kg</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="data-row">
                                        <div class="label">Volumen Total:</div>
                                        <div class="value">{{ number_format($guia->volumenproducto ?? 0, 2) }} m³</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="data-row">
                                        <div class="label">N° Bultos/Pallets:</div>
                                        <div class="value">{{ $guia->numerobultopallet ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                            @if($guia->observaciones)
                                <div class="data-row mt-3">
                                    <div class="label">Observaciones:</div>
                                    <div class="value">{{ $guia->observaciones }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="guia-section">
                        <div class="section-header">
                            <i class="fas fa-qrcode me-2"></i>CÓDIGO QR
                        </div>
                        <div class="p-3 text-center">
                            <div class="qr-placeholder mx-auto mb-2">
                                <i class="fas fa-qrcode fa-2x text-muted"></i>
                            </div>
                            <small class="text-muted">Código QR para verificación</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validación y Firmas -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="guia-section">
                        <div class="section-header">
                            <i class="fas fa-clipboard-check me-2"></i>VALIDACIÓN DEL SISTEMA
                        </div>
                        <div class="p-3 text-center">
                            @if($guia->estado === 'Confirmado')
                                <div class="stamp mb-3">
                                    <div class="stamp-text">
                                        VALIDADO<br>
                                        <small>{{ now()->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                <div class="validation-badge">
                                    <i class="fas fa-shield-check me-2"></i>
                                    Documento Validado Electrónicamente
                                </div>
                            @else
                                <div class="text-warning">
                                    <i class="fas fa-clock fa-3x mb-2"></i>
                                    <p>Pendiente de Validación</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="guia-section">
                        <div class="section-header">
                            <i class="fas fa-signature me-2"></i>FIRMA ELECTRÓNICA
                        </div>
                        <div class="p-3">
                            <div class="electronic-signature">
                                <i class="fas fa-certificate fa-2x text-primary mb-2"></i>
                                <p class="mb-1"><strong>Documento firmado electrónicamente</strong></p>
                                <small class="text-muted">
                                    Hash: {{ substr(md5($guia->codigoguia . $guia->fechaemision), 0, 16) }}<br>
                                    Fecha: {{ now()->format('d/m/Y H:i:s') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Legal -->
            <div class="card bg-light">
                <div class="card-body py-2">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <small class="text-muted">
                                <strong>REPRESENTACIÓN IMPRESA DE LA GUÍA DE REMISIÓN ELECTRÓNICA</strong><br>
                                Este documento ha sido generado en el Sistema de Gestión Logística de Precio Uno.
                                Para verificar la autenticidad de este documento, visite nuestro portal web.
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>Generado: {{ now()->format('d/m/Y H:i:s') }}<br>
                                <i class="fas fa-user me-1"></i>Usuario: {{ Auth::user()->name }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestañas de Validación (solo visible en pantalla) -->
            <div class="mt-4 no-print">
                <ul class="nav nav-tabs" id="validacionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">
                            <i class="fas fa-chart-pie me-1"></i> Resumen de Validación
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos" type="button" role="tab">
                            <i class="fas fa-boxes me-1"></i> Productos por Estado
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content border border-top-0 rounded-bottom" id="validacionTabsContent">
                    <div class="tab-pane fade show active p-4" id="resumen" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                        <h4 class="text-success">{{ count($productosBuenos) }}</h4>
                                        <small>Productos Buenos</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-warning">
                                    <div class="card-body text-center">
                                        <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                                        <h4 class="text-warning">{{ count($productosRegulares) }}</h4>
                                        <small>Productos Regulares</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-danger">
                                    <div class="card-body text-center">
                                        <i class="fas fa-times-circle text-danger fa-2x mb-2"></i>
                                        <h4 class="text-danger">{{ count($productosDanados) }}</h4>
                                        <small>Productos Dañados</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-secondary">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clock text-secondary fa-2x mb-2"></i>
                                        <h4 class="text-secondary">{{ count($productosSinCondicion ?? []) }}</h4>
                                        <small>Pendientes</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade p-4" id="productos" role="tabpanel">
                        <div class="accordion" id="productosAccordion">
                            @php
                                $estados = [
                                    'Buenos' => ['items' => $productosBuenos, 'color' => 'success', 'icon' => 'check-circle'],
                                    'Regulares' => ['items' => $productosRegulares, 'color' => 'warning', 'icon' => 'exclamation-triangle'],
                                    'Dañados' => ['items' => $productosDanados, 'color' => 'danger', 'icon' => 'times-circle'],
                                    'Pendientes' => ['items' => $productosSinCondicion ?? [], 'color' => 'secondary', 'icon' => 'clock']
                                ];
                            @endphp
                            
                            @foreach($estados as $estado => $config)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $estado }}">
                                            <i class="fas fa-{{ $config['icon'] }} text-{{ $config['color'] }} me-2"></i>
                                            {{ $estado }} ({{ count($config['items']) }})
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $estado }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#productosAccordion">
                                        <div class="accordion-body">
                                            @forelse($config['items'] as $item)
                                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                    <div>
                                                        <strong>{{ $item->codproducto ?? 'N/A' }}</strong> - {{ $item->producto ?? 'Sin descripción' }}
                                                        @if(!empty($item->observaciones))
                                                            <br><small class="text-muted">{{ $item->observaciones }}</small>
                                                        @endif
                                                    </div>
                                                    <span class="badge bg-{{ $config['color'] }}">{{ number_format($item->cantidad ?? 0, 0) }}</span>
                                                </div>
                                            @empty
                                                <p class="text-muted text-center py-3">No hay productos en estado {{ strtolower($estado) }}</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Mejorar la experiencia de impresión
    window.addEventListener('beforeprint', function() {
        document.title = 'Guía de Remisión - {{ $guia->codigoguia }}';
    });
    
    // Función para copiar código al portapapeles
    function copyCode(code) {
        navigator.clipboard.writeText(code).then(function() {
            // Mostrar notificación de éxito
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check me-2"></i>Código copiado al portapapeles
                    </div>
                </div>
            `;
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            setTimeout(() => toast.remove(), 3000);
        });
    }
    
    // Agregar funcionalidad de clic para copiar códigos
    document.addEventListener('DOMContentLoaded', function() {
        const codes = document.querySelectorAll('code');
        codes.forEach(code => {
            code.style.cursor = 'pointer';
            code.title = 'Clic para copiar';
            code.addEventListener('click', () => copyCode(code.textContent));
        });
    });
</script>
@endpush