<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder {
    public function run(): void {
        $roles = [
            'admin' => [
                'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios',
                'ver miembros', 'crear miembros', 'editar miembros', 'eliminar miembros',
                'ver rutinas', 'crear rutinas', 'editar rutinas', 'eliminar rutinas',
                'ver pagos', 'crear pagos', 'editar pagos', 'eliminar pagos',
                'ver reportes', 'exportar reportes',
            ],
             'profesor' => [
                'ver miembros', 'editar miembros',
                'ver rutinas', 'crear rutinas', 'editar rutinas',
            ],
            'entrenador' => [
                'ver miembros', 'editar miembros',
                'ver rutinas', 'crear rutinas', 'editar rutinas',
            ],
            'recepcionista' => [
                'ver miembros', 'crear miembros',
                'ver pagos', 'crear pagos',
            ],
            'miembro' => [
                'ver rutinas', 'ver pagos',
            ],
        ];
    // === Crear permisos únicos ===
        $allPermissions = collect($roles)->flatten()->unique();
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

 app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === Crear roles y asignar permisos ===
 
foreach ($roles as $roleName => $permissions) {
    $normalized = strtolower($roleName);
    $role = Role::firstOrCreate(['name' => $normalized]);
    $role->syncPermissions($permissions);
}

        // === Crear usuario admin inicial ===
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@corpo.test'],
            ['name' => 'Administrador', 'password' => bcrypt('123456')]
        );
        $adminUser->assignRole('admin');
    }
}
