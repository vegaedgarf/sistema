@extends('layouts.admin')

@section('title', 'Reportes Financieros')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fa fa-chart-line me-2"></i> Reportes Financieros</h1>
    </div>

    <!-- Filtros -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Año</label>
                    <input type="number" name="year" value="{{ request('year', date('Y')) }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Mes</label>
                    <select name="month" class="form-select">
                        <option value="">Todos</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Método de Pago</label>
                    <select name="payment_method" class="form-select">
                        <option value="">Todos</option>
                        <option value="efectivo" {{ request('payment_method')=='efectivo'?'selected':'' }}>Efectivo</option>
                        <option value="tarjeta" {{ request('payment_method')=='tarjeta'?'selected':'' }}>Tarjeta</option>
                        <option value="transferencia" {{ request('payment_method')=='transferencia'?'selected':'' }}>Transferencia</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Actividad</label>
                    <select name="activity_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach(\App\Models\Activity::all() as $activity)
                            <option value="{{ $activity->id }}" {{ request('activity_id') == $activity->id ? 'selected' : '' }}>
                                {{ $activity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Totales -->
    <div class="alert alert-info d-flex align-items-center shadow-sm">
        <i class="fa fa-coins fa-2x me-3"></i>
        <div>
            <h5 class="mb-0 fw-semibold">Total ingresos</h5>
            <span class="fs-5">${{ number_format($totalIncome, 2) }}</span>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">
            <i class="fa fa-chart-bar me-2 text-primary"></i> Ingresos Mensuales
        </div>
        <div class="card-body">
            <canvas id="monthlyChart" height="80"></canvas>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="fa fa-receipt me-2 text-primary"></i> Detalle de pagos</span>
            <a href="{{ route('payments.create') }}" class="btn btn-sm btn-success">
                <i class="fa fa-plus me-1"></i> Nuevo Pago
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Miembro</th>
                        <th>Actividad</th>
                        <th>Método</th>
                        <th class="text-end">Monto</th>
                        <th class="text-center">Acciones</th>
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
                            <td class="text-end">${{ number_format($p->amount, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('financial_reports.show', [$p->payment_date->year, $p->payment_date->month]) }}" 
                                   class="btn btn-sm btn-outline-info" title="Ver resumen mensual">
                                   <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('financial_reports.edit', $p->id) }}" 
                                   class="btn btn-sm btn-outline-warning" title="Editar pago">
                                   <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No hay registros disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_map(fn($m)=>\Carbon\Carbon::create()->month($m)->format('M'), array_keys($monthlySummary->toArray()))) !!},
        datasets: [{
            label: 'Ingresos Mensuales ($)',
            data: {!! json_encode(array_values($monthlySummary->toArray())) !!},
            backgroundColor: '#007bff'
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection
