<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CORPO | Panel Administrativo')</title>

    {{-- Bootstrap + CoreUI + Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

     
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- CSS personalizado --}}
    @vite(['resources/css/admin.css'])
</head>

<body class="c-app">
    {{-- Sidebar --}}
    <nav class="c-sidebar" id="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-3 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/corpo-logo.jpg') }}" alt="CORPO" height="28" class="me-2">
                <h6 class="fw-bold text-white m-0 sidebar-title">CORPO</h6>
            </div>
            <button class="btn btn-sm btn-outline-light border-0 toggle-btn" id="sidebarCollapseBtn" data-bs-toggle="tooltip" title="Contraer menú">
                <i class="fa fa-angle-double-left"></i>
            </button>
        </div>

        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" data-bs-toggle="tooltip" title="Dashboard">
                    <i class="fa fa-gauge me-2"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('members*') ? 'active' : '' }}" href="{{ route('members.index') }}" data-bs-toggle="tooltip" title="Miembros">
                    <i class="fa fa-users me-2"></i> <span>Miembros</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('contacts*') ? 'active' : '' }}" href="#" data-bs-toggle="tooltip" title="Contactos">
                    <i class="fa fa-address-book me-2"></i> <span>Contactos</span>
                </a>
            </li>

            @role('admin')
            <li class="nav-item mt-2">
                <button class="nav-link text-start w-100 d-flex align-items-center justify-content-between submenu-toggle" data-bs-toggle="collapse" data-bs-target="#adminMenu">
                    <span><i class="fa fa-gear me-2"></i> Administración</span>
                    <i class="fa fa-angle-down small"></i>
                </button>
                <ul class="collapse nav flex-column ms-3" id="adminMenu">
                    <li><a href="{{ route('users.index') }}" class="nav-link small"><i class="fa fa-user me-2"></i> Usuarios</a></li>
                    <li><a href="{{ route('roles.index') }}" class="nav-link small"><i class="fa fa-user-shield me-2"></i> Roles</a></li>
                    <li><a href="{{ route('permissions.index') }}" class="nav-link small"><i class="fa fa-key me-2"></i> Permisos</a></li>
                </ul>
            </li>
            @endrole
       

        {{-- @role('admin') --}}
        @hasanyrole(['admin', 'profesor', 'entrenador', 'recepcionista'])
        <li class="nav-item mt-2">
            <button class="nav-link text-start w-100 d-flex align-items-center justify-content-between submenu-toggle" 
                    data-bs-toggle="collapse" data-bs-target="#financeMenu">
                <span><i class="fa fa-coins me-2"></i> Gestión Financiera</span>
                <i class="fa fa-angle-down small"></i>
            </button>
            <ul class="collapse nav flex-column ms-3" id="financeMenu">
                
                <li>
                     <a href="{{ route('financial_reports.index') }}" class="nav-link small">
                        <i class="fa fa-chart-line me-2"></i> Reportes
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('memberships.index') }}" class="nav-link small">
                        <i class="fa fa-id-card me-2"></i> Membresías
                    </a>
                </li> 
                
                <li>
                    <a href="{{ route('membership_prices.index') }}" class="nav-link small">
                        <i class="fa fa-tags me-2"></i> Precios por Actividad
                    </a>
                </li>

                <li>
                    <a href="{{ route('activities.index') }}" class="nav-link small">
                        <i class="fa fa-dumbbell me-2"></i> Actividades
                    </a>
                </li>


                <li>
                    <a href="{{ route('payments.index') }}" class="nav-link small">
                        <i class="fa fa-cash-register me-2"></i> Pagos
                    </a>
                </li>
                <li>
                     <a href="{{ route('member_activity.index') }}" class="nav-link small" >
                        <i class="fa fa-calendar-check me-2"></i > Asistencias-actividades-inscripciones
                    </a> 
                </li>
            </ul>
        </li>
        @endhasanyrole
         {{-- @endrole --}}



        </ul>

        <div class="p-3 border-top mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="fa fa-sign-out-alt me-2"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <div class="c-wrapper" id="mainWrapper">
        <header class="c-header bg-white border-bottom d-flex align-items-center justify-content-between px-4 py-2 shadow-sm">
            <button class="btn btn-light btn-sm d-lg-none" id="mobileMenuBtn">
                <i class="fa fa-bars"></i>
            </button>
            <h6 class="fw-semibold mb-0">@yield('title', 'Panel')</h6>

            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary btn-sm me-3" id="darkModeToggle" data-bs-toggle="tooltip" title="Modo oscuro">
                    <i class="fa fa-moon"></i>
                </button>
                <i class="fa fa-user-circle text-muted me-2"></i>
                <span class="small fw-semibold">{{ Auth::user()->name ?? 'Usuario' }}</span>
            </div>
        </header>

        <main class="c-body p-4 bg-light min-vh-100">
            @yield('content')
        </main>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const darkModeToggle = document.getElementById('darkModeToggle');

        // Inicializar tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

        // Colapsar sidebar (modo escritorio)
        sidebarCollapseBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            document.querySelector('.sidebar-title').classList.toggle('d-none');
            sidebarCollapseBtn.querySelector('i').classList.toggle('fa-angle-double-left');
            sidebarCollapseBtn.querySelector('i').classList.toggle('fa-angle-double-right');
        });

        // Mostrar/ocultar sidebar móvil
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        // Cerrar sidebar móvil al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 992 && !sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Modo oscuro
        darkModeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            darkModeToggle.querySelector('i').classList.toggle('fa-moon');
            darkModeToggle.querySelector('i').classList.toggle('fa-sun');
        });


    document.querySelectorAll('.submenu-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const icon = toggle.querySelector('.fa-angle-down');
        icon.classList.toggle('rotate-180');
        });
    });



    </script>

@stack('scripts')

</body>
</html>
