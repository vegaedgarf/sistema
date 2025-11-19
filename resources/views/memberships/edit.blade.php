@extends('layouts.admin')

@section('title', 'Editar Inscripción')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Editar Inscripción #{{ $membership->id }}</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-warning small">
                <i class="fa fa-exclamation-triangle"></i> Atención: Está editando una inscripción existente. 
                No puede cambiar el miembro ni el plan ni el precio pactado aquí.
            </div>

            <form action="{{ route('memberships.update', $membership) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Miembro</label>
                        <input type="text" class="form-control" value="{{ $membership->member->last_name }} {{ $membership->member->first_name }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Plan</label>
                        <input type="text" class="form-control" value="{{ $membership->plan->name }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $membership->start_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha Fin (Vencimiento)</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $membership->end_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $membership->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="active" {{ $membership->status == 'active' ? 'selected' : '' }}>Activa</option>
                            <option value="expired" {{ $membership->status == 'expired' ? 'selected' : '' }}>Vencida</option>
                            <option value="cancelled" {{ $membership->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <a href="{{ route('memberships.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection