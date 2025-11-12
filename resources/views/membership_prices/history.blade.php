@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-danger">Precios de Membresía Históricos</h2>
    <p class="text-muted">Estos son los precios que ya no están vigentes, o cuya fecha de inicio es futura.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('membership_prices.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-2"></i> Volver a Precios Activos
        </a>
        <a href="{{ route('membership_prices.create') }}" class="btn btn-primary">Crear Nuevo Precio</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Precio</th>
                <th>Vigente Desde</th>
                <th>Vigente Hasta</th>
                <th>Actividades</th>
                <th>Estado</th>
                <th width="180px">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historicalPrices as $price)
            {{-- Determinamos si el registro está expirado (Vigente Hasta <= Hoy) --}}
            @php
                $isExpired = $price->valid_to && $price->valid_to->lte(now());
            @endphp

            <tr class="{{ $isExpired ? 'table-secondary' : 'table-info' }}">
                <td>{{ $price->id }}</td>
                <td><span class="badge bg-danger fs-6">${{ number_format($price->price, 2) }}</span></td>
                <td>{{ $price->valid_from->format('d/m/Y') }}</td>
                <td>{{ $price->valid_to ? $price->valid_to->format('d/m/Y') : 'N/A' }}</td>
                <td>
                     {{-- CORRECCIÓN: Accedemos al dato pivote 'times_per_week' --}}
                    @foreach($price->activity as $activity)
                        <span class="badge bg-secondary me-1">
                            {{ $activity->name }} ({{ $activity->pivot->times_per_week }} veces/semana)
                        </span>
                    @endforeach



                </td>
                <td>
                    @if($isExpired)
                        <span class="badge bg-dark">Expirado (Fijo)</span>
                    @elseif($price->valid_from->gt(now()))
                        <span class="badge bg-info text-dark">Vigencia Futura</span>
                    @endif
                </td>
                <td>
                    {{-- Botón Show siempre visible --}}
                    <a href="{{ route('membership_prices.show', $price) }}" class="btn btn-sm btn-info text-white me-1">Ver</a>

                    @if($isExpired)
                        {{-- Los precios expirados no se pueden modificar ni eliminar --}}
                        <button class="btn btn-sm btn-light text-dark" disabled>Histórico</button>
                    @else
                        {{-- Permitimos editar y eliminar precios de vigencia futura --}}
                        <a href="{{ route('membership_prices.edit', $price) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                        <form method="POST" action="{{ route('membership_prices.destroy', $price) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este precio futuro?')">Eliminar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No hay precios históricos o futuros registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Bloque de Paginación --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $historicalPrices->links() }}
    </div>

</div>
@endsection