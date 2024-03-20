<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetContactListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_contact_list_api(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/contact');

        $response->assertStatus(200);
    }
}
