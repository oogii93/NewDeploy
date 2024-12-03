<x-app-layout>


    <style>
        .calendar-cell {
            width: 14.28%; /* 100% / 7 days */
            height: 200px; /* Adjust this value as needed */
            max-height: 120px;
            overflow: hidden;
            position: relative;
        }
        .cell-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow-y: auto;
        }
        .holiday-indicator {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>


    @php
        // Define an array of possible classes
        $classes = ['bg-blue-200', 'bg-green-200', 'bg-yellow-200', 'bg-red-200', 'bg-purple-200','bg-gray-200','bg-pink-200','bg-emerald-200','bg-stone-400'];
    @endphp


    <div class="container mx-auto px-2">

        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mb-3 mt-8">
            <h2 class="text-xl font-semibold text-center my-2">
               予定表
            </h2>
            <h1 class="text-2xl font-bold text-center my-3">
                {{ Carbon\Carbon::parse($selectedDate)->translatedFormat('Y年 F') }}
            </h1>

            <form id="officeForm" action="{{ route('companySchedule.index') }}" method="GET" class="space-y-4 mb-5">
                <div>
                    <select class="w-full px-4 py-2 border rounded-md" name="office_id" onchange="this.form.submit()">
                        <option value="">会社選択</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}"
                                {{ $selectedOfficeId == $office->id ? 'selected' : '' }}>
                                {{ $office->corp->corp_name }} -- {{ $office->office_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($selectedOfficeId)
                    <div class="flex space-x-2">
                        <input type="month" name="date" value="{{ $selectedDate }}"
                            class="flex-grow px-4 py-2 border rounded-md">
                        <x-button purpose="defualt" type="submit" class="px-4 py-2">
                            検索
                        </x-button>

                    </div>
                @endif
            </form>


        </div>



        <div class="w-full overflow-x-auto px-2 sm:px-4">
            @if ($selectedOfficeId)
            <div class="bg-white rounded-lg shadow-lg min-w-[800px] md:min-w-full">

                <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-300 p-2 bg-red-50 text-red-600">日</th>
                                <th class="border-b border-gray-300 p-2 bg-gray-50 text-gray-600">月</th>
                                <th class="border-b border-gray-300 p-2 bg-gray-50 text-gray-600">火</th>
                                <th class="border-b border-gray-300 p-2 bg-gray-50 text-gray-600">水</th>
                                <th class="border-b border-gray-300 p-2 bg-gray-50 text-gray-600">木</th>
                                <th class="border-b border-gray-300 p-2 bg-gray-50 text-gray-600">金</th>
                                <th class="border-b border-gray-300 p-2 bg-blue-50 text-blue-600">土</th>
                            </tr>
                        </thead>
                        {{-- @php
                        dd($holidays);
                    @endphp --}}

                        <tbody class="bg-white">
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
            <td class="border border-gray-400 p-4 text-center calendar-cell
                {{ isset($week[$i]) && $week[$i]->month == Carbon\Carbon::parse($selectedDate)->month ? '' : 'bg-gray-100' }}
                {{ isset($week[$i]) && $week[$i]->isToday() ? 'bg-blue-100 font-bold' : '' }}
                {{ isset($week[$i]) && isset($holidays[$week[$i]->format('Y-m-d')]) ? 'bg-pink-50' : '' }}"
                data-date="{{ isset($week[$i]) ? $week[$i]->format('Y-m-d') : '' }}">

                <div class="cell-content">
                    @if (isset($week[$i]))
                        <div class="font-semibold">{{ $week[$i]->day }}
                            @if ($week[$i]->isToday())
                            <span class="mt-5 text-lg bg-sky-200 rounded-2xl text-sky-800 flex justify-center w-1/2 mx-auto text-center py-3">今日</span>

                        @endif
                        </div>
                        @if ($week[$i]->month == Carbon\Carbon::parse($selectedDate)->month)
                            <div class="text-gray-600 text-xs mt-1">
                                <a href="#" class="text-blue-600 text-4xl font-bold open-modal" data-date="{{ $week[$i]->format('Y-m-d') }}">+</a>
                            </div>
                            <div class="schedules-container mt-2 overflow-y-auto max-h-40">
                                <!-- Schedules will be displayed here -->
                            </div>
                        @endif
                    @endif
                </div>

                @if (isset($week[$i]) && isset($holidays[$week[$i]->format('Y-m-d')]))
                    <div class="holiday-indicator  rounded-2xl text-rose-700 font-semibold text-lg mb-5">
                        公休
                    </div>
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


<!--Create Modal -->



<div id="scheduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-semibold text-gray-900">スケジュールを作成</h3>
            <div class="mt-2 px-7 py-3">
                <form id="scheduleForm">
                    @csrf
                    <input type="hidden" id="scheduleDate" name="date">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">タイトル</label>
                        <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="タイトルを必ず入力してください" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">説明</label>
                        <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline " placeholder="説明を必ず入力してください"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">開始時刻</label>
                        <input type="time" id="start_time" name="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">終了時間</label>
                        <input type="time" id="end_time" name="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4 hidden">
                        <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">User</label>
                        <select id="user_id" name="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="{{ $authUser->id }}">{{ $authUser->name }}</option>
                        </select>
                    </div>


                    <div class="mb-4">
                        <label for="color" class="block text-gray-700 text-sm font-bold mb-2">色</label>
                        <input type="color" id="color" name="color" value="#3490dc" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <input type="hidden" id="office_id" name="office_id" value="{{ $selectedOfficeId }}">



                    <div class="justify-between">

                        <x-button purpose="default" id="closeModal">
                            キャンセル
                    </x-button>


                        <x-button purpose="search" id="saveSchedule">
                          保存
                        </x-button>


                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!--Edit Modal -->

<div id="editScheduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-semibold text-gray-900">スケジュール編集 </h3>
            <div class="mt-2 px-7 py-3">
                <form action="" id="editScheduleForm">

                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editScheduleId" name="id">
                    <div class="mb-4">
                        <label for="editTitle" class="block text-gray-700 text-sm font-bold mb-2">タイトル</label>
                        <input type="text" id="editTitle" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="editDescription" class="block text-gray-700 text-sm font-bold mb-2">説明</label>
                        <textarea id="editDescription" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="editStartTime" class="block text-gray-700 text-sm font-bold mb-2">開始時刻</label>
                        <input type="datetime-local" id="editStartTime" name="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="editEndTime" class="block text-gray-700 text-sm font-bold mb-2">終了時間</label>
                        <input type="datetime-local" id="editEndTime" name="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="editColor" class="block text-gray-700 text-sm font-bold mb-2">色</label>
                        <input type="color" id="editColor" name="color" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">

                        <x-button purpose="default" id="closeEditModal">
                            取消
                        </x-button>
                        <x-button purpose="delete" id="deleteSchedule">
                            削除
                        </x-button>
                        <x-button purpose="search" id="updateSchedule">
                            更新
                        </x-button>
                    </div>

                </form>
            </div>


        </div>

    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('scheduleModal');
        const editModal=document.getElementById('editScheduleModal');
        const openModalLinks = document.querySelectorAll('.open-modal');
        const saveButton = document.getElementById('saveSchedule');
        const closeButton = document.getElementById('closeModal');
        const closeEditModalButton=document.getElementById('closeEditModal');
        const updateScheduleButton=document.getElementById('updateSchedule');
        const deleteScheduleButton=document.getElementById('deleteSchedule');

//
@if($selectedOfficeId)
        fetchSchedules();
@endif

//
    document.getElementById('officeForm').addEventListener('submit', function(e){
        e.preventDefault();
        this.submit();
        fetchSchedules();
    });


        openModalLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const date = this.getAttribute('data-date');
                document.getElementById('scheduleDate').value = date;
                document.getElementById('start_time').value = `${date}T00:00`;
                document.getElementById('end_time').value = `${date}T23:59`;
                modal.classList.remove('hidden');
            });
        });

        closeButton.addEventListener('click', function(e){
            e.preventDefault();
            modal.classList.add('hidden');
            document.getElementById('scheduleForm').reset();
        });

        closeEditModalButton.addEventListener('click', function(e){
            e.preventDefault();
            editModal.classList.add('hidden');
        });



 saveButton.addEventListener('click', function(e) {
    e.preventDefault();
    const form = document.getElementById('scheduleForm');
    const formData = new FormData(form);

    // Format date and time fields
    const startDate = formData.get('date');
    const startTime = formData.get('start_time');
    const endTime = formData.get('end_time');

    // Combine start time
    formData.set('start_time', `${startDate} ${startTime}:00`);

    // Only combine end time if provided
    if (endTime) {
        formData.set('end_time', `${startDate} ${endTime}:00`);
    } else {
        formData.delete('end_time'); // Ensure it's not sent if empty
    }

    fetch('{{ route("companySchedule.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchSchedules();
            modal.classList.add('hidden');
            form.reset();
        } else {
            alert('Failed to save schedule: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the schedule: ' + (error.message || 'Unknown error'));
    });
});


