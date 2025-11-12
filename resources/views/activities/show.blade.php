@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Detalles de la Actividad: {{ $activity->name }}</h4>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $activity->id }}</p>
            <p><strong>Descripción:</strong></p>
            <div class="alert alert-light border">{{ $activity->description ?? 'Sin descripción.' }}</div>
            
            <p><strong>Estado:</strong> 
                @if($activity->active)
                    <span class="badge bg-success">Activa</span>
                @else
                    <span class="badge bg-warning text-dark">Inactiva</span>
                @endif
            </p>
            
            <hr>
            
            <p class="small text-muted"><strong>Creada:</strong> {{ $activity->created_at->format('d/m/Y H:i') }} por {{ $activity->createdBy->name ?? 'N/A' }}</p>
            <p class="small text-muted"><strong>Última Actualización:</strong> {{ $activity->updated_at->format('d/m/Y H:i') }} por {{ $activity->updatedBy->name ?? 'N/A' }}</p>

            @if($activity->deleted_at)
                <p class="text-danger small">Soft Deleted: {{ $activity->deleted_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-warning me-2">Editar</a>
            <a href="{{ route('activities.index') }}" class="btn btn-secondary">Volver al listado</a>
        </div>
    </div>
</div>
@endsection