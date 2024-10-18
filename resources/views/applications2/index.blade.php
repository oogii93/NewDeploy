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
                社内注文管理

            </h1>

            <h1 class="text-2xl font-bold mb-4 text-left py-4 px-2">注文表一覧</h1>

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

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">注文番号</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">社員番号</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">社員名</th>

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">注文日付け</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">注文内容</th>

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">動作</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">確認した人</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">確認した日付け</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-sm">
                        @foreach ($application2 as $record)
                        {{-- {{ dd($record->user->office->office_name) }} --}}
                         <tr class="hover:bg-stone-100 border-b">

                            <td class="border border-slate-300 px-4 py-3">{{ $record->id ?? 'N/A' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->user->employer_id ?? 'N/A' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->user ? $record->user->name : '' }}</td>
                            <td class="border border-slate-300 px-4 py-3">{{ $record->created_at }}</td>

                            <td class="border border-slate-300 px-4 py-2">
                                <a href="{{ route('applications2.show', $record) }}"
                                    class="text-blue-500 hover:underline">View</a>


                            </td>







                            <td class="border border-slate-300 px-4 py-3">
                                <div class="mb-4">
                                    <select name="checker_id" id="checker_id_{{ $record->id }}"
                                            class="form-select"
                                            {{ $record->is_checked ? 'disabled' : '' }}>
                                        <option value="">選択</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $record->checked_by == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <input type="checkbox"
                                           id="checkbox_{{ $record->id }}"
                                           name="is_active"
                                           value="1"
                                           {{ $record->is_checked ? 'checked disabled' : '' }}
                                           class="form-checkbox h-4 w-4">

                                    <button type="button"
                                            id="confirm_button_{{ $record->id }}"
                                            data-record-id="{{ $record->id }}"
                                            class="confirm-button bg-green-400 hover:bg-green-500 text-white font-semibold py-1 px-3 rounded
                                                {{ $record->is_checked ? 'bg-gray-400 cursor-not-allowed' : '' }}"
                                            {{ $record->is_checked ? 'disabled' : '' }}>
                                        {{ $record->is_checked ? '確認済み' : '確認ボタン' }}
                                    </button>
                                </div>
                            </td>

                         <td class="border border-slate-300 px-4 py-3">
                            <span id="checked_by_{{ $record->id }}">
                                {{ $record->checked_by ? \App\Models\User::find($record->checked_by)->name : '確認されていません。' }}
                            </span>
                        </td>
                        <td class="border border-slate-300 px-4 py-3 whitespace-nowrap hidden md:table-cell">
                            <span id="checked_date_{{ $record->id }}"
                                class="{{ $record->checked_at ? 'text-blue-600 font-medium' : 'text-red-600 font-semiboldr' }}">
                                {{ $record->checked_at ? $record->checked_at->format('Y-m-d H:i') : '確認されていません。' }}
                            </span>
                        </td>


                        </tr>
                     @endforeach
                    </tbody>
                    {{-- <div class="mt-4">
                        {{ $records->appends(request()->query())->links() }}
                    </div> --}}
                </table>
            </div>
        </div>

        </div>
    </div>



    {{-- <script>
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
            } else {
                alert('Failed to update the record. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Attach the checkApplication function to all buttons
    document.querySelectorAll('[id^="button_"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.id.split('_')[1];
            checkApplication(id);
        });
    });
});
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all confirm buttons
            const confirmButtons = document.querySelectorAll('.confirm-button');

            confirmButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const recordId = this.dataset.recordId;
                    const checkbox = document.getElementById(`checkbox_${recordId}`);
                    const select = document.getElementById(`checker_id_${recordId}`);

                    if (!checkbox.checked) {
                        alert('確認のためチェックボックスを選択してください。');
                        return;
                    }

                    if (!select.value) {
                        alert('確認者を選択してください。');
                        return;
                    }

                    // Send AJAX request
                    fetch(`/applications2/${recordId}/check`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            checker_id: select.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Disable inputs
                            checkbox.disabled = true;
                            select.disabled = true;
                            this.disabled = true;
                            this.classList.add('bg-gray-400', 'cursor-not-allowed');
                            this.textContent = '確認済み';

                            // Update the display of checked_by and checked_at
                            // Assuming you have elements with these IDs
                            if (document.getElementById(`checked_by_${recordId}`)) {
                                document.getElementById(`checked_by_${recordId}`).textContent = data.checker_name;
                            }
                            if (document.getElementById(`checked_at_${recordId}`)) {
                                document.getElementById(`checked_at_${recordId}`).textContent = data.checked_at;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('エラーが発生しました。');
                    });
                });
            });
        });
        </script>



</x-app-layout>
