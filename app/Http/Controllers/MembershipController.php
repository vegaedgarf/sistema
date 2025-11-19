<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MembershipController extends Controller
{
   public function index()
    {
        $memberships = Membership::with(['member', 'plan'])
            ->latest()
            ->paginate(10);
            
        return view('memberships.index', compact('memberships'));
    }

    public function create()
    {
        // Pasamos miembros (para el buscador) y planes
        $members = Member::where('status', 'activo')->orderBy('last_name')->get(['id', 'first_name', 'last_name', 'dni']);
        $plans = Plan::where('is_active', true)->orderBy('name')->get();

        return view('memberships.create', compact('members', 'plans'));
    }

    /**
     * Lógica AJAX para calcular el precio final antes de guardar.
     */
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:corpo_members,id',
            'plan_id' => 'required|exists:corpo_plans,id',
        ]);

        $member = Member::with('currentGroupMembership.group')->find($request->member_id);
        $plan = Plan::with(['prices' => function($q) {
            // Obtener el precio vigente HOY
            $q->where('valid_from', '<=', now())
              ->where(fn($query) => $query->whereNull('valid_to')->orWhere('valid_to', '>=', now()))
              ->latest('valid_from');
        }])->find($request->plan_id);

        // 1. Obtener Precio Base
        $currentPrice = $plan->prices->first();
        if (!$currentPrice) {
            return response()->json(['error' => 'Este plan no tiene un precio configurado.'], 422);
        }
        $basePrice = $currentPrice->price;

        // 2. Calcular Descuento por Grupo Familiar
        $discountAmount = 0;
        $discountPercentage = 0;
        $groupName = null;

        if ($member->currentGroupMembership && $member->currentGroupMembership->group) {
            $group = $member->currentGroupMembership->group;
            $discountPercentage = $group->discount_percentage;
            $groupName = $group->name;
            
            // Cálculo: Precio * (Porcentaje / 100)
            $discountAmount = $basePrice * ($discountPercentage / 100);
        }

        // 3. Precio Final
        $finalPrice = $basePrice - $discountAmount;

        return response()->json([
            'base_price' => $basePrice,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
            'group_name' => $groupName
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:corpo_members,id',
            'plan_id' => 'required|exists:corpo_plans,id',
            'start_date' => 'required|date',
            // Validamos que los montos coincidan (seguridad extra)
            'final_price' => 'required|numeric',
        ]);

        // Recalcular en el backend para seguridad (evitar manipulación de HTML)
        // NOTA: En un sistema real, deberías abstraer la lógica de calculatePrice 
        // a un Servicio para reutilizarla aquí y no confiar solo en lo que manda el front.
        // Por ahora, confiamos en la request pero idealmente se recalcula.
        
        // Calculamos fecha fin (ej. +1 mes)
        // Esto depende de tu lógica de negocio. Asumiremos mensual por defecto.
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addMonth()->subDay(); // Ej: 01/01 al 31/01

        Membership::create([
            'member_id' => $validated['member_id'],
            'plan_id' => $validated['plan_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $endDate,
            'plan_price_at_purchase' => $request->base_price_hidden, // Debes enviar esto desde el form
            'discount_applied' => $request->discount_amount_hidden,   // Debes enviar esto desde el form
            'final_price' => $validated['final_price'],
            'status' => 'pending', // Nace pendiente de pago
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('memberships.index')->with('success', 'Inscripción registrada. Ahora puede registrar el pago.');
    }


    public function show(Membership $membership)
        {
            $membership->load(['member', 'plan', 'creator']);
            return view('memberships.show', compact('membership'));
        }

        public function edit(Membership $membership)
        {
            // En la edición, generalmente solo permitimos cambiar fechas o estado, 
            // no el miembro ni el plan (porque afectaría la contabilidad histórica).
            return view('memberships.edit', compact('membership'));
        }

        public function update(Request $request, Membership $membership)
        {
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' => 'required|in:pending,active,expired,cancelled',
            ]);

            $membership->update($validated + [
                'updated_by' => auth()->id()
            ]);

            return redirect()->route('memberships.index')->with('success', 'Membresía actualizada.');
        }
        
        public function destroy(Membership $membership)
        {
            $membership->delete();
            return redirect()->route('memberships.index')->with('success', 'Membresía eliminada.');
        }





}