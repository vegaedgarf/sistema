@extends('layouts.admin')

@section('title', 'Editar Miembro')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Editar miembro: {{ $member->first_name }} {{ $member->last_name }}</h5>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="first_name" class="form-label">Nombre</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}"
                           class="form-control @error('first_name') is-invalid @enderror" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="last_name" class="form-label">Apellido</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}"
                           class="form-control @error('last_name') is-invalid @enderror" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" id="dni" name="dni" value="{{ old('dni', $member->dni) }}"
                           class="form-control @error('dni') is-invalid @enderror" required>
                    @error('dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $member->birth_date?->format('Y-m-d')) }}"
                           class="form-control @error('birth_date') is-invalid @enderror">
                    @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $member->address) }}"
                           class="form-control @error('address') is-invalid @enderror">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $member->phone) }}"
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="joined_at" class="form-label">Fecha de Alta</label>
                    <input type="date" id="joined_at" name="joined_at"
                           value="{{ old('joined_at', $member->joined_at?->format('Y-m-d')) }}"
                           class="form-control @error('joined_at') is-invalid @enderror" required>
                    @error('joined_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label for="observations" class="form-label">Observaciones</label>
                    <textarea id="observations" name="observations" rows="3"
                              class="form-control @error('observations') is-invalid @enderror">{{ old('observations', $member->observations) }}</textarea>
                    @error('observations')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Estado</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="activo" {{ old('status', $member->status) === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('status', $member->status) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="suspendido" {{ old('status', $member->status) === 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3">Gestión de Grupo</h5>
            <div class="row">
                <div class="col-md-6">
                    <label for="family_group_id" class="form-label">Grupo Familiar Asignado</label>
                    <select class="form-select" id="family_group_id" name="family_group_id">
                        <option value="">[Sin Grupo]</option>
                        
                        @php
                            // Esta variable $familyGroups viene de MemberController@edit
                            // Esta variable $member->currentGroupMembership viene de MemberController@edit
                            $currentGroupId = $member->currentGroupMembership?->family_group_id;
                        @endphp

                        @foreach($familyGroups as $group)
                            <option value="{{ $group->id }}" 
                                {{ old('family_group_id', $currentGroupId) == $group->id ? 'selected' : '' }}
                            >
                                {{ $group->name }} ({{ $group->discount_percentage }}% Dto.)
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">
                        Cambiar de grupo mantendrá el historial del grupo anterior.
                    </div>
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('members.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection