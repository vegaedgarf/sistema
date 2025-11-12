@extends('layouts.admin')

@section('title', 'Editar Inscripción a Actividad')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i> Editar Inscripción
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

            {{-- Formulario --}}
            <form action="{{ route('member_activity.update', $memberActivity->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('member_activity.partials.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</div>
@endsection
