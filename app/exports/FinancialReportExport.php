<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinancialReportExport implements FromView
{
    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
        $payments = Payment::whereYear('payment_date', $this->year)
            ->whereMonth('payment_date', $this->month)
            ->where('status', 'cobrado')
            ->with(['membership.member', 'membership.activities'])
            ->get();

        $total = $payments->sum('amount');

        return view('financial_reports.export_excel', [
            'payments' => $payments,
            'year' => $this->year,
            'month' => $this->month,
            'total' => $total,
        ]);
    }
}
