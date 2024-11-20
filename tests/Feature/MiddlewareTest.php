<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    /** @test */
    public function it_blocks_requests_with_invalid_token()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid-token',
        ])->get('/events');

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid API token. Please authenticate again.',
        ]);
    }

    /** @test */
    public function it_allows_requests_with_valid_token()
    {
        // Simulate a valid token
        $validToken = 'eyJhbGciOiJSUzI1NiIsI';

        $response = $this->withHeaders([
            'Authorization' => "Bearer $validToken",
        ])->get('/events');

        $response->assertStatus(200); // Assuming successful API interaction
    }
}
