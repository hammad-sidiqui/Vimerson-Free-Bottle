@if($step_details)

<div class="row mb-4 personal-details">
    <div class="col-12">
        <h5 class="mb-3">Personal Details</h5>
    </div>
    <div class="col-12 d-md-flex">
        <p class="me-3 pe-3">{{ $step_details->first_name }} {{ $step_details->last_name }}</p>
        <p class="me-3 pe-3">{{ $step_details->email }}</p>
        <p class="me-3 pe-3">{{ $step_details->phone_number }}</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3">Free Bottle</h5>
    </div>
    @foreach( $step_details->bottles as $bottle )
        <div class="free-bottle text-center">
            <img alt="" src="{{ route('bottle', $bottle->image)}}">
            <p class="">{{ $bottle->name }}</p>
        </div>
    @endforeach
</div>

@foreach( $step_details->feedbackLastData as $feedback )
<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3">Feedback</h5>
        <div class="rating-stars text-center mb-3">
            <ul>
                <li class="star {{ $feedback->stars >= 1 ? 'selected': '' }}" title="Poor" data-value="1">
                    <i class="bi bi-star-fill"></i>
                </li>
                <li class="star {{ $feedback->stars >= 2 ? 'selected': '' }}" title="Fair" data-value="2">
                    <i class="bi bi-star-fill"></i>
                </li>
                <li class="star {{ $feedback->stars >= 3 ? 'selected': '' }}" title="Good" data-value="3">
                    <i class="bi bi-star-fill"></i>
                </li>
                <li class="star {{ $feedback->stars >= 4 ? 'selected': '' }}" title="Excellent" data-value="4">
                    <i class="bi bi-star-fill"></i>
                </li>
                <li class="star {{ $feedback->stars >= 5 ? 'selected': '' }}" title="WOW!!!" data-value="5">
                    <i class="bi bi-star-fill"></i>
                </li>
            </ul>
        </div>
        <p>{{ $feedback->feedback }}</p>
    </div>
</div>
<!-- div class="row">
    <div class="col-12">
        <h5 class="mb-3">Questionnaire</h5>
        {{-- @foreach( json_decode($feedback->questionnaire, true) as $question )
        <div class="question-answer">
            <p class="mb-0 question">{{ $question['question'] }}</p>
            <p class="mb-0 answer">{{ $question['answer'] }}</p>
        </div>
        @endforeach --}}
    </div>
</div> -->
@endforeach
@else
<p class="text-muted"><b>Not found any results</b></p>
@endif