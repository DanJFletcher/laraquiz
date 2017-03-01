@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $quiz->title }}</h1>
        @if(count($quiz->questions) > 0)
            <ul>
                @foreach($quiz->questions as $question)
                    <li>{{ $question->text }}</li>
                @endforeach
            </ul>
        @else
            <p>No questions in this quiz yet.</p>
        @endif
        <a 
            href="{{ route('question.create', ['id' => $quiz->id]) }}"
            class="btn btn-primary"
            title="Add Question">
            Add Question
        </a>
    </div>
@endsection
