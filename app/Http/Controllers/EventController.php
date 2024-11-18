<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config; 
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
         $this->url = Config::get('values.url').'/events';
     }
     //private $apiBase = $_ENV['APP_ENV'];
    
    // private function getAccessToken()
    // {
    //     $clientId = "36f16afa-a628-44ca-bbcd-44559771bdcd";
    //     $clientSecret = "bubtdyqxv0pv5zwf007payoofgsscwwjqcki8dekeccx";
        
    //     $url = "{$this->apiBase}/Auth";
    //     $postData = [
    //         "ClientId" => $clientId,
    //         "ClientSecret" => $clientSecret,
    //     ];

    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $data = json_decode($response, true);
    //     return $data['access_token'] ?? null;
    // }


    // Display Event List
    public function index()
    {

       // dd($this->apiBase);
        //echo "token:" . $token ."<br>\n";
        //dd(request()->headers->all());

        //$accessToken = $this->getAccessToken();
        //$accessToken = request()->bearerToken();

        //dd($accessToken);
        //$url = "{$this->apiBase}/events";
        //$url = Config::get('values.url').'/events';

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer  $this->accessToken"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $events = json_decode($response, true);
        //dd($events);
        return view('events.index', ['events' => $events['items'] ?? []]);
    }                                           

    // Show Add Event Form
    public function create()
    {
        return view('events.create');
    }

    // Store New Event
    public function store(Request $request)
    {
        // $accessToken = $this->getAccessToken();
        // $url = "{$this->apiBase}/events";
        //dd($request);
        //$this->validateInput($request->all());
        //dd($request->all());
        //dd($postData);
        $errors = [];
        $title = $request->input('title');
        $description = $request->input('description');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (empty($title)) {
          $errors[] = 'The title is required.';
      }

      if (empty($description)) {
          $errors[] = 'The description is required.';
      }

      if (empty($startDate)) {
          $errors[] = 'The start date is required.';
      } elseif (!strtotime($startDate)) {
          $errors[] = 'The start date must be a valid date.';
      }

      if (empty($endDate)) {
          $errors[] = 'The end date is required.';
      } elseif (!strtotime($endDate)) {
          $errors[] = 'The end date must be a valid date.';
      }

      if (!empty($startDate) && !empty($endDate) && strtotime($startDate) > strtotime($endDate)) {
          $errors[] = 'The start date cannot be later than the end date.';
      }


      if (!empty($errors)) {
        
        return redirect('/event/create')->withErrors([ 'errors' => $errors]);
    }
        
        $postData = [
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "startDate" => $request->input('startDate'),
            "endDate" => $request->input('endDate'),
        ];

        //dd($request->input('start_date'));

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $this->accessToken",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        //dd($response);
        curl_close($ch);

        return redirect()->route('event.index')->with('message', 'Event added successfully!');
    }

    // Show Event Details
    public function show($id)
    {
        //$accessToken = $this->getAccessToken();
        //$url = "{$this->apiBase}/events/{$id}";

        $ch = curl_init($this->url.'/'.$id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $this->accessToken"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $event = json_decode($response, true);
        return view('events.show', ['event' => $event]);
       
    }
  
   
    }
