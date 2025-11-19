

import '@coreui/coreui/dist/css/coreui.min.css';
import * as CoreUI from '@coreui/coreui';
import Alpine from 'alpinejs';


import './bootstrap';


import { createApp } from 'vue';


window.Alpine = Alpine;

window.CoreUI = CoreUI;

Alpine.start();


/*
|--------------------------------------------------------------------------
| Lógica para el Formulario de Planes
|--------------------------------------------------------------------------
*/
const planFormApp = document.getElementById('plan-form-app');

if (planFormApp) {
    // Leemos los datos desde los atributos data-*
    const activitiesData = planFormApp.dataset.activities;
    const initialDetailsData = planFormApp.dataset.initialDetails;

    createApp({
        data() {
            return {
                // Parseamos el JSON que nos pasa Blade
                activities: activitiesData ? JSON.parse(activitiesData) : [],
                details: initialDetailsData ? JSON.parse(initialDetailsData) : [] 
            }
        },
        methods: {
            addDetail() {
                // Añade una nueva fila vacía
                this.details.push({
                    activity_id: '',
                    times_per_week: 1
                });
            },
            removeDetail(index) {
                // Elimina la fila por su índice
                this.details.splice(index, 1);
            }
        },
        mounted() {
            // Si es un formulario de 'crear' (sin detalles iniciales), añadimos uno por defecto
            if (this.details.length === 0) {
                this.addDetail();
            }
        }
    }).mount('#plan-form-app');
}


/*
|--------------------------------------------------------------------------
| Lógica para el Formulario de Grupos Familiares
|--------------------------------------------------------------------------
*/
const groupFormApp = document.getElementById('group-form-app');

if (groupFormApp) {
    const allMembersData = groupFormApp.dataset.allMembers;
    const initialMembersData = groupFormApp.dataset.initialMembers;

    createApp({
        data() {
            return {
                allMembers: JSON.parse(allMembersData),
                selectedMembers: JSON.parse(initialMembersData) || [],
                searchQuery: '',
            }
        },
        computed: {
            /**
             * Filtra la lista de 'todos' para mostrar solo los que
             * coinciden con la búsqueda Y que no están ya seleccionados.
             */
            availableMembers() {
                const query = this.searchQuery.toLowerCase().trim();
                if (!query) return [];

                // Obtener IDs de los ya seleccionados
                const selectedIds = new Set(this.selectedMembers.map(m => m.id));

                return this.allMembers.filter(member => {
                    const isNotSelected = !selectedIds.has(member.id);
                    const nameMatch = member.first_name.toLowerCase().includes(query) || 
                                      member.last_name.toLowerCase().includes(query);
                    const dniMatch = (member.dni || '').includes(query);

                    return isNotSelected && (nameMatch || dniMatch);
                }).slice(0, 5); // Limitar a 5 resultados
            }
        },
        methods: {
            addMember(member) {
                this.selectedMembers.push(member);
                this.searchQuery = ''; // Limpiar búsqueda
            },
            removeMember(index) {
                this.selectedMembers.splice(index, 1);
            }
        }
    }).mount('#group-form-app');
}

/*
|--------------------------------------------------------------------------
| Lógica para el Modal de Agregar Miembro (En Show Family Group)
|--------------------------------------------------------------------------
*/
const addMemberApp = document.getElementById('add-member-app');

if (addMemberApp) {
    const membersData = addMemberApp.dataset.members;

    createApp({
        data() {
            return {
                members: membersData ? JSON.parse(membersData) : [],
                searchQuery: '',
                selectedMember: null
            }
        },
        computed: {
            filteredMembers() {
                // Si no escribe nada, no mostramos nada (o podrías mostrar los primeros 5)
                if (this.searchQuery.length < 2) return [];

                const query = this.searchQuery.toLowerCase().trim();

                return this.members.filter(member => {
                    const fullName = `${member.last_name} ${member.first_name}`.toLowerCase();
                    const dni = String(member.dni); // Asegurar que sea string

                    return fullName.includes(query) || dni.includes(query);
                }).slice(0, 10); // Limitamos a 10 resultados para rendimiento
            }
        },
        methods: {
            selectMember(member) {
                this.selectedMember = member;
                this.searchQuery = ''; // Limpiamos la búsqueda
            }
        }
    }).mount('#add-member-app');
}


/*
|--------------------------------------------------------------------------
| Lógica para Inscripciones (Memberships) - CON BUSCADOR
|--------------------------------------------------------------------------
*/
const membershipFormApp = document.getElementById('membership-form-app');

if (membershipFormApp) {
    const membersData = JSON.parse(membershipFormApp.dataset.members);
    const plansData = JSON.parse(membershipFormApp.dataset.plans);
    // ✅ Capturamos la ruta generada por Laravel
    const routeCalculate = membershipFormApp.dataset.routeCalculate;

    createApp({
        data() {
            return {
                members: membersData,
                plans: plansData,
                // Datos del Buscador
                searchQuery: '',
                selectedMember: null,
                // Datos del Formulario
                form: {
                    member_id: '',
                    plan_id: '',
                    start_date: new Date().toISOString().split('T')[0]
                },
                // Datos Económicos
                totals: {
                    base_price: null,
                    discount_amount: 0,
                    final_price: null,
                    group_name: ''
                },
                loading: false
            }
        },
        computed: {
            filteredMembers() {
                if (this.searchQuery.length < 2) return [];
                const query = this.searchQuery.toLowerCase().trim();
                return this.members.filter(member => {
                    const fullName = `${member.last_name} ${member.first_name}`.toLowerCase();
                    const dni = String(member.dni);
                    return fullName.includes(query) || dni.includes(query);
                }).slice(0, 10);
            }
        },
        methods: {
            selectMember(member) {
                this.selectedMember = member;
                this.form.member_id = member.id;
                this.searchQuery = '';
                // Al seleccionar miembro, calculamos precio si ya hay plan
                this.calculateTotals();
            },
            resetMember() {
                this.selectedMember = null;
                this.form.member_id = '';
                this.totals.final_price = null; // Resetear precio
            },
            async calculateTotals() {
                // Solo calculamos si ambos están seleccionados
                if (!this.form.member_id || !this.form.plan_id) {
                    this.totals.final_price = null;
                    return;
                }

                this.loading = true;

                try {
                    // ✅ Usamos la ruta correcta pasada desde Blade
                    const response = await axios.post(routeCalculate, {
                        member_id: this.form.member_id,
                        plan_id: this.form.plan_id
                    });

                    this.totals = response.data;

                } catch (error) {
                    console.error(error);
                    alert('Error al calcular el precio. Verifique que el plan tenga precios vigentes.');
                } finally {
                    this.loading = false;
                }
            },
            formatPrice(value) {
                return new Intl.NumberFormat('es-AR', { 
                    minimumFractionDigits: 2, 
                    maximumFractionDigits: 2 
                }).format(value);
            }
        }
    }).mount('#membership-form-app');
}