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
                    <i class="fas fa-user me-2"></i>
                    Conductor
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-id-card me-2"></i>
                    DNI
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-building me-2"></i>
                    Empresa
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-truck me-2"></i>
                    Vehículo
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
            @forelse($data as $conductor)
                <tr class="border-bottom">
                    <td class="text-center">
                        <span class="badge bg-primary fs-6">{{ $conductor['idconductor'] }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $conductor['nombre'] ?? 'Sin nombre' }}</h6>
                                <small class="text-muted">ID: {{ $conductor['idconductor'] }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-info bg-opacity-10 text-info">{{ $conductor['dni'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-secondary">ID: {{ $conductor['idtransportista'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">ID: {{ $conductor['idvehiculo'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-{{ $conductor['estado'] === 'Activo' ? 'success' : 'warning' }}">
                            <i class="fas fa-{{ $conductor['estado'] === 'Activo' ? 'check-circle' : 'clock' }} me-1"></i>
                            {{ $conductor['estado'] }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-outline-warning btn-sm btn-editarconductor"
                                    title="Editar conductor" data-bs-toggle="tooltip">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminarconductor"
                                    title="Eliminar conductor" data-bs-toggle="tooltip">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm"
                                    title="Ver perfil" data-bs-toggle="tooltip">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay conductores registrados</h5>
                            <p class="text-muted">Comience agregando su primer conductor</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#idmodalConductoress">
                                <i class="fas fa-plus me-1"></i>Agregar Conductor
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
