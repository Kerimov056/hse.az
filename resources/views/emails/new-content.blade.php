{{-- resources/views/emails/new-content.blade.php --}}
@component('mail::message')
# {{ $title }}

**Type:** {{ ucfirst($type) }}

@if($excerpt)
{{ $excerpt }}
@endif

@component('mail::button', ['url' => $url])
View details
@endcomponent

If you no longer wish to receive such emails,
[unsubscribe]({{ route('unsubscribe', auth()->user()->token ?? 'token-placeholder') }}).
@endcomponent
