@extends('layouts.admin')

@section('title', 'Grupos Familiares')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Gestión de Grupos Familiares (Descuentos)</h4>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('family-groups.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Crear Nuevo Grupo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Grupo</th>
                        <th>Descuento Aplicado</th>
                        <th class="text-center">Miembros</th>
                        <th>Estado</th>
                        <th width="150px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                    <tr @if(!$group->is_active) class="table-secondary opacity-75" @endif>
                        <td>
                            <strong>{{ $group->name }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark fs-6">{{ $group->discount_percentage }}%</span>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $group->current_members_count }}</span>
                        </td>
                        
                        <td>
                            @if($group->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>

                            <a href="{{ route('family-groups.show', $group) }}" class="btn btn-sm btn-info text-white me-1" title="Ver Miembros">
                            <i class="fa fa-eye"></i>
                            </a>

                            
                            <a href="{{ route('family-groups.edit', $group) }}" class="btn btn-sm btn-warning me-1" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('family-groups.destroy', $group) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro de ELIMINAR este grupo? Perderá la asociación con sus miembros.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No se encontraron grupos familiares.</td>
                    </tr>
                    @endForelse
                </tbody>
            </table>

            @if ($groups->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $groups->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection