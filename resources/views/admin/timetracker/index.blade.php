@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-12">
            <h3 class="font-weight-bold">Form Time Tracker</h3>
        </div>
    </div>
    <hr>

    <div class="row">

        @if( count($time_tracker) > 0 )

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-layout data-table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20">User</th>
                                    <th width="20" class="text-center">Form ID</th>
                                    <th width="20" class="text-center">Step One</th>
                                    <th width="20" class="text-center">Step Two</th>
                                    <th width="20" class="text-center">Step Three</th>
                                    <th width="20" class="text-center">Step Four</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($time_tracker as $time)

                                <tr>
                                    <td>{{ $time->userData ? $time->userData->first_name .' '. $time->userData->last_name : 'Unknow'}}</td>
                                    <td class="text-center">{{$time->form_id}}</td>
                                    <td class="text-center">{{$time->step_one_time ? $time->step_one_time . ' Seconds' : '' }}</td>
                                    <td class="text-center">{{$time->step_two_time ? $time->step_two_time . ' Seconds' : '' }}</td>
                                    <td class="text-center">{{$time->step_three_time ? $time->step_three_time . ' Seconds' : '' }}</td>
                                    <td class="text-center">{{$time->step_four_time ? $time->step_four_time . ' Seconds' : '' }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @else
            <div class="col-lg-12">
                <p class="text-muted">No time tracker found yet</p>
            </div>
        @endif

    </div>
</div>

@endsection
