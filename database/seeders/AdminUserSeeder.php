<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder {
    public function run(): void {
        $user = User::firstOrCreate(['email' => 'admin@corpo.test'], [
            'name' => 'Administrador', 'password' => Hash::make('password'),
        ]);
        if (method_exists($user, 'assignRole')) $user->assignRole('Admin');
    }
}
