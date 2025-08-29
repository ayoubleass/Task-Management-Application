<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function unauthenticated_user_cannot_access_projects()
    {
        $response = $this->getJson('/api/projects');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function can_list_projects_for_authenticated_user()
    {
        Project::factory()->count(3)->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/projects');

        $response->assertStatus(200)
                 ->assertJsonStructur0([
                     'succes',
                     'message',
                     'data' => [
                             'id',
                             'title',
                             'description',
                             'user_id',
                             'created_at',
                             'updated_at'
                     ],
                 ]);
    }

    /** @test */
    public function can_create_project()
    {
        $payload = [
            'title' => 'New Project',
            'description' => 'Project description',
        ];

        $response = $this->actingAs($this->user, 'sanctum')
                         ->postJson('/api/project', $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Record created successfully',
                     'data' => [
                         'title' => 'New Project',
                         'description' => 'Project description',
                     ]
                 ]);

        $this->assertDatabaseHas('projects', ['title' => 'New Project']);
    }

    /** @test */
    public function can_update_project()
    {
        $project = Project::factory()->create(['user_id' => $this->user->id]);  

        $payload = ['title' => 'Updated Title'];

        $response = $this->actingAs($this->user, 'sanctum')
                         ->putJson("/api/project/{$project->id}", $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $project->id,
                         'title' => 'Updated Title'
                     ]
                 ]);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function can_delete_project()
    {
        $project = Project::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')
                         ->deleteJson("/api/project/{$project->id}");

        $response->assertStatus(200)
                 ->assertJson(['status' => true]);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
