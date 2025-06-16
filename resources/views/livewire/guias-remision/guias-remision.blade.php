<div class="container-fluid py-2">
    <div class="table-responsive shadow-sm rounded-3 border border-light">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-dark text-center">
            <tr class="align-middle">
                <th>Código</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Razón Social</th>
                <th>Pedido / TIM</th>
                <th>Motivo</th>
                <th>Peso<br>(Kg)</th>
                <th>Volumen<br>(m³)</th>
                <th>Bultos / Pallets</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($data as $guia)
                <tr wire:key="guia-{{ $guia['idguia'] }}-{{ now()->timestamp }}" data-id="{{ $guia['idguia'] }}">
                    <td class="text-center fw-semibold">{{ $guia['codigoguia'] }}</td>
                    <td class="text-center">{{ $guia['fechaemision'] }}</td>
                    <td class="text-center">{{ $guia['horaemision'] }}</td>
                    <td class="text-start text-capitalize">{{ $guia['razonsocialguia'] }}</td>
                    <td class="text-center">{{ $guia['numerotrasladotim'] }}</td>
                    <td class="text-center">
                            <span class="badge bg-{{ $guia['motivotraslado'] === 'Venta' ? 'success' : 'info' }}">
                                {{ $guia['motivotraslado'] }}
                            </span>
                    </td>
                    <td class="text-end">{{ number_format($guia['pesobrutototal'], 2) }}</td>
                    <td class="text-end">{{ number_format($guia['volumenproducto'], 2) }}</td>
                    <td class="text-center">{{ $guia['numerobultopallet'] }}</td>
                    <td class="text-start text-wrap" style="max-width: 220px;">
                        {{ $guia['observaciones'] ?? '-' }}
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('vistadetalleguia', ["idguia" => $guia['idguia']]) }}"
                               class="btn btn-sm btn-outline-info" title="Ver Detalle" data-bs-toggle="tooltip">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-warning btn-editarguia"
                                    data-id="{{ $guia['idguia'] }}"
                                    data-codigo="{{ $guia['codigoguia'] }}"
                                    title="Editar" data-bs-toggle="tooltip">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-eliminarguia"
                                    data-id="{{ $guia['idguia'] }}" title="Eliminar" data-bs-toggle="tooltip">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @if($guia['estado'] !== 'Confirmado')
                                <a href="{{ route('vistarevisionguias', ["idguia" => $guia['idguia']]) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Conteo" data-bs-toggle="tooltip">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center text-muted py-4">
                        No se encontraron guías registradas.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endpush
