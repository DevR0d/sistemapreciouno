<div class="container-fluid py-2">
    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Razón Social</th>
                    <th>Pedido / TIM</th>
                    <th>Motivo de traslado</th>
                    <th>Peso (Kg)</th>
                    <th>Volumen (m³)</th>
                    <th>Bultos / Pallets</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $guia)
                    <tr class="text-center" wire:key="guia-{{ $guia['idguia'] }}-{{ now()->timestamp }}">
                        <td>{{ $guia['idguia'] }}</td>
                        <td>{{ $guia['codigoguia'] }}</td>
                        <td>{{ $guia['fechaemision'] }}</td>
                        <td>{{ $guia['horaemision'] }}</td>
                        <td class="text-start">{{ $guia['razonsocialguia'] }}</td>
                        <td>{{ $guia['numerotrasladotim'] }}</td>
                        <td>{{ $guia['motivotraslado'] }}</td>
                        <td>{{ $guia['pesobrutototal'] }}</td>
                        <td>{{ $guia['volumenproducto'] }}</td>
                        <td>{{ $guia['numerobultopallet'] }}</td>
                        <td class="text-start text-wrap" style="max-width: 200px;">{{ $guia['observaciones'] }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('vistadetalleguia', ["idguia" => $guia['idguia']])}}" class="btn btn-sm btn-outline-info" title="Ver Detalle">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                                <!-- Botón Editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning btn-editarguia" title="Editar">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <!-- Botón Eliminar -->
                                <button type="button" class="btn btn-sm btn-outline-danger btn-eliminarguia"
                                        data-id="{{ $guia['idguia'] }}" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                @if($guia['estado'] !== 'Confirmado')
                                    <a href="{{ route('vistarevisionguias', ["idguia" => $guia['idguia']])}}"
                                       class="btn btn-sm btn-outline-info" title="conteo">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted py-4">
                            No se encontraron guías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
