@extends('layouts.admin')

@section('title', 'Crear Grupo Familiar')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Crear Nuevo Grupo Familiar</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('family_groups.partials._form', [
                'familyGroup' => new \App\Models\FamilyGroup()
            ])
        </div>
    </div>
</div>
@endsection