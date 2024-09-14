<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'correct_answer',
        'wrong_answer',
        'unanswered',
        'total_question',
    ];

    // If you want to define relationships, you can do so here
    // For example, to link to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // And to link to the Quiz model
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
