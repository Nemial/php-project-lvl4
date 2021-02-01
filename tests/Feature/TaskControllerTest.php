<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $user = User::factory()->make();
        $this->user = $user;
        $this->id = Task::first()->id;
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
        $data = ['name' => 'Тестовый'];
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['name' => 'Тестовый']);
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
        $data = ['name' => 'Изменённый'];
        $response = $this->actingAs($this->user)->put(route('tasks.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', ['name' => 'Изменённый']);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('tasks.destroy', $this->id));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', ['id' => $this->id]);
    }
}
