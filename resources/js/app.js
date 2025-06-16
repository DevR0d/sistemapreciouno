import './bootstrap';
import './appglobal.js';
import './demo/scripts.js'
import './intranet/appproducto.js';
import './intranet/appvehiculo.js';
import './intranet/appconductores.js';
import './intranet/appguiasremision.js';
import './demo/datatables-simple-demo.js';
import './demo/chart-area-demo.js';
import './demo/chart-bar-demo.js';
import './demo/chart-pie-demo.js';
import './demo/datatables-demo.js';

// Importar nuevos componentes
import './components/filters.js';
import './components/table-enhancements.js';
import './components/dashboard-charts.js';
import './components/form-validation.js';
import './components/notifications.js';

// Inicialización global
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Inicializar popovers de Bootstrap
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Animaciones de carga para contadores
    const counters = document.querySelectorAll('[data-counter]');
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.counter) || parseInt(counter.textContent);
        let current = 0;
        const increment = target / 50;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 30);
    });

    // Smooth scroll para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-hide alerts después de 5 segundos
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Confirmación para acciones destructivas
    document.addEventListener('click', function(e) {
        if (e.target.matches('[data-confirm]')) {
            e.preventDefault();
            const message = e.target.dataset.confirm || '¿Estás seguro de realizar esta acción?';
            
            if (window.Swal) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ejecutar la acción original
                        if (e.target.href) {
                            window.location.href = e.target.href;
                        } else if (e.target.onclick) {
                            e.target.onclick();
                        }
                    }
                });
            } else {
                if (confirm(message)) {
                    if (e.target.href) {
                        window.location.href = e.target.href;
                    } else if (e.target.onclick) {
                        e.target.onclick();
                    }
                }
            }
        }
    });

    // Loading states para botones
    document.addEventListener('click', function(e) {
        if (e.target.matches('[data-loading]')) {
            const button = e.target;
            const originalText = button.innerHTML;
            const loadingText = button.dataset.loading || 'Cargando...';
            
            button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>${loadingText}`;
            button.disabled = true;
            
            // Restaurar después de 3 segundos (o cuando se complete la acción)
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        }
    });

    // Funcionalidad de búsqueda global
    const globalSearch = document.querySelector('[data-global-search]');
    if (globalSearch) {
        globalSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const searchableElements = document.querySelectorAll('[data-searchable]');
            
            searchableElements.forEach(element => {
                const text = element.textContent.toLowerCase();
                const shouldShow = text.includes(searchTerm);
                element.style.display = shouldShow ? '' : 'none';
            });
        });
    }

    // Funcionalidad de tema oscuro/claro
    const themeToggle = document.querySelector('[data-theme-toggle]');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            const isDark = document.body.classList.contains('dark-theme');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Actualizar icono
            const icon = themeToggle.querySelector('i');
            if (icon) {
                icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }
        });
        
        // Cargar tema guardado
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
            const icon = themeToggle.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-sun';
            }
        }
    }

    // Funcionalidad de pantalla completa
    const fullscreenToggle = document.querySelector('[data-fullscreen-toggle]');
    if (fullscreenToggle) {
        fullscreenToggle.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });
    }

    // Notificación de conexión
    window.addEventListener('online', function() {
        showSuccess('Conexión restaurada', { timeout: 3000 });
    });

    window.addEventListener('offline', function() {
        showWarning('Sin conexión a internet', { timeout: 5000 });
    });

    console.log('🚀 Sistema Logístico Precio Uno - Inicializado correctamente');
});

// Funciones globales útiles
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN'
    }).format(amount);
};

window.formatDate = function(date) {
    return new Intl.DateTimeFormat('es-PE', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
};

window.formatNumber = function(number) {
    return new Intl.NumberFormat('es-PE').format(number);
};

// Función para copiar al portapapeles
window.copyToClipboard = function(text) {
    navigator.clipboard.writeText(text).then(function() {
        showSuccess('Copiado al portapapeles');
    }).catch(function() {
        showError('Error al copiar');
    });
};