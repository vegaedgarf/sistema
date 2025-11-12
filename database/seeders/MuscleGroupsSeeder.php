<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MuscleGroupsSeeder extends Seeder {
    public function run(): void {
        DB::table('corpo_muscle_groups')->insert([
            ['name' => 'Pecho'], ['name' => 'Espalda'], ['name' => 'Piernas'],
            ['name' => 'Hombros'], ['name' => 'Bíceps'], ['name' => 'Tríceps'],
            ['name' => 'Abdominales'],
        ]);
    }
}
