@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Gestión de Actividades</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        
        {{-- Formulario de Búsqueda --}}
        <form action="{{ route('activities.index') }}" method="GET" class="d-flex me-3">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Buscar por nombre o descripción..." 
                   value="{{ $search ?? '' }}" 
                   style="width: 300px;">
            <button class="btn btn-outline-secondary ms-2" type="submit">
                <i class="fa fa-search"></i>
            </button>
            {{-- Botón para limpiar la búsqueda si hay un término activo --}}
            @if(isset($search) && $search)
                <a href="{{ route('activities.index') }}" class="btn btn-outline-danger ms-1">
                    <i class="fa fa-times"></i>
                </a>
            @endif
        </form>

        <a href="{{ route('activities.create') }}" class="btn btn-primary">Crear Nueva Actividad</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Creada Por</th>
                <th width="150px">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
            <tr @if(!$activity->active) class="table-secondary" @endif>
                <td>{{ $activity->id }}</td>
                <td>{{ $activity->name }}</td>
                <td>{{ Str::limit($activity->description, 50) }}</td>
                <td>
                    @if($activity->deleted_at)
                        <span class="badge bg-danger">Eliminada</span>
                    @elseif($activity->active)
                        <span class="badge bg-success">Activa</span>
                    @else
                        <span class="badge bg-warning text-dark">Inactiva</span>
                    @endif
                </td>
                {{-- USAR ACCESO CONDICIONAL PARA EVITAR EL ERROR DE NULL --}}
                <td>{{ $activity->createdBy?->name ?? 'N/A' }}</td>
                <td>
                    @if(!$activity->deleted_at)
                        {{-- Botón Show --}}
                        <a href="{{ route('activities.show', $activity) }}" class="btn btn-sm btn-info text-white me-1">Ver</a>
                        {{-- Botón Edit --}}
                        <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                        {{-- Formulario de eliminación (Soft Delete) --}}
                        <form method="POST" action="{{ route('activities.destroy', $activity) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de desactivar esta actividad?')">Eliminar</button>
                        </form>
                    @else
                        <span class="text-muted small">Restaurar/Eliminar Def.</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No se encontraron actividades.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection