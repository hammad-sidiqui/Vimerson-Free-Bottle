@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Users</h3>
        </div>
        <div class="col-md-6" style="text-align: right">
            <a class="btn btn-primary" href="{{ route('export') }}">Export Users Data</a>
        </div>
    </div>
    <hr>

    <div class="row">

        @if( count($users) > 0 )

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)

                                <tr>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone_number}}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{ $users->render() }}

        @else
            <div class="col-lg-12">
                <p class="text-muted">No user found yet</p>
            </div>
        @endif
    </div>
</div>

@endsection
