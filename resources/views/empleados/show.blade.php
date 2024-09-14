<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Empleado</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Detalles del Empleado</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $empleado->name }}</h5>
                <p class="card-text"><strong>DPI:</strong> {{ $empleado->dpi }}</p>
                <p class="card-text"><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
                <p class="card-text"><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $empleado->email }}</p>
                <p class="card-text"><strong>Fecha de Nacimiento:</strong> {{ $empleado->fecha_nacimiento }}</p>
                <p class="card-text"><strong>Estado Civil:</strong> {{ $empleado->estado_civil }}</p>
                <p class="card-text"><strong>Fecha de Ingreso:</strong> {{ $empleado->fecha_ingreso }}</p>
                <p class="card-text"><strong>Dias de vacaciones disponibles:</strong> {{ $empleado->dias_vacaciones_disponibles }}</p>

                <hr>
                <h5>Empleos</h5>
                @if($empleado->empleos->isEmpty())
                    <p>No hay empleos registrados.</p>
                @else
                    <ul>
                        @foreach($empleado->empleos as $empleo)
                            <li>
                                <strong>Puesto:</strong> {{ $empleo->puesto }} <br>
                                <strong>Departamento:</strong> {{ $empleo->departamento }} <br>
                                <strong>Tipo de Contrato:</strong> {{ $empleo->tipo_contrato }} <br>
                                <strong>Salario Base:</strong> Q {{ number_format($empleo->salario_base, 2) }} <br>
                                <strong>Fecha de Ingreso:</strong> {{ $empleo->fecha_ingreso }} <br>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <hr>
                <h5>Historial Laboral</h5>
                @if($empleado->historialLaboral)
                    <p><strong>Experiencia Previa:</strong> {{ $empleado->historialLaboral->experiencia_previa }}</p>
                    <p><strong>Educación:</strong> {{ $empleado->historialLaboral->educacion }}</p>
                    <p><strong>Certificaciones:</strong> {{ $empleado->historialLaboral->certificaciones }}</p>
                @else
                    <p>No hay historial laboral registrado.</p>
                @endif

                <a href="{{ route('empleados.index') }}" class="btn btn-primary">Volver a la lista</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>