<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Aceptamos el objeto Request
    {
        $search = $request->get('search'); // Obtiene el término de búsqueda

        $query = Activity::withTrashed()
                              ->with(['createdBy', 'updatedBy'])
                              ->orderBy('active', 'desc')
                              ->orderBy('name', 'asc');

        // Si hay un término de búsqueda, aplicamos el filtro
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $activities = $query->get();

        // Pasamos el término de búsqueda de vuelta a la vista para que el campo no se vacíe
        return view('activities.index', compact('activities', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:corpo_activities,name',
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean', // Manejado por el checkbox
        ]);

        $activity = Activity::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'active' => $request->has('active'), // Checkbox solo envía valor si está marcado
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('activities.index')->with('success', 'Actividad ' . $activity->name . ' creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        // Carga las relaciones para mostrar en detalle quién creó/actualizó
        $activity->load(['createdBy', 'updatedBy']);
        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            // Aseguramos que el nombre sea único, excepto para la actividad actual
            'name' => 'required|string|max:255|unique:corpo_activities,name,' . $activity->id,
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean',
        ]);

        $activity->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'active' => $request->has('active'),
            'updated_by' => Auth::id(), // Solo actualizamos updated_by
        ]);

        return redirect()->route('activities.index')->with('success', 'Actividad ' . $activity->name . ' actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        // Laravel maneja SoftDeletes, por lo que se marca como eliminado
        $activity->delete(); 
        
        return redirect()->route('activities.index')->with('success', 'Actividad eliminada (soft deleted) correctamente.');
    }
}