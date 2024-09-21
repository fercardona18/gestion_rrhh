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
            <input type="hidden" name="empleo_id" value="{{ old('empleo_id', isset($empleo) ? $empleo->id : '') }}"> <!-- Campo oculto para empleo_id -->
            
            <div class="form-group">
                <label for="salario_base">Salario Base:</label>
                <input type="number" class="form-control" name="salario_base" value="{{ old('salario_base', isset($empleo) ? $empleo->salario_base : '') }}" readonly>
            </div>

            <div class="form-group">
                <label for="horas_extras">Horas Extras:</label>
                <input type="number" class="form-control" name="horas_extras" value="{{ old('horas_extras', 0) }}" required>
            </div>

            <div class="form-group">
                <label for="deducciones">Deducciones:</label>
                @php
                    // Calcular deducciones basadas en el salario base
                    $deducciones = isset($empleo->salario_base) ? $empleo->salario_base * 0.1267 : 0;
                @endphp
                <input type="number" class="form-control" name="deducciones" value="{{ old('deducciones', $deducciones) }}" readonly>

                <!-- Explicación de las deducciones -->
                <small class="form-text text-muted">
                    Deducciones: 
                    <ul>
                        <li><strong>IGSS:</strong> 12.67% del salario base.</li>
                        <li><strong>IRTRA:</strong> 1% del salario base.</li>
                        <li><strong>INTECAP:</strong> 1% del salario base.</li>
                    </ul>
                </small>
            </div>

            <div class="form-group">
                <label for="bonificaciones">Bonificaciones:</label>
                <input type="number" class="form-control" name="bonificaciones" value="{{ old('bonificaciones', 250) }}" readonly>
            </div>

            <div class="form-group">
                <label for="prestaciones">Prestaciones:</label>
                <input type="number" class="form-control" name="prestaciones" value="{{ old('prestaciones', 0) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Agregar Nómina</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>