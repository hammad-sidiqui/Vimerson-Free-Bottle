@extends('layouts.APP')

@section('template_title')
Add Questionnaire
@endsection

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Add Question</h3>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <hr />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-3">

            @if(Session::has('error_flash'))
            <div class="alert alert-danger col-md-8 col-md-offset-2">
                {{ Session::get('error_flash') }}
            </div>
            @endif

            @include('admin.questionnaire.error')

            {!! Form::open(['url' => '/admin/questionnaire/store', 'files' => true]) !!}

            @include('admin.questionnaire.form', ['sumbitButtonText' => 'Add Question'])

            {!! Form::close() !!}

        </div>
    </div>
</div>

@stop

@section('jsscript')

$('#image').change(function(){
let reader = new FileReader();

reader.onload = (e) => {
$('#icon_preview_container').attr('src', e.target.result);
}

reader.readAsDataURL(this.files[0]);
});

@stop
