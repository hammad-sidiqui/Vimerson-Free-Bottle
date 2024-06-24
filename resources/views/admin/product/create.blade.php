@extends('layouts.app')

@section('template_title')
	Create Product
@endsection

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        @if(Session::has('error_flash'))
            <div class="alert alert-danger col-md-8 col-md-offset-2">
                {{ Session::get('error_flash') }}
            </div>
        @endif

        <div class="col-md-12">
            @include('admin.product.error')
            
            {!! Form::open(['url' => '/admin/product/store', 'files' => true]) !!}

                @include('admin.product.form', ['sumbitButtonText' => 'Create New ASIN', 'headingText' => 'Create ASIN'])

            {!! Form::close() !!}
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
