<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Quiz;

class QuestionController extends Controller
{
    /**
     * Display all questions belonging to current quiz
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // [TODO]
        // Currently this dipsplays all questions belonging to current user
        // But after testing, It apears it does not. 
        // Will have to fix the query to produce the results I actually need.
        $user = Auth::user();
        $questions = DB::table('questions')
                        ->join('quizzes', 'questions.id', '=', 'quizzes.id')
                        ->join('users', 'quizzes.id', '=', 'users.id')
                        ->select('questions.id', 'questions.text')
                        ->where('questions.id', $user->id)
                        ->get();

        // $questions = Auth::User()->quizzes()->get()->each->questions;

        // dd($questions);

        return view('question.index')->with(compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->query('id');

        return view('question.create')->with(['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = Question::create($request->all());

        $id = $question->quiz->id;

        return redirect()->route("quiz.show", ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
