<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Solo llamamos a las clases Seeder.
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            ActivitiesSeeder::class,
            MuscleGroupsSeeder::class,
            ExerciseCategoriesSeeder::class,
            ExercisesSeeder::class,
            MemberSeeder::class,
            CorpoPlansSeeder::class, // Debe ir antes de cualquier pago/membresía
            CorpoFamilyGroupsSeeder::class,
           // MembershipPricesSeeder::class,
            FinancialReportsSeeder::class,
            RolesAndAdminSeeder::class,
          // CorpoGymSeederPreciosPlanes::class,

        ]);
    }
}