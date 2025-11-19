@extends('layouts.admin')

@section('title', 'Detalle del Grupo: ' . $familyGroup->name)

@section('content')
<div class="container-fluid mt-4">
    
    {{-- Encabezado con Botón --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Detalle del Grupo: {{ $familyGroup->name }}</h4>
        
        {{-- BOTÓN PARA ABRIR MODAL --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="fa fa-user-plus me-2"></i> Agregar Miembro
        </button>
    </div>

    {{-- Alertas de Éxito/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tarjeta de Información General --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Información del Grupo</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Nombre:</strong> {{ $familyGroup->name }}
                </div>
                <div class="col-md-6">
                    <strong>Descuento:</strong> <span class="badge bg-info text-dark">{{ $familyGroup->discount_percentage }}%</span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <strong>Estado:</strong>
                    @if($familyGroup->is_active)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Miembros Activos:</strong> 
                    <span class="badge bg-primary fs-6">{{ $familyGroup->currentMembers->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Navegación de Pestañas --}}
    <ul class="nav nav-tabs" id="groupTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab" aria-controls="current" aria-selected="true">
                Miembros Actuales ({{ $familyGroup->currentMembers->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">
                Historial de Miembros ({{ $familyGroup->memberHistory->count() }})
            </button>
        </li>
    </ul>

    {{-- Contenido de las Pestañas --}}
    <div class="tab-content border border-top-0 bg-white p-3 shadow-sm" id="groupTabsContent">
        
        {{-- Pestaña 1: Miembros Actuales --}}
        <div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
            @if ($familyGroup->currentMembers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Miembro Desde</th>
                                <th width="100px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($familyGroup->currentMembers as $membership)
                                <tr>
                                    <td>{{ $membership->member->id }}</td>
                                    <td>
                                        <a href="{{ route('members.show', $membership->member) }}" class="fw-bold text-decoration-none">
                                            {{ $membership->member->last_name }}, {{ $membership->member->first_name }}
                                        </a>
                                    </td>
                                    <td>{{ $membership->member->dni }}</td>
                                    <td>{{ $membership->member->email }}</td>
                                    <td>{{ $membership->start_date->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('members.edit', $membership->member) }}" class="btn btn-sm btn-outline-primary" title="Editar Miembro">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-secondary m-3 text-center">
                    No hay miembros activos en este grupo actualmente.
                </div>
            @endif
        </div>
        
        {{-- Pestaña 2: Historial --}}
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            @if ($familyGroup->memberHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>DNI</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($familyGroup->memberHistory as $membership)
                                <tr @if($membership->end_date) class="table-secondary text-muted" @endif>
                                    <td>{{ $membership->member->id }}</td>
                                    <td>
                                        {{ $membership->member->last_name }}, {{ $membership->member->first_name }}
                                    </td>
                                    <td>{{ $membership->member->dni }}</td>
                                    <td>{{ $membership->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $membership->end_date ? $membership->end_date->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if(is_null($membership->end_date))
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-secondary">Finalizado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-secondary m-3 text-center">
                    No hay historial de miembros para este grupo.
                </div>
            @endif
        </div>

    </div>
    
    {{-- Botón Volver --}}
    <div class="mt-4 mb-5">
        <a href="{{ route('family-groups.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Volver al listado de Grupos
        </a>
    </div>

</div>


{{-- === MODAL PARA AGREGAR MIEMBRO (CON BUSCADOR VUE) === --}}
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            {{-- 
                ID "add-member-app": Vue se montará aquí.
                data-members: Pasamos todos los miembros disponibles al JS.
            --}}
            <div id="add-member-app" data-members='@json($availableMembers)'>
                
                <form action="{{ route('family_groups.add_member', $familyGroup) }}" method="POST">
                    @csrf
                    
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addMemberModalLabel">Agregar Miembro al Grupo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Busque por <strong>Apellido</strong>, <strong>Nombre</strong> o <strong>DNI</strong>.
                        </p>

                        {{-- INPUT OCULTO: Este es el que se envía al servidor --}}
                        <input type="hidden" name="member_id" :value="selectedMember ? selectedMember.id : ''">

                        {{-- BUSCADOR --}}
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">Buscar Miembro</label>
                            
                            {{-- Input de búsqueda --}}
                            <input type="text" 
                                   class="form-control" 
                                   v-model="searchQuery" 
                                   placeholder="Escriba para buscar..." 
                                   autocomplete="off"
                                   @keydown.enter.prevent> {{-- Evita submit al dar enter --}}

                            {{-- Tarjeta de Miembro Seleccionado --}}
                            <div v-if="selectedMember" class="alert alert-success mt-2 d-flex justify-content-between align-items-center p-2">
                                <div>
                                    <i class="fa fa-check-circle me-2"></i>
                                    <strong>@{{ selectedMember.last_name }}, @{{ selectedMember.first_name }}</strong>
                                    <br>
                                    <small>DNI: @{{ selectedMember.dni }}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger bg-white" @click="selectedMember = null">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            {{-- Lista de Resultados (Solo aparece si hay búsqueda y no hay selección) --}}
                            <div v-if="searchQuery.length > 0 && !selectedMember" class="list-group mt-1 shadow position-absolute w-100" style="z-index: 1050; max-height: 200px; overflow-y: auto;">
                                
                                <button type="button" 
                                        v-for="member in filteredMembers" 
                                        :key="member.id"
                                        class="list-group-item list-group-item-action"
                                        @click="selectMember(member)">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">@{{ member.last_name }}, @{{ member.first_name }}</h6>
                                        <small>@{{ member.dni }}</small>
                                    </div>
                                </button>

                                <div v-if="filteredMembers.length === 0" class="list-group-item text-muted small text-center">
                                    No se encontraron resultados.
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info py-2 px-3 small mt-3">
                            <i class="fa fa-info-circle me-1"></i> Si el miembro ya pertenece a otro grupo, será movido a este automáticamente.
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        {{-- El botón se deshabilita si no hay miembro seleccionado --}}
                        <button type="submit" class="btn btn-primary" :disabled="!selectedMember">Agregar al Grupo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection