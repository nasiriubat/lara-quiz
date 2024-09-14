<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TakeQuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('quizzes.index');
});

// Quiz Routes
Route::resource('quizzes', QuizController::class);
Route::get('/quizList', [QuizController::class, 'list'])->name('quizzes.list');


// Question Routes
Route::resource('questions', QuestionController::class);

// Additional routes for managing questions within a quiz
Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.storeQuestion');
Route::delete('quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('quizzes.destroyQuestion');

Route::get('quiz/{quiz}/take', [TakeQuizController::class, 'show'])->name('quiz.take');
Route::post('quiz/{quiz}/submit', [TakeQuizController::class, 'submit'])->name('quiz.submit');

