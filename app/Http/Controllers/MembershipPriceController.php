<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\MembershipPrice;
use Illuminate\Http\Request;
use Carbon\Carbon;
class MembershipPriceController extends Controller
{
  /**
     * Muestra solo los precios de membresía que están actualmente activos.
     */
    public function index()
    {
        $now = Carbon::now()->toDateString();

        $membershipPrices = MembershipPrice::with('activity')
            ->whereDate('valid_from', '<=', $now)
            ->where(function ($query) use ($now) {
                $query->whereNull('valid_to')
                      ->orWhereDate('valid_to', '>', $now);
            })
            ->orderBy('price', 'asc')
            // CAMBIO: Usamos paginate() en lugar de get()
            ->paginate(10); 

        return view('membership_prices.index', compact('membershipPrices'));
    }

    /**
     * Muestra todos los precios de membresía históricos (no vigentes).
     */
    public function history()
    {
        $now = Carbon::now()->toDateString();

        $historicalPrices = MembershipPrice::with('activity')
            ->where(function ($query) use ($now) {
                $query->whereDate('valid_to', '<=', $now)
                      ->whereNotNull('valid_to');
            })
            ->orWhereDate('valid_from', '>', $now)
            ->orderBy('valid_to', 'desc')
            // CAMBIO: Usamos paginate() en lugar de get()
            ->paginate(10);

        // La vista histórica debe llamarse 'historicalPrices'
        return view('membership_prices.history', compact('historicalPrices'));
    }



    public function show(MembershipPrice $membershipPrice)
    {
        // Carga la relación singular 'activity' para acceder a las actividades asociadas
        $membershipPrice->load('activity');
        
        // Retorna la vista de detalle, pasando la variable $membershipPrice
        return view('membership_prices.show', compact('membershipPrice'));
    }

    public function create()
    {
        $activities = Activity::where('active', true)->get();
        return view('membership_prices.create', compact('activities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date|after:valid_from',
            'activities' => 'required|array',
            'activities.*.id' => 'required|exists:corpo_activities,id',
            'activities.*.times_per_week' => 'required|integer|min:1|max:7',
        ]);

        $price = MembershipPrice::create([
            'price' => $validated['price'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'] ?? null,
            'created_by' => auth()->id(),
        ]);

        // Asocia las actividades con sus veces por semana
        foreach ($validated['activities'] as $activity) {
            $price->activity()->attach($activity['id'], [
                'times_per_week' => $activity['times_per_week'],
            ]);
        }

        return redirect()->route('membership_prices.index')->with('success', 'Precio registrado correctamente');
    }


public function edit(MembershipPrice $membershipPrice)
    {
        $now = Carbon::now();

        // RESTRICCIÓN: Impedir la edición si el registro ha expirado (es histórico).
        if ($membershipPrice->valid_to && $membershipPrice->valid_to->lte($now)) {
            return redirect()->route('membership_prices.history')
                             ->with('error', 'Error: No se permite editar un precio que ya ha expirado y es histórico.');
        }

        // Carga todas las actividades activas
        $activities = Activity::where('active', true)->get();
        
        // Carga la relación activity (singular) con los datos pivote
        $membershipPrice->load('activity'); 
        
        return view('membership_prices.edit', compact('membershipPrice', 'activities'));
    }

    public function update(Request $request, MembershipPrice $membershipPrice)
    {
        $now = Carbon::now();

        // RESTRICCIÓN: Impedir la actualización si el registro ha expirado (es histórico).
        if ($membershipPrice->valid_to && $membershipPrice->valid_to->lte($now)) {
            return redirect()->route('membership_prices.history')
                             ->with('error', 'Error: No se permite actualizar un precio que ya ha expirado y es histórico.');
        }

        // Lógica de validación que maneja el array 'activities' con datos pivote
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            // Usar 'after_or_equal' si permites el mismo día
            'valid_to' => 'nullable|date|after:valid_from', 
            'activities' => 'required|array',
            
            // Usando 'corpo_activities' para la regla exists según tu código anterior.
            'activities.*.id' => 'required|exists:corpo_activities,id', 
            
            'activities.*.times_per_week' => 'required|integer|min:1|max:7',
        ]);

