<div class="table-container-sticky">
    <div class="table-responsive">
        <table class="table table-hover align-middle" data-sortable>
            <thead class="table-dark sticky-top">
            <tr>
                <th class="text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th data-sortable="codigoproducto" style="cursor: pointer;" class="text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-barcode me-2"></i>
                        Código
                        @if ($sortField === 'codigoproducto')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                        @endif
                    </div>
                </th>
                <th data-sortable="nombre" style="cursor: pointer;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tag me-2"></i>
                        Nombre del Producto
                        @if ($sortField === 'nombre')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                        @endif
                    </div>
                </th>
                <th class="text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-cog me-2"></i>
                        Tipo Código
                    </div>
                </th>
                <th data-sortable="tipoinventario" style="cursor: pointer;" class="text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-warehouse me-2"></i>
                        Inventario
                        @if ($sortField === 'tipoinventario')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                        @endif
                    </div>
                </th>
                <th class="text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Estado
                    </div>
                </th>
                <th data-sortable="fecharegistro" style="cursor: pointer;" class="text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar me-2"></i>
                        Fecha Registro
                        @if ($sortField === 'fecharegistro')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                        @endif
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
            @forelse($data as $producto)
                <tr class="border-bottom" data-id="{{ $producto->idproducto }}" data-searchable>
                    <td class="text-center">
                        <div class="form-check">
                            <input class="form-check-input row-checkbox" type="checkbox">
                        </div>
                    </td>
                    <td class="text-center" data-field="codigo">
                        <span class="badge bg-secondary fs-6 user-select-all" 
                              onclick="copyToClipboard('{{ $producto->codigoproducto }}')"
                              data-bs-toggle="tooltip" title="Clic para copiar">
                            {{ $producto->codigoproducto }}
                        </span>
                    </td>
                    <td data-field="nombre">
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
                    <td class="text-center" data-field="tipocodigo">
                        <span class="badge bg-info bg-opacity-10 text-info">{{ $producto->tipocodproducto }}</span>
                    </td>
                    <td class="text-center" data-field="tipo">
                        <span class="badge bg-{{ $producto->tipoinventario === 'Tottus' ? 'primary' : 'success' }}">
                            {{ $producto->tipoinventario }}
                        </span>
                    </td>
                    <td class="text-center" data-field="estado">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ $producto->estado }}
                        </span>
                    </td>
                    <td class="text-center" data-field="fecha">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($producto->fecharegistro)->format('d/m/Y') }}
                        </small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-outline-info btn-sm"
                                    title="Ver detalles" data-bs-toggle="tooltip"
                                    onclick="showProductDetails({{ $producto->idproducto }})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm btn-editarproducto"
                                    title="Editar producto" data-bs-toggle="tooltip"
                                    data-id="{{ $producto->idproducto }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminarproducto"
                                    data-id="{{ $producto->idproducto }}"
                                    title="Eliminar producto" data-bs-toggle="tooltip"
                                    data-confirm="¿Está seguro de eliminar este producto?">
                                <i class="fas fa-trash"></i>
                            </button>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" 
                                        data-bs-toggle="dropdown" title="Más opciones">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="duplicateProduct({{ $producto->idproducto }})">
                                        <i class="fas fa-copy me-2"></i>Duplicar
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="exportProduct({{ $producto->idproducto }})">
                                        <i class="fas fa-download me-2"></i>Exportar
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-warning" href="#" onclick="archiveProduct({{ $producto->idproducto }})">
                                        <i class="fas fa-archive me-2"></i>Archivar
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">
                                @if ($search)
                                    No se encontraron productos para "{{ $search }}"
                                @else
                                    No hay productos registrados
                                @endif
                            </h5>
                            @if (!$search)
                                <p class="text-muted">Comience agregando su primer producto</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#idmodalProductos">
                                    <i class="fas fa-plus me-1"></i>Agregar Producto
                                </button>
                            @else
                                <button class="btn btn-outline-secondary" onclick="clearSearch()">
                                    <i class="fas fa-times me-1"></i>Limpiar búsqueda
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación mejorada -->
    @if($data->total() > 0)
        <div class="sticky-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center px-4 py-3">
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando <strong>{{ $data->firstItem() }}</strong> a <strong>{{ $data->lastItem() }}</strong> 
                    de <strong>{{ $data->total() }}</strong> productos
                    @if($search)
                        <span class="badge bg-info ms-2">Filtrado por: "{{ $search }}"</span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" onclick="previousPage()" 
                                {{ $data->onFirstPage() ? 'disabled' : '' }}>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="nextPage()"
                                {{ !$data->hasMorePages() ? 'disabled' : '' }}>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Funciones específicas para productos
    function showProductDetails(id) {
        showInfo(`Cargando detalles del producto ${id}...`);
        // Aquí implementarías la lógica para mostrar detalles
    }

    function duplicateProduct(id) {
        showInfo(`Duplicando producto ${id}...`);
        // Implementar lógica de duplicación
    }

    function exportProduct(id) {
        showInfo(`Exportando producto ${id}...`);
        // Implementar lógica de exportación
    }

    function archiveProduct(id) {
        Swal.fire({
            title: '¿Archivar producto?',
            text: 'El producto se moverá al archivo pero no se eliminará',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, archivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                showSuccess('Producto archivado correctamente');
            }
        });
    }

    function clearSearch() {
        const searchInput = document.querySelector('[data-filter="search"]');
        if (searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
    }

    function previousPage() {
        // Implementar navegación de página anterior
        showInfo('Cargando página anterior...');
    }

    function nextPage() {
        // Implementar navegación de página siguiente
        showInfo('Cargando página siguiente...');
    }

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