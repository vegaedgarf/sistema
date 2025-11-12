@extends('layouts.admin')

@section('title', 'Nuevo Miembro')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Registrar nuevo miembro</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('members.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="first_name" class="form-label">Nombre</label>
                    {{-- ✅ CORREGIDO: name="first_name" --}}
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="last_name" class="form-label">Apellido</label>
                    {{-- ✅ CORREGIDO: name="last_name" --}}
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" id="dni" name="dni" value="{{ old('dni') }}" class="form-control @error('dni') is-invalid @enderror" required>
                    @error('dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                    {{-- ✅ CORREGIDO: name="birth_date" --}}
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" class="form-control @error('birth_date') is-invalid @enderror">
                    @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label for="address" class="form-label">Dirección</label>
                    {{-- ✅ CORREGIDO: name="address" --}}
                    <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="phone" class="form-label">Teléfono</label>
                    {{-- ✅ CORREGIDO: name="phone" --}}
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="joined_at" class="form-label">Fecha de Alta</label>
                    {{-- ✅ CORREGIDO: name="joined_at" --}}
                    <input type="date" id="joined_at" name="joined_at" value="{{ old('joined_at', now()->format('Y-m-d')) }}" class="form-control @error('joined_at') is-invalid @enderror" required>
                    @error('joined_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label for="observations" class="form-label">Observaciones</label>
                    {{-- ✅ CORREGIDO: name="observations" --}}
                    <textarea id="observations" name="observations" rows="3" class="form-control @error('observations') is-invalid @enderror">{{ old('observations') }}</textarea>
                    @error('observations')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Estado</label>
                    {{-- ✅ CORREGIDO: name="status" --}}
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="activo" {{ old('status', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('status') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="suspendido" {{ old('status') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('members.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
