@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <a href="{{ route('bottle_list') }}">
                            <div class="card-body">
                                <div class="d-flex my-2 align-items-center justify-content-center flex-column">
                                    <img class="dashboard-card-icon" src="{{ asset('images/icons/bottle.svg') }}">
                                    <h6 class="font-weight-bold mt-4">Bottle<h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <a href="{{ route('product_list') }}">
                            <div class="card-body">
                                <div class="d-flex my-2 align-items-center justify-content-center flex-column">
                                    <img class="dashboard-card-icon" src="{{ asset('images/icons/ASIN.svg') }}">
                                    <h6 class="font-weight-bold mt-4">ASIN<h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <a href="{{ route('timetracker_list') }}">
                            <div class="card-body">
                                <div class="d-flex my-2 align-items-center justify-content-center flex-column">
                                    <img class="dashboard-card-icon" src="{{ asset('images/icons/time-tracker.svg') }}">
                                    <h6 class="font-weight-bold mt-4">Time Tracker<h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <a href="{{ route('questionnaire_list') }}">
                            <div class="card-body">
                                <div class="d-flex my-2 align-items-center justify-content-center flex-column">
                                    <img class="dashboard-card-icon" src="{{ asset('images/icons/questionnaire.svg') }}">
                                    <h6 class="font-weight-bold mt-4">Questionnaire<h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <a href="{{ route('user_list') }}">
                            <div class="card-body">
                                <div class="d-flex my-2 align-items-center justify-content-center flex-column">
                                    <img class="dashboard-card-icon" src="{{ asset('images/icons/users.svg') }}">
                                    <h6 class="font-weight-bold mt-4">Users<h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex my-2 align-items-center justify-content-center flex-column">

                            <div class="custom-control custom-checkbox custom-checkbox-color-check custom-control-inline">
                            @if ($popup)
                            <input type="checkbox" class="custom-control-input bg-success" id="allow_amazon_popup" checked="">
                           <label class="custom-control-label" for="allow_amazon_popup">Allow amazon popup</label>
                           @else
                           <input type="checkbox" class="custom-control-input bg-success" id="allow_amazon_popup" checked="">
                           <label class="custom-control-label" for="allow_amazon_popup">Allow amazon popup</label>
                           @endif

                        </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- Page end  -->
</div>
@endsection