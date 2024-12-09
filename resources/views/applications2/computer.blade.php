<x-app-layout>

    @php

    $statusTranslations=[
        'pending'=>'申請中',
        'approved'=>'承認済み',
        'denied' => '拒否済み'
    ];
    @endphp




@if (session('success') || session('error'))
<div id="statusToast" class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md">
    <div class="bg-white border-l-4 @if(session('success')) border-blue-500 @else border-red-500 @endif rounded-r-lg shadow-md overflow-hidden">
        <div class="p-4 flex items-center">
            <div class="flex-shrink-0">
                @if (session('success'))
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            <div class="ml-3 w-0 flex-1">
                @if (session('success'))
                    <p class="text-lg font-semibold text-blue-900">
                        {!! session('success') !!}
                    </p>
                @endif
                @if (session('error'))
                    <p class="text-sm font-medium text-gray-900">
                        {{ session('error') }}
                    </p>
                @endif


            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button id="closeToast" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                閉じる
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown {
        from { transform: translate(-50%, -100%); }
        to { transform: translate(-50%, 0); }
    }
    #statusToast {
        animation: slideDown 0.5s ease-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var statusToast = document.getElementById('statusToast');
        var closeToast = document.getElementById('closeToast');

        var hideTimeout = setTimeout(function() {
            hideToast();
        }, 8000);

        closeToast.addEventListener('click', function() {
            clearTimeout(hideTimeout);
            hideToast();
        });

        function hideToast() {
            statusToast.style.transform = 'translate(-50%, -100%)';
            statusToast.style.transition = 'transform 0.5s ease-in-out';
            setTimeout(function() {
                statusToast.style.display = 'none';
            }, 500);
        }
    });
</script>
@endif

<style>
    @media (max-width: 767px) {

        .hide-on-mobile {
            display: none;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            width: 100%;
            min-width: auto;
        }

        th,
        td {
            font-size: 10px;
            padding: 4px;
        }

        .show-on-mobile {
            display: table-cell;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
        }

        .action-buttons x-button {
            padding: 8px;
        }

        .action-buttons img {
            width: 20px;
            height: 20px;
        }

        .action-buttons a {
            flex: 1 0 calc(50% -4px);
            margin-bottom: 12px;
            width: 100%;
            font-size: 12px;
            padding: 8px 4px;
            white-space: nowrap;
        }
    }
</style>


<div class="min-h-screen bg-gray-100">
    <div class="bg-white container mx-auto mt-5 rounded-xl">


    <div class="container mx-auto ">
        {{-- Page Header --}}
        <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-t-xl shadow-lg mb-8">
            <div class="p-6 text-center md:text-left">
                <h1 class="text-4xl font-extrabold text-white mb-2">パソコン問い合わせ管理</h1>
                <p class="text-sky-100 text-lg">パソコン問い合わせ一覧</p>
            </div>
        </div>

        {{-- Actions and Search --}}

            <div>
                <form action="" method="GET" class="px-2 w-full md:w-1/2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="キーワードで検索..."
                            class="w-full pl-10 pr-24 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-300 ease-in-out"
                        >
                        <button
                            type="submit"
                            class="absolute top-0 right-0 h-full px-4 bg-sky-600 text-white rounded-r-lg hover:bg-sky-700 transition duration-300"
                        >
                            検索
                        </button>
                    </div>
                </form>

            </div>








        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mt-5 px-2">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-sky-50 border-b">
                    <tr>

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">番号</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">社員番号</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">社員名</th>

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">問い合わせ日付け</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">注文内容</th>

                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">動作</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">確認した人</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">コメント</th>
                            <th class="border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">aaa</th>
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
                                    class="text-sky-600 hover:text-sky-800 transition duration-300 ease-in-out transform hover:scale-110">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                     </svg>
                                 </a>
{{--
                                <a href="{{ route('applications2.show', $record) }}"
                                    class="text-blue-500 hover:underline">View</a> --}}


                            </td>







                            <td class="border border-slate-300 px-4 py-3">
                                <div class="mb-4">
                                    <select name="checker_id" id="checker_id_{{ $record->id }}" class="form-select">
                                        <option value="">選択</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $record->checked_by == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="checkbox_{{ $record->id }}" name="is_active" value="1"
                                        {{ $record->is_checked ? 'checked' : '' }} class="form-checkbox h-4 w-4">




                                    <button type="button" id="confirm_button_{{ $record->id }}"
                                        data-record-id="{{ $record->id }}"
                                        class="confirm-button bg-green-400 hover:bg-green-500 text-white font-semibold py-1 px-3 rounded">
                                        確認ボタン
                                    </button>
                                </div>
                            </td>


                         <td class="border border-slate-300 px-4 py-3">
                            <span id="checked_by_{{ $record->id }}">
                                {{ $record->checked_by ? \App\Models\User::find($record->checked_by)->name : '確認されていません。' }}
                            </span>
                            <br>
                            <small>
                                <span id="checked_date_{{ $record->id }}"
                                    class="{{ $record->checked_at ? 'text-blue-600 font-medium' : 'text-red-600 font-semiboldr' }}">
                                    {{ $record->checked_at ? $record->checked_at->format('Y-m-d H:i') : '確認されていません。' }}
                                </span>

                            </small>
                        </td>


                        <td class="border border-slate-300 px-4 py-3 whitespace-nowrap hidden md:table-cell">
                            <textarea
                                id="comment_{{ $record->id }}"
                                name="comment"
                                class="comment-textarea form-textarea w-full"
                                data-record-id="{{ $record->id }}"
                            >{{ $record->comment }}</textarea>

                           <br> <button
                                type="button"
                                class="save-comment-btn bg-blue-500 text-white px-4 py-2 rounded"
                                data-record-id="{{ $record->id }}"
                            >保存
                        </button>

                        </td>




                        <td class="border border-slate-300 px-4 py-3 whitespace-nowrap hidden md:table-cell">
                            <a href="{{ route('past-examples.create', $record) }}" class="bg-sky-500 hover:bg-sky-600 px-2 py-2 text-white rounded-xl">事例作成</a>
                        </td>

                        @endforeach








                        </tr>

                    </tbody>

                </table>
                <div class="mt-4">
                    {{ $application2->links() }}
                </div>
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
    const saveButtons = document.querySelectorAll('.save-comment-btn');

    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const recordId = this.dataset.recordId;
            const textarea = document.getElementById(`comment_${recordId}`);
            const commentText = textarea.value.trim();

            // Send AJAX request
            fetch(`/applications2/${recordId}/update-comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    comment: commentText
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Optionally disable textarea or show success message
                    textarea.classList.add('bg-green-100');
                    setTimeout(() => {
                        textarea.classList.remove('bg-green-100');
                    }, 2000);

                    // Show a toast or alert
                    alert('コメントが正常に保存されました。');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('コメントの保存中にエラーが発生しました。');
            });
        });
    });
});
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
