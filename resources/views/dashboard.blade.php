<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AceroNet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="display-4 mb-4">Dashboard</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Productos</a></li>
                        <li class="nav-item"><a href="{{ route('customers.index') }}" class="nav-link">Clientes</a></li>
                        <li class="nav-item"><a href="{{ route('orders.index') }}" class="nav-link">Órdenes</a></li>
                        <li class="nav-item"><a href="{{ route('reports.sales') }}" class="nav-link">Reporte de Ventas</a></li>
                        <li class="nav-item"><a href="{{ route('reports.inventory') }}" class="nav-link">Reporte de Inventario</a></li>
                        <li class="nav-item">
                            <a href="{{ url('/aceronet/public/actividades') }}" class="nav-link">Planificación de Actividades</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="card">
            <div class="card-body">
                <p class="card-text">Bienvenido al sistema</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 