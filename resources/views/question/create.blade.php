@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Form::open(['url' => 'question']) }}
            <div class="form-group">
                {{ Form::label('text', 'Question text') }}
                {{ Form::text('text', Input::old('text'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('answer', 'Answer') }}
                {{ Form::text('answer', Input::old('answer'), array('class' => 'form-control')) }}
            </div>

            {{ Form::hidden('quiz_id', '1') }}

            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
@endsection()