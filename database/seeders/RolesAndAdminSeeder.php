<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 1. Crear roles
        $roles = ['admin', 'profesor', 'entrenador', 'recepcionista', 'miembro'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 🔹 2. Crear permisos base (opcional)
        $permissions = [
            'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios',
            'ver roles', 'crear roles', 'editar roles', 'eliminar roles',
            'ver permisos', 'crear permisos', 'editar permisos', 'eliminar permisos'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 🔹 3. Asignar todos los permisos al rol admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions(Permission::all());

        // 🔹 4. Crear usuario admin si no existe
        $admin = User::firstOrCreate(
            ['email' => 'admin@corpo.com'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('admin123')
            ]
        );

        // 🔹 5. Asignar rol admin
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        echo "Seeder ejecutado: roles, permisos y usuario admin creados.\n";
    }
}
