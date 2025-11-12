<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            ActivitiesSeeder::class,
            MuscleGroupsSeeder::class,
            ExerciseCategoriesSeeder::class,
            ExercisesSeeder::class,
           // MembershipPricesSeeder::class,
            FinancialReportsSeeder::class,
            RolesAndAdminSeeder::class,
            MemberSeeder::class,
           // CorpoGymSeederPreciosPlanes::class,

        ]);
    }
}



