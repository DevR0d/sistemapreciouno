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
{{--    <link rel="icon" type="image/png" href="{{ asset('storage/imgsistema/logo.png') }}">--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @vite([
        'resources/css/demo/styles.css',
        'resources/css/views/layout.css',
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
        'resources/js/app.js'
    ])
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow-sm navbar-nav-scroll">
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
                                <!-- Barra de búsqueda -->
                                <div class="col-md-6 d-flex justify-content-end align-items-center gap-3 mt-3 mt-md-0">
                                    @if(!View::hasSection('hideSearchBar'))
                                        <div class="input-group shadow-sm" style="max-width: 300px;">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text"
                                                   id="filtroTabla"
                                                   class="form-control border-start-0"
                                                   placeholder="Buscar...">
                                        </div>
                                    @endif

                                    <div>
                                        @yield('header-actions') {{-- Botón Nueva Guía --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{--        @elseif(!View::hasSection('hidePageHeaders'))--}}
{{--            <div class="page-header">--}}
{{--                <div class="container-fluid">--}}
{{--                    <div class="row align-items-center justify-content-between">--}}
{{--                        <div class="col-md-3 text-center">--}}
{{--                            <div class="mb-3">--}}
{{--                                <i class="fas fa-truck fa-3x mb-2"></i>--}}
{{--                                <h4 class="mb-0">PRECIO UNO</h4>--}}
{{--                                <small>Sistema Logístico</small>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-5 text-center">--}}
{{--                            <h2 class="mb-2">GUÍA DE REMISIÓN ELECTRÓNICA</h2>--}}
{{--                            <p class="mb-0">Documento Tributario Electrónico</p>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-2 text-center">--}}
{{--                            <div class="border border-light rounded p-2">--}}
{{--                                <h4 class="mb-1" style="font-size: 1.5rem;">{{ $guia->codigoguia ?? 'N/A' }}</h4>--}}
{{--                                <small>N° de Guía</small>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-2 text-end mt-3 mt-md-0">--}}
{{--                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 mb-2 w-100"--}}
{{--                                    onclick="window.location.href='/guiasremision'">--}}
{{--                                <i class="fas fa-chevron-left me-1"></i> Volver al listado--}}
{{--                            </button>--}}
{{--                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 mb-2 w-100"--}}
{{--                                    onclick="window.open('{{ route('guias.pdf', ['id' => $guia->idguia]) }}', '_blank')">--}}
{{--                                <i class="fas fa-file-pdf me-1"></i> Imprimir Guia en PDF--}}
{{--                            </button>--}}
{{--                            <button type="button" class="btn btn-outline-primary btn-sm"--}}
{{--                                    onclick="window.open('{{ route('validacion.pdf', ['id' => $guia->idguia]) }}', '_blank')">--}}
{{--                                <i class="fas fa-file-pdf me-1"></i> EXPORTAR PDF--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
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
