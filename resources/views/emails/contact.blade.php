@component('mail::message')
# رسالة تواصل جديدة

**الاسم:** {{ $contact->name }}  
**البريد:** {{ $contact->email }}  
**الموضوع:** {{ $contact->subject }}

**الرسالة:**
{{ $contact->message }}

@endcomponent
