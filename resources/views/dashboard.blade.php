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
        }
        .sidebar {
            min-width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center">Gestión de RRHH</h2>
        <div class="nav flex-column">
            <a href="{{ route('empleados.index') }}" class="nav-item nav-link">Empleados</a>
            <a href="{{ route('vacaciones.index') }}" class="nav-item nav-link">Vacaciones</a>
            <a href="{{ route('nomina.index') }}" class="nav-item nav-link">Nómina</a>
            <a href="{{ route('informacion.index') }}" class="nav-item nav-link">Información General</a>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <h1 class="text-center">Bienvenido al Dashboard</h1>
            <p class="text-center">Aquí puedes gestionar todos los aspectos de Recursos Humanos.</p>

            <div class="row">
                <!-- Cuadro de Responsabilidades -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Responsabilidades</h5>
                        </div>
                        <div class="card-body">
                            @if ($responsabilidades->isEmpty())
                                <p>No hay responsabilidades definidas.</p>
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
                                <p>No hay información general definida.</p>
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
                                <p>No hay anuncios disponibles.</p>
                            @else
                                <ul>
                                    @foreach ($anuncios as $anuncio)
                                        <li>
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