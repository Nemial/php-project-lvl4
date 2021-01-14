<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private int $id;
    protected $seed = true;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->id = TaskStatus::first()->id;
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('task_statuses.create'));

        $response->assertOk();
    }

    public function testStore()
    {
        $data = ['name' => 'Тестовый'];
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => 'Тестовый']);
    }

    public function testShow()
    {
        $response = $this->get(route("task_statuses.show", $this->id));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->get(route('task_statuses.edit', $this->id));

        $response->assertOk();
    }

    public function testUpdate()
    {
        $data = ['name' => 'Изменённый'];
        $response = $this->put(route('task_statuses.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', ['name' => 'Изменённый']);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('task_statuses.destroy', $this->id));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->id]);
    }
}
