<?php

namespace Tests\Feature;
use App\Http\Middleware\InjectBearerToken;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\EventService;
use App\Services\BearerTokenService;
use Illuminate\Http\Request;

class InjectBearerTokenTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testMiddlewareInjectsToken()
    {
      
    }
}
