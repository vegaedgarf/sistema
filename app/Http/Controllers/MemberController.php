<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;


class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('members.index', compact('members'));
    }

public function show($id)
{
    $member = Member::with('contacts')->findOrFail($id);
    $memberhealth = Member::with('healthRecord')->findOrFail($id);

    return view('members.show', compact('member'));
}






public function create(Request $request, Member $member)
{
    $member = null;
    if ($request->has('member_id')) {
        $member = Member::find($request->member_id);
    }
    // al usar ruta plana, pasamos $member (puede ser null si se crea desde lista global)
    return view('members.create', compact('member'));
}


private function validateMember(Request $request, ?Member $member = null)
    {
        // Se asegura que la regla unique del DNI excluya al miembro actual si se está actualizando
        $memberId = $member ? $member->id : 'NULL'; 
        
        return $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            // DNI: Único en la tabla 'corpo_members', campo 'dni', excluyendo $memberId
            'dni' => 'required|string|max:20|unique:corpo_members,dni,' . $memberId . ',id', 
            
            // ✅ Nuevas validaciones en inglés
            'birth_date' => 'nullable|date', 
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'status' => 'required|in:activo,inactivo,suspendido', // Debe coincidir con los ENUM de la DB
            'joined_at' => 'required|date',
            'observations' => 'nullable|string', 
        ]);
    }

    /**
     * Almacena un nuevo miembro.
     */
    public function store(Request $request , Member $member)
    {
        $validated = $this->validateMember($request);

     $validated['created_by'] = auth()->id();

// 2. CAPTURAR el objeto recién creado
    $newMember = Member::create($validated); 

    // 3. Redirigir usando el objeto creado
    return redirect()->route('members.show', $newMember) // Usar $newMember
                     ->with('success', 'Miembro creado exitosamente.');

    }



    /**
     * Actualiza el miembro especificado.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $this->validateMember($request, $member);

        // Actualiza el registro con los datos validados + campo de actualización
        $member->update($validated + [
            'updated_by' => auth()->id(), 
        ]);

        return redirect()->route('members.index')
                         ->with('success', 'Miembro actualizado exitosamente.');
    }


    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }


    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Miembro eliminado.');
    }
}
