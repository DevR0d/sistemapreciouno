<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title') - Sistema Logístico Precio Uno</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('storage/imgsistema/logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @vite([
        'resources/css/demo/styles.css',
        'resources/css/views/layout.css',
        'resources/js/intranet/usuarios.js',
        'resources/js/intranet/appproducto.js',
        'resources/js/intranet/appvehiculo.js',
        'resources/js/intranet/appconductores.js',
        'resources/js/intranet/appguiasremision.js',
        'resources/js/appglobal.js',
        'resources/js/applogin.js',
        'resources/js/bootstrap.js',
        'resources/js/demo/chart-area-demo.js',
        'resources/js/demo/chart-bar-demo.js',
        'resources/js/demo/datatables-simple-demo.js',
        'resources/js/demo/scripts.js',
    ])
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow-sm">
        <!-- Brand -->
        <a class="navbar-brand ps-3" href="{{ route('vistadashboard') }}">
            <i class="fas fa-truck me-2"></i>
            Sistema Logístico
        </a>

        <!-- Menú principal horizontal -->
        <div class="navbar-nav me-auto ms-md-0">
            @if (session('usuariologeado')["data"][0]['idrol'] == 1)
                <a class="nav-link {{ request()->routeIs('vistadashboard') ? 'active' : '' }}" href="{{ route('vistadashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('vistausuarios') ? 'active' : '' }}" href="{{ route('vistausuarios') }}">
                    <i class="fa-solid fa-user me-2"></i>Usuarios
                </a>
                <a class="nav-link {{ request()->routeIs('vistaconductor') ? 'active' : '' }}" href="{{ route('vistaconductor') }}">
                    <i class="fa-solid fa-id-card me-2"></i>Conductores
                </a>
                <a class="nav-link {{ request()->routeIs('vistavehiculo') ? 'active' : '' }}" href="{{ route('vistavehiculo') }}">
                    <i class="fa-solid fa-truck me-2"></i>Vehículos
                </a>
                <a class="nav-link {{ request()->routeIs('vistaproducto') ? 'active' : '' }}" href="{{ route('vistaproducto') }}">
                    <i class="fa-solid fa-bag-shopping me-2"></i>Productos
                </a>
            @elseif (session('usuariologeado')["data"][0]['idrol'] == 2)
                <a class="nav-link {{ request()->routeIs('vistaguiasderemision') ? 'active' : '' }}" href="{{ route('vistaguiasderemision') }}">
                    <i class="fa-solid fa-table-list me-2"></i>Guías de Remisión
                </a>
            @elseif (session('usuariologeado')["data"][0]['idrol'] == 3)
                <a class="nav-link {{ request()->routeIs('vistadashboard') ? 'active' : '' }}" href="{{ route('vistadashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('vistausuarios') ? 'active' : '' }}" href="{{ route('vistausuarios') }}">
                    <i class="fa-solid fa-user me-2"></i>Usuarios
                </a>
                <a class="nav-link {{ request()->routeIs('vistaconductor') ? 'active' : '' }}" href="{{ route('vistaconductor') }}">
                    <i class="fa-solid fa-id-card me-2"></i>Conductores
                </a>
                <a class="nav-link {{ request()->routeIs('vistavehiculo') ? 'active' : '' }}" href="{{ route('vistavehiculo') }}">
                    <i class="fa-solid fa-truck me-2"></i>Vehículos
                </a>
                <a class="nav-link {{ request()->routeIs('vistaproducto') ? 'active' : '' }}" href="{{ route('vistaproducto') }}">
                    <i class="fa-solid fa-bag-shopping me-2"></i>Productos
                </a>
                <a class="nav-link {{ request()->routeIs('vistaguiasderemision') ? 'active' : '' }}" href="{{ route('vistaguiasderemision') }}">
                    <i class="fa-solid fa-table-list me-2"></i>Guías de Remisión
                </a>
            @endif
        </div>

        <!-- Menú de usuario -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-2">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><h6 class="dropdown-header">Mi Cuenta</h6></li>
                    <li><a class="dropdown-item" href="#!"><i class="fas fa-user-cog me-2"></i>Configuración</a></li>
                    <li><a class="dropdown-item" href="#!"><i class="fas fa-history me-2"></i>Actividad</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item text-danger" href="#!" id="btncerrarsesion"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="container-fluid main-content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('vistadashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>
        <!-- Page Header -->
        @if(!View::hasSection('hidePageHeader'))
            <div class="page-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Título y subtítulo -->
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <div>
                                    <h1 class="page-title">@yield('title')</h1>
                                    <p class="page-subtitle">@yield('subtitle', 'Gestión del sistema logístico')</p>
                                </div>
                                <div class="mt-3 mt-md-0">
                                    @yield('header-actions') <!-- Esto se irá a la derecha -->
                                </div>
                            </div>
                            <!-- Barra de búsqueda -->
                            @if(!View::hasSection('hideSearchBar'))
                                <div class="mt-3">
                                    <div class="input-group search-bar w-100 shadow-sm">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                        <input type="text"
                                               id="filtroTabla"
                                               class="form-control border-start-0"
                                               placeholder="Filtrar por código, razón social o N° de pedido">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

    @livewireScripts
    @stack('scripts')
    @yield('scripts')

    <style>
        .avatar-circle {
            width: 32px;
            height: 32px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }
    </style>
</body>
</html>
