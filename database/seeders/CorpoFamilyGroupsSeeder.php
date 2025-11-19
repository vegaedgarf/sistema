<?php

namespace Database\Seeders;

use App\Models\FamilyGroup;          // El "catálogo" de grupos
use App\Models\FamilyGroupMembership;  // El "modelo pivote" con historial
use App\Models\Member;               // El miembro
use Illuminate\Database\Seeder;
use Carbon\Carbon;                   // Necesario para las fechas

class CorpoFamilyGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Creamos el "Catálogo" de Grupos de Descuento
        $familiaPerez = FamilyGroup::create([
            'name' => 'Grupo Familiar Pérez/González',
            'discount_percentage' => 15.00, // 15% de descuento
            'is_active' => true,
        ]);

        $grupoVIP = FamilyGroup::create([
            'name' => 'Grupo VIP',
            'discount_percentage' => 25.00,
            'is_active' => true,
        ]);
        
        $this->command->info('✅ Grupos Familiares (FamilyGroup) sembrados.');

        // 2. Creamos el "Historial" de asignaciones (datos de ejemplo)
        $juanPerez = Member::find(1);
        $mariaGonzalez = Member::find(2);

        if ($juanPerez && $mariaGonzalez) {
            
            // Juan Pérez está actualmente activo en el grupo
            FamilyGroupMembership::create([
                'family_group_id' => $familiaPerez->id,
                'member_id' => $juanPerez->id,
                'start_date' => Carbon::today()->subMonths(3), // Se unió hace 3 meses
                'end_date' => null, // 'null' significa que es la membresía activa
            ]);

            // María González *estuvo* en el grupo, pero ya no (Historial)
            FamilyGroupMembership::create([
                'family_group_id' => $familiaPerez->id,
                'member_id' => $mariaGonzalez->id,
                'start_date' => Carbon::today()->subYear(), // Se unió hace un año
                'end_date' => Carbon::today()->subMonths(2), // Se fue hace 2 meses
            ]);
            
            $this->command->info('✅ Asignaciones de grupos (FamilyGroupMembership) sembradas.');
        
        } else {
             $this->command->warn('⚠️ No se encontraron miembros 1 y 2. Se omitió la siembra de asignaciones de grupos.');
        }
    }
}