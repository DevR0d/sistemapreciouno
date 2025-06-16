<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
        <tr>
            <th wire:click="sortBy('id')" style="cursor: pointer;" class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-hashtag me-2"></i>
                    ID
                    @if ($sortField === 'id')
                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @endif
                </div>
            </th>
            <th wire:click="sortBy('name')" style="cursor: pointer;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user me-2"></i>
                    Nombre
                    @if ($sortField === 'name')
                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @endif
                </div>
            </th>
            <th wire:click="sortBy('email')" style="cursor: pointer;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-envelope me-2"></i>
                    Correo Electrónico
                    @if ($sortField === 'email')
                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @endif
                </div>
            </th>
            <th wire:click="sortBy('idrol')" style="cursor: pointer;" class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-user-tag me-2"></i>
                    Rol
                    @if ($sortField === 'idrol')
                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                    @endif
                </div>
            </th>
            <th class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-calendar me-2"></i>
                    Último Acceso
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
        @forelse($data as $usuario)
            <tr class="border-bottom">
                <td class="text-center">
                    <span class="badge bg-primary fs-6">{{ $usuario->id }}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $usuario->name }}</h6>
                            <small class="text-muted">ID: {{ $usuario->id }}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        <span>{{ $usuario->email }}</span>
                    </div>
                </td>
                <td class="text-center">
                    @php
                        $rolConfig = [
                            1 => ['name' => 'Administrador', 'color' => 'danger', 'icon' => 'user-shield'],
                            2 => ['name' => 'Prevencionista', 'color' => 'success', 'icon' => 'user-check'],
                            3 => ['name' => 'Super Admin', 'color' => 'warning', 'icon' => 'user-crown']
                        ];
                        $config = $rolConfig[$usuario->idrol] ?? ['name' => 'Desconocido', 'color' => 'secondary', 'icon' => 'user'];
                    @endphp
                    <span class="badge bg-{{ $config['color'] }}">
                        <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                        {{ $config['name'] }}
                    </span>
                </td>
                <td class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        {{ $usuario->updated_at ? $usuario->updated_at->diffForHumans() : 'Nunca' }}
                    </small>
                </td>
                <td>
                    <div class="action-buttons">
                        <button type="button" class="btn btn-outline-warning btn-sm btn-editarusuario"
                                title="Editar usuario" data-bs-toggle="tooltip">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-eliminarusuario"
                                data-id="{{ $usuario->id }}" title="Eliminar usuario" data-bs-toggle="tooltip">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm"
                                title="Ver perfil" data-bs-toggle="tooltip">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                title="Resetear contraseña" data-bs-toggle="tooltip">
                            <i class="fas fa-key"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay usuarios registrados</h5>
                        <p class="text-muted">Comience agregando su primer usuario</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#idmodalUsuarios">
                            <i class="fas fa-plus me-1"></i>Agregar Usuario
                        </button>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Paginación mejorada -->
    @if($data->total() > 0)
        <div class="sticky-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center px-4 py-3">
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando <strong>{{ $data->firstItem() }}</strong> a <strong>{{ $data->lastItem() }}</strong>
                    de <strong>{{ $data->total() }}</strong> usuarios
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    @endif
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
