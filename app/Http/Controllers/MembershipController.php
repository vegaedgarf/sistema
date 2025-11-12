<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::orderBy('name')->paginate(10);
        return view('memberships.index', compact('memberships'));
    }

    public function create()
    {
        return view('memberships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'duration_days'  => 'required|integer|min:1',
            'notes'          => 'nullable|string',
            'active'         => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();
        Membership::create($validated);

        return redirect()->route('memberships.index')->with('success', 'Membresía creada correctamente.');
    }

    public function edit(Membership $membership)
    {
        return view('memberships.edit', compact('membership'));
    }

    public function update(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'duration_days'  => 'required|integer|min:1',
            'notes'          => 'nullable|string',
            'active'         => 'boolean',
        ]);

        $validated['updated_by'] = auth()->id();
        $membership->update($validated);

        return redirect()->route('memberships.index')->with('success', 'Membresía actualizada correctamente.');
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();
        return redirect()->route('memberships.index')->with('success', 'Membresía eliminada.');
    }
}
