import * as XLSX from "xlsx";

import { jsPDF } from "jspdf";
import autoTable from "jspdf-autotable";

// Mejoras para tablas
export class TableEnhancements {
    constructor(tableSelector) {
        this.table = document.querySelector(tableSelector);
        this.init();
    }

    init() {
        if (!this.table) return;

        this.setupSorting();
        this.setupRowSelection();
        this.setupBulkActions();
        this.setupExportFunctionality();
        this.setupColumnToggle();
    }

    setupSorting() {
        const headers = this.table.querySelectorAll('th[data-sortable]');

        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                this.sortTable(header);
            });
        });
    }

    sortTable(header) {
        const column = header.dataset.sortable;
        const currentDirection = header.dataset.sortDirection || 'asc';
        const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

        // Limpiar iconos de ordenamiento previos
        this.table.querySelectorAll('th .sort-icon').forEach(icon => icon.remove());

        // Agregar icono de ordenamiento
        const icon = document.createElement('i');
        icon.className = `fas fa-sort-${newDirection === 'asc' ? 'up' : 'down'} ms-1 sort-icon`;
        header.appendChild(icon);

        header.dataset.sortDirection = newDirection;

        // Ordenar filas
        const tbody = this.table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const aValue = this.getCellValue(a, column);
            const bValue = this.getCellValue(b, column);

            if (newDirection === 'asc') {
                return aValue.localeCompare(bValue, undefined, { numeric: true });
            } else {
                return bValue.localeCompare(aValue, undefined, { numeric: true });
            }
        });

        // Reordenar en el DOM
        rows.forEach(row => tbody.appendChild(row));
    }

    getCellValue(row, column) {
        const cell = row.querySelector(`[data-field="${column}"]`);
        return cell ? cell.textContent.trim() : '';
    }

    setupRowSelection() {
        // Checkbox para seleccionar todas las filas
        const selectAllCheckbox = document.createElement('input');
        selectAllCheckbox.type = 'checkbox';
        selectAllCheckbox.className = 'form-check-input';
        selectAllCheckbox.addEventListener('change', (e) => {
            this.selectAllRows(e.target.checked);
        });

        const firstHeader = this.table.querySelector('th');
        if (firstHeader) {
            const checkboxContainer = document.createElement('div');
            checkboxContainer.className = 'form-check';
            checkboxContainer.appendChild(selectAllCheckbox);
            firstHeader.insertBefore(checkboxContainer, firstHeader.firstChild);
        }

        // Agregar checkboxes a cada fila
        const rows = this.table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'form-check-input row-checkbox';
            checkbox.addEventListener('change', () => {
                this.updateBulkActions();
            });

            const firstCell = row.querySelector('td');
            if (firstCell) {
                const checkboxContainer = document.createElement('div');
                checkboxContainer.className = 'form-check';
                checkboxContainer.appendChild(checkbox);
                firstCell.insertBefore(checkboxContainer, firstCell.firstChild);
            }
        });
    }

    selectAllRows(checked) {
        const checkboxes = this.table.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
        this.updateBulkActions();
    }

    updateBulkActions() {
        const selectedRows = this.table.querySelectorAll('.row-checkbox:checked').length;
        const bulkActionsContainer = document.querySelector('[data-bulk-actions]');

        if (bulkActionsContainer) {
            if (selectedRows > 0) {
                bulkActionsContainer.style.display = 'block';
                bulkActionsContainer.querySelector('[data-selected-count]').textContent = selectedRows;
            } else {
                bulkActionsContainer.style.display = 'none';
            }
        }
    }

    setupBulkActions() {
        // Crear contenedor de acciones masivas si no existe
        if (!document.querySelector('[data-bulk-actions]')) {
            const bulkContainer = document.createElement('div');
            bulkContainer.setAttribute('data-bulk-actions', '');
            bulkContainer.className = 'alert alert-info d-none mb-3';
            bulkContainer.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-check-square me-2"></i>
                        <span data-selected-count>0</span> elementos seleccionados
                    </span>
                    <div>
                        <button class="btn btn-sm btn-outline-danger me-2" data-bulk-action="delete">
                            <i class="fas fa-trash me-1"></i>Eliminar
                        </button>
                        <button class="btn btn-sm btn-outline-primary" data-bulk-action="export">
                            <i class="fas fa-download me-1"></i>Exportar
                        </button>
                    </div>
                </div>
            `;

            this.table.parentNode.insertBefore(bulkContainer, this.table);
        }

        // Event listeners para acciones masivas
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-bulk-action="delete"]')) {
                this.bulkDelete();
            } else if (e.target.matches('[data-bulk-action="export"]')) {
                this.bulkExport();
            }
        });
    }

    async bulkDelete() {
        const selectedCheckboxes = this.table.querySelectorAll('.row-checkbox:checked');
        const selectedIds = Array.from(selectedCheckboxes).map(checkbox => {
            return checkbox.closest('tr').dataset.id;
        });

        if (selectedIds.length === 0) return;

        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: `Se eliminarán ${selectedIds.length} elementos seleccionados`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            // Aquí implementarías la lógica de eliminación masiva
            console.log('Eliminando IDs:', selectedIds);

            Swal.fire({
                title: 'Eliminados',
                text: `${selectedIds.length} elementos eliminados correctamente`,
                icon: 'success',
                timer: 2000
            });
        }
    }

    bulkExport() {
        const selectedCheckboxes = this.table.querySelectorAll('.row-checkbox:checked');
        const selectedRows = Array.from(selectedCheckboxes).map(checkbox => {
            return checkbox.closest('tr');
        });

        if (selectedRows.length === 0) return;

        // Crear CSV con los datos seleccionados
        const headers = Array.from(this.table.querySelectorAll('th')).map(th => th.textContent.trim());
        const csvContent = [
            headers.join(','),
            ...selectedRows.map(row => {
                const cells = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
                return cells.join(',');
            })
        ].join('\n');

        // Descargar archivo
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `export_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    }

    setupExportFunctionality() {
        // Agregar botones de exportación si no existen
        const exportContainer = document.querySelector('[data-export-actions]');
        if (!exportContainer) {
            const container = document.createElement('div');
            container.setAttribute('data-export-actions', '');
            container.className = 'mb-3';
            container.innerHTML = `
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-success btn-sm" data-export="excel">
                        <i class="fas fa-file-excel me-1"></i>Excel
                    </button>
                    <button class="btn btn-outline-danger btn-sm" data-export="pdf">
                        <i class="fas fa-file-pdf me-1"></i>PDF
                    </button>
                    <button class="btn btn-outline-info btn-sm" data-export="csv">
                        <i class="fas fa-file-csv me-1"></i>CSV
                    </button>
                </div>
            `;

            this.table.parentNode.insertBefore(container, this.table);
        }

        // Event listeners para exportación
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-export]')) {
                const format = e.target.dataset.export;
                this.exportTable(format);
            }
        });
    }

    exportTable(format) {
        const rows = Array.from(this.table.querySelectorAll('tr'));
        const data = rows.map(row => {
            return Array.from(row.querySelectorAll('th, td')).map(cell => cell.textContent.trim());
        });

        switch (format) {
            case 'csv':
                this.exportCSV(data);
                break;
            case 'excel':
                this.exportExcel(data);
                break;
            case 'pdf':
                this.exportPDF(data);
                break;
        }
    }

    exportCSV(data) {
        const csvContent = data.map(row => row.join(',')).join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        this.downloadFile(blob, 'export.csv');
    }

    // exportExcel(data) {
    //     // Implementación básica para Excel (requeriría una librería como SheetJS)
    //     console.log('Exportar a Excel:', data);
    //     alert('Funcionalidad de Excel en desarrollo');
    // }

    exportExcel(data) {
        const worksheet = XLSX.utils.aoa_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Datos");

        const excelBuffer = XLSX.write(workbook, { bookType: "xlsx", type: "array" });
        const blob = new Blob([excelBuffer], { type: "application/octet-stream" });
        this.downloadFile(blob, `export_${new Date().toISOString().slice(0, 10)}.xlsx`);
    }

    // exportPDF(data) {
    //     // Implementación básica para PDF (requeriría una librería como jsPDF)
    //     console.log('Exportar a PDF:', data);
    //     alert('Funcionalidad de PDF en desarrollo');
    // }

    exportPDF(data) {
        const doc = new jsPDF();
        const colHeaders = data[0];
        const rows = data.slice(1);

        autoTable(doc, {
            head: [colHeaders],
            body: rows,
            startY: 20,
            styles: { fontSize: 8 },
        });

        doc.save(`export_${new Date().toISOString().slice(0, 10)}.pdf`);
    }

    downloadFile(blob, filename) {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        window.URL.revokeObjectURL(url);
    }

    setupColumnToggle() {
        // Crear dropdown para mostrar/ocultar columnas
        const columnToggle = document.createElement('div');
        columnToggle.className = 'dropdown mb-3';
        columnToggle.innerHTML = `
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-columns me-1"></i>Columnas
            </button>
            <ul class="dropdown-menu" data-column-toggle>
                ${Array.from(this.table.querySelectorAll('th')).map((th, index) => `
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" class="form-check-input me-2" checked data-column="${index}">
                            ${th.textContent.trim()}
                        </label>
                    </li>
                `).join('')}
            </ul>
        `;

        this.table.parentNode.insertBefore(columnToggle, this.table);

        // Event listener para toggle de columnas
        columnToggle.addEventListener('change', (e) => {
            if (e.target.matches('[data-column]')) {
                const columnIndex = parseInt(e.target.dataset.column);
                const isVisible = e.target.checked;
                this.toggleColumn(columnIndex, isVisible);
            }
        });
    }

    toggleColumn(columnIndex, isVisible) {
        const headers = this.table.querySelectorAll('th');
        const rows = this.table.querySelectorAll('tbody tr');

        // Toggle header
        if (headers[columnIndex]) {
            headers[columnIndex].style.display = isVisible ? '' : 'none';
        }

        // Toggle cells
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells[columnIndex]) {
                cells[columnIndex].style.display = isVisible ? '' : 'none';
            }
        });
    }
}

// Inicializar mejoras de tabla
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('table')) {
        new TableEnhancements('table');
    }
});
