@extends('layouts.admin')

@section('title', 'Nuevo Ingreso')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white d-flex align-items-center">
            <i class="fa fa-plus-circle me-2"></i> <h6 class="mb-0">Registrar Nuevo Ingreso</h6>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('financial_reports.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Pago</label>
                        <input type="date" name="payment_date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Monto ($)</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Método de Pago</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observaciones</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('financial_reports.index') }}" class="btn btn-secondary me-2">
                        <i class="fa fa-arrow-left me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
