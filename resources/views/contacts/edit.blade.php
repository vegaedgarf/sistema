@extends('layouts.admin')

@section('title', 'Editar contacto')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Editar contacto de {{ $member->first_name }} {{ $member->last_name }}</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups...</strong> Corrige los siguientes errores:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contacts.update', ['member' => $member->id, 'contact' => $contact->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">Nombre</label>
                <input type="text" name="first_name" id="first_name"
                       class="form-control @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name', $contact->first_name) }}" required>
            </div>

            <div class="col-md-6">
                <label for="last_name" class="form-label">Apellido</label>
                <input type="text" name="last_name" id="last_name"
                       class="form-control @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name', $contact->last_name) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="relationship" class="form-label">Relación</label>
                <input type="text" name="relationship" id="relationship"
                       class="form-control @error('relationship') is-invalid @enderror"
                       value="{{ old('relationship', $contact->relationship) }}" required>
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" name="phone" id="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $contact->phone) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $contact->email) }}">
            </div>

        <div class="col-md-6 d-flex align-items-center">
                <div class="form-check mt-3">
                    
                    <input type="hidden" name="is_primary" value="0">
                    
                    <input type="checkbox" name="is_primary" id="is_primary" class="form-check-input" value="1"
                        {{ 
                            // Prioriza el valor antiguo (si hubo un error de validación)
                            // Si no hay old, usa el valor actual del contacto
                            old('is_primary', $contact->is_primary) ? 'checked' : '' 
                        }}>
                    
                    <label for="is_primary" class="form-check-label">Contacto principal</label>
                </div>
            </div>
    

    <div class="d-flex justify-content-end">
                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
    </form>
</div>
@endsection
