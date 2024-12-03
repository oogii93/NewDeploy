<x-app-layout>


    @php
        // Define an array of possible classes
        $classes = ['bg-blue-200', 'bg-green-200', 'bg-yellow-200', 'bg-red-200', 'bg-purple-200','bg-gray-200','bg-pink-200','bg-emerald-200','bg-stone-400'];
    @endphp


    <div class="container mx-auto px-2">

        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mb-3 mt-8">
            <h1 class="text-2xl font-bold text-center my-6">
                {{ Carbon\Carbon::parse($selectedDate)->translatedFormat('Y年 F') }}
            </h1>

            <form action="{{ route('room.index') }}" method="GET" class="space-y-4">
                <div>
                    <select class="w-full px-4 py-2 border rounded-md" name="office_id" onchange="this.form.submit()">
                        <option value="">会社選択</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}"
                                {{ $selectedOfficeId == $office->id ? 'selected' : '' }}>
                                {{ $office->corp->corp_name }} -- {{ $office->office_name }}
                        @endforeach
                    </select>
                </div>

                @if ($selectedOfficeId)
                    <div class="flex space-x-2 mb-5">
                        <input type="month" name="date" value="{{ $selectedDate }}"
                            class="flex-grow px-4 py-2 border rounded-md">
                        <x-button purpose="defualt" type="submit" class="px-4 py-2">
                            検索
                        </x-button>

                    </div>
                @endif
            </form>

            <div class="mt-5">
                <x-button purpose="search" href="{{ route('room.create') }}">
                    新規個室
                </x-button>


            </div>
        </div>

<div class="w-full overflow-x-auto px-2 sm:px-4 bg-white mt-5">
    @if ($selectedOfficeId)
    <div class="bg-white rounded-lg shadow-lg min-w-[800px] md:min-w-full">

            <table class="w-full border border-collapse">
                <thead>
                    <tr>
                        <th class="border border-red-400  p-2 bg-red-100">日</th>
                        <th class="border border-gray-400 p-2 bg-gray-100">月</th>
                        <th class="border border-gray-400 p-2 bg-gray-100">火</th>
                        <th class="border border-gray-400 p-2 bg-gray-100">水</th>
                        <th class="border border-gray-400 p-2 bg-gray-100">木</th>
                        <th class="border border-gray-400 p-2 bg-gray-100">金</th>
                        <th class="border border-blue-400 p-2 bg-blue-100">土</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $date = Carbon\Carbon::parse($selectedDate)->startOfMonth();
                        $endOfMonth = $date->copy()->endOfMonth();
                        $calendar = [];
                        $week = 0;

                        // Fill in empty days before the start of the month
                        while ($date->dayOfWeek != 0) {
                            $date->subDay();
                            $calendar[$week][$date->dayOfWeek] = $date->copy();
                        }
                        $date->addDay();

                        // Fill in the days of the month
                        while ($date <= $endOfMonth) {
                            $calendar[$week][$date->dayOfWeek] = $date->copy();
                            if ($date->dayOfWeek == 6) {
                                $week++;
                            }
                            $date->addDay();
                        }

                        // Fill in empty days after the end of the month
                        while ($date->dayOfWeek != 0) {
                            $calendar[$week][$date->dayOfWeek] = $date->copy();
                            $date->addDay();
                        }
                    @endphp


                    @foreach ($calendar as $week)
                        <tr>
                            @for ($i = 0; $i < 7; $i++)
                                <td
                                    class="border border-gray-600 p-2 w-36 h-36 min-h[9rem] align-top overflow-hidden {{ isset($week[$i]) && $week[$i]->month == Carbon\Carbon::parse($selectedDate)->month ? '' : 'bg-gray-200' }}">
                                    @if (isset($week[$i]))
                                        <div class="font-semibold">{{ $week[$i]->day }}</div>
                                        @if ($week[$i]->month == Carbon\Carbon::parse($selectedDate)->month)
                                            <div class="text-yellow-500 text-sm mt-1">
                                                <a href="{{ route('room.schedule', ['officeId' => $selectedOfficeId, 'date' => $week[$i]->toDateString()]) }}"
                                                    class="text-yellow-500 text-sm mt-1">個室指定する</a>
                                            </div>
                                            <div class="reservations-container">
                                                @foreach ($reservations->where('start_time', '>=', $week[$i]->startOfDay())->where('start_time', '<', $week[$i]->addDay()->startOfDay()) as $reservation)
                                                    @php
                                                        // Select a random class from the array
                                                        $randomClass = $classes[array_rand($classes)];
                                                    @endphp



                                                    <div class="reservation-item text-xs mt-1">
                                                        <small class="text-gray-600">
                                                            {{ $reservation->user->name }}-{{ $reservation->room->name }}</small>

                                                        <p class="{{ $randomClass }}">
                                                            {{ $reservation->start_time->format('H:i') }} -
                                                            {{ $reservation->end_time->format('H:i') }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
</div>
    </div>
</div>



</x-app-layout>
