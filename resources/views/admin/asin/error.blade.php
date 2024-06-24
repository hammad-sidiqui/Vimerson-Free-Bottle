@if( $errors->any() )
	<ul class="alert alert-danger col-md-12 flex-wrap">
		@foreach( $errors->all() as $error )
			<li style="margin-left: 25px;">{{ $error }}</li>
		@endforeach
	</ul>
@endif