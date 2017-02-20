
@extends('layouts.app')
@section('content')
    <div class="content text-center">
        <h1>Laraquiz</h1>
        <p>Easily create quizzes for self studying.</p>
        @if (Auth::User())
            <a href="{{ route('quiz.index') }}" class="btn btn-default btn-large">Get Started</a>
        @else
            <a href="{{ url('/register') }}" class="btn btn-default btn-large">Get Started</a>
        @endif
    </div>
@endsection
