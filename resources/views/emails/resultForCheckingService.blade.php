@component('mail::message')
# Kết quả cho dịch vụ {{$service}}

Xin chào {{$requester}}!

Kết quả tìm kiếm của bạn cho dịch vụ {{$service}} là:

{!!nl2br($result)!!}

{{-- # Truy cập trang web
@component('mail::button', ['url' => '{{route('home')}}'])
{{ config('app.name') }}
@endcomponent --}}

Cảm ơn,<br>
Từ {{ config('app.name') }} !
@endcomponent
