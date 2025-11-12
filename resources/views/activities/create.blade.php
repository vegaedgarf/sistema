@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Crear Nueva Actividad</h2>

    <form method="POST" action="{{ route('activities.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            @error('description')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="active" id="active" value="1" checked>
            <label class="form-check-label" for="active">
                Activa (Visible para membresías)
            </label>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success me-2">Guardar Actividad</button>
            <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection