@extends('layouts.admin')

@section('title', 'Nueva Ficha Médica')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 mb-3">Ficha Médica de {{ $member->first_name }} {{ $member->last_name }}</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-notes-medical me-2"></i>Registrar nueva ficha médica
        </div>
        <div class="card-body">
            <form action="{{ route('health_records.store', $member->id) }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de Sangre</label>
                        <input type="text" name="blood_type" class="form-control" value="{{ old('blood_type') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Altura (cm)</label>
                        <input type="number" step="0.01" name="height" class="form-control" value="{{ old('height') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Peso (kg)</label>
                        <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alergias</label>
                    <textarea name="allergies" class="form-control">{{ old('allergies') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lesiones</label>
                    <textarea name="injuries" class="form-control">{{ old('injuries') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Condiciones Médicas</label>
                    <textarea name="medical_conditions" class="form-control">{{ old('medical_conditions') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Medicaciones</label>
                    <textarea name="medications" class="form-control">{{ old('medications') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observations" class="form-control">{{ old('observations') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Ficha</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
