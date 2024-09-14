@extends('layouts.app')

@section('content')
    <h1>{{ $quiz->title }}</h1>
    <div id="quiz-container">
        <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST" id="quiz-form">
            @csrf

            @foreach ($questions as $index => $question)
                <div class="question-block" id="question-{{ $index }}" @if ($index > 0) style="display:none;" @endif>
                    <h3>Question {{ $index + 1 }}</h3>
                    <p>{{ $question->text }}</p>
                    
                    @foreach ($question->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" id="option-{{ $option->id }}" >
                            <label class="form-check-label" for="option-{{ $option->id }}">
                                {{ $option->text }}
                            </label>
                        </div>
                    @endforeach

                    <div class="mt-3">
                        <p>Time left: <span id="timer-{{ $index }}"></span> seconds</p>
                        <button type="button" class="btn btn-primary next-question" data-next="{{ $index + 1 }}">Next</button>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-4" style="display: none;" id="submit-btn-container">
                <button type="submit" class="btn btn-success">Submit Quiz</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    let currentQuestionIndex = 0;
    let questionTimers = [];

    // Function to start the timer for a question
    function startTimer(questionIndex, timeLimit) {
        let timerElement = document.getElementById('timer-' + questionIndex);
        let timeLeft = timeLimit;
        timerElement.innerText = timeLeft;

        questionTimers[questionIndex] = setInterval(function() {
            timeLeft--;
            timerElement.innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(questionTimers[questionIndex]);
                showNextQuestion(questionIndex);
            }
        }, 1000);
    }

    // Function to show the next question
    function showNextQuestion(currentIndex) {
        document.getElementById('question-' + currentIndex).style.display = 'none';
        let nextQuestion = document.getElementById('question-' + (currentIndex + 1));

        if (nextQuestion) {
            nextQuestion.style.display = 'block';
            startTimer(currentIndex + 1, {{ $questions[0]->time_limit }}); // Assuming each question has the same time limit
        } else {
            document.getElementById('submit-btn-container').style.display = 'block';
        }
    }

    // Event listener for next question button
    document.querySelectorAll('.next-question').forEach(button => {
        button.addEventListener('click', function() {
            let nextIndex = this.dataset.next;
            showNextQuestion(currentQuestionIndex);
            currentQuestionIndex = nextIndex;
        });
    });

    // Start the timer for the first question
    startTimer(0, {{ $questions[0]->time_limit }});
</script>
@endpush