        // 1. Actualiza los campos principales del precio
        $membershipPrice->update([
            'price' => $validated['price'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'] ?? null,
        ]);
        
        // 2. Prepara los datos para la sincronización Many-to-Many
        $activitiesToSync = [];
        foreach ($validated['activities'] as $activity) {
            $activitiesToSync[$activity['id']] = [
                'times_per_week' => $activity['times_per_week'],
            ];
        }

        // Usa sync() con la relación singular 'activity' para actualizar la tabla pivote
        $membershipPrice->activity()->sync($activitiesToSync);

        return redirect()->route('membership_prices.index')->with('success', 'Precio actualizado correctamente.');
    }








/*public function edit(MembershipPrice $membershipPrice)
    {
        $now = Carbon::now();

        // RESTRICCIÓN: Impedir la edición si el registro ha expirado.
        if ($membershipPrice->valid_to && $membershipPrice->valid_to->lte($now)) {
            return redirect()->route('membership_prices.history')
                             ->with('error', 'Error: No se permite editar un precio que ya ha expirado y es histórico.');
        }

        $activities = Activity::orderBy('name')->pluck('name', 'id');
        $selectedActivities = $membershipPrice->activity->pluck('id')->toArray();

        return view('membership_prices.edit', compact('membershipPrice', 'activities', 'selectedActivities'));
    }

     public function update(Request $request, MembershipPrice $membershipPrice)
    {
        $now = Carbon::now();

        // RESTRICCIÓN: Impedir la actualización si el registro ha expirado.
        if ($membershipPrice->valid_to && $membershipPrice->valid_to->lte($now)) {
            return redirect()->route('membership_prices.history')
                             ->with('error', 'Error: No se permite actualizar un precio que ya ha expirado y es histórico.');
        }
        
        // 1. VALIDACIÓN
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            
            // Validamos la estructura del array 'activities' que viene del formulario
            'activities' => 'nullable|array',
            'activities.*.id' => 'required_with:activities.*.times_per_week|exists:activities,id',
            'activities.*.times_per_week' => 'required|integer|min:1|max:7', // Asegura que se envíe un valor válido
        ]);

        // Actualizar los campos principales del modelo
        $membershipPrice->update([
            'price' => $validated['price'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'] ?? null,
        ]);
        
        // 2. TRANSFORMAR DATOS para sync()
        $syncData = [];
        if (!empty($validated['activities'])) {
            foreach ($validated['activities'] as $activityData) {
                // La función sync() requiere el ID como clave y los datos pivote como valor.
                $syncData[$activityData['id']] = [
                    'times_per_week' => $activityData['times_per_week']
                ];
            }
        }
        
        // 3. SINCRONIZAR
        // Esto adjuntará, desvinculará y actualizará los campos pivote en una sola operación.
        $membershipPrice->activity()->sync($syncData);

        return redirect()->route('membership_prices.index')->with('success', 'Precio de membresía actualizado correctamente.');
    }

*/



/*
    public function destroy(MembershipPrice $membershipPrice)
    {
        // CORREGIDO: Desasocia las actividades de la tabla pivote antes de eliminar el registro principal
        // Esto previene errores de integridad referencial si no se usa ON DELETE CASCADE.
        $membershipPrice->activity()->detach(); 

        $membershipPrice->delete();
        
        return redirect()->route('membership_prices.index')->with('success', 'Registro eliminado correctamente.');
    }
*/


/**
     * Elimina el registro, pero solo si no ha expirado, y desasocia las relaciones.
     */
    public function destroy(MembershipPrice $membershipPrice)
    {
        $now = Carbon::now();

        // 1. REGLA DE NEGOCIO: Prohibir la eliminación de registros ya expirados (históricos).
        // Si la fecha de fin existe Y es anterior o igual a hoy, el precio ya fue activo y no se puede eliminar.
        if ($membershipPrice->valid_to && $membershipPrice->valid_to->lte($now)) {
            // Redirigimos al histórico porque es donde reside este tipo de registro
            return redirect()->route('membership_prices.history')
                             ->with('error', 'Error: No se puede eliminar un precio que ya fue histórico (expirado).');
        }

        try {
            // 2. INTEGRIDAD REFERENCIAL: Desasocia las actividades de la tabla pivote antes de eliminar.
            $membershipPrice->activity()->detach(); 

            // 3. ELIMINACIÓN: Eliminamos el registro principal.
            $membershipPrice->delete();
            
            $message = 'Precio de membresía eliminado correctamente.';
            
            // 4. REDIRECCIÓN INTELIGENTE: Redirigimos al índice adecuado.
            // Si el precio era activo (valid_from <= now), vamos al índice principal.
            if ($membershipPrice->valid_from->lte($now)) {
                 return redirect()->route('membership_prices.index')->with('success', $message);
            }
            
            // Si era un precio futuro (valid_from > now), vamos al histórico.
            return redirect()->route('membership_prices.history')->with('success', $message);
            
        } catch (\Exception $e) {
            // Manejo de errores genérico (p. ej., si falla la conexión a DB)
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al intentar eliminar el precio.');
        }
    }








}
