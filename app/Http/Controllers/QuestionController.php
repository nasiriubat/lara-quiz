<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'text' => 'required|string|max:255',
        'time_limit' => 'required|integer|min:1',
        'options' => 'required|array|min:2|max:10',
        'options.*.text' => 'required|string|max:255',
        'options.*.is_correct' => 'nullable|boolean',
    ]);

    $question = Question::create([
        'text' => $request->text,
        'time_limit' => $request->time_limit,
    ]);

    foreach ($request->options as $option) {
        $question->options()->create([
            'text' => $option['text'],
            'is_correct' => isset($option['is_correct']) ? true : false,
        ]);
    }

    return redirect()->route('questions.index')->with('success', 'Question created successfully');
}

public function edit(Quiz $quiz)
{
    $questions = Question::all();
    $selectedQuestions = $quiz->questions->pluck('id')->toArray();

    // Exclude selected questions from the available questions
    $availableQuestions = $questions->filter(function ($question) use ($selectedQuestions) {
        return !in_array($question->id, $selectedQuestions);
    });

    return view('quizzes.edit', [
        'quiz' => $quiz,
        'availableQuestions' => $availableQuestions,
        'selectedQuestions' => $selectedQuestions,
    ]);
}


    public function update(Request $request, Question $question)
{
    $request->validate([
        'text' => 'required|string|max:255',
        'time_limit' => 'required|integer|min:1',
        'options' => 'required|array|min:2|max:10',
        'options.*.text' => 'required|string|max:255',
        'options.*.is_correct' => 'nullable|boolean',
    ]);

    $question->update([
        'text' => $request->text,
        'time_limit' => $request->time_limit,
    ]);

    $question->options()->delete();

    foreach ($request->options as $option) {
        $question->options()->create([
            'text' => $option['text'],
            'is_correct' => isset($option['is_correct']) ? true : false,
        ]);
    }

    return redirect()->route('questions.index')->with('success', 'Question updated successfully');
}

    public function destroy(Question $question)
    {
        $question->options()->delete();
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully');
    }
}
