@extends('layouts.admin')

@section('title', 'Detalle de Inscripción')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Inscripción #{{ $membership->id }}</h5>
            <span class="badge bg-white text-primary">{{ strtoupper($membership->status) }}</span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Miembro</h6>
                    <h5>{{ $membership->member->last_name }}, {{ $membership->member->first_name }}</h5>
                    <p class="mb-0">DNI: {{ $membership->member->dni }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="text-muted">Plan Contratado</h6>
                    <h5>{{ $membership->plan->name }}</h5>
                    <p class="mb-0">Registrado por: {{ $membership->creator->name ?? 'Sistema' }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4">
                    <strong>Vigencia:</strong><br>
                    Del {{ $membership->start_date->format('d/m/Y') }} al {{ $membership->end_date->format('d/m/Y') }}
                </div>
                <div class="col-md-4">
                    <strong>Detalle Económico:</strong><br>
                    Precio Base: ${{ number_format($membership->plan_price_at_purchase, 2) }}<br>
                    Descuento: -${{ number_format($membership->discount_applied, 2) }}<br>
                    <strong class="text-primary">Total: ${{ number_format($membership->final_price, 2) }}</strong>
                </div>
                <div class="col-md-4">
                    <strong>Saldo:</strong><br>
                    {{-- Aquí conectaremos el módulo de pagos --}}
                    @php $paid = $membership->payments->sum('amount') ?? 0; @endphp
                    Pagado: ${{ number_format($paid, 2) }}<br>
                    <span class="{{ ($membership->final_price - $paid) > 0 ? 'text-danger' : 'text-success' }}">
                        Pendiente: ${{ number_format($membership->final_price - $paid, 2) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <a href="{{ route('memberships.index') }}" class="btn btn-secondary">Volver</a>
            {{-- Botón para ir a registrar pago (Próximo módulo) --}}
            @if($membership->final_price > $paid)
                <a href="#" class="btn btn-success float-end">
                    <i class="fa fa-dollar-sign"></i> Registrar Pago
                </a>
            @endif
        </div>
    </div>
</div>
@endsection