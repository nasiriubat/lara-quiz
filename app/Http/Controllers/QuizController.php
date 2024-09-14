<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'time_limit' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create($request->all());

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully');
    }

    public function show(Quiz $quiz)
    {
        return view('quizzes.show', compact('quiz'));
    }
    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'time_limit' => 'required|integer|min:1',
        ]);

        $quiz->update($request->all());

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully');
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'questions' => 'nullable|array',
            'questions.*' => 'exists:questions,id',
        ]);

        // Sync questions to the quiz
        $quiz->questions()->sync($request->questions);

        return redirect()->route('quizzes.edit', $quiz->id)->with('success', 'Questions updated successfully');
    }


    public function destroyQuestion(Quiz $quiz, Question $question)
    {
        $quiz->questions()->detach($question->id);
        return redirect()->route('quizzes.edit', $quiz->id)->with('success', 'Question removed from quiz');
    }
    public function list()
    {
        $quizzes = Quiz::all(); // Fetch all quizzes
        return view('quizzes.list', compact('quizzes'));
    }
}
