@extends('layouts.admin')

@section('title', 'Inscripciones a Actividades')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-dumbbell me-2"></i> Inscripciones a Actividades</h5>
            <a href="{{ route('member_activity.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Nueva Inscripción
            </a>
        </div>

        {{-- FILTROS --}}
        <div class="card-body border-bottom">
             <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label for="filterMember" class="form-label">Miembro</label>
                    <input type="text" id="filterMember" class="form-control" placeholder="Nombre o apellido">
                </div>
                <div class="col-md-3">
                    <label for="filterActivity" class="form-label">Actividad</label>
                    <input type="text" id="filterActivity" class="form-control" placeholder="Nombre de la actividad">
                </div>
                <div class="col-md-2">
                    <label for="filterFrom" class="form-label">Desde</label>
                    <input type="date" id="filterFrom" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="filterTo" class="form-label">Hasta</label>
                    <input type="date" id="filterTo" class="form-control">
                </div>
                <div class="col-md-2 d-grid">
                    <button id="filterButton" class="btn btn-outline-light bg-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLA AJAX --}}
        <div class="card-body">
            <div class="table-responsive">
                <table id="memberActivityTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Miembro</th>
                            <th>Actividad</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Registrado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
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
    console.log("Cargando DataTable desde:", "{{ route('member_activity.data') }}");

    let table = $('#memberActivityTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
         searching: false,
        ajax: {
            url: "{{ route('member_activity.data') }}",
            data: function (d) {
                d.member = $('#filterMember').val();
                d.activity = $('#filterActivity').val();
                d.from = $('#filterFrom').val();
                d.to = $('#filterTo').val();
            },
            error: function(xhr, error, thrown) {
                console.error("Error AJAX:", xhr.responseText);
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'member', name: 'member' },
            { data: 'activity', name: 'activity' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'amount_paid', name: 'amount_paid' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
            emptyTable: "No hay inscripciones registradas aún"
        },
        order: [[0, 'desc']]
    });

    $('#filterButton').click(function() {
        table.ajax.reload();
    });
});
</script>
@endpush
