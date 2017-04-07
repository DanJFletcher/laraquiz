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
        // If validation fails this will automatically redirect user
        // back to quiz.create and flash errors.
        $this->validate($request, [
            'title' => 'bail|required|unique:quizzes'
        ]);

        // Create a new quiz, mass assign the input from Request
        // and save to the database
        $quiz = Quiz::create($request->All());

        // If $quiz is an instance of App\Quiz
        // return success
        if (isset($quiz->id)) {
            // redirect
            Session::flash('message', 'Successfully created quiz!');
            return Redirect::to('quiz');
        }
        // Else if it's not an instance, then something
        // went wrong
        else {
            Session::flash('message', 'Failed to create quiz.');
            return Redirect::to('quiz');
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
        // $quiz has id we found a quiz
        if (isset($quiz->id)) {
            return view('quiz.show')->with(compact('quiz'));
        }
        // else the quiz could not be found
        else {
            return response(404);
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
        // $quiz has id we found a quiz
        if (isset($quiz->id)) {
            return view('quiz.edit')->with(compact('quiz'));
        }
        // else the quiz could not be found
        else {
            return response(404);
        }
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
        // If validation fails this will automatically redirect user
        // back to quiz.create and flash errors.
        $this->validate($request, [
            'title' => 'bail|required|unique:quizzes'
        ]);

        // Update the title of this quiz
        $quiz->title = $request->input('title');

        $quiz->save();

        return Redirect::to("quiz");
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
            // redirect success
            Session::flash('message', 'Successfully deleted quiz!');
            return Redirect::to('quiz');
        }

        // redirect fail
        Session::flash('message', 'Failed to delete quiz.');
        return Redirect::to('quiz');
    }
}
