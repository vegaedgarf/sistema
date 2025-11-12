@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    {{-- CORRECCIÓN: Se usa $membershipPrice --}}
    <h2>Editar Precio de Membresía: #{{ $membershipPrice->id }}</h2>

    <form method="POST" action="{{ route('membership_prices.update', $membershipPrice) }}" id="membershipPriceForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="price">Precio</label>
            <input type="number" step="0.01" name="price" class="form-control" 
                   value="{{ old('price', $membershipPrice->price) }}" required>
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="valid_from">Válido desde</label>
            {{-- CORRECCIÓN: Se usa $membershipPrice --}}
            <input type="date" name="valid_from" class="form-control" 
                   value="{{ old('valid_from', $membershipPrice->valid_from->toDateString()) }}" required>
            @error('valid_from')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="valid_to">Válido hasta</label>
            {{-- CORRECCIÓN: Se usa $membershipPrice --}}
            <input type="date" name="valid_to" class="form-control" 
                   value="{{ old('valid_to', $membershipPrice->valid_to ? $membershipPrice->valid_to->toDateString() : '') }}">
            @error('valid_to')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <h5 class="mt-4">Actividades incluidas</h5>

        {{-- Crear un array de IDs de actividades asociadas para una búsqueda rápida --}}
        @php
            $associatedActivities = $membershipPrice->activity->keyBy('id'); // CORRECCIÓN: Se usa $membershipPrice
        @endphp
        
        @foreach($activities as $activity)
            @php
                $index = $loop->index;
                $isAssociated = $associatedActivities->has($activity->id);
                $timesPerWeekValue = $isAssociated ? $associatedActivities[$activity->id]->pivot->times_per_week : '';
                
                // Usar old() si hay un error de validación
                $oldChecked = old("activities.{$index}.id") !== null;
                $oldTimesPerWeek = old("activities.{$index}.times_per_week", $timesPerWeekValue);

                // Determinar el estado 'checked' (old tiene prioridad)
                $isChecked = $oldChecked || ($oldChecked === false && $isAssociated);
                if (old('activities') === null) {
                    // Si no hay errores de validación, usar el estado de la BD
                    $isChecked = $isAssociated;
                }
            @endphp

            <div class="mb-2 activity-row" data-index="{{ $index }}">
                {{-- Checkbox para indicar si la actividad está seleccionada --}}
                <input type="checkbox" 
                       id="activity_check_{{ $index }}" 
                       class="activity-check" 
                       data-index="{{ $index }}" 
                       {{ $isChecked ? 'checked' : '' }}>

                <label for="activity_check_{{ $index }}" class="form-check-label me-3">
                    {{ $activity->name }}
                </label>
                
                {{-- Campo Oculto para el ID (se habilita/deshabilita con JS) --}}
                <input type="hidden" 
                       name="activities[{{ $index }}][id]" 
                       value="{{ $activity->id }}" 
                       class="activity-id-input" 
                       data-index="{{ $index }}" 
                       disabled> 
                       
                {{-- Campo para Veces/Semana (se habilita/deshabilita con JS) --}}
                <input type="number" 
                       name="activities[{{ $index }}][times_per_week]" 
                       placeholder="Veces/semana" 
                       min="1" 
                       max="7" 
                       class="form-control d-inline-block times-per-week-input" 
                       data-index="{{ $index }}" 
                       value="{{ $oldTimesPerWeek }}"
                       style="width: 120px;" 
                       disabled>

                @error("activities.{$index}.times_per_week")
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-success mt-3">Actualizar</button>
        <a href="{{ route('membership_prices.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

{{-- BLOQUE DE JAVASCRIPT PARA MANEJAR LA LÓGICA DE VALIDACIÓN (Igual que en 'create') --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('membershipPriceForm');
    const activityCheckboxes = form.querySelectorAll('.activity-check');
    const timesPerWeekInputs = form.querySelectorAll('.times-per-week-input');

    // 1. Función para habilitar/deshabilitar campos y setear 'required'
    function toggleInputs(index, enable) {
        const idInput = form.querySelector(`.activity-id-input[data-index="${index}"]`);
        const tpwInput = form.querySelector(`.times-per-week-input[data-index="${index}"]`);
        
        if (idInput && tpwInput) {
            idInput.disabled = !enable;
            tpwInput.disabled = !enable;
            
            if (enable) {
                tpwInput.setAttribute('required', 'required');
            } else {
                tpwInput.removeAttribute('required');
                if (!form.querySelector(`.activity-check[data-index="${index}"]`).checked) {
                    tpwInput.value = '';
                }
            }
        }
    }

    // 2. Manejo de estado inicial y Event Listeners para checkboxes
    activityCheckboxes.forEach(checkbox => {
        const index = checkbox.dataset.index;
        toggleInputs(index, checkbox.checked);

        checkbox.addEventListener('change', function() {
            toggleInputs(this.dataset.index, this.checked);
        });
    });

    // 3. Event Listeners para campos Veces/Semana
    timesPerWeekInputs.forEach(input => {
        input.addEventListener('input', function() {
            const index = this.dataset.index;
            const checkbox = form.querySelector(`.activity-check[data-index="${index}"]`);
            
            if (this.value > 0) {
                checkbox.checked = true;
                toggleInputs(index, true); 
            } else if (this.value === '') {
                checkbox.checked = false;
                toggleInputs(index, false);
            }
        });
    });
});
</script>
@endsection