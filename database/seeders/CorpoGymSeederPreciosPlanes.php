<?php
 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\MembershipPrice;
use Illuminate\Support\Facades\DB;




class CorpoGymSeederPreciosPlanes extends Seeder
{
    /**
     * Carga las actividades base y los planes de precios asociados.
     * El código ha sido robustecido para evitar IDs nulos.
     */
    public function run(): void
    {
        // 🔹 1. DEFINICIÓN DE ACTIVIDADES
        $activitiesData = [
            ['name' => 'Musculación', 'description' => 'Entrenamiento en sala de pesas', 'active' => true],
            ['name' => 'Pilates', 'description' => 'Ejercicio controlado en colchonetas', 'active' => true],
            ['name' => 'NeoPilates', 'description' => 'Variante avanzada de pilates con equipamiento', 'active' => true],
            ['name' => 'Funcional', 'description' => 'Entrenamiento funcional grupal', 'active' => true],
            ['name' => 'boxeo', 'description' => 'Entrenamiento funcional grupal', 'active' => true],
        ];

        // Array para almacenar las instancias de modelos creados (para acceso seguro al ID)
        $activityModels = [];

        // 🔹 2. CREACIÓN/ACTUALIZACIÓN DE ACTIVIDADES y captura de instancias
        // Capturar la instancia del modelo devuelta por updateOrCreate evita
        // la necesidad de una consulta "first()" separada, lo que previene problemas de sincronización.
        $this->command->info("Creando o actualizando las actividades base...");
        foreach ($activitiesData as $data) {
            $model = Activity::updateOrCreate(['name' => $data['name']], $data);
            $activityModels[$data['name']] = $model;
        }

        // Asignación de variables con las instancias de modelo válidas
        // (Estas instancias YA tienen el ID de la base de datos)
        $musculacion = $activityModels['Musculación'];
        $pilates = $activityModels['Pilates'];
        $neopilates = $activityModels['NeoPilates'];
        $funcional = $activityModels['Funcional'];

        // 🔹 3. DEFINICIÓN DE PLANES Y PRECIOS (usando IDs de modelos garantizados)
        $planes = [
            [
                'price' => 12000,
                'valid_from' => '2025-01-01',
                'valid_to' => '2025-08-01',
                'activities' => [
                    // El ID se extrae del modelo capturado ($musculacion->id), el cual no es null.
                    ['id' => $musculacion->id, 'times_per_week' => 2],
                ],
            ],
            [
                'price' => 14500,
                'valid_from' => '2025-08-02',
                'valid_to' => null,
                'activities' => [
                    ['id' => $musculacion->id, 'times_per_week' => 3],
                ],
            ],
            [
                'price' => 16000,
                'valid_from' => '2025-01-01',
                'valid_to' => null,
                'activities' => [
                    ['id' => $pilates->id, 'times_per_week' => 1],
                    ['id' => $neopilates->id, 'times_per_week' => 1],
                ],
            ],
            [
                'price' => 11000,
                'valid_from' => '2025-01-01',
                'valid_to' => null,
                'activities' => [
                    ['id' => $funcional->id, 'times_per_week' => 2],
                ],
            ],
        ];

        // 🔹 4. CREACIÓN DE PRECIOS Y ASOCIACIÓN CON ACTIVIDADES (Tabla Pivote)
        $this->command->info("Cargando planes de precios y asociaciones...");
        foreach ($planes as $plan) {
            $price = MembershipPrice::create([
                'price' => $plan['price'],
                'valid_from' => $plan['valid_from'],
                'valid_to' => $plan['valid_to'],
                'created_by' => 1,
            ]);

            foreach ($plan['activities'] as $activity) {
                // El método attach utiliza el ID de la actividad para insertar la relación
               $price->activity()->attach($activity['id'], [
                    'times_per_week' => $activity['times_per_week'],
                ]);
            }
        }

        $this->command->info("✅ Seeder ejecutado correctamente: Actividades y precios cargados.");
    }
}


/*
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\MembershipPrice;

class CorpoGymSeederPreciosPlanes extends Seeder
{
    public function run(): void
    {
        // 🔹 ACTIVIDADES BASE
        $activities = [
            ['name' => 'Musculación', 'description' => 'Entrenamiento en sala de pesas', 'active' => true],
            ['name' => 'Pilates', 'description' => 'Ejercicio controlado en colchonetas', 'active' => true],
            ['name' => 'NeoPilates', 'description' => 'Variante avanzada de pilates con equipamiento', 'active' => true],
            ['name' => 'Funcional', 'description' => 'Entrenamiento funcional grupal', 'active' => true],
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(['name' => $activity['name']], $activity);
        }

        $musculacion = Activity::where('name', 'Musculación')->first();
        $pilates = Activity::where('name', 'Pilates')->first();
        $neopilates = Activity::where('name', 'NeoPilates')->first();
        $funcional = Activity::where('name', 'Funcional')->first();

        // 🔹 PLANES Y PRECIOS (con historial)
        $planes = [
            [
                'price' => 12000,
                'valid_from' => '2025-01-01',
                'valid_to' => '2025-08-01',
                'activities' => [
                    ['id' => $musculacion->id, 'times_per_week' => 2],
                ],
            ],
            [
                'price' => 14500,
                'valid_from' => '2025-08-02',
                'valid_to' => null,
                'activities' => [
                    ['id' => $musculacion->id, 'times_per_week' => 3],
                ],
            ],
            [
                'price' => 16000,
                'valid_from' => '2025-01-01',
                'valid_to' => null,
                'activities' => [
                    ['id' => $pilates->id, 'times_per_week' => 1],
                    ['id' => $neopilates->id, 'times_per_week' => 1],
                ],
            ],
            [
                'price' => 11000,
                'valid_from' => '2025-01-01',
                'valid_to' => null,
                'activities' => [
                    ['id' => $funcional->id, 'times_per_week' => 2],
                ],
            ],
        ];

        foreach ($planes as $plan) {
            $price = MembershipPrice::create([
                'price' => $plan['price'],
                'valid_from' => $plan['valid_from'],
                'valid_to' => $plan['valid_to'],
                'created_by' => 1,
            ]);

            foreach ($plan['activities'] as $activity) {
                $price->activities()->attach($activity['id'], [
                    'times_per_week' => $activity['times_per_week'],
                ]);
            }
        }

        echo "✅ Seeder ejecutado correctamente: Actividades y precios cargados.\n";
    }
}
*/