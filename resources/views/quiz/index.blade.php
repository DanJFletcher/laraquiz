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
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the quiz (uses the show method found at GET /quizs/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('quiz/' . $quiz->id) }}">Show this quiz</a>

                <!-- edit this quiz (uses the edit method found at GET /quizs/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('quiz/' . $quiz->id . '/edit') }}">Edit this quiz</a>

            </td>
            </tr>
        @endforeach
        </tbody>
        </table>

    </div>
@endsection