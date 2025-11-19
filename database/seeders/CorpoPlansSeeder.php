<?php

// database/seeders/CorpoPlansSeeder.php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanDetail;
use App\Models\PlanPrice;
use App\Models\Activity; // Refactorizado de CorpoActivity
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CorpoPlansSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtener IDs de Actividades base
        $musculacion = Activity::where('name', 'Musculación')->firstOrFail();
        $pilates = Activity::where('name', 'Pilates')->firstOrFail();
        $funcional = Activity::where('name', 'Funcional')->firstOrFail();

        // -----------------------------------------------------------
        // 1. CREACIÓN DE PLANES Y DETALLES
        // -----------------------------------------------------------

        // --- Plan 1: Plan Básico (Musculación 5x) ---
        $planBasico = Plan::create([
            'name' => 'Plan Muscle 5x',
            'description' => 'Acceso a sala de pesas, 5 veces por semana.',
            'is_active' => true,
        ]);

        PlanDetail::create([
            'plan_id' => $planBasico->id,
            'activity_id' => $musculacion->id,
            'times_per_week' => 5,
        ]);

        // --- Plan 2: Plan Combinado (Pilates 2x + Funcional 3x) ---
        $planCombinado = Plan::create([
            'name' => 'Plan Full Combo',
            'description' => 'Combina lo mejor: 2 sesiones de Pilates y 3 sesiones de Funcional.',
            'is_active' => true,
        ]);

        PlanDetail::create([
            'plan_id' => $planCombinado->id,
            'activity_id' => $pilates->id,
            'times_per_week' => 2,
        ]);

        PlanDetail::create([
            'plan_id' => $planCombinado->id,
            'activity_id' => $funcional->id,
            'times_per_week' => 3,
        ]);
        
        // -----------------------------------------------------------
        // 2. CREACIÓN DE PRECIOS (CON HISTORIAL)
        // -----------------------------------------------------------
        
        // Plan Básico - Precio Antiguo
        PlanPrice::create([
            'plan_id' => $planBasico->id,
            'price' => 15000.00,
            'valid_from' => Carbon::parse('2025-10-01'),
            'valid_to' => Carbon::parse('2025-10-31'),
        ]);
        
        // Plan Básico - Precio Actual
        $planBasicoPriceId = PlanPrice::create([
            'plan_id' => $planBasico->id,
            'price' => 18000.00,
            'valid_from' => Carbon::parse('2025-11-01'),
            'valid_to' => null, 
        ]);

        // Plan Combinado - Precio Actual
        PlanPrice::create([
            'plan_id' => $planCombinado->id,
            'price' => 35000.00,
            'valid_from' => Carbon::today()->subMonths(3),
            'valid_to' => null, 
        ]);
        
        $this->command->info('✅ Planes, Detalles y Precios sembrados (Modelos: Plan, PlanDetail, PlanPrice).');
    }
}