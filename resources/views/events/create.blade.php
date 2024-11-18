@extends('layouts.app')

@section('content')
    <h1>Add Event</h1>
    @if (isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('event.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="add title">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>


        <div class="mb-3">
            <label for="description" class="form-label">Start Date:</label>
            <input type="date" name="startDate" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">End Date:</label>
            <input type="date" name="endDate" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
@endsection
