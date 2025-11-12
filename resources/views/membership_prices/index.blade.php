@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Listado de Precios de Membresía (Activos)</h2>
     
  <h3>queda pendiente resolver la parte de que no se pueda eliminar un precio que esta en uso actualmente rompe la coherencia de la bd</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        {{-- Enlace al Histórico --}}
        <a href="{{ route('membership_prices.history') }}" class="btn btn-danger">
            <i class="fa fa-history me-2"></i> Ver Histórico
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
                <th>Actividades Incluidas</th>
                <th width="150px">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($membershipPrices as $price)
            {{-- La clase table-success resalta que el precio está activo --}}
            <tr class="table-success"> 
                <td>{{ $price->id }}</td>
                <td><span class="badge bg-success fs-6">${{ number_format($price->price, 2) }}</span></td>
                <td>{{ $price->valid_from->format('d/m/Y') }}</td>
                <td>{{ $price->valid_to ? $price->valid_to->format('d/m/Y') : 'Ilimitado' }}</td>
                <td>
                    {{-- CORRECCIÓN: Accedemos al dato pivote 'times_per_week' --}}
                    @foreach($price->activity as $activity)
                        <span class="badge bg-info text-dark me-1">
                            {{ $activity->name }} ({{ $activity->pivot->times_per_week }} veces/semana)
                        </span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('membership_prices.show', $price) }}" class="btn btn-sm btn-info text-white me-1">Ver</a>
                    <a href="{{ route('membership_prices.edit', $price) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                    <form method="POST" action="{{ route('membership_prices.destroy', $price) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        {{-- Cambié el confirm a un modal de ejemplo, recuerda que 'confirm()' no funciona en iframes --}}
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este precio?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No se encontraron precios de membresía activos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    {{-- AÑADIDO: Bloque de Paginación --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $membershipPrices->links() }}
    </div>

</div>
@endsection