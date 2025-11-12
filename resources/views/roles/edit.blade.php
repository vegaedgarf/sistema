@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Editar Rol</h4>

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del rol</label>
            <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Permisos</label>
            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input"
                                id="perm{{ $permission->id }}"
                                {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
