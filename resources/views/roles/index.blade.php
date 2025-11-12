@extends('layouts.admin')

@section('title', 'Roles')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Roles</h4>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Nuevo Rol</a>

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Permisos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->permissions as $perm)
                                    <span class="badge bg-info text-dark">{{ $perm->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar rol?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No hay roles creados.</td></tr>
                    @endforelse
                </tbody>
            </table>

            @if ($roles->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $roles->links() }}
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
