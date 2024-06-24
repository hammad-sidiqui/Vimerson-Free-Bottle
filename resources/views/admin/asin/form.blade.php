<div class="form-row">
    <div class="form-group mt-2 col-lg-12">
        {!! Form::label('asin', 'Asin') !!}
        {!! Form::text('asin', null, ['class' => 'form-control', 'placeholder' => 'Enter comma separated asin']) !!}
    </div>
</div>

<div class="form-row">
    <div class="col-md-12">
        <div class="form-group col-md-6">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', [1 => 'Yes', 0 => 'No'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::submit($sumbitButtonText , ['class' => 'btn float-right w-200 theme-primary-btn mt-2']) !!}
