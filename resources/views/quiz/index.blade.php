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
            </tr>
        </thead>
        <tbody>
        
        @foreach($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->user->name }}
            </tr>
        @endforeach
        </tbody>
        </table>

    </div>
@endsection