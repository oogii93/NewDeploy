@extends('admin.dashboard')

@section('admin')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <style>
        @media (max-width: 767px) {

            .hide-on-mobile {
                display: none;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                max-width: 100%;
                margin-bottom:1rem;
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
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .action-buttons x-button {
                padding: 8px;
            }

            .action-buttons img {
                width: 20px;
                height: 20px;
            }

             .action-buttons a {


                flex: 0 0 calc(50% - 8px);
                margin-bottom: 8px;
            }

        }
    </style>

    @if (session('success'))
        <!-- Success toast code (unchanged) -->
    @endif

<div class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow overflow-hidden">
        <div class="container mx-auto px-4 py-8">

            <div class="shadow overflow-hidden rounded border-b border-gray-200 bg-white mt-10 p-4 sm:p-6 lg:p-8">



                <h1 class="px-2 py-2 text-xl font-medium mb-6 mt-5">
                    社員管理

                </h1>


                <h1 class="text-2xl font-bold mb-4 text-left py-4 px-2">社員一覧</h1>

                <div class="flex flex-wrap gap-2 mb-4 px-2">
                    <x-button purpose="search" href="{{ url('/admin/role-permission/users/create') }}">
                        新規登録
                    </x-button>
                    <x-button purpose="default" href="{{ route('admin.role-permission.user.restore.index') }}">
                        復元
                    </x-button>


                </div>

                <div class="w-full overflow-x-auto px-2">
                    <form action="{{ route('admin.role-permission.user.index') }}" method="GET" class="mb-4">
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

            <div>



                        <div class="flex justify-center mt-10 mb-10">
                            <div class="table-responsive">
                                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden border border-slate-400">
                                    <thead class="bg-blue-200 text-gray-700">
                                    <tr>
                                        <th class="min-w-[90px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            社員番号
                                        </th>
                                        <th class="min-w-[90px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            会社
                                        </th>
                                        <th class="min-w-[90px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            営業所
                                        </th>
                                        <th class="min-w-[90px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            課
                                        </th>
                                        <th class="min-w-[150px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            氏名
                                        </th>
                                        <th class="min-w-[120px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            フリガナ
                                        </th>
                                        <th class="min-w-[70px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            性別
                                        </th>
                                        <th class="min-w-[120px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            生年月日
                                        </th>
                                        <th class="min-w-[100px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            郵便番号
                                        </th>
                                        <th class="min-w-[300px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            住所
                                        </th>
                                        <th class="min-w-[200px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            メール
                                        </th>
                                        <th class="min-w-[80px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm hide-on-mobile">
                                            権限
                                        </th>
                                        <th class="min-w-[80px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            データ
                                        </th>
                                        <th class="min-w-[80px] border border-slate-400 text-left py-3 px-4 uppercase font-semibold text-sm">
                                            作動
                                        </th>
                                    </tr>
                                </thead>

                                        <tbody class="text-gray-700 text-sm">
                                            @foreach ($users as $user)
                                                <tr class="hover:bg-stone-100 border-b">
                                                    <td class="border border-slate-300 px-4 py-3">
                                                        {{ $user->employer_id }}</td>
                                                    <td class="border border-slate-300 px-4 py-3">
                                                        {{ $user->office && $user->office->corp ? $user->office->corp->corp_name : '' }}
                                                    </td>
                                                    <td class="border border-slate-300 px-4 py-3">
                                                        {{ $user->office ? $user->office->office_name : '' }}
                                                    </td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">
                                                        {{ $user->division ? $user->division->name : '' }}
                                                    </td>
                                                    <td class="border border-slate-300 px-4 py-3">{{ $user->name }}</td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">{{ $user->furigana }}</td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">{{ $user->gender }}</td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">{{ $user->birthdate }}</td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">{{ $user->post_number }}</td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">{{ $user->address }}</td>

                                                    <td class="border border-slate-300 px-4 py-3 ">{{ $user->email }}
                                                    </td>
                                                    <td class="border border-slate-300 px-4 py-3 hide-on-mobile">
                                                        @if (!empty($user->getRoleNames()))
                                                            @foreach ($user->getRoleNames() as $rolename)
                                                                <span
                                                                    class="bg-gray-200 rounded-full px-2 py-1 text-xs font-bold text-gray-700 mr-2">{{ $rolename }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>

                                                    {{-- <td class="border border-slate-300 px-4 py-3">
                                                        <a href="{{ route('admin.user-details.show-update', $user->id) }}"
                                                            class="p-2 hover:bg-stone-300 inline-block">
                                                            <img src="{{ asset('4.svg') }}" alt="所属" class="w-10 h-10">
                                                        </a>


                                                        <a href="{{ route('admin.user-details.bank-show-update',$user->id) }}" class="p-2 hover:bg-stone-300 inline-block">
                                                            <img src="{{ asset('4.svg') }}" alt="所属" class="w-10 h-10">
                                                        </a>

                                                        <a href="{{ route('admin.user-details.family-index',$user->id) }}" class="p-2 hover:bg-stone-300 inline-block">
                                                            <img src="{{ asset('4.svg') }}" alt="所属" class="w-10 h-10">
                                                        </a>


                                                    </td> --}}
                                                    <td class="border border-slate-300 px-4 py-3">
                                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                                            <button type="button" @click="open = !open" @click.away="open = false" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown menu -->
                                                            <div
                                                            x-show="open"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="transform opacity-0 scale-95"
                                                            x-transition:enter-end="transform opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-75"
                                                            x-transition:leave-start="transform opacity-100 scale-100"
                                                            x-transition:leave-end="transform opacity-0 scale-95"
                                                            :class="{'mt-2': $el.getBoundingClientRect().bottom + 200 < window.innerHeight, 'bottom-0 mb-2': $el.getBoundingClientRect().bottom + 200 > window.innerHeight}"
                                                            class="absolute right-0 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20"
                                                        >
                                                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                                    <a href="{{ route('admin.user-details.show-update', $user->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-900" role="menuitem">
                                                                        <img src="{{ asset('4.svg') }}" alt="Assign Corp" class="inline w-5 h-5 mr-2">社員データ
                                                                    </a>
                                                                    <a href="{{ route('admin.user-details.bank-show-update',$user->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-900" role="menuitem">
                                                                        <img src="{{ asset('44.svg') }}" alt="Assign Office" class="inline w-5 h-5 mr-2">振り込みデータ
                                                                    </a>
                                                                    <a href="{{ route('admin.user-details.family-index',$user->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-100 hover:text-yellow-900" role="menuitem">
                                                                        <img src="{{ asset('55.svg') }}" alt="Edit" class="inline w-5 h-5 mr-2"> 家族データ
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>


                                                    <td class="border border-slate-300 px-4 py-3">
                                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                                            <button type="button" @click="open = !open" @click.away="open = false" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                                </svg>
                                                            </button>

                                                            <!-- Dropdown menu -->
                                                            <div
                                                            x-show="open"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="transform opacity-0 scale-95"
                                                            x-transition:enter-end="transform opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-75"
                                                            x-transition:leave-start="transform opacity-100 scale-100"
                                                            x-transition:leave-end="transform opacity-0 scale-95"
                                                            :class="{'mt-2': $el.getBoundingClientRect().bottom + 200 < window.innerHeight, 'bottom-0 mb-2': $el.getBoundingClientRect().bottom + 200 > window.innerHeight}"
                                                            class="absolute right-0 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20"
                                                        >
                                                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                                    <a href="{{ route('admin.assign-corporation', $user->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 hover:text-blue-900" role="menuitem">
                                                                        <img src="{{ asset('com.svg') }}" alt="Assign Corp" class="inline w-5 h-5 mr-2">会社与え
                                                                    </a>
                                                                    <a href="{{ route('admin.assign-office', $user->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-900" role="menuitem">
                                                                        <img src="{{ asset('office.svg') }}" alt="Assign Office" class="inline w-5 h-5 mr-2">所属与え
                                                                    </a>
                                                                    <a href="{{ url('/admin/role-permission/users/' . $user->id . '/edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-100 hover:text-yellow-900" role="menuitem">
                                                                        <img src="{{ asset('2.svg') }}" alt="Edit" class="inline w-5 h-5 mr-2"> 編集
                                                                    </a>
                                                                    <a href="#" @click.prevent="if (confirm('Are you sure?')) window.location.href='{{ url('/admin/role-permission/users/' . $user->id . '/delete') }}'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-900" role="menuitem">
                                                                        <img src="{{ asset('1.svg') }}" alt="Delete" class="inline w-5 h-5 mr-2"> 消去
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>



                                                    {{-- <td class="border border-slate-300 px-4 py-3">
                                                        <div class="action-buttons">
                                                            <a href="{{ route('admin.assign-corporation', $user->id) }}"
                                                                class="p-2 hover:bg-blue-400 inline-block">
                                                                <img src="{{ asset('com.svg') }}" alt="所属" class="w-10 h-10">
                                                            </a>

                                                            <a href="{{ route('admin.assign-office', $user->id) }}"
                                                                class="p-2 hover:bg-green-200 inline-block">
                                                                <img src="{{ asset('office.svg') }}" alt="所属" class="w-10 h-10">
                                                            </a>
                                                            <a href="{{ url('/admin/role-permission/users/' . $user->id . '/edit') }}"
                                                                class="p-2 hover:bg-yellow-200 inline-block">
                                                                <img src="{{ asset('2.svg') }}" alt="編集" class="w-10 h-10">
                                                            </a>
                                                            <a href="{{ url('/admin/role-permission/users/' . $user->id . '/delete') }}"
                                                                onclick="return confirm('本当に消去しますか？')"
                                                                class="p-2 hover:bg-red-200 inline-block">
                                                                <img src="{{ asset('1.svg') }}" alt="消去" class="w-10 h-10">
                                                            </a>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $users->appends(['search' => $search])->links() }}
                                </div>
                            </div>
                        </div>
        </div>
</div>






@endsection
