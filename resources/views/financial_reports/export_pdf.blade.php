<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero {{ $month }}/{{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Reporte Financiero - {{ $month }}/{{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Miembro</th>
                <th>Actividad</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Método</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->membership->member->first_name ?? '-' }} {{ $p->membership->member->last_name ?? '' }}</td>
                    <td>{{ $p->membership->activities->pluck('name')->join(', ') }}</td>
                    <td>${{ number_format($p->amount, 2, ',', '.') }}</td>
                    <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                    <td>{{ $p->payment_method ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Ingresos: ${{ number_format($total, 2, ',', '.') }}</h3>
</body>
</html>
