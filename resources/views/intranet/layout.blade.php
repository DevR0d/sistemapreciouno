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
        //'resources/js/app.js',
        'resources/js/intranet/appguiasremision.js',
        'resources/js/intranet/appproducto.js',
        'resources/js/intranet/appvehiculo.js',
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
               <a class="navbar-brand ps-3" href="{{route("vistadashboard")}}">Bienvenido Usuario</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Ingrese su busqueda..." aria-label="Ingrese su busqueda..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
{{--                        <div class="sb-sidenav-menu-heading">Core</div>--}}
                        <a class="nav-link" href="{{route("vistadashboard")}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link" href="{{route("vistausuarios")}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Usuarios
                        </a>

                        <a class="nav-link" href="{{route("vistavehiculo")}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-truck"></i></div>
                            Vehiculo
                        </a>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-truck"></i></div>
                            Conductores
                        </a>

                        <a class="nav-link" href="{{route("vistaproducto")}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                            Producto
                        </a>

                        <a class="nav-link" href="{{route("vistaguiasderemision")}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tag"></i></div>
                            Guías de Remisión
                        </a>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-tag"></i></div>
                            Revisión de Guías
                        </a>

                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
