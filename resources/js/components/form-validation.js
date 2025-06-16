// Validación avanzada de formularios
export class FormValidation {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        this.rules = {};
        this.init();
    }

    init() {
        if (!this.form) return;
        
        this.setupValidation();
        this.setupRealTimeValidation();
        this.setupCustomValidators();
    }

    setupValidation() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.form.classList.add('was-validated');
        });
    }

    setupRealTimeValidation() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Validación en tiempo real
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                if (input.classList.contains('is-invalid')) {
                    this.validateField(input);
                }
            });
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name || field.id;
        let isValid = true;
        let errorMessage = '';

        // Validaciones básicas
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Este campo es obligatorio';
        }

        // Validaciones por tipo
        if (isValid && value) {
            switch (field.type) {
                case 'email':
                    if (!this.isValidEmail(value)) {
                        isValid = false;
                        errorMessage = 'Ingrese un email válido';
                    }
                    break;
                
                case 'tel':
                    if (!this.isValidPhone(value)) {
                        isValid = false;
                        errorMessage = 'Ingrese un teléfono válido';
                    }
                    break;
                
                case 'number':
                    const min = field.getAttribute('min');
                    const max = field.getAttribute('max');
                    const numValue = parseFloat(value);
                    
                    if (isNaN(numValue)) {
                        isValid = false;
                        errorMessage = 'Ingrese un número válido';
                    } else if (min && numValue < parseFloat(min)) {
                        isValid = false;
                        errorMessage = `El valor mínimo es ${min}`;
                    } else if (max && numValue > parseFloat(max)) {
                        isValid = false;
                        errorMessage = `El valor máximo es ${max}`;
                    }
                    break;
            }
        }

        // Validaciones personalizadas
        if (isValid && this.rules[fieldName]) {
            const customValidation = this.rules[fieldName](value, field);
            if (!customValidation.isValid) {
                isValid = false;
                errorMessage = customValidation.message;
            }
        }

        // Aplicar estilos de validación
        this.applyValidationStyles(field, isValid, errorMessage);
        
        return isValid;
    }

    validateForm() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        return isFormValid;
    }

    applyValidationStyles(field, isValid, errorMessage) {
        // Limpiar clases previas
        field.classList.remove('is-valid', 'is-invalid');
        
        // Remover mensajes de error previos
        const existingFeedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');
        if (existingFeedback) {
            existingFeedback.remove();
        }
        
        // Aplicar nueva validación
        if (isValid) {
            field.classList.add('is-valid');
            
            const feedback = document.createElement('div');
            feedback.className = 'valid-feedback';
            feedback.textContent = '¡Correcto!';
            field.parentNode.appendChild(feedback);
        } else {
            field.classList.add('is-invalid');
            
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = errorMessage;
            field.parentNode.appendChild(feedback);
        }
    }

    setupCustomValidators() {
        // Validador para DNI
        this.addRule('dni', (value) => {
            if (!/^\d{8}$/.test(value)) {
                return { isValid: false, message: 'El DNI debe tener 8 dígitos' };
            }
            return { isValid: true };
        });

        // Validador para RUC
        this.addRule('ruc', (value) => {
            if (!/^\d{11}$/.test(value)) {
                return { isValid: false, message: 'El RUC debe tener 11 dígitos' };
            }
            return { isValid: true };
        });

        // Validador para placa de vehículo
        this.addRule('placa', (value) => {
            if (!/^[A-Z0-9]{6,8}$/.test(value.toUpperCase())) {
                return { isValid: false, message: 'Formato de placa inválido' };
            }
            return { isValid: true };
        });

        // Validador para código de producto
        this.addRule('codigoproducto', (value) => {
            if (!/^\d{6,20}$/.test(value)) {
                return { isValid: false, message: 'El código debe tener entre 6 y 20 dígitos' };
            }
            return { isValid: true };
        });

        // Validador para contraseña segura
        this.addRule('password', (value) => {
            if (value.length < 6) {
                return { isValid: false, message: 'La contraseña debe tener al menos 6 caracteres' };
            }
            if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) {
                return { isValid: false, message: 'Debe contener mayúsculas, minúsculas y números' };
            }
            return { isValid: true };
        });
    }

    addRule(fieldName, validator) {
        this.rules[fieldName] = validator;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        return phoneRegex.test(phone.replace(/\s/g, ''));
    }

    // Método para mostrar errores del servidor
    showServerErrors(errors) {
        Object.entries(errors).forEach(([fieldName, messages]) => {
            const field = this.form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                this.applyValidationStyles(field, false, messages[0]);
            }
        });
    }

    // Método para limpiar validaciones
    clearValidation() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
        
        const feedbacks = this.form.querySelectorAll('.invalid-feedback, .valid-feedback');
        feedbacks.forEach(feedback => feedback.remove());
        
        this.form.classList.remove('was-validated');
    }
}

// Auto-inicializar validación en formularios
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        new FormValidation(`#${form.id}`);
    });
});