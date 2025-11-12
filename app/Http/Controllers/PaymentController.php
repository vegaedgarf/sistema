<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['member', 'membership'])
            ->orderByDesc('payment_date')
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $members = Member::orderBy('last_name')->get();
        $memberships = Membership::where('active', true)->get();
        return view('payments.create', compact('members', 'memberships'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'      => 'required|exists:corpo_members,id',
            'membership_id'  => 'required|exists:corpo_memberships,id',
            'amount'         => 'required|numeric|min:0',
            'payment_date'   => 'required|date',
            'expires_at'     => 'nullable|date|after_or_equal:payment_date',
            'status'         => 'required|in:cobrado,pendiente,anulado',
            'payment_method' => 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Pago registrado correctamente.');
    }

    public function edit(Payment $payment)
    {
        $members = Member::orderBy('last_name')->get();
        $memberships = Membership::where('active', true)->get();
        return view('payments.edit', compact('payment', 'members', 'memberships'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'member_id'      => 'required|exists:corpo_members,id',
            'membership_id'  => 'required|exists:corpo_memberships,id',
            'amount'         => 'required|numeric|min:0',
            'payment_date'   => 'required|date',
            'expires_at'     => 'nullable|date|after_or_equal:payment_date',
            'status'         => 'required|in:cobrado,pendiente,anulado',
            'payment_method' => 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Pago eliminado correctamente.');
    }
}
