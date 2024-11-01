<x-app-layout>
    @php
        $currentDate = $startDate->copy();
    @endphp




    @while ($currentDate <= $endDate)
        <!-- Render attendance records for the current date -->
        @php
            $currentDate->addDay();
        @endphp
    @endwhile

    <div class="flex flex-wrap py-10">
        @foreach ($users as $user)
            <div class="p-5">
                @include('calendar-table', [
                    'user' => $user,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'holiday' => $holidays,// Pass holidays to the included template
                    'corpName'=>$corpName,
                    'breakData'=>$breakData,

                ])
            </div>

        @endforeach
    </div>

    <div class="mt-4 mb-4 flex justify-start">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>


</x-app-layout>
