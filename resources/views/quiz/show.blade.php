@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $quiz->title }}</h1>
        <ul>
            @foreach($quiz->questions as $question)
                <li>{{ $question->text }}</li>
            @endforeach
        </ul>
        <a 
            href="{{ route('question.create', ['id' => $quiz->id]) }}"
            class="btn btn-primary"
            title="Add Question">
            Add Question
        </a>
    </div>
@endsection
