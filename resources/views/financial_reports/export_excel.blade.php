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
                <td>{{ $p->amount }}</td>
                <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                <td>{{ $p->payment_method ?? '-' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td colspan="3"><strong>{{ $total }}</strong></td>
        </tr>
    </tbody>
</table>
