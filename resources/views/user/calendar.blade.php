<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-6">{{ $selectedCorp->corp_name }}</h1>

            <!-- Year Selection -->
            <div class="flex justify-center mb-8">
                <form action="{{ route('user.calendar') }}" method="GET" class="flex items-center gap-3">
                    <select name="year" class="block w-32 rounded-lg border-0 py-2.5 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                {{ $i }}年
                            </option>
                        @endfor
                    </select>
                    <button type="submit" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        表示
                    </button>
                </form>
            </div>

            <h2 class="text-xl font-medium text-gray-700 text-center mb-8">{{ $selectedYear }}年のお休みスケジュール</h2>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($calendar as $month => $monthCalendar)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Month Header -->
                        <div class="bg-indigo-50 px-4 py-3">
                            <h3 class="text-lg font-semibold text-indigo-900 text-center">{{ $month }}月</h3>
                        </div>

                        <!-- Calendar Content -->
                        <div class="p-4">
                            <!-- Days of Week -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                @php
                                    $daysOfWeek = ['日', '月', '火', '水', '木', '金', '土'];
                                    $firstDayOfMonth = Carbon\Carbon::create($selectedYear, $month, 1)->dayOfWeek;
                                @endphp
                                @foreach($daysOfWeek as $index => $dayOfWeek)
                                    <div class="text-center text-sm font-semibold {{ $index == 0 ? 'text-red-500' : ($index == 6 ? 'text-blue-500' : 'text-gray-600') }}">
                                        {{ $dayOfWeek }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Calendar Days -->
                             <!-- Calendar Days -->
                            <div class="grid grid-cols-7">
                                @for($i = 0; $i < $firstDayOfMonth; $i++)
                                    <div class="h-7"></div>
                                @endfor

                                @foreach($monthCalendar as $day => $dayData)
                                    @php
                                        $dayOfWeekIndex = Carbon\Carbon::create($selectedYear, $month, $day)->dayOfWeek;
                                        $dayColorClass = $dayOfWeekIndex == 0 ? 'text-red-500' : ($dayOfWeekIndex == 6 ? 'text-blue-500' : 'text-gray-900');
                                    @endphp

                                    <div class="h-7 relative">
                                        <div class="absolute inset-0.5 flex flex-col items-center justify-center text-xs
                                            {{ $dayData['isHoliday'] ? 'bg-green-50' : '' }}
                                            {{ $dayColorClass }}">
                                            <span class="{{ $dayData['isHoliday'] ? 'font-semibold -mb-1' : '' }}">{{ $day }}</span>
                                            @if($dayData['isHoliday'])
                                                <span class="text-[8px] text-green-600">公休</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
