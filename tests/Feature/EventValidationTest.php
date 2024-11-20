<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventValidationTest extends TestCase
{
   /** @test */
   public function it_validates_event_creation_inputs()
   {
       $response = $this->post(route('events.store'), [
           'title' => '',
           'description' => 'Final event',
           'startDate' => 'invalid-date',
           'endDate' => '',
       ]);

       $response->assertSessionHasErrors([
           'title',
           'description',
           'startDate',
           'endDate',
       ]);
   }

   /** @test */
   public function it_accepts_valid_event_inputs()
   {
       $response = $this->post(route('events.store'), [
           'title' => 'New Event',
           'description' => 'This is a valid description today.',
           'startDate' => '2024-12-15',
           'endDate' => '2024-12-16',
       ]);

       $response->assertStatus(302); 
       $response->assertSessionHasNoErrors();
   }
}
