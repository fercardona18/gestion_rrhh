<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nómina</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Nómina</h1>
        </header>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Salario Base</th>
                    <th>Horas Extras</th>
                    <th>Deducciones</th>
                    <th>Bonificaciones</th>
                    <th>Prestaciones</th>
                    <th>Total a Pagar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nominas as $nomina)
                    <tr>
                        <td>{{ $nomina->id }}</td>
                        <td>{{ $nomina->empleado->name }}</td>
                        <td>Q {{ number_format($nomina->salario_base, 2) }}</td>
                        <td>Q {{ number_format($nomina->horas_extras, 2) }}</td>
                        <td>Q {{ number_format($nomina->deducciones, 2) }}</td>
                        <td>Q {{ number_format($nomina->bonificaciones, 2) }}</td>
                        <td>Q {{ number_format($nomina->prestaciones, 2) }}</td>
                        <td>Q {{ number_format($nomina->salario_base + $nomina->horas_extras + $nomina->bonificaciones - $nomina->deducciones + $nomina->prestaciones, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>