<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contacts;
use App\Models\Funnel;
use App\Models\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $funnel;
    protected $stage;
    protected $contact;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->funnel = Funnel::factory()->create(['user_id' => $this->user->id]);
        $this->stage = Stage::factory()->create(['funnel_id' => $this->funnel->id]);

        $this->contact = Contacts::factory()->create([
            'funnel_id' => $this->funnel->id,
            'stage_id' => $this->stage->id,
        ]);
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->user)
                        ->getJson("/api/funnels/{$this->funnel->id}/stages/{$this->stage->id}/contacts");

        $response->assertStatus(200)
                ->assertJsonStructure([['id', 'name', 'email', 'phoneNumber', 'position']]);
    }

    public function testStore()
    {
        $data = [
            'position' => 1,
            'name' => 'Test Contact',
            'email' => 'test@example.com',
            'phoneNumber' => '1234567890',
            'dateOfBirth' => '2000-01-01',
            'address' => 'Test Address',
            'buyValue' => 100.50,
        ];

        $response = $this->actingAs($this->user)
                        ->postJson("/api/funnels/{$this->funnel->id}/stages/{$this->stage->id}/contacts", $data);

        $response->assertStatus(201)
                ->assertJson([
                    'message' => 'Contato criado com sucesso',
                    'data' => ['name' => 'Test Contact']
                ]);

        $this->assertDatabaseHas('contacts', ['email' => 'test@example.com']);
    }

    public function testShow()
    {
        $response = $this->actingAs($this->user)
                        ->getJson("/api/contacts/{$this->contact->id}");

        $response->assertStatus(200)
                ->assertJson(['id' => $this->contact->id]);
    }

    public function testUpdate()
    {
        $data = [
            'position' => 2,
            'name' => 'Updated Contact',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($this->user)
                        ->putJson("/api/contacts/{$this->contact->id}", $data);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Contato atualizado com sucesso',
                    'data' => ['name' => 'Updated Contact']
                ]);

        $this->assertDatabaseHas('contacts', ['email' => 'updated@example.com']);
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
                         ->deleteJson("/api/contacts/{$this->contact->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'contato deleteado']);

        $this->assertDatabaseMissing('contacts', ['id' => $this->contact->id]);
    }
}
