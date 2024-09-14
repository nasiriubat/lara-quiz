<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class TakeQuizController extends Controller
{
    // Show the quiz to the user
    public function show(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('options')->get();
        return view('quizzes.take', compact('quiz', 'questions'));
    }

    // Handle quiz submission
    public function submit(Request $request, Quiz $quiz)
    {
        $user = auth()->user(); // Assuming user is authenticated
        $data = $request->validate([
            'answers' => 'array',
            'answers.*' => 'integer',  // each answer should be an option id
        ]);
    
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
    
        foreach ($quiz->questions as $question) {
            $selectedOptionId = $data['answers'][$question->id] ?? null;
    
            if ($selectedOptionId) {
                $correctOption = $question->options()->where('is_correct', true)->first();
    
                if ($correctOption && $correctOption->id == $selectedOptionId) {
                    $correctAnswers++;
                } else {
                    $wrongAnswers++;
                }
            } else {
                $unanswered++;
            }
        }
    
        // Save the result to UserAnswer model
        UserAnswer::create([
            'user_id' => $user->id ?? 1,
            'quiz_id' => $quiz->id,
            'correct_answer' => $correctAnswers,
            'wrong_answer' => $wrongAnswers,
            'unanswered' => $unanswered,
            'total_question' => $totalQuestions,
        ]);
    
        return redirect()->route('quizzes.index')->with('success', "You scored {$correctAnswers}/{$totalQuestions}");
    }
    
}
