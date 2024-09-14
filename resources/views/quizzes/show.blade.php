@extends('layouts.app')

@section('content')
    <h1>{{ $quiz->title }}</h1>
    <p>Time Limit: {{ $quiz->time_limit }} seconds</p>
    <a href="{{ route('quizzes.take', $quiz->id) }}">Start Quiz</a>
@endsection
