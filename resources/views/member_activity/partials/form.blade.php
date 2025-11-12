@php
    $isEdit = isset($mode) && $mode === 'edit';
@endphp

<div class="row g-3">
    {{-- Miembro --}}
    <div class="col-md-6">
        <label for="member_id" class="form-label">Miembro</label>
        <select name="member_id" id="member_id" class="form-select @error('member_id') is-invalid @enderror" required {{ $isEdit ? 'disabled' : '' }}>
            <option value="">Seleccione un miembro...</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('member_id', $memberActivity->member_id ?? '') == $member->id ? 'selected' : '' }}>
                    {{ $member->first_name }} {{ $member->last_name }}
                </option>
            @endforeach
        </select>
        @error('member_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Actividad --}}
    <div class="col-md-6">
        <label for="activity_id" class="form-label">Actividad</label>
        <select name="activity_id" id="activity_id" class="form-select @error('activity_id') is-invalid @enderror" required {{ $isEdit ? 'disabled' : '' }}>
            <option value="">Seleccione una actividad...</option>
            @foreach($activities as $activity)
                <option value="{{ $activity->id }}"
                    {{ old('activity_id', $memberActivity->activity_id ?? '') == $activity->id ? 'selected' : '' }}>
                    {{ $activity->name }}
                </option>
            @endforeach
        </select>
        @error('activity_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Fechas --}}
    <div class="col-md-6">
        <label for="start_date" class="form-label">Fecha de Inicio</label>
        <input type="date" name="start_date" id="start_date"
               class="form-control @error('start_date') is-invalid @enderror"
               value="{{ old('start_date', $memberActivity->start_date ?? now()->toDateString()) }}" required>
        @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="end_date" class="form-label">Fecha de Fin</label>
        <input type="date" name="end_date" id="end_date"
               class="form-control @error('end_date') is-invalid @enderror"
               value="{{ old('end_date', $memberActivity->end_date ?? '') }}">
        @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Monto y método --}}
    <div class="col-md-4">
        <label for="amount_paid" class="form-label">Monto Pagado</label>
        <input type="number" step="0.01" name="amount_paid" id="amount_paid"
               class="form-control @error('amount_paid') is-invalid @enderror"
               value="{{ old('amount_paid', $memberActivity->amount_paid ?? '') }}" placeholder="0.00" required>
        @error('amount_paid')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="payment_method" class="form-label">Método de Pago</label>
        <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
            <option value="">Seleccione...</option>
            <option value="efectivo" {{ old('payment_method', $memberActivity->payment_method ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
            <option value="tarjeta" {{ old('payment_method', $memberActivity->payment_method ?? '') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
            <option value="transferencia" {{ old('payment_method', $memberActivity->payment_method ?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
        </select>
        @error('payment_method')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="membership_price_id" class="form-label">Precio Aplicado</label>
        <select name="membership_price_id" id="membership_price_id" class="form-select">
            <option value="">Sin precio específico</option>
            @foreach($membershipPrices as $price)
                <option value="{{ $price->id }}"
                    {{ old('membership_price_id', $memberActivity->membership_price_id ?? '') == $price->id ? 'selected' : '' }}>
{{ $price->activity->pluck('name')->implode(' + ') }} - ${{ number_format($price->price, 2) }}
                </option>
            @endforeach
        </select>
    </div>




    {{-- Notas --}}
    <div class="col-12">
        <label for="notes" class="form-label">Notas</label>
        <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $memberActivity->notes ?? '') }}</textarea>
    </div>
</div>

<div class="mt-4 text-end">
    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> {{ $isEdit ? 'Actualizar Inscripción' : 'Guardar Inscripción' }}
    </button>
</div>