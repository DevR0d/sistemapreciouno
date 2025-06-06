<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('storage/imgsistema/logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @vite([
        'resources/css/demo/styles.css',
        'resources/css/views/layout.css',
        'resources/js/intranet/appproducto.js',
        'resources/js/intranet/appvehiculo.js',
        'resources/js/intranet/appconductores.js',
        'resources/js/appglobal.js',
        'resources/js/applogin.js',
        'resources/js/bootstrap.js',
        'resources/js/demo/chart-area-demo.js',
        'resources/js/demo/chart-bar-demo.js',
        //'resources/js/demo/chart-pie-demo.js',
        //'resources/js/demo/datatables-demo.js',
        'resources/js/demo/datatables-simple-demo.js' ,
        'resources/js/demo/scripts.js',
    ])
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
{{--    <a class="navbar-brand" href="{{ route('vistadashboard') }}">--}}
{{--        <img src="{{ asset('storage/img/Hiperbodega_Precio_Uno.svg') }}"--}}
{{--             alt="Logo"--}}
{{--             class="img-fluid me-2 d-none d-sm-inline"--}}
{{--             style="max-height: 30px; width: auto;">--}}
{{--    </a>--}}
    <!-- Menú principal horizontal -->
    <div class="navbar-nav me-auto">
        @if (session('usuariologeado')["data"][0]['idrol'] == 1)
            <div>
                <a class="nav-link {{ request()->routeIs('vistadashboard') ? 'active' : '' }}" href="{{ route('vistadashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
            <div>
                <a class="nav-link {{ request()->routeIs('vistausuarios') ? 'active' : '' }}" href="{{ route('vistausuarios') }}">
                    <i class="fa-solid fa-user me-2"></i>Usuarios
                </a>
            </div>
            <div>
                <a class="nav-link {{ request()->routeIs('vistaconductor') ? 'active' : '' }}" href="{{ route('vistaconductor') }}">
                    <i class="fa-solid fa-id-card me-2"></i>Conductores
                </a>
            </div>
            <div>
                <a class="nav-link {{ request()->routeIs('vistavehiculo') ? 'active' : '' }}" href="{{ route('vistavehiculo') }}">
                    <i class="fa-solid fa-truck me-2"></i>Vehículos
                </a>
            </div>
            <div>
                <a class="nav-link {{ request()->routeIs('vistaproducto') ? 'active' : '' }}" href="{{ route('vistaproducto') }}">
                    <i class="fa-solid fa-bag-shopping me-2"></i>Productos
                </a>
            </div>
            <div>
                <a class="nav-link {{ request()->routeIs('vistaguiasderemisionadministrador') ? 'active' : '' }}" href="{{ route('vistaguiasderemisionadministrador') }}">
                    <i class="fa-solid fa-table-list me-2"></i>Guias de Carga
                </a>
            </div>
        @else
        @endif
    </div>
    <!-- Barra de búsqueda (derecha) -->
{{--    <div class="ms-auto d-flex">--}}
{{--        <form class="d-flex align-items-center me-3">--}}
{{--            <div class="input-group">--}}
{{--                <input class="form-control form-control-sm" type="text" placeholder="Ingrese su busqueda..."--}}
{{--                       aria-label="Buscar" style="width: 200px;">--}}
{{--                <button class="btn btn-sm btn-primary" type="submit">--}}
{{--                    <i class="fas fa-search"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
    <!-- Menú de usuario -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
               aria-expanded="false">Bienvenido {{ Auth::user()->name }}<i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Configuración</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" id="btncerrarsesion">Cerrar Sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>
{{--contenido vistas--}}
<div class="container-fluid mt-5 pt-3" class="@if(Request::is('dashboard')) enable-scroll @endif">
    <main>
        @yield('content')
    </main>
</div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
</body>
</html>
