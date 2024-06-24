@extends('layouts.app')

@section('template_title')
Edit ASIN
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

			{!! Form::model($product, ['method' => 'PATCH', 'files' => true, 'action' => ['ProductController@updateProduct', $product->id]]) !!}

			@include('admin.product.form', ['sumbitButtonText' => 'Update ASIN', 'headingText' => 'Update ASIN'])

			{!! Form::close() !!}
		</div>

	</div>
</div>

@section('jsscript')

jQuery(document).ready(function () {
	fetchProducInfo(true);
});

@endsection

@stop