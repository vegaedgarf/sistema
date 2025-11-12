<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\FinancialReport;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;

class FinancialReportController extends Controller
{
    /**
     * Muestra el resumen general de ingresos.
     */
    public function index(Request $request)
    {
        $year  = $request->input('year', date('Y'));
        $month = $request->input('month');
        $activityId = $request->input('activity_id');
        $paymentMethod = $request->input('payment_method');

        // === FILTRO BASE ===
        $query = Payment::query()
            ->whereYear('payment_date', $year)
            ->where('status', 'cobrado');

        if ($month) {
            $query->whereMonth('payment_date', $month);
        }

        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        if ($activityId) {
            $query->whereHas('membership.activities', function ($q) use ($activityId) {
                $q->where('corpo_activities.id', $activityId);
            });
        }

        $payments = $query->with(['membership.member', 'membership.activities'])->get();

        $totalIncome = $payments->sum('amount');

        // === RESUMEN MENSUAL PARA GRÁFICO ===
        $monthlySummary = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereYear('payment_date', $year)
            ->where('status', 'cobrado')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('financial_reports.index', compact('payments', 'totalIncome', 'monthlySummary'));
    }

    /**
     * Mostrar formulario de creación manual.
     */
    public function create()
    {
        return view('financial_reports.create');
    }

    /**
     * Guardar un nuevo registro manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        // Se guarda como "pago manual"
        Payment::create([
            'member_id' => null,
            'membership_id' => null,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => 'cobrado',
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('financial_reports.index')
            ->with('success', 'Ingreso registrado correctamente.');
    }

    /**
     * Mostrar detalle mensual.
     */
    public function show($year, $month)
    {
        $payments = Payment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->where('status', 'cobrado')
            ->with(['membership.member', 'membership.activities'])
            ->get();

        $total = $payments->sum('amount');

        return view('financial_reports.show', compact('payments', 'year', 'month', 'total'));
    }

    /**
     * Editar un registro individual.
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('financial_reports.edit', compact('payment'));
    }

    /**
     * Actualizar registro.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('financial_reports.index')
            ->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Eliminar registro manual.
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('financial_reports.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

    /**
     * Generar o actualizar automáticamente el reporte mensual consolidado.
     */
    public function generateMonthlyReport($year, $month)
    {
        $totalPaid = Payment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->where('status', 'cobrado')
            ->sum('amount');

        $totalPending = Payment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->where('status', 'pendiente')
            ->sum('amount');

        $incomeByActivity = Payment::selectRaw('corpo_activities.name, SUM(corpo_payments.amount) as total')
            ->join('corpo_memberships', 'corpo_payments.membership_id', '=', 'corpo_memberships.id')
            ->join('corpo_member_activity', 'corpo_member_activity.membership_price_id', '=', 'corpo_memberships.id')
            ->join('corpo_activities', 'corpo_member_activity.activity_id', '=', 'corpo_activities.id')
            ->whereYear('corpo_payments.payment_date', $year)
            ->whereMonth('corpo_payments.payment_date', $month)
            ->groupBy('corpo_activities.name')
            ->pluck('total', 'corpo_activities.name');

        FinancialReport::updateOrCreate(
            ['year_month' => sprintf('%04d-%02d', $year, $month)],
            [
                'total_memberships_paid' => $totalPaid,
                'total_memberships_pending' => $totalPending,
                'total_income' => $totalPaid,
                'income_by_activity' => $incomeByActivity,
                'updated_by' => auth()->id(),
            ]
        );

        return redirect()->route('financial_reports.index')
            ->with('success', 'Reporte mensual actualizado correctamente.');
    }

public function exportPDF($year, $month)
{
    $payments = Payment::whereYear('payment_date', $year)
        ->whereMonth('payment_date', $month)
        ->where('status', 'cobrado')
        ->with(['membership.member', 'membership.activities'])
        ->get();

    $total = $payments->sum('amount');

    $pdf = Pdf::loadView('financial_reports.export_pdf', compact('payments', 'year', 'month', 'total'))
        ->setPaper('a4', 'portrait');

    return $pdf->download("reporte-financiero-{$year}-{$month}.pdf");
}

public function exportExcel($year, $month)
{
    return Excel::download(new FinancialReportExport($year, $month), "reporte-financiero-{$year}-{$month}.xlsx");
}




}
