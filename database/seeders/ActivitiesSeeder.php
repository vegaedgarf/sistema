<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder {
    public function run(): void {
        DB::table('corpo_activities')->insert([
            ['name' => 'Musculación', 'description' => 'Entrenamiento con pesas.', 'created_by' => '1','created_at' =>'2025-11-09 23:16:04','updated_at' =>'2025-11-09 23:16:04'],
            ['name' => 'Pilates', 'description' => 'Ejercicios de flexibilidad y fuerza.', 'created_by' => '1','created_at' =>'2025-11-09 23:16:04','updated_at' =>'2025-11-09 23:16:04'],
            ['name' => 'Funcional', 'description' => 'Entrenamiento funcional.', 'created_by' => '1','created_at' =>'2025-11-09 23:16:04','updated_at' =>'2025-11-09 23:16:04'],
            ['name' => 'yoga', 'description' => 'Entrenamiento yoga.', 'created_by' => '1','created_at' =>'2025-11-09 23:16:04','updated_at' =>'2025-11-09 23:16:04'],
            ['name' => 'boxeo', 'description' => 'Entrenamiento boxeo.', 'created_by' => '1','created_at' =>'2025-11-09 23:16:04','updated_at' =>'2025-11-09 23:16:04'],
            ['name' => 'karate', 'description' => 'Entrenamiento karate.', 'created_by' => '1','created_at' =>'2025-11-09 23:16:04','updatedat' =>'2025-11-09 23:16:04'],

        ]);
    }
}

