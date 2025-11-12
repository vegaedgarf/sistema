@extends('layouts.admin')

@section('title', 'Agregar Contacto')

@section('content')

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Agregar contacto para {{ $member->first_name }} {{ $member->last_name }}</h5>
        </div>


    <div class="card-body">

        {{-- Mensajes de error del servidor --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ route('contacts.store', $member->id) }}" method="POST" novalidate class="needs-validation">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">Nombre *</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" 
                        value="{{ old('first_name') }}" required maxlength="100">
                    <div class="invalid-feedback">Ingrese el nombre.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">Apellido *</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" 
                        value="{{ old('last_name') }}" required maxlength="100">
                    <div class="invalid-feedback">Ingrese el apellido.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="relationship" class="form-label">Relación *</label>
                    <input type="text" name="relationship" id="relationship" class="form-control" 
                        value="{{ old('relationship') }}" required maxlength="100">
                    <div class="invalid-feedback">Ingrese la relación.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Teléfono *</label>
                    <input type="text" name="phone" id="phone" class="form-control" 
                        value="{{ old('phone') }}" required pattern="[0-9+()\-\s]+" maxlength="50">
                    <div class="invalid-feedback">Ingrese un teléfono válido.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" 
                        value="{{ old('email') }}" maxlength="150">
                    <div class="invalid-feedback">Ingrese un correo electrónico válido.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="is_primary" class="form-label">Contacto principal</label>
                    <select name="is_primary" id="is_primary" class="form-select">
                        <option value="0" {{ old('is_primary') == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('is_primary') == '1' ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
            </div>

       

            <div class="d-flex justify-content-between">
                <a href="{{ route('members.show', $member->id) }}" class="btn btn-secondary">
                    ← Volver al miembro
                </a>
                <button type="submit" class="btn btn-success">Guardar contacto</button>
            </div>
        </form>

    </div>
</div>


</div>

{{-- Validación visual Bootstrap --}}

<script>
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

@endsection
