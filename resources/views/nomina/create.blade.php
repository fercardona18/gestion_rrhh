<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nómina para {{ $empleado->name }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Agregar Nueva Nómina para {{ $empleado->name }}</h1>
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

        <form action="{{ route('nomina.store', $empleado->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="salario_base">Salario Base:</label>
                <input type="number" class="form-control" name="salario_base" required>
            </div>
            <div class="form-group">
                <label for="horas_extras">Horas Extras:</label>
                <input type="number" class="form-control" name="horas_extras" value="0" required>
            </div>
            <div class="form-group">
                <label for="deducciones">Deducciones:</label>
                <input type="number" class="form-control" name="deducciones" value="0" required>
            </div>
            <div class="form-group">
                <label for="bonificaciones">Bonificaciones:</label>
                <input type="number" class="form-control" name="bonificaciones" value="0" required>
            </div>
            <div class="form-group">
                <label for="prestaciones">Prestaciones:</label>
                <input type="number" class="form-control" name="prestaciones" value="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Nómina</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>