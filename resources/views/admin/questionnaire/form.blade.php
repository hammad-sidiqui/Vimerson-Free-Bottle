<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            {!! Form::label('question', 'Question') !!}
                            {!! Form::text('question', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::select('status', [1 => 'Active', 0 => 'Inactive'], null, ['class' =>
                            'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::label('featured', 'Featured') !!}
                            {!! Form::select('featured', [0 => 'No', 1 => 'Yes'], null, ['class' => 'form-control']) !!}
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
                        {!! Form::submit($sumbitButtonText , ['class' => 'btn btn-primary float-right mt-2']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
