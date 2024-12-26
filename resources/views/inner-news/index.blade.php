
<!--REAL-->
<x-app-layout>

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
                            <h1 class="text-4xl font-extrabold text-white mb-2">過去実例管理</h1>
                            <p class="text-sky-100 text-lg">効率的な過去実例の管理と検索</p>
                        </div>
                    </div>

                    {{-- Actions and Search --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6  px-2 space-y-4 md:space-y-0">
                        {{-- New Registration Button --}}
                        <div>
                            <x-button
                                purpose="search"
                                href="{{ route('inner-news.create') }}"
                                class="bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>新規登録</span>
                            </x-button>


                            <x-button
                                purpose="search"
                                href="{{ route('inner-news.news-category.index') }}"
                                class="bg-orange-400 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>カテゴリ</span>
                            </x-button>


                        </div>

                        {{-- Search Form --}}
                        <form action="" method="GET" class="w-full md:w-1/2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input
                                    type="search"
                                    name="search"
                                    value=""
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

                    {{-- Table --}}
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-sky-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">番号</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">実例タイトル</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">日付け</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">動作</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($innerNews as $index => $record)
                                        <tr class="hover:bg-sky-50 transition duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $record->title }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $record->created_at }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-4">
                                                    {{-- View Button --}}
                                                    <a href="{{ route('inner-news.show', $record->id) }}"
                                                       class="text-sky-600 hover:text-sky-800 transition duration-300 ease-in-out transform hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>

                                                    {{-- Edit Button --}}
                                                    <a href="{{ route('inner-news.edit', $record->id) }}"
                                                       class="text-yellow-600 hover:text-yellow-800 transition duration-300 ease-in-out transform hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>

                                                    {{-- Delete Button --}}
                                                    <form action="{{ route('inner-news.destroy', $record->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            onclick="return confirm('本当に消去しますか？')"
                                                            class="text-red-600 hover:text-red-800 transition duration-300 ease-in-out transform hover:scale-110"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                                データが見つかりません
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6 flex justify-center">
                        {{-- {{ $pastExamples->appends(request()->query())->links('vendor.pagination.tailwind') }} --}}
                    </div>
                </div>
            </div>
        </x-app-layout>
