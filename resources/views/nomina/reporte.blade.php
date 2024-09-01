<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Nómina</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Reporte de Nómina</h1>
        </header>

        <section class="employee-info">
            <h2 class="mb-3">Datos del Trabajador</h2>
            <table class="table table-bordered">
                <tr>
                    <th>Nombre Completo</th>
                    <td>{{ $empleado->name }}</td>
                </tr>
                <tr>
                    <th>DPI</th>
                    <td>{{ $empleado->dpi }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $empleado->email }}</td>
                </tr>
                <tr>
                    <th>Cargo</th>
                    <td>{{ $empleado->puesto }}</td>
                </tr>
                <tr>
                    <th>Fecha de Ingreso</th>
                    <td>{{ $empleado->fecha_ingreso }}</td>
                </tr>
            </table>
        </section>

        <section class="salary-info">
            <h2 class="mb-3">Información Salarial</h2>
            <table class="table table-bordered">
                <tr>
                    <th>Salario Base</th>
                    <td>Q {{ number_format($nomina->salario_base, 2) }}</td>
                </tr>
                <tr>
                    <th>Horas Extras</th>
                    <td>Q {{ number_format($nomina->horas_extras, 2) }}</td>
                </tr>
                <tr>
                    <th>Deducciones</th>
                    <td>Q {{ number_format($nomina->deducciones, 2) }}</td>
                </tr>
                <tr>