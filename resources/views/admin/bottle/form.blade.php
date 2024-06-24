<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-lg-8">
                        <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter product name']) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('asin', 'ASIN') !!}
                                    {!! Form::text('asin', null, ['class' => 'form-control', 'placeholder' => 'Enter ASIN']) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('variant_id', 'Shopify Variant ID') !!}
                                    {!! Form::text('variant_id', null, ['class' => 'form-control', 'placeholder' =>
                                    'Enter product variant ID'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('status', 'Status') !!}
                                    {!! Form::select('status', [1 => 'Active', 0 => 'Inactive'], null, ['class' =>
                                    'form-control']) !!}
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('featured', 'Featured') !!}
                                    {!! Form::select('featured', [0 => 'No', 1 => 'Yes'], null, ['class' =>
                                    'form-control']) !!}
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            {!! Form::file('image', ['class' => 'file dropify', 'name' => 'image', 'placeholder' =>
                            'Choose Bottle Image', 'id' =>
                            'image' ]) !!}
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 justify-content-center">
                        {!! Form::submit($sumbitButtonText , ['class' => 'btn float-right btn-primary mt-2']) !!}
                        @if(isset($bottle)) 
                        <button type="button" class="btn btn-delete float-right mt-2 mr-2" data-toggle="modal" data-target="#delete_asin">Delete</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($bottle))
<!-- modal for delete asin -->
<div id="delete_asin" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-danger bg-default">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-5">
                <h6>Are you sure you want to Delete?</h6>
            </div>
            <div class="modal-footer">
                <!-- {!! Form::open(['method' => 'DELETE', 'route' => ['delete_bottle', $bottle->id]]) !!}
                {!! Form::submit('Yes', ['class' => 'text-danger btn btn-default']) !!}
                {!! Form::close() !!} -->
                <a href="javascript:;" class="btn btn-delete" onclick="deleteBottle({{ $bottle->id }})" data-dismiss="modal">Yes</a>
                <a href="javascript:;" class="btn btn-secondary" data-dismiss="modal">No</a>
            </div>
        </div>
    </div>
</div>
@endif

@section('jsscript')
    setBottleImage('{{ $bottle->image ?? 'placeholder.png' }}')
@endsection
