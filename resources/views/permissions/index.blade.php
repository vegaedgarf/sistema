@extends('layouts.admin')

@section('title', 'Permisos')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Listado de Permisos</h4>

    <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">Nuevo Permiso</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este permiso?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($permissions->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $permissions->links() }}
            </div>
        @endif

        </div>
    </div>
</div>
@endsection
