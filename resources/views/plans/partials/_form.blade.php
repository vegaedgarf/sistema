@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error de validación:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- 
  ID "plan-form-app" para que Vue se monte aquí.
  (CORRECCIÓN) Usamos data-attributes para pasar los datos a Vue.
-->
<form 
    action="{{ $plan->id ? route('plans.update', $plan) : route('plans.store') }}" 
    method="POST" 
    id="plan-form-app"
    data-activities='@json($activities)'
    data-initial-details='@json($details)'
>
    @csrf
    @if($plan->id)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Columna Izquierda: Datos del Plan -->
        <div class="col-md-6">
            <h5>1. Datos del Plan</h5>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Plan</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $plan->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $plan->description) }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Precio Actual ($)</label>
                <input type="number" class="form-control" id="price" name="price" 
                       value="{{ old('price', $currentPrice->price) }}" step="0.01" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select class="form-select" name="is_active" required>
                    <option value="1" {{ old('is_active', $plan->is_active ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('is_active', $plan->is_active) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>

        <!-- Columna Derecha: Detalles del Plan (Vue.js) -->
        <div class="col-md-6">
            <h5>2. Actividades y Frecuencia</h5>
            
            <!-- Contenedor para los detalles dinámicos -->
            <div v-if="details.length > 0">
                <div v-for="(detail, index) in details" :key="index" class="row g-2 mb-2 align-items-center">
                    <!-- Input Oculto para el ID (si se está editando) -->
                    <input type="hidden" :name="'details[' + index + '][id]'" v-model="detail.id">

                    <!-- Select de Actividad -->
                    <div class="col-6">
                        <select :name="'details[' + index + '][activity_id]'" 
                                v-model="detail.activity_id" 
                                class="form-select" required>
                            <option value="" disabled>Seleccione actividad...</option>
                            <!-- (CORRECCIÓN) El v-for ahora funcionará -->
                            <option v-for="activity in activities" :value="activity.id" v-text="activity.name"></option>
                        </select>
                    </div>
                    
                    <!-- Input de Frecuencia -->
                    <div class="col-3">
                        <input type="number" :name="'details[' + index + '][times_per_week]'" 
                               v-model.number="detail.times_per_week" 
                               class="form-control" placeholder="Veces/Sem" min="1" max="7" required>
                    </div>

                    <!-- Botón Eliminar -->
                    <div class="col-3">
                        <button type="button" @click="removeDetail(index)" class="btn btn-danger w-100">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="alert alert-warning text-center small">
                Añada al menos una actividad al plan.
            </div>

            <!-- Botón Añadir -->
            <button type="button" @click="addDetail" class="btn btn-outline-success w-100 mt-2">
                <i class="fa fa-plus me-2"></i> Añadir Actividad
            </button>
        </div>
    </div>

    <hr class="my-4">
    
    <div class="d-flex justify-content-end">
        <a href="{{ route('plans.index') }}" class="btn btn-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            {{ $plan->id ? 'Actualizar Plan' : 'Guardar Plan' }}
        </button>
    </div>
</form>