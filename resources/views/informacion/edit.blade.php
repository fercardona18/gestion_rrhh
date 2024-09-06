<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Información</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Editar Información General</h1>
        </header>

        <a href="{{ route('informacion.index') }}" class="btn btn-secondary mb-3">Regresar a la Lista</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('informacion.update', $informacion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo" value="{{ $informacion->titulo }}" required>
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea class="form-control" name="contenido" rows="5" required>{{ $informacion->contenido }}</textarea>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select name="tipo" class="form-control" required>
                    <option value="responsabilidad" {{ $informacion->tipo == 'responsabilidad' ? 'selected' : '' }}>Responsabilidad</option>
                    <option value="anuncio" {{ $informacion->tipo == 'anuncio' ? 'selected' : '' }}>Anuncio</option>
                    <option value="informacion_general" {{ $informacion->tipo == 'informacion_general' ? 'selected' : '' }}>Información General</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Información</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>