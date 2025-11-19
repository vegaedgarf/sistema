@extends('layouts.admin')

@section('title', 'Detalle del Miembro')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalle del Miembro</h4>
        </div>

        <div class="card-body">
            {{-- Información del miembro (campos en inglés, etiquetas en español) --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nombre:</strong> {{ $member->first_name }} {{ $member->last_name }}
                </div>
                <div class="col-md-3">
                    <strong>DNI:</strong> {{ $member->dni }}
                </div>
                <div class="col-md-3">
                    <strong>Estado:</strong>
                    {{-- Corregido: tu enum es 'activo' no 'active' --}}
                    <span class="badge bg-{{ $member->status === 'activo' ? 'success' : ($member->status === 'suspendido' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($member->status) }}
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4"><strong>Teléfono:</strong> {{ $member->phone ?? '-' }}</div>
                <div class="col-md-4"><strong>Email:</strong> {{ $member->email ?? '-' }}</div>
                    
            <div class="col-md-4">
                    <strong>Grupo Familiar:</strong>
                    @if($member->currentGroupMembership)
                        <span class="badge bg-info text-dark">{{ $member->currentGroupMembership->group?->name }}</span>
                    @else
                    <span class="text-muted small">Sin grupo</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4"><strong>Dirección:</strong> {{ $member->address ?? '-' }}</div>
                <div class="col-md-4"><strong>Fecha de nacimiento:</strong> {{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('d/m/Y') : '-' }}</div>
                <div class="col-md-4"><strong>Inicio de membresía:</strong> {{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d/m/Y') : '-' }}</div>
                {{-- Nota: 'membership_expires_at' no está en tu migración de 'corpo_members' --}}
                {{-- <div class="col-md-4"><strong>Vencimiento:</strong> {{ $member->membership_expires_at ? \Carbon\Carbon::parse($member->membership_expires_at)->format('d/m/Y') : '-' }}</div> --}}
            </div>

            <div class="mt-3">
                <strong>Observaciones:</strong>
                <div class="border rounded p-2 bg-light" style="min-height:60px;">
                    {{ $member->observations ?? '—' }}
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Contactos del Miembro</h5>

            {{-- Usamos ruta plana contacts.create y pasamos member_id como query --}}
            <a href="{{ route('contacts.create', $member->id) }}" class="btn btn-light btn-sm">
                ➕ Agregar Contacto
            </a>
        </div>

        <div class="card-body">
            @if (session('success_contact')) {{-- Usar un session key diferente es buena idea --}}
                <div class="alert alert-success">{{ session('success_contact') }}</div>
            @endif

            @if ($member->contacts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Relación</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Principal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member->contacts as $contact)
                                <tr>
                                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                    <td>{{ $contact->relationship ?? '-' }}</td>
                                    <td>{{ $contact->phone ?? '-' }}</td>
                                    <td>{{ $contact->email ?? '-' }}</td>
                                    <td>
                                        @if ($contact->is_primary)
                                            <span class="badge bg-success">Sí</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('contacts.edit', ['member' => $member->id, 'contact' => $contact->id]) }}" 
                                           class="btn btn-warning btn-sm">
                                            ✏️  Editar
                                        </a>
                                        <form action="{{ route('contacts.destroy', ['member' => $member->id, 'contact' => $contact->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este contacto?')">🗑️ Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No hay contactos registrados para este miembro.</p>
            @endif
        </div>
    </div>
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-notes-medical me-2 text-primary"></i>Ficha Médica</h5>

            @if ($member->healthRecord)
                <div>
                    <a href="{{ route('health_records.show', $member->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-eye me-1"></i> Ver Detalles
                    </a>
                    <a href="{{ route('health_records.edit', [$member->id, $member->healthRecord->id]) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i> Editar
                    </a>
                </div>
            @else
                <a href="{{ route('health_records.create', $member->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Crear Ficha Médica
                </a>
            @endif
        </div>

        <div class="card-body">
            @if ($member->healthRecord)
                <table class="table table-bordered mb-0">
                    <tr><th>Tipo de Sangre</th><td>{{ $member->healthRecord->blood_type ?? '-' }}</td></tr>
                    <tr><th>Peso</th><td>{{ $member->healthRecord->weight ? $member->healthRecord->weight . ' kg' : '-' }}</td></tr>
                    <tr><th>Altura</th><td>{{ $member->healthRecord->height ? $member->healthRecord->height . ' cm' : '-' }}</td></tr>
                    <tr><th>Alergias</th><td>{{ $member->healthRecord->allergies ?? '-' }}</td></tr>
                    <tr><th>Condiciones Médicas</th><td>{{ $member->healthRecord->medical_conditions ?? '-' }}</td></tr>
                </table>
            @else
                <p class="text-muted mb-0">No hay ficha médica registrada para este miembro.</p>
            @endif
        </div>
    </div>
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fa fa-users-rectangle me-2"></i> Historial de Grupos Familiares</h5>
        </div>
        <div class="card-body">
            @if ($member->groupHistory->count() > 0)
                <table class="table table-striped table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Grupo</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member->groupHistory as $membership)
                            <tr>
                                <td>{{ $membership->group->name ?? 'Grupo eliminado' }}</td>
                                <td>{{ $membership->start_date->format('d/m/Y') }}</td>
                                <td>{{ $membership->end_date ? $membership->end_date->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if(is_null($membership->end_date))
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Finalizado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Este miembro no tiene historial de grupos.</p>
            @endif
        </div>
    </div>
    <div class="mt-4 mb-4">
        <a href="{{ route('members.index') }}" class="btn btn-secondary">← Volver al listado</a>
    </div>
</div>
@endsection