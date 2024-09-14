@extends('layouts.app')

@section('content')
    <h1>Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-success mb-3">Create New Question</a>

    <table class="table table-bordered" id="questions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Text</th>
                <th>Options</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
            <tr>
                <td>{{ $question->id }}</td>
                <td>{{ $question->text }}</td>
                <td>
                    @foreach ($question->options as $option)
                        <div>{{ $option->text }} ({{ $option->is_correct ? 'Correct' : 'Incorrect' }})</div>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline">
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
