<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Historial Laboral para {{ $empleo->puesto }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Agregar Historial Laboral para {{ $empleo->puesto }}</h1>
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

        <form action="{{ route('historial.store', $empleo->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="experiencia_previa">Experiencia Previa:</label>
                <textarea class="form-control" name="experiencia_previa" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="educacion">Educación:</label>
                <textarea class="form-control" name="educacion" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="certificaciones">Certificaciones:</label>
                <textarea class="form-control" name="certificaciones" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Historial Laboral</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>