@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://https://x.com/ryoukou_sangyo/photo" class="logo" alt="Laravel Logo" class="h-14 w-auto sm:h-18 sm:w-auto mr-3 sm:mr-5>
{{-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo"> --}}
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
