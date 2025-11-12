@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Editar Permiso</h4>

    <form action="{{ route('permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del permiso</label>
            <input type="text" name="name" id="name" value="{{ $permission->name }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
