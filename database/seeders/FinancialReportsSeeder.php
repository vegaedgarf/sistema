<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialReportsSeeder extends Seeder {
    public function run(): void {
        DB::table('corpo_financial_reports')->insert([
            [
                'year_month' => '2025-01',
                'total_memberships_paid' => 120,
                'total_memberships_pending' => 10,
                'total_income' => 185000,
                'income_by_activity' => json_encode(['Musculación' => 90000, 'Pilates' => 50000, 'Funcional' => 45000]),
                'created_by' => 1
            ],
        ]);
    }
}
