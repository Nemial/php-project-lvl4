<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private int $id;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::factory()->create();
        $statuses = TaskStatus::where('name', 'Новый')->get();
        [$status] = $statuses;
        $this->id = DB::table('tasks')->insertGetId(
            [
                'name' => 'Test',
                'status_id' => $status->id,
                'description' => 'Test description',
                'created_by_id' => $this->user->id,
                'assigned_to_id' => $this->user->id
            ]
        );
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
        $statuses = TaskStatus::where('name', 'На тестировании')->get();
        [$status] = $statuses;
        $data = [
            'name' => 'StoreTest',
            'status_id' => $status->id,
            'description' => 'It is stored test task',
            'created_by_id' => $this->user->id,
            'assigned_to_id' => $this->user->id
        ];
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['name' => 'StoreTest']);
    }

    public function testShow(): void
    {
        $response = $this->actingAs($this->user)->get(route("tasks.show", $this->id));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.edit', $this->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $statuses = TaskStatus::where('name', 'В работе')->get();
        [$status] = $statuses;
        $data = [
            'name' => 'TestUpdated',
            'status_id' => $status->id,
            'created_by_id' => $this->user->id,
            'assigned_to_id' => $this->user->id
        ];
        $response = $this->actingAs($this->user)->put(route('tasks.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['name' => 'TestUpdated']);
    }

    public function testDestroy(): void
    {
        $task = Task::findOrFail($this->id);
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($task);
    }
}
