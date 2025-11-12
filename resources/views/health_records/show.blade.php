@extends('layouts.admin')

@section('title', 'Ficha Médica')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 mb-3">Ficha Médica — {{ $member->first_name }} {{ $member->last_name }}</h4>

    @if ($healthRecord)
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <span><i class="fas fa-notes-medical me-2"></i>Detalles de Ficha Médica</span>
                <div>
                    <a href="{{ route('health_records.edit', [$member->id, $healthRecord->id]) }}" class="btn btn-warning btn-sm me-2"><i class="fas fa-edit"></i> Editar</a>
                    <form action="{{ route('health_records.destroy', [$member->id, $healthRecord->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta ficha médica?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Tipo de Sangre</th><td>{{ $healthRecord->blood_type ?? '-' }}</td></tr>
                    <tr><th>Altura</th><td>{{ $healthRecord->height ? $healthRecord->height . ' cm' : '-' }}</td></tr>
                    <tr><th>Peso</th><td>{{ $healthRecord->weight ? $healthRecord->weight . ' kg' : '-' }}</td></tr>
                    <tr><th>Alergias</th><td>{{ $healthRecord->allergies ?? '-' }}</td></tr>
                    <tr><th>Lesiones</th><td>{{ $healthRecord->injuries ?? '-' }}</td></tr>
                    <tr><th>Condiciones Médicas</th><td>{{ $healthRecord->medical_conditions ?? '-' }}</td></tr>
                    <tr><th>Medicaciones</th><td>{{ $healthRecord->medications ?? '-' }}</td></tr>
                    <tr><th>Observaciones</th><td>{{ $healthRecord->observations ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Este miembro no tiene ficha médica registrada.
            <a href="{{ route('health_records.create', $member->id) }}" class="btn btn-primary btn-sm ms-2">Crear Ficha Médica</a>
        </div>
    @endif

      <div class="mt-3">
        <a href="{{ route('members.show', ['member' => $member->id]) }}" class="btn btn-secondary">← Volver al listado</a>
    </div>
</div>
@endsection
