@extends('layouts.app')

@section('template_title')
Edit Question
@endsection

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Edit Question</h3>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <hr />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('error_flash'))
            <div class="alert alert-danger col-md-8 col-md-offset-2">
                {{ Session::get('error_flash') }}
            </div>
            @endif

            @include('admin.questionnaire.error')

            {!! Form::model($question, ['method' => 'PATCH', 'action' =>
            ['AdminVimersonHealthController@questionUpdate', $question->id]]) !!}

            @include('admin.questionnaire.form', ['sumbitButtonText' => 'Update Question'])

            {!! Form::close() !!}

        </div>
    </div>
</div>

@stop
