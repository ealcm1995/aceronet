<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')AceroNet</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        #toast-container {
            position: fixed !important;
            bottom: 15px !important;
            right: 15px !important;
            top: unset !important;
        }

        #toast-container > div {
            opacity: 0.95 !important;
            padding: 10px 15px !important;
            border-radius: 6px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05) !important;
            width: 250px !important;
        }

        #toast-container > .toast-success {
            background-image: none !important;
            background-color: #4ade80 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        #toast-container > .toast-error {
            background-image: none !important;
            background-color: #f87171 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .toast-message {
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: white !important;
            text-align: center !important;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            width: 250px;
            min-width: 250px;
            z-index: 1000;
            background-color: #2e2e30;
            height: 100vh;
        }

        .sidebar.collapsed {
            width: 80px;
            min-width: 80px;
        }

        .sidebar.collapsed .sidebar-header h4,
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.5rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .main-content {
            transition: all 0.3s ease;
            width: calc(100% - 250px);
            margin-left: 250px;
        }

        .main-content.expanded {
            width: calc(100% - 80px);
            margin-left: 80px;
        }

        #toggleSidebar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 auto;
        }

        #toggleSidebar:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .sidebar-footer {
            margin-top: auto;
            margin-bottom: auto;
            padding-top: 20px;
            text-align: center;
        }

        .sidebar .nav {
            margin-bottom: auto;
        }

        header.bg-dark {
            background-color: #2e2e30 !important;
        }

        .sidebar-header {
            background-color: #2e2e30;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 px-0 sidebar" id="sidebar">
                <div class="sidebar-header">
                    <h4 class="text-white">AceroNet</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a class="nav-link {{ request()->is('actividades*') ? 'active' : '' }}" href="{{ route('actividades.index') }}">
                        <i class="fas fa-tasks"></i>
                        <span>Actividades</span>
                    </a>
                    {{-- Comentar hasta implementar
                    <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Productos</span>
                    </a>
                    <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Clientes</span>
                    </a>
                    <a class="nav-link {{ request()->is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Órdenes</span>
                    </a>
                    --}}
                    <a class="nav-link {{ request()->is('reporte-editor') ? 'active' : '' }}" href="{{ route('reporte.editor') }}">
                        <i class="fas fa-file-edit"></i>
                        <span>Editor de Reportes</span>
                    </a>
                </nav>
                <div class="sidebar-footer">
                    <button id="toggleSidebar" class="btn btn-link text-white">
                        <i class="fas fa-arrow-left" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
<!-- NavBar -->
<div class="col-md-10 main-content p-0">
    <header class="bg-dark text-white">
        <div class="d-flex justify-content-between align-items-center px-4 py-3">
            <!-- Mensaje de bienvenida -->
            <div class="welcome-message">
                @auth
                    <h5 class="mb-0">¡Bienvenido, <span class="text-primary fw-bold">{{ Auth::user()->name }}</span>!</h5>
                @else
                    <h5 class="mb-0">¡Bienvenido a AceroNet!</h5>
                @endauth
            </div>
            
            <!-- Elementos del lado derecho -->
            <div class="d-flex align-items-center">
                <!-- Buscador -->
                <div class="search-container me-4">
                    <form class="d-flex">
                        <div class="input-group input-group-sm">
                            <input type="search" class="form-control border-end-0" placeholder="Buscar...">
                            <button class="btn btn-outline-light border-start-0" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Iconos de acción -->
                <div class="d-flex align-items-center me-4">
                    <!-- Notificaciones -->
                    <div class="dropdown mx-3">
                        <a href="#" class="btn btn-link text-white position-relative p-1" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-sm py-2">
                            <a class="dropdown-item px-3 py-2" href="#">Notificación 1</a>
                            <a class="dropdown-item px-3 py-2" href="#">Notificación 2</a>
                            <a class="dropdown-item px-3 py-2" href="#">Notificación 3</a>
                        </div>
                    </div>

                    <!-- Mensajes -->
                    <div class="dropdown mx-3">
                        <a href="#" class="btn btn-link text-white position-relative p-1" data-bs-toggle="dropdown">
                            <i class="fas fa-envelope fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-sm py-2">
                            <a class="dropdown-item px-3 py-2" href="#">Mensaje 1</a>
                            <a class="dropdown-item px-3 py-2" href="#">Mensaje 2</a>
                        </div>
                    </div>
                </div>

                <!-- Separador vertical -->
                <div class="vr mx-3 opacity-25 bg-white" style="height: 32px;"></div>

                <!-- Perfil de usuario -->
                @auth
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle border" width="40" height="40" alt="Avatar">
                        <span class="ms-2 text-dark">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-sm py-2">
                        <a class="dropdown-item px-3 py-2" href="#"><i class="fas fa-user me-2 text-secondary"></i>Perfil</a>
                        <a class="dropdown-item px-3 py-2" href="#"><i class="fas fa-cog me-2 text-secondary"></i>Configuración</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item px-3 py-2 text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Salir
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3">Iniciar sesión</a>
                </div>
                @endauth
            </div>
        </div>
    </header>
    @yield('content')
</div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeNotifications();
        });
    </script>
    <script>
        function eliminarActividad(id) {
            if (confirm('¿Estás seguro que deseas eliminar esta actividad?')) {
                fetch('{{ url("/") }}/actividades/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Actividad eliminada');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        toastr.error('No se pudo eliminar la actividad');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Error al eliminar');
                });
            }
        }
    </script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            preventDuplicates: true,
            showDuration: "200",
            hideDuration: "500",
            timeOut: "1500",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
    </script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleIcon = document.getElementById('toggleIcon');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Cambiar el icono según el estado
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-arrow-left');
                toggleIcon.classList.add('fa-arrow-right');
            } else {
                toggleIcon.classList.remove('fa-arrow-right');
                toggleIcon.classList.add('fa-arrow-left');
            }
            
            // Guardar el estado en localStorage
            localStorage.setItem('sidebarState', sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded');
        });

        // Recuperar el estado al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleIcon = document.getElementById('toggleIcon');
            const sidebarState = localStorage.getItem('sidebarState');
            
            if (sidebarState === 'collapsed') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                toggleIcon.classList.remove('fa-arrow-left');
                toggleIcon.classList.add('fa-arrow-right');
            }
        });
    </script>
    @yield('scripts')
    <div class="modal fade" id="reporteModal" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reporteModalLabel">
                        <i class="fas fa-chart-bar me-2"></i>Generar Reporte
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí irá el contenido del modal de reportes -->
                    <form id="reporteForm" class="row g-3">
                        <div class="col-12">
                            <p class="text-muted">Seleccione los criterios para generar el reporte</p>
                        </div>
                        <!-- Aquí puedes agregar más campos según necesites -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-file-download me-2"></i>Generar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
    function changePerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', '1');  // Forzar siempre a la página 1
        url.searchParams.set('per_page', value);
        window.location.href = url.toString();
    }
    </script>
</body>
</html> 
</html> 