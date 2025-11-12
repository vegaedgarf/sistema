@extends('layouts.admin')

@section('title', 'Contactos de Miembros')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Listado de Contactos</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Agregar Contacto</a>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Miembro</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Relación</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Principal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->member->first_name ?? '-' }} {{ $contact->member->last_name ?? '' }}</td>
                            <td>{{ $contact->first_name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->relationship }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>
                                @if($contact->is_primary)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este contacto?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $contacts->links() }}
        </div>
    </div>
</div>
@endsection
