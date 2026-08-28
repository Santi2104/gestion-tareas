<?php

namespace Database\Seeders;

use App\Enums\PriorityLevel;
use App\Enums\TagName;
use App\Enums\TaskStatus;
use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $priorities = Priority::all();

        if ($priorities->isEmpty()) {
            return;
        }

        $sampleTasks = [
            [
                'title' => 'Actualizar manual de bienvenida para nuevos colaboradores',
                'description' => 'Revisar y actualizar la documentación de inducción y beneficios para el ingreso de personal.',
                'status' => TaskStatus::Completed,
                'due_date' => now()->addDays(2)->format('Y-m-d'),
                'priority_level' => PriorityLevel::Low,
                'tags' => [TagName::Hr->value],
            ],
            [
                'title' => 'Revisar métricas de rendimiento del servidor de base de datos',
                'description' => 'Analizar consumo de memoria, queries lentas e índices para optimizar tiempos de respuesta.',
                'status' => TaskStatus::InProgress,
                'due_date' => now()->addDays(4)->format('Y-m-d'),
                'priority_level' => PriorityLevel::High,
                'tags' => [TagName::Dev->value, TagName::Qa->value],
            ],
            [
                'title' => 'Planificar entrevistas de clima laboral del trimestre',
                'description' => 'Coordinar agenda con líderes de equipo para realizar el seguimiento de satisfacción interna.',
                'status' => TaskStatus::Pending,
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'priority_level' => PriorityLevel::Medium,
                'tags' => [TagName::Hr->value],
            ],
            [
                'title' => 'Auditar accesos y permisos de usuarios en la plataforma interna',
                'description' => 'Verificar roles activos y revocar credenciales de cuentas en desuso o reasignadas.',
                'status' => TaskStatus::Completed,
                'due_date' => now()->addDays(1)->format('Y-m-d'),
                'priority_level' => PriorityLevel::High,
                'tags' => [TagName::Dev->value],
            ],
            [
                'title' => 'Validar compatibilidad en navegadores para el portal de clientes',
                'description' => 'Ejecutar pruebas funcionales y de diseño en Safari, Chrome, Firefox y navegadores móviles.',
                'status' => TaskStatus::InProgress,
                'due_date' => now()->addDays(5)->format('Y-m-d'),
                'priority_level' => PriorityLevel::Medium,
                'tags' => [TagName::Qa->value],
            ],
            [
                'title' => 'Organizar taller interno sobre buenas prácticas y metodologías ágiles',
                'description' => 'Preparar material didáctico y dinámicas grupales para la sesión de retroalimentación mensual.',
                'status' => TaskStatus::Pending,
                'due_date' => now()->addDays(10)->format('Y-m-d'),
                'priority_level' => PriorityLevel::Low,
                'tags' => [TagName::Hr->value, TagName::Dev->value],
            ],
        ];

        foreach ($sampleTasks as $item) {
            $tagValues = $item['tags'];
            $priorityLevel = $item['priority_level'];

            $priority = $priorities->first(fn (Priority $p) => $p->name === $priorityLevel || $p->name->value === $priorityLevel->value) ?? $priorities->first();

            $task = Task::firstOrCreate(
                ['title' => $item['title']],
                [
                    'description' => $item['description'],
                    'status' => $item['status'],
                    'due_date' => $item['due_date'],
                    'priority_id' => $priority->id,
                ]
            );

            $tagIds = Tag::whereIn('name', $tagValues)->pluck('id');
            $task->tags()->sync($tagIds);
        }
    }
}
