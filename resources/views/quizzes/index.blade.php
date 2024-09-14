@extends('layouts.app')

@section('content')
    <h1>Quizzes</h1>
    <a href="{{ route('quizzes.create') }}" class="btn btn-success mb-3">Create New Quiz</a>

    <table class="table table-bordered" id="quizzes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Time Limit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->time_limit }} seconds</td>
                <td>
                    <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
