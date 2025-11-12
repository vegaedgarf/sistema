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
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Fecha Alta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            {{-- ✅ Usando first_name --}}
                            <td>{{ $member->first_name }}</td>
                            {{-- ✅ Usando last_name --}}
                            <td>{{ $member->last_name }}</td>
                            <td>{{ $member->dni }}</td>
                            <td>{{ $member->email }}</td>
                            {{-- ✅ Usando phone --}}
                            <td>{{ $member->phone }}</td>
                            <td>
                                {{-- ✅ Usando status --}}
                                <span class="badge bg-{{ $member->status === 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            {{-- ✅ Usando joined_at (con formateo Carbon directo) --}}
                            <td>{{ $member->joined_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i>ver</a>
                                <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i>Editar</a>
                               <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar al miembro {{ $member->first_name }} {{ $member->last_name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>Eliminar
                                    </button>
                                </form>
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
