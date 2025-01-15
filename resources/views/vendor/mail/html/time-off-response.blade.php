@component('mail::message')
{{-- Intro Lines --}}


<div class="text-black mb-6">
    <h1 class="text-2xl font-bold mb-4 text-center">
        太成Netから通知です。
    </h1>
</div>

<div class="mb-6">
    <h3 class="text-lg font-normal leading-relaxed text-gray-700">
        お疲れ様です。休暇申請書が{{ $timeOffRequest->status === 'approved' ? '承認されました' : ($timeOffRequest->status==='denied' ? '拒否されました' : '')}}
    </h3>
</div>
<div class="bg-gray-50 p-4 rounded-lg mb-6 mt-2">
    <h4 class="font-bold mb-3">申請内容:</h4>
    <ul class="space-y-2">
        <li>申請者: {{ $timeOffRequest->user->name }}</li>
        <li>勤怠区分: {{ $timeOffRequest->attendanceTypeRecord->name }}</li>
        <li>日付: {{ $timeOffRequest->date }}</li>
        <li>理由: {{ $timeOffRequest->reason }}</li>
        @if($timeOffRequest->reason_select)
            <li>種類: {{ $timeOffRequest->reason_select }}</li>
        @endif
    </ul>
</div>








@endcomponent
