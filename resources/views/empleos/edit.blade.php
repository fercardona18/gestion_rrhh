<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleo para {{ $empleo->puesto }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Editar Empleo para {{ $empleo->puesto }}</h1>
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

        <form action="{{ route('empleos.update', $empleo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" name="fecha_ingreso" value="{{ $empleo->fecha_ingreso }}" required>
            </div>
            <div class="form-group">
                <label for="puesto">Puesto:</label>
                <input type="text" class="form-control" name="puesto" value="{{ $empleo->puesto }}" required>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <input type="text" class="form-control" name="departamento" value="{{ $empleo->departamento }}" required>
            </div>
            <div class="form-group">
                <label for="tipo_contrato">Tipo de Contrato:</label>
                <input type="text" class="form-control" name="tipo_contrato" value="{{ $empleo->tipo_contrato }}" required>
            </div>
            <div class="form-group">
                <label for="salario_base">Salario Base:</label>
                <input type="number" class="form-control" name="salario_base" value="{{ $empleo->salario_base }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Empleo</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>