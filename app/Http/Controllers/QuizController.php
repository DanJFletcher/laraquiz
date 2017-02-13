<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Session;
use Redirect;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();

        return view('quiz.index')->with(compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create quiz form
        return view('quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new quiz, mass assign the input from Request
        // and save to the database
        $quiz = Quiz::create($request->All());

        // If $quiz is an instance of App\Quiz
        // return success
        if ($quiz instanceof Quiz) {
            // redirect
            Session::flash('message', 'Successfully created quiz!');
            return Redirect::to('quiz');
        } 
        // Else if it's not an instance, then something
        // went wrong
        else {
            return response()->json([
                'message' => 'fail'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        // $quiz is set we found a quiz
        if (isset($quiz)) {
            return response()->json([
                "message" => "success",
                "quiz" => $quiz
            ]);
        }
        // else the quiz could not be found
        else {
            return response()->json([
                "message" => "fail"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        if($quiz->delete()) {
            return response()->json([
                'message' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'fail'
        ]);
    }
}
