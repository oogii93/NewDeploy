@component('mail::message')
{{-- Intro Lines --}}


<div class="text-black mb-6">
    <h1 class="text-2xl font-bold mb-4 text-center">
        太成Netから通知です。
    </h1>
</div>

<div class="mb-6">
    <h3 class="text-lg font-normal leading-relaxed text-gray-700">
       社内注文通知
    </h3>
</div>
<div class="bg-gray-50 p-4 rounded-lg mb-6 mt-2">
    <h4 class="font-bold mb-3">注文内容:</h4>
<ul>
    <li>注文者: {{ $user->name }}</li>
    <li></li>
    <li></li>
</ul>
</div>


<small class="">ありがとうございました。</small>










@endcomponent
