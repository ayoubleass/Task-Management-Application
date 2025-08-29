<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TacheControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $project;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_can_list_tasks_for_a_project()
    {
        Task::factory()->count(3)->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/projects/{$this->project->id}/tasks");

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_task()
    {
        $payload = [
            "title" => "Task1",
            "description" => "This is Task1",
            "assign_to" => "John Jones",
            "status" => "todo",
            'priority' => 'low'
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson("/api/projects/{$this->project->id}/tasks", $payload);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
        ]);

        $payload = [
            "title" => "Updated Task",
            "description" => "Updated description",
            "assign_to" => "Jane Doe",
            "status" => "in_progress",
            'priority' => 'high'
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/tasks/{$task->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Task']);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_task_status()
    {
        $task = Task::factory()->create([
            'project_id' => $this->project->id,
            'status' => 'todo'
        ]);

        $payload = ['status' => 'done'];

        $response = $this->actingAs($this->user, 'sanctum')
            ->patchJson("/api/tasks/{$task->id}/status", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Record status has been updated successfully']);
    }
}
