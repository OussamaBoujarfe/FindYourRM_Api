@component('mail::message')
# You have a request!

## User information
Name of the user: {{$user->name ?? ''}}  
Gender of the user: {{$user->gender ?? ''}}  
Age of the user: {{Carbon\Carbon::parse($user->birthday)->age?? ''}}  
Country of the user: {{$user->country ?? ''}}  
City of the user: {{$user->city ?? ''}}  
The user prefer {{$user->preferences[0]}} gender, between age {{$user->preferences[1][0]}} and {{$user->preferences[1][1]}}  


<i>Contact: {{$user->email ?? ''}}  </i>

## Room information
Country: {{$room->country}}  
City: {{$room->city}}  
Number of rooms: {{$room->number_of_rooms}}  
Rent: {{$room->rent}}  



Thanks,<br>
{{ config('app.name') }}
@endcomponent
