<?php

namespace App\Http\Controllers;

use App\Models\FamilyGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FamilyGroupMembership;
use App\Models\Member;                 // <--- ¡Esta es la que falta!
use Carbon\Carbon;                     // <--- Esta también para las fechas


class FamilyGroupController extends Controller
{
    /**
     * Muestra la lista de grupos familiares.
     */
    public function index()
    {
        // Contamos los miembros para la vista de índice
       $groups = FamilyGroup::withCount('currentMembers')->latest()->paginate(10);
        return view('family_groups.index', compact('groups'));
    }

  public function create()
    {
        // NO necesitamos pasar los miembros
        return view('family_groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'required|boolean',
            // --- ELIMINADO: 'members' y 'members.*' ya no se validan aquí ---
        ]);

        FamilyGroup::create($validated);
        
        return redirect()->route('family-groups.index')->with('success', 'Grupo familiar creado exitosamente.');
    }


    public function edit(FamilyGroup $familyGroup)
    {
        // NO necesitamos cargar miembros
        return view('family_groups.edit', compact('familyGroup'));
    }

    public function update(Request $request, FamilyGroup $familyGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'required|boolean',
            // --- ELIMINADO: 'members' y 'members.*' ---
        ]);

        $familyGroup->update($validated);

        // --- ELIMINADO: $familyGroup->members()->sync() ---
        
        return redirect()->route('family-groups.index')->with('success', 'Grupo familiar actualizado exitosamente.');
    }
    /**
     * Elimina el grupo familiar.
     */
    public function destroy(FamilyGroup $familyGroup)
    {
        // No es necesario desasociar miembros si la FK en la pivote tiene 'onDelete(cascade)'
        // Si no, sync([]) es más seguro antes de borrar.
        $familyGroup->members()->sync([]);
        $familyGroup->delete();

        return redirect()->route('family-groups.index')->with('success', 'Grupo familiar eliminado.');
    }

public function show(FamilyGroup $familyGroup)
    {
        $familyGroup->load('currentMembers.member', 'memberHistory.member');

        // Obtenemos miembros activos para el select del modal
        // Podrías filtrar para no mostrar los que ya están en este grupo, pero mostrarlos todos es aceptable.
        $availableMembers = Member::where('status', 'activo')
                                  ->orderBy('last_name')
                                  ->get(['id', 'first_name', 'last_name', 'dni']);

        return view('family_groups.show', compact('familyGroup', 'availableMembers'));
    }


 /**
     * Agrega un miembro existente a este grupo (gestionando el historial).
     */
    public function addMember(Request $request, FamilyGroup $familyGroup)
    {
        $request->validate([
            'member_id' => 'required|exists:corpo_members,id',
        ]);

        $member = Member::findOrFail($request->member_id);

        // 1. Verificar si ya está en este grupo actualmente
        $currentMembership = $member->currentGroupMembership;
        if ($currentMembership && $currentMembership->family_group_id == $familyGroup->id) {
            return back()->with('error', 'El miembro ya pertenece a este grupo.');
        }

        // 2. Cerrar membresía anterior (si tiene una en OTRO grupo)
        if ($currentMembership) {
            $currentMembership->update(['end_date' => Carbon::yesterday()]);
        }

        // 3. Crear nueva membresía en ESTE grupo
        FamilyGroupMembership::create([
            'member_id' => $member->id,
            'family_group_id' => $familyGroup->id,
            'start_date' => Carbon::today(),
            'end_date' => null,
        ]);

        return back()->with('success', 'Miembro agregado al grupo correctamente.');
    }   





}