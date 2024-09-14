@extends('layouts.app')

@section('content')
    <h1>Edit Quiz</h1>
    <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $quiz->title }}" required>
        </div>
        <div class="mb-3">
            <label for="time_limit" class="form-label">Time Limit (seconds)</label>
            <input type="number" class="form-control" id="time_limit" name="time_limit" value="{{ $quiz->time_limit }}" required>
        </div>
        <div class="mb-3">
            <label for="questions" class="form-label">Add or Update Questions</label>
            <select class="form-select" id="questions" name="questions[]" multiple="multiple">
                @foreach ($availableQuestions as $question)
                    <option value="{{ $question->id }}" {{ in_array($question->id, $selectedQuestions) ? 'disabled' : '' }}>
                        {{ $question->text }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Quiz</button>
    </form>

    <h2 class="mt-4">Assigned Questions</h2>
    <ul>
        @foreach ($quiz->questions as $question)
            <li>
                {{ $question->text }}
                <form action="{{ route('quizzes.destroyQuestion', [$quiz->id, $question->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#questions').select2({
            placeholder: 'Select questions',
            allowClear: true
        });
    });
</script>
@endpush
