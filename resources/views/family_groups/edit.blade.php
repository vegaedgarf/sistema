@extends('layouts.admin')

@section('title', 'Editar Grupo Familiar')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Editar Grupo: {{ $familyGroup->name }}</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('family_groups.partials._form', [
                'familyGroup' => $familyGroup
            ])
        </div>
    </div>
</div>
@endsection