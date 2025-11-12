@extends('layouts.admin')

@section('title', 'Reporte Detallado')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">
            <i class="fa fa-calendar-alt text-primary me-2"></i>
            Reporte {{ $month ? \Carbon\Carbon::create()->month($month)->format('F') : '' }} {{ $year }}
        </h4>

        <a href="{{ route('financial_reports.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="alert alert-info shadow-sm">
        <strong>Total del período:</strong> ${{ number_format($total, 2) }}
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Miembro</th>
                        <th>Actividad</th>
                        <th>Método</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td>{{ $p->payment_date->format('d/m/Y') }}</td>
                            <td>{{ $p->membership->member->full_name ?? '-' }}</td>
                            <td>
                                @foreach($p->membership->activities as $act)
                                    <span class="badge bg-secondary">{{ $act->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ ucfirst($p->payment_method) }}</td>
                            <td>${{ number_format($p->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No hay registros en este período</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
