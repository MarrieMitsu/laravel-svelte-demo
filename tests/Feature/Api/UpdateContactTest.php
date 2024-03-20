<?php

namespace Tests\Feature\Api;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_contact_api(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put("/api/contact/{$contact->id}", [
            'name' => 'edited_name'
        ]);

        $response->assertStatus(204);
    }

    public function test_update_contact_api_invalid_email(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put("/api/contact/{$contact->id}", [
            'email' => 'edited_invalid_email'
        ]);

        $response->assertStatus(422);
    }
}
