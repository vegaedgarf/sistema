<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseCategoriesSeeder extends Seeder {
    public function run(): void {
        DB::table('corpo_exercise_categories')->insert([
            ['name' => 'Fuerza'], ['name' => 'Cardio'], ['name' => 'Estiramiento'],
        ]);
    }
}
