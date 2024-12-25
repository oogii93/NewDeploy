<x-app-layout>

    @php

    $statusTranslations=[
        'pending'=>'申請中',
        'approved'=>'承認済み',
        'denied' => '拒否済み'
    ];
    @endphp

    <div class="bg-gray-100 shadow-sm min-h-screen">
        <div class="container mx-auto px-4">


            @if (session('success'))
            <div id="successToast" class="fixed top-20 left-0 w-full bg-gray-100 border-b border-gray-500 rounded-b px-4 py-3 shadow-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 12a1 1 0 112 0v1a1 1 0 11-2 0v-1zm1-8a7 7 0 110 14 7 7 0 010-14z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-gray-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var successToast = document.getElementById('successToast');
                    if (successToast) {
                        setTimeout(function() {
                            successToast.classList.add('hidden');
                        }, 3000); // Disappear after 3 seconds
                    }
                });
            </script>

            @endif

        <div class="shadow overflow-hidden rounded border-b border-gray-200 bg-white mt-10">

            <h1 class="px-2 py-2 text-xl font-medium mb-6 mt-5">
                勤怠届人事課管理

            </h1>

            <h1 class="text-2xl font-bold mb-4 text-left py-4 px-2">勤怠届一覧</h1>

            <div class="w-full overflow-x-auto px-2">

                <form action="{{ route('Kintaihr') }}" method="GET" class="mb-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="text" name="search" value="{{ request()->input('search') }}"
                            class="border border-gray-300 rounded px-3 py-2 flex-grow" placeholder="社員検索">

                        <x-button type="submit" purpose="default">
                            検索
                        </x-button>

                    </div>
                </form>
            </div>



        </div>

        <div class="table-responsive mt-10 mb-10">
            <table class="min-w-full table-auto bg-white shadow-lg rounded-lg overflow-hidden border border-slate-400">
                <thead class="bg-blue-200 text-gray-700">
                    <tr>

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">会社名</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">営業所名</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">送信人</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">勤怠区分</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">日付</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">理由１</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">理由２</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">送信日付け</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">状態</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">上司</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">動作</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">確認した人</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">確認した日付け</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-sm">
                        @foreach ($records as $record)
                        {{-- {{ dd($record->user->office->office_name) }} --}}
                        <tr class="hover:bg-stone-100 border-b">

                            <td class="border border-slate-300 px-4 py-3">{{ $record->user->office->corp->corp_name ?? 'N/A' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->user->office->office_name ?? 'N/A' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->user ? $record->user->name : '' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->attendanceTypeRecord ? $record->attendanceTypeRecord->name : '' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->date }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->reason_select }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->reason }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->created_at }}</td>

                            <td class="border border-slate-300 px-4 py-3">
                                @if ($record->status == 'approved')
                                    <div class="flex items-center">
                                        <span>{{ $statusTranslations[$record->status] }}</span>
                                        <img src="{{ asset('images/approved.png') }}" alt="Approved" class="ml-2 w-5 h-5">
                                    </div>
                                @elseif($record->status == 'denied')
                                    <div class="flex items-center">
                                        <span>{{$statusTranslations[$record->status] }}</span>
                                        <img src="{{ asset('images/denied.png') }}" alt="Denied" class="ml-2 w-5 h-5">
                                    </div>
                                @else
                                    <span>{{ $statusTranslations[$record->status] }}</span>
                                @endif
                            </td>

                            <td class="border border-slate-300 px-4 py-3">
                                {{ $record->boss ? $record->boss->name : 'No boss assigned' }}
                            </td>



                            <td class="border border-slate-300 px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="checkbox_{{ $record->id }}" name="is_active" value="1"
                                        {{ $record->is_checked ? 'checked disabled' : '' }} class="form-checkbox h-4 w-4">

                              <button type="button" id="button_{{ $record->id }}"
                                        class="bg-green-400 hover:bg-green-500 text-white font-semibold py-1 px-3 rounded
                                            {{ $record->is_checked ? 'bg-gray-400 cursor-not-allowed' : '' }}"
                                        {{ $record->is_checked ? 'disabled' : '' }}>
                                        {{ $record->is_checked ? '確認済み' : '確認ボタン' }}
                                    </button>


                                </div>
                            </td>

                         <td class="border border-slate-300 px-4 py-3">
                            <span id="checked_by_{{ $record->id }}">
                                {{ $record->checked_by ? \App\Models\User::find($record->checked_by)->name : 'Not checked' }}
                            </span>
                        </td>

                        <td class="border border-slate-300 px-4 py-3 whitespace-nowrap hidden md:table-cell">
                            <span id="checked_date_{{ $record->id }}">
                                {{ $record->checked_at ? $record->checked_at->format('Y-m-d H:i') : 'Not checked' }}
                            </span>
                        </td>


                        </tr>
                    @endforeach
                    </tbody>
                    <div class="mt-4">
                        {{ $records->appends(request()->query())->links() }}
                    </div>
                </table>
            </div>
        </div>

        </div>
    </div>



    <script>
    document.addEventListener('DOMContentLoaded', function() {
    function checkApplication(id) {
        const checkbox = document.getElementById(`checkbox_${id}`);
        const button = document.getElementById(`button_${id}`);
        const isChecked = checkbox.checked;

        if (!isChecked) {
            alert('Please check the checkbox before confirming.');
            return;
        }

        fetch(`/records/${id}/check`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_checked: isChecked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`checked_by_${id}`).textContent = data.checked_by;
                document.getElementById(`checked_date_${id}`).textContent = data.checked_at;

                // Disable the button and change its appearance
                button.disabled = true;
                button.classList.remove('bg-green-500', 'hover:bg-green-700');
                button.classList.add('bg-gray-400', 'cursor-not-allowed');
                button.textContent = '確認済み';

                // Disable the checkbox
                checkbox.disabled = true;


                checkNotificationCount();

            } else {
                alert('Failed to update the record. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    function checkNotificationCount(){
        fetch('/check-unckecked-notifications')
            .then(response =>response.json())
            .then(data =>{
                const notificationDot=document.querySelector('[href="{{ route("Kintaihr") }}"] span');
                if(notificationDot){
                    if(data.uncheckedCount === 0){
                        notificationDot.style.display='none';
                    }
                }
            })
            .catch(error=> console.error('Error:', error));
    }

    // Attach the checkApplication function to all buttons
    document.querySelectorAll('[id^="button_"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.id.split('_')[1];
            checkApplication(id);
        });
    });
});
    </script>



</x-app-layout>
