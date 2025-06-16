<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Sistema Logístico Precio Uno</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/imgsistema/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/views/login/login.css', 'resources/js/applogin.js'])
    <style>
        #loadingProgress.loading {
            width: 100%;
        }

        :root {
            --primary-color: #c8102e;
            --primary-dark: #a10b25;
            --gradient-primary: linear-gradient(135deg, #c8102e 0%, #a10b25 100%);
        }

        body {
            background: var(--gradient-primary);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            min-height: 500px;
        }

        .login-left {
            flex: 1;
            background: var(--gradient-primary);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .login-right {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .brand-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(200, 16, 46, 0.25);
        }

        .btn-login {
            background: var(--gradient-primary);
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(200, 16, 46, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .loading-spinner {
            display: none;
        }

        .loading .loading-spinner {
            display: inline-block;
        }

        .loading .btn-text {
            display: none;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                margin: 1rem;
            }

            .login-left {
                padding: 2rem;
                min-height: 200px;
            }

            .brand-logo {
                font-size: 2rem;
            }

            .login-right {
                padding: 2rem;
            }
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .form-control.with-icon {
            border-left: none;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.5rem;
        }
    </style>
</head>
<div id="loadingBar" style="display:none; height:4px; width:100%; position:fixed; top:0; left:0; z-index:9999;">
    <div style="height:100%; width:0; background:linear-gradient(90deg, #c8102e, #a10b25); transition: width 0.5s;"
        id="loadingProgress"></div>
</div>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Lado izquierdo - Branding -->
            <div class="login-left">
                <div class="brand-logo">
                    <i class="fas fa-truck-moving me-3"></i>
                    PRECIO UNO
                </div>
                <div class="brand-subtitle">
                    Sistema de Gestión Logística
                </div>
                <div class="mt-4">
                    <i class="fas fa-shield-alt fa-2x mb-3 opacity-75"></i>
                    <p class="mb-0 opacity-75">Seguro • Confiable • Eficiente</p>
                </div>
            </div>

            <!-- Lado derecho - Formulario -->
            <div class="login-right">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark mb-2">¡Bienvenido de vuelta!</h2>
                    <p class="text-muted">Ingresa tus credenciales para acceder al sistema</p>
                </div>

                <!-- Mensajes de error -->
                <div id="errorAlert" class="alert alert-danger d-none" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="errorMessage"></span>
                </div>

                <form id="formulariologin" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="username"
                            placeholder="correo@ejemplo.com" required autocomplete="username">
                        <label for="username">
                            <i class="fas fa-envelope me-2"></i>Correo electrónico
                        </label>
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Contraseña" required autocomplete="current-password">
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                    </div>

                    <!-- Remember me y forgot password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-muted" for="rememberMe">
                                Recordarme
                            </label>
                        </div>
                        <a href="#!" class="forgot-password">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <!-- Submit button -->
                    <button id="btnlogin" class="btn btn-login w-100 text-white" type="submit">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Iniciar Sesión
                        </span>
                        <span class="loading-spinner d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Verificando...
                        </span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        <i class="fas fa-copyright me-1"></i>
                        2025 Precio Uno. Todos los derechos reservados.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mejorar la experiencia del formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formulariologin');
            const submitBtn = document.getElementById('btnlogin');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');

            // Función para mostrar errores
            function showError(message) {
                errorMessage.textContent = message;
                errorAlert.classList.remove('d-none');
                setTimeout(() => {
                    errorAlert.classList.add('d-none');
                }, 5000);
            }

            // Función para mostrar estado de carga
            function setLoading(loading) {
                if (loading) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                } else {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }
            }

            // Validación en tiempo real
            const inputs = form.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // Ocultar alerta de error al escribir
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    errorAlert.classList.add('d-none');
                });
            });
        });
    </script>
</body>

</html>
