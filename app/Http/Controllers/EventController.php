<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Services\EventService;
use App\Http\Requests\EventRequest;
use Exception;
use Redirect;

class EventController extends Controller
{
  //
  private $apiBase = "https://interview.civicplus.com/36f16afa-a628-44ca-bbcd-44559771bdcd/api";

  private $accessToken;
  private $url;

  public function __construct()
  {
    $this->accessToken = request()->bearerToken();
    $this->url = Config::get('values.url') . '/events';
  }

  public function index(EventService $eventService)
  {
    try {
      $events = $eventService->getEvents();
      //dd($events);
      return view('events.index', ['events' => $events['items'] ?? []]);
    } catch (\App\Exceptions\ApiException $e) {
      return back()->withErrors($e->getMessage());
    }
  }

  // Show Add Event Form
  public function create()
  {
    return view('events.create');
  }

  // Store New Event
  public function store(EventRequest $request, EventService $eventService)
  {
    try {
      //dd($request->validated());
      $eventService->createEvent($request->validated());
      return redirect()->route('event.index')->with('message', 'Event added successfully.');
    } catch (\App\Exceptions\ApiException $e) {
      return back()->withErrors($e->getMessage());
    }
  }


  // Show Event Details
  public function show($id, EventService $eventService)
  {

    try {
      //dd($request->validated());
      $event = $eventService->showEvent($id);
      // return redirect()->route('event.index')->with('message', 'Event added successfully.');
      return view('events.show', ['event' => $event]);
    } catch (\App\Exceptions\ApiException $e) {
      return back()->withErrors($e->getMessage());
    }
  // } catch (\Exception $e) {
  //   return back()->withErrors($e->getMessage())->withInput();
  // }
  }
}
