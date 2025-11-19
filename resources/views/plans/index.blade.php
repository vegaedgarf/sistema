@extends('layouts.admin')

@section('title', 'Planes y Precios')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Gestión de Planes y Precios</h4>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('plans.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Crear Nuevo Plan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Plan</th>
                        <th>Detalles (Actividades y Frecuencia)</th>
                        <th>Precio Actual</th>
                        <th>Estado</th>
                        <th width="150px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr @if(!$plan->is_active) class="table-secondary opacity-75" @endif>
                        <td>
                            <strong>{{ $plan->name }}</strong>
                            <p class="small text-muted mb-0">{{ Str::limit($plan->description, 60) }}</p>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                @foreach($plan->details as $detail)
                                    <li>
                                        <i class="fa fa-check-circle text-success me-1"></i>
                                        {{ $detail->activity->name ?? 'Actividad eliminada' }} 
                                        (<strong>{{ $detail->times_per_week }}</strong> x semana)
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @php
                                // Buscar el precio actual (válido hoy y sin fecha de fin)
                                $currentPrice = $plan->prices
                                    ->where('valid_from', '<=', now())
                                    ->where(fn($p) => $p->valid_to === null || $p->valid_to >= now())
                                    ->first();
                            @endphp
                            
                            @if($currentPrice)
                                <strong class="fs-5">${{ number_format($currentPrice->price, 2, ',', '.') }}</strong>
                            @else
                                <span class="badge bg-warning text-dark">Sin precio</span>
                            @endif
                        </td>
                        <td>
                            @if($plan->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('plans.edit', $plan) }}" class="btn btn-sm btn-warning me-1" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('plans.destroy', $plan) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro de DESACTIVAR este plan?')">
                                @csrf
                                @method('DELETE')
                                <button type.submit" class="btn btn-sm btn-danger" title="Desactivar">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No se encontraron planes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($plans->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $plans->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection