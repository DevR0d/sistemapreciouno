<div class="table-container-sticky">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th class="text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th class="text-center">
                    <i class="fas fa-barcode me-2"></i> Código
                </th>
                <th>
                    <i class="fas fa-tag me-2"></i> Nombre del Producto
                </th>
                <th class="text-center">
                    <i class="fas fa-cog me-2"></i> Tipo Código
                </th>
                <th class="text-center">
                    <i class="fas fa-warehouse me-2"></i> Inventario
                </th>
                <th class="text-center">
                    <i class="fas fa-info-circle me-2"></i> Estado
                </th>
                <th class="text-center">
                    <i class="fas fa-calendar me-2"></i> Fecha Registro
                </th>
                <th class="text-center">
                    <i class="fas fa-tools me-2"></i> Acciones
                </th>
            </tr>
        </thead>
        <tbody class="scrollable-tbody">
        @forelse($data as $producto)
            <tr class="border-bottom" data-id="{{ $producto->idproducto }}">
                <td class="text-center">
                    <input class="form-check-input row-checkbox" type="checkbox">
                </td>
                <td class="text-center">
                            <span class="badge bg-secondary fs-6 user-select-all"
                                  onclick="copyToClipboard('{{ $producto->codigoproducto }}')"
                                  data-bs-toggle="tooltip" title="Clic para copiar">
                                {{ $producto->codigoproducto }}
                            </span>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-box text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $producto->nombre }}</h6>
                            <small class="text-muted">ID: {{ $producto->idproducto }}</small>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <span class="badge bg-info bg-opacity-10 text-info">{{ $producto->tipocodproducto }}</span>
                </td>
                <td class="text-center">
                            <span class="badge bg-{{ $producto->tipoinventario === 'Tottus' ? 'primary' : 'success' }}">
                                {{ $producto->tipoinventario }}
                            </span>
                </td>
                <td class="text-center">
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ $producto->estado }}
                            </span>
                </td>
                <td class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($producto->fecharegistro)->format('d/m/Y') }}
                    </small>
                </td>
                <td class="text-center">
                    <div class="action-buttons">
                        {{--  <button type="button" class="btn btn-outline-info btn-sm" title="Ver detalles" onclick="showProductDetails({{ $producto->idproducto }})">
                            <i class="fas fa-eye"></i>
                        </button>  --}}
                        {{--  <button type="button" class="btn btn-outline-warning btn-sm btn-editarproducto" data-id="{{ $producto->idproducto }}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>  --}}
                        <button type="button" class="btn btn-outline-danger btn-sm btn-eliminarproducto" data-id="{{ $producto->idproducto }}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay productos registrados</h5>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Footer de paginación fijo -->
    @if($data->total() > 0)
        <div class="sticky-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center px-4 py-3">
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando <strong>{{ $data->firstItem() }}</strong> a <strong>{{ $data->lastItem() }}</strong>
                    de <strong>{{ $data->total() }}</strong> productos
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

        // Actualizar contador de resultados
        const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])').length;
        const totalRows = document.querySelectorAll('tbody tr').length;
        const countElement = document.querySelector('[data-results-count]');
        if (countElement) {
            countElement.textContent = `${visibleRows} de ${totalRows}`;
        }
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

    .user-select-all {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .user-select-all:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
@endpush
