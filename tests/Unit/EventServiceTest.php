<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\EventService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;
use App\Services\BearerTokenService;

class EventServiceTest extends TestCase
{

    public function it_returns_data_for_successful_api_call()
    {

        Http::fake([
            'http://interview.civicplus.com/36f16afa-a628-44ca-bbcd-44559771bdcd/api/Events' => Http::response([
                'total' => 1,
                'items' => [
                    [
                        'id' => '91af0d34-0ed3-499b-8a8b-8c704557c10b',
                        'title' => 'Event March 2025',
                        'description' => 'New Laravel Developer Congress',
                        'startDate' => '2025-03-04T00:00:00Z',
                        'endDate' => '2025-03-07T00:00:00Z',
                    ],
                ],
            ], 200),
        ]);

        $service = app(EventService::class);
        $response = $service->getEvents();

        $this->assertIsArray($response);
        $this->assertEquals('Event March 2025', $response['items'][0]['title']);
    }

    public function it_throws_exception_on_failed_api_call()
    {
        Http::fake([
            'http://interview.civicplus.com/36f16afa-a628-44ca-bbcd-44559771bdcd/api/Events' => Http::response([
                'message' => 'Unauthorized',
            ], 401),
        ]);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unauthorized');

        $service = app(EventService::class);
        $response = $service->getEvents();
    }

    public function testAddEvent() {
        $service = app(EventService::class);        
        $_SESSION['token'] = "valid_token";
        $eventData = [
            "title" => "New Event",
            "description" => "Event Description",
            "startDate" => "2024-11-21",
            "endDate" => "2024-11-22"
        ];


        $response = $service->createEvent($eventData);
        $this->assertEquals(201, $response['status_code']);
    }
}
