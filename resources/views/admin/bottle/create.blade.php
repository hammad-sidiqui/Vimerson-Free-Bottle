@extends('layouts.app')

@section('template_title')
Add Free Bottle
@endsection

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Add Free Bottle</h3>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            @if(Session::has('error_flash'))
            <div class="alert alert-danger col-md-8 col-md-offset-2">
                {{ Session::get('error_flash') }}
            </div>
            @endif

            @include('admin.bottle.error')

            {!! Form::open(['url' => '/admin/bottle/store', 'files' => true]) !!}

            @include('admin.bottle.form', ['sumbitButtonText' => 'Add Free Bottle'])

            {!! Form::close() !!}

        </div>
    </div>

</div>
</section>

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
