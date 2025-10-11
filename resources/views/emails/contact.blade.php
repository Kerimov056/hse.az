{{-- resources/views/emails/contact.blade.php --}}
@component('mail::message')
# New Contact Message

**Full name:** {{ $data['full_name'] }}  
**Email:** {{ $data['email'] }}  
**Phone:** {{ $data['phone'] ?? '—' }}  
**Topic:** {{ $data['topic'] ?? '—' }}

**Message:**
> {{ $data['message'] }}

@component('mail::subcopy')
Sent from Educve contact form.
@endcomponent
@endcomponent
