@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Bienvenido, {{ Auth::user()->name ?? 'Usuario' }}</h4>
        <small class="text-muted">Último acceso: {{ now()->format('d/m/Y H:i') }}</small>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                    <h6 class="fw-semibold">Miembros activos</h6>
                    <h3 class="fw-bold">128</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-dumbbell fa-2x text-success mb-2"></i>
                    <h6 class="fw-semibold">Rutinas creadas</h6>
                    <h3 class="fw-bold">47</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-heartbeat fa-2x text-danger mb-2"></i>
                    <h6 class="fw-semibold">Fichas médicas</h6>
                    <h3 class="fw-bold">85</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-coins fa-2x text-warning mb-2"></i>
                    <h6 class="fw-semibold">Pagos del mes</h6>
                    <h3 class="fw-bold">$24.560</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico de ejemplo --}}
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold">
            <i class="fa fa-chart-line me-2 text-primary"></i>Actividad mensual
        </div>
        <div class="card-body">
            <canvas id="activityChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('activityChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [{
            label: 'Miembros activos',
            data: [100, 115, 120, 130, 128, 140],
            borderColor: '#0d6efd',
            fill: false,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
