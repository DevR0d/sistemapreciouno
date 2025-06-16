// Sistema de notificaciones
export class NotificationSystem {
    constructor() {
        this.container = this.createContainer();
        this.notifications = [];
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadPersistentNotifications();
    }

    createContainer() {
        const container = document.createElement('div');
        container.id = 'notification-container';
        container.className = 'position-fixed';
        container.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        `;
        document.body.appendChild(container);
        return container;
    }

    show(message, type = 'info', options = {}) {
        const notification = this.createNotification(message, type, options);
        this.container.appendChild(notification);
        this.notifications.push(notification);

        // Animación de entrada
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        // Auto-dismiss
        if (options.autoDismiss !== false) {
            const timeout = options.timeout || this.getTimeoutByType(type);
            setTimeout(() => {
                this.dismiss(notification);
            }, timeout);
        }

        // Limitar número de notificaciones
        if (this.notifications.length > 5) {
            this.dismiss(this.notifications[0]);
        }

        return notification;
    }

    createNotification(message, type, options) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade mb-2 notification-item`;
        notification.style.cssText = `
            transition: all 0.3s ease;
            transform: translateX(100%);
            opacity: 0;
        `;

        const icon = this.getIconByType(type);
        const title = options.title ? `<strong>${options.title}</strong><br>` : '';
        
        notification.innerHTML = `
            <div class="d-flex align-items-start">
                <i class="fas fa-${icon} me-2 mt-1"></i>
                <div class="flex-grow-1">
                    ${title}${message}
                </div>
                <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="alert"></button>
            </div>
            ${options.actions ? this.createActions(options.actions) : ''}
        `;

        // Event listener para cerrar
        notification.querySelector('.btn-close').addEventListener('click', () => {
            this.dismiss(notification);
        });

        // Agregar clase show para animación
        notification.classList.add('show');
        notification.style.transform = 'translateX(0)';
        notification.style.opacity = '1';

        return notification;
    }

    createActions(actions) {
        const actionsHtml = actions.map(action => `
            <button class="btn btn-sm btn-outline-light me-2" data-action="${action.id}">
                ${action.label}
            </button>
        `).join('');

        return `<div class="mt-2">${actionsHtml}</div>`;
    }

    dismiss(notification) {
        if (!notification || !notification.parentNode) return;

        notification.style.transform = 'translateX(100%)';
        notification.style.opacity = '0';

        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            this.notifications = this.notifications.filter(n => n !== notification);
        }, 300);
    }

    getIconByType(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle',
            primary: 'bell',
            secondary: 'cog'
        };
        return icons[type] || 'info-circle';
    }

    getTimeoutByType(type) {
        const timeouts = {
            success: 4000,
            error: 8000,
            warning: 6000,
            info: 5000,
            primary: 5000,
            secondary: 5000
        };
        return timeouts[type] || 5000;
    }

    setupEventListeners() {
        // Escuchar eventos personalizados
        document.addEventListener('notification:show', (e) => {
            this.show(e.detail.message, e.detail.type, e.detail.options);
        });

        // Escuchar clics en acciones
        this.container.addEventListener('click', (e) => {
            if (e.target.matches('[data-action]')) {
                const action = e.target.dataset.action;
                const notification = e.target.closest('.notification-item');
                
                // Emitir evento personalizado
                document.dispatchEvent(new CustomEvent('notification:action', {
                    detail: { action, notification }
                }));
            }
        });
    }

    loadPersistentNotifications() {
        // Cargar notificaciones persistentes del localStorage
        const saved = localStorage.getItem('persistent_notifications');
        if (saved) {
            const notifications = JSON.parse(saved);
            notifications.forEach(notif => {
                this.show(notif.message, notif.type, { ...notif.options, autoDismiss: false });
            });
        }
    }

    // Métodos de conveniencia
    success(message, options = {}) {
        return this.show(message, 'success', options);
    }

    error(message, options = {}) {
        return this.show(message, 'error', options);
    }

    warning(message, options = {}) {
        return this.show(message, 'warning', options);
    }

    info(message, options = {}) {
        return this.show(message, 'info', options);
    }

    // Notificaciones especiales para el sistema logístico
    guiaCreated(codigoGuia) {
        return this.success(`Guía ${codigoGuia} creada exitosamente`, {
            title: 'Guía Creada',
            actions: [
                { id: 'view', label: 'Ver Detalle' },
                { id: 'print', label: 'Imprimir' }
            ]
        });
    }

    productAdded(nombreProducto) {
        return this.info(`Producto "${nombreProducto}" agregado al carrito`, {
            timeout: 3000
        });
    }

    validationError(field, message) {
        return this.error(`Error en ${field}: ${message}`, {
            title: 'Error de Validación',
            timeout: 6000
        });
    }

    systemUpdate(message) {
        return this.show(message, 'primary', {
            title: 'Actualización del Sistema',
            autoDismiss: false,
            actions: [
                { id: 'refresh', label: 'Actualizar Página' }
            ]
        });
    }
}

// Crear instancia global
window.notifications = new NotificationSystem();

// Funciones globales de conveniencia
window.showNotification = (message, type, options) => {
    return window.notifications.show(message, type, options);
};

window.showSuccess = (message, options) => {
    return window.notifications.success(message, options);
};

window.showError = (message, options) => {
    return window.notifications.error(message, options);
};

window.showWarning = (message, options) => {
    return window.notifications.warning(message, options);
};

window.showInfo = (message, options) => {
    return window.notifications.info(message, options);
};