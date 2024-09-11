<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Editar Empleado</h1>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre Completo:</label>
                <input type="text" class="form-control" name="name" value="{{ $empleado->name }}" required>
            </div>
            <div class="form-group">
                <label for="dpi">DPI:</label>
                <input type="text" class="form-control" name="dpi" value="{{ $empleado->dpi }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" value="{{ $empleado->direccion }}" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" value="{{ $empleado->telefono }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ $empleado->email }}" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" name="fecha_nacimiento" value="{{ $empleado->fecha_nacimiento }}" required>
            </div>
            <div class="form-group">
                <label for="estado_civil">Estado Civil:</label>
                <input type="text" class="form-control" name="estado_civil" value="{{ $empleado->estado_civil }}" required>
            </div>
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" name="fecha_ingreso" value="{{ $empleado->fecha_ingreso }}" required>
            </div>
            <div class="form-group">
                <label for="puesto">Cargo:</label>
                <input type="text" class="form-control" name="puesto" value="{{ $empleado->puesto }}" required>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <input type="text" class="form-control" name="departamento" value="{{ $empleado->departamento }}" required>
            </div>
            <div class="form-group">
                <label for="tipo_contrato">Tipo de Contrato:</label>
                <input type="text" class="form-control" name="tipo_contrato" value="{{ $empleado->tipo_contrato }}" required>
            </div>
            <div class="form-group">
                <label for="salario_base">Salario Base:</label>
                <input type="number" class="form-control" name="salario_base" value="{{ $empleado->salario_base }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>