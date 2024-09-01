<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleos de {{ $empleado->name }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Empleos de {{ $empleado->name }}</h1>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Ingreso</th>
                    <th>Puesto</th>
                    <th>Departamento</th>
                    <th>Tipo de Contrato</th>
                    <th>Salario Base</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleado->empleos as $empleo)
                    <tr>
                        <td>{{ $empleo->id }}</td>
                        <td>{{ $empleo->fecha_ingreso }}</td>
                        <td>{{ $empleo->puesto }}</td>
                        <td>{{ $empleo->departamento }}</td>
                        <td>{{ $empleo->tipo_contrato }}</td>
                        <td>Q {{ number_format($empleo->salario_base, 2) }}</td>
                        <td>
                            <a href="{{ route('empleos.edit', $empleo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('empleos.destroy', $empleo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('empleos.create', $empleado->id) }}" class="btn btn-primary">Agregar Nuevo Empleo</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>