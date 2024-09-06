<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestión de RRHH</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: #f0f4f8; /* Color de fondo suave */
        }
        .sidebar {
            min-width: 250px;
            background-color: #343a40; /* Color oscuro */
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Sombra para el sidebar */
        }
        .sidebar img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            transition: background-color 0.3s; /* Transición suave */
        }
        .sidebar a:hover {
            background-color: #495057; /* Color al pasar el ratón */
            text-decoration: underline;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #ffffff; /* Fondo blanco para el contenido */
            overflow-y: auto;
            border-left: 1px solid #dee2e6; /* Línea divisoria */
        }
        .card {
            border-radius: 10px; /* Bordes redondeados */
            transition: transform 0.2s; /* Transición suave */
        }
        .card:hover {
            transform: scale(1.02); /* Efecto de zoom al pasar el ratón */
        }
        .card-header {
            background-color: #007bff; /* Color de fondo del encabezado */
            color: white;
            font-weight: bold;
        }
        .list-group-item {
            background-color: #f8f9fa; /* Fondo claro para los elementos de la lista */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center">Gestión de RRHH</h2>
        <div class="nav flex-column">
            <a href="{{ route('empleados.index') }}" class="nav-item nav-link">
                <i class="fas fa-users"></i> Empleados
            </a>
            <a href="{{ route('vacaciones.index') }}" class="nav-item nav-link">
                <i class="fas fa-plane"></i> Vacaciones
            </a>
            <a href="{{ route('nomina.index') }}" class="nav-item nav-link">
                <i class="fas fa-money-bill-wave"></i> Nómina
            </a>
            <a href="{{ route('informacion.index') }}" class="nav-item nav-link">
                <i class="fas fa-info-circle"></i> Información General
            </a>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <h1 class="text-center">Bienvenido al Dashboard</h1>
            <p class="text-center">Aquí puedes gestionar todos los aspectos de Recursos Humanos.</p>

            <!-- Barra de búsqueda -->
            <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                <div class="input-group">
                    <input type="date" name="fecha" class="form-control" placeholder="Buscar por fecha" value="{{ request('fecha') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <!-- Cuadro de Responsabilidades -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Responsabilidades</h5>
                        </div>
                        <div class="card-body">
                            @if ($responsabilidades->isEmpty())
                                <p>No hay responsabilidades definidas para la fecha seleccionada.</p>
                            @else
                                @foreach ($responsabilidades as $responsabilidad)
                                    <strong>{{ $responsabilidad->titulo }}</strong>: {{ $responsabilidad->contenido }}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cuadro de Información General -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Información General</h5>
                        </div>
                        <div class="card-body">
                            @if ($infoGeneral->isEmpty())
                                <p>No hay información general definida para la fecha seleccionada.</p>
                            @else
                                @foreach ($infoGeneral as $info)
                                    <strong>{{ $info->titulo }}</strong>: {{ $info->contenido }}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cuadro de Anuncios -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Anuncios</h5>
                        </div>
                        <div class="card-body">
                            @if ($anuncios->isEmpty())
                                <p>No hay anuncios disponibles para la fecha seleccionada.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($anuncios as $anuncio)
                                        <li class="list-group-item">
                                            <strong>{{ $anuncio->titulo }}</strong>: {{ $anuncio->contenido }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>