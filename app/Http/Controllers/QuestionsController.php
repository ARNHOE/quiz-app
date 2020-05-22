<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function store(Question $question, Answer $answer)
    {
        Auth::user()->answers()->attach($answer->id, ['question_id' => $question->id]);
//        Auth::user()->answers()->create([
//            'question_id' => $question->id,
//            'answer_id' => $answer->id,
//        ]);
    }
}
