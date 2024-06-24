@extends('layouts.app')

@section('template_title')
Add Free Bottle
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 mb-3">

            @if(Session::has('error_flash'))
            <div class="alert alert-danger col-md-12">
                {{ Session::get('error_flash') }}
            </div>
            @endif

            @include('admin.asin.error')

            {!! Form::open(['url' => '/admin/asin/store']) !!}

            @include('admin.asin.form', ['sumbitButtonText' => 'Add Asin'])

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