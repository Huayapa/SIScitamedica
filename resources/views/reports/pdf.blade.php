<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Citas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background: #f1f1f1;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        td {
            border-bottom: 1px solid #eee;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>

    <h1>Reporte de Citas</h1>

    <table>
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($appointments as $a)
                <tr>
                    <td>{{ $a->patient->full_name }}</td>
                    <td>{{ $a->doctor->full_name }}</td>
                    <td>{{ $a->appointment_date?->format('d/m/Y') }}</td>
                    <td>{{ $a->appointment_time ? substr($a->appointment_time, 0, 5) : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
