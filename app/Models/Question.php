<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'time_limit'];

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_question')->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
