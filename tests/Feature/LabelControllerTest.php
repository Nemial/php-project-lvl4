<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    private Label $label;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
        $this->label = Label::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.index'));
        $response->assertSee("{$this->label->id}");
        $response->assertSee($this->label->name);
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));

        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = Label::factory()->labelData()->make()->toArray(); /** @phpstan-ignore-line */
        $response = $this->actingAs($this->user)->post(route('labels.store'), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testShow(): void
    {
        $response = $this->actingAs($this->user)->get(route("labels.show", $this->label->id));
        $response->assertSee("{$this->label->id}");
        $response->assertSee($this->label->name);
        $response->assertSee($this->label->description);
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label->id));

        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = Label::factory()->labelUpdatedData()->make()->toArray(); /** @phpstan-ignore-line */
        $response = $this->actingAs($this->user)->put(route('labels.update', $this->label->id), $data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy(): void
    {
        $label = Label::findOrFail($this->label->id);
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDeleted($label);
    }
}
