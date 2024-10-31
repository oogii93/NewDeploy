@extends('admin.dashboard')

@section('admin')

@php
    use Carbon\Carbon;
@endphp

<div class="py-10 bg-gray-100 shadow-sm min-h-screen">
    <h1 class="text-xl font-bold  text-center">{{ $selectedCorp->corp_name}}</h1>
    <h2 class="text-xl font-semibold mb-4 text-center py-5">{{ $selectedYear }} 年のお休みスケジュールカレンダー</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach($calendar as $month => $monthCalendar)
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-2xl text-yellow-500 font-semibold mb-2 text-center">{{ $month }}</h3>
                <div class="grid grid-cols-7 gap-1 text-center font-semibold">
                    @php
                        $daysOfWeek = ['日', '月', '火', '水', '木', '金', '土'];
                        $firstDayOfMonth = Carbon::create($selectedYear, $month, 1)->dayOfWeek;
                    @endphp
                    @foreach($daysOfWeek as $index => $dayOfWeek)
                        @php
                            $colorClass = '';
                            if ($index == 0) {
                                $colorClass = 'text-red-500'; // Sunday
                            } elseif ($index == 6) {
                                $colorClass = 'text-blue-500'; // Saturday
                            }
                        @endphp
                        <div class="{{ $colorClass }}">{{ $dayOfWeek }}</div>
                        @if($index == 6)
                            @break
                        @endif
                    @endforeach
                </div>
                <div class="grid grid-cols-7 gap-1">
                    @for($i = 0; $i < $firstDayOfMonth; $i++)
                        <div></div>
                    @endfor
                    @foreach($monthCalendar as $day => $dayData)
                        @php
                            $dayOfWeekIndex = Carbon::create($selectedYear, $month, $day)->dayOfWeek;
                            $dayColorClass = '';
                            if ($dayOfWeekIndex == 0) {
                                $dayColorClass = 'text-red-500'; // Sunday
                            } elseif ($dayOfWeekIndex == 6) {
                                $dayColorClass = 'text-blue-500'; // Saturday
                            }
                        @endphp
                        <div class="text-center p-1 @if($dayData['isHoliday']) bg-red-100 @endif {{ $dayColorClass }}">
                            {{ $day }}
                            @if($dayData['isHoliday'])
                                <div class="flex justify-center">
                                    @if($dayData['holiday'])
                                        <div>
                                            <form method="POST" action="{{ route('admin.calendar.deleteHoliday', ['holidayId' => $dayData['holiday']->id ?? null, 'officeId' => $dayData['holiday']->office_id ?? 0, 'corpId' => $selectedCorpId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('この休日を削除してもよろしいですか?')">消去</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div>
                                    <form method="POST" action="{{ route('admin.calendar.addHoliday') }}">
                                        @csrf
                                        <input type="hidden" name="date" id="addHolidayDate" value="{{ $dayData['date']->format('Y-m-d') }}">
                                        <input type="hidden" name="office_id" id="addHolidayOfficeId" value="{{ $dayData['holiday']->office_id ?? '' }}">
                                        <input type="hidden" name="corp_id" id="addHolidayCorpId" value="{{ $selectedCorpId }}">
                                        <button type="submit" class='text-blue-500'>追加</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
