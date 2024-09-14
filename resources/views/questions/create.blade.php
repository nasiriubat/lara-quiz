@extends('layouts.app')

@section('content')
    <h1>Create Question</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label">Question Text</label>
            <input type="text" class="form-control" id="text" name="text" required>
        </div>
        <div class="mb-3">
            <label for="time_limit" class="form-label">Time Limit (seconds)</label>
            <input type="number" class="form-control" id="time_limit" name="time_limit" required>
        </div>
        <div id="options-container">
            <div class="option mb-3">
                <label class="form-label">Option</label>
                <input type="text" class="form-control" name="options[0][text]" required>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="options[0][is_correct]" value="1">
                    <label class="form-check-label">Correct</label>
                </div>
            </div>
            <div class="option mb-3">
                <label class="form-label">Option</label>
                <input type="text" class="form-control" name="options[1][text]" required>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="options[1][is_correct]" value="1">
                    <label class="form-check-label">Correct</label>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="add-option">Add Another Option</button>
        <button type="submit" class="btn btn-primary">Create Question</button>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('add-option').addEventListener('click', function() {
        let container = document.getElementById('options-container');
        let index = container.children.length;
        if (index < 10) {
            let newOption = `
                <div class="option mb-3">
                    <label class="form-label">Option</label>
                    <input type="text" class="form-control" name="options[${index}][text]" required>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="options[${index}][is_correct]" value="1">
                        <label class="form-check-label">Correct</label>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newOption);
        } else {
            alert('You can only add up to 10 options.');
        }
    });
</script>
@endpush
