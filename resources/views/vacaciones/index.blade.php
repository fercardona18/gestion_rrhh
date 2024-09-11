<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vacaciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Lista de Solicitudes de Vacaciones</h1>
        </header>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Días Solicitados</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacaciones as $vacacion)
                    <tr>
                        <td>{{ $vacacion->id }}</td>
                        <td>{{ $vacacion->empleado->name }}</td>
                        <td>{{ $vacacion->fecha_inicio }}</td>
                        <td>{{ $vacacion->fecha_fin }}</td>
                        <td>{{ $vacacion->dias_solicitados }}</td>
                        <td>
                            @if ($vacacion->estado == 'pendiente')
                                <span class="badge badge-warning">Pendiente</span>
                            @elseif ($vacacion->estado == 'aprobado')
                                <span class="badge badge-success">Aprobado</span>
                            @else
                                <span class="badge badge-danger">Rechazado</span>
                            @endif
                        </td>
                        <td>{{ $vacacion->comentario }}</td>
                        <td>
                            @if ($vacacion->estado == 'pendiente')
                                <form action="{{ route('vacaciones.approve', $vacacion->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                                </form>
                                <form action="{{ route('vacaciones.reject', $vacacion->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="text" name="comentario" placeholder="Comentario" required>
                                    <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                </form>
                            @else
                                <span class="badge badge-secondary">No se puede modificar</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Regresar al Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>