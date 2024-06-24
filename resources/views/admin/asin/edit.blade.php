@extends('layouts.app')

@section('template_title')
Edit Free Bottle
@endsection

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Edit - {{ $asin->asin }}</h3>
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

            @include('admin.asin.error')

            {!! Form::model($asin, ['method' => 'PATCH', 'action' => ['AdminVimersonHealthController@updateAsin',
            $asin->id]]) !!}

            @include('admin.asin.form', ['sumbitButtonText' => 'Update Asin'])

            {!! Form::close() !!}

        </div>
    </div>
</div>

@stop
