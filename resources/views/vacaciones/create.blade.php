<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Vacaciones para {{ $empleado->name }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Solicitar Vacaciones para {{ $empleado->name }}</h1>
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

        <form action="{{ route('vacaciones.store') }}" method="POST">
            @csrf
            <input type="hidden" name="empleado_id" value="{{ $empleado->id }}">
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" class="form-control" name="fecha_fin" required>
            </div>
            <div class="form-group">
                <label for="dias_solicitados">Días Solicitados:</label>
                <input type="number" class="form-control" name="dias_solicitados" min="1" max="{{ $empleado->dias_vacaciones_disponibles }}" required>
                <small class="form-text text-muted">Tienes {{ $empleado->dias_vacaciones_disponibles }} días de vacaciones disponibles.</small>
            </div>
            <div class="form-group">
                <label for="comentario">Comentario:</label>
                <textarea class="form-control" name="comentario" rows="3" placeholder="Escribe tu comentario aquí..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>