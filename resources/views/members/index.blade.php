@extends('layouts.admin')

@section('title', 'Miembros')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Miembros</h5>
        <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Miembro
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Grupo Familiar</th>
                        <th>Estado</th>
                        <th>Fecha Alta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->first_name }}</td>
                            <td>{{ $member->last_name }}</td>
                            <td>{{ $member->dni }}</td>
                            
                           <td>
                                @if($member->currentGroupMembership)
                                    {{-- Usamos ?-> para evitar el crash si el grupo fue borrado --}}
                                    <span class="badge bg-info text-dark">
                                        {{ $member->currentGroupMembership->group?->name ?? 'Grupo Eliminado' }}
                                    </span>
                                @else
                                    <span class="text-muted small">--</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-{{ $member->status === 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td>{{ $member->joined_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i> Ver</a>
                                <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection