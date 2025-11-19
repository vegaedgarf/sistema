@extends('layouts.admin')

@section('title', 'Membresías')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Membresías (Inscripciones)</h4>
        <a href="{{ route('memberships.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Nueva Inscripción
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Miembro</th>
                            <th>Plan</th>
                            <th>Vigencia</th>
                            <th>Precio Acordado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($memberships as $membership)
                            <tr>
                                <td>{{ $membership->id }}</td>
                                <td>
                                    <a href="{{ route('members.show', $membership->member_id) }}" class="fw-bold text-decoration-none">
                                        {{ $membership->member->last_name }}, {{ $membership->member->first_name }}
                                    </a>
                                    <br><small class="text-muted">{{ $membership->member->dni }}</small>
                                </td>
                                <td>{{ $membership->plan->name }}</td>
                                <td>
                                    {{ $membership->start_date->format('d/m/y') }} <i class="fa fa-arrow-right small mx-1"></i> {{ $membership->end_date->format('d/m/y') }}
                                </td>
                                <td>
                                    $ {{ number_format($membership->final_price, 2, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $badges = [
                                            'pending' => 'bg-warning text-dark',
                                            'active' => 'bg-success',
                                            'expired' => 'bg-secondary',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        $labels = [
                                            'pending' => 'Pendiente Pago',
                                            'active' => 'Activa',
                                            'expired' => 'Vencida',
                                            'cancelled' => 'Cancelada'
                                        ];
                                    @endphp
                                    <span class="badge {{ $badges[$membership->status] ?? 'bg-secondary' }}">
                                        {{ $labels[$membership->status] ?? $membership->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('memberships.show', $membership) }}" class="btn btn-sm btn-info text-white me-1" title="Ver Detalle">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('memberships.edit', $membership) }}" class="btn btn-sm btn-warning" title="Editar Fechas/Estado">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No hay inscripciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $memberships->links() }}
            </div>
        </div>
    </div>
</div>
@endsection