
<!--REAL-->


@extends('admin.dashboard')

@section('admin')
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


    <div class="bg-gray-100 shadow-sm min-h-screen">
        <div class="container mx-auto px-4">

            @if (session('success'))
            <div id="successToast" class="fixed top-20 left-0 w-full bg-red-100 border-b border-gray-500 rounded-b px-4 py-3 shadow-md">
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
                  過去実例管理

                </h1>


                <h1 class="text-2xl font-bold mb-4 text-left py-4 px-2">過去実例一覧</h1>

                <div class="flex flex-wrap gap-2 mb-4 px-2">
                    <x-button purpose="search" href="{{ url('/admin/past-examples/create') }}">
                        新規登録
                    </x-button>



                </div>


            <div class="w-full max-w-md mt-10 px-3 mb-5">
                <form action="{{ route('admin.past-examples.index') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="search"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="キーワードで検索..."
                        class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out shadow-sm hover:border-blue-400"
                    >
                    <button
                        type="submit"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-sm font-medium text-white bg-sky-600 rounded-r-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition duration-300 ease-in-out"
                    >
                        検索
                    </button>
                </form>
            </div>



            </div>




                    <div class="table-responsive mt-10">
                        <table class="border-collapse border border-slate-400 min-w-full bg-white mt-5">
                            <thead class="bg-gray-200 text-black">
                                <tr>
                                    <th class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm">
                                        番号
                                    </th>
                                    <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm ">
                                        実例タイトル
                                    </th>

                                    <th
                                        class="border border-slate-300 text-left py-3 px-4 uppercase font-semibold text-sm ">
                                        動作
                                    </th>


                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pastExamples as $index=>$record)
                                    <tr class="border-b border-gray-200 hover:bg-blue-50">
                                        <td class="border border-slate-300 px-4 py-2">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="border border-slate-300 px-4 py-2 ">
                                            {{ $record->title }}</td>




                                            <td class="border border-slate-300 px-4 py-2">
                                                <div class="action-buttons flex items-center space-x-2">
                                                    <a href="{{route('admin.past-examples.show',$record->id)}}" class="p-2 hover:bg-yellow-200 inline-flex items-center justify-center">


                                                            <img src="{{ asset('eye.svg') }}" alt="View PDFs" class="w-10 h-10">
                                                    </a>
                                                    <a href="{{route('admin.past-examples.edit',$record->id)}}" class="p-2 hover:bg-yellow-200 inline-flex items-center justify-center">
                                                        <img src="{{ asset('2.svg') }}" alt="編集" class="w-10 h-10">
                                                    </a>

                                                    <form action="{{ route('admin.past-examples.destroy', $record) }}" method="POST" class="inline-flex">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 hover:bg-red-200 inline-flex items-center justify-center"
                                                                onclick="return confirm('本当に消去しますか？')">
                                                            <img src="{{ asset('1.svg') }}" alt="消去" class="w-10 h-10">
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $pastExamples->appends(request()->query())->links() }}

                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection

