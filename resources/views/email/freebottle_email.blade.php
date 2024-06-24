@component('mail::message')

<h1>Perosnal Info</h1>
<p>{{ $mail_data['first_name'] }}</p>
<p>{{ $mail_data['last_name'] }}</p>
<p>{{ $mail_data['email'] }}</p>
<p>{{ $mail_data['phone_number'] }}</p>

@if($mail_data['bottle'])
<h1>Bottle Info</h1>
<p>{{ $mail_data['bottle']['name'] }} </p>

<img alt="" src="{{ route('bottle', $mail_data['bottle']['image']) }}">
@endif

@if($mail_data['feedbackLastData'])
<h1>Feedback Info</h1>

@foreach ($mail_data['feedbackLastData'] as $feedback)
{{ $feedback['feedback'] }} <br>

{{-- @foreach (json_decode($feedback['questionnaire'], true) as $questionnaire_feedback)
<ul>
    <li>{{ $questionnaire_feedback['question'] }}</li>
    <li>{{ $questionnaire_feedback['answer'] }}</li>
</ul>
@endforeach --}}

@endforeach
@endif

@component('mail::button', ['url' => 'https://vimerson.com'])
For more details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