function openEditModal(scheduleId) {
    fetch(`{{ url('/company-schedule') }}/${scheduleId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched schedule for edit:', data);
            document.getElementById('editScheduleId').value = data.id;
            document.getElementById('editTitle').value = data.title;
            document.getElementById('editDescription').value = data.description;
            document.getElementById('editStartTime').value = data.start_time.slice(0, 16);
            document.getElementById('editEndTime').value = data.end_time ? data.end_time.slice(0, 16) : '';
            document.getElementById('editColor').value = data.color;
            editModal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching schedule for edit:', error);
        });
}

updateScheduleButton.addEventListener('click', function(e) {
    e.preventDefault();
    const form = document.getElementById('editScheduleForm');
    const formData = new FormData(form);
    const scheduleId = formData.get('id');

    fetch(`{{ url('/company-schedule') }}/${scheduleId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'PUT'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            fetchSchedules();
            editModal.classList.add('hidden');
        } else {
            alert('Failed to update schedule: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the schedule');
    });
});

deleteScheduleButton.addEventListener('click', function(e) {
    e.preventDefault();
    if (confirm('Are you sure you want to delete this schedule?')) {
        const scheduleId = document.getElementById('editScheduleId').value;

        fetch(`{{ url('/company-schedule') }}/${scheduleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                fetchSchedules();
                editModal.classList.add('hidden');
            } else {
                alert('Failed to delete schedule: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the schedule');
        });
    }
});


function fetchSchedules() {
    const startDate = '{{ Carbon\Carbon::parse($selectedDate)->startOfMonth()->format("Y-m-d") }}';
    const endDate = '{{ Carbon\Carbon::parse($selectedDate)->endOfMonth()->format("Y-m-d") }}';
    const officeId = '{{ $selectedOfficeId }}';

    if (!officeId) {
            console.log('No office selected, skipping schedule fetch');
            return;
        }

    fetch(`{{ route("companySchedule.getSchedules") }}?office_id={{ $selectedOfficeId }}&start_date=${startDate}&end_date=${endDate}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched schedules:', data);
            displaySchedules(data);
        })
            .catch(error => {
                console.error('Error fetching schedules:', error);
            });
    }

    function displaySchedules(schedules) {
        // Clear existing schedules
        document.querySelectorAll('.schedules-container').forEach(container => {
            container.innerHTML = '';
        });




             // Update the schedules display in each cell
        schedules.forEach(schedule => {
            const date = new Date(schedule.start_time).toISOString().split('T')[0];
            const cell = document.querySelector(`td[data-date="${date}"] .schedules-container`);
            if (cell) {
                const startTime = new Date(schedule.start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                const endTime = schedule.end_time ? new Date(schedule.end_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                const scheduleDiv = document.createElement('div');
                scheduleDiv.className = 'text-xs font-semibold p-1 mb-1 rounded cursor-pointer';
                scheduleDiv.style.backgroundColor = schedule.color;
                scheduleDiv.innerHTML = `
                    ${startTime} ~ ${endTime}<br>
                    <span style="color: stone; font-size:1.25em;">${schedule.user.name}</span><br>
                    ${schedule.title}<br>
                    ${schedule.description}<br>
                `;
                scheduleDiv.addEventListener('click', () => openEditModal(schedule.id));
                cell.appendChild(scheduleDiv);
            }
        });
    }
});
</script>



</x-app-layout>
