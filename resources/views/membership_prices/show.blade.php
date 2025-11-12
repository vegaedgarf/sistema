@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalles del Precio de Membresía: #{{ $membershipPrice->id }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Precio:</strong> <span class="badge bg-success fs-5">${{ number_format($membershipPrice->price, 2) }}</span></p>
                    <p><strong>Válido Desde:</strong> {{ $membershipPrice->valid_from->format('d/m/Y') }}</p>
                    <p><strong>Válido Hasta:</strong> 
                        @if($membershipPrice->valid_to)
                            {{ $membershipPrice->valid_to->format('d/m/Y') }}
                        @else
                            <span class="badge bg-secondary">Actual / Sin límite</span>
                        @endif
                    </p>
                    <p><strong>Estado:</strong> 
                        @if(!$membershipPrice->valid_to || $membershipPrice->valid_to->gt(now()))
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-warning">Histórico</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h5>Actividades Incluidas</h5>
                    {{-- Usamos la relación singular 'activity' --}}
                    @forelse($membershipPrice->activity as $activity)
                        <div class="mb-2">
                            <span class="badge bg-info text-dark me-2">
                                {{ $activity->name }}
                            </span>
                            <span class="small text-muted">({{ $activity->pivot->times_per_week }} veces/semana)</span>
                        </div>
                    @empty
                        <p class="text-danger">No hay actividades asociadas a este precio.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('membership_prices.edit', $membershipPrice) }}" class="btn btn-warning me-2">Editar</a>
            <a href="{{ route('membership_prices.index') }}" class="btn btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
@endsection