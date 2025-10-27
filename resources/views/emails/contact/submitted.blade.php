@component('mail::message')
# Pesan Baru dari Form Kontak

**Nama:** {{ $data['name'] }}
**Email:** {{ $data['email'] }}
**Telepon:** {{ $data['telp'] }}
**Subjek:** {{ $data['subject'] }}

**Pesan:**
> {!! nl2br(e($data['message'])) !!}

@slot('subcopy')
Dikirim dari halaman kontak website.
@endslot
@endcomponent
