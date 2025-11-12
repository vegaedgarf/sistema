<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Activity;
use App\Models\MemberActivity;
use App\Models\MembershipPrice;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class MemberActivityController extends Controller
{
    public function index()
    {
        return view('member_activity.index');
    }

    public function show(MemberActivity $memberActivity)
    {
        $memberActivity->load(['member', 'activity', 'membershipPrice', 'createdBy', 'updatedBy']);

        return view('member_activity.show', compact('memberActivity'));
    }

public function create()
    {
        $activities = Activity::all();
        $membershipPrices = MembershipPrice::all();
        
        // CORRECCIÓN CLAVE: Definir la variable $members.
        // Como el formulario de creación usa AJAX para buscar, pasamos una colección vacía 
        // para satisfacer la vista sin cargar todos los miembros de la base de datos.
        $members = collect(); 

        return view('member_activity.create', compact('activities', 'membershipPrices', 'members'));
    }

public function edit($id)
{
    $memberActivity = MemberActivity::findOrFail($id); // O tu lógica de edición
    $activities = Activity::all(); 

    // Aquí SÍ se pasa $memberActivity
    return view('member_activity.edit', compact('memberActivity', 'activities'));
}

/*Con estas modificaciones, tu formulario debería cargar correctamente tanto para la creación (donde `$memberActivity` no existe) como para la edición (donde sí existe).*/








    public function store(Request $request)
    {
        // NOTA: Se ha ajustado la validación para reflejar que la inscripción
        // se vincula al Combo de Precio (membership_price_id) y no a una sola activity_id.
        $validated = $request->validate([
            'member_id'             => 'required|exists:corpo_members,id',
            'membership_price_id'   => 'required|exists:corpo_membership_prices,id', // Debe ser requerido ahora
            'start_date'            => 'required|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
            'amount_paid'           => 'required|numeric|min:0', // Requerido porque es el pago real
            'payment_method'        => 'required|string|max:100', // Requerido ya que hay pago
            'notes'                 => 'nullable|string',
            
            // Estas son solo para la lógica JS y no se guardan en el modelo principal MemberActivity
            'activity_ids'          => 'array', 
            'times_per_week'        => 'array',
        ]);

        // Opcional: Buscar el precio del combo para asegurar la coherencia del monto si fue autocompletado
        $membershipPrice = MembershipPrice::find($validated['membership_price_id']);
        
        // Ya que la inscripción ahora representa la compra del combo, la columna activity_id
        // se puede dejar nula o rellenar con un ID de actividad principal si es necesario en tu DB.
        // Si tu tabla member_activity requiere activity_id, debes reconsiderar la estructura o usar una columna temporal.
        
        // Asumiendo que MemberActivity se liga al Combo/Precio:
        $memberActivity = new MemberActivity($validated);
        $memberActivity->activity_id = null; // O ajusta esto a la lógica de tu DB
        $memberActivity->created_by = auth()->id();
        $memberActivity->save();

        // Si necesitas guardar el detalle de las actividades del combo para esta inscripción
        // (lo que sería ideal para el historial), se necesitaría una tabla intermedia
        // MemberActivityComboDetails, pero lo omitiremos por ahora para no complicar el esquema.

        return redirect()->route('member_activity.index')->with('success', 'Inscripción registrada correctamente.');
    }


    public function update(Request $request, MemberActivity $memberActivity)
    {
        $validated = $request->validate([
            // En la edición no se suele permitir cambiar el miembro o el combo, 
            // sino actualizar las fechas y el pago.
            'member_id'             => 'required|exists:corpo_members,id',
            'membership_price_id'   => 'required|exists:corpo_membership_prices,id', 
            'activity_id'           => 'nullable|exists:corpo_member_activity,id', // Dejamos nullable
            'start_date'            => 'required|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
            'amount_paid'           => 'required|numeric|min:0',
            'payment_method'        => 'required|string|max:100',
            'notes'                 => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();
        $memberActivity->update($validated);

        return redirect()->route('member_activity.index')->with('success', 'Inscripción actualizada correctamente.');
    }
    
    // ... (Resto de métodos: destroy, data)
    public function destroy(MemberActivity $memberActivity)
    {
        $memberActivity->delete();
        return redirect()->route('member_activity.index')->with('success', 'Inscripción eliminada correctamente.');
    }

    public function data(Request $request)
    {
        $query = MemberActivity::with(['member', 'activity', 'membershipPrice.activity']);

        // 🔎 Filtros opcionales (código sin cambios)
        if ($request->filled('member')) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->member}%")
                  ->orWhere('last_name', 'like', "%{$request->member}%");
            });
        }

        if ($request->filled('activity')) {
            $query->whereHas('activity', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->activity}%");
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('start_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('start_date', '<=', $request->to);
        }

        // ✅ DataTables response
        return DataTables::of($query)
            ->addColumn('member', function ($row) {
                return $row->member
                    ? "{$row->member->first_name} {$row->member->last_name}"
                    : '-';
            })
            ->addColumn('activity', function ($row) {
                // Si está ligado a un precio, mostrar el combo, sino la actividad simple
                if ($row->membershipPrice) {
                    return $row->membershipPrice->activity
                        ->map(fn($a) => "{$a->name} ({$a->pivot->times_per_week}x)")
                        ->implode(' + ');
                }
                return $row->activity->name ?? '-';
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date ? $row->start_date->format('d/m/Y') : '-';
            })
            ->editColumn('end_date', function ($row) {
                return $row->end_date ? $row->end_date->format('d/m/Y') : '-';
            })
            ->editColumn('amount_paid', function ($row) {
                return $row->amount_paid !== null
                    ? '$' . number_format($row->amount_paid, 2)
                    : '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y') : '-';
            })
            ->addColumn('actions', function ($row) {
                // 👇 asegúrate que esta vista exista (resources/views/member_activity/partials/actions.blade.php)
                return view('member_activity.partials.actions', ['r' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


/**
     * Busca miembros por DNI, Apellido y/o Nombre y devuelve resultados en JSON.
     * Esta es la lógica para la Etapa 1.
     */
    public function searchMembers(Request $request)
    {
        // Limpiar y obtener los parámetros de búsqueda
        $dni = $request->input('dni');
        $apellido = $request->input('apellido');
        $nombre = $request->input('nombre');
        
        // Si no hay criterios de búsqueda significativos, devolver array vacío.
        if (empty($dni) && empty($apellido) && empty($nombre)) {
            return response()->json([]);
        }

        $query = Member::query();

        if ($dni) {
            $query->where('dni', 'like', "%{$dni}%");
        }
        if ($apellido) {
            $query->where('last_name', 'like', "%{$apellido}%");
        }
        if ($nombre) {
            $query->where('first_name', 'like', "%{$nombre}%");
        }

        // Limitar los resultados para no sobrecargar el frontend, y seleccionar solo los campos necesarios
        $members = $query->limit(15)
            ->get(['id', 'first_name', 'last_name', 'dni']);

        return response()->json($members);
    }

    /**
     * Devuelve los MembershipPrices (combos) disponibles basados en las actividades seleccionadas.
     * Esta es la lógica para la Etapa 3.
     */
    public function getPricesByActivities(Request $request)
    {
        // 1. Validar las IDs de actividad
        $request->validate([
            'activity_ids' => 'required|array',
            'activity_ids.*' => 'exists:corpo_activities,id', // Ajusta 'corpo_activities' a tu tabla real
        ]);

        $selectedActivityIds = $request->input('activity_ids');

        // 2. Obtener precios que incluyen al menos una de las actividades seleccionadas
        // Asume que MembershipPrice tiene una relación Many-to-Many con Activity (llamada 'activity')
        $availablePrices = MembershipPrice::with('activity')
            ->whereHas('activity', function ($query) use ($selectedActivityIds) {
                // Filtra MembershipPrices que tienen AL MENOS una actividad seleccionada
                $query->whereIn('activity_id', $selectedActivityIds);
            })
            // Opcional: Filtrar por precios activos
            ->where('valid_from', '<=', now())
            ->where(function ($query) {
                $query->whereNull('valid_to')
                      ->orWhere('valid_to', '>', now());
            })
            ->get();
        
        // 3. Formatear y devolver la respuesta
        $formattedPrices = $availablePrices->map(function ($price) {
            // Asume que la relación MembershipPrice->activity incluye campos pivot como 'times_per_week'
            $detail = $price->activity
                ->map(fn($a) => "{$a->name} (" . ($a->pivot->times_per_week ?? 'N/A') . "x)")
                ->implode(' + ');

            return [
                'id' => $price->id,
                'price' => number_format($price->price, 2, '.', ''), // Formato numérico sin comas
                'option_text' => $detail . " - $" . number_format($price->price, 2),
                'detail' => $detail,
            ];
        });

        return response()->json($formattedPrices);
    }




/*public function data(Request $request)
{
    $query = MemberActivity::with(['member', 'activity']);

    if ($request->member) {
        $query->whereHas('member', function($q) use ($request) {
            $q->where('first_name', 'like', "%{$request->member}%")
              ->orWhere('last_name', 'like', "%{$request->member}%");
        });
    }

    if ($request->activity) {
        $query->whereHas('activity', function($q) use ($request) {
            $q->where('name', 'like', "%{$request->activity}%");
        });
    }

    if ($request->from) {
        $query->whereDate('start_date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('end_date', '<=', $request->to);
    }
\Log::info('DATA REQUEST', [
    'total' => MemberActivity::count(),
    'records' => MemberActivity::with(['member', 'activity'])->get()->take(3),
]);
    return DataTables::of($query)
        ->addColumn('member', fn($r) => $r->member->first_name . ' ' . $r->member->last_name)
        ->addColumn('activity', fn($r) => $r->activity->name ?? '-')
        ->editColumn('start_date', fn($r) => $r->start_date->format('d/m/Y'))
        ->editColumn('end_date', fn($r) => $r->end_date ? $r->end_date->format('d/m/Y') : '-')
        ->editColumn('amount_paid', fn($r) => '$' . number_format($r->amount_paid, 2))
        ->editColumn('created_at', fn($r) => $r->created_at->format('d/m/Y'))
        ->addColumn('actions', function($r) {
            return view('member_activity.partials.actions', compact('r'))->render();
        })
        ->make(true);
}
*/

}
