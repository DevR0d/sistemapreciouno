// Funcionalidad para gráficos del dashboard
export class DashboardCharts {
    constructor() {
        this.charts = {};
        this.init();
    }

    init() {
        this.initializeCharts();
        this.setupRealTimeUpdates();
        this.setupChartInteractions();
    }

    initializeCharts() {
        // Gráfico de área para guías emitidas
        this.createAreaChart();
        
        // Gráfico de barras para discrepancias
        this.createBarChart();
        
        // Gráfico circular para estados
        this.createPieChart();
        
        // Gráfico de líneas para tendencias
        this.createLineChart();
    }

    createAreaChart() {
        const ctx = document.getElementById('areaChart');
        if (!ctx) return;

        this.charts.area = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.getLastDays(7),
                datasets: [{
                    label: 'Guías Emitidas',
                    data: this.generateRandomData(7, 10, 50),
                    fill: true,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: true,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }

    createBarChart() {
        const ctx = document.getElementById('barChart');
        if (!ctx) return;

        this.charts.bar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Productos', 'Vehículos', 'Conductores', 'Guías'],
                datasets: [{
                    label: 'Cantidad',
                    data: [120, 45, 67, 89],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    createPieChart() {
        const ctx = document.getElementById('pieChart');
        if (!ctx) return;

        this.charts.pie = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Sin Daño', 'Con Daño', 'En Proceso'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return `${context.label}: ${percentage}%`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    createLineChart() {
        const ctx = document.getElementById('lineChart');
        if (!ctx) return;

        this.charts.line = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.getLastMonths(6),
                datasets: [
                    {
                        label: 'Guías Sin Discrepancias',
                        data: this.generateRandomData(6, 50, 100),
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        pointRadius: 5
                    },
                    {
                        label: 'Guías Con Discrepancias',
                        data: this.generateRandomData(6, 10, 30),
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        pointRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    setupRealTimeUpdates() {
        // Actualizar datos cada 30 segundos
        setInterval(() => {
            this.updateChartData();
        }, 30000);
    }

    updateChartData() {
        Object.values(this.charts).forEach(chart => {
            if (chart.data.datasets) {
                chart.data.datasets.forEach(dataset => {
                    dataset.data = dataset.data.map(() => 
                        Math.floor(Math.random() * 100) + 10
                    );
                });
                chart.update('none');
            }
        });
    }

    setupChartInteractions() {
        // Agregar controles de zoom y pan si están disponibles
        Object.values(this.charts).forEach(chart => {
            chart.canvas.addEventListener('click', (e) => {
                const points = chart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
                if (points.length) {
                    const firstPoint = points[0];
                    const label = chart.data.labels[firstPoint.index];
                    const value = chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                    
                    this.showChartTooltip(label, value, e.pageX, e.pageY);
                }
            });
        });
    }

    showChartTooltip(label, value, x, y) {
        // Crear tooltip personalizado
        const tooltip = document.createElement('div');
        tooltip.className = 'chart-tooltip';
        tooltip.style.cssText = `
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            z-index: 1000;
            left: ${x + 10}px;
            top: ${y - 10}px;
        `;
        tooltip.textContent = `${label}: ${value}`;
        
        document.body.appendChild(tooltip);
        
        setTimeout(() => {
            tooltip.remove();
        }, 2000);
    }

    getLastDays(count) {
        const days = [];
        for (let i = count - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            days.push(date.toLocaleDateString('es-ES', { month: 'short', day: 'numeric' }));
        }
        return days;
    }

    getLastMonths(count) {
        const months = [];
        for (let i = count - 1; i >= 0; i--) {
            const date = new Date();
            date.setMonth(date.getMonth() - i);
            months.push(date.toLocaleDateString('es-ES', { month: 'short', year: 'numeric' }));
        }
        return months;
    }

    generateRandomData(count, min, max) {
        return Array.from({ length: count }, () => 
            Math.floor(Math.random() * (max - min + 1)) + min
        );
    }

    // Método para actualizar datos desde el servidor
    updateFromServer(endpoint) {
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                // Actualizar gráficos con datos reales
                this.updateChartsWithServerData(data);
            })
            .catch(error => {
                console.error('Error updating chart data:', error);
            });
    }

    updateChartsWithServerData(data) {
        // Implementar actualización con datos del servidor
        if (data.guiasEmitidas && this.charts.area) {
            this.charts.area.data.datasets[0].data = data.guiasEmitidas;
            this.charts.area.update();
        }
        
        if (data.estadosGuias && this.charts.pie) {
            this.charts.pie.data.datasets[0].data = data.estadosGuias;
            this.charts.pie.update();
        }
    }
}

// Inicializar gráficos del dashboard
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('[data-dashboard-charts]')) {
        new DashboardCharts();
    }
});