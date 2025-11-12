<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExercisesSeeder extends Seeder {
    public function run(): void {
        DB::table('corpo_exercises')->insert([
            ['name' => 'Press de banca', 'exercise_category_id' => 1, 'muscle_group_id' => 1, 'video_url' => 'https://www.youtube.com/watch?v=gRVjAtPip0Y'],
            ['name' => 'Sentadillas', 'exercise_category_id' => 1, 'muscle_group_id' => 3, 'video_url' => 'https://www.youtube.com/watch?v=aclHkVaku9U'],
            ['name' => 'Remo con barra', 'exercise_category_id' => 1, 'muscle_group_id' => 2, 'video_url' => 'https://www.youtube.com/watch?v=vT2GjY_Umpw'],
        ]);
    }
}
