@extends('layouts.admin')

@section('title', 'Editar Ingreso')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fa fa-pen-to-square me-2"></i> <h6 class="mb-0">Editar Ingreso</h6>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('financial_reports.update', $payment->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Pago</label>
                        <input type="date" name="payment_date" value="{{ $payment->payment_date->format('Y-m-d') }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Monto ($)</label>
                        <input type="number" step="0.01" name="amount" value="{{ $payment->amount }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Método de Pago</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="efectivo" {{ $payment->payment_method == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="tarjeta" {{ $payment->payment_method == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ $payment->payment_method == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observaciones</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $payment->notes }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('financial_reports.index') }}" class="btn btn-secondary me-2">
                        <i class="fa fa-arrow-left me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
