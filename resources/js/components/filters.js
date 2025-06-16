// Funcionalidad para filtros avanzados
export class FilterManager {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.filters = {};
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadSavedFilters();
    }

    setupEventListeners() {
        // Filtro de búsqueda en tiempo real
        const searchInput = this.container?.querySelector('[data-filter="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce((e) => {
                this.applyFilter('search', e.target.value);
            }, 300));
        }

        // Filtros de select
        const selectFilters = this.container?.querySelectorAll('select[data-filter]');
        selectFilters?.forEach(select => {
            select.addEventListener('change', (e) => {
                this.applyFilter(e.target.dataset.filter, e.target.value);
            });
        });

        // Filtros de fecha
        const dateFilters = this.container?.querySelectorAll('input[type="date"][data-filter]');
        dateFilters?.forEach(input => {
            input.addEventListener('change', (e) => {
                this.applyFilter(e.target.dataset.filter, e.target.value);
            });
        });

        // Botón limpiar filtros
        const clearBtn = this.container?.querySelector('[data-action="clear-filters"]');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => this.clearAllFilters());
        }

        // Botón aplicar filtros
        const applyBtn = this.container?.querySelector('[data-action="apply-filters"]');
        if (applyBtn) {
            applyBtn.addEventListener('click', () => this.applyAllFilters());
        }
    }

    applyFilter(filterName, value) {
        this.filters[filterName] = value;
        this.saveFilters();
        this.filterTable();
    }

    filterTable() {
        const table = document.querySelector('table tbody');
        if (!table) return;

        const rows = Array.from(table.querySelectorAll('tr'));
        
        rows.forEach(row => {
            let shouldShow = true;

            // Aplicar cada filtro
            Object.entries(this.filters).forEach(([filterName, filterValue]) => {
                if (!filterValue) return;

                switch (filterName) {
                    case 'search':
                        const searchText = row.textContent.toLowerCase();
                        if (!searchText.includes(filterValue.toLowerCase())) {
                            shouldShow = false;
                        }
                        break;
                    
                    case 'estado':
                        const estadoCell = row.querySelector('[data-field="estado"]');
                        if (estadoCell && estadoCell.textContent.trim() !== filterValue) {
                            shouldShow = false;
                        }
                        break;
                    
                    case 'tipo':
                        const tipoCell = row.querySelector('[data-field="tipo"]');
                        if (tipoCell && tipoCell.textContent.trim() !== filterValue) {
                            shouldShow = false;
                        }
                        break;
                    
                    case 'fechaDesde':
                        const fechaCell = row.querySelector('[data-field="fecha"]');
                        if (fechaCell) {
                            const rowDate = new Date(fechaCell.textContent);
                            const filterDate = new Date(filterValue);
                            if (rowDate < filterDate) {
                                shouldShow = false;
                            }
                        }
                        break;
                    
                    case 'fechaHasta':
                        const fechaHastaCell = row.querySelector('[data-field="fecha"]');
                        if (fechaHastaCell) {
                            const rowDate = new Date(fechaHastaCell.textContent);
                            const filterDate = new Date(filterValue);
                            if (rowDate > filterDate) {
                                shouldShow = false;
                            }
                        }
                        break;
                }
            });

            row.style.display = shouldShow ? '' : 'none';
        });

        this.updateResultsCount();
    }

    updateResultsCount() {
        const table = document.querySelector('table tbody');
        if (!table) return;

        const visibleRows = table.querySelectorAll('tr:not([style*="display: none"])').length;
        const totalRows = table.querySelectorAll('tr').length;
        
        const countElement = document.querySelector('[data-results-count]');
        if (countElement) {
            countElement.textContent = `Mostrando ${visibleRows} de ${totalRows} registros`;
        }
    }

    clearAllFilters() {
        this.filters = {};
        
        // Limpiar inputs
        const inputs = this.container?.querySelectorAll('input, select');
        inputs?.forEach(input => {
            if (input.type === 'search' || input.type === 'text') {
                input.value = '';
            } else if (input.type === 'date') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });

        this.saveFilters();
        this.filterTable();
    }

    applyAllFilters() {
        this.filterTable();
        
        // Mostrar notificación
        this.showNotification('Filtros aplicados correctamente', 'success');
    }

    saveFilters() {
        localStorage.setItem(`filters_${window.location.pathname}`, JSON.stringify(this.filters));
    }

    loadSavedFilters() {
        const saved = localStorage.getItem(`filters_${window.location.pathname}`);
        if (saved) {
            this.filters = JSON.parse(saved);
            
            // Aplicar filtros guardados a los inputs
            Object.entries(this.filters).forEach(([filterName, value]) => {
                const input = this.container?.querySelector(`[data-filter="${filterName}"]`);
                if (input && value) {
                    input.value = value;
                }
            });
            
            this.filterTable();
        }
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

// Inicializar filtros cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar filtros para cada página
    if (document.querySelector('[data-filter-container]')) {
        new FilterManager('filter-container');
    }
});