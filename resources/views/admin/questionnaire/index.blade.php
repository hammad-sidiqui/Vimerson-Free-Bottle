@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="font-weight-bold">Questionnaire</h3>
        </div>
        <div class="col-md-6" style="text-align: right">
            <a class="btn btn-primary" href="/admin/questionnaire/create">Create New Question</a>
        </div>
    </div>
    <hr>

    @if(Session::has('flash_message'))
    <div class="alert alert-success col-md-12">
        {{ Session::get('flash_message') }}
    </div>
    @endif

    <div class="row">

        @if( count($questions) > 0 )

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="40">Questionnaire</th>
                                    <th width="20" class="text-center">Status</th>
                                    <th width="20" class="text-center">Featured</th>
                                    <th width="20" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)

                                <tr>
                                    <td>{{$question->question}}</td>
                                    <td class="text-center">{{$question->status == '1' ? 'active' : 'inactive'}}</td>
                                    <td class="text-center">{{$question->featured == '1' ? 'featured' : 'not featured'}}</td>
                                    <td class="text-center">
                                        <a href="/admin/questionnaire/{{$question->id}}/edit" title="edit questionnaire"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;Edit</a>
                                    </td>
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
                <p class="text-muted">No question found yet</p>
            </div>
        @endif

    </div>

</div>

@endsection
