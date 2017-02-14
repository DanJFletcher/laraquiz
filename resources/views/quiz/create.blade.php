@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- if there are creation errors, they will show here -->
        @if (isset($errors))
            {{ HTML::ul($errors->all()) }}
        @endif

        {{ Form::open(['url' => 'quiz']) }}

        <div class="form-group">
            {{ Form::label('title', 'Quiz Title') }}
            {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
        </div>

        {{ Form::hidden('user_id', Auth::user()->id) }}

        {{ Form::submit('Create the Quiz!', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>



@endsection()