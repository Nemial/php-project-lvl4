<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private int $id;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
        $this->id = \DB::table('labels')->insertGetId(['name' => 'Первая метка']);
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore()
    {
        $data = ['name' => 'Тестовая метка'];
        $response = $this->actingAs($this->user)->post(route('labels.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', ['name' => 'Тестовая метка']);
    }

    public function testShow()
    {
        $response = $this->get(route("labels.show", $this->id));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->id));

        $response->assertOk();
    }

    public function testUpdate()
    {
        $data = ['name' => 'Изменили метку'];
        $response = $this->actingAs($this->user)->put(route('labels.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', ['name' => 'Изменили метку']);
    }

    public function testDestroy()
    {
        $label = Label::findOrFail($this->id);
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($label);
    }
}
