@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalle de Inscripción</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Miembro:</strong> {{ $memberActivity->member->first_name }} {{ $memberActivity->member->last_name }}</p>
            <p><strong>Actividad:</strong> {{ $memberActivity->activity->name ?? '-' }}</p>
            <p><strong>Precio / Plan:</strong> {{ $memberActivity->membershipPrice->price_name ?? '-' }}</p>
            <p><strong>Fecha inicio:</strong> {{ $memberActivity->start_date->format('d/m/Y') }}</p>
            <p><strong>Fecha fin:</strong> {{ optional($memberActivity->end_date)->format('d/m/Y') ?? '-' }}</p>
            <p><strong>Monto pagado:</strong> ${{ number_format($memberActivity->amount_paid, 2) }}</p>
            <p><strong>Método de pago:</strong> {{ $memberActivity->payment_method ?? '-' }}</p>
            <p><strong>Notas:</strong> {{ $memberActivity->notes ?? '-' }}</p>
            <hr>
            <p><strong>Creado por:</strong> {{ $memberActivity->createdBy->name ?? 'Sistema' }}</p>
            <p><strong>Última actualización:</strong> {{ $memberActivity->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('member_activity.index') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('member_activity.edit', $memberActivity->id) }}" class="btn btn-primary">Editar</a>
    </div>
</div>
@endsection
