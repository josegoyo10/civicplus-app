<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class EventControllerTest extends TestCase
{
    public function it_displays_event_list_on_index_page()
    {
        Http::fake([
            'http://interview.civicplus.com/36f16afa-a628-44ca-bbcd-44559771bdcd/api/Events' => Http::response([
                'total' => 1,
                'items' => [
                    [

                        "id" => "38b730cd-3a20-4745-aa35-d0892a8e0105",
                        "title" => "Event 2025",
                        "description" => "Event 2025 description",
                        "startDate" => "2024-12-17T00:00:00Z",
                        "endDate" => "2024-12-21T00:00:00Z"
                    ],
                ],
            ], 200),
        ]);

        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('events.index');
        $response->assertViewHas('events');
    }

    public function it_handles_api_failure_gracefully()
    {
        Http::fake([
            'http://interview.civicplus.com/36f16afa-a628-44ca-bbcd-44559771bdcd/api/Events' => Http::response([
                'message' => 'API request failed',
            ], 500),
        ]);

        $response = $this->get(route('events.index'));

        $response->assertStatus(302); 
        $response->assertSessionHasErrors('API request failed');
    }
}
