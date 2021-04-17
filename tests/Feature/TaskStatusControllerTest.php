<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $originalStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
        $this->originalStatus = TaskStatus::factory()->create();
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
        $data = TaskStatus::factory()->statusData()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->originalStatus->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = TaskStatus::factory()->statusUpdatedData()->make()->toArray();
        $response = $this->actingAs($this->user)->put(route('task_statuses.update', $this->originalStatus->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy(): void
    {
        $status = TaskStatus::findOrFail($this->originalStatus->id);
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($status);
    }
}
