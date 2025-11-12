@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Editar Usuario</h4>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Roles</label>
            <div class="row">
                @foreach ($roles as $role)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" value="{{ $role }}" class="form-check-input" id="role{{ $loop->index }}"
                                {{ in_array($role, $userRoles) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role{{ $loop->index }}">{{ $role }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
