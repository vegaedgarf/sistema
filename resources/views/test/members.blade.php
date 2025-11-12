@extends('layouts.admin')

@section('title', 'Prueba DataTable - Miembros')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Prueba de tabla con AJAX (Miembros)</h3>

    <table id="testTable" class="table table-bordered table-striped w-100">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Creado</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    console.log("Ruta AJAX:", "{{ route('test.members.data') }}");

    $('#testTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('test.members.data') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'email', name: 'email' }
            ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});
</script>
@endpush
