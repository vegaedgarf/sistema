<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\HealthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthRecordController extends Controller
{
    /**
     * Mostrar la ficha médica de un miembro (si existe).
     */
    public function show(Member $member)
    {
        $healthRecord = $member->healthRecord;
        return view('health_records.show', compact('member', 'healthRecord'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(Member $member)
    {
        // Evita duplicar fichas
        if ($member->healthRecord) {
            return redirect()
                ->route('health_ecords.show', $member->id)
                ->with('warning', 'El miembro ya tiene una ficha médica.');
        }

        return view('health_records.create', compact('member'));
    }

    /**
     * Guardar nueva ficha médica.
     */
    public function store(Request $request, Member $member)
    {
        $validated = $request->validate([
            'blood_type' => 'nullable|string|max:10',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'allergies' => 'nullable|string',
            'injuries' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'medications' => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $validated['member_id'] = $member->id;
        $validated['created_by'] = Auth::id();

        HealthRecord::create($validated);

        return redirect()
            ->route('health_records.show', $member->id)
            ->with('success', 'Ficha médica creada correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Member $member, HealthRecord $healthRecord)
    {
        return view('health_records.edit', compact('member', 'healthRecord'));
    }

    /**
     * Actualizar ficha médica.
     */
    public function update(Request $request, Member $member, HealthRecord $healthRecord)
    {
        $validated = $request->validate([
            'blood_type' => 'nullable|string|max:10',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'allergies' => 'nullable|string',
            'injuries' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'medications' => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $validated['updated_by'] = Auth::id();

        $healthRecord->update($validated);

        return redirect()
            ->route('health_records.show', $member->id)
            ->with('success', 'Ficha médica actualizada correctamente.');
    }

    /**
     * Eliminar ficha médica.
     */
    public function destroy(Member $member, HealthRecord $healthRecord)
    {
        $healthRecord->delete();

        return redirect()
            ->route('members.show', $member->id)
            ->with('success', 'Ficha médica eliminada correctamente.');
    }
}
