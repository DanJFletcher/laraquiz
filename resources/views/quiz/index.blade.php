@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Quizzes</h1>
        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>ID</td>
                <td>Title</td>
                <td>Owner</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
        
        @foreach($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->user->name }}</td>
                <td>

                <!-- delete the quiz (uses the destroy method DESTROY /quiz/{id} -->
                {{ Form::open(['route' => ['quiz.destroy', $quiz->id], 'method' => 'delete']) }}
                    <button 
                        class="btn btn-small btn-square btn-danger pull-right" 
                        type="submit"
                        title="Delete this quiz">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                {{ Form::close() }}

                <!-- show the quiz (uses the show method found at GET /quizs/{id} -->
                <a 
                    class="btn btn-small btn-square btn-info pull-right" 
                    href="{{ URL::to('quiz/' . $quiz->id) }}"
                    title="Show this quiz">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>

                <!-- edit this quiz (uses the edit method found at GET /quizs/{id}/edit -->
                <a 
                    class="btn btn-small btn-square btn-primary pull-right" 
                    href="{{ URL::to('quiz/' . $quiz->id . '/edit') }}"
                    title="Edit this quiz">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>

            </td>
            </tr>
        @endforeach
        </tbody>
        </table>

        <a href="{{ URL::to('quiz/create') }}" class="btn btn-small btn-primary pull-right" title="Create new quiz"><i class="fa fa-plus" aria-hidden="true"></i> Create Quiz</a>

    </div>
@endsection