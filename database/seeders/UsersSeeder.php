<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder {
    public function run(): void {
        $users = [
            ['name' => 'Administrador', 'email' => 'admin@corpo.test', 'role' => 'Admin'],
            ['name' => 'Entrenador Demo', 'email' => 'trainer@corpo.test', 'role' => 'Entrenador'],
            ['name' => 'Recepcionista Demo', 'email' => 'recepcion@corpo.test', 'role' => 'Recepcionista'],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(['email' => $u['email']], [
                'name' => $u['name'],
                'password' => Hash::make('password'),
            ]);
            if (method_exists($user, 'assignRole')) {
                $user->assignRole($u['role']);
            }
        }
    }
}
