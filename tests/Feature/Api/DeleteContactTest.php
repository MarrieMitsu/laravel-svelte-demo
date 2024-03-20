<?php

namespace Tests\Feature\Api;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_contact_api(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete("/api/contact/{$contact->id}");

        $response->assertStatus(204);
    }
}
