<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')->get();

        return view('home', compact('questions'));
    }
}
