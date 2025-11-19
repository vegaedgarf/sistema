<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanDetail;
use App\Models\PlanPrice;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PlanController extends Controller
{
    /**
     * Muestra la lista de planes.
     */
    public function index()
    {
        // Carga ansiosa (eager loading) de detalles, actividades y precios
        $plans = Plan::with('details.activity', 'prices')
                    ->latest()
                    ->paginate(10);

        return view('plans.index', compact('plans'));
    }

    /**
     * Muestra el formulario de creación.
     */
  public function create()
    {
        $activities = Activity::where('active', true)->orderBy('name')->get();
        
        // --- INICIO DE LA VALIDACIÓN ---
        // Si no hay actividades activas, no podemos crear un plan.
        // Redirigimos al índice de actividades para que creen una.
        if ($activities->isEmpty()) {
            return redirect()->route('activities.index')
                ->withErrors(['error' => 'No se puede crear un plan porque no hay actividades activas. Por favor, cree o active una actividad primero.']);
        }
        // --- FIN DE LA VALIDACIÓN ---

        return view('plans.create', compact('activities'));
    }
    /**
     * Almacena un nuevo plan, sus detalles y su precio inicial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric|min:0',
            'details' => 'required|array|min:1',
            'details.*.activity_id' => 'required|exists:corpo_activities,id',
            'details.*.times_per_week' => 'required|integer|min:1|max:7',
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear el Plan
            $plan = Plan::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
            ]);

            // 2. Crear los Detalles (Actividades y Frecuencias)
            foreach ($validated['details'] as $detail) {
                $plan->details()->create($detail);
            }

            // 3. Crear el primer Precio (Inmutabilidad)
            $plan->prices()->create([
                'price' => $validated['price'],
                'valid_from' => Carbon::today(),
                'valid_to' => null, // null = precio actual
            ]);

            DB::commit();

            return redirect()->route('plans.index')->with('success', 'Plan creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Error al crear el plan: ' . $e->getMessage()]);
        }
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Plan $plan)
    {
        // Cargar el plan con sus detalles y el precio actual
        $plan->load('details', 'prices');
        $activities = Activity::where('active', true)->orderBy('name')->get();
        
        // Obtenemos el precio actual para el formulario
        $currentPrice = $plan->prices()->whereNull('valid_to')->first();

        return view('plans.edit', compact('plan', 'activities', 'currentPrice'));
    }

    /**
     * Actualiza un plan, sus detalles y maneja el historial de precios.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric|min:0',
            'details' => 'required|array|min:1',
            'details.*.activity_id' => 'required|exists:corpo_activities,id',
            'details.*.times_per_week' => 'required|integer|min:1|max:7',
        ]);

        try {
            DB::beginTransaction();

            // 1. Actualizar el Plan
            $plan->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
            ]);

            // 2. Sincronizar Detalles (Forma simple: borrar y recrear)
            $plan->details()->delete();
            foreach ($validated['details'] as $detail) {
                $plan->details()->create($detail);
            }

            // 3. Lógica de Inmutabilidad de Precio
            $currentPrice = $plan->prices()->whereNull('valid_to')->first();

            // Si el precio del formulario es DIFERENTE al precio actual en la BD...
            if ($currentPrice && $currentPrice->price != $validated['price']) {
                
                // Cerramos el precio actual
                $currentPrice->update(['valid_to' => Carbon::yesterday()]);

                // Creamos un nuevo registro de precio
                $plan->prices()->create([
                    'price' => $validated['price'],
                    'valid_from' => Carbon::today(),
                    'valid_to' => null,
                ]);
            }

            DB::commit();

            return redirect()->route('plans.index')->with('success', 'Plan actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Error al actualizar el plan: ' . $e->getMessage()]);
        }
    }

    /**
     * Desactiva (Soft Delete) un plan.
     */
    public function destroy(Plan $plan)
    {
        // En lugar de un soft delete, es mejor cambiar el estado a inactivo
        // para mantener la integridad referencial con membresías antiguas.
        $plan->update(['is_active' => false]);
        
        // Opcional: Si prefieres soft-delete (si tu modelo Plan usa SoftDeletes)
        // $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan desactivado.');
    }
}