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

<form 
    action="{{ $familyGroup->id ? route('family-groups.update', $familyGroup) : route('family-groups.store') }}" 
    method="POST" 
>
    @csrf
    @if($familyGroup->id)
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-8">
            <h5>Datos del Grupo</h5>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Grupo</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $familyGroup->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="discount_percentage" class="form-label">Porcentaje de Descuento (%)</label>
                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" 
                       value="{{ old('discount_percentage', $familyGroup->discount_percentage) }}" 
                       step="0.01" min="0" max="100" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select class="form-select" name="is_active" required>
                    <option value="1" {{ old('is_active', $familyGroup->is_active ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('is_active', $familyGroup->is_active) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>

        </div>

    <hr class="my-4">
    
    <div class="d-flex justify-content-end">
        <a href="{{ route('family-groups.index') }}" class="btn btn-secondary me-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            {{ $familyGroup->id ? 'Actualizar Grupo' : 'Guardar Grupo' }}
        </button>
    </div>
</form>