<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = Task::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testShow(): void
    {
        $response = $this->actingAs($this->user)->get(route("tasks.show", $this->task->id));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.edit', $this->task->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = Task::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->put(route('tasks.update', $this->task->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy(): void
    {
        $task = Task::findOrFail($this->task->id);
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($task);
    }
}
