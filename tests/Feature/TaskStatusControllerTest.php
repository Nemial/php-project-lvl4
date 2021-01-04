<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private int $id;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $taskStatus = new TaskStatus();
        $taskStatus->name = 'В работе';
        $taskStatus->save();
        $this->id = $taskStatus->id;
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $data = ['name' => 'Новый'];
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => 'Новый']);
    }

    public function testShow()
    {
        $response = $this->get(route("task_statuses.show", ['task_status' => $this->id]));
        $response->assertOk();
    }
}
