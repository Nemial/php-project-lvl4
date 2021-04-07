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

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'Тестовая метка'];
        $response = $this->actingAs($this->user)->post(route('labels.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', ['name' => 'Тестовая метка']);
    }

    public function testShow(): void
    {
        $response = $this->actingAs($this->user)->get(route("labels.show", $this->id));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => 'Изменили метку'];
        $response = $this->actingAs($this->user)->put(route('labels.update', $this->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', ['name' => 'Изменили метку']);
    }

    public function testDestroy(): void
    {
        $label = Label::findOrFail($this->id);
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($label);
    }
}
