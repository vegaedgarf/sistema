@extends('layouts.admin')

@section('title', 'Test Members')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i> Listado de Miembros (Prueba)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="testMembersTable" class="table table-striped table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody></tbody> {{-- importante --}}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    console.log("Iniciando DataTable...");

    $('#testMembersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('test-members/data') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'email', name: 'email' }
        ],
        order: [[0, 'asc']],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        initComplete: function(settings, json) {
            console.log("DataTable cargado correctamente:", json);
        },
        error: function(xhr, error, thrown) {
            console.error("Error cargando DataTable:", xhr.responseText);
        }
    });
});
</script>
@endpush

