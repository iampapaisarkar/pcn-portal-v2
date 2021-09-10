@component('mail::message')
# Invitation as User on {{env('APP_NAME')}}

@if($data['state'])
<div>Hello {{$data['firstname'] . ' ' .$data['lastname']}}, <br> {{env('APP_NAME')}} has sent you an invitation as a {{$data['role']['role']}} role for {{$data['state']}} state.</div>
@else
<div>Hello {{$data['firstname'] . ' ' .$data['lastname']}}, <br> {{env('APP_NAME')}} has sent you an invitation as a {{$data['role']['role']}} role.</div>
@endif

<div>Please activate the account by clicking on the link below</div>
<a target="_blank" href="{{$data['activation_url']}}" rel="noopener">{{$data['activation_url']}}</a>

{{ config('app.name') }}
@endcomponent