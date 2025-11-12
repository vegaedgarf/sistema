@php
    // Título: Formulario de Inscripción por Etapas con AJAX
    // Archivo: resources/views/member_activity/partials/form_stepped.blade.php
    $isEdit = isset($mode) && $mode === 'edit';
    
    /**
     * CORRECCIÓN: Objeto de seguridad para el modo 'create'.
     * Si $memberActivity no está definida (o es null), crea un objeto temporal 
     * que simula las propiedades y el método activities() de tu modelo.
     */
    $memberActivity = $memberActivity ?? new class { 
        public $member_id = null;
        public $start_date = null;
        public $end_date = null;
        public $amount_paid = null;
        public $payment_method = null;
        public $notes = null;
        public $membership_price_id = null;
        // Método de relación que devuelve una colección vacía para evitar errores de pluck
        public function activities() { return collect([]); } 
    };
@endphp

{{-- **IMPORTANTE: Se requiere jQuery, Bootstrap y FontAwesome para el diseño y el JS** --}}
<div id="registration-form" class="row g-4">
    
    {{-- =================================== --}}
    {{-- ETAPA 1: BÚSQUEDA DEL MIEMBRO (AJAX) --}}
    {{-- =================================== --}}
    <div class="col-12 border-bottom pb-3 mb-3">
        <h4><i class="fas fa-user-circle me-2"></i> 1. Seleccionar Miembro</h4>
        
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="search_dni" class="form-label">Buscar por DNI</label>
                <input type="text" id="search_dni" class="form-control member-search-input" placeholder="Escriba el DNI..." autocomplete="off">
            </div>
            <div class="col-md-4">
                <label for="search_apellido" class="form-label">Buscar por Apellido</label>
                <input type="text" id="search_apellido" class="form-control member-search-input" placeholder="Escriba el Apellido..." autocomplete="off">
            </div>
            <div class="col-md-4">
                <label for="search_nombre" class="form-label">Buscar por Nombre</label>
                <input type="text" id="search_nombre" class="form-control member-search-input" placeholder="Escriba el Nombre..." autocomplete="off">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 position-relative">
                <div id="member-search-results" class="list-group position-absolute w-100 z-10 shadow" style="max-height: 200px; overflow-y: auto; display: none;">
                    {{-- Resultados de búsqueda se cargarán aquí --}}
                </div>

                {{-- Campo oculto para guardar el ID del miembro seleccionado --}}
                <input type="hidden" name="member_id" id="member_id" value="{{ old('member_id', $memberActivity->member_id) }}">
                
                @error('member_id')
                    <div class="alert alert-danger mt-2">Debe seleccionar un miembro.</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <span id="member-info" class="badge bg-primary text-white p-3 shadow-sm" style="display: {{ old('member_id', $memberActivity->member_id) ? 'inline-block' : 'none' }};">
                    Miembro Seleccionado: 
                    <span id="selected-member-name" class="fw-bold">
                        {{ old('member_id', $memberActivity->member_id) ? 'ID: ' . old('member_id', $memberActivity->member_id) : '' }}
                    </span>
                    <button type="button" id="clear-member" class="btn-close btn-close-white ms-2" aria-label="Limpiar"></button>
                </span>
            </div>
        </div>
    </div>
    
    {{-- =================================== --}}
    {{-- ETAPA 2: SELECCIÓN DE ACTIVIDADES --}}
    {{-- =================================== --}}
    <div id="step-activities" class="col-12" style="display:{{ old('member_id', $memberActivity->member_id) ? 'block' : 'none' }};">
        <h4><i class="fas fa-list-check me-2"></i> 2. Seleccionar Actividades</h4>
        <p class="text-muted">Elige una o varias actividades. Al presionar Siguiente, se cargarán los combos.</p>
        
        <div id="activities-container" class="row">
            @foreach($activities as $activity)
                <div class="col-md-4 mb-3">
                    <div class="form-check border p-3 rounded shadow-sm bg-light">
                        <input class="form-check-input activity-checkbox" type="checkbox" 
                               value="{{ $activity->id }}" id="activity_{{ $activity->id }}" 
                               data-activity-name="{{ $activity->name }}" 
                               {{ in_array($activity->id, old('activity_ids', $memberActivity->activities()->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="activity_{{ $activity->id }}">
                            {{ $activity->name }}
                        </label>
                    </div>
                </div>
            @endforeach
            <input type="hidden" name="selected_activities_ids" id="selected_activities_ids" value="{{ implode(',', old('activity_ids', $memberActivity->activities()->pluck('id')->toArray())) }}">
        </div>
        
        <div class="alert alert-warning mt-3" id="activity-error" style="display:none;">
            Debes seleccionar al menos una actividad.
        </div>

        <button type="button" id="next-to-price" class="btn btn-primary mt-3 float-end" disabled>
            Siguiente: Seleccionar Precio <i class="fas fa-arrow-right ms-2"></i>
        </button>
    </div>

    {{-- =================================== --}}
    {{-- ETAPA 3: SELECCIÓN DEL COMBO Y PAGO --}}
    {{-- =================================== --}}
    <div id="step-price-payment" class="col-12 border-top pt-4 mt-5" style="display:none;">
        <h4><i class="fas fa-money-bill-wave me-2"></i> 3. Combo, Fechas y Pago</h4>
        
        <div class="row g-3">
            {{-- Detalles de Actividades Seleccionadas --}}
            <div class="col-12">
                <div class="alert alert-info">
                    <strong>Actividades seleccionadas:</strong> <span id="summary-activities" class="fw-bold"></span>
                </div>
            </div>

            {{-- Precios Disponibles (Combos) - Carga AJAX --}}
            <div class="col-md-6">
                <label for="membership_price_id" class="form-label">Seleccionar Combo/Precio</label>
                <select name="membership_price_id" id="membership_price_id" class="form-select @error('membership_price_id') is-invalid @enderror" required>
                    <option value="">Seleccione un combo...</option>
                    {{-- Opciones cargadas por AJAX --}}
                </select>
                @error('membership_price_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Display del Precio --}}
            <div class="col-md-6">
                <div id="price-display-info" class="p-3 border rounded bg-light">
                    Precio del Combo: <span id="combo-price" class="fw-bold fs-5 text-success">$0.00</span>
                    <br>
                    Detalle del Combo: <span id="combo-detail">--</span>
                </div>
            </div>

            {{-- Fechas y Pago --}}
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
                <label for="end_date" class="form-label">Fecha de Fin (Opcional)</label>
                <input type="date" name="end_date" id="end_date"
                        class="form-control @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date', $memberActivity->end_date) }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="amount_paid" class="form-label">Monto Pagado</label>
                <input type="number" step="0.01" name="amount_paid" id="amount_paid"
                        class="form-control @error('amount_paid') is-invalid @enderror"
                        value="{{ old('amount_paid', $memberActivity->amount_paid) }}" placeholder="0.00" required>
                <small class="text-muted">Se autocompletará con el precio del combo.</small>
                @error('amount_paid')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="payment_method" class="form-label">Método de Pago</label>
                <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                    <option value="">Seleccione...</option>
                    <option value="efectivo" {{ old('payment_method', $memberActivity->payment_method) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ old('payment_method', $memberActivity->payment_method) == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transferencia" {{ old('payment_method', $memberActivity->payment_method) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
                @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Notas --}}
            <div class="col-12">
                <label for="notes" class="form-label">Notas</label>
                <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $memberActivity->notes) }}</textarea>
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Inscripción
            </button>
        </div>
    </div>
</div>

@push('scripts')
{{-- Asegúrate de que jQuery esté cargado en tu layout o antes de este script --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === ELEMENTOS DEL DOM ===
        const searchDni = document.getElementById('search_dni');
        const searchApellido = document.getElementById('search_apellido');
        const searchNombre = document.getElementById('search_nombre');
        const memberSearchInputs = document.querySelectorAll('.member-search-input');
        const memberIdInput = document.getElementById('member_id');
        const memberSearchResults = document.getElementById('member-search-results');
        const memberInfoDisplay = document.getElementById('member-info');
        const selectedMemberName = document.getElementById('selected-member-name');
        const clearMemberButton = document.getElementById('clear-member');
        
        const stepActivities = document.getElementById('step-activities');
        const stepPricePayment = document.getElementById('step-price-payment');
        const activityCheckboxes = document.querySelectorAll('.activity-checkbox');
        const nextToPriceButton = document.getElementById('next-to-price');
        const activityError = document.getElementById('activity-error');
        
        const membershipPriceSelect = document.getElementById('membership_price_id');
        const comboPriceDisplay = document.getElementById('combo-price');
        const comboDetailDisplay = document.getElementById('combo-detail');
        const summaryActivities = document.getElementById('summary-activities');
        const amountPaidInput = document.getElementById('amount_paid');
        const hiddenActivitiesInput = document.getElementById('selected_activities_ids');
        
        // === RUTAS DE AJAX ===
        const searchMembersUrl = "{{ route('member_activity.search_members') }}";
        const getPricesUrl = "{{ route('member_activity.prices_by_activities') }}";
        
        let searchTimeout;

        // ===========================================
        // LÓGICA PASO 1: BÚSQUEDA DE MIEMBRO (AJAX)
        // ===========================================

        memberSearchInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                searchTimeout = setTimeout(() => {
                    performMemberSearch();
                }, 300); // Debounce de 300ms
            });
        });

        function performMemberSearch() {
            const dni = searchDni.value.trim();
            const apellido = searchApellido.value.trim();
            const nombre = searchNombre.value.trim();
            
            const totalLength = dni.length + apellido.length + nombre.length;
            
            if (totalLength < 2) {
                memberSearchResults.style.display = 'none';
                return;
            }

            memberSearchResults.innerHTML = '<a class="list-group-item list-group-item-action text-center"><i class="fas fa-spinner fa-spin me-2"></i>Buscando...</a>';
            memberSearchResults.style.display = 'block';

            $.ajax({
                url: searchMembersUrl,
                method: 'GET',
                data: { dni, apellido, nombre },
                success: function(members) {
                    memberSearchResults.innerHTML = '';
                    if (members.length > 0) {
                        members.forEach(member => {
                            const fullName = `${member.first_name} ${member.last_name}`;
                            const item = document.createElement('a');
                            item.href = '#';
                            item.classList.add('list-group-item', 'list-group-item-action', 'p-2');
                            item.textContent = `${fullName} (DNI: ${member.dni || 'N/A'})`;
                            item.dataset.id = member.id;
                            item.dataset.name = fullName;
                            memberSearchResults.appendChild(item);
                        });
                        memberSearchResults.style.display = 'block';
                    } else {
                        memberSearchResults.innerHTML = '<div class="list-group-item list-group-item-warning">No se encontraron miembros.</div>';
                        memberSearchResults.style.display = 'block';
                    }
                },
                error: function(xhr) {
                    memberSearchResults.innerHTML = '<div class="list-group-item list-group-item-danger">Error en la búsqueda.</div>';
                    console.error("Error al buscar miembros:", xhr.responseText);
                }
            });
        }

        // Evento de selección de resultado
        memberSearchResults.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && e.target.dataset.id) {
                const memberId = e.target.dataset.id;
                const memberName = e.target.dataset.name;
                
                memberIdInput.value = memberId;
                selectedMemberName.textContent = memberName;
                memberInfoDisplay.style.display = 'inline-block';
                memberSearchResults.style.display = 'none';
                
                stepActivities.style.display = 'block'; // Mostrar paso 2
                updateStep2Validation();

                e.preventDefault();
            }
        });

        // Limpiar selección
        clearMemberButton.addEventListener('click', function() {
            memberIdInput.value = '';
            searchDni.value = '';
            searchApellido.value = '';
            searchNombre.value = '';
            memberInfoDisplay.style.display = 'none';
            memberSearchResults.style.display = 'none';
            stepActivities.style.display = 'none';
            stepPricePayment.style.display = 'none';
            
            activityCheckboxes.forEach(cb => cb.checked = false);
            membershipPriceSelect.innerHTML = '<option value="">Seleccione un combo...</option>';
            updateStep2Validation();
        });

        // ===========================================
        // LÓGICA PASO 2: SELECCIÓN DE ACTIVIDADES
        // ===========================================

        // Evento de cambio en checkboxes de actividad
        activityCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateStep2Validation();
                // Ocultar paso 3 al cambiar la selección
                stepPricePayment.style.display = 'none';
                membershipPriceSelect.innerHTML = '<option value="">Seleccione un combo...</option>';
                comboPriceDisplay.textContent = '$0.00';
                comboDetailDisplay.textContent = '--';
                amountPaidInput.value = '';
            });
        });

        // Valida el Paso 2
        function updateStep2Validation() {
            const selectedActivitiesCount = Array.from(activityCheckboxes).filter(cb => cb.checked).length;
            
            if (selectedActivitiesCount > 0 && memberIdInput.value) {
                nextToPriceButton.disabled = false;
                activityError.style.display = 'none';
                
                const ids = Array.from(activityCheckboxes).filter(cb => cb.checked).map(cb => cb.value);
                hiddenActivitiesInput.value = ids.join(',');

            } else {
                nextToPriceButton.disabled = true;
                activityError.style.display = memberIdInput.value ? 'block' : 'none';
                hiddenActivitiesInput.value = '';
            }
        }

        /**
         * Maneja el clic en el botón Siguiente (Paso 2 -> Paso 3)
         */
        nextToPriceButton.addEventListener('click', function() {
            const selectedActivityIds = Array.from(activityCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => parseInt(cb.value));

            const selectedActivityNames = Array.from(activityCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.dataset.activityName);

            if (selectedActivityIds.length === 0) return; 

            // 1. Actualizar Resumen de Actividades
            summaryActivities.textContent = selectedActivityNames.join(' + ');

            // 2. Filtrar y Cargar Combos Disponibles mediante AJAX
            loadAvailablePrices(selectedActivityIds);
            
            // 3. Mostrar el Paso 3
            stepPricePayment.style.display = 'block';
        });

        // ===========================================
        // LÓGICA PASO 3: CARGA DE PRECIOS (AJAX)
        // ===========================================

        function loadAvailablePrices(selectedActivityIds) {
            membershipPriceSelect.innerHTML = '<option value="">Cargando combos...</option>';
            
            $.ajax({
                url: getPricesUrl,
                method: 'GET',
                data: {
                    activity_ids: selectedActivityIds 
                },
                success: function(formattedPrices) {
                    membershipPriceSelect.innerHTML = '<option value="">Seleccione un combo...</option>';
                    
                    if (formattedPrices.length > 0) {
                        formattedPrices.forEach(price => {
                            const option = document.createElement('option');
                            option.value = price.id;
                            option.textContent = price.option_text; 
                            option.dataset.price = price.price;
                            option.dataset.detail = price.detail;
                            // Preseleccionar si coincide con el valor old
                            if (price.id == membershipPriceSelect.dataset.oldPriceId) {
                                option.selected = true;
                            }
                            membershipPriceSelect.appendChild(option);
                        });
                        
                        // Disparar el evento change si ya había una selección (por 'old')
                        if (membershipPriceSelect.value) {
                             $(membershipPriceSelect).trigger('change'); 
                        }

                    } else {
                        membershipPriceSelect.innerHTML = '<option value="" disabled>No hay combos disponibles.</option>';
                    }
                },
                error: function(xhr) {
                    console.error("Error al cargar precios:", xhr.responseText);
                    membershipPriceSelect.innerHTML = '<option value="">Error al cargar precios.</option>';
                }
            });
        }
        
        // Guardar el valor 'old' del precio
        membershipPriceSelect.dataset.oldPriceId = "{{ old('membership_price_id', $memberActivity->membership_price_id) }}";


        /**
         * Maneja el cambio en el select de Precio/Combo
         */
        membershipPriceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                const price = parseFloat(selectedOption.dataset.price).toFixed(2);
                const detail = selectedOption.dataset.detail;
                
                comboPriceDisplay.textContent = `$${price}`;
                comboDetailDisplay.textContent = detail;
                amountPaidInput.value = price; // Autocompletar el monto pagado
            } else {
                comboPriceDisplay.textContent = '$0.00';
                comboDetailDisplay.textContent = '--';
                amountPaidInput.value = '';
            }
        });

        // === INICIALIZACIÓN (Recuperación de estado si hubo error de validación) ===
        (function initForm() {
            if (memberIdInput.value) {
                stepActivities.style.display = 'block';

                const oldActivityIdsString = hiddenActivitiesInput.value;
                if (oldActivityIdsString.length > 0) {
                    
                    const oldActivityIds = oldActivityIdsString.split(',').filter(id => id.length > 0);
                    
                    // Asegurar que los checkboxes estén marcados si vienen de old()
                    oldActivityIds.forEach(id => {
                        const cb = document.getElementById(`activity_${id}`);
                        if (cb) cb.checked = true;
                    });
                    
                    updateStep2Validation();

                    // Si hay actividades seleccionadas, intentamos cargar los combos
                    if (oldActivityIds.length > 0) {
                        const selectedActivityIds = oldActivityIds.map(id => parseInt(id));
                        
                        const selectedActivityNames = Array.from(activityCheckboxes)
                            .filter(cb => cb.checked)
                            .map(cb => cb.dataset.activityName);
                        summaryActivities.textContent = selectedActivityNames.join(' + ');

                        loadAvailablePrices(selectedActivityIds);
                        stepPricePayment.style.display = 'block';
                    }
                }
            }
            updateStep2Validation();
        })();
    });
</script>
@endpush