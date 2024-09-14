@extends('layouts.app')

@section('content')
    <h1>Create Quiz</h1>
    <form action="{{ route('quizzes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="time_limit" class="form-label">Time Limit (seconds)</label>
            <input type="number" class="form-control" id="time_limit" name="time_limit" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Quiz</button>
    </form>
@endsection
