@extends('layouts.admin')

@section('title', 'Nueva Inscripción')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Nueva Inscripción (Membresía)</h4>

    {{-- 
        IMPORTANTE: 
        1. data-members: Los datos para buscar.
        2. data-route-calculate: La ruta CORRECTA para el axios (soluciona el error 404).
    --}}
    <div class="card shadow-sm" id="membership-form-app" 
         data-members='@json($members)' 
         data-plans='@json($plans)'
         data-route-calculate="{{ route('memberships.calculate_price') }}">
         
        <div class="card-body">
            <form action="{{ route('memberships.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 border-end">
                        <h5 class="mb-3 text-primary">1. Datos de la Inscripción</h5>
                        
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">Miembro</label>
                            
                            {{-- Input oculto que se envía al backend --}}
                            <input type="hidden" name="member_id" :value="form.member_id">

                            {{-- Input visible de búsqueda --}}
                            <div v-if="!selectedMember">
                                <input type="text" 
                                       class="form-control" 
                                       v-model="searchQuery" 
                                       placeholder="Buscar por DNI o Apellido..." 
                                       autocomplete="off">
                                
                                {{-- Lista de Resultados --}}
                                <div v-if="searchQuery.length > 1" class="list-group mt-1 shadow position-absolute w-100" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                    <button type="button" 
                                            v-for="member in filteredMembers" 
                                            :key="member.id"
                                            class="list-group-item list-group-item-action"
                                            @click="selectMember(member)">
                                        <strong>@{{ member.last_name }}, @{{ member.first_name }}</strong>
                                        <br><small class="text-muted">DNI: @{{ member.dni }}</small>
                                    </button>
                                    <div v-if="filteredMembers.length === 0" class="list-group-item text-muted small">
                                        No se encontraron resultados.
                                    </div>
                                </div>
                            </div>

                            {{-- Tarjeta de Miembro Seleccionado --}}
                            <div v-else class="alert alert-success d-flex justify-content-between align-items-center p-2 mb-0">
                                <div>
                                    <i class="fa fa-user-check me-2"></i>
                                    <strong>@{{ selectedMember.last_name }}, @{{ selectedMember.first_name }}</strong>
                                    <span class="small text-muted">(@{{ selectedMember.dni }})</span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger bg-white" @click="resetMember">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <div v-if="!form.member_id" class="text-danger small mt-1">Debe seleccionar un miembro.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Plan</label>
                            <select name="plan_id" class="form-select" v-model="form.plan_id" @change="calculateTotals" required>
                                <option value="">-- Seleccione Plan --</option>
                                <option v-for="plan in plans" :value="plan.id">
                                    @{{ plan.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Inicio</label>
                            <input type="date" name="start_date" class="form-control" 
                                   v-model="form.start_date" required>
                            <div class="form-text">La fecha de fin se calculará automáticamente (1 mes).</div>
                        </div>
                    </div>

                    <div class="col-md-6 bg-light p-4 rounded">
                        <h5 class="mb-3 text-primary">2. Resumen a Pagar</h5>
                        
                        <div v-if="loading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2">Calculando precio...</p>
                        </div>

                        <div v-else-if="totals.final_price !== null">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Precio del Plan:</span>
                                <span class="fw-bold">$ @{{ formatPrice(totals.base_price) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3 text-success" v-if="totals.discount_amount > 0">
                                <span>
                                    <i class="fa fa-users me-1"></i> Desc. Grupo (@{{ totals.group_name }}):
                                </span>
                                <span>- $ @{{ formatPrice(totals.discount_amount) }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">Total a Pagar:</span>
                                <span class="h3 mb-0 text-primary">$ @{{ formatPrice(totals.final_price) }}</span>
                            </div>

                            <input type="hidden" name="base_price_hidden" :value="totals.base_price">
                            <input type="hidden" name="discount_amount_hidden" :value="totals.discount_amount">
                            <input type="hidden" name="final_price" :value="totals.final_price">
                        </div>

                        <div v-else class="alert alert-info text-center mt-4">
                            <i class="fa fa-calculator fa-2x mb-2 text-secondary"></i><br>
                            Seleccione un miembro y un plan para calcular el precio.
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('memberships.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success btn-lg" :disabled="!totals.final_price || loading">
                        <i class="fa fa-check me-2"></i> Confirmar Inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection