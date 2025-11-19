<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Payment;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class FinancialReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'corpo_financial_reports';

    protected $fillable = [
        'year_month',
        'total_memberships_paid',
        'total_memberships_pending',
        'total_income',
        'income_by_activity',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'income_by_activity' => 'array', // para almacenar JSON
    ];

    /* ==========================
       🔗 RELACIONES
       ========================== */

    /** Usuario que creó el reporte */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Usuario que actualizó el reporte */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /* ==========================
       ⚙️ MÉTODOS DE CÁLCULO
       ========================== */

    /**
     * Genera o actualiza un reporte financiero mensual.
     * @param string $yearMonth Formato "YYYY-MM"
     * @return FinancialReport
     */
    public static function generateMonthlyReport(string $yearMonth): FinancialReport
    {
        // === Filtrar pagos del mes ===
        $payments = Payment::whereRaw("DATE_FORMAT(payment_date, '%Y-%m') = ?", [$yearMonth])->get();

        $totalPaid     = $payments->where('status', 'cobrado')->sum('amount');
        $totalPending  = $payments->where('status', 'pendiente')->count();
        $totalPaidCount = $payments->where('status', 'cobrado')->count();

        // === Calcular ingresos agrupados por actividad ===
        $incomeByActivity = DB::table('corpo_payments as p')
            ->join('corpo_memberships as m', 'm.id', '=', 'p.membership_id')
            ->leftJoin('corpo_member_activity as ma', 'ma.member_id', '=', 'p.member_id')
            ->leftJoin('corpo_activities as a', 'a.id', '=', 'ma.activity_id')
            ->select(DB::raw('a.name as activity_name, SUM(p.amount) as total_income'))
            ->whereRaw("DATE_FORMAT(p.payment_date, '%Y-%m') = ?", [$yearMonth])
            ->groupBy('a.name')
            ->pluck('total_income', 'activity_name')
            ->toArray();

        // === Crear o actualizar registro ===
        $report = self::updateOrCreate(
            ['year_month' => $yearMonth],
            [
                'total_memberships_paid'    => $totalPaidCount,
                'total_memberships_pending' => $totalPending,
                'total_income'              => $totalPaid,
                'income_by_activity'        => $incomeByActivity,
            ]
        );

        return $report;
    }

    /**
     * Devuelve un reporte existente o lo genera si no está.
     */
    public static function getOrGenerate(string $yearMonth): FinancialReport
    {
        return self::where('year_month', $yearMonth)->first()
            ?? self::generateMonthlyReport($yearMonth);
    }

    /**
     * Genera reportes de todo un año.
     */
    public static function generateYearlyReports(int $year): array
    {
        $reports = [];
        for ($month = 1; $month <= 12; $month++) {
            $ym = sprintf('%04d-%02d', $year, $month);
            $reports[$ym] = self::generateMonthlyReport($ym);
        }
        return $reports;
    }
}
