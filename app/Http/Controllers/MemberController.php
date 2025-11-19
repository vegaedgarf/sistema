<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\FamilyGroup; // <-- AÑADIDO
use App\Models\FamilyGroupMembership; // <-- AÑADIDO
use Illuminate\Http\Request;
use Carbon\Carbon; // <-- AÑADIDO

class MemberController extends Controller
{
    public function index(Request $request) // <-- AÑADIDO Request
    {
        // Tu lógica de búsqueda (si la tienes) iría aquí
        $query = Member::query();
        
        // Cargar la relación del grupo actual para mostrar en la lista
        $members = $query->with('currentGroupMembership.group') // <-- AÑADIDO
                         ->latest()
                         ->paginate(10);
                         
        return view('members.index', compact('members'));
    }

    public function show($id)
    {
        // Carga todas las relaciones necesarias en una sola consulta
        $member = Member::with(
            'contacts', 
            'healthRecord',
            'currentGroupMembership.group', // Grupo actual
            'groupHistory.group' // Historial de grupos
        )->findOrFail($id);
        
        // $memberhealth ya no es necesario, 'healthRecord' ya está en $member
        return view('members.show', compact('member'));
    }

    public function create(Request $request)
    {
        // Cargar todos los grupos activos para el dropdown
        $familyGroups = FamilyGroup::where('is_active', true)->orderBy('name')->get();

        return view('members.create', [
            'member' => new Member(), // Pasar un miembro vacío
            'familyGroups' => $familyGroups,
        ]);
    }

    private function validateMember(Request $request, ?Member $member = null)
    {
        // Se asegura que la regla unique del DNI excluya al miembro actual si se está actualizando
        $memberId = $member ? $member->id : 'NULL'; 
        
        // Validaciones del Miembro (SIN el grupo)
        return $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:corpo_members,dni,' . $memberId . ',id', 
            'birth_date' => 'nullable|date', 
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:corpo_members,email,' . $memberId . ',id', // <-- CORREGIDO: Añadir unique
            'status' => 'required|in:activo,inactivo,suspendido',
            'joined_at' => 'required|date',
            'observations' => 'nullable|string', 
        ]);
    }

    /**
     * Almacena un nuevo miembro.
     */
    public function store(Request $request) // Eliminado Member $member
    {
        $validatedMember = $this->validateMember($request);
        
        // Validación del Grupo (separada)
        $validatedGroup = $request->validate([
            'family_group_id' => 'nullable|exists:corpo_family_groups,id'
        ]);

        $validatedMember['created_by'] = auth()->id();

        // 1. CREAR el objeto Miembro
        $newMember = Member::create($validatedMember); 
        
        // 2. ASIGNAR el grupo (si se seleccionó uno)
        $this->updateGroupMembership($newMember, $validatedGroup['family_group_id'] ?? null);

        // 3. Redirigir
        return redirect()->route('members.show', $newMember)
                         ->with('success', 'Miembro creado exitosamente.');
    }

    /**
     * Actualiza el miembro especificado.
     */
    public function update(Request $request, Member $member)
    {
        $validatedMember = $this->validateMember($request, $member);

        // Validación del Grupo (separada)
        $validatedGroup = $request->validate([
            'family_group_id' => 'nullable|exists:corpo_family_groups,id'
        ]);

        // 1. Actualiza el Miembro
        $member->update($validatedMember + [
            'updated_by' => auth()->id(), 
        ]);
        
        // 2. Actualiza el Grupo (con lógica de historial)
        $this->updateGroupMembership($member, $validatedGroup['family_group_id'] ?? null);

        return redirect()->route('members.index')
                         ->with('success', 'Miembro actualizado exitosamente.');
    }

    public function edit(Member $member)
    {
        // 1. Cargar todos los grupos activos para el dropdown
        $familyGroups = FamilyGroup::where('is_active', true)->orderBy('name')->get();
        
        // 2. Cargar la membresía de grupo activa de este miembro
        $member->load('currentGroupMembership');

        return view('members.edit', compact('member', 'familyGroups'));
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Miembro eliminado.');
    }
    
    /**
     * Lógica encapsulada para gestionar el historial de grupos de un miembro.
     */
    private function updateGroupMembership(Member $member, ?string $newGroupId): void
    {
        // Recargar la relación para asegurar datos frescos
        $member->load('currentGroupMembership');
        $currentMembership = $member->currentGroupMembership;
        $currentGroupId = $currentMembership?->family_group_id;

        // Caso 1: No hay cambios (sigue en el mismo grupo o sigue sin grupo)
        if ($currentGroupId == $newGroupId) {
            return;
        }

        // Caso 2: Hay un cambio. Finalizamos la membresía actual (si existe).
        if ($currentMembership) {
            $currentMembership->update(['end_date' => Carbon::yesterday()]);
        }

        // Caso 3: Asignamos la nueva membresía (si se seleccionó una)
        if ($newGroupId) {
            FamilyGroupMembership::create([
                'member_id' => $member->id,
                'family_group_id' => $newGroupId,
                'start_date' => Carbon::today(),
                'end_date' => null, // null = activo
            ]);
        }
    }
}