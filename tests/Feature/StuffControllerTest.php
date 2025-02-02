<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\StuffModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StuffControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_display_the_index_page()
    {
        $response = $this->get('/stuffs');
        $response->assertStatus(200);
        $response->assertViewIs('stuff.index');
    }

    #[Test]
    public function it_can_display_the_create_page()
    {
        $response = $this->get('/stuffs/create');
        $response->assertStatus(200);
        $response->assertViewIs('stuff.create');
    }

    #[Test]
    public function it_can_store_a_new_stuff()
    {
        $response = $this->post('/stuffs', [
            'code' => 'CODE123',
            'name' => 'Stuff Name'
        ]);

        $response->assertRedirect('/stuffs');
        $this->assertDatabaseHas('stuffs', [
            'code' => 'CODE123',
            'name' => 'Stuff Name'
        ]);
    }

    #[Test]
    public function it_can_display_a_single_stuff()
    {
        $stuff = StuffModel::factory()->create();

        $response = $this->get("/stuffs/{$stuff->id}");
        $response->assertStatus(200);
        $response->assertViewIs('stuff.show');
        $response->assertViewHas('stuff', $stuff);
    }

    #[Test]
    public function it_can_display_the_edit_page()
    {
        $stuff = StuffModel::factory()->create();

        $response = $this->get("/stuffs/{$stuff->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('stuff.edit');
        $response->assertViewHas('stuff', $stuff);
    }

    #[Test]
    public function it_can_update_a_stuff()
    {
        $stuff = StuffModel::factory()->create();

        $response = $this->put("/stuffs/{$stuff->id}", [
            'code' => 'NEWCODE123',
            'name' => 'New Stuff Name'
        ]);

        $response->assertRedirect('/stuffs');
        $this->assertDatabaseHas('stuffs', [
            'id' => $stuff->id,
            'code' => 'NEWCODE123',
            'name' => 'New Stuff Name'
        ]);
    }

    #[Test]
    public function it_can_delete_a_stuff()
    {
        $stuff = StuffModel::factory()->create();

        $response = $this->delete("/stuffs/{$stuff->id}");
        $response->assertRedirect('/stuffs');
        $this->assertDatabaseMissing('stuffs', [
            'id' => $stuff->id
        ]);
    }
}
