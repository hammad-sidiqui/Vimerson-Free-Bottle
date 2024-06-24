@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Bottles</h3>
        </div>
        <div class="col-md-6" style="text-align: right">
            <a class="btn btn-primary" href="/admin/bottle/create">Create New Bottle</a>
        </div>
    </div>
    <hr>

    @if(Session::has('flash_message'))
    <div class="alert alert-success col-md-12">
        {{ Session::get('flash_message') }}
    </div>
    @endif

    <div class="row">

        @if( count($bottles) > 0 )

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="max-width: 110px;" class="text-center">Bottle Image</th>
                                    <th width="30">Bottle Name</th>
                                    <th width="30" class="text-center">Shopify Variant ID</th>
                                    <th width="20" class="text-center">ASIN</th>
                                    <th width="20" class="text-center">Status</th>
                                    <th width="20" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bottles as $bottle)
                                <tr>
                                    <td class="text-center"><img class="product-img" style="" src="{{ route('bottle', $bottle->image) }}">
                                    </td>
                                    <td>{{ $bottle->name }}</td>
                                    <td class="text-center">{{ $bottle->variant_id }}</td>
                                    <td class="text-center">{{ $bottle->asin }}</td>
                                    <td class="text-center">{{$bottle->status == '1' ? 'active' : 'inactive'}}</td>
                                    <td class="text-center">
                                        <a class="mr-2 action-divider position-relative" href="{{ route('edit_bottle', $bottle->id) }}">Edit</a>
                                        <a href="javascript:;" class="text-danger ml-2" data-toggle="modal" data-target="#delete_bottle-{{ $bottle->id }}">Delete</a>
                                    </td>
                                </tr>

                                <!-- modal for delete asin -->
                                <div id="delete_bottle-{{ $bottle->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header text-danger bg-default">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body p-5">
                                                <h6>Are you sure you want to Delete?</h6>
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['delete_bottle', $bottle->id]]) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-delete']) !!}
                                                {!! Form::close() !!}
                                                <a href="javascript:;" class="btn btn-secondary" data-dismiss="modal">No</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @else
            <div class="col-lg-12">
                <p class="text-muted">No bottle found yet</p>
            </div>
        @endif

    </div>

</div>

@endsection
