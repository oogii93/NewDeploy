<x-app-layout>
    {{-- Flash Messages --}}
    <div class="fixed top-4 left-0 right-0 z-50 flex justify-center">
        @if (session('success'))
            <div id="flash-message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg max-w-xl w-full animate-slideIn">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg max-w-xl w-full animate-slideIn">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Main Container --}}
    <div class="container mx-auto px-4 py-8 md:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">名刺管理</h1>

                <div class="flex flex-col md:flex-row w-full md:w-auto space-y-2 md:space-y-0 md:space-x-2">
                    <x-button purpose="search" href="{{ route('namecards.create') }}" class="w-full md:w-auto">
                        新規登録
                    </x-button>
                </div>
            </div>

            {{-- Search Form --}}
            <form action="" method="GET" class="mb-4">
                <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                        placeholder="商品番号、商品名、種類、メーカーで検索"
                    >
                    <x-button purpose="default" type="submit" class="w-full md:w-auto">
                        検索
                    </x-button>
                </div>
            </form>
        </div>

        {{-- Namecard Table --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-sky-200">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">会社名</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">画像</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">名刺名</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">電話番号</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($namecards as $namecard)
                            <tr>
                                <td class="border border-gray-300 px-4 py-4">
                                    <div class="text-sm text-gray-900">{{ $namecard->company }}</div>
                                </td>


                                <td class="border border-gray-300 px-4 py-4 hidden md:table-cell ">
                                    @if($namecard->image_path)
                                        <img
                                            src="{{ Storage::url($namecard->image_path) }}"
                                            alt="Name Card"
                                            class="w-24 h-20 object-cover rounded-lg "
                                        >
                                    @else
                                        <div class="text-sm text-gray-500">No image</div>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">{{ $namecard->name }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">{{ $namecard->phone }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-4">
                                    <div class="text-sm text-gray-900">{{ $namecard->email }}</div>
                                </td>
                                <td class="border border-gray-300 px-4 py-4">
                                    <div class="flex space-x-2 justify-center">
                                        <a
                                            href="{{ route('namecards.show', $namecard->id) }}"
                                            class="text-yellow-600 hover:text-yellow-900 transition duration-300"
                                            title="編集"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form
                                            action="{{ route('namecards.destroy', $namecard->id) }}"
                                            method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('本当に消去しますか？')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-900 transition duration-300"
                                                title="消去"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{-- {{ $namecards->links('vendor.pagination.tailwind') }} --}}
        </div>
    </div>

    {{-- Flash Message Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.classList.add('animate-fadeOut');
                    setTimeout(() => flashMessage.remove(), 500);
                }, 5000);
            }
        });
    script>
</x-app-layout>
