<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private int $id;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->make();
        $statuses = TaskStatus::get();
        [$status] = $statuses;
        $this->id = $status->id;
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'Тестовый'];
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => 'Тестовый']);
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => 'Изменённый'];
        $response = $this->actingAs($this->user)->put(route('task_statuses.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => 'Изменённый']);
    }

    public function testDestroy(): void
    {
        $status = TaskStatus::findOrFail($this->id);
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($status);
    }
}
