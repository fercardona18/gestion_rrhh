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
                    <th>Cargo</th>
                    <th>Fecha de Ingreso</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Estado</th>
                    <th>Comentarios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacaciones as $vacacion)
                    @php
                        // Obtener los datos del empleado
                        $empleado = $vacacion->empleado;
                    @endphp
                    <tr>
                        <td>{{ $vacacion->id }}</td>
                        <td>{{ $empleado->name }}</td>
                        <td>{{ $empleado->puesto }}</td>
                        <td>{{ $empleado->fecha_ingreso }}</td>
                        <td>{{ $vacacion->fecha_inicio }}</td>
                        <td>{{ $vacacion->fecha_fin }}</td>
                        <td>{{ ucfirst($vacacion->estado) }}</td>
                        <td>{{ $vacacion->comentarios }}</td>
                        <td>
                            <form action="{{ route('vacaciones.update', $vacacion->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="estado" class="form-select" required>
                                    <option value="pendiente" {{ $vacacion->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="autorizado" {{ $vacacion->estado == 'autorizado' ? 'selected' : '' }}>Autorizado</option>
                                    <option value="rechazado" {{ $vacacion->estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                                <button type="submit" class="btn btn-warning btn-sm">Actualizar Estado</button>
                            </form>
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