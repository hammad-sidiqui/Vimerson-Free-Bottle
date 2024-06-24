<div class="row align-items-center">
    <div class="col-md-6">
        <h3 class="font-weight-bold">{{$headingText}}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <hr />
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-lg-8">
                        <div class="form-row">
                            <!-- <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('product_name', 'Product Name') !!}
                                    {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder' =>
                                    'Enter product Name']) !!}
                                </div>
                            </div> -->
                            {!! Form::hidden('sortable_bottles', null, ['id' => 'sortable_bottles']) !!}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('asin', 'ASIN') !!}
                                    @if(isset($product->asin))
                                    {!! Form::text('asin', null, ['class' => 'form-control', 'placeholder' => 'Enter ASIN', 'id' => 'product_asin_number', 'readonly' => true]) !!}
                                    @else
                                    {!! Form::text('asin', null, ['class' => 'form-control', 'placeholder' => 'Enter ASIN', 'id' => 'product_asin_number']) !!}
                                    @endif
                                    <!-- <button type="button" id="fetch_bottle_details">Featch Details</button> -->
                                </div>
                            </div>
                            <div class="col-lg-3 align-items-end d-flex">
                                <div class="form-group w-100">
                                    {!! Form::button('Fetch bottle', ['class' => 'btn btn-secondary w-100', 'id' => 'fetch_bottle_details']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('status', 'Status') !!}
                                    {!! Form::select('status', [1 => 'Active', 0 => 'Inactive'], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('variant_id', 'Shopify Variant ID') !!}
                                    {!! Form::text('bottle_variant_id', null, ['class' => 'form-control', 'id' => 'bottle_variant_id', 'placeholder' => 'Variant ID', 'disabled' => true]) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('bottle_name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'disabled' => true, 'id' => 'bottle_name']) !!}
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('bottle_ids', 'ASIN to be Shown') !!}
                                    <!-- {!! Form::select('bottle_ids', $bottle_list, null, ['class' => 'form-control', 'name' => 'bottle_ids[]', 'id' => 'bottle_ids_dropdown', 'multiple' => 'multiple']) !!} -->
                                    <select id="bottle_ids_dropdown" class="form-control" name="bottle_ids[]" multiple="multiple">
                                        <!-- @foreach($bottle_list as $key => $bottle)
                                        <option value="{{ $key }}">{{ $bottle }}</option>
                                        @endforeach -->
                                    </select>
                                </div>
                                <div class="selected_bottles d-flex flex-wrap">
                                    <!-- <div class="product">
                                        <div class="product_image">
                                            <img alt="" src="{{asset('images/Men_sMultivitamins_60caps_Front_300x.png')}}">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::file('image', ['class' => 'file dropify', 'name' => 'image', 'placeholder' => 'Choose Bottle Image', 'id' => 'bottle_image']) !!}
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
                        {!! Form::submit($sumbitButtonText, ['class' => 'btn btn-primary float-right mt-2']) !!}
                        @if(isset($product)) 
                        <button type="button" class="btn btn-delete float-right mt-2 mr-2" data-toggle="modal"  data-target="#delete_asin">Delete</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($product)) 
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
                <!-- {!! Form::open(['method' => 'DELETE', 'route' => ['delete_product', $product->id]]) !!}
                {!! Form::submit('Yes', ['class' => 'text-danger btn btn-default']) !!}
                {!! Form::close() !!} -->
                <a href="javascript:;" class="btn btn-delete" onclick="deleteProduct({{ $product->id }})" data-dismiss="modal">Yes</a>
                <a href="javascript:;" class="btn btn-secondary" data-dismiss="modal">No</a>
            </div>
        </div>
    </div>
</div>
@endif