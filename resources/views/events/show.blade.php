@extends('layouts.app')

@section('content')
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $event['title'] }}</h5>
            <p class="card-text">
            <p><strong>Description:</strong> {{ $event['description'] }}</p>
            <p><strong>Start Date:</strong> {{ formatDate($event['startDate'], 'Y-m-d') }}</p>
            <p><strong>End Date:</strong> {{ formatDate($event['endDate'], 'Y-m-d') }}</p>
            </p>
            <a href="{{ route('event.index') }}" class="btn btn-primary">Back to Events</a>
        </div>
    </div>
@endsection
