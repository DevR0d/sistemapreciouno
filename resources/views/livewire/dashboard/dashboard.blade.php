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
    <!-- Gráfico ancho -->
    {{--    <div class="card mb-4 shadow-sm rounded-3"> --}}
    {{--        <div class="card-header bg-light fw-semibold d-flex align-items-center"> --}}
    {{--            <i class="fas fa-chart-area me-2"></i> Últimas Guías Emitidas --}}
    {{--        </div> --}}
    {{--        <div class="card-body p-3"> --}}
    {{--            <canvas id="myAreaChart" style="width: 100%; height: 350px;"></canvas> --}}
    {{--            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    <!-- Gráfico de líneas: Guías sin y con discrepancias -->
    <div class="card mb-4 shadow-sm rounded-3">
        <div class="card-header bg-light fw-semibold d-flex align-items-center">
            <i class="fas fa-chart-line me-2"></i> Guías Emitidas (Sin vs Con Discrepancias)
        </div>
        <div class="card-body p-3">
            <canvas id="chartGuiasDiscrepancias" style="width: 100%; height: 350px;"></canvas>
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
                        No se encontraron productos con discrepancias
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Nuevo apartado final: Dashboard adicional -->
    <div class="row g-4">
        <!-- Top 5 servicios más vendidos -->
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-3 p-3">
                <div class="text-center mb-3">
                </div>
                {{--                Canvas para grafico pastel--}}
                <div class="card mb-4 shadow-sm rounded-3">
                    <div class="card-header bg-light fw-semibold d-flex align-items-center">
                        <i class="fas fa-chart-pie me-2"></i> Estado de Guías (Sin Daño vs Con Daño)
                    </div>
                    <div class="card-body p-3">
                        <canvas id="pieChart" style="width: 100%; height: 350px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- NUEVO CARD UNIFICADO: Guías con discrepancias + gráfico --}}
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
                            <canvas id="chartTopDiscrepancias" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- NUEVO CARD: Productos con más discrepancias --}}
        <div class="card shadow-sm rounded-3 p-3">
            <div class="card-header bg-light fw-semibold d-flex align-items-center mb-3">
                <i class="fas fa-box-open me-2"></i> Top 10 Productos con Más Discrepancias
            </div>
            <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead class="table-success sticky-top">
                    <tr>
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Total entregado / Revisado</th>
                        <th>Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productosConDiscrepancias as $item)
                        <tr>
                            <td>{{ $item->codproducto }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>{{ $item->cantrecibida }} / {{ $item->cantrecibidarevision }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Scripts para gráficos --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico Últimas Guías Emitidas
    {{-- const ctxArea = document.getElementById('myAreaChart').getContext('2d'); --}}
    {{-- new Chart(ctxArea, { --}}
    {{--    type: 'line', --}}
    {{--    data: { --}}
    {{--        labels: {!! json_encode($ultimasGuias->pluck('fecha')) !!}, --}}
    {{--        datasets: [{ --}}
    {{--            label: 'Guías Emitidas', --}}
    {{--            data: {!! json_encode($ultimasGuias->pluck('total')) !!}, --}}
    {{--            fill: true, --}}
    {{--            borderColor: 'rgba(54, 162, 235, 1)', --}}
    {{--            backgroundColor: 'rgba(54, 162, 235, 0.2)', --}}
    {{--            tension: 0.3 --}}
    {{--        }] --}}
    {{--    }, --}}
    {{--    options: { --}}
    {{--        responsive: true, --}}
    {{--        scales: { --}}
    {{--            y: { beginAtZero: true } --}}
    {{--        } --}}
    {{--    } --}}
    {{-- }); --}}
    const ctxGuias = document.getElementById('chartGuiasDiscrepancias').getContext('2d');
    new Chart(ctxGuias, {
        type: 'line',
        data: {
            labels: @json($fechas),
            datasets: [{
                label: 'Guías Sin Discrepancias',
                data: @json($datosSinDiscrepancias),
                borderColor: 'orange',
                backgroundColor: 'rgba(255,165,0,0.2)',
                tension: 0.4,
                pointRadius: 5
            },
                {
                    label: 'Guías Con Discrepancias',
                    data: @json($datosConDiscrepancias),
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
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha de emisión'
                    }
                }
            }
        }
    });

    // Gráfico Pie: Estado de Guías
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Guías Sin Daño', 'Guías Con Daño'],
            datasets: [{
                label: 'Cantidad de Guías',
                data: [{{ $guiasSinDanio }}, {{ $guiasConDanio }}],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)', // verde
                    'rgba(220, 53, 69, 0.7)' // rojo
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    // Gráfico barras: Top 10 guías con más discrepancias
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
                    title: {
                        display: true,
                        text: 'Cantidad de Discrepancias'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'N° Guía'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
