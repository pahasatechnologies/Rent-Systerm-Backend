@component('mail::message')
# {{ $contact->subject }}

Message: {{$contact->message}}

From: {{$contact->name}} 

Email: {{$contact->email}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
