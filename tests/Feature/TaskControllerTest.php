<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    private int $id;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->user = $user;
        $this->id = DB::table('tasks')->insertGetId(
            [
                'name' => 'Test',
                'status_id' => 1,
                'description' => 'Test description',
                'created_by_id' => $this->user->id,
                'assigned_to_id' => $this->user->id
            ]
        );
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testStore()
    {
        $data = [
            'name' => 'StoreTest',
            'status_id' => 3,
            'description' => 'It is stored test task',
            'created_by_id' => $this->user->id,
            'assigned_to_id' => $this->user->id
        ];
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['name' => 'StoreTest']);
    }

    public function testShow()
    {
        $response = $this->get(route("tasks.show", $this->id));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.edit', $this->id));

        $response->assertOk();
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'TestUpdated',
            'status_id' => '2',
            'created_by_id' => $this->user->id,
            'assigned_to_id' => $this->user->id
        ];
        $response = $this->actingAs($this->user)->put(route('tasks.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['name' => 'TestUpdated']);
    }

    public function testDestroy()
    {
        $task = Task::findOrFail($this->id);
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($task);
    }
}
