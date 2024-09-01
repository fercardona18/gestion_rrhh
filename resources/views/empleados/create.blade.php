<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Empleado</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Agregar Nuevo Empleado</h1>
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

        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre Completo:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="estado_civil">Estado Civil:</label>
                <input type="text" class="form-control" name="estado_civil" required>
            </div>
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" name="fecha_ingreso" required>
            </div>

            <hr>
            <h4>Información de Empleo</h4>
            <div class="form-group">
                <label for="puesto">Puesto:</label>
                <input type="text" class="form-control" name="puesto">
            </div>
            <div class="form-group">
                <label for="departamento">Departamento:</label>
                <input type="text" class="form-control" name="departamento">
            </div>
            <div class="form-group">
                <label for="tipo_contrato">Tipo de Contrato:</label>
                <input type="text" class="form-control" name="tipo_contrato">
            </div>
            <div class="form-group">
                <label for="salario_base">Salario Base:</label>
                <input type="number" class="form-control" name="salario_base">
            </div>

            <hr>
            <h4>Información de Historial Laboral</h4>
            <div class="form-group">
                <label for="experiencia_previa">Experiencia Previa:</label>
                <textarea class="form-control" name="experiencia_previa"></textarea>
            </div>
            <div class="form-group">
                <label for="educacion">Educación:</label>
                <textarea class="form-control" name="educacion"></textarea>
            </div>
            <div class="form-group">
                <label for="certificaciones">Certificaciones:</label>
                <textarea class="form-control" name="certificaciones"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Agregar Empleado</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>