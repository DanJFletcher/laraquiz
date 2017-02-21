@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $quiz->title }}</h1>
        <ul>
            @foreach($quiz->questions as $question)
                <li>{{ $question->text }}</li>
            @endforeach
        </ul>
    </div>
@endsection
