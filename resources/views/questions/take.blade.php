@extends('layouts.app')

@section('content')
    <h1>{{ $quiz->title }}</h1>
    <div id="quiz-timer">Time left: {{ $quiz->time_limit }} seconds</div>

    <div id="quiz-container">
        @foreach($questions as $question)
            <div class="question" data-time-limit="{{ $question->time_limit }}" style="display: none;">
                <h2>{{ $question->text }}</h2>
                @foreach($question->options as $option)
                    <label>
                        <input type="radio" name="question_{{ $question->id }}">
                        {{ $option->option_text }}
                    </label><br>
                @endforeach
            </div>
        @endforeach
    </div>

    <script>
        let questions = document.querySelectorAll('.question');
        let quizTime = {{ $quiz->time_limit }};
        let currentQuestion = 0;
        let timeLeft = questions[currentQuestion].dataset.timeLimit;

        function showNextQuestion() {
            questions[currentQuestion].style.display = 'none';
            currentQuestion++;
            if (currentQuestion < questions.length) {
                timeLeft = questions[currentQuestion].dataset.timeLimit;
                questions[currentQuestion].style.display = 'block';
            } else {
                alert('Quiz Complete!');
            }
        }

        function startQuiz() {
            questions[currentQuestion].style.display = 'block';
            setInterval(function() {
                timeLeft--;
                if (timeLeft <= 0) {
                    showNextQuestion();
                }
            }, 1000);
        }

        startQuiz();
    </script>
@endsection
