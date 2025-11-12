@extends('layouts.admin')

@section('title', 'Nueva Inscripción a Actividad')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-plus-circle me-2"></i> Nueva Inscripción a Actividad
            </h5>
            <a href="{{ route('member_activity.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            {{-- Mensajes de error globales --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>¡Atención!</strong> Corrige los errores antes de continuar.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario Principal --}}
            <form action="{{ route('member_activity.store') }}" method="POST">
                @csrf
                {{-- Aquí incluimos el nuevo formulario de etapas --}}
                @include('member_activity.partials.form_stepped', [
                    'members' => $members,
                    'activities' => $activities,
                    'membershipPrices' => $membershipPrices // Se usa en JS
                ])
            </form>
        </div>
    </div>
</div>
@endsection