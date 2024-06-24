@if($questionnaire)
    @foreach( $questionnaire as $key => $question )
        <div class="row">
            <div class="col">
                <div class="form-group mb-3 questionnaire">
                    <label class="control-label question question_{{$key+1}}">
                        <span class="font-weight-bold">Q {{$key+1}}.</span> {{$question->question}}
                    </label>
                    <textarea id="answer_{{$key+1}}" class="answer"></textarea>
                </div>
            </div>
        </div>
    @endforeach
@else
<p class="text-muted"><b>Not found any results</b></p>
@endif