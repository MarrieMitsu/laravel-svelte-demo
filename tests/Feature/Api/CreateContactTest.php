<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_contact_api(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/contact', [
            'name' => 'Lanaya',
            'email' => 'lanaya@mail.com',
        ]);

        $response->assertStatus(201);
    }

    public function test_create_contact_api_invalid_email(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/contact', [
            'name' => 'Lanaya',
            'email' => 'invalid_email',
        ]);

        $response->assertStatus(422);
    }

    public function test_create_contact_api_missing_attributes(): void
    {
        $payload_cases = [
            [
                'email' => 'lanaya@mail.com',
            ],
            [
                'name' => 'Lanaya',
            ]
        ];

        foreach ($payload_cases as $payload) {
            $response = $this->withHeaders([
                'Accept' => 'application/json',
            ])->post('/api/contact', $payload);

            $response->assertStatus(422);
        }
    }
}
