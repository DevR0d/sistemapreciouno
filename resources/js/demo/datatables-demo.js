document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('dataTable');
    if (table && window.DataTable) {
        new DataTable(table);
    }
});
