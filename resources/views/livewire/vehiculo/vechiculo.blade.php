<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
        <tr>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-hashtag me-2"></i>
                    ID
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-id-card me-2"></i>
                    Placa Principal
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-id-card-alt me-2"></i>
                    Placa Secundaria
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Estado
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-tools me-2"></i>
                    Acciones
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
            @forelse($vehiculos as $vehiculo)
                <tr wire:key="vehiculo-{{ $vehiculo['idvehiculo'] }}-{{ now()->timestamp }}" class="border-bottom">
                    <td class="text-center">
                        <span class="badge bg-primary fs-6">{{ $vehiculo['idvehiculo'] }}</span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                <i class="fas fa-truck text-success"></i>
                            </div>
                            <span class="fw-bold text-uppercase">{{ $vehiculo['placa'] }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase">
                            {{ $vehiculo['placasecundaria'] }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Activo
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-outline-warning btn-sm btn-editarvehiculo"
                                    title="Editar vehículo" data-bs-toggle="tooltip">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminarvehiculo"
                                    data-id="{{ $vehiculo['idvehiculo'] }}"
                                    title="Eliminar vehículo" data-bs-toggle="tooltip">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay vehículos registrados</h5>
                            <p class="text-muted">Comience agregando su primer vehículo</p>
                            <button class="btn btn-primary" id="btnnuevovehiculo">
                                <i class="fas fa-plus me-1"></i>Agregar Vehículo
                            </button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Animación de hover en filas
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'transform 0.2s ease';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>

<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .table tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .action-buttons .btn {
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-1px);
    }
</style>
@endpush
