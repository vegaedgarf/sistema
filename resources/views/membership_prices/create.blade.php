@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Nuevo Precio de Membresía</h2>

    {{-- Se usa JavaScript para filtrar los inputs antes de enviar, cumpliendo la validación estricta --}}
    <form method="POST" action="{{ route('membership_prices.store') }}" id="membershipPriceForm">
        @csrf

        <div class="mb-3">
            <label for="price">Precio <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="valid_from">Válido desde <span class="text-danger">*</span></label>
            <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from', now()->toDateString()) }}" required>
            @error('valid_from')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="valid_to">Válido hasta</label>
            <input type="date" name="valid_to" class="form-control" value="{{ old('valid_to') }}">
            @error('valid_to')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <h5 class="mt-4">Actividades incluidas <span class="text-danger">*</span></h5>
        <p class="text-muted small">Selecciona una actividad y define el número de veces a la semana (requerido).</p>
        
        {{-- Bucle de Actividades --}}
        @foreach($activities as $activity)
            <div class="mb-2 activity-row" data-index="{{ $loop->index }}">
                {{-- Checkbox para indicar si la actividad está seleccionada --}}
                <input type="checkbox" 
                       id="activity_check_{{ $loop->index }}" 
                       class="activity-check" 
                       data-index="{{ $loop->index }}" 
                       {{ old("activities.{$loop->index}.id") ? 'checked' : '' }}>

                <label for="activity_check_{{ $loop->index }}" class="form-check-label me-3">
                    {{ $activity->name }}
                </label>
                
                {{-- Campo Oculto para el ID (se habilita/deshabilita con JS) --}}
                <input type="hidden" 
                       name="activities[{{ $loop->index }}][id]" 
                       value="{{ $activity->id }}" 
                       class="activity-id-input" 
                       data-index="{{ $loop->index }}" 
                       disabled> 
                       
                {{-- Campo para Veces/Semana (se habilita/deshabilita con JS) --}}
                <input type="number" 
                       name="activities[{{ $loop->index }}][times_per_week]" 
                       placeholder="Veces/semana" 
                       min="1" 
                       max="7" 
                       class="form-control d-inline-block times-per-week-input" 
                       data-index="{{ $loop->index }}" 
                       value="{{ old("activities.{$loop->index}.times_per_week") }}"
                       style="width: 120px;" 
                       disabled>

                @error("activities.{$loop->index}.times_per_week")
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
        
        <div class="mt-3">
            <button type="submit" class="btn btn-success me-2">Guardar</button>
            {{-- Botón Cancelar añadido --}}
            <a href="{{ route('membership_prices.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

{{-- BLOQUE DE JAVASCRIPT PARA MANEJAR LA LÓGICA DE VALIDACIÓN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('membershipPriceForm');
    const activityCheckboxes = form.querySelectorAll('.activity-check');
    const timesPerWeekInputs = form.querySelectorAll('.times-per-week-input');

    // 1. Función para habilitar/deshabilitar campos
    function toggleInputs(index, enable) {
        const idInput = form.querySelector(`.activity-id-input[data-index="${index}"]`);
        const tpwInput = form.querySelector(`.times-per-week-input[data-index="${index}"]`);
        
        if (idInput && tpwInput) {
            idInput.disabled = !enable;
            tpwInput.disabled = !enable;
            if (enable) {
                // El campo times_per_week es requerido solo si la actividad está seleccionada
                tpwInput.setAttribute('required', 'required'); 
            } else {
                tpwInput.removeAttribute('required');
                tpwInput.value = ''; // Limpiar si se deshabilita
            }
        }
    }

    // 2. Event Listeners para checkboxes
    activityCheckboxes.forEach(checkbox => {
        const index = checkbox.dataset.index;
        
        // Estado inicial
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