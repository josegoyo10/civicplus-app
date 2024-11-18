@extends('layouts.app')

@section('content')
    <h1>Event List</h1>
    <a href="{{ route('event.create') }}" class="btn btn-primary">Add Event</a>

    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif



    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event['title'] }}</td>
                    <td>{{ $event['description'] }}</td>
                    <td>{{ formatDate($event['startDate'],'Y-m-d')}}</td>
                    <td>{{ formatDate($event['endDate'],'Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('event.show', $event['id']) }}" class="btn btn-success btn-xs">View Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
