@extends('layouts.admin') {{-- o el layout que uses --}}

@section('content')
<div class="container py-4">
    <h3>Prueba DataTables AJAX</h3>
    <table id="testTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Miembro</th>
                <th>Actividad</th>
                <th>Creado</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#testTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('test.data') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'member', name: 'member' },
            { data: 'activity', name: 'activity' },
            { data: 'created_at', name: 'created_at' },
        ],
        error: function(xhr) {
            console.error("❌ Error en AJAX:", xhr.responseText);
        }
    });
});
</script>
@endpush
