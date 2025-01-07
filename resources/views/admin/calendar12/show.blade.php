@extends('admin.dashboard')

@section('admin')

@php
    use Carbon\Carbon;
@endphp

<div id="notification" class="fixed top-4 right-4 p-4 rounded shadow-lg hidden transition-opacity duration-500 z-50">
</div>

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
                                           <form action="" class="delete-holiday-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="holidayId" value="{{ $dayData['holiday']->id }}">
                                                <input type="hidden" name="officeId" value="{{ $dayData['holiday']->office_id }}">
                                                <input type="hidden" name="corpId" value="{{ $selectedCorpId }}">
                                                <button type="submit" class="text-red-500 hover:text-red-600">消去</button>
                                           </form>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div>
                                    <form class="add-holiday-form">
                                        @csrf
                                        <input type="hidden" name="date" value="{{ $dayData['date']->format('Y-m-d') }}">
                                        <input type="hidden" name="corp_id" value="{{ $selectedCorpId }}">
                                        <button type="submit" class="text-blue-500 hover:text-blue-700">追加</button>
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

<script>
 document.addEventListener('DOMContentLoaded', function() {
    function showNotification(message, isSuccess = true) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `fixed top-4 right-4 p-4 rounded shadow-lg z-50 ${
            isSuccess ? 'bg-green-500' : 'bg-red-500'
        } text-white`;

        notification.classList.remove('hidden');

        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    // Handle Add Holiday
    document.querySelectorAll('.add-holiday-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('admin.calendar.addHoliday') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('休日が正常に追加されました');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'エラーが発生しました', false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('エラーが発生しました', false);
            });
        });
    });

    // Handle Delete Holiday
    document.querySelectorAll('.delete-holiday-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (confirm('この休日を削除してもよろしいですか?')) {
                const formData = new FormData(this);
                const holidayId = formData.get('holidayId');
                const officeId = formData.get('officeId');
                const corpId = formData.get('corpId');

                fetch(`/admin/calendar/delete-holiday/${holidayId}/${officeId}/${corpId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('休日が正常に削除されました');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showNotification(data.message || 'エラーが発生しました', false);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('エラーが発生しました', false);
                });
            }
        });
    });
});
</script>

@endsection
