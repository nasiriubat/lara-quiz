@extends('layouts.app')

@section('content')
    <h1>List of Quizzes</h1>
    <table class="table table-striped">
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
                        @if ($quiz->questions->isEmpty())
                            No questions assigned
                        @else
                            <a href="{{ route('quiz.take', ['quiz' => $quiz->id]) }}" class="btn btn-primary">Take Quiz</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
