<div class="container-fluid px-4">
    @vite('resources/css/views/dahsboard/dashboard.css')
    <!-- Tarjetas resumen -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-gradient-primary shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold">Guías Emitidas</h6>
                        <h3 class="fw-bold">{{ $totalGuiasEmitidas }}</h3>
                    </div>
                    <i class="fas fa-truck fa-3x opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-gradient-warning shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold">Revisiones Realizadas</h6>
                        <h3 class="fw-bold">{{ $totalRevisiones }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-gradient-success shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold">Guías Sin Daño</h6>
                        <h3 class="fw-bold">{{ $guiasSinDanio }}</h3>
                    </div>
                    <i class="fas fa-shield-alt fa-3x opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-gradient-danger shadow-sm rounded-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold">Guías Con Daño</h6>
                        <h3 class="fw-bold">{{ $guiasConDanio }}</h3>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    {{-- GRÁFICO RESUMEN DE DISCREPANCIAS / SIN / FALTANTES --}}
    <div class="card shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light fw-semibold d-flex align-items-center">
            <i class="fas fa-layer-group me-2"></i> Resumen General de Guías
        </div>
        <div class="card-body p-3">
            <canvas id="chartResumenDiscrepancias" style="width: 100%; height: 350px;"></canvas>
        </div>
    </div>

    {{-- Gráficos: Pie y Línea en la misma fila --}}
    <div class="card shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light fw-semibold d-flex align-items-center">
            <i class="fas fa-chart-bar me-2"></i> Análisis Visual de Estado y Discrepancias
        </div>
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Gráfico Pie -->
                <div class="col-md-6 border-end p-3 d-flex align-items-center justify-content-center" style="min-height: 360px;">
                    <canvas id="pieChart" style="max-height: 300px; max-width: 100%;"></canvas>
                </div>

                <!-- Gráfico Línea -->
                <div class="col-md-6 p-3">
                    <canvas id="chartGuiasDiscrepancias" style="max-height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla principal -->
    <div class="card mb-5 shadow-sm rounded-3">
        <div class="card-header bg-light fw-semibold d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2"></i> Tabla de Discrepancias en Guías
        </div>
        <div class="card-body p-3">
            <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>EAN/SKU</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Total enviado</th>
                        <th>Total recibido con discrepancia</th>
                        <th>Fecha de entrega</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productosConDiscrepancias as $item)
                        <tr>
                            <td>{{ $item->codproducto }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>{{ $item->cantrecibida }}</td>
                            <td>{{ $item->cantrecibidarevision }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-box-open me-5"></i> No se encontraron productos con discrepancias.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabla: Top guías con discrepancias + gráfico barras --}}
    <div class="card shadow-sm rounded-3 p-3 mb-4">
        <div class="card-header bg-light fw-semibold d-flex align-items-center mb-3">
            <i class="fas fa-exclamation-circle me-2"></i> Top 10 Guías con Más Discrepancias
        </div>
        <div class="row g-3 align-items-stretch">
            <div class="col-md-6">
                <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                    <table class="table table-sm table-striped align-middle mb-0">
                        <thead class="table-success sticky-top">
                        <tr>
                            <th>N° Guía</th>
                            <th>Cantidad de productos</th>
                            <th>Cantidad de discrepancias</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($guiascondiscrepancias as $guia)
                            <tr>
                                <td>{{ $guia->codigoguia }}</td>
                                <td>{{ $guia->cantidad_productos }}</td>
                                <td>{{ $guia->cantidad_discrepancias }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card flex-fill shadow-sm rounded-3 w-100">
                    <div class="card-body p-3">
                        <canvas id="chartTopDiscrepancias" style="width: 100%; height: 320px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Scripts para gráficos --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico RESUMEN GENERAL
    const ctxResumen = document.getElementById('chartResumenDiscrepancias').getContext('2d');
    new Chart(ctxResumen, {
        type: 'bar',
        data: {
            labels: @json($this->labelsResumen),
            datasets: [
                {
                    label: 'Discrepancias',
                    data: @json($this->datosDiscrepancias),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                },
                {
                    label: 'Sin Discrepancias',
                    data: @json($this->datosSinDiscrepancias),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                },
                {
                    label: 'Faltantes',
                    data: @json($this->datosFaltantes),
                    backgroundColor: 'rgba(102, 0, 255, 0.7)',
                    borderColor: 'rgba(102, 0, 255, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Cantidad de Guías'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });

    // Gráfico Pie: Daño
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Guías Sin Daño', 'Guías Con Daño'],
            datasets: [{
                label: 'Cantidad de Guías',
                data: [{{ $guiasSinDanio }}, {{ $guiasConDanio }}],
                backgroundColor: ['rgba(40, 167, 69, 0.7)', 'rgba(220, 53, 69, 0.7)'],
                borderColor: ['rgba(40, 167, 69, 1)', 'rgba(220, 53, 69, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                }
            }
        }
    });

    // Gráfico Línea: Discrepancias vs Sin Discrepancias
    const ctxGuias = document.getElementById('chartGuiasDiscrepancias').getContext('2d');
    new Chart(ctxGuias, {
        type: 'line',
        data: {
            labels: @json($this->fechas),
            datasets: [
                {
                    label: 'Guías Sin Discrepancias',
                    data: @json($this->datosSinDiscrepancias),
                    borderColor: 'orange',
                    backgroundColor: 'rgba(255,165,0,0.2)',
                    tension: 0.4,
                    pointRadius: 5
                },
                {
                    label: 'Guías Con Discrepancias',
                    data: @json($this->datosConDiscrepancias),
                    borderColor: 'red',
                    backgroundColor: 'rgba(255,0,0,0.2)',
                    tension: 0.4,
                    pointRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true },
                x: { title: { display: true, text: 'Fecha de emisión' } }
            }
        }
    });

    // Gráfico Barras: Top 10 guías con más discrepancias
    const ctxBar = document.getElementById('chartTopDiscrepancias').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($guiascondiscrepancias->pluck('codigoguia')) !!},
            datasets: [{
                label: 'Discrepancias',
                data: {!! json_encode($guiascondiscrepancias->pluck('cantidad_discrepancias')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Cantidad de Discrepancias' }
                },
                x: {
                    title: { display: true, text: 'N° Guía' }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
