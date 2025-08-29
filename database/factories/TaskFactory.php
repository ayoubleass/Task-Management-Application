<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'assign_to' => $this->faker->name(),
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'done']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'project_id' => \App\Models\Project::factory(),

        ];
    }
}
