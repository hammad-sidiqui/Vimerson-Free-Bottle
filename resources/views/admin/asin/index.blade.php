@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <a href="/admin/asin/create">Create</a>

    @if(Session::has('flash_message'))
    <div class="alert alert-success col-md-12">
        {{ Session::get('flash_message') }}
    </div>
    @endif

    <div class="row">

        @if( count($asin) > 0 )

        <table class="table table-striped table-hover table-responsive table-condensed table-layout">

            <tr>
                <th>ASIN</th>
                <th>Status</th>
                <th>Active</th>
            </tr>

            @foreach($asin as $product)

            <tr>
                <td>{{$product->asin}}</td>
                <td>{{$product->status == 1 ? 'active' : 'inactive'}}</td>
                <td>
                    <a href="{{ route('edit_asin', $product->id) }}">
                        Edit
                    </a>
                </td>
            </tr>

            @endforeach
        </table>

        {{ $asin->render() }}

        @else
        <div class="row">
            <div class="col-lg-12">
                <p class="text-muted">No ASIN found yet</p>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection